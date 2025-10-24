<?php
session_start();

// Check if user is already logged in, redirect to home.php
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit();
}

// Check for a flash error message from the login processing handler
$error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['login_error']); // Clear the message after displaying it
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONETICKET - Login</title>

    <!-- Essential Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Google Fonts (Aesthetic Typography) -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Custom Aesthetic CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        /* Structural CSS: Ensures the background and centering function correctly. */
        body {
            /* Ensures full-page background and centering */
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
            background-color: var(--dark-bg, #000);
            color: var(--text-light, #E8E8E8);
            font-family: 'Poppins', sans-serif;
        }

        /* Custom alert styling to match the dark theme */
        .alert-custom {
            background-color: rgba(255, 71, 87, 0.15);
            /* Primary Red with low opacity */
            border: 1px solid #FF4757;
            color: #FF4757;
        }

        .btn-close-white {
            filter: invert(1);
        }
    </style>
</head>

<body>
    <!-- Background Image Wrapper -->
    <div class="background-image-wrapper">
        <img src="https://images.unsplash.com/photo-1470225640333-777c57c5a082?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80"
            alt="Vibrant Concert Audience" class="background-image">
        <div class="bg-overlay"></div>
    </div>

    <!-- Main Content Container -->
    <main class="login-container d-flex justify-content-center align-items-center">
        <!-- Login Card (Glassmorphism effect provided by .login-box-glass class from style.css) -->
        <div class="login-box-glass text-center p-4 p-md-5 mx-3" data-aos="zoom-in" data-aos-duration="1000">

            <div class="login-header mb-4">
                <i class="bi bi-ticket-perforated login-brand-icon mb-2"></i>
                <h1 class="login-title mb-2">ONETICKET</h1>
                <!-- Proper Aesthetic Motto -->
                <p class="login-motto lead mb-0">Your Passport to Unforgettable Moments</p>
            </div>

            <?php if ($error): ?>
                <!-- Error Display -->
                <div class="alert alert-custom alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i> <?php echo htmlspecialchars($error); ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Form submission points to login_process.php for authentication -->
            <form action="login_process.php" method="POST" class="mb-3">
                <div class="mb-3">
                    <!-- Aesthetic form control using .form-control-glass (from style.css) -->
                    <input type="email" name="email" class="form-control form-control-glass" placeholder="Email Address"
                        required>
                </div>
                <div class="mb-4">
                    <input type="password" name="password" class="form-control form-control-glass"
                        placeholder="Password" required>
                </div>
                <!-- Aesthetic button using .btn-login-glass (from style.css) -->
                <button type="submit" class="btn btn-login-glass w-100">Login to Your World</button>
            </form>

            <div class="login-footer">
                <!-- Registration link -->
                <p class="mb-2">Don’t have an account? <a href="register.php" class="text-gradient-login">Sign up</a>
                </p>
                <!-- Forgot Password link -->
                <a href="forgot_password.php" class="text-muted-light" style="font-size: 0.9em;">Forgot Password?</a>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true
        });
    </script>
</body>

</html>