<?php
include('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
    } else {
        echo "<p class='text-red-500'>Invalid credentials!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-80">
        <h2 class="text-2xl font-bold mb-4">Login</h2>
        <form method="post" class="flex flex-col">
            <input type="text" name="username" placeholder="Username" required class="mb-3 p-2 border rounded-lg focus:outline-none">
            <input type="password" name="password" placeholder="Password" required class="mb-3 p-2 border rounded-lg focus:outline-none">
            <button type="submit" class="bg-green-500 text-white py-2 rounded-lg hover:bg-green-600">Login</button>
        </form>
        <p class="mt-3">New here? <a href="register.php" class="text-blue-500">Register</a></p>
    </div>
</body>
</html>
