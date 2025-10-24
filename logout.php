<?php
// logout.php

// 1. Start the session to access existing session data
session_start();

// 2. Unset all session variables (clears data stored in the current session)
$_SESSION = array();

// 3. Destroy the session (deletes the session file on the server)
// This invalidates the old session ID completely.
session_destroy();

// 4. Redirect the user to the homepage/login page
header('Location: index.php'); // Assuming index.php is your primary entry/login page
exit;
?>