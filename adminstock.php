<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reservation_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch stock items
$sql = "SELECT id, item_name, stock_count, reservation_status, price, latest_stock_date, total_reserved, total_sold FROM stock_items";
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
            background-image: url('background1.png');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .blur-container {
            background-color: rgba(255, 255, 255, 0.6); /* Semi-transparent white */
            backdrop-filter: blur(3px); /* Blur effect */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            max-width: 1100px; /* Sets a maximum width for the content */
            width: 100%; /* Full width */
            text-align: center; /* Center the title and table content */
        }

        h1 {
            margin-top: 30px; /* Pushes the title 50px down from the top */
            margin-bottom: 25px; /* Optional, keeps some space below the title */
            color: #333;
            font-size: 28px;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        .action-buttons a {
            margin-right: 10px;
            text-decoration: none;
            color: white;
            background-color: #28a745;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .action-buttons a.delete {
            background-color: #dc3545;
        }

        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="blur-container">
        <h1>Stock Items</h1> <!-- Title is inside the blur container -->
        <table>
            <tr>
                <th>Item Name</th>
                <th>Stock Count</th>
                <th>Reservation Status</th>
                <th>Price</th>
                <th>Date of Latest Stock</th>
                <th>Total Reserved</th>
                <th>Total Sold/Issued</th>
                <th>Actions</th> <!-- Added Actions column -->
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["item_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["stock_count"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["reservation_status"]) . "</td>";
                    echo "<td>$" . htmlspecialchars(number_format($row["price"], 2)) . "</td>";
                    echo "<td>" . htmlspecialchars($row["latest_stock_date"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["total_reserved"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["total_sold"]) . "</td>";
                    echo "<td class='action-buttons'>
                        <a href='edit.php?id=" . $row['id'] . "'>Edit</a>
                        <a href='delete.php?id=" . $row['id'] . "' class='delete'>Delete</a>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' style='text-align:center;'>No data available</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
