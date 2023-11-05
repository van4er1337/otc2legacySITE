<?php
session_start();

// Это массив для заблокированных IP-адресов
$blocked_ips = []; // Просто пример, вы можете загружать заблокированные IP из базы данных

if (isset($_GET['username']) && isset($_GET['password'])) {
    $username = filter_var(trim($_GET['username']), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_GET['password']), FILTER_SANITIZE_STRING);

    $mysql = new mysqli('serverip', 'username', 'password', 'dbname');

    if ($mysql->connect_error) {
        die("Connection failed: " . $mysql->connect_error);
    } else {
        echo "DB connected successfully<br>";
    }

    $result = $mysql->query("SELECT * FROM `dbtable` WHERE `username` = '$username' AND `password` = '$password'");

    if ($result && $result->num_rows > 0) {
        // Получаем IP-адрес пользователя
        $user_ip = $_SERVER['REMOTE_ADDR'];

        // Проверяем, заблокирован ли IP-адрес
        if (!in_array($user_ip, $blocked_ips)) {
            echo 'Yes!';
        } else {
            echo 'Your IP is blocked. Please contact support.';
        }
    } else {
        echo 'Idi naxyi';
    }

    $mysql->close();
} else {
    echo 'Username or password not provided!';
}
?>
