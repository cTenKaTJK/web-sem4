<?php

session_start();
if (isset($_SESSION["moviename"]) && isset($_SESSION["moviegenre"]) && isset($_SESSION["movierate"])) {
    $movie_name = $_SESSION["moviename"];
    $movie_genre = $_SESSION["moviegenre"];
    $movie_rate = $_SESSION["movierate"];
    echo "фильм:\t$movie_name\nжанр:\t$movie_genre\nрейтинг:\t$movie_rate";
}

?>