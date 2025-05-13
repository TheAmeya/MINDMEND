<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login1.php");
    exit();
}

$user_name = $_SESSION['user_name'];
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
    <p>Hello, <?php echo $user_name; ?>. Based on your recent assessment, your GAD-7 score is: <strong>7</strong>.</p>
    <p>This indicates mild anxiety. You can meditate or follow mindfulness practices to help manage your anxiety.</p>
</body>
</html>