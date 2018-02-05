<?php

require_once('functions.php');

$header = include('header.php');
$footer = include('footer.php');
$input_data = include('config.php');

$result = "";

$placeholders = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
];

checkForIntersects($input_data);

foreach ($input_data as $text_block) {
    $cells = explode(',', $text_block['cells']);
    $min = min($cells);
    $max = max($cells);
    $bounds = getGridBounds($min, $max, $placeholders);
    $result .= getHTMLFromData($text_block, $bounds);
}

echo $header . $result . $footer;
