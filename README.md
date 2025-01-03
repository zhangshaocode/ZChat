# ZChat
This is a simple chat program with PHP.
这是一个简单的聊天程序
THIS PROGRAM HAS CHINESE LANGUAGE ONLY.
此程序仅支持中文。
# Usage Guide 使用指南⭐
# !!!需要修改以下部分您才可以部署到您的服务器使用!!!
# a. config.php
<p>找到以下部分：</p>
    
``` php   
$host = 'localhost';
$dbname = 'chat_app';
$username = 'your_db_username'; // 替换为你的数据库用户名
$password = 'your_db_password'; // 替换为你的数据库密码
```
<h2>修改为你的实际数据库信息:</h2>

```php
$host = 'localhost';
$dbname = 'chat_app';
$username = 'my_database_user';
$password = 'my_secure_password';
```

<h1 style="color:red">b. register.php</h1>
作用: 处理用户注册功能。用户提交表单后，用户名和加密后的密码会被插入到 users 表中。

需要修改的地方:

数据库表结构:
确保 users 表已经创建，并且包含 id, username, password 字段。
可以参考以下 SQL 语句创建 users 表：
``` sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
```

操作步骤:

确保你有一个 MySQL 数据库实例正在运行。
使用 PHPMyAdmin 或命令行工具连接到你的数据库。
创建 users 表：
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
```
## c. login.php
作用: 处理用户登录功能。用户提交表单后，程序会验证用户名和密码，并设置会话变量以便用户访问聊天页面。

需要修改的地方:

确保 users 表存在:
确认 users 表已经按照上述步骤创建。
操作步骤:

确保 users 表已经创建并且至少有一个用户记录。
访问 login.php 页面并尝试登录。
# d. chat.php
作用: 显示聊天界面并处理消息发送和接收，包括文件上传功能。

需要修改的地方:

确保 uploads 目录存在并且具有正确的权限:
确保 Web 服务器有写入 uploads 目录的权限。
使用以下命令创建目录并设置权限：
``` bash
mkdir -p /www/wwwroot/121.40.80.112/zchat/frontend/uploads
chown -R www-data:www-data /www/wwwroot/121.40.80.112/zchat/frontend/uploads
chmod -R 755 /www/wwwroot/121.40.80.112/zchat/frontend/uploads
```
操作步骤:

在服务器上执行以下命令来创建 uploads 目录并设置权限：
``` bash
mkdir -p /www/wwwroot/121.40.80.112/zchat/frontend/uploads
chown -R www-data:www-data /www/wwwroot/121.40.80.112/zchat/frontend/uploads
chmod -R 755 /www/wwwroot/121.40.80.112/zchat/frontend/uploads
```
访问 chat.php 页面并测试消息发送和文件上传功能。
# e. logout.php
作用: 处理用户注销功能。用户点击注销按钮后，会话变量会被销毁，并重定向到登录页面。

需要修改的地方:

没有特定的修改需求，只要确保 session_start() 已经调用并且会话管理正确。
操作步骤:

访问 chat.php 页面并点击“注销”按钮。
确认用户被重定向到 login.php 页面。
### 总结：以上操作步骤可以基本完成对ZChat的部署及操作过程，请遵守Apache License 2.0协议并合理开源使用，我们承认您可以对此程序进行修改和发布到其他平台，但请声明原作者，最终解释权归Zhangshaocode所有。
