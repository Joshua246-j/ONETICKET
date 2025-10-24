<?php
session_start();
include 'includes/header.php';
include 'db/connection.php'; // MySQL connection

// --- 1. Fetch Booking Data with Joins ---
$booking_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$booking = null;

if ($booking_id > 0) {
    // SECURITY: Use a prepared statement to fetch the booking details, joining all three tables.
    $sql = "SELECT 
                b.id AS booking_ref, 
                b.tickets, 
                b.total_price, 
                b.booking_date,
                e.name AS event_name, 
                e.date AS event_date, 
                e.location AS event_location,
                u.name AS user_name,
                u.email AS user_email,
                u.phone AS user_phone
            FROM bookings b
            INNER JOIN events e ON b.event_id = e.id
            INNER JOIN users u ON b.user_id = u.id
            WHERE b.id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $booking = $result->fetch_assoc();
        }
        $stmt->close();
    }
}
?>

<style>
    .confirm-container {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .text-green {
        color: #A3FF12;
    }

    .card-confirm {
        max-width: 550px;
        background-color: #1A1A1A;
        padding: 30px;
        border-radius: 16px;
        border: 2px solid #A3FF12;
        /* Highlight border */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
    }

    .booking-detail-item {
        font-size: 1.1rem;
        margin-bottom: 15px;
        color: #EAEAEA;
        text-align: left;
    }

    .detail-icon {
        color: #A3FF12;
        margin-right: 10px;
    }

    .btn-green {
        background-color: #A3FF12;
        color: #0B0B0B;
        font-weight: bold;
        border-radius: 8px;
        padding: 10px 30px;
        transition: all 0.3s ease;
        text-transform: uppercase;
    }

    .btn-green:hover {
        background-color: #C3FF42;
        transform: translateY(-2px);
    }
</style>

<body style="background-color: #0B0B0B; color: #F5F5F5;">

    <section class="confirm-section py-5 confirm-container">
        <div class="container text-center">

            <?php if ($booking): ?>

                <h1 class="fw-bolder mb-3" style="font-family: 'Montserrat', sans-serif; font-size: 2.5rem;">
                    <i class="bi bi-check-circle-fill text-green me-2"></i> Booking Confirmed!
                </h1>

                <p class="mb-4 lead">Thank you, <strong
                        class="text-green"><?php echo htmlspecialchars($booking['user_name']); ?></strong>. Your ticket
                    details are below.</p>

                <div class="card-confirm mx-auto">
                    <h4 class="text-green border-bottom pb-2 mb-4">Ticket Reference: #<?php echo $booking['booking_ref']; ?>
                    </h4>

                    <div class="d-grid gap-2">
                        <div class="booking-detail-item">
                            <i class="bi bi-calendar-event detail-icon"></i>
                            <strong>Event:</strong> <?php echo htmlspecialchars($booking['event_name']); ?>
                        </div>
                        <div class="booking-detail-item">
                            <i class="bi bi-clock detail-icon"></i>
                            <strong>Date:</strong> <?php echo date('F j, Y', strtotime($booking['event_date'])); ?>
                        </div>
                        <div class="booking-detail-item">
                            <i class="bi bi-geo-alt-fill detail-icon"></i>
                            <strong>Location:</strong> <?php echo htmlspecialchars($booking['event_location']); ?>
                        </div>

                        <hr style="border-color: rgba(255, 255, 255, 0.1);">

                        <div class="booking-detail-item">
                            <i class="bi bi-ticket-perforated detail-icon"></i>
                            <strong>Tickets:</strong> <?php echo $booking['tickets']; ?>
                        </div>
                        <div class="booking-detail-item">
                            <i class="bi bi-currency-rupee detail-icon"></i>
                            <strong>Total Paid:</strong> ₹<?php echo number_format($booking['total_price'], 0); ?>
                        </div>
                        <div class="booking-detail-item">
                            <i class="bi bi-envelope-fill detail-icon"></i>
                            <strong>Email:</strong> <?php echo htmlspecialchars($booking['user_email']); ?>
                        </div>

                        <p class="small text-muted mt-3 mb-0">
                            Booking placed on: <?php echo date('d M Y, h:i A', strtotime($booking['booking_date'])); ?>
                        </p>
                    </div>
                </div>
                <a href="my_bookings.php" class="btn btn-green mt-5 me-3">View All Bookings</a>
                <a href="events.php" class="btn btn-outline-light mt-5 border-green text-green">Book Another Event</a>

            <?php else: ?>
                <h2 class="fw-bold mb-4" style="font-family: 'Montserrat', sans-serif; color:#FF4C4C;">
                    <i class="bi bi-x-octagon-fill me-2"></i> Booking Not Found!
                </h2>
                <p>We could not find the details for Booking ID **#<?php echo $booking_id; ?>**. Please check your link or
                    <a href="my_bookings.php" style="color:#A3FF12;">view your past bookings</a>.
                </p>
            <?php endif; ?>

        </div>
    </section>

</body>

<?php include 'includes/footer.php'; ?>