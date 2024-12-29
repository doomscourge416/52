<?php
session_start();
require 'dbconnect.php';
require 'csrf.php';

$bdconnection = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = mysqli_real_escape_string($bdconnection, $_POST['login']);
    $password = $_POST['pass'];
    $role = 'user'; // По умолчанию - пользователь

    // Проверка на существующий логин
    $result = mysqli_query($bdconnection, "SELECT * FROM users WHERE LOGIN='$login'");
    if (mysqli_num_rows($result) > 0) {
        echo "Логин уже занят.";
    } else {
        // Хеширование пароля
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($bdconnection, "INSERT INTO users (LOGIN, PASSWORD, ROLE) VALUES ('$login', '$hashedPassword', '$role')");
        echo "Регистрация успешна!";
    }
}

$token = generateCSRFToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>

<a href="login.php">Login</a>
<a href="dashboard.php">Admin Page</a>

<body>
<form method="post" action="">
    <input type="text" name="login" placeholder="Логин" required><br/>
    <input type="password" name="pass" placeholder="Пароль" required><br/>
    <input type="hidden" name="token" value="<?=$token?>">
    <input type="submit" value="Зарегистрироваться">
</form>
</body>
</html>