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

// Initialize variables
$message = '';
$fullname = '';
$gender = '';
$numberofsets = isset($_POST['numberofsets']) ? $_POST['numberofsets'] : ''; // Keep the No. of sets value
$reservation_date = isset($_POST['reservation_date']) ? $_POST['reservation_date'] : ''; // Keep the reservation date value

// Check if the form is submitted for fetching details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fetch'])) {
    $personal_id = $_POST['personalID'];

    // Fetch user details from the database
    $stmt = $conn->prepare("SELECT fullName, gender FROM student WHERE studentID = ?");
    $stmt->bind_param("s", $personal_id);
    $stmt->execute();
    $stmt->bind_result($fullname, $gender);
    $stmt->fetch();
    $stmt->close();

    // If no user is found, set error message
    if (!$fullname) {
        $message = "<p class='error'>Error: Personal ID not found.</p>";
    }
}

// If the form is submitted for reservation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reserve'])) {
    $personal_id = $_POST['personalID'];
    $fullname = $_POST['fullname'];
    $gender = $_POST['Gender'];
    $numberofsets = $_POST['numberofsets'];
    $reservation_date = $_POST['reservation_date'];
    
    // Format the date before inserting it into the database (MySQL expects date in YYYY-MM-DD format)
    $formatted_reservation_date = date("Y-m-d", strtotime($reservation_date));

    // Check if the personal ID already exists in reservations
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM reserved_items WHERE studentID = ?");
    $checkStmt->bind_param("s", $personal_id);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        $message = "<p class='error'>Error: Personal ID already has a reservation.</p>";
    } else {
        // Insert the reservation
        $stmt = $conn->prepare("INSERT INTO reserved_items (studentID, fullname, gender, numberofsets, reservation_date ) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $personal_id, $fullname, $gender, $numberofsets, $reservation_date);

        if ($stmt->execute()) {
            $message = "<p class='success'>Reservation created successfully.</p>";
        } else {
            $message = "<p class='error'>Error: " . $stmt->error . "</p>";
        }
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
    <title>Reservation Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background1.png');
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
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 30px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        h2 {
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="submit"] {
            width: 80%;
            padding: 8px;
            border: 2px solid #ccc;
            border-radius: 4px;
            margin-bottom: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 20px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
        .button-group {
            margin-top: 20px;
        }
        .button-group a {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
            display: inline-block;
        }
        .button-group a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Uniform Reservation</h2>
        <?php if (isset($message)) echo "<div class='message'>$message</div>"; ?> <!-- Display success/error messages -->
        <form method="post" action="">
            <div class="form-group">
                <label for="personalID">Personal ID</label>
                <input type="text" id="personalID" name="personalID" value="<?php echo isset($_POST['personalID']) ? $_POST['personalID'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="numberofsets">No. of Sets</label>
                <input type="text" id="numberofsets" name="numberofsets" value="<?php echo $numberofsets; ?>" required>
            </div>
            <div class="form-group">
                <label for="reservation_date">Reservation Date(YYYY-MM-DD)</label>
                <input type="text" id="reservation_date" name="reservation_date" value="<?php echo $reservation_date; ?>" required>
            </div>
            <div class="form-group">
                <input type="submit" name="fetch" value="Fetch Details">
            </div>
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="Gender">Gender</label>
                <input type="text" id="Gender" name="Gender" value="<?php echo $gender; ?>" readonly>
            </div>
            <input type="submit" name="reserve" value="Reserve">
        </form>

        <div class="button-group">
            <a href="studenthomepage.php">Go back to Home Page</a>
            <a href="reserved.php">Go to Reservation Items</a>
        </div>
    </div>
</body>
</html>
