<?php
// booking.php

// 1. INCLUDE DB CONNECTION
include 'db/connection.php';

// --- INITIALIZATION ---
// FIX: We rely on header.php for session_start() and ACL. We handle the 
// form submission FIRST to allow redirection BEFORE HTML output.

// Get event ID from URL (using 'event_id' as fixed previously)
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
$error = '';
$event_data = null;
$user_data = ['name' => 'Guest', 'email' => 'N/A', 'phone' => 'N/A']; // Default values

// -----------------------------------------------------------
// --- 2. HANDLE FORM SUBMISSION & REDIRECTION (MUST BE TOP) ---
// -----------------------------------------------------------

// Fetch event data temporarily if a submission is detected, to validate price/id
if (isset($_POST['book_now']) && $event_id > 0) {

    // FIX: Check if a session is NOT already active before starting it.
    // This resolves the "Ignoring session_start()" Notice.
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $user_id = $_SESSION['user_id'] ?? 0;

    // --- Temporary Event Data Fetch for Validation ---
    $temp_stmt = $conn->prepare("SELECT price FROM events WHERE id = ?");
    if ($temp_stmt) {
        $temp_stmt->bind_param("i", $event_id);
        $temp_stmt->execute();
        $temp_result = $temp_stmt->get_result();
        $temp_event = $temp_result->fetch_assoc();
        $temp_stmt->close();
    }

    if ($user_id <= 0) {
        // Redirection failure (user somehow lost session)
        header("Location: login.php");
        exit();
    }

    if ($temp_event) {
        $tickets = filter_input(INPUT_POST, 'tickets', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 10]]);

        if ($tickets === false) {
            $error = "Invalid number of tickets (must be between 1 and 10).";
        } else {
            $event_price = $temp_event['price'];
            $total_price = $tickets * $event_price;

            $sql = "INSERT INTO bookings (user_id, event_id, tickets, total_price) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("iiid", $user_id, $event_id, $tickets, $total_price);

                if ($stmt->execute()) {
                    $booking_id = $stmt->insert_id;
                    $stmt->close();
                    $conn->close();

                    // SUCCESS REDIRECTION (This is the header call that must be moved up)
                    header("Location: confirm.php?id=$booking_id");
                    exit();
                } else {
                    $error = "Database error during booking insertion: " . $stmt->error;
                }
            } else {
                $error = "Failed to prepare booking insertion statement.";
            }
        }
    } else {
        $error = "Event details could not be verified for booking.";
    }
    // Note: If an error occurred, we fall through to display the error below the header.
}

// -----------------------------------------------------------
// --- 3. DATA FETCH FOR PAGE DISPLAY (Runs AFTER Form Submit) ---
// -----------------------------------------------------------

// Fetch Event Details (for display)
if ($event_id > 0) {
    $stmt_event = $conn->prepare("SELECT id, name, price, date, location FROM events WHERE id = ?");
    if ($stmt_event) {
        $stmt_event->bind_param("i", $event_id);
        $stmt_event->execute();
        $result_event = $stmt_event->get_result();
        if ($result_event->num_rows > 0) {
            $event_data = $result_event->fetch_assoc();
        } else {
            // Only set $error if it wasn't already set by the form submission logic
            if (empty($error)) {
                $error = "Event not found in the database. (ID: $event_id)";
            }
        }
        $stmt_event->close();
    } else {
        if (empty($error)) {
            $error = "Database error: Could not prepare event statement.";
        }
    }
}

// --- NOW INCLUDE HEADER.PHP (HTML output starts & session_start() runs here) ---
include 'includes/header.php';

// --- 4. USER DATA FETCH (After session is active) ---

// User ID is guaranteed to be set by header.php's ACL/session logic
$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id > 0) {
    $stmt_user = $conn->prepare("SELECT name, email, phone FROM users WHERE id = ?");
    if ($stmt_user) {
        $stmt_user->bind_param("i", $user_id);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        $fetched_data = $result_user->fetch_assoc();
        if ($fetched_data) {
            $user_data = $fetched_data; // Overwrite defaults with actual user data
        }
        $stmt_user->close();
    }
}

// Note: Connection is closed after successful form submit inside the top block.
// We close it here if the form wasn't submitted, and it wasn't closed before.
if (isset($conn) && $conn->ping()) {
    $conn->close();
}
?>

<body style="background-color: #0B0B0B; color: #FFFFFF;">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <h1 class="text-white fw-bold mb-4 border-bottom pb-2" style="font-family: 'Montserrat', sans-serif;">
                    <i class="bi bi-ticket-perforated-fill text-green me-2"></i>
                    Confirm Your Booking 🎟️
                </h1>

                <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-x-octagon-fill me-2"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if (!$event_data): ?>
                    <div class="alert alert-warning" role="alert">
                        <p class="mb-0">
                            Please select a valid event from the
                            <a href="events.php" class="alert-link">Events Page</a> to book tickets.
                        </p>
                    </div>
                <?php else: ?>

                    <!-- EVENT SUMMARY -->
                    <div class="card mb-4 border-0 shadow-lg booking-summary-card">
                        <div class="card-body">
                            <h4 class="card-title text-green"><?php echo htmlspecialchars($event_data['name']); ?></h4>

                            <p class="card-text text-white mb-1">
                                <i class="bi bi-calendar3 me-2 text-green"></i>
                                <strong>Date:</strong> <?php echo htmlspecialchars($event_data['date']); ?>
                            </p>

                            <p class="card-text text-white mb-3">
                                <i class="bi bi-geo-alt-fill me-2 text-green"></i>
                                <strong>Location:</strong> <?php echo htmlspecialchars($event_data['location']); ?>
                            </p>

                            <p class="card-text fw-bold fs-4 text-white mt-3">
                                Price per Ticket:
                                <span class="text-green">₹<?php echo number_format($event_data['price'], 0); ?></span>
                            </p>
                        </div>
                    </div>

                    <!-- BOOKING FORM -->
                    <form method="POST" class="p-4 rounded-3 shadow-lg booking-form">
                        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">

                        <h5 class="mt-3 mb-3 text-white border-bottom pb-2">
                            <i class="bi bi-person-fill me-2"></i>Your Details (Read-only)
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control"
                                    value="<?php echo htmlspecialchars($user_data['name'] ?? 'N/A'); ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control"
                                    value="<?php echo htmlspecialchars($user_data['email'] ?? 'N/A'); ?>" readonly>
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3 text-white border-bottom pb-2">
                            <i class="bi bi-ticket-fill me-2"></i>Select Tickets
                        </h5>

                        <div class="mb-4">
                            <label for="tickets" class="form-label">Number of Tickets</label>
                            <input type="number" class="form-control" id="tickets" name="tickets" min="1" max="10" value="1"
                                required oninput="calculateTotal(<?php echo $event_data['price']; ?>)">
                            <small class="form-text text-muted">Max 10 tickets per booking.</small>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded total-summary">
                            <h5 class="mb-0 text-white">Total Amount Due:</h5>
                            <span id="total_price_display" class="fw-bold fs-3 text-green">
                                ₹<?php echo number_format($event_data['price'], 0); ?>
                            </span>
                        </div>

                        <button type="submit" name="book_now" class="btn btn-green w-100 py-2 mt-3">
                            <i class="bi bi-lock-fill me-2"></i> Finalize & Secure Payment
                        </button>

                        <p class="text-center text-muted mt-2 small">
                            By clicking 'Finalize', you agree to our <a href="#" class="text-green">Terms</a>.
                        </p>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <style>
        .text-green {
            color: #A3FF12;
        }

        .booking-summary-card,
        .booking-form {
            background-color: #1A1A1A;
            border: 1px solid #333;
        }

        .total-summary {
            background-color: #0B0B0B;
            border: 2px solid #A3FF12;
        }

        .form-label {
            color: #EAEAEA;
        }

        .form-control {
            background-color: #2A2A2A;
            color: #FFFFFF;
            border: 1px solid #444;
        }

        .form-control:focus {
            border-color: #A3FF12;
            box-shadow: 0 0 5px rgba(163, 255, 18, 0.5);
        }

        .btn-green {
            background-color: #A3FF12;
            color: #0B0B0B;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-green:hover {
            background-color: #C3FF42;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(163, 255, 18, 0.3);
        }

        .alert-link {
            font-weight: bold;
            color: #74f000 !important;
        }
    </style>

    <script>
        function calculateTotal(price) {
            const ticketsInput = document.getElementById('tickets');
            let tickets = parseInt(ticketsInput.value);
            if (isNaN(tickets) || tickets < 1) tickets = 1;
            if (tickets > 10) tickets = 10;
            const total = tickets * price;
            document.getElementById('total_price_display').innerHTML =
                '₹' + total.toLocaleString('en-IN', { minimumFractionDigits: 0 });
        }

        // Run calculation on page load
        document.addEventListener('DOMContentLoaded', () => {
            const initialPriceElement = document.querySelector('.card-text.fw-bold.fs-4.text-white span.text-green');
            if (initialPriceElement) {
                // Extract price from the displayed HTML if event data is present
                const priceText = initialPriceElement.textContent.replace('₹', '').replace(/,/g, '');
                const initialPrice = parseFloat(priceText);
                calculateTotal(initialPrice);
            }
        });
    </script>

</body>

<?php include 'includes/footer.php'; ?>