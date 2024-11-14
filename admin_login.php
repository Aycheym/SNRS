<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // MySQL username
$password = ""; // MySQL password (if any)
$dbname = "UniformSystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variable for error message
$adminError = "";

// Admin login form handling
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_login'])) {
    $adminEmployeeID = $conn->real_escape_string($_POST['admin_employeeID']);
    $adminPassword = $conn->real_escape_string($_POST['admin_password']);
    
    // Check if admin exists in the database
    $sql = "SELECT * FROM admin WHERE employeeID='$adminEmployeeID'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        // Verify the password
        if (password_verify($adminPassword, $admin['password'])) {
            // Redirect to homepage after successful login
            header('Location: adminhomepage.php');
            exit(); // Always call exit after header redirection
        } else {
            $adminError = "Invalid username or password.";
        }
    } else {
        $adminError = "Invalid username or password.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            background-image: url('background1.png');
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

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .input-container {
            position: relative;
            width: 100%;
            max-width: 250px;
            margin: 15px 0;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.5);
            font-size: 16px;
        }

        label {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            font-size: 16px;
            pointer-events: none;
            transition: all 0.2s ease;
        }

        /* Floating effect when input is focused or has text */
        input:focus + label,
        input:not(:placeholder-shown) + label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            color: #007bff;
        }

        .button {
            width: 100%;
            max-width: 250px;
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

        .signup,
        .forgot-password {
            margin-top: 10px;
            font-size: 15px;
        }

        .signup {
            color: black;
        }

        .signup a,
        .forgot-password a {
            color: #007bff;
            text-decoration: none;
        }

        .signup a:hover,
        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="logo1.png" alt="Logo" class="logo">
        <form method="post" action="">
            <div class="input-container">
                <input type="text" id="admin_employeeID" name="admin_employeeID" placeholder=" " required>
                <label for="admin_employeeID">Admin ID</label>
            </div>
            <div class="input-container">
                <input type="password" id="admin_password" name="admin_password" placeholder=" " required>
                <label for="admin_password">Admin Password</label>
            </div>
            <button type="submit" name="admin_login" class="button">Admin Login</button>
            <?php if ($adminError): ?>
                <p class="error"><?php echo $adminError; ?></p>
            <?php endif; ?>
        </form>
        <p class="signup">Don't have an account? <a href="admin_signup.php">Sign up here</a></p>
        <p class="forgot-password"><a href="forgot_password.php">Forgot Password?</a></p>
    </div>
</body>
</html>
