<?php
function getDbConnection() {
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = '52';

    $connection = mysqli_connect($host, $user, $password, $dbname);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $connection;
}
?>