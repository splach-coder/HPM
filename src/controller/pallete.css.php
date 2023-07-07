<?php

require_once '../model/handleQuery.php';

$query = new handleQuery();
$colors = $query->selectQuery('SELECT * FROM `color_pallete`');

header("Content-type: text/css");

$cssString = ":root {";
foreach ($colors as $color) {
    $cssString .= strtolower($color['name']) . ": " . $color['color'] . ";";
}
$cssString .= "}";

echo $cssString;
