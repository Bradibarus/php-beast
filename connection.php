<?php
$host = 'localhost'; // адрес сервера
$user = 'user'; // имя пользователя
$password = 'fucker666'; // пароль
$database = 'lab6'; // бд
$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
?>