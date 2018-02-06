<?php

require_once('functions.php');

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
    $bounds = getGridBounds($placeholders, $cells);
    $result .= getHTMLFromData($text_block, $bounds);
}

return $result;
