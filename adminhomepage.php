<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('background1.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            height: 100vh;
            color: #333;
        }

        /* Sidebar styling */
        .sidebar {
            width: 250px;
            background-color: #add8e6;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            height: 100vh;
        }

        .sidebar .profile {
            text-align: center;
            margin-bottom: 40px;
            width: 100%;
        }

        .sidebar .profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .sidebar .profile h3 {
            font-size: 15px;
            margin: 5px 0;
            color: #333;
        }

        .sidebar .profile p {
            font-size: 14px;
            color: #555;
        }

        .sidebar .nav-item {
            width: 100%;
            margin: 10px 0;
            text-align: center;
        }

        .sidebar .nav-item a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            padding: 15px;
            display: block;
            width: 100%;
            text-align: center;
            border-radius: 5px;
            transition: background 0.3s;
            cursor: pointer;
        }

        .sidebar .nav-item a:hover {
            background-color: #87ceeb;
        }

        /* Main content area */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Reservation container styling */
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            display: none;
        }

        .container img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
        }

        .container h2 {
            font-size: 24px;
            color: #07a6f0;
            margin: 0;
        }
    </style>
    <script>
        // Function to toggle the display of the Reservation container for Home button
        function showReservation() {
            document.getElementById("reservationContainer").style.display = "block";
        }

        // Function to redirect to stock.php for Stock button
        function goToStockPage() {
            window.location.href = "stock.php";
        }
    </script>
</head>
<body>

<!-- Sidebar with User Profile and Buttons -->
<div class="sidebar">
    <div class="profile">
        <img src="profile.png" alt="User Profile">
        <h3>Admin Name</h3>
        <p>Administrator</p>
    </div>
    <div class="nav-item">
        <!-- Home button with JavaScript function to show reservation -->
        <a onclick="showReservation()">Home</a>
        <!-- Stock button with JavaScript function to redirect to stock.php -->
        <a onclick="goToStockPage()">Stock</a>
    </div>
</div>

<!-- Main content -->
<div class="main-content">
    <!-- Reservation Container -->
    <div id="reservationContainer" class="container">
        <img src="reservation.png" alt="Reservation Icon">
        <h2>Reservation</h2>
    </div>
</div>

</body>
</html>
