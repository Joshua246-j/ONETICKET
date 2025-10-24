<?php
session_start();
include 'db/connection.php'; // Includes the $conn database connection object

$error = '';
$success = '';

// Check if user is already logged in, redirect to home.php
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Sanitize and collect user input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 2. Server-side Validation
    if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
        $error = 'All fields are required.';
    } elseif (strlen($name) < 3) {
        $error = 'Full Name must be at least 3 characters long.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Enter a valid email address.';
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        // Enforcing a 10-digit numeric phone number
        $error = 'Phone must be a 10-digit number (e.g., 9876543210).';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // 3. Check for existing email using prepared statement
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = 'Email already registered. Login instead.';
        } else {
            // 4. Securely hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // 5. Insert new user into the database
            $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password, created_at) VALUES (?, ?, ?, ?, NOW())");
            // "ssss" for four string parameters
            $stmt->bind_param("ssss", $name, $email, $phone, $hashed_password);

            if ($stmt->execute()) {
                $success = 'Registration successful! You will be redirected to the login page shortly...';

                // Redirect after a 2-second delay to show success message
                header("Refresh:2; url=login.php");
                exit();
            } else {
                // Handle insertion error
                error_log("User registration failed: " . $stmt->error);
                $error = 'Server error. Please try again.';
            }
        }
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ONETICKET</title>
    <!-- Use Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Load Poppins font for consistency -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        /* Registration Page Specific Styles (Dark/Neon Aesthetic) */
        body {
            font-family: 'Poppins', sans-serif;
            background: #0D0D0D;
            color: #fff;
        }

        .register-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .register-card {
            background: #1A1A1A;
            border-radius: 16px;
            padding: 2.5rem;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .form-control {
            background: #2A2A2A;
            border: 1px solid #444;
            color: #fff;
            border-radius: 8px;
            padding: 10px 15px;
        }

        .form-control:focus {
            background: #2A2A2A;
            border-color: #a3ff12;
            box-shadow: 0 0 10px rgba(163, 255, 18, 0.4);
            color: #fff;
        }

        .btn-register {
            background: linear-gradient(135deg, #a3ff12, #FFA500);
            /* Neon Green to Orange Gradient */
            color: #0D0D0D;
            font-weight: 700;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            opacity: 0.9;
            box-shadow: 0 5px 20px rgba(163, 255, 18, 0.5);
            transform: translateY(-2px);
        }

        /* Error Alert Style */
        .alert-custom {
            background: rgba(255, 71, 87, 0.1);
            border: 1px solid #ff4757;
            color: #ff4757;
            border-radius: 8px;
        }

        /* Success Alert Style */
        .success-custom {
            background: rgba(163, 255, 18, 0.1);
            border: 1px solid #a3ff12;
            color: #a3ff12;
            border-radius: 8px;
        }

        .text-neon-green {
            color: #a3ff12;
            font-weight: 700;
        }

        a {
            color: #a3ff12;
            text-decoration: none;
        }

        a:hover {
            color: #C3FF42;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-card">
            <h2 class="text-center mb-4 text-neon-green">
                <i class="bi bi-person-plus-fill me-2"></i> Create Your Account
            </h2>

            <?php if ($error): ?>
                <div class="alert alert-custom"><i
                        class="bi bi-x-octagon-fill me-2"></i><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert success-custom"><i
                        class="bi bi-check-circle-fill me-2"></i><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" autocomplete="off">
                <!-- Full Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required
                        placeholder="Enter your full name">
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required
                        placeholder="user@example.com">
                </div>

                <!-- Phone Number -->
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" name="phone" id="phone" class="form-control" pattern="[0-9]{10}"
                        value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required
                        placeholder="10-digit number">
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Min 6 characters" required>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                </div>

                <!-- Terms Checkbox -->
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="termsCheck" required>
                    <label class="form-check-label" for="termsCheck">I agree to the <a href="#">Terms &
                            Conditions</a></label>
                </div>

                <button type="submit" class="btn btn-register">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Create Account
                </button>
            </form>

            <p class="text-center mt-4 text-muted small">
                Already have an account? <a href="login.php">Login here</a>
            </p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>