<?php

$arr = [1, 2, 3, 4, 5];
$average = array_sum($arr) / count($arr);
echo "среднее арифметическое: $average\n";

$sum = array_sum(range(1, 100));
echo "сумма чисел от 1 до 100: $sum\n";

$sq_arr = [1, 324, 16, 4096, 49];
$sqrt_arr = array_map('sqrt', $sq_arr);
print_r($sqrt_arr);

$letters = range('a', 'z');
$numbers = range(1, 26);
$array = array_combine($letters, $numbers);
print_r($array);

$numbers = '1234567890';
$pairs = str_split($numbers, 2);
$sumOfPairs = array_sum($pairs);
echo "Сумма попарных чисел: $sumOfPairs\n";