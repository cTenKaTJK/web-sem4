<?php

session_start();
$_SESSION["moviename"] = $_POST["moviename"];
$_SESSION["moviegenre"] = $_POST["moviegenre"];
$_SESSION["movierate"] = $_POST["movierate"];

?>