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

if (empty($_GET['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'id filed required';
    exit;
}

$id = $_GET['id'];

$query = new handleQuery();

$supplier = $query->selectQuery("SELECT * FROM `suppliers`
WHERE id = ?  AND company_id = '" . $_SESSION['companyID'] . "' ;", [$id]);

header('Content-Type: application/json');

$json_supplier = json_encode($supplier);

echo $json_supplier;
