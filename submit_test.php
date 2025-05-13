<?php
session_start();
require 'db1.php';  // Include the database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header('Location: login1.php');
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $test_name = $_POST['test_name'];  // This comes from the hidden input field in the form
    $score = 0;

    // Calculate the score based on submitted answers
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'q') === 0) {  // Process only form elements starting with 'q'
            $score += intval($value);
        }
    }

    // Determine conclusion based on test name and score
    $conclusion = '';
    switch ($test_name) {
        case 'depression':
            if ($score <= 4) $conclusion = "Minimal depression.";
            elseif ($score <= 9) $conclusion = "Mild depression.";
            elseif ($score <= 14) $conclusion = "Moderate depression.";
            else $conclusion = "Severe depression. Please seek help.";
            break;
        
        case 'anxiety':
            if ($score <= 4) $conclusion = "Minimal anxiety.";
            elseif ($score <= 9) $conclusion = "Mild anxiety.";
            elseif ($score <= 14) $conclusion = "Moderate anxiety.";
            else $conclusion = "Severe anxiety. Please seek help.";
            break;

        // Add other cases for different tests here...
    }

    // Insert the test result into the database
    $stmt = $conn->prepare("INSERT INTO test_results (user_id, test_name, score, conclusion) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('isis', $user_id, $test_name, $score, $conclusion);

    if ($stmt->execute()) {
        // Send the score back to the client for an alert and then redirect to profile
        echo "<script>
            alert('You scored $score in the $test_name test. Conclusion: $conclusion');
            window.location.href = 'profile1.php';
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
