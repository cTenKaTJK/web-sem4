<?php

$arr0 = [];
for ($i = 1; $i <= 10; $i++)
    $arr0[$i] = str_repeat('x', $i);
print_r($arr0);

function arrayFill($value, $count): array {
    $arr1 = [];
    for ($i = 0; $i < $count; $i++)
        $arr1[$i] = $value;
    return $arr1;
}
print_r(arrayFill('0', 5));

$arr2 = [[1, 2, 3], [4, 5], [6]];
$arr2Sum = array_sum(array_merge(...$arr2));
echo "Сумма элементов массива:\t$arr2Sum\n";

$arr3 = [];
for ($i = 0; $i < 3; $i++) {
    for ($j = 1; $j <= 3; $j++)
        $arr3[$i][] = $i * 3 + $j;
}
print_r($arr3);

$arr4 = [2, 5, 3, 9];
$result = $arr4[0] * $arr4[1] + $arr4[2] * $arr4[3];
echo "result:\t$result\n";

$user = ['name' => 'Степан', 'surname' => 'Лапшин', 'patronymic' => 'Александрович'];
echo $user['surname'], " ", $user['name'], " ", $user['patronymic'], "\n";


$date = ['year' => date('Y'), 'month' => date('m'), 'day' => date('d')];
echo $date['year'] . '-' . $date['month'] . '-' . $date['day'], "\n";

$arr = ['a', 'b', 'c', 'd', 'e'];
echo "Количество элементов в массиве:\t", count($arr), "\n";

echo "Последний эллемент в массиве:\t\t", end($arr), "\n";

echo "Предпоследний элемент в массиве:\t", prev($arr), "\n";