<?php

$text = $_POST["textarea"];
$matches = array();
$regexp = '/( [a-zёа-я]-[a-zёа-я] )/ui';

$count = preg_match_all($regexp, $text, $matches);
echo "В тесте $count слов с дефисом\n";
?>