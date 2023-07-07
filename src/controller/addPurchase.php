<?php
//start the session
session_start();

// Import the DB class to handle database connections
require_once('../model/handleQuery.php');
require_once('../utils/helpers/functions.php');

// The main function that handles the login process
// Check if the user has submitted the login form
// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Invalid request method';
    exit;
}


// Sanitize and retrieve the form inputs
$produitID = sanitizeInput($_POST['produitID']);
$prix = sanitizeInput($_POST['prixActuel']);
$stock = sanitizeInput($_POST['stockActuel']);
$note = sanitizeInput($_POST['note']);


// Check if required fields are not empty
if (empty($produitID) || empty($prix) || empty($stock)) {
    // Handle the case where required fields are empty
    echo "Please fill in all required fields.";
    exit;
}

$companyID =  $_SESSION['companyID'];

$query = "INSERT INTO `purchase`(`product_id`, `company_id`, `quantity`, `price`, `Note`) VALUES (?, ?, ?, ?, ?)";

$params = [$produitID, $companyID, $stock, $prix, $note];

// Execute the query
$q = new handleQuery();
$res = $q->execQuery($query, $params);


$queryU = "UPDATE `products` SET `stock` = `stock` + ? WHERE `id` = ?";
$paramsU = [$stock, $produitID];

// Execute the query
$qU = new handleQuery();
$resU = $qU->execQuery($queryU, $paramsU);


if ($res > 0) {
    // If the client addition is successful
    echo "Success: Purchase Affectted successfully.";
} else {
    // If the client addition not successful
    echo "Error: an error Occured repeat the opration please.";
}

exit();
