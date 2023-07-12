<?php

//start the session
session_start();

// Import the DB class to handle database connections
require_once('../model/handleQuery.php');
require_once('../utils/helpers/functions.php');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/signup.php');
    exit;
}

// Check if status field is empty
if (empty($_POST['primaryColor'])) {
    // If the user has not submitted the login form, display the login view
    $error_message = 'Something wrong please try again.';
    header('Location: ../views/settings.php?message=' . $error_message . '&type=danger');
    exit();
}

// Check if status field is empty
if (empty($_POST['Darkprimary'])) {
    // If the user has not submitted the login form, display the login view
    $error_message = 'Something wrong please try again.';
    header('Location: ../views/settings.php?message=' . $error_message . '&type=danger');
    exit();
}

// Check if status field is empty
if (empty($_POST['Lightprimary'])) {
    // If the user has not submitted the login form, display the login view
    $error_message = 'Something wrong please try again.';
    header('Location: ../views/settings.php?message=' . $error_message . '&type=danger');
    exit();
}

// sanitize user inputs
function sanitize_input($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// retrieve user inputs
$color1 = sanitize_input($_POST['primaryColor']);
$color2 = sanitize_input($_POST['Darkprimary']);
$color3 = sanitize_input($_POST['Lightprimary']);

$defaultColorPalette = [
    ['name' => '--primary-color', 'color' => $color1],
    ['name' => '--light-primary', 'color' => $color3],
    ['name' => '--dark-primary', 'color' => $color2],
    ['name' => '--white-color', 'color' => '#ffffff'],
    ['name' => '--dark-color', 'color' => "#232323"]
];

foreach ($defaultColorPalette as $color) {
    $sql1 = "UPDATE `color_pallete` SET `color`= ? WHERE `name` = ? AND  `company_id` = ?";

    $query = new handleQuery();
    $c = $query->execQuery($sql1, [$color['color'], $color['name'], $_SESSION['companyID']]);
}
