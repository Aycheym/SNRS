<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uniformsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize message variable
$message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeID = $_POST['employeeID'];
    $fullname = $_POST['fullname'];
    $contact_number = $_POST['contact_number'];
    $email =  $_POST['email'];
    $campus_name = $_POST['campus_name'];
    $office = $_POST['office'];
    $gender = $_POST['gender'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // Check if the studentID already exists
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM admin WHERE employeeID = ?");
    $checkStmt->bind_param("s", $employeeID);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    // Prepare and bind the insert statement
    $stmt = null; // Initialize $stmt
    if ($count > 0) {
        $message = "<p class='error'>Error: Employee ID already exists.</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO admin (employeeID, fullname, contact_number, email, campus_name, office, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $employeeID, $fullname, $contact_number, $email, $campus_name, $office, $gender, $password);

        // Execute the statement
        if ($stmt->execute()) {
            $message = "<p class='success'>New record created successfully. <a href='index.php'>Login</a></p>";
        } else {
            $message = "<p class='error'>Error: " . $stmt->error . "</p>";
        }
    }

    // Close the statement if it was initialized
    if ($stmt) {
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMINISTRATOR SIGN-UP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background1.png'); /* Add your background image URL here */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 450px; /* Reduced width */
            width: 100%; /* Allow full width */
            margin: auto;
            background: rgba(255, 255, 255, 0.8); /* Slightly more opaque background */
            backdrop-filter: blur(10px); /* Blur effect for glass look */
            padding: 25px; /* Adjusted padding */
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            position: relative;
            margin-bottom: 15px; /* Adjusted for smaller spacing */
            margin-left: 12px; /* Moved fields 5 pixels to the right */
        }
        label {
            position: absolute;
            left: 10px;
            top: 10px;
            color: #999;
            transition: 0.2s ease all;
            pointer-events: none; /* Prevent interaction with the label */
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 90%; /* Reduced width of input fields */
            padding: 10px; /* Adjusted padding */
            border: 2px solid #ccc; /* Border style */
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.8); /* Light background for input */
            transition: all 0.3s ease; /* Transition for smooth effect */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Shadow effect */
            margin-left: 5px; /* Added left margin to input fields */
        }
        input:focus {
            outline: none;
            background: rgba(255, 255, 255, 1); /* Full background on focus */
            border-color: #007bff; /* Change border color on focus */
            box-shadow: 0 0 5px rgba(92, 184, 92, 0.5); /* Focus shadow effect */
        }
        input:focus + label,
        input:not(:placeholder-shown) + label {
            top: -15px;
            left: 10px;
            font-size: 12px;
            color: #007bff;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px; /* Adjusted padding */
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px; /* Adjusted font size */
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.2s ease, transform 0.2s; /* Added transform effect */
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            text-align: center; /* Center error messages */
        }
        .success {
            color: green;
            text-align: center; /* Center success messages */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>ADMIN SIGN-UP</h2>
        <?php if (isset($message)) echo $message; ?> <!-- Display success/error messages at the top -->
        <form method="post" action="">
            <div class="form-group">
                <input type="text" id="employeeID" name="employeeID" required placeholder=" " />
                <label for="studentID">Personal ID</label>
            </div>

            <div class="form-group">
                <input type="text" id="fullname" name="fullname" required placeholder=" " />
                <label for="fullname">Full Name</label>
            </div>

            <div class="form-group">
                <input type="text" id="contact_number" name="contact_number" required placeholder=" " />
                <label for="contactnumber">Contact Number</label>
            </div>

            <div class="form-group">
                <input type="email" id="email" name="email" required placeholder=" " />
                <label for="email">Email</label>
            </div>

            <div class="form-group">
                <input type="text" id="campus_name" name="campus_name" required placeholder=" " />
                <label for="campus_name">Campus Name</label>
            </div>

            <div class="form-group">
                <input type="text" id="office" name="office" required placeholder=" " />
                <label for="office">Office</label>
            </div>

            <div class="form-group">
                <input type="text" id="gender" name="gender" required placeholder=" " />
                <label for="gender">Gender</label>
            </div>

            <div class="form-group">
                <input type="password" id="password" name="password" required placeholder=" " />
                <label for="password">Password</label>
            </div>

            <input type="submit" value="Sign Up">
        </form>
    </div>
</body>
</html>