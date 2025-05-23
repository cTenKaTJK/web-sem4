<?php
    $mysql = new mysqli('db', 'root', 'helloword', 'web');

    if (mysqli_connect_errno()) {
        echo mysqli_connect_error() . "ошибка подключения к БД";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $mysqli->real_escape_string($_POST['email']);
        $title = $mysqli->real_escape_string($_POST['title']);
        $description = $mysqli->real_escape_string($_POST['description']);
        $category = $mysqli->real_escape_string($_POST['category']);
    }

    $mysqli->close();
?>