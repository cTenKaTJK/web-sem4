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

$arr0 = array(4, 2, 5, 19, 13, 0, 10);
$arrSqrt = 0;
foreach ($arr0 as $value)
    $arrSqrt += $value**2;

echo "2 в 10:   ", $st,
"\n корень из числа 245: ", $sqrtNum,
"\nкорень из суммы квадратов элементов массива: ", sqrt($arrSqrt), "\n";

$sqrt379 = sqrt(379);
$sqrt0 = round($sqrt379);
$sqrt1 = round($sqrt379, 1);
$sqrt2 = round($sqrt379, 2);

$sqrt587= sqrt(587);

echo "округления корня из 379:\n", "$sqrt0  $sqrt1  $sqrt2\n";
echo "Результат округления корня из числа 587:\nfloor: ", floor($sqrt587), "\nceil: ", ceil($sqrt587), "\n";

$arr1 = [4, -2, 5, 19, -130, 0, 10];
echo "минимум: ", min($arr1), "\nмаксимум: ", max($arr1), "\n";

echo "случайное число от 1 до 100:  ", rand(1, 100), "\n";

$arr2 = [];
echo "массив из 10 случайных чисел\n";
for ($i = 0; $i < 10; $i++) {
    $arr2[$i] = rand(1, 100);
    echo $arr2[$i], "  ";
}
echo "\n";

$a = 114;
$b = 141;
echo "модуль a - b\t", abs($a - $b), "\n";
echo "модуль b - a\t", abs($b - $a), "\n";

$arr3 = [1, 2, -1, -2, 3, -3];
echo "новый массив:\n";
for ($i = 0; $i < 6; $i++) {
    $arr3[$i] = abs($arr3[$i]);
    echo $arr3[$i], " "; 
}
echo "\n";

echo "Введите число:\t";
$a = fgets(STDIN);
$arrOfDivs = [];
echo "Делители числа {$a}:\n";
for ($div = 1; $div <= (sqrt($a) + 0.1); $div++) {
    if ($a % $div == 0) {
        echo $div, " ", ($a / $div), " ";
        $arrOfDivs[] = $div;
        $arrOfDivs[] = ($a / $div);
    }
}
echo "\n";

$array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$sum = 0;
$count = 0;
foreach ($array as $value) {
    if ($sum <= 10) {
        $sum += $value;
        $count++;
    }
}
echo "для суммы больше 10, надо сложить первые ", $count, " чисел\n";