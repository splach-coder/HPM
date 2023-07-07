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

$search = $_GET['query'];

$query = new handleQuery();
$clients = $query->selectQuery("SELECT `id`, `business_name`
FROM `clients` 
WHERE (id LIKE ? OR business_name LIKE ?) AND company_id = '" . $_SESSION['companyID'] . "';", ["%$search%", "%$search%"]);

header('Content-Type: application/json');

// Create an associative array with the "clients" key
//$response = array("clients" => $clients);

$json_clients = json_encode($clients);

echo $json_clients;
