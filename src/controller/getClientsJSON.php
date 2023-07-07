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
$clients = $query->selectQuery("SELECT c.`id`, `business_name`, `first_name`, `last_name`, g.name as `gender`,  `email`, `phone` FROM `clients` c
INNER JOIN `gender` g where g.id = c.gender AND company_id = '" . $_SESSION['companyID'] . "'");

header('Content-Type: application/json');

// Create an associative array with the "clients" key
//$response = array("clients" => $clients);

$json_clients = json_encode($clients);

echo $json_clients;
