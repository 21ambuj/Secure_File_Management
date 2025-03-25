<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('config.php');

// Fetch username
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$userId]);
$username = $stmt->fetchColumn();

// Fetch user files
$fileStmt = $conn->prepare("SELECT * FROM files WHERE user_id = ?");
$fileStmt->execute([$userId]);
$files = $fileStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure File Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="container mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-3xl font-bold mb-4">Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
            <p class="text-gray-700 mb-4">Manage your files securely here.</p>
            <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded mb-4 inline-block">Logout</a>

            <!-- File Upload Section -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold mb-4">Upload a File</h2>
                <form method="post" action="upload.php" enctype="multipart/form-data" class="flex flex-col gap-4">
                    <input type="file" name="file" class="file-input file-input-bordered w-full max-w-xs" required>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                        Upload File
                    </button>
                </form>
            </div>

            <!-- Display Uploaded Files -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold mb-4">Your Uploaded Files</h2>
                <?php if (!empty($files)): ?>
                    <ul class="list-disc list-inside">
                        <?php foreach ($files as $file): ?>
                            <li class="mb-2">
                                <a href="uploads/<?php echo htmlspecialchars($file['filename']); ?>" target="_blank" class="text-blue-500 hover:underline">
                                    <?php echo htmlspecialchars($file['filename']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-gray-500">No files uploaded yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
