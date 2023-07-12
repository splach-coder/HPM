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

$purchases = $query->selectQuery("SELECT `ps`.`id`, 
`p`.`name` AS name, 
`s`.`business_name` AS client, 
`ps`.`price`, 
`quantity`,
`ps`.`Note`,
DATE_FORMAT(`sale_date`, '%d %M %Y')  AS date 
FROM `sales` AS ps
INNER JOIN `products` AS p ON p.id = ps.product_id
INNER JOIN `clients` AS s ON s.id = ps.client_id
WHERE  `ps`.`id` = ? AND ps.company_id = '" . $_SESSION['companyID'] . "'", [$id]);


header('Content-Type: application/json');

$json_purchases = json_encode($purchases);

echo $json_purchases;
