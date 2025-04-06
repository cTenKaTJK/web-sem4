<?php

#   вариант 11
$str = "kick kock kkkkiukeck pipka krak";
$regexp = "/(?=(k..k))/u";
$match_arr = array();

$count = preg_match_all($regexp, $str, $match_arr);
echo "количество совпадений:\t{$count}\n";
var_dump($match_arr);
?>