<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Example of a GAD-7 score stored in the session
$gad7_score = 7; // This can be fetched dynamically from the database

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAD-7 Score</title>
</head>
<body>
    <h1>Your GAD-7 Score</h1>
    <p>Your current GAD-7 score is: <strong><?php echo $gad7_score; ?></strong></p>
    <p>Based on this score, you may have moderate anxiety.</p>

    <p><a href="profile.php">Back to Profile</a></p>
</body>
</html>