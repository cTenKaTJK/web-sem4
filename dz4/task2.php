<?php

#   вариант 11
$str = "a1b2c3";
$regexp = "/[0-9]+/";
$output = preg_replace_callback(
    $regexp,
    function ($match) {
        return $match[0] ** 4;
    },
    $str
);
echo $output. "\n";
?>