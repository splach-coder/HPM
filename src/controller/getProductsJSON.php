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
$products = $query->selectQuery("SELECT p.`id`, p.`name`, `purchase_price`, `gross_margin`, `stock_status`, u.name AS `unit`, f.name AS `family` FROM `products` AS p
INNER JOIN `family` AS f ON f.id = p.family_id
INNER JOIN `units` AS u ON u.id = p.unit
WHERE p.company_id = '" . $_SESSION['companyID'] . "' ;");

header('Content-Type: application/json');

// Create an associative array with the "clients" key
//$response = array("clients" => $clients);

$json_products = json_encode($products);

echo $json_products;
