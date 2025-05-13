<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}
include('db1.php'); // Include database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Journal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #a7d6f9, #ffffff);
            color: #333;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
            padding: 20px;
            max-width: 800px;
            margin: auto;
            width: 100%;
        }

        h1 {
            text-align: center;
            font-size: 2.5rem;
            color: #4a90e2;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-size: 1.2rem;
        }

        input[type="text"], input[type="date"], textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        input[type="range"] {
            width: 100%;
            margin-bottom: 10px;
        }

        .scale {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .mood-value {
            text-align: center;
            margin: 10px 0;
            font-size: 1.5rem;
            color: #357ABD;
        }

        button {
            background-color: #4a90e2;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #357ABD;
        }

        .entry {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
        }

        .entry p {
            margin: 8px 0;
        }

        #entries {
            max-height: 400px;
            overflow-y: auto;
        }

        .date-search {
            display: block;
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
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


        /* Responsive Design */
        @media screen and (max-width: 768px) {
            main {
                padding: 10px;
            }

            h1 {
                font-size: 2rem;
            }

            button {
                font-size: 1rem;
            }

            .mood-value {
                font-size: 1.3rem;
            }
        }

        footer {
            background-color: #4a90e2;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>

    <?php include('navbar.php'); ?> <!-- Include the navbar -->

    <main>
        <h1>Mood Journal</h1>

        <!-- Mood Slider -->
        <label for="mood">How do you feel today? (1-10)</label>
        <input type="range" id="mood" min="1" max="10" oninput="updateMoodValue(this.value)">

        <!-- Mood Value Display -->
        <div class="mood-value" id="mood-value">Mood: 5</div>

        <!-- Mood Scale Display -->
        <div class="scale">
            <span>😢 1</span>
            <span>😟 3</span>
            <span>😐 5</span>
            <span>😊 7</span>
            <span>😁 10</span>
        </div>

        <!-- Question Text Area -->
        <label for="question">What made you feel this way?</label>
        <textarea id="question" rows="4" placeholder="Describe your feelings or experiences..."></textarea>

        <!-- Submit Button -->
        <button onclick="saveEntry()">Save Entry</button>

        <!-- Search Bar -->
        <h2>Search Entries by Date</h2>
        <input type="date" id="searchDate" class="date-search" oninput="searchEntries()">

        <h2>Your Entries</h2>

        <!-- Entries Section -->
        <div id="entries"></div>
        <!-- Call sign button -->
<div class="call-sign" onclick="togglePopup()">Need Help?</div>

<!-- Pop-up with suicide prevention number -->
<div class="popup" id="popup">
    <span class="close-btn" onclick="togglePopup()">x</span>
    Suicide Prevention Hotline: <br><strong>1-800-273-8255</strong>
</div>

    </main>

    <footer>
        © 2024 Mood Journal. All rights reserved.
    </footer>

    <script>
        function updateMoodValue(value) {
            const moodValueElement = document.getElementById("mood-value");
            moodValueElement.innerText = "Mood: " + value;
        }

        function saveEntry() {
            const mood = document.getElementById("mood").value;
            const question = document.getElementById("question").value;

            if (!question) {
                alert("Please provide an answer to the question.");
                return;
            }

            const formData = new FormData();
            formData.append("mood", mood);
            formData.append("question", question);

            fetch("save_entry.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                    document.getElementById("mood").value = 5;
                    document.getElementById("question").value = '';
                    loadEntries();  // Reload entries after save
                } else {
                    alert("Failed to save entry.");
                }
            })
            .catch(error => console.error("Error:", error));
        }

        function loadEntries(limit = 5) {
            fetch(`get_entries2.php?limit=${limit}`)
            .then(response => response.json())
            .then(entries => {
                const entriesDiv = document.getElementById("entries");
                entriesDiv.innerHTML = ''; // Clear previous entries

                entries.forEach(entry => {
                    const entryDiv = document.createElement("div");
                    entryDiv.className = 'entry';
                    entryDiv.innerHTML = `<p><strong>Date:</strong> ${entry.entry_date}</p>
                                          <p><strong>Mood:</strong> ${entry.mood}/10</p>
                                          <p><strong>What made you feel this way?</strong> ${entry.question}</p>`;
                    entriesDiv.appendChild(entryDiv);
                });
            })
            .catch(error => console.error("Error loading entries:", error));
        }
        // Function to toggle the pop-up visibility
function togglePopup() {
    var popup = document.getElementById("popup");
    popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";
}


        function searchEntries() {
            const searchDate = document.getElementById('searchDate').value;
            fetch(`get_entries2.php?date=${searchDate}`)
            .then(response => response.json())
            .then(entries => {
                const entriesDiv = document.getElementById("entries");
                entriesDiv.innerHTML = ''; // Clear previous entries

                entries.forEach(entry => {
                    const entryDiv = document.createElement("div");
                    entryDiv.className = 'entry';
                    entryDiv.innerHTML = `<p><strong>Date:</strong> ${entry.entry_date}</p>
                                          <p><strong>Mood:</strong> ${entry.mood}/10</p>
                                          <p><strong>What made you feel this way?</strong> ${entry.question}</p>`;
                    entriesDiv.appendChild(entryDiv);
                });
            })
            .catch(error => console.error("Error loading entries:", error));
        }

        // Load recent entries on page load
        window.onload = function() {
            loadEntries();
        };
    </script>

</body>
</html>
