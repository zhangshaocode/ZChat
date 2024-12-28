<?php
$host = 'localhost';
$dbname = 'chat_app';
$username = 'your_db_username'; // 替换为你的数据库用户名
$password = 'your_db_password'; // 替换为你的数据库密码

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("无法连接到数据库: " . $e->getMessage());
}
?>