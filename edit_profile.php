<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password
$dbname = "uniformsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Initialize variables
$fullname = "";
$username = "";
$password = "";
$profilepic = "";

// Fetch current user data
$sql = "SELECT fullname, username, password, profilepic FROM admins WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($fullname, $username, $hashed_password, $profilepic);
$stmt->fetch();
$stmt->close();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'] ?: null;
    $username = $_POST['username'] ?: null;
    $password = $_POST['password'] ?: null;

    // Handle file upload
    if (isset($_FILES['profilepic']) && $_FILES['profilepic']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profilepic"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check file type
        $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target_file)) {
                $profilepic = $target_file;
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        } else {
            $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }

    // Prepare update query
    $sql = "UPDATE admins SET fullname=COALESCE(?, fullname), username=COALESCE(?, username), password=COALESCE(?, password), profilepic=COALESCE(?, profilepic) WHERE id=?";
    $stmt = $conn->prepare($sql);

    // Hash the password only if it's provided
    $hashed_password = $password ? password_hash($password, PASSWORD_DEFAULT) : null;

    // Bind parameters
    $stmt->bind_param("ssssi", $fullname, $username, $hashed_password, $profilepic, $user_id);

    // Execute the query
    if ($stmt->execute()) {
        $success_message = "Profile updated successfully.";
    } else {
        $error_message = "Error updating profile: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpg'); /* Replace with your background image */
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
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            backdrop-filter: blur(1px);
        }
        h1 {
            color: #3660a3;
            font-size: 24px;
            text-transform: uppercase;
            margin: 0px 15px;
        }
        .input-container {
            position: relative;
            margin: 15px 0;
        }
        input[type="text"],
        input[type="password"],
        input[type="file"] {
            width: calc(100% - 22px);
            padding: 10px; /* Increased padding */
            border: 1px solid #ccc;
            border-radius: 4px;
            height: 40px; /* Increased height */
            font-size: 16px; /* Increased font size */
            box-sizing: border-box; /* Ensure padding doesn't affect the width */
            transition: padding 0.2s; /* Smooth transition for padding */
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #07a6f0; /* Change border color on focus */
            outline: none; /* Remove default outline */
        }
        input[type="text"]::placeholder,
        input[type="password"]::placeholder {
            color: #aaa;
        }
        input[type="submit"] {
            background-color: #b8e2f5;
            color: white;
            border: none;
            padding: 10px;
            margin-top: 15px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
            transition: transform 0.3s ease;
        }
        input[type="submit"]:disabled {
            background-color: #b8e2f5;
            cursor: not-allowed;
        }
        input[type="submit"].active {
            background-color: #07a6f0;
        }
        .go-back-btn {
            background-color: #d8000c; /* Red color for 'Go Back' */
            color: white;
            margin-top: 10px;
        }
        .error-message {
            color: red;
            background-color: #ffdddd;
            border: 1px solid red;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            font-size: 14px;
        }
        .success-message {
            color: green;
            background-color: #ddffdd;
            border: 1px solid green;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            font-size: 14px;
        }
        .success-message a {
            color: #07a6f0; /* Default link color */
            text-decoration: none; /* Remove underline */
            transition: color 0.3s; /* Smooth transition */
        }
        .success-message a:hover {
            color: #005f8d; /* Darker color on hover */
            text-decoration: underline; /* Underline on hover */
        }
        .file-input-container {
            margin-top: 15px;
            margin-bottom: 15px;
            position: relative;
            transition: background-color 0.3s;
        }
        .file-input-container input[type="file"] {
            display: none; /* Hide the actual file input */
           
        }
        .custom-file-label {
            display: inline-block;
            background-color: #07a6f0;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px; 
        }
        .custom-file-label:hover {
            background-color: #005f8d;
        }
        .file-chosen {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }
        /* New styles for floating labels */
        .floating-label {
            position: absolute;
            left: 14px;
            top: 12px;
            transition: 0.2s;
            color: #68adf7; /* Change label color to blue */
            pointer-events: none; /* Prevent events on label */
        }
        input[type="text"]:focus + .floating-label,
        input[type="text"]:not(:placeholder-shown) + .floating-label,
        input[type="password"]:focus + .floating-label,
        input[type="password"]:not(:placeholder-shown) + .floating-label {
            top: -12px; /* Move label above the input */
            font-size: 12px; /* Smaller font size */
            color: #68adf7; /* Change color on focus */
        }
        hr.blue-line {
            width: 100%;
            height: 3px;
            background-color: #007BFF;
            border: none;
            margin: 10px auto 30px auto;
        }
        .header-nav-container {
            display: flex;
            align-items: center;
            background-color: rgba(184, 226, 245, 0.8); /* Transparent color for blur */
            padding: 10px 20px; /* Added padding */
            backdrop-filter: blur(10px); /* Blur effect */
        }
        .header-nav-container img {
            max-width: 10%;
            height: auto;
            margin-right: 20px; /* Adds 20px gap between logo and nav links */
        }
        .header-nav-container nav {
            display: flex;
            gap: 5px;
            align-items: center;
        }
        nav a {
            color: #07a6f0;
            text-decoration: none;
            margin: 0 10px;
            font-size: 16px;
        }
        nav a:not(:last-child)::after {
            content: '|'; /* Adds vertical line between links */
            margin-left: 10px;
            color: #07a6f0;
        }
        nav a:hover {
            text-decoration: underline;
            color: #005f9e;
        }

        /* New CSS for the clickable image on the right */
        .clickable-image img {
            max-width: 4%; 
            margin-left: 850px;/* Same size as the logo */
            height: auto;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .clickable-image img:hover {
            transform: scale(1.05);
        }

    </style>
<script>
    function updateFileName() {
        const input = document.getElementById('profilepic');
        const fileName = input.files[0] ? input.files[0].name : 'No file chosen';
        
        // Get the file extension
        const extension = fileName.split('.').pop();
        // Get the base name without the extension
        const baseName = fileName.substring(0, fileName.length - extension.length - 1); // -1 for the dot
        const truncatedBaseName = baseName.length > 20 ? baseName.slice(0, 20) + '...' : baseName;

        // Combine the truncated base name with the extension
        const finalName = baseName.length > 20 ? truncatedBaseName + '.' + extension : fileName;

        document.getElementById('file-chosen').innerText = finalName;
    }

    // Function to check if inputs are empty on focus out
    function checkInputValue(input) {
        const label = input.nextElementSibling; // Get the associated label
        if (input.value) {
            label.classList.add('active'); // Add active class if there's a value
        } else {
            label.classList.remove('active'); // Remove active class if empty
            label.style.top = '12px'; // Reset label position
            label.style.fontSize = '14px'; // Reset label font size
        }
    }

    // New function to handle focus on input fields
    function handleInputFocus(input) {
        const label = input.nextElementSibling; // Get the associated label
        label.classList.add('active'); // Add active class on focus
        label.style.top = '-12px'; // Move label above the input
        label.style.fontSize = '12px'; // Smaller font size
    }
</script>
</head>
<body> 


    <div class="container">
        <h1>Edit Profile</h1>

        <hr class="blue-line">

        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?= $error_message ?></div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="success-message"><?= $success_message ?></div>
        <?php endif; ?>
        <form action="edit_profile.php" method="post" enctype="multipart/form-data">
        <div class="input-container">
            <input type="text" name="fullname" value="<?= htmlspecialchars($fullname) ?>" onblur="checkInputValue(this)" onfocus="handleInputFocus(this)" required>
            <label class="floating-label">Full Name</label>
        </div>
        <div class="input-container">
            <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" onblur="checkInputValue(this)" onfocus="handleInputFocus(this)" required>
            <label class="floating-label">Username</label>
        </div>
        <div class="input-container">
            <input type="password" name="password" onblur="checkInputValue(this)" onfocus="handleInputFocus(this)">
            <label class="floating-label">New Password</label>
        </div>
            <div class="file-input-container">
                <input type="file" name="profilepic" id="profilepic" accept="image/*" onchange="updateFileName()">
                <label for="profilepic" class="custom-file-label">Choose Profile Picture</label>
                <div id="file-chosen" class="file-chosen">No file chosen</div>
            </div>
            <input type="submit" value="Update Profile">
        </form>
        <div class="button-container">
            <button type="button" class="go-back-button" onclick="window.history.back()">Go Back</button>
        </div>
    </div>
</body>
</html>