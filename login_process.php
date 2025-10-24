<?php
session_start();
include 'db/connection.php'; // Provides the database connection ($conn)

// Ensure the script only runs when the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Sanitize and trim input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Default redirection URL (for generic login)
    $redirect_url = 'index.php';

    // 2. Prepare statement to retrieve user data by email
    // We fetch the hashed password, ID, and name
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");

    if (!$stmt) {
        // Handle database preparation error
        $_SESSION['login_error'] = "A critical system error occurred. Please try again.";
        header("Location: login.php");
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $stmt->close();

        // 3. Verify the submitted password against the hash
        if (password_verify($password, $user['password'])) {

            // --- SUCCESSFUL LOGIN ---

            // 4. Set session variables for user identity and authentication
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name']; // Useful for displaying personalized content

            // 5. Handle redirection back to the intended page (if one was stored)
            if (isset($_SESSION['redirect_to'])) {
                $redirect_url = $_SESSION['redirect_to'];
                unset($_SESSION['redirect_to']); // Clear the stored URL after use
            }

            // Redirect to the final destination
            header("Location: " . $redirect_url);
            exit();

        } else {
            // Invalid password (but email found) - use generic error
            $_SESSION['login_error'] = "Invalid email or password.";
        }
    } else {
        // No account found with that email - use generic error
        $_SESSION['login_error'] = "Invalid email or password.";
    }

    // Redirect back to login page if authentication failed
    header("Location: login.php");
    exit();

} else {
    // If someone tries to access this script directly without POST data
    header("Location: login.php");
    exit();
}
?>