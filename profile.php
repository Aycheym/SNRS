<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Students Profile</title>
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
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        /* Glass effect container */
        .profile-container {
            background-color: rgba(255, 255, 255, 0.2); /* Semi-transparent white */
            backdrop-filter: blur(10px); /* Glass blur effect */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            width: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-container img {
            height: 120px;
            width: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .profile-container h2 {
            font-size: 24px;
            color: #07a6f0;
            margin: 10px 0;
        }

        /* Button styling */
        .profile-container button, .profile-container input[type="file"] {
            background-color: #07a6f0;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            margin: 10px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 14px;
            width: 80%;
        }

        .profile-container button:hover, .profile-container input[type="file"]:hover {
            background-color: #005f99;
        }

        .logout-button {
            background-color: #f05353;
        }

        .logout-button:hover {
            background-color: #c03b3b;
        }

        /* Hidden file input style */
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        
        .file-input-wrapper input[type="file"] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <!-- Profile Image -->
    <img src="profile.png" alt="Profile Image" id="profileImage">

    <!-- User Name (Placeholder) -->
    <h2>John Doe</h2>

    <!-- Edit Profile Image Button -->
    <div class="file-input-wrapper">
        <button>Edit Profile Image</button>
        <input type="file" accept="image/*" onchange="updateProfileImage(event)">
    </div>

    <!-- Delete Profile Image Button -->
    <button onclick="deleteProfileImage()">Delete Profile Image</button>

    <!-- Logout Button -->
    <button class="logout-button" onclick="logout()">Log Out</button>
</div>

<script>
    // Placeholder for updating profile image
    function updateProfileImage(event) {
        const profileImage = document.getElementById('profileImage');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    // Placeholder for deleting profile image
    function deleteProfileImage() {
        const profileImage = document.getElementById('profileImage');
        profileImage.src = 'default-profile.png'; // Replace with a default profile image path
        alert("Profile image deleted.");
    }

    // Placeholder for logout functionality
    function logout() {
        // Logic to handle user logout
        alert("Logging out...");
        window.location.href = 'logout.php'; // Redirect to logout page
    }
</script>

</body>
</html>
