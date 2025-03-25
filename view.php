<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$stmt = $conn->prepare("SELECT * FROM files WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$files = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Files</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>Your Uploaded Files</h2>
    <ul>
        <?php foreach ($files as $file): ?>
            <li><a href="uploads/<?php echo $file['filename']; ?>" download><?php echo $file['filename']; ?></a></li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php">Go Back</a>
</body>
</html>
