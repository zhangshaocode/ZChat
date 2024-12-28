<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_message'])) {
    $content = $_POST['content'];
    $image_url = '';

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $original_filename = basename($_FILES["image"]["name"]);
        $unique_filename = uniqid() . '_' . $original_filename; // 使用唯一标识符避免文件名冲突
        $target_file = $target_dir . $unique_filename;

        // Ensure the uploads directory exists and is writable
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $target_file;
        } else {
            echo "<script>alert('上传文件时出错');</script>";
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, content, image_url) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $content, $image_url]);
        echo "<script>alert('消息发送成功');</script>";
    } catch (PDOException $e) {
        echo "<script>alert('发送消息时出错');</script>";
    }
}

function getMessages($pdo) {
    $stmt = $pdo->query("
        SELECT m.*, u.username AS sender_username
        FROM messages m
        JOIN users u ON m.sender_id = u.id
        ORDER BY m.created_at ASC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>聊天</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg space-y-4">
        <h1 class="text-2xl font-bold text-center mb-4">聊天</h1>
        <form method="post" enctype="multipart/form-data" action="" class="space-y-4">
            <textarea name="content" placeholder="输入消息..." class="w-full p-3 border rounded focus:outline-none focus:border-blue-500" required></textarea>
            <div class="flex space-x-2">
                <input type="file" name="image" accept="image/*" class="hidden" id="imageUpload" onchange="handleFileChange(event)" />
                <label for="imageUpload" class="py-2 px-4 bg-blue-500 text-white rounded cursor-pointer hover:bg-blue-600 focus:outline-none">上传图片</label>
                <button type="submit" name="send_message" class="py-2 px-4 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none">发送消息</button>
            </div>
        </form>

        <div id="messages" class="h-64 overflow-y-scroll border rounded p-3">
            <?php
            $messages = getMessages($pdo);
            foreach ($messages as $message) {
                $messageClass = $message['sender_id'] == $user_id ? 'sent' : 'received';
                $backgroundColor = $message['sender_id'] == $user_id ? '#e1f2ff' : '#fff';
                ?>
                <div class="message <?= $messageClass ?> p-3 rounded mb-2" style="background-color: <?= $backgroundColor ?>;">
                    <strong><?= htmlspecialchars($message['sender_username']) ?>:</strong> <?= htmlspecialchars($message['content']) ?>
                    <?php if (!empty($message['image_url'])): ?>
                        <br><img src="<?= htmlspecialchars($message['image_url']) ?>" alt="上传的图片" class="mt-2 w-full h-auto rounded">
                    <?php endif; ?>
                </div>
                <?php
            }
            ?>
        </div>

        <a href="logout.php" class="block text-center mt-4 text-red-500 hover:text-red-600">注销</a>
    </div>

    <script>
        function handleFileChange(event) {
            const fileInput = event.target;
            const fileName = fileInput.files[0].name;
            const label = document.querySelector('label[for="imageUpload"]');
            label.textContent = fileName || '上传图片';
        }
    </script>
</body>
</html>