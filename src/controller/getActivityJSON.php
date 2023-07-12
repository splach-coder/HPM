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

$companyID =  $_SESSION['companyID'];

$query = new handleQuery();
$activity = $query->selectQuery("SELECT * FROM activity WHERE `company_id` = '$companyID' OR def = 'default'");

header('Content-Type: application/json');

$json_activity = json_encode($activity);

echo $json_activity;
