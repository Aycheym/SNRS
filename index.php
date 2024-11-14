<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password
$dbname = "UniformSystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for error message
$studentError = "";

// Student login form handling
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_login'])) {
    $studentID = $conn->real_escape_string($_POST['student_id']);
    $studentPassword = $conn->real_escape_string($_POST['student_password']);
    
    // Check if student exists in the database
    $sql = "SELECT * FROM student WHERE studentID='$studentID'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        // Verify the password
        if (password_verify($studentPassword, $student['password'])) {
            // Redirect to homepage if login is successful
            header("Location: studenthomepage.php");
            exit; // Ensure the script stops executing after the redirect
        } else {
            $studentError = "Invalid student ID or password.";
        }
    } else {
        $studentError = "Invalid student ID or password.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
         body {
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: url('background1.png') no-repeat center center fixed;
        background-size: cover;
        font-family: Arial, sans-serif;
    }

    .container {
        position: relative;
        width: 300px;
        padding: 20px;
        border-radius: 15px;
        backdrop-filter: blur(10px) brightness(1.2);
        background: rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .logo {
        width: 150px;
        margin-bottom: 20px;
    }

    .input-container {
        position: relative;
        width: 100%;
        margin: 10px 0;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        background-color: rgba(255, 255, 255, 0.5);
    }

    input[type="text"]:focus + label,
    input[type="password"]:focus + label,
    input[type="text"]:valid + label,
    input[type="password"]:valid + label {
        top: -15px;
        font-size: 12px;
        color: #007bff;
    }

    label {
        position: absolute;
        left: 10px;
        top: 10px;
        color: #888;
        pointer-events: none;
        transition: all 0.2s ease;
        font-size: 16px;
    }

    .button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .button:hover {
        background-color: #0056b3;
    }

    .error {
        color: red;
        margin-bottom: 20px;
    }

    hr {
        border: none;
        border-top: 2px solid black; /* Black line */
        width: 80%;
        margin: 20px auto; /* Centers the line horizontally */
    }

    .signup {
        margin-top: 10px;
        color: #000;
        font-size: 15px;
    }

    .signup a {
        color: #007bff;
        text-decoration: none;
    }

    .signup a:hover {
        text-decoration: underline;
    }

    .forgot-password {
        font-size: 14px;
        color: #007bff;
        margin-top: 5px;
        text-decoration: none;
        display: block;
    }

    .forgot-password:hover {
        text-decoration: underline;
    }

    .admin-login-button {
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        padding: 10px;
        font-size: 16px;
        width: 100%;
        margin-top: 10px;
    }

    .admin-login-button:hover {
        background-color: #0056b3;
    }  
    </style>
</head>
<body>

<div class="container">
    <!-- Logo Image -->
    <img src="logo1.png" alt="Logo" class="logo">

    <!-- Student Login Form -->
    <form method="post" action="" autocomplete="off">
        <!-- Hidden Dummy Field -->
        <input type="text" style="display:none">

        <div class="input-container">
            <input type="text" id="student_id" name="student_id" required autocomplete="off">
            <label for="student_id">Student ID</label>
        </div>
        <div class="input-container">
            <input type="password" id="student_password" name="student_password" required autocomplete="off">
            <label for="student_password">Password</label>
        </div>
        <button type="submit" name="student_login" class="button">Login</button>
        <?php if ($studentError): ?>
            <p class="error"><?php echo $studentError; ?></p>
        <?php endif; ?>
    </form>

    <!-- Black Horizontal Line -->
    <hr>

    <!-- Admin Login Button -->
    <button class="admin-login-button" onclick="window.location.href='admin_login.php'">Admin Login</button>

    <!-- Sign Up and Forgot Password Links -->
    <p class="signup">Don't have an account? <a href="student_signup1.php">Sign up here</a></p>
    <a href="forgot_password.php" class="forgot-password">Forgot Password?</a>
</div>

</body>
</html>
