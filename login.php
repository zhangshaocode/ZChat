<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: chat.php');
            exit;
        } else {
            echo "<script>alert('无效的凭据');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('登录时出错');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg space-y-4">
        <h1 class="text-2xl font-bold text-center mb-4">登录</h1>
        <form method="post" action="">
            <input type="text" name="username" placeholder="用户名" class="w-full p-3 border rounded focus:outline-none focus:border-blue-500" required />
            <input type="password" name="password" placeholder="密码" class="w-full p-3 border rounded focus:outline-none focus:border-blue-500" required />
            <button type="submit" class="w-full py-2 px-4 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none">登录</button>
        </form>
        <p class="text-center">还没有账户？ <a href="register.php" class="text-blue-500">点击这里注册</a></p>
    </div>
</body>
</html>