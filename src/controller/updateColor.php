<?php
//start the session
session_start();

// Import the DB class to handle database connections
require_once('../model/handleQuery.php');
require_once('../utils/helpers/functions.php');

// The main function that handles the login process
// Check if the user has submitted the login form
// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Invalid request method';
    exit;
}

$id = $_POST['id'];
$color = sanitizeInput($_POST['color']);

// Check if required fields are not empty
if (empty($color)) {
    // Handle the case where required fields are empty
    echo "Please fill in all required fields.";
    exit;
}

$query = "UPDATE `color_pallete` SET `color`= ? WHERE `id` = ?;";

$params = [$color, $id];

// Execute the query
$q = new handleQuery();
$res = $q->execQuery($query, $params);

if ($res > 0) {
    // If the client addition is successful
    echo "success: Color updated successfully";
} else {
    // If the client addition not successful
    echo "Error: an error Occured repeat the opration please.";
}

exit();
