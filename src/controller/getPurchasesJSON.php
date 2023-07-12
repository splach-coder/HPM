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
$purchases = $query->selectQuery("SELECT 
ps.`id`, 
p.name AS produit,
CONCAT(s.nom, ' ', s.prenom) AS supplier,
`quantity`, 
`price`,  
DATE_FORMAT(`purchase_date`, '%d %M %Y')  AS date
FROM `purchase` AS ps
INNER JOIN `products` AS  p ON  ps.product_id = p.id
INNER JOIN `suppliers` AS s ON p.supplier_id = s.id
WHERE ps.company_id = '" . $_SESSION['companyID'] . "'
ORDER BY purchase_date DESC;");

header('Content-Type: application/json');

// Create an associative array with the "clients" key
//$response = array("clients" => $clients);

$json_purchases = json_encode($purchases);

echo $json_purchases;
