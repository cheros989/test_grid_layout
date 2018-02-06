<?php

/**
*
* @author Roman Pavliukov
* @param integer $min is minimal value of cells array
* @param integer $max is maximal value of cells array
* @param array $placeholders is array with placeholders numbers for grid
* @return array with start & end positions for grid css layout
*/
function getGridBounds($placeholders, $cells) : array {

    $min = min($cells);
    $max = max($cells);
    $cells = array_unique($cells);
    $start_pos = ['row' => 0, 'col' => 0];
    $end_pos = ['row' => 0, 'col' => 0];
    $row_position = 0;
    $column_position = 0;

    foreach ($placeholders as $row) {

        foreach ($row as $col) {
            if ($min == $col) {
                $start_pos = ['row' => $row_position, 'col' => $column_position];
            }
            if ($max == $col) {
                $end_pos = ['row' => $row_position, 'col' => $column_position];
            }
            $column_position++;
        }

        $row_position++;
        $column_position = 0;
    }

    $positions = [
        'start_pos' => $start_pos,
        'end_pos' => $end_pos
    ];

    if (!isValidRectangle($positions, $cells, $placeholders)) {
        throw new Exception("Неправильные прямоугольники!");
    }

    return $positions;
}

/**
*
* @author Roman Pavliukov
* @param array $text_block with all config data
* @param array $bounds with positions for rectangles
* @return string result HTML for one element
*/
function getHTMLFromData($text_block, $bounds) : string {

    $start_column = $bounds['start_pos']['col'] + 1;
    $end_column = $bounds['end_pos']['col'] + 2;
    $start_row = $bounds['start_pos']['row'] + 1;
    $end_row = $bounds['end_pos']['row'] + 2;
    $bg_color = $text_block["bgcolor"];
    $color = $text_block["color"];
    $align = $text_block["align"];
    $valign = $text_block['valign'];
    $text = $text_block["text"];

    return "
    <div style='grid-column:
    $start_column / $end_column; grid-row: $start_row / $end_row;
    background-color: $bg_color; color:  $color; text-align: $align;'>
    <p class='$valign'>$text</p>
    </div>";
}

/**
* @author Roman Pavliukov
* @param array $input_data with all config data
* @throws Exception if rectangles have intersects
* @return void
*/
function checkForIntersects($input_data) : void {
    $all_cells = [];
    foreach ($input_data as $text_block) {
        $cells = explode(',', $text_block['cells']);
        $intersects = array_intersect($all_cells, $cells);
        if (!empty($intersects)) {
            throw new Exception("Введены некоректные данные. Ячейки пересекаются!!!");
        }
        $all_cells = array_merge($all_cells, $cells);
    }
}

/**
*
* Validation of rectangle
* @author Roman Pavliukov
* @param array $positions
* @param array $cells
* @param array $placeholders
* @return bool
*/
function isValidRectangle($positions, $cells, $placeholders) : bool {
    $start_pos = $positions['start_pos'];
    $end_pos = $positions['end_pos'];
    $correct_rect_placeholders = [];

    if ($start_pos['row'] > $end_pos['row'] || $start_pos['col'] > $end_pos['col']) {
        return false;
    }

    for ($row = $start_pos['row']; $row <= $end_pos['row']; $row++) {
        for ($col = $start_pos['col']; $col <= $end_pos['col']; $col++) {
            $correct_rect_placeholders[] = $placeholders[$row][$col];
        }
    }

    return arrayIdent($cells, $correct_rect_placeholders);
}

/**
*
* Function to check arrays identical
* @author Roman Pavliukov
* @param array $array1
* @param array $array2
* @return bool
*/
function arrayIdent($array1, $array2) : bool {
    if (count($array1) == count($array2))
        if (empty(array_diff($array1, $array2)))
            return true;

    return false;
};
