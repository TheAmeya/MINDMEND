<?php
$host = 'localhost';          // Hostname, typically 'localhost'
$db = 'user_auth';            // Use the correct database name 'user_auth'
$user = 'root';               // Default username for XAMPP
$pass = '';                   // Default password for XAMPP (leave it empty for root)

$conn = mysqli_connect($host, $user, $pass, $db);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
