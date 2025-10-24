<?php
// my_bookings.php

// 1️⃣ START SESSION & DATABASE CONNECTION
session_start();
// Include the database connection file
include 'db/connection.php';

// 2️⃣ AUTH CHECK
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$bookings = [];
$error = "";

// 3️⃣ FETCH BOOKINGS (JOIN EVENTS + BOOKINGS)
// Using prepared statements for security
$sql = "SELECT 
            b.id AS booking_id, 
            b.tickets, 
            b.total_price, 
            b.booking_date,
            e.name AS event_name, 
            e.date AS event_date, 
            e.location AS event_location
        FROM bookings b
        INNER JOIN events e ON b.event_id = e.id
        WHERE b.user_id = ?
        ORDER BY e.date DESC, b.booking_date DESC"; // Order by event date (newest first)

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bookings = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    $stmt->close();
} else {
    // Log the actual error for debugging, but show a generic message to the user
    error_log("MySQL Prepare Error: " . $conn->error);
    $error = "A database error occurred. Please try again later.";
}

$conn->close();

// Include the header (assumed to contain necessary Bootstrap links)
include 'includes/header.php';
?>

<style>
    /* Global Dark Theme */
    body {
        background-color: #0B0B0B;
        color: #F5F5F5;
        /* Primary text color */
        font-family: 'Poppins', sans-serif;
    }

    /* Custom Brand Color */
    .text-green {
        color: #A3FF12;
    }

    .bg-success {
        background-color: #A3FF12 !important;
        color: #0B0B0B !important;
    }

    /* Active badge */
    .bg-danger {
        background-color: #FF4757 !important;
    }

    /* Expired badge */
    .border-secondary {
        border-color: #333 !important;
    }

    /* --- Card Styles --- */
    .card-dark {
        background-color: #1A1A1A;
        border: 1px solid #333;
        color: #F5F5F5;
        border-radius: 12px;
        transition: all 0.3s;
    }

    .card-dark:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(163, 255, 18, 0.15);
        /* Slightly stronger shadow on hover */
    }

    .card-header {
        border-bottom: 1px solid #282828 !important;
        /* Slightly lighter border for header separation */
    }

    .card-footer {
        border-top: 1px solid #282828 !important;
        /* Lighter border for footer separation */
    }

    /* State-specific Cards */
    .card-active {
        border-left: 5px solid #A3FF12;
        /* Green accent on active cards */
    }

    .card-expired {
        background-color: #111;
        border: 1px solid #333;
        /* Make border solid but faded */
        opacity: 0.8;
    }

    .card-expired .text-muted,
    .card-expired .text-white {
        color: #999 !important;
        /* Mute text inside expired cards */
    }

    /* --- Text Readability Improvement --- */
    /* Ensure muted text is bright enough to be easily readable on the dark cards */
    .card-dark .text-muted {
        color: #BBBBBB !important;
        /* Brighter gray for better contrast on #1A1A1A background */
    }

    /* --- Button Styles --- */
    .btn-green {
        background-color: #A3FF12;
        color: #0B0B0B;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        transition: 0.3s ease;
    }

    .btn-green:hover {
        background-color: #C3FF42;
        transform: translateY(-2px);
    }

    .btn-cancel {
        border: 1px solid #FF4757;
        color: #FF4757;
        background: transparent;
        border-radius: 8px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-cancel:hover {
        background-color: #FF4757;
        color: #1A1A1A;
    }

    /* --- Alert Styles --- */
    .alert {
        background-color: #1A1A1A;
        border: 1px solid #444;
        color: #F5F5F5;
        border-radius: 8px;
        padding: 1rem;
    }

    .alert-danger {
        border-left: 5px solid #FF4757;
    }

    .alert-info {
        border-left: 5px solid #A3FF12;
    }
</style>

<main class="py-5">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold text-white display-5">
                <i class="bi bi-journal-check text-green me-3"></i> My Bookings
            </h2>
            <a href="events.php" class="btn btn-green rounded-pill px-4 py-2">
                <i class="bi bi-calendar-plus me-1"></i> New Booking
            </a>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger mb-4">
                <i class="bi bi-x-octagon me-2"></i><strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($bookings)): ?>
            <div class="text-center p-5 rounded border border-secondary" style="background-color:#1A1A1A;">
                <h4 class="text-white mb-3 fw-light">You haven't booked any events yet.</h4>
                <p class="text-muted">Explore upcoming events and secure your spot!</p>
                <a href="events.php" class="btn btn-green rounded-pill mt-4 px-4 py-2">
                    <i class="bi bi-search me-1"></i> Browse Events
                </a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($bookings as $b):
                    // Logic to determine event status
                    $is_expired = strtotime($b['event_date']) < time();
                    $card_class = $is_expired ? 'card-expired' : 'card-active';
                    $status_badge = $is_expired
                        ? '<span class="badge bg-danger rounded-pill py-2 px-3"><i class="bi bi-hourglass-split me-1"></i>Expired</span>'
                        : '<span class="badge bg-success rounded-pill py-2 px-3"><i class="bi bi-check-circle me-1"></i>Active</span>';
                    ?>
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card card-dark <?php echo $card_class; ?> h-100">
                            <div class="card-header d-flex justify-content-between align-items-center bg-transparent">
                                <h5 class="fw-bold text-white mb-0 text-truncate">
                                    <?php echo htmlspecialchars($b['event_name']); ?></h5>
                                <?php echo $status_badge; ?>
                            </div>

                            <div class="card-body">
                                <p class="mb-2"><i class="bi bi-calendar-event text-green me-2"></i>
                                    <strong>Date:</strong>
                                    <?php echo htmlspecialchars(date("F j, Y, h:i A", strtotime($b['event_date']))); ?>
                                </p>
                                <p class="mb-2"><i class="bi bi-geo-alt-fill text-green me-2"></i>
                                    <strong>Location:</strong> <?php echo htmlspecialchars($b['event_location']); ?>
                                </p>
                                <p class="mb-4"><i class="bi bi-ticket-perforated text-green me-2"></i>
                                    <strong>Tickets:</strong> <?php echo htmlspecialchars($b['tickets']); ?>
                                </p>

                                <div class="border-top border-secondary pt-3 mt-3">
                                    <p class="fs-5 fw-bold mb-1">
                                        <small class="text-muted fw-normal me-2">Total Paid:</small>
                                        <span class="text-green">₹<?php echo number_format($b['total_price'], 0); ?></span>
                                    </p>
                                </div>
                            </div>

                            <div class="card-footer text-center bg-transparent">
                                <p class="small text-muted mb-3">Booking ID:
                                    #<?php echo htmlspecialchars($b['booking_id']); ?> |
                                    <span>Booked on
                                        <?php echo htmlspecialchars(date("Y-m-d", strtotime($b['booking_date']))); ?></span>
                                </p>

                                <div class="d-grid gap-2 d-md-block">
                                    <?php if (!$is_expired): ?>
                                        <a href="confirm.php?id=<?php echo htmlspecialchars($b['booking_id']); ?>"
                                            class="btn btn-green btn-sm px-3">
                                            <i class="bi bi-qr-code me-1"></i> View Ticket
                                        </a>
                                        <a href="cancel_booking.php?id=<?php echo htmlspecialchars($b['booking_id']); ?>"
                                            class="btn btn-cancel btn-sm px-3"
                                            onclick="return confirm('Are you sure you want to cancel booking #<?php echo $b['booking_id']; ?>? This action cannot be undone.');">
                                            <i class="bi bi-x-circle me-1"></i> Cancel Booking
                                        </a>
                                    <?php else: ?>
                                        <span class="text-danger small fw-bold"><i class="bi bi-info-circle me-1"></i> Event has
                                            concluded</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>