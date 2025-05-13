<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: login1.php");
    exit();
}

// You can use $_SESSION['user_name'] to greet the user
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
            display: flex;
            height: 100vh;
            background-image: url('https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDl8fGNhbG1pbmd8ZW58MHx8fHwxNjA3MzE5MDEx&ixlib=rb-1.2.1&q=80&w=1920');
            background-size: cover;
            background-position: center;
            color: #333;
        }

        /* Container */
        .container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            margin: auto;
            height: 100%;
            align-items: center;
            justify-content: space-between;
        }

        /* Left Side Container */
        .left-container {
            flex: 1;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            margin-right: 20px;
        }

        /* Title Styling */
        .title {
            font-size: 40px;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
            font-family: 'Georgia', serif;
            text-shadow: 1px 1px 3px rgba(255, 255, 255, 0.9);
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

        /* Button Hover Effect */
        button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        /* Video Container */
        #video-container {
            flex: 2;
            display: none;
            margin-top: 30px;
            border: 5px solid #2c3e50;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
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
        }
    </style>
</head>
<body>

    <?php include('navbar.php'); ?> 
    <div class="container">
        <div class="left-container">
            <h1 class="title">Breathing Exercises</h1>

            <div class="buttons-container">
                <button onclick="playVideo('C:\\Users\\hp\\Desktop\\my website\\5555.mp4.mp4')">5 | 5 | 5 | 5 Box Breathing</button>
                <button onclick="playVideo('C:\\Users\\hp\\Desktop\\my website\\7777.mp4.mp4')">7 | 7 | 7 | 7 Box Breathing</button>
                <button onclick="playVideo('C:\\Users\\hp\\Desktop\\my website\\insomnia.mp4.mp4')">Insomnia Method Breathing</button>
                <button onclick="playVideo('C:\\Users\\hp\\Desktop\\my website\\4080.mp4.mp4')">4 | 0 | 8 | 0 Breathing (Reduce Heart Rate)</button>
                <button onclick="playVideo('C:\\Users\\hp\\Desktop\\my website\\478.mp4.mp4')">4 | 7 | 8 Breathing Exercise</button>

                <!-- Additional Exercise Buttons -->
                <button onclick="playMixture(1)">Oceanic Breathing Meditation</button>
                <button onclick="playMixture(2)">Harmony in Calm Breathing</button>
                <button onclick="playMixture(3)">Mindful Slow Breath</button>
                <button onclick="playMixture(4)">Lunar Relaxation Breath</button>
                <button onclick="playMixture(5)">Stellar Deep Breathing</button>
                <button onclick="playMixture(6)">Rhythmic Breath Sync</button>
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

        // Function to play a unique mixture of videos based on button click
        function playMixture(buttonIndex) {
            var videoContainer = document.getElementById('video-container');
            var videoElement = document.getElementById('breathing-video');
            var videoSource = document.getElementById('video-source');
            
            // List of available video files
            var videos = [
                'C:\\Users\\hp\\Desktop\\my website\\5555.mp4.mp4',
                'C:\\Users\\hp\\Desktop\\my website\\7777.mp4.mp4',
                'C:\\Users\\hp\\Desktop\\my website\\insomnia.mp4.mp4',
                'C:\\Users\\hp\\Desktop\\my website\\4080.mp4.mp4',
                'C:\\Users\\hp\\Desktop\\my website\\478.mp4.mp4'
            ];

            // Define unique combinations for each button
            var combinations = [
                [0, 1, 2], // Oceanic Breathing Meditation
                [1, 3],    // Harmony in Calm Breathing
                [2, 4],    // Mindful Slow Breath
                [0, 4],    // Lunar Relaxation Breath
                [1, 2, 4], // Stellar Deep Breathing
                [0, 3, 4]  // Rhythmic Breath Sync
            ];

            var currentCombo = combinations[buttonIndex - 1];
            var currentVideo = 0;

            // Play videos in the defined combination
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
    </script>

</body>
</html>
