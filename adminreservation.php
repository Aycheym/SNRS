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
    $studentID = $_POST['studentID'];
    $femaleUniform = $_POST['femaleuniform'];
    $maleUniform = $_POST['maleuniform'];

    // Check if the studentID exists
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM student WHERE studentID = ?");
    $checkStmt->bind_param("s", $studentID);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        // Update the student's uniform quantities
        $stmt = $conn->prepare("UPDATE student SET femaleuniform = ?, maleuniform = ? WHERE studentID = ?");
        $stmt->bind_param("sss", $femaleUniform, $maleUniform, $studentID);

        if ($stmt->execute()) {
            // Success message updated here with hyperlinks
            $message = "<p class='success'>Reservation request sent. Pending Approval.</p>";
            $message .= "<a href='adminhomepage.php'>Go back to homepage</a> | ";
            $message .= "<a href='reserved_items.php'>Go to reserved items</a>";
        } else {
            $message = "<p class='error'>Error updating record: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        $message = "<p class='error'>Error: Student ID not found.</p>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uniform Reservation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('background1.png'); /* Add your background image URL */
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
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }
        h2 {
            color: #007bff;
            margin-bottom: 20px;
            font-size: 24px;
        }
        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 20px;
            font-size: 14px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
        a {
            text-decoration: none;
            color: #007bff;
            margin: 0 5px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Uniform Reservation</h2>
        <form method="POST" action="">
            <input type="text" name="studentID" placeholder="Student ID" required>
            <input type="text" name="femaleuniform" placeholder="Female Uniform Sets" required>
            <input type="text" name="maleuniform" placeholder="Male Uniform Sets" required>
            <input type="submit" value="Make The Reservation">
        </form>
        <div class="message"><?php if (isset($message)) echo $message; ?></div>
    </div>
</body>
</html>
