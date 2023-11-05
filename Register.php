<?php
session_start();

if (isset($_GET['username']) && isset($_GET['password'])) {
    $username = filter_var(trim($_GET['username']), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_GET['password']), FILTER_SANITIZE_STRING);
    $ip_address = $_SERVER['REMOTE_ADDR']; // Получаем IP-адрес пользователя

    $mysql = new mysqli('serverip', 'username', 'password', 'dbname');

    if ($mysql->connect_error) {
        die("Connection failed: " . $mysql->connect_error);
    }

    // Проверяем, существует ли пользователь с таким именем
    $check_existing_user = $mysql->query("SELECT * FROM `users` WHERE `username` = '$username'");
    
    if ($check_existing_user && $check_existing_user->num_rows > 0) {
        echo 'User already exists!';
    } else {
        // Добавляем нового пользователя с IP-адресом
        $add_user = $mysql->query("INSERT INTO `dbtable` (`username`, `password`, `ip_address`) VALUES ('$username', '$password', '$ip_address')");
        if ($add_user) {
            echo 'User added successfully!';
        } else {
            echo 'Failed to add user.';
        }
    }

    $mysql->close();
} else {
    echo 'Username or password not provided!';
}
?>
