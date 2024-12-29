<?php
session_start();
require 'dbconnect.php';
require 'csrf.php';

$bdconnection = getDbConnection();

if (isset($_COOKIE['remember_me'])) {
    $_SESSION["CSRF"] = $_COOKIE['remember_me'];
    $_SESSION["isauth"] = true;
    echo "Вы уже авторизованы.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (validateCSRFToken($_POST['token'])) {
        $login = mysqli_real_escape_string($bdconnection, $_POST['login']);
        $password = $_POST['pass'];

        $result = mysqli_query($bdconnection, "SELECT * FROM users WHERE LOGIN='$login'");
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['PASSWORD'])) {
                $_SESSION["isauth"] = true;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role'] = $row['ROLE'];

                if (isset($_POST['remember'])) {
                    $token = hash('gost-crypto', random_int(0,999999 . "salt"));
                    setcookie('remember_me', $token, time() + 86400, "/"); // 1 день
                    mysqli_query($bdconnection, "UPDATE users SET remember_token='$token' WHERE LOGIN='$login'");
                }

                echo "Успешная авторизация";
            } else {
                echo "Неверный пароль.";
            }
        } else {
            echo "Логин не найден.";
        }
    } else {
        echo "Ошибка токена!";
    }
}

$token = generateCSRFToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
</head>

<a href="register.php">Registration</a>
<a href="dashboard.php">Admin Page</a>

<body>
<form method="post" action="">
    <input type="text" name="login" placeholder="Логин" required><br/>
    <input type="password" name="pass" placeholder="Пароль" required><br/>
    <input type="checkbox" name="remember"> Запомнить меня<br/>
    <input type="hidden" name="token" value="<?=$token?>">
    <input type="submit" value="Войти">
</form>
</body>
</html>