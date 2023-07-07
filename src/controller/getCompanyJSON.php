<?php
//start the session
session_start();
// Import the DB class to handle database connections
require_once('../model/handleQuery.php');

// The main function that handles the login process
// Check if the user has submitted the login form
// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Invalid request method';
    exit;
}

$query = new handleQuery();
$colors = $query->selectQuery("SELECT `business_name`, `address_line1`, `address_line2`, `postal_code`, `city`, `country`, `telephone`, `mobile`, `fax`, `email` FROM `company` WHERE `id` = '" . $_SESSION['companyID'] . "' ;");

header('Content-Type: application/json');

$json_colors = json_encode($colors);

echo $json_colors;
