<?php
// includes/header.php

// 1. START SESSION: Must be the absolute first line of PHP code that is executed.
// FIX: Use session_status() check to prevent the "Ignoring session_start()" Notice.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Define protected pages (only accessible when logged in)
$protected_pages = ['my_bookings.php', 'booking.php', 'confirm.php', 'logout.php', 'profile.php'];

// Get variables
$current_page = basename($_SERVER['PHP_SELF']);
$is_logged_in = isset($_SESSION['user_id']);
$user_name_safe = $is_logged_in ? htmlspecialchars($_SESSION['user_name'] ?? 'User') : 'Guest';

// --- UNIVERSAL ACCESS CONTROL LIST (ACL) ---
if (in_array($current_page, $protected_pages) && !$is_logged_in) {
    // If the user tries to access a protected page, save their destination (e.g., booking.php?event=1)
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php"); // Redirects to the login form page
    exit();
}
// --- END ACL ---

// Set default title
if (!isset($page_title)) {
    $page_title = 'All Your Tickets. One Platform';
}

// Function to handle active link highlighting
function is_active($page_name, $current_page)
{
    // Fix 1: Map the current page to the home alias if it's index.php
    $home_alias = 'index.php';

    // Check if the current page is index.php and the link is home, OR if the file names match directly.
    if (($page_name === 'index.php' || $page_name === 'home.php') && $current_page === $home_alias) {
        return ' active';
    }
    return $current_page === $page_name ? ' active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONETICKET - <?php echo htmlspecialchars($page_title); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Assuming custom CSS defines colors like primary-green, etc. -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .user-dropdown-btn {
            background-color: var(--primary-green) !important;
            color: #0D0D0D !important;
            border: none !important;
            font-weight: 600 !important;
        }

        .user-dropdown-btn:hover {
            background-color: #C3FF42 !important;
        }

        .brand-text {
            /* Styling for the ONETICKET text, assuming custom CSS variables */
            color: var(--primary-green, #A3FF12);
            font-size: 1.25rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top shadow-sm" aria-label="Main navigation">
        <div class="container-fluid px-4">

            <!-- Branding: Fix 2: Changed href to index.php -->
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <i class="bi bi-ticket-perforated brand-icon me-2" aria-hidden="true"
                    style="color: var(--primary-green, #A3FF12);"></i>
                <span class="fw-bold brand-text">ONETICKET</span>
            </a>

            <!-- Toggler Button -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-2 text-white"></i>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-lg-center">

                    <!-- 1. Home Link: Fix 3: Changed href to index.php and added 'index.php' to active check -->
                    <li class="nav-item mx-2"><a class="nav-link<?php echo is_active('index.php', $current_page); ?>"
                            href="index.php"><i class="bi bi-house-door"></i> Home</a></li>

                    <!-- 2. Events Link -->
                    <li class="nav-item mx-2"><a class="nav-link<?php echo is_active('events.php', $current_page); ?>"
                            href="events.php"><i class="bi bi-calendar-event"></i> Events</a></li>

                    <?php if ($is_logged_in): ?>
                        <!-- 3. My Bookings Link (Visible only when logged in) -->
                        <li class="nav-item mx-2">
                            <a class="nav-link<?php echo is_active('my_bookings.php', $current_page); ?>"
                                href="my_bookings.php"><i class="bi bi-bookmark-check"></i> My Bookings</a>
                        </li>
                    <?php endif; ?>

                </ul>

                <div class="d-flex align-items-center gap-2 ms-lg-3 mt-3 mt-lg-0">

                    <!-- Search Button -->
                    <button class="btn btn-outline-light rounded-pill px-3" data-bs-toggle="modal"
                        data-bs-target="#searchModal" aria-label="Open Search">
                        <i class="bi bi-search"></i> <span class="d-none d-lg-inline ms-1">Search</span>
                    </button>

                    <?php if ($is_logged_in): ?>
                        <!-- LOGGED IN STATE: Show Username and Dropdown -->
                        <div class="dropdown">
                            <button class="btn rounded-pill px-3 dropdown-toggle text-nowrap user-dropdown-btn"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                aria-label="User menu for <?php echo $user_name_safe; ?>">
                                <i class="bi bi-person-circle me-1"></i> <?php echo $user_name_safe; ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                                <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person"></i> Profile</a>
                                </li>
                                <li><a class="dropdown-item" href="my_bookings.php"><i class="bi bi-ticket"></i> My
                                        Bookings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="logout.php"><i
                                            class="bi bi-box-arrow-right"></i> Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- LOGGED OUT STATE: Show Login/Register Buttons -->
                        <a href="login.php" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold"
                            style="background-color: var(--primary-green, #A3FF12); color: #0D0D0D; border: none;">Login</a>
                        <a href="register.php" class="btn btn-sm btn-outline-primary rounded-pill px-3"
                            style="color: var(--primary-green, #A3FF12); border-color: var(--primary-green, #A3FF12);">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <!-- Search Modal structure is required below for the search button to work -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background-color: #1A1A1A; color: #F5F5F5;">
                <div class="modal-header border-bottom" style="border-color: #333;">
                    <h5 class="modal-title" id="searchModalLabel"><i class="bi bi-search"></i> Search Events</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="events.php" method="GET">
                        <input type="text" name="q" class="form-control"
                            placeholder="Search by event name, city, or category..."
                            style="background-color: #2A2A2A; border-color: #A3FF12; color: #F5F5F5;">
                        <button type="submit" class="btn btn-primary mt-3"
                            style="background-color: #A3FF12; color: #0D0D0D;">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>