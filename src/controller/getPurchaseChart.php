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

if (empty($_GET['month'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'id filed required';
    exit;
}

$month = date("m");

$query = new handleQuery();

$purchases = $query->selectQuery("SELECT UNIX_TIMESTAMP(DATE(`purchase_date`)) * 1000 AS date,  CAST(SUM(`price`) AS DECIMAL(10, 2)) AS value
FROM `purchase`
WHERE MONTH(`purchase_date`) = ?
AND company_id = '" . $_SESSION['companyID'] . "' 
GROUP BY date;", [$month]);


header('Content-Type: application/json');

$json_purchases = json_encode($purchases);

echo $json_purchases;
