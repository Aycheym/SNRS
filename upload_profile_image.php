<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $uploadDir = 'uploads/';
    $fileName = basename($_FILES['profile_image']['name']);
    $uploadFilePath = $uploadDir . $fileName;

    // Ensure the uploads directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Save the uploaded file to the server
    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadFilePath)) {
        // Update session with new profile image path
        $_SESSION['profile_image'] = $uploadFilePath;
        header("Location: profile.php");
    } else {
        echo "Error uploading the file.";
    }
}
?>
