<?php
session_start();

if (!isset($_SESSION["isauth"])) {
    header("Location: login.php"); // Перенапратив, если не авторизован
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
    .disabled {
        background-color: grey;
        cursor: not-allowed;
    }
    </style>
    <script>
        function showMessage() {
            alert('Добро пожаловать');
        }
    </script>
</head>

<a href="register.php">Registration</a>
<a href="login.php">Login</a>

<body>

<h1>Добро пожаловать в панель управления</h1>

<?php if ($_SESSION['role'] === 'admin'): ?>
    <button onclick="showMessage()">Нажмите меня</button>
<?php else: ?>
    <button class="disabled" disabled>Нажмите меня</button>
<?php endif; ?>

</body>
</html>