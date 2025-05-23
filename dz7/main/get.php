<?php
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