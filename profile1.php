<?php
session_start();
require 'db1.php';  // Include your database connection file

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login1.php');
    exit();
}

// Retrieve user details from the session
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
$user_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$user_profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'default_profile_picture.jpg';

// Fetch user's test results from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT test_name, score FROM test_results WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$results = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            background-image: url('background.jpg');
            background-size: cover;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
                url('mh.webp');
            background-size: cover;
            background-position: center; 
        }

        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #4CAF50;
            padding: 15px;
            text-align: left;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 18px;
        }

        nav a:hover {
            background-color: yellow;
        }

        .profile-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
            margin-top: 100px;
        }

        .profile-picture {
            background-color: #f0f0f0;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            display: inline-block;
            line-height: 100px;
            font-size: 40px;
            color: #aaa;
        }

        .logout-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            text-decoration: none;
            font-size: 16px;
        }

        .logout-btn:hover {
            background-color: #45a049;
        }

        .test-results {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        th {
            background-color: #f0f0f0;
        }
        /* Style for the call sign button */
.call-sign {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #ff5c5c;
    color: white;
    padding: 10px 15px;
    border-radius: 20px;
    font-size: 14px;
    text-align: center;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}

/* Style for the pop-up */
.popup {
    display: none;
    position: fixed;
    bottom: 70px;
    right: 20px;
    background-color: #ffffff;
    color: #333333;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    font-size: 16px;
    width: 250px;
    text-align: center;
    z-index: 1001;
}

/* Close button */
.close-btn {
    cursor: pointer;
    color: #ff5c5c;
    font-weight: bold;
    float: right;
    margin-left: 10px;
}

    </style>
</head>
<body>
    
<?php include('navbar.php'); ?>

    <div class="profile-container">
        <img src="https://images.unsplash.com/photo-1592194996308-3a5b9f8c5d62?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNzMwN3wwfDF8c2VhcmNofDV8fGRpbm9zYXVyfGVufDB8fHx8MTY3MDE3NjA4Nw&ixlib=rb-1.2.1&q=80&w=1080" alt="Profile Picture" class="profile-picture">
        <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>
        <p>Email: <?php echo htmlspecialchars($user_email); ?></p>
        <p>This is your profile page. You can manage your settings and view your activity here.</p>
        <!-- Call sign button -->
<div class="call-sign" onclick="togglePopup()">Need Help?</div>

<!-- Pop-up with suicide prevention number -->
<div class="popup" id="popup">
    <span class="close-btn" onclick="togglePopup()">x</span>
    Suicide Prevention Hotline: <br><strong>1-800-273-8255</strong>
</div>


      <!--  
        <div class="test-results">
            <h3>Your Test Results</h3>
            <?php if ($results->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Test Name</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $results->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['test_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['score']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No test results found.</p>
            <?php endif; ?>
        </div>-->

        <a href="logout1.php" class="logout-btn">Logout</a>
    </div>
    <script>
        // Function to toggle the pop-up visibility
function togglePopup() {
    var popup = document.getElementById("popup");
    popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";
}

        </script>
</body>
</html>
