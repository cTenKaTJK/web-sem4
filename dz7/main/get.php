<?php
    $mysql = new mysqli('db', 'root', 'helloword', 'web');

    if (mysqli_connect_errno()) {
        echo mysqli_connect_error() . "ошибка подключения к БД";
    }

    $adverts = [];

    if ($result = $mysqli->query('SELECT * FROM ad ORDER BY created DESC')) {
        while ($row = $result->fetch_assoc()) {
            $adverts[] = $row;
        }
        $result->close();
    }
    $mysqli->close();

    return $adverts;
?>
