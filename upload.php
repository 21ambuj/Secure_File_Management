<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $userId = $_SESSION['user_id'];
    $filename = $_FILES['file']['name'];
    $filepath = 'uploads/' . basename($filename);

    // Ensure the uploads directory exists
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Check for file upload errors
    if ($_FILES['file']['error'] === 0) {
        // Secure the filename
        $filename = preg_replace("/[^a-zA-Z0-9\._-]/", "", $filename);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) {
            $stmt = $conn->prepare("INSERT INTO files (user_id, filename) VALUES (?, ?)");
            $stmt->execute([$userId, $filename]);
            echo "<p class='text-green-500'>File uploaded successfully!</p>";
        } else {
            echo "<p class='text-red-500'>Failed to upload the file!</p>";
        }
    } else {
        echo "<p class='text-red-500'>File upload error!</p>";
    }
}
?>
