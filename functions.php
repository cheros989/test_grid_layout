<?php

/**
*
* @author Roman Pavliukov
* @param integer $min is minimal value of cells array
* @param integer $max is maximal value of cells array
* @param array $placeholders is array with placeholders numbers for grid
* @return array with start & end positions for grid css layout
*/
function getGridBounds($min, $max, $placeholders) : array {

    $start_pos = ['row' => 0, 'col' => 0];
    $end_pos = ['row' => 0, 'col' => 0];
    $row_position = 1;
    $column_position = 1;

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
        $column_position = 1;
    }

    return [
        'start_pos' => $start_pos,
        'end_pos' => $end_pos
    ];
}

/**
*
* @author Roman Pavliukov
* @param array $text_block with all config data
* @param array $bounds with positions for rectangles
* @return string result HTML for one element
*/
function getHTMLFromData($text_block, $bounds) : string {
    return "
    <div style='grid-column:"
    . $bounds['start_pos']['col'] . "/" . ($bounds['end_pos']['col'] + 1)
    . "; grid-row:" . $bounds['start_pos']['row'] . "/" . ($bounds['end_pos']['row'] + 1)
    . "; background-color:" . $text_block["bgcolor"]
    . "; color:" . $text_block["color"]
    . "; text-align: " . $text_block["align"]
    . "'>" . "<p class='". $text_block['valign'] . "'>" . $text_block["text"]
    . "</p></div>";
}

/**
* @author Roman Pavliukov
* @param array $input_data with all config data
* @throws Exception if rectangles have intersects
* @return void
*/
function checkForIntersects($input_data) {
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
