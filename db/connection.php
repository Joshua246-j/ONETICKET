<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "ONETICKET";

// Create connection
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$conn) {
    die("<b>Database connection failed:</b> " . mysqli_connect_error());
}

// Set proper character encoding
mysqli_set_charset($conn, "utf8mb4");
?>