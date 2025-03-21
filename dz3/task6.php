<?php

$a = 10;
$b = 3;
echo $a % $b, "\n";

echo "переменная a: ";
$a = fgets(STDIN);
echo "переменная b: ";
$b = fgets(STDIN);
if ($a % $b == 0)
    echo "делится ", $a / $b, "\n";
else
    echo "делится с остатком ", $a % $b, "\n";

$st = 2 ** 10;
$sqrt = 245**1/2;

$array = array(4, 2, 5, 19, 13, 0, 10);
$arrSqrt = 0;
foreach ($array as $value)
    $arrSqrt += $value**2;

echo "2 в 10:   ", $st,
"\n корень из числа 245: ", $sqrtNum,
"\nкорень из суммы квадратов элементов массива: ", sqrt($arrSqrt), "\n";

$num = sqrt(379);
$sqrtNum0 = round($num);
$sqrtNum1 = round($num, 1);
$sqrtNum2 = round($num, 2);