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
$sales = $query->selectQuery("SELECT 
ps.`id`, 
p.name AS produit,
CONCAT(c.last_name, ' ', c.first_name) AS client,
`quantity`, 
`price`,  
DATE_FORMAT(`sale_date`, '%d %M %Y')  AS date
FROM `sales` AS ps
INNER JOIN `products` AS  p ON  ps.product_id = p.id
INNER JOIN `clients` AS c ON c.id = ps.client_id
WHERE ps.company_id = '" . $_SESSION['companyID'] . "'
ORDER BY sale_date DESC;");

header('Content-Type: application/json');

// Create an associative array with the "clients" key
//$response = array("clients" => $clients);

$json_sales = json_encode($sales);

echo $json_sales;
