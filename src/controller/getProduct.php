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

$products = $query->selectQuery("SELECT p.*, CONCAT(s.nom, ' ', s.prenom, '  |  ', s.business_name) AS 'supplier' FROM `products` AS p
INNER JOIN `suppliers` AS s 
ON p.supplier_id = s.id
WHERE p.id = ? AND p.company_id = '" . $_SESSION['companyID'] . "'", [$id]);

$images = $query->selectQuery("SELECT `id`, `image_url` FROM `product_images` WHERE  `product_id` = ? ORDER BY `created_at` DESC;", [$id]);

// Add the images array as a field in the products array
$products[0]['images'] = $images;

header('Content-Type: application/json');

$json_products = json_encode($products);

echo $json_products;
