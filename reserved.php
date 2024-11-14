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

// Fetch all reserved items from the 'reserved_items' table
$sql = "SELECT studentID, fullname, gender, numberofsets, reservation_date FROM reserved_items";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Reserved Items</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background1.png'); /* Add your background image URL here */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 700px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ccc;
        }
        th {
            background-color: #1E90FF; /* Blue color for the header row */
            color: white; /* White text for better contrast */
        }
        .back-button {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>All Reserved Items</h2>
        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Personal ID</th>
                    <th>Full Name</th>
                    <th>Gender</th>
                    <th>No. of Sets</th>
                    <th>Reservation Date</th>
                </tr>
                <?php while($rows = $result->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo htmlspecialchars($rows['studentID']); ?></td>
                        <td><?php echo htmlspecialchars($rows['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($rows['gender']); ?></td>
                        <td><?php echo htmlspecialchars($rows['numberofsets']); ?></td>
                        <td><?php echo htmlspecialchars($rows['reservation_date']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php else: ?>
            <p>No reserved items found.</p>
        <?php endif; ?>
        <a href="studenthomepage.php" class="back-button">Go back to homepage</a>
    </div>
</body>
</html>
