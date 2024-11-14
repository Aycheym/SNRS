<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            width: 100%;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #07a6f0;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Logs</h2>
    <table>
        <thead>
            <tr>
                <th>Log ID</th>
                <th>Log Date</th>
                <th>User/Product</th>
                <th>Action</th>
                <th>Modified By</th>
                <th>Modified Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database connection details
            $servername = "localhost";
            $username = "root"; // Replace with your actual database username
            $password = ""; // Replace with your actual database password
            $dbname = "UniformSystem";

            // Create a connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query the logs table
            $sql = "SELECT log_id, log_date, user_product, action, modified_by, modified_date FROM logs ORDER BY log_date DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data for each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["log_id"] . "</td>";
                    echo "<td>" . $row["log_date"] . "</td>";
                    echo "<td>" . $row["user_product"] . "</td>";
                    echo "<td>" . $row["action"] . "</td>";
                    echo "<td>" . $row["modified_by"] . "</td>";
                    echo "<td>" . $row["modified_date"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No logs found</td></tr>";
            }

            // Close the connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
