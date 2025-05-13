<?php
session_start();
$host = 'localhost';
$db = 'user_auth';
$user = 'root';
$pass = ''";

// Connect to database
$conn = new mysqli($host, $user, $pass, $db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $email;  // Save email in session
            $_SESSION['LAST_ACTIVITY'] = time(); // Track login time
            echo 'success';
        } else {
            echo 'fail';
        }
    } else {
        echo 'fail';
    }
}
?>