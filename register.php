<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    echo "<p>Registration successful! <a href='login.php'>Login Here</a></p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-80">
        <h2 class="text-2xl font-bold mb-4">Register</h2>
        <form method="post" class="flex flex-col">
            <input type="text" name="username" placeholder="Username" required class="mb-3 p-2 border rounded-lg focus:outline-none">
            <input type="password" name="password" placeholder="Password" required class="mb-3 p-2 border rounded-lg focus:outline-none">
            <button type="submit" class="bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Register</button>
        </form>
        <p class="mt-3">Already have an account? <a href="login.php" class="text-blue-500">Login</a></p>
    </div>
</body>
</html>
