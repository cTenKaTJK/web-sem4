<?php

$myNum = 201;
$answer = $myNum;

$answer += 2;
$answer *= 2;
$answer -= 2;
$answer /= 2;

$answer -= $myNum;

echo 'итоговое значение answer: ', $answer, "\n";