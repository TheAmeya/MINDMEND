
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
    <title>Mind-Mend | Your Mental Health Matters</title>

    <!-- CSS Styles -->
    <style>
        /* General Reset and Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Lato', sans-serif;
        }

        body {
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
        }

        h1, h2, h3 {
            font-family: 'Merriweather', serif;
        }

        /* Hero Section */
        .hero {
    background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
                url('charge.jpg');
    background-size: cover; /* Ensures the image covers the entire section */
    background-position: center; /* Centers the image */
    height: 100vh; /* Makes the section take up the full viewport height */
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
}

        .hero-content {
            max-width: 70%;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 12px;
            animation: fadeIn 2s ease-in-out;
        }

        .hero h1 {
            font-size: 4.5em;
            margin-bottom: 20px;
            letter-spacing: 2px;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7);
        }

        .hero p {
            font-size: 1.7em;
            margin-bottom: 30px;
            line-height: 1.5;
            color: #d3d3d3;
        }

        #cta-btn {
            background: linear-gradient(45deg, #57ca85, #2a9f85);
            color: white;
            padding: 15px 40px;
            border: none;
            font-size: 1.4em;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.4s ease;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
        }

        #cta-btn:hover {
            background: linear-gradient(45deg, #2a9f85, #57ca85);
            transform: translateY(-3px);
            box-shadow: 0 12px 18px rgba(0, 0, 0, 0.4);
        }

      
        .about {
            padding: 80px 20px;
            background-color: #fff;
            text-align: center;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
                url('photo.jpeg');
    background-size: cover; /* Ensures the image covers the entire section */
    background-position: center; /* Centers the image */
    height: 100vh; /* Makes the section take up the full viewport height */
        }

        .about h2 {
            font-size: 3em;
            color: #fff;
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
        }

        .about h2::after {
            content: '';
            width: 80px;
            height: 4px;
            background: #57ca85;
            display: block;
            margin: 10px auto;
        }

        .about p {
            font-size: 1.3em;
            color: #fff;
            max-width: 900px;
            margin: 0 auto 50px;
            line-height: 1.7;
        }

        /* Statistics Section */
        .statistics {
            display: flex;
            justify-content: space-around;
            background-color: #f8f9fa;
            padding: 80px 0;
            animation: fadeIn 2s ease-in-out;
        }

        .stat-box {
            text-align: center;
            padding: 20px;
            margin: 10px;
            transition: transform 0.3s ease;
        }

        .stat-box img {
            width: 120px;
            height: 120px;
            margin-bottom: 20px;
            border-radius: 50%;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .stat-box:hover {
            transform: translateY(-10px);
        }

        .stat-box h3 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 15px;
        }

        .stat-box p {
            font-size: 1.2em;
            color: #777;
            max-width: 300px;
            margin: 0 auto;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 30px 0;
            font-size: 1em;
            letter-spacing: 0.5px;
        }

        footer p {
            margin: 0;
            font-size: 1.1em;
        }

        footer a {
            color: #57ca85;
            text-decoration: none;
        }

        footer a:hover {
            color: #fff;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            
            <h1>Mind-Mend</h1>
            <p>Your Mental Health Matters</p>
            <p>A journey for support, growth, and healing.</p>
            <a href="profile1.php">
    <button id="cta-btn">Get Started</button>
</a>

        </div>
    </section>
    <!-- Call sign button -->
<div class="call-sign" onclick="togglePopup()">Need Help?</div>

<!-- Pop-up with suicide prevention number -->
<div class="popup" id="popup">
    <span class="close-btn" onclick="togglePopup()">x</span>
    Suicide Prevention Hotline: <br><strong>1-800-273-8255</strong>
</div>


    
    <section class="about">
        <h2>Why Mental Health is Important <b>?</b></h2>
        <p>
        Mental health is essential as it influences our thoughts, emotions, behaviors, and overall ability to handle life's challenges. Good mental health allows us to manage stress effectively, make sound decisions, and maintain healthy relationships. It also directly impacts productivity, enabling us to stay focused and perform well in work, school, and personal responsibilities.<br>

Physical health and mental well-being are deeply interconnected; stress, anxiety, and depression can lead to physical issues like heart disease and weakened immunity. Positive mental health, on the other hand, promotes resilience and personal growth, helping individuals set and achieve meaningful goals.<br>

When we prioritize mental health, we not only improve our own quality of life but also help reduce the stigma surrounding mental health issues. This encourages more open discussions and makes it easier for others to seek support, fostering a healthier, more understanding community.
        </p>
    </section>

    <!-- Statistics Section -->
    <section class="statistics">
        <div class="stat-box">
            <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNzMwN3wwfDF8c2VhcmNofDJ8fG1lbnRhbCUyMGhlYWx0aHxlbnwwfHx8fDE2NzAxNzYwMjU&ixlib=rb-1.2.1&q=80&w=1080" alt="Mental Health">
            <h3>1 in 5</h3>
            <p>People experience mental health issues each year worldwide.</p>
        </div>
        <div class="stat-box">
            <img src="https://images.unsplash.com/photo-1553729784-e91953dec042?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNzMwN3wwfDF8c2VhcmNofDZ8fHN1cHBvcnR8ZW58MHx8fHwxNjcwMTc2MDgy&ixlib=rb-1.2.1&q=80&w=1080" alt="Support">
            <h3>75%</h3>
            <p>Of people with mental health disorders remain untreated globally.</p>
        </div>
        <div class="stat-box">
            <img src="https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNzMwN3wwfDF8c2VhcmNofDMyfHdlbGx8ZW58MHx8fHwxNjcwMTc2MDg3&ixlib=rb-1.2.1&q=80&w=1080" alt="Well-being">
            <h3>300 Million</h3>
            <p>People suffer from depression globally, a leading cause of disability.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>2024 Mind-Mend. All rights reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
    </footer>

    <!-- JavaScript -->
    <script>
        document.getElementById('cta-btn').addEventListener('click', function() {
            alert('Thank you for choosing Mind-Mend! Let\'s start your journey.');
        });
        // Function to toggle the pop-up visibility
function togglePopup() {
    var popup = document.getElementById("popup");
    popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";
}

    </script>

</body>
</html>

