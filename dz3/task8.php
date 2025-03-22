<?php

function increaseEnthusiasm($str): string {
    return $str . "!";
}
echo increaseEnthusiasm("hello, world"), "\n";

function repeatThreeTimes($str): string {
    return $str . $str . $str;
}
echo repeatThreeTimes("repeat"), "\n";

echo increaseEnthusiasm(repeatThreeTimes("A")), "\n";

function cut($str, $len = 10): string {
    return substr($str, 0, $len);
}
echo cut("abcdefghijklmnopqrstuvwxyz"), "\n";

function printArrayRecursively($arr, $index = 0) {
    if ($index < count($arr)) { 
        echo $arr[$index], " "; 
        printArrayRecursively($arr, $index + 1);
    }
}
$arr = [1, 2, 3, 4, 5];
printArrayRecursively($arr);
echo "\n";

function digitSum($num) {
    if ($num <= 9) {
        return $num;
    }

    return digitSum(array_sum(str_split($num)));
}
echo digitSum(2048), "\n"; 
echo digitSum(101), "\n"; 