<?php
session_start();
require 'db1.php'; // Database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login1.php'); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if both 'test_name' and 'score' are present in the POST data
    if (isset($_POST['test_name']) && isset($_POST['score'])) {
        $test_name = $_POST['test_name'];  // Test name from the form
        $score = $_POST['score'];  // Test score from the form

        // Prepare the SQL query to insert data into the test_results table
        $insert_sql = "INSERT INTO test_results (user_id, test_name, score) VALUES (?, ?, ?)";

        // Prepare the statement to prevent SQL injection
        $stmt = $conn->prepare($insert_sql);

        // Bind the parameters (i = integer, s = string)
        $stmt->bind_param("isi", $user_id, $test_name, $score);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // After successful insertion, redirect to profile1.php
            header('Location: profile1.php');
            exit(); // Always call exit after redirection to stop further script execution
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Please fill in both the test name and the score.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mental Health Assessment</title>
    <style>
* {
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(to right, #a1c4fd, #c2e9fb);
    color: #333;
}

.header {
    text-align: center;
    background-color: #00796b;
    color: white;
    padding: 20px;
}

h1{
    margin: 0;
    font-size: 2.5em;
}

h2 {
    color: #00796b;
}

.test-selection {
    display: flex;
    justify-content: center;
    margin: 20px 0;
}

.test-button {
    background-color: #00796b;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    margin: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.test-button:hover {
    background-color: #004d40;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.questionnaire {
    margin-bottom: 20px;
}

.question {
    margin-bottom: 20px;
}

.label {
    font-weight: bold;
}

.button-group {
    display: flex;
    justify-content: space-between;
}

.button-group input[type="radio"] {
    margin-right: 10px;
}

span {
    background: #b3e5fc;
    border-radius: 4px;
    padding: 10px;
    transition: background 0.3s;
}

.button-group input[type="radio"]:checked + span {
    background: #00796b;
    color: white;
}

.submit-button {
    background-color: #00796b;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.submit-button:hover {
    background-color: #004d40;
}

.results {
    text-align: center;
    margin-top: 20px;
}
.click-here {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: orange;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            margin-top:4% ;
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
    
    <div class="header">
        <h1>Mental Health Self-Assessment</h1>
        <h3>To access your profile click here<span class="click-here"><a href="profile1.php">Click Here</a></span></h3>
        
        
        <p>Select a test below to begin your assessment</p>
    </div>
    

    <div class="test-selection">
        <button class="test-button" onclick="showTest('depression')">Take Depression Test</button>
        <button class="test-button" onclick="showTest('postpartum')">Take Postpartum Depression Test</button>
        <button class="test-button" onclick="showTest('anxiety')">Take Anxiety Test</button>
        <button class="test-button" onclick="showTest('adhd')">Take ADHD Test</button>
        <button class="test-button" onclick="showTest('bipolar')">Take Bipolar Disorder Test</button>
        <button class="test-button" onclick="showTest('psychosis')">Take Psychosis Test</button>
        <button class="test-button" onclick="showTest('ptsd')">Take PTSD Test</button>
        <button class="test-button" onclick="showTest('eating')">Take Eating Disorder Test</button>
        <button class="test-button" onclick="showTest('addiction')">Take Addiction Test</button>
        <button class="test-button" onclick="showTest('youth')">Take Youth Mental Health Test</button>
    </div>

    <div class="container">
        
        <form id="depression" class="questionnaire" style="display:none">
            <h2>Depression Test</h2>
            <div class="question">
                <label>1. Little interest or pleasure in doing things:</label>
                <div class="button-group">
                    <input type="radio" name="depression_q1" value="0" required> <span>Not at all</span>
                    <input type="radio" name="depression_q1" value="1"> <span>Several days</span>
                    <input type="radio" name="depression_q1" value="2"> <span>More than half the days</span>
                    <input type="radio" name="depression_q1" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>2. Feeling down, depressed, or hopeless:</label>
                <div class="button-group">
                    <input type="radio" name="depression_q2" value="0" required> <span>Not at all</span>
                    <input type="radio" name="depression_q2" value="1"> <span>Several days</span>
                    <input type="radio" name="depression_q2" value="2"> <span>More than half the days</span>
                    <input type="radio" name="depression_q2" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>3. Trouble falling or staying asleep, or sleeping too much:</label>
                <div class="button-group">
                    <input type="radio" name="depression_q3" value="0" required> <span>Not at all</span>
                    <input type="radio" name="depression_q3" value="1"> <span>Several days</span>
                    <input type="radio" name="depression_q3" value="2"> <span>More than half the days</span>
                    <input type="radio" name="depression_q3" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>4. Feeling tired or having little energy:</label>
                <div class="button-group">
                    <input type="radio" name="depression_q4" value="0" required> <span>Not at all</span>
                    <input type="radio" name="depression_q4" value="1"> <span>Several days</span>
                    <input type="radio" name="depression_q4" value="2"> <span>More than half the days</span>
                    <input type="radio" name="depression_q4" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>5. Poor appetite or overeating:</label>
                <div class="button-group">
                    <input type="radio" name="depression_q5" value="0" required> <span>Not at all</span>
                    <input type="radio" name="depression_q5" value="1"> <span>Several days</span>
                    <input type="radio" name="depression_q5" value="2"> <span>More than half the days</span>
                    <input type="radio" name="depression_q5" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>6. Feeling bad about yourself - or that you are a failure or have let yourself or your family down:</label>
                <div class="button-group">
                    <input type="radio" name="depression_q6" value="0" required> <span>Not at all</span>
                    <input type="radio" name="depression_q6" value="1"> <span>Several days</span>
                    <input type="radio" name="depression_q6" value="2"> <span>More than half the days</span>
                    <input type="radio" name="depression_q6" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>7. Trouble concentrating on things, such as reading the newspaper or watching television:</label>
                <div class="button-group">
                    <input type="radio" name="depression_q7" value="0" required> <span>Not at all</span>
                    <input type="radio" name="depression_q7" value="1"> <span>Several days</span>
                    <input type="radio" name="depression_q7" value="2"> <span>More than half the days</span>
                    <input type="radio" name="depression_q7" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>8. Moving or speaking so slowly that other people could have noticed, or the opposite - being so fidgety or restless that you have been moving around a lot more than usual:</label>
                <div class="button-group">
                    <input type="radio" name="depression_q8" value="0" required> <span>Not at all</span>
                    <input type="radio" name="depression_q8" value="1"> <span>Several days</span>
                    <input type="radio" name="depression_q8" value="2"> <span>More than half the days</span>
                    <input type="radio" name="depression_q8" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>9. Thoughts that you would be better off dead, or of hurting yourself:</label>
                <div class="button-group">
                    <input type="radio" name="depression_q9" value="0" required> <span>Not at all</span>
                    <input type="radio" name="depression_q9" value="1"> <span>Several days</span>
                    <input type="radio" name="depression_q9" value="2"> <span>More than half the days</span>
                    <input type="radio" name="depression_q9" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <input type="submit" value="Submit" class="submit-button" onclick="evaluateTest('depression')">
        </form>

        <form id="postpartum" class="questionnaire" style="display:none">
            <h2>Postpartum Depression Test</h2>
            <div class="question">
                <label>1. I have been able to laugh and see the funny side of things:</label>
                <div class="button-group">
                    <input type="radio" name="postpartum_q1" value="0" required> <span>As much as I always could</span>
                    <input type="radio" name="postpartum_q1" value="1"> <span>Not quite so much now</span>
                    <input type="radio" name="postpartum_q1" value="2"> <span>Definitely not so much now</span>
                    <input type="radio" name="postpartum_q1" value="3"> <span>Not at all</span>
                </div>
            </div>
            <div class="question">
                <label>2. I have looked forward with enjoyment to things:</label>
                <div class="button-group">
                    <input type="radio" name="postpartum_q2" value="0" required> <span>As much as I ever did</span>
                    <input type="radio" name="postpartum_q2" value="1"> <span>Rather less than I used to</span>
                    <input type="radio" name="postpartum_q2" value="2"> <span>Definitely less than I used to</span>
                    <input type="radio" name="postpartum_q2" value="3"> <span>Hardly at all</span>
                </div>
            </div>
            <div class="question">
                <label>3. I have blamed myself unnecessarily when things went wrong:</label>
                <div class="button-group">
                    <input type="radio" name="postpartum_q3" value="0" required> <span>No, never</span>
                    <input type="radio" name="postpartum_q3" value="1"> <span>Not very often</span>
                    <input type="radio" name="postpartum_q3" value="2"> <span>Yes, some of the time</span>
                    <input type="radio" name="postpartum_q3" value="3"> <span>Yes, most of the time</span>
                </div>
            </div>
            <div class="question">
                <label>4. I have been anxious or worried for no good reason:</label>
                <div class="button-group">
                    <input type="radio" name="postpartum_q4" value="0" required> <span>No, not at all</span>
                    <input type="radio" name="postpartum_q4" value="1"> <span>Hardly ever</span>
                    <input type="radio" name="postpartum_q4" value="2"> <span>Yes, sometimes</span>
                    <input type="radio" name="postpartum_q4" value="3"> <span>Yes, very often</span>
                </div>
            </div>
            <div class="question">
                <label>5. I have felt scared or panicky for no very good reason:</label>
                <div class="button-group">
                    <input type="radio" name="postpartum_q5" value="0" required> <span>No, not at all</span>
                    <input type="radio" name="postpartum_q5" value="1"> <span>No, not much</span>
                    <input type="radio" name="postpartum_q5" value="2"> <span>Yes, sometimes</span>
                    <input type="radio" name="postpartum_q5" value="3"> <span>Yes, quite a lot</span>
                </div>
            </div>
            <div class="question">
                <label>6. Things have been getting on top of me:</label>
                <div class="button-group">
                    <input type="radio" name="postpartum_q6" value="0" required> <span>No, I have been coping as well as ever</span>
                    <input type="radio" name="postpartum_q6" value="1"> <span>No, most of the time I have coped quite well</span>
                    <input type="radio" name="postpartum_q6" value="2"> <span>Yes, sometimes I haven't been coping as well as usual</span>
                    <input type="radio" name="postpartum_q6" value="3"> <span>Yes, most of the time I haven't been able to cope at all</span>
                </div>
            </div>
            <div class="question">
                <label>7. I have been so unhappy that I have had difficulty sleeping:</label>
                <div class="button-group">
                    <input type="radio" name="postpartum_q7" value="0" required> <span>No, not at all</span>
                    <input type="radio" name="postpartum_q7" value="1"> <span>Not very often</span>
                    <input type="radio" name="postpartum_q7" value="2"> <span>Yes, sometimes</span>
                    <input type="radio" name="postpartum_q7" value="3"> <span>Yes, most of the time</span>
                </div>
            </div>
            <div class="question">
                <label>8. I have felt sad or miserable:</label>
                <div class="button-group">
                    <input type="radio" name="postpartum_q8" value="0" required> <span>No, not at all</span>
                    <input type="radio" name="postpartum_q8" value="1"> <span>Not very often</span>
                    <input type="radio" name="postpartum_q8" value="2"> <span>Yes, quite often</span>
                    <input type="radio" name="postpartum_q8" value="3"> <span>Yes, most of the time</span>
                </div>
            </div>
            <div class="question">
                <label>9. I have been so unhappy that I have been crying:</label>
                <div class="button-group">
                    <input type="radio" name="postpartum_q9" value="0" required> <span>No, never</span>
                    <input type="radio" name="postpartum_q9" value="1"> <span>Only occasionally</span>
                    <input type="radio" name="postpartum_q9" value="2"> <span>Yes, quite often</span>
                    <input type="radio" name="postpartum_q9" value="3"> <span>Yes, most of the time</span>
                </div>
            </div>
            <div class="question">
                <label>10. The thought of harming myself has occurred to me:</label>
                <div class="button-group">
                    <input type="radio" name="postpartum_q10" value="0" required> <span>Never</span>
                    <input type="radio" name="postpartum_q10" value="1"> <span>Hardly ever</span>
                    <input type="radio" name="postpartum_q10" value="2"> <span>Sometimes</span>
                    <input type="radio" name="postpartum_q10" value="3"> <span>Yes, quite often</span>
                </div>
            </div>
            <input type="submit" value="Submit" class="submit-button" onclick="evaluateTest('postpartum')">
        </form>

        <!-- Anxiety Test -->
        <form id="anxiety" class="questionnaire" style="display:none">
            <h2>Anxiety Test</h2>
            <div class="question">
                <label>1. Feeling nervous, anxious, or on edge:</label>
                <div class="button-group">
                    <input type="radio" name="anxiety_q1" value="0" required> <span>Not at all</span>
                    <input type="radio" name="anxiety_q1" value="1"> <span>Several days</span>
                    <input type="radio" name="anxiety_q1" value="2"> <span>More than half the days</span>
                    <input type="radio" name="anxiety_q1" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>2. Not being able to stop or control worrying:</label>
                <div class="button-group">
                    <input type="radio" name="anxiety_q2" value="0" required> <span>Not at all</span>
                    <input type="radio" name="anxiety_q2" value="1"> <span>Several days</span>
                    <input type="radio" name="anxiety_q2" value="2"> <span>More than half the days</span>
                    <input type="radio" name="anxiety_q2" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>3. Worrying too much about different things:</label>
                <div class="button-group">
                    <input type="radio" name="anxiety_q3" value="0" required> <span>Not at all</span>
                    <input type="radio" name="anxiety_q3" value="1"> <span>Several days</span>
                    <input type="radio" name="anxiety_q3" value="2"> <span>More than half the days</span>
                    <input type="radio" name="anxiety_q3" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>4. Trouble relaxing:</label>
                <div class="button-group">
                    <input type="radio" name="anxiety_q4" value="0" required> <span>Not at all</span>
                    <input type="radio" name="anxiety_q4" value="1"> <span>Several days</span>
                    <input type="radio" name="anxiety_q4" value="2"> <span>More than half the days</span>
                    <input type="radio" name="anxiety_q4" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>5. Being so restless that it is hard to sit still:</label>
                <div class="button-group">
                    <input type="radio" name="anxiety_q5" value="0" required> <span>Not at all</span>
                    <input type="radio" name="anxiety_q5" value="1"> <span>Several days</span>
                    <input type="radio" name="anxiety_q5" value="2"> <span>More than half the days</span>
                    <input type="radio" name="anxiety_q5" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>6. Becoming easily annoyed or irritable:</label>
                <div class="button-group">
                    <input type="radio" name="anxiety_q6" value="0" required> <span>Not at all</span>
                    <input type="radio" name="anxiety_q6" value="1"> <span>Several days</span>
                    <input type="radio" name="anxiety_q6" value="2"> <span>More than half the days</span>
                    <input type="radio" name="anxiety_q6" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>7. Feeling afraid, as if something awful might happen:</label>
                <div class="button-group">
                    <input type="radio" name="anxiety_q7" value="0" required> <span>Not at all</span>
                    <input type="radio" name="anxiety_q7" value="1"> <span>Several days</span>
                    <input type="radio" name="anxiety_q7" value="2"> <span>More than half the days</span>
                    <input type="radio" name="anxiety_q7" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <input type="submit" value="Submit" class="submit-button" onclick="evaluateTest('anxiety')">
        </form>

        <!-- ADHD Test -->
        <form id="adhd" class="questionnaire" style="display:none">
            <h2>ADHD Test</h2>
            <div class="question">
                <label>1. How often do you have trouble wrapping up the final details of a project, once the challenging parts have been done?</label>
                <div class="button-group">
                    <input type="radio" name="adhd_q1" value="0" required> <span>Never</span>
                    <input type="radio" name="adhd_q1" value="1"> <span>Rarely</span>
                    <input type="radio" name="adhd_q1" value="2"> <span>Sometimes</span>
                    <input type="radio" name="adhd_q1" value="3"> <span>Often</span>
                    <input type="radio" name="adhd_q1" value="4"> <span>Very Often</span>
                </div>
            </div>
            <div class="question">
                <label>2. How often do you have difficulty getting things in order when you have to do a task that requires organization?</label>
                <div class="button-group">
                    <input type="radio" name="adhd_q2" value="0" required> <span>Never</span>
                    <input type="radio" name="adhd_q2" value="1"> <span>Rarely</span>
                    <input type="radio" name="adhd_q2" value="2"> <span>Sometimes</span>
                    <input type="radio" name="adhd_q2" value="3"> <span>Often</span>
                    <input type="radio" name="adhd_q2" value="4"> <span>Very Often</span>
                </div>
            </div>
            <div class="question">
                <label>3. How often do you have problems remembering appointments or obligations?</label>
                <div class="button-group">
                    <input type="radio" name="adhd_q3" value="0" required> <span>Never</span>
                    <input type="radio" name="adhd_q3" value="1"> <span>Rarely</span>
                    <input type="radio" name="adhd_q3" value="2"> <span>Sometimes</span>
                    <input type="radio" name="adhd_q3" value="3"> <span>Often</span>
                    <input type="radio" name="adhd_q3" value="4"> <span>Very Often</span>
                </div>
            </div>
            <div class="question">
                <label>4. When you have a task that requires a lot of thought, how often do you avoid or delay getting started?</label>
                <div class="button-group">
                    <input type="radio" name="adhd_q4" value="0" required> <span>Never</span>
                    <input type="radio" name="adhd_q4" value="1"> <span>Rarely</span>
                    <input type="radio" name="adhd_q4" value="2"> <span>Sometimes</span>
                    <input type="radio" name="adhd_q4" value="3"> <span>Often</span>
                    <input type="radio" name="adhd_q4" value="4"> <span>Very Often</span>
                </div>
            </div>
            <div class="question">
                <label>5. How often do you fidget or squirm with your hands or feet when you have to sit down for a long time?</label>
                <div class="button-group">
                    <input type="radio" name="adhd_q5" value="0" required> <span>Never</span>
                    <input type="radio" name="adhd_q5" value="1"> <span>Rarely</span>
                    <input type="radio" name="adhd_q5" value="2"> <span>Sometimes</span>
                    <input type="radio" name="adhd_q5" value="3"> <span>Often</span>
                    <input type="radio" name="adhd_q5" value="4"> <span>Very Often</span>
                </div>
            </div>
            <div class="question">
                <label>6. How often do you feel overly active and compelled to do things, like you were driven by a motor?</label>
                <div class="button-group">
                    <input type="radio" name="adhd_q6" value="0" required> <span>Never</span>
                    <input type="radio" name="adhd_q6" value="1"> <span>Rarely</span>
                    <input type="radio" name="adhd_q6" value="2"> <span>Sometimes</span>
                    <input type="radio" name="adhd_q6" value="3"> <span>Often</span>
                    <input type="radio" name="adhd_q6" value="4"> <span>Very Often</span>
                </div>
            </div>
            <input type="submit" value="Submit" class="submit-button" onclick="evaluateTest('adhd')">
        </form>

               <!-- Bipolar Test -->
        <form id="bipolar" class="questionnaire" style="display:none">
            <h2>Bipolar Disorder Test</h2>
            <div class="question">
                <label>1. Have you ever experienced a period of time when you were so full of energy that you couldn't sit still?</label>
                <div class="button-group">
                    <input type="radio" name="bipolar_q1" value="0" required> <span>Never</span>
                    <input type="radio" name="bipolar_q1" value="1"> <span>Rarely</span>
                    <input type="radio" name="bipolar_q1" value="2"> <span>Sometimes</span>
                    <input type="radio" name="bipolar_q1" value="3"> <span>Often</span>
                    <input type="radio" name="bipolar_q1" value="4"> <span>Very Often</span>
                </div>
            </div>
            <div class="question">
                <label>2. Have you ever had periods of being so irritable that you could not control your temper?</label>
                <div class="button-group">
                    <input type="radio" name="bipolar_q2" value="0" required> <span>Never</span>
                    <input type="radio" name="bipolar_q2" value="1"> <span>Rarely</span>
                    <input type="radio" name="bipolar_q2" value="2"> <span>Sometimes</span>
                    <input type="radio" name="bipolar_q2" value="3"> <span>Often</span>
                    <input type="radio" name="bipolar_q2" value="4"> <span>Very Often</span>
                </div>
            </div>
            <div class="question">
                <label>3. Have you ever experienced racing thoughts or felt like your mind was going a mile a minute?</label>
                <div class="button-group">
                    <input type="radio" name="bipolar_q3" value="0" required> <span>Never</span>
                    <input type="radio" name="bipolar_q3" value="1"> <span>Rarely</span>
                    <input type="radio" name="bipolar_q3" value="2"> <span>Sometimes</span>
                    <input type="radio" name="bipolar_q3" value="3"> <span>Often</span>
                    <input type="radio" name="bipolar_q3" value="4"> <span>Very Often</span>
                </div>
            </div>
            <div class="question">
                <label>4. Have you ever felt overly confident about your abilities and done things you later regretted?</label>
                <div class="button-group">
                    <input type="radio" name="bipolar_q4" value="0" required> <span>Never</span>
                    <input type="radio" name="bipolar_q4" value="1"> <span>Rarely</span>
                    <input type="radio" name="bipolar_q4" value="2"> <span>Sometimes</span>
                    <input type="radio" name="bipolar_q4" value="3"> <span>Often</span>
                    <input type="radio" name="bipolar_q4" value="4"> <span>Very Often</span>
                </div>
            </div>
            <div class="question">
                <label>5. Have you ever felt that you needed less sleep than usual and still felt rested?</label>
                <div class="button-group">
                    <input type="radio" name="bipolar_q5" value="0" required> <span>Never</span>
                    <input type="radio" name="bipolar_q5" value="1"> <span>Rarely</span>
                    <input type="radio" name="bipolar_q5" value="2"> <span>Sometimes</span>
                    <input type="radio" name="bipolar_q5" value="3"> <span>Often</span>
                    <input type="radio" name="bipolar_q5" value="4"> <span>Very Often</span>
                </div>
            </div>
            <input type="submit" value="Submit" class="submit-button" onclick="evaluateTest('bipolar')">
        </form>

        <!-- Psychosis Test -->
        <form id="psychosis" class="questionnaire" style="display:none">
            <h2>Psychosis Test</h2>
            <div class="question">
                <label>1. Have you ever heard voices that other people could not hear?</label>
                <div class="button-group">
                    <input type="radio" name="psychosis_q1" value="0" required> <span>Never</span>
                    <input type="radio" name="psychosis_q1" value="1"> <span>Rarely</span>
                    <input type="radio" name="psychosis_q1" value="2"> <span>Sometimes</span>
                    <input type="radio" name="psychosis_q1" value="3"> <span>Often</span>
                    <input type="radio" name="psychosis_q1" value="4"> <span>Very Often</span>
                </div>
            </div>
            <div class="question">
                <label>2. Have you ever felt that people were watching you or talking about you?</label>
                <div class="button-group">
                    <input type="radio" name="psychosis_q2" value="0" required> <span>Never</span>
                    <input type="radio" name="psychosis_q2" value="1"> <span>Rarely</span>
                    <input type="radio" name="psychosis_q2" value="2"> <span>Sometimes</span>
                    <input type="radio" name="psychosis_q2" value="3"> <span>Often</span>
                    <input type="radio" name="psychosis_q2" value="4"> <span>Very Often</span>
                </div>
            </div>
            <div class="question">
                <label>3. Have you ever felt that you were under some kind of control, or that something was influencing your thoughts?</label>
                <div class="button-group">
                    <input type="radio" name="psychosis_q3" value="0" required> <span>Never</span>
                    <input type="radio" name="psychosis_q3" value="1"> <span>Rarely</span>
                    <input type="radio" name="psychosis_q3" value="2"> <span>Sometimes</span>
                    <input type="radio" name="psychosis_q3" value="3"> <span>Often</span>
                    <input type="radio" name="psychosis_q3" value="4"> <span>Very Often</span>
                </div>
            </div>
            <div class="question">
                <label>4. Have you ever felt that something was very real but later realized it wasn't?</label>
                <div class="button-group">
                    <input type="radio" name="psychosis_q4" value="0" required> <span>Never</span>
                    <input type="radio" name="psychosis_q4" value="1"> <span>Rarely</span>
                    <input type="radio" name="psychosis_q4" value="2"> <span>Sometimes</span>
                    <input type="radio" name="psychosis_q4" value="3"> <span>Often</span>
                    <input type="radio" name="psychosis_q4" value="4"> <span>Very Often</span>
                </div>
            </div>
            <div class="question">
                <label>5. Have you ever had thoughts that others might be plotting against you?</label>
                <div class="button-group">
                    <input type="radio" name="psychosis_q5" value="0" required> <span>Never</span>
                    <input type="radio" name="psychosis_q5" value="1"> <span>Rarely</span>
                    <input type="radio" name="psychosis_q5" value="2"> <span>Sometimes</span>
                    <input type="radio" name="psychosis_q5" value="3"> <span>Often</span>
                    <input type="radio" name="psychosis_q5" value="4"> <span>Very Often</span>
                </div>
            </div>
            <input type="submit" value="Submit" class="submit-button" onclick="evaluateTest('psychosis')">
        </form>

        <!-- PTSD Test -->
        <form id="ptsd" class="questionnaire" style="display:none">
            <h2>PTSD Test</h2>
            <div class="question">
                <label>1. Have you experienced or witnessed a traumatic event?</label>
                <div class="button-group">
                    <input type="radio" name="ptsd_q1" value="0" required> <span>No</span>
                    <input type="radio" name="ptsd_q1" value="1"> <span>Yes</span>
                </div>
            </div>
            <div class="question">
                <label>2. Do you have recurrent, involuntary memories of the traumatic event?</label>
                <div class="button-group">
                    <input type="radio" name="ptsd_q2" value="0" required> <span>No</span>
                    <input type="radio" name="ptsd_q2" value="1"> <span>Yes</span>
                </div>
            </div>
            <div class="question">
                <label>3. Do you experience distressing dreams related to the traumatic event?</label>
                <div class="button-group">
                    <input type="radio" name="ptsd_q3" value="0" required> <span>No</span>
                    <input type="radio" name="ptsd_q3" value="1"> <span>Yes</span>
                </div>
            </div>
            <div class="question">
                <label>4. Do you experience flashbacks or feel as though the event is happening again?</label>
                <div class="button-group">
                    <input type="radio" name="ptsd_q4" value="0" required> <span>No</span>
                    <input type="radio" name="ptsd_q4" value="1"> <span>Yes</span>
                </div>
            </div>
            <div class="question">
                <label>5. Do you avoid reminders of the traumatic event?</label>
                <div class="button-group">
                    <input type="radio" name="ptsd_q5" value="0" required> <span>No</span>
                    <input type="radio" name="ptsd_q5" value="1"> <span>Yes</span>
                </div>
            </div>
            <div class="question">
    <label>6. Do you feel emotionally numb or detached from others?</label>
    <div class="button-group">
        <input type="radio" name="ptsd_q6" value="0" required> <span>No</span>
        <input type="radio" name="ptsd_q6" value="1"> <span>Yes</span>
    </div>
</div>
<div class="question">
    <label>7. Do you have difficulty remembering important parts of the traumatic event?</label>
    <div class="button-group">
        <input type="radio" name="ptsd_q7" value="0" required> <span>No</span>
        <input type="radio" name="ptsd_q7" value="1"> <span>Yes</span>
    </div>
</div>
<div class="question">
    <label>8. Do you feel irritable or have outbursts of anger?</label>
    <div class="button-group">
        <input type="radio" name="ptsd_q8" value="0" required> <span>No</span>
        <input type="radio" name="ptsd_q8" value="1"> <span>Yes</span>
    </div>
</div>
<div class="question">
    <label>9. Do you feel constantly on guard or easily startled?</label>
    <div class="button-group">
        <input type="radio" name="ptsd_q9" value="0" required> <span>No</span>
        <input type="radio" name="ptsd_q9" value="1"> <span>Yes</span>
    </div>
</div>
<div class="question">
    <label>10. Do you have difficulty sleeping due to thoughts about the trauma?</label>
    <div class="button-group">
        <input type="radio" name="ptsd_q10" value="0" required> <span>No</span>
        <input type="radio" name="ptsd_q10" value="1"> <span>Yes</span>
    </div>
</div>
            <input type="submit" value="Submit" class="submit-button" onclick="evaluateTest('ptsd')">
        </form>
       


        <!-- Eating Disorder Test -->
        <form id="eating" class="questionnaire" style="display:none">
            <h2>Eating Disorder Test</h2>
            <div class="question">
                <label>1. Do you often think about food, dieting, and weight?</label>
                <div class="button-group">
                    <input type="radio" name="eating_q1" value="0" required> <span>No</span>
                    <input type="radio" name="eating_q1" value="1"> <span>Yes</span>
                </div>
            </div>
            <div class="question">
                <label>2. Do you eat in secret or hide food?</label>
                <div class="button-group">
                    <input type="radio" name="eating_q2" value="0" required> <span>No</span>
                    <input type="radio" name="eating_q2" value="1"> <span>Yes</span>
                </div>
            </div>
            <div class="question">
                <label>3. Do you frequently feel guilty about eating?</label>
                <div class="button-group">
                    <input type="radio" name="eating_q3" value="0" required> <span>No</span>
                    <input type="radio" name="eating_q3" value="1"> <span>Yes</span>
                </div>
            </div>
            <div class="question">
                <label>4. Do you restrict your food intake to prevent weight gain?</label>
                <div class="button-group">
                    <input type="radio" name="eating_q4" value="0" required> <span>No</span>
                    <input type="radio" name="eating_q4" value="1"> <span>Yes</span>
                </div>
            </div>
            <div class="question">
                <label>5. Do you have a fear of gaining weight?</label>
                <div class="button-group">
                    <input type="radio" name="eating_q5" value="0" required> <span>No</span>
                    <input type="radio" name="eating_q5" value="1"> <span>Yes</span>
                </div>
            </div>
            <div class="question">
    <label>6. Do you find it difficult to stop eating once you start?</label>
    <div class="button-group">
        <input type="radio" name="eating_q6" value="0" required> <span>No</span>
        <input type="radio" name="eating_q6" value="1"> <span>Yes</span>
    </div>
</div>
<div class="question">
    <label>7. Do you feel distressed after eating large amounts of food?</label>
    <div class="button-group">
        <input type="radio" name="eating_q7" value="0" required> <span>No</span>
        <input type="radio" name="eating_q7" value="1"> <span>Yes</span>
    </div>
</div>
<div class="question">
    <label>8. Do you use exercise, fasting, or other means to "make up" for eating?</label>
    <div class="button-group">
        <input type="radio" name="eating_q8" value="0" required> <span>No</span>
        <input type="radio" name="eating_q8" value="1"> <span>Yes</span>
    </div>
</div>
<div class="question">
    <label>9. Do you avoid eating in front of others due to embarrassment?</label>
    <div class="button-group">
        <input type="radio" name="eating_q9" value="0" required> <span>No</span>
        <input type="radio" name="eating_q9" value="1"> <span>Yes</span>
    </div>
</div>
<div class="question">
    <label>10. Do you experience stress or anxiety that affects your eating habits?</label>
    <div class="button-group">
        <input type="radio" name="eating_q10" value="0" required> <span>No</span>
        <input type="radio" name="eating_q10" value="1"> <span>Yes</span>
    </div>
</div>

            <input type="submit" value="Submit" class="submit-button" onclick="evaluateTest('eating')">
        </form>

        <!-- Addiction Test -->
        <form id="addiction" class="questionnaire" style="display:none">
            <h2>Addiction Test</h2>
            <div class="question">
                <label>1. Have you ever felt you should cut down on your drinking or drug use?</label>
                <div class="button-group">
                    <input type="radio" name="addiction_q1" value="0" required> <span>No</span>
                    <input type="radio" name="addiction_q1" value="1"> <span>Yes</span>
                </div>
            </div>
            <div class="question">
                <label>2. Have people annoyed you by criticizing your drinking or drug use?</label>
                <div class="button-group">
                    <input type="radio" name="addiction_q2" value="0" required> <span>No</span>
                    <input type="radio" name="addiction_q2" value="1"> <span>Yes</span>
                </div>
            </div>
            <div class="question">
                <label>3. Have you ever felt guilty about your drinking or drug use?</label>
                <div class="button-group">
                    <input type="radio" name="addiction_q3" value="0" required> <span>No</span>
                    <input type="radio" name="addiction_q3" value="1"> <span>Yes</span>
                </div>
            </div>
            <div class="question">
                <label>4. Have you ever felt you could handle your drinking or drug use better than others?</label>
                <div class="button-group">
                    <input type="radio" name="addiction_q4" value="0" required> <span>No</span>
                    <input type="radio" name="addiction_q4" value="1"> <span>Yes</span>
                </div>
            </div>
            <div class="question">
                <label>5. Have you ever had a drink or used drugs first thing in the morning to steady your nerves or get rid of a hangover?</label>
                <div class="button-group">
                    <input type="radio" name="addiction_q5" value="0" required> <span>No</span>
                    <input type="radio" name="addiction_q5" value="1"> <span>Yes</span>
                </div>
            </div>
            <div class="question">
    <label>6. Have you ever neglected responsibilities because of drinking or drug use?</label>
    <div class="button-group">
        <input type="radio" name="addiction_q6" value="0" required> <span>No</span>
        <input type="radio" name="addiction_q6" value="1"> <span>Yes</span>
    </div>
</div>
<div class="question">
    <label>7. Have you tried to stop or reduce your use but found you couldn’t?</label>
    <div class="button-group">
        <input type="radio" name="addiction_q7" value="0" required> <span>No</span>
        <input type="radio" name="addiction_q7" value="1"> <span>Yes</span>
    </div>
</div>
<div class="question">
    <label>8. Have you ever lost interest in hobbies or activities because of substance use?</label>
    <div class="button-group">
        <input type="radio" name="addiction_q8" value="0" required> <span>No</span>
        <input type="radio" name="addiction_q8" value="1"> <span>Yes</span>
    </div>
</div>
<div class="question">
    <label>9. Have you found yourself using more over time to get the same effect?</label>
    <div class="button-group">
        <input type="radio" name="addiction_q9" value="0" required> <span>No</span>
        <input type="radio" name="addiction_q9" value="1"> <span>Yes</span>
    </div>
</div>
<div class="question">
    <label>10. Have you continued using substances despite knowing it causes problems in your life?</label>
    <div class="button-group">
        <input type="radio" name="addiction_q10" value="0" required> <span>No</span>
        <input type="radio" name="addiction_q10" value="1"> <span>Yes</span>
    </div>
</div>

            <input type="submit" value="Submit" class="submit-button" onclick="evaluateTest('addiction')">
        </form>
<!-- Call sign button -->
<div class="call-sign" onclick="togglePopup()">Need Help?</div>

<!-- Pop-up with suicide prevention number -->
<div class="popup" id="popup">
    <span class="close-btn" onclick="togglePopup()">x</span>
    Suicide Prevention Hotline: <br><strong>1-800-273-8255</strong>
</div>

        <!-- Youth Mental Health Test -->
        <form id="youth" class="questionnaire" style="display:none">
            <h2>Youth Mental Health Test</h2>
            <div class="question">
                <label>1. How often do you feel sad or hopeless?</label>
                <div class="button-group">
                    <input type="radio" name="youth_q1" value="0" required> <span>Not at all</span>
                    <input type="radio" name="youth_q1" value="1"> <span>Several days</span>
                    <input type="radio" name="youth_q1" value="2"> <span>More than half the days</span>
                    <input type="radio" name="youth_q1" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>2. How often do you have trouble sleeping, or sleep too much?</label>
                <div class="button-group">
                    <input type="radio" name="youth_q2" value="0" required> <span>Not at all</span>
                    <input type="radio" name="youth_q2" value="1"> <span>Several days</span>
                    <input type="radio" name="youth_q2" value="2"> <span>More than half the days</span>
                    <input type="radio" name="youth_q2" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>3. How often do you feel angry or irritable?</label>
                <div class="button-group">
                    <input type="radio" name="youth_q3" value="0" required> <span>Not at all</span>
                    <input type="radio" name="youth_q3" value="1"> <span>Several days</span>
                    <input type="radio" name="youth_q3" value="2"> <span>More than half the days</span>
                    <input type="radio" name="youth_q3" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>4. How often do you feel anxious or worried?</label>
                <div class="button-group">
                    <input type="radio" name="youth_q4" value="0" required> <span>Not at all</span>
                    <input type="radio" name="youth_q4" value="1"> <span>Several days</span>
                    <input type="radio" name="youth_q4" value="2"> <span>More than half the days</span>
                    <input type="radio" name="youth_q4" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
                <label>5. How often do you have trouble concentrating on things, such as schoolwork or homework?</label>
                <div class="button-group">
                    <input type="radio" name="youth_q5" value="0" required> <span>Not at all</span>
                    <input type="radio" name="youth_q5" value="1"> <span>Several days</span>
                    <input type="radio" name="youth_q5" value="2"> <span>More than half the days</span>
                    <input type="radio" name="youth_q5" value="3"> <span>Nearly every day</span>
                </div>
            </div>
            <div class="question">
    <label>6. How often do you feel like you're not good enough?</label>
    <div class="button-group">
        <input type="radio" name="youth_q6" value="0" required> <span>Not at all</span>
        <input type="radio" name="youth_q6" value="1"> <span>Several days</span>
        <input type="radio" name="youth_q6" value="2"> <span>More than half the days</span>
        <input type="radio" name="youth_q6" value="3"> <span>Nearly every day</span>
    </div>
</div>
<div class="question">
    <label>7. How often do you lose interest in activities you used to enjoy?</label>
    <div class="button-group">
        <input type="radio" name="youth_q7" value="0" required> <span>Not at all</span>
        <input type="radio" name="youth_q7" value="1"> <span>Several days</span>
        <input type="radio" name="youth_q7" value="2"> <span>More than half the days</span>
        <input type="radio" name="youth_q7" value="3"> <span>Nearly every day</span>
    </div>
</div>
<div class="question">
    <label>8. How often do you feel overwhelmed or stressed out?</label>
    <div class="button-group">
        <input type="radio" name="youth_q8" value="0" required> <span>Not at all</span>
        <input type="radio" name="youth_q8" value="1"> <span>Several days</span>
        <input type="radio" name="youth_q8" value="2"> <span>More than half the days</span>
        <input type="radio" name="youth_q8" value="3"> <span>Nearly every day</span>
    </div>
</div>
<div class="question">
    <label>9. How often do you feel like withdrawing from friends or family?</label>
    <div class="button-group">
        <input type="radio" name="youth_q9" value="0" required> <span>Not at all</span>
        <input type="radio" name="youth_q9" value="1"> <span>Several days</span>
        <input type="radio" name="youth_q9" value="2"> <span>More than half the days</span>
        <input type="radio" name="youth_q9" value="3"> <span>Nearly every day</span>
    </div>
</div>
<div class="question">
    <label>10. How often do you feel physical symptoms like headaches or stomachaches related to stress?</label>
    <div class="button-group">
        <input type="radio" name="youth_q10" value="0" required> <span>Not at all</span>
        <input type="radio" name="youth_q10" value="1"> <span>Several days</span>
        <input type="radio" name="youth_q10" value="2"> <span>More than half the days</span>
        <input type="radio" name="youth_q10" value="3"> <span>Nearly every day</span>
    </div>
</div>

            <input type="submit" value="Submit" class="submit-button" onclick="evaluateTest('youth')">
        </form>

        <div class="results" id="results"></div>
    </div>

<script>
function showTest(testName) {
    const tests = document.querySelectorAll('.questionnaire');
    tests.forEach(test => {
        test.style.display = 'none'; // Hide all tests
    });
    document.getElementById(testName).style.display = 'block'; // Show selected test
    document.getElementById('results').innerHTML = ''; // Clear previous results
}

function evaluateTest(testName) {
    event.preventDefault();
    const formData = new FormData(document.getElementById(testName));
    let score = 0;

    for (let value of formData.values()) {
        score += parseInt(value);
    }

    let conclusion = '';
    switch (testName) {
        case 'depression':
            conclusion = getDepressionConclusion(score);
            break;
        case 'postpartum':
            conclusion = getPostpartumConclusion(score);
            break;
        case 'anxiety':
            conclusion = getAnxietyConclusion(score);
            break;
        case 'adhd':
            conclusion = getAdhdConclusion(score);
            break;
        case 'bipolar':
            conclusion = getBipolarConclusion(score);
            break;
        case 'psychosis':
            conclusion = getPsychosisConclusion(score);
            break;
        case 'ptsd':
            conclusion = getPTSDConclusion(score);
            break;
        case 'eating':
            conclusion = getEatingConclusion(score);
            break;
        case 'addiction':
            conclusion = getAddictionConclusion(score);
            break;
        case 'youth':
            conclusion = getYouthConclusion(score);
            break;
    }

    document.getElementById('results').innerHTML = `
        <h3>Your Score: ${score}</h3>
        <p>${conclusion}</p>
    `;
}
// Function to toggle the pop-up visibility
function togglePopup() {
    var popup = document.getElementById("popup");
    popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";
}


function getDepressionConclusion(score) {
    if (score <= 4) return "Your results suggest minimal depression.";
    if (score <= 9) return "Your results indicate mild depression.";
    if (score <= 14) return "Your results indicate moderate depression.";
    return "Your results suggest severe depression. Please consult a professional.";
}

function getPostpartumConclusion(score) {
    if (score <= 4) return "Your results suggest minimal postpartum depression.";
    if (score <= 9) return "Your results indicate mild postpartum depression.";
    if (score <= 14) return "Your results indicate moderate postpartum depression.";
    return "Your results suggest severe postpartum depression. Please consult a professional.";
}

function getAnxietyConclusion(score) {
    if (score <= 4) return "Your results suggest minimal anxiety.";
    if (score <= 9) return "Your results indicate mild anxiety.";
    if (score <= 14) return "Your results indicate moderate anxiety.";
    return "Your results suggest severe anxiety. Please consult a professional.";
}

function getAdhdConclusion(score) {
    if (score <= 4) return "Your results suggest minimal risk for ADHD.";
    if (score <= 9) return "Your results indicate mild signs of ADHD.";
    if (score <= 14) return "Your results indicate moderate signs of ADHD.";
    return "Your results suggest a high risk for ADHD. Please consult a professional.";
}

function getBipolarConclusion(score) {
    if (score <= 4) return "Your results suggest minimal risk for bipolar disorder.";
    if (score <= 9) return "Your results indicate mild signs of bipolar disorder.";
    if (score <= 14) return "Your results indicate moderate signs of bipolar disorder.";
    return "Your results suggest a high risk for bipolar disorder. Please consult a professional.";
}

function getPsychosisConclusion(score) {
    if (score <= 4) return "Your results suggest minimal risk for psychosis.";
    if (score <= 9) return "Your results indicate mild signs of psychosis.";
    if (score <= 14) return "Your results indicate moderate signs of psychosis.";
    return "Your results suggest a high risk for psychosis. Please consult a professional.";
}

function getPTSDConclusion(score) {
    if (score <= 2) return "Your results suggest no signs of PTSD.";
    return "Your results indicate possible PTSD symptoms. Please consider seeking help.";
}

function getEatingConclusion(score) {
    if (score <= 3) return "Your results suggest minimal risk for eating disorders.";
    if (score <= 7) return "Your results indicate mild signs of eating disorders.";
    return "Your results suggest a high risk for eating disorders. Please consult a professional.";
}

function getAddictionConclusion(score) {
    if (score <= 4) return "Your results suggest minimal risk for addiction.";
    if (score <= 8) return "Your results indicate mild signs of addiction.";
    return "Your results suggest a high risk for addiction. Please consult a professional.";
}

function getYouthConclusion(score) {
    if (score <= 4) return "Your results suggest minimal mental health concerns.";
    if (score <= 9) return "Your results indicate mild mental health concerns.";
    if (score <= 14) return "Your results indicate moderate mental health concerns.";
    return "Your results suggest significant mental health concerns. Please consult a professional.";
}
</script>
</body>
</html>