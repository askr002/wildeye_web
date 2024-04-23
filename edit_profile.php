<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Logout functionality
if (isset($_POST['logout'])) {
    // Unset all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to login page
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: right;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .sidebar {
            background-color: #f5f5f5;
            float: left;
            width: 200px;
            height: 100vh;
            padding: 20px;
        }
        .content {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .logout {
            decoration: none;
            font-size: 1rem;
            padding: 0.3rem 0.5rem;
            border-radius: 15px;
            border: none;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        .logout:hover {
            color: white;
            background: grey;
            cursor: pointer;
        }
        .logout img {
            height: 1.2rem;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a {
            color: #333;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: 500;
        }
        .sidebar ul li a:hover {
            color: #007bff;
            text-decoration: underline;
        }
        form label {
            font-weight: 500;
            font-size: 1.1rem;
        }
        form input[type="text"],
        form input[type="password"] {
            height: 2rem;
            border-radius: 10px;
        }
        form input[type="submit"] {
            padding: 0.7rem;
            border-radius: 10px;
            border: none;
            font-weight: 500;
            font-size: 1rem;
        }

    </style>
</head>
<body>

<div class="header">
    <h2 class="logo">Wild-Eye</h2>
    <form method="post">
        <button class="logout" type="submit" name="logout"><img src="http://localhost:8000/logout_icon.png" alt="">Logout</button>
    </form>
</div>

<div class="sidebar">
    <ul>
        <li><a href="dashboard.php">Home</a></li>
        <li><a href="#">Notification Preferences</a></li>
        <li><a href="historical_data.php">Historical Data</a></li>
        <li><a href="weather.php">Weather Information</a></li>
        <li><a href="#">Edit Profile</a></li>
    </ul>
</div>

<div class="content">
<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "user";
$password = "password";
$database = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    $newUsername = $_POST['new_username'];
    $newPassword = $_POST['new_password'];

    // Update the username and password in the database
    $username = $_SESSION['username'];
    $update_sql = "UPDATE users SET username='$newUsername', password='$newPassword' WHERE username='$username'";

    if ($conn->query($update_sql) === TRUE) {
        echo "<p>Profile updated successfully.</p>";
        $_SESSION['username'] = $newUsername; // Update session with new username
    } else {
        echo "<p>Error updating profile: " . $conn->error . "</p>";
    }
}
?>

<h1>Edit Profile</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="new_username">New Username:</label><br>
    <input type="text" id="new_username" name="new_username" required><br><br>
    <label for="new_password">New Password:</label><br>
    <input type="password" id="new_password" name="new_password" required><br><br>
    <input type="submit" name="submit" value="Update Profile">
</form>
</div>

</body>
</html>
