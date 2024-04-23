<?php
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

// Function to register new user
function registerUser($username, $password, $conn) {
    // Sanitize input to prevent SQL injection
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Check if username already exists
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Username already exists
        return false;
    } else {
        // Insert new user into the database
        $insert_sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($insert_sql) === TRUE) {
            // User registration successful
            return true;
        } else {
            // Error inserting user
            return false;
        }
    }
}

// Check if registration form is submitted
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (registerUser($username, $password, $conn)) {
        // Registration successful
        $registration_message = "Registration successful. You can now login.";
    } else {
        // Registration failed
        $error_message = "Registration failed. Username already exists or there was an error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;

        }
        html {
            width: 100%;
            height: 100%;
            background: #f2f2f2;
            background: linear-gradient(-135deg, #70c850, #16171d);
        }
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: absolute;
            width: 100%;
            height: 100%;
            background: #f2f2f2;
            background: linear-gradient(-135deg, #70c850, #16171d);
        }
        ::selection{
            background: #1c1d20;
            color: #fff;
        }
        .content {            
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
            border-radius: 15px;
            width: 380px;
            background: white;
            box-shadow: 0px 15px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        .content h2 {
            font-size: 2rem;
            font-weight: 600;
        }
        .content form {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
            min-height: 30vh;
        }
        .content form .field{
            height: 50px;
            width: 100%;
            margin-top: 20px;
            position: relative;
        }
        .content form .field input{
            height: 100%;
            width: 100%;
            outline: none;
            font-size: 17px;
            padding-left: 20px;
            border: 1px solid lightgrey;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .content form .field input:focus,
        form .field input:valid{
            border-color: #194b06;
        }
        .content form .field label{
            position: absolute;
            top: 50%;
            left: 20px;
            color: #999999;
            background: white;
            font-weight: 400;
            font-size: 17px;
            pointer-events: none;
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }
        .button{
            color: #ffffff;
            font-size: 20px;
            font-weight: 500;
            cursor: pointer;
            border: 2px solid #fff;
            background-color: #2d7312;
            outline: #2d6e13 3px solid;
            width: 50%;
            border-radius: 10px;
            text-align: center;
            padding: 2px 25px;
            margin-top: 2rem;
        }
        .button:active, .button:hover {
            transform: scale(0.95);
        }
        a {
            color: #262626;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="content">
        <h2>Registration</h2>
        <?php if (isset($registration_message)) echo "<p>$registration_message</p>"; ?>
        <?php if (isset($error_message)) echo "<p>$error_message</p>"; ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="field">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" required><br><br>
            </div>
            <div class="field">
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br><br>
            </div>
            <input class="button" type="submit" name="submit" value="Register">
        </form>
        <a href="login.php">Log In</a>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>

