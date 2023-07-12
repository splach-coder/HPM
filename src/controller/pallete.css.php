<?php

require_once '../model/handleQuery.php';

$query = new handleQuery();
$colors = $query->selectQuery("SELECT * FROM `color_pallete` WHERE `company_id` = '248a3a2f-026a-11ee-a4d4-089798ad5b2f';");

header("Content-type: text/css");

$cssString = ":root {";
foreach ($colors as $color) {
    $cssString .= strtolower($color['name']) . ": " . $color['color'] . ";";
}
$cssString .= "}";

echo $cssString;
