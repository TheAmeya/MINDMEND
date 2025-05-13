<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login1.php");
    exit();
}

$host = 'localhost';
$dbname = 'user_auth';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $city = $_POST['city'];
        $state = $_POST['state'];
        $district = $_POST['district'] ?? '';
        $address = $_POST['address'] ?? '';

        // Modified SQL query to include clinic_address and district search flexibility
        $sql = "SELECT first_name, last_name, specialization, clinic_address, district 
                FROM psychiatrists 
                WHERE city LIKE :city 
                AND state LIKE :state 
                AND (district LIKE :district OR clinic_address LIKE :address)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'city' => "%$city%", 
            'state' => "%$state%", 
            'district' => "%$district%", 
            'address' => "%$address%"
        ]);
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            $output = "<h3>Psychiatrists Near '$address, $city, $state'</h3><ul class='psych-list'>";
            foreach ($results as $row) {
                $output .= "<li>
                                <h4>{$row['first_name']} {$row['last_name']}</h4>
                                <p class='specialization'>Specialization: {$row['specialization']}</p>
                                <p class='clinic-info'>Clinic: {$row['clinic_address']}, District: {$row['district']}</p>
                            </li>";
            }
            $output .= "</ul>";
        } else {
            $output = "<p>No psychiatrists found in the specified area.</p>";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Nearby Psychiatrists</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('help.jpeg') center/cover no-repeat;
            color: #333;
            text-align: center;
        }

        .container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 600px;
            margin: 40px auto;
            color: #333;
        }

        h1 {
            font-size: 2em;
            color: #3498db;
        }

        input[type="text"], select {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            padding: 15px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        .psych-list {
            list-style: none;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
            align-items: center;
        }

        .psych-list li {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            padding: 20px;
            width: 90%;
            max-width: 500px;
            text-align: left;
            color: #333;
        }

        .psych-list li h4 {
            margin: 0;
            font-size: 1.2em;
            color: #2c3e50;
        }

        .psych-list li .specialization {
            color: #3498db;
            font-weight: bold;
        }

        .psych-list li .clinic-info {
            font-size: 0.9em;
            color: #7f8c8d;
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
    
<?php include('navbar.php'); ?> <!-- Include the navbar -->
    <div class="container">
        <h1>Find Psychiatrists Near You</h1>

        <!-- Search form -->
        <form method="POST" action="">
            <div>
                <label for="address">Approximate Address</label><br>
                <input type="text" id="address" name="address"><br><br>
            </div>
            <div>
                <label for="city">City</label><br>
                <input type="text" id="city" name="city" required><br><br>
            </div>
            <div>
                <label for="state">State</label><br>
                <input type="text" id="state" name="state" required><br><br>
            </div>
            <div>
                <label for="district">District</label><br>
                <input type="text" id="district" name="district"><br><br>
            </div>
            <button type="submit">Search</button>
        </form>

        <!-- Display results -->
        <div id="result">
            <?php if (isset($output)) { echo $output; } ?>
        </div>
    </div>
    <!-- Call sign button -->
<div class="call-sign" onclick="togglePopup()">Need Help?</div>

<!-- Pop-up with suicide prevention number -->
<div class="popup" id="popup">
    <span class="close-btn" onclick="togglePopup()">x</span>
    Suicide Prevention Hotline: <br><strong>1-800-273-8255</strong>
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
