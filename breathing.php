<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: login1.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Breathing Exercises</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: url('https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDl8fGNhbG1pbmd8ZW58MHx8fHwxNjA3MzE5MDEx&ixlib=rb-1.2.1&q=80&w=1920');
            background-size: cover;
            background-position: center;
            color: #333;
        }

        /* Navbar Styling */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        /* Title Container Styling */
        .title-container {
            position: fixed;
            top: 60px; /* Adjust according to navbar height */
            width: 100%;
            z-index: 99;
            text-align: center;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        /* Title Styling */
        .title {
            font-size: 40px;
            color: #2c3e50;
            text-align: center;
            font-family: 'Georgia', serif;
            text-shadow: 1px 1px 3px rgba(255, 255, 255, 0.9);
        }

        /* Main Container */
        .container {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 1200px;
            margin: auto;
            padding-top: 200px; /* Padding to avoid overlap with the fixed elements */
            justify-content: center;
        }

        /* Left Side Container */
        .left-container {
            padding: 40px 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            margin-right: 20px;
        }

        /* Button Styling */
        button {
            padding: 12px 15px;
            font-size: 18px;
            font-weight: bold;
            background-color: #3498db;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.2s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 10px;
            width: 100%;
        }

        /* Video Container */
        #video-container {
            margin-top: 30px;
            border: 5px solid #2c3e50;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            display: none;
        }

        video {
            width: 100%;
            border-radius: 10px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .title {
                font-size: 30px;
            }

            button {
                font-size: 14px;
                padding: 10px;
            }

            .title-container {
                top: 50px; /* Adjust if navbar height changes */ 
            }
            /* Style for the call sign button */


        }
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
    <!-- Include Navbar -->
    <nav>
        <?php include('navbar.php'); ?>
    </nav>

    <!-- Fixed Title -->
    <div class="title-container">
        <h1 class="title">Breathing Exercises</h1>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="left-container">
            <div class="buttons-container">
                <button onclick="playVideo('5555_breathing.mp4')">5 | 5 | 5 | 5 Box Breathing</button>
                <button onclick="playVideo('7777_breathing.mp4')">7 | 7 | 7 | 7 Box Breathing</button>
                <button onclick="playVideo('i.mp4')">Insomnia Method Breathing</button>
                <button onclick="playVideo('4080_breathing.mp4')">4 | 0 | 8 | 0 Breathing (Reduce Heart Rate)</button>
                <button onclick="playVideo('478_breathing.mp4')">4 | 7 | 8 Breathing Exercise</button>

                <!-- Additional Exercise Buttons -->
                <button onclick="playVideo('1.mp4')">Oceanic Breathing Meditation</button>
                <button onclick="playVideo('2.mp4')">Harmony in Calm Breathing</button>
                <button onclick="playVideo('3.mp4')">Mindful Slow Breath</button>
                <button onclick="playVideo('4.mp4')">Lunar Relaxation Breath</button>
                <button onclick="playVideo('5.mp4')">Stellar Deep Breathing</button>
                <button onclick="playVideo('O.mp4')">Rhythmic Breath Sync</button>
            </div>
        </div>
 


        <!-- Video Container -->
        <div id="video-container">
            <video id="breathing-video" controls loop>
                <source id="video-source" src="" type="video/mp4">
                Your browser does not support the video tag.
            </video>
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
        function playVideo(videoFile) {
            var videoContainer = document.getElementById('video-container');
            var videoElement = document.getElementById('breathing-video');
            var videoSource = document.getElementById('video-source');

            videoSource.src = videoFile;
            videoElement.load();
            videoContainer.style.display = 'block';
            videoElement.play();
        }

        function playMixture(buttonIndex) {
            var videoContainer = document.getElementById('video-container');
            var videoElement = document.getElementById('breathing-video');
            var videoSource = document.getElementById('video-source');
            
            var videos = [
                'C:/xampp/htdocs/5555_breathing.MP4.mp4',
                'C:/xampp/htdocs/7777_breathing.MP4.mp4',
                'C:/xampp/htdocs/insominia_method_breathing.MP4.mp4',
                'C:/xampp/htdocs/4080_breathing.MP4.mp4',
                'C:/xampp/htdocs/478_breathing.MP4.mp4'
            ];

            var combinations = [
                [0, 1, 2],
                [1, 3],
                [2, 4],
                [0, 4],
                [1, 2, 4],
                [0, 3, 4]
            ];

            var currentCombo = combinations[buttonIndex - 1];
            var currentVideo = 0;

            function playNextVideo() {
                videoSource.src = videos[currentCombo[currentVideo]];
                videoElement.load();
                videoElement.play();

                videoElement.onended = function() {
                    currentVideo = (currentVideo + 1) % currentCombo.length;
                    playNextVideo();
                };
            }

            playNextVideo();
            videoContainer.style.display = 'block';
        }
        // Function to toggle the pop-up visibility
function togglePopup() {
    var popup = document.getElementById("popup");
    popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";
}

    </script>

</body>
</html>
