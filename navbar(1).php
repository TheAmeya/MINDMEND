<nav>
    <ul> 
        <li><a href="home.php">Home</a></li>
        <li><a href="breathing.php">Breathing</a></li>
        <li><a href="mental_health_tests.php">Test</a></li>
        <li><a href="moodjournal.php">Mood Journal</a></li>
        <li><a href="help.php">Help</a></li>
        <li><a href="profile1.php">Profile</a></li>
    </ul>
</nav>

<style>
    body {
        margin: 0;
        padding: 0;
    }

    nav {
        background-color: #4a90e2;
        width: 100%; /* Ensure the nav spans the full width */
        display: table;
        padding: 0; /* Remove padding */
    }

    nav ul {
        display: table;
        width: 100%; /* Spread the list across the full width */
        list-style: none;
        padding: 0;
        margin: 0;
        table-layout: fixed; /* Makes each item take up equal width */
    }

    nav ul li {
        display: table-cell;
        text-align: center;
        font-size: 20px;
        height: 100px; /* Increase cell height */
    }

    nav ul li a {
        color: white;
        text-decoration: none;
        font-weight: bold;
        display: block;
        height: 100%; /* Ensure link takes full cell height */
        line-height: 100px; /* Vertically center text */
    }

    nav ul li:hover {
        background-color: yellow; /* Change background on hover */
    }

    nav ul li:hover a {
        color: black; /* Change text color on hover */
    }
</style>
