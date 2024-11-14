<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "UniformSystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch stock items
$sql = "SELECT item_name, stock_count, reservation_status, price, latest_stock_date, total_reserved, total_sold FROM stock_items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Items</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background1.png'); /* Add your background image URL here */  
            background-size: cover;
            background-position: center;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        table {
            width: 80%;
            margin-top: 20px;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>Item Name</th>
            <th>Stock Count</th>
            <th>Reservation Status</th>
            <th>Price</th>
            <th>Date of Latest Stock</th>
            <th>Total Reserved</th>
            <th>Total Sold/Issued</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["item_name"] . "</td>";
                echo "<td>" . $row["stock_count"] . "</td>";
                echo "<td>" . $row["reservation_status"] . "</td>";
                echo "<td>" . $row["price"] . "</td>";
                echo "<td>" . $row["latest_stock_date"] . "</td>";
                echo "<td>" . $row["total_reserved"] . "</td>";
                echo "<td>" . $row["total_sold"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No data available</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>