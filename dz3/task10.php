<?php
function moreThanTen($a, $b): bool {
    return ($a + $b) > 10;
}
echo moreThanTen(11, 1), "\n";

function areEqual($a, $b): bool {
    return $a === $b;
}
echo areEqual(1, 1), "\n";

$test = 0;
echo ($test == 0) ? 'верно' : '', "\n";

$age = 20;
if ($age < 10 || $age > 99)
    echo "число меньше 10 или больше 99\n";
else {
    $sum = array_sum(str_split((string)$age));
    if ($sum <= 9)
        echo "Сумма цифр однозначна\n";
    else
        echo "Сумма цифр двузначна\n";
}

$arr = [1, 1, 1];
if (count($arr) == 3) {
    echo "Сумма элементов массива:\t", array_sum($arr) . "\n";
}