<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Student Home Page</title>
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
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        /* Glass effect for header */
        .header {
            width: 100%;
            background-color: rgba(255, 255, 255, 0.2); /* Semi-transparent white */
            padding: 10px 20px;
            position: fixed;
            top: 0;
            left: 0;
            backdrop-filter: blur(10px); /* Glass blur effect */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header img {
            height: 60px; /* Logo height */
            margin-right: 15px; /* Spacing between logo and text */
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #07a6f0;
            flex-grow: 1; /* Ensures the text expands to fill remaining space */
            text-align: left;
        }

        /* Profile icon styling */
        .profile-icon {
            height: 40px; /* Adjust profile icon size */
            border-radius: 50%; /* Circular profile icon */
            cursor: pointer;
            transition: transform 0.3s ease;
            margin-left: 20px; /* Reduced space between text and icon */
        }

        .profile-icon:hover {
            transform: scale(1.1); /* Slight zoom on hover */
        }

        /* Adjusting grid-container for fixed header */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
            padding: 20px;
            margin: 100px auto 0 auto; /* Pushes the grid below the header */
            max-width: 2500px;
            width: 90%;
        }

        .grid-item {
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            width: 80%;
        }

        .grid-item img {
            width: 50%;
            height: auto;
            margin-bottom: 10px;
            object-fit: cover;
        }

        .grid-item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .grid-item h3 {
            font-size: 16px;
            color: #07a6f0;
            margin: 0;
        }
    </style>
</head>
<body>

<!-- Glass effect header with logo and profile icon -->
<div class="header">
    <img src="logo1.png" alt="Logo">
    <h1>Student Uniform Reservation</h1>
    <a href="profile.php">
        <img src="profile.png" alt="Profile" class="profile-icon">
    </a>
</div>

<!-- Grid containers with smaller images and labels -->
<div class="grid-container">
    <div class="grid-item" onclick="window.location.href='reservation.php'">
        <img src="reservation.png" alt="Make a reservation">
        <h3>MAKE A RESERVATION</h3>
    </div>
    <div class="grid-item" onclick="window.location.href='stock.php'">
        <img src="stock.png" alt="Current Stock">
        <h3>CURRENT STOCK</h3>
    </div>
    <div class="grid-item" onclick="window.location.href='reserved.php'">
        <img src="log.png" alt="Reserved items">
        <h3>RESERVED ITEMS</h3>
    </div>
</div>

</body>
</html>
