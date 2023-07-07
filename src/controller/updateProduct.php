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

$id = $_POST['id'];

// Sanitize and retrieve the form inputs
$produitNom = sanitizeInput($_POST['Show-produitNom']);
$category = sanitizeInput($_POST['Show-category']);
$unit = sanitizeInput($_POST['Show-unit']);
$activite = sanitizeInput($_POST['Show-activite']);
$prix = sanitizeInput($_POST['Show-prix']);
$stock = sanitizeInput($_POST['Show-stock']);
$margeht = sanitizeInput($_POST['Show-margeht']);
$margeht100 = sanitizeInput($_POST['Show-margeht100']);
$prixvente = sanitizeInput($_POST['Show-prixvente']);
$note = sanitizeInput($_POST['Show-note']);
$desc = sanitizeInput($_POST['Show-desc']);

// Check if required fields are not empty
if (empty($produitNom) || empty($prix) || empty($prixvente) || empty($margeht100) || empty($margeht)  || $category === "none"   || $unit === "none" || $activite === "none") {
    // Handle the case where required fields are empty
    echo "Please fill in all required fields.";
    exit;
}

$part = '';
$companyID = '248a3a2f-026a-11ee-a4d4-089798ad5b2f';

if (isset($_POST['suppliers_list'])) {
    $supplier = sanitizeInput($_POST['suppliers_list']);
    $part = " `supplier_id`= ' $supplier' , ";
}

$query = "UPDATE `products` 
SET `name`=?,`description`=?,`purchase_price`=?,`selling_price`=?,`gross_margin`=?,`stock`=?,  `stock_status`= ?, `Note`= ?, `updated_at`= CURRENT_TIMESTAMP() ,`last_purchase`=  CURRENT_TIMESTAMP() ,`unit`=?,`activity`= ?,  $part  `family_id`=? ,`gorss_margin_100`=?
WHERE `id` = ?";

$stockStatus = getStockStatus($stock);

$params = [$produitNom, $desc, $prix, $prixvente, $margeht, $stock, $stockStatus, $note, $unit, $activite, $category, $margeht, $id];

// Execute the query
$q = new handleQuery();
$res = $q->execQuery($query, $params);


// Assuming you have an array of file inputs with the name "image[]"
if (isset($_FILES['images'])) {
    // Set upload directory
    $uploadDir = '../static/images/products/';

    // Retrieve the array of files
    $files = $_FILES['images'];

    // Iterate through each file
    for ($i = 0; $i < count($files['name']); $i++) {
        $name = $files['name'][$i];

        // Check if file was uploaded without errors
        if ($files['error'][$i] !== UPLOAD_ERR_OK) {
            header('HTTP/1.1 500 Internal Server Error');
            echo 'Failed to upload file: ' . $name;
            exit;
        }

        // Check file type
        $allowedTypes = array('image/png', 'image/jpeg', 'image/jpg');

        if (!in_array($files['type'][$i], $allowedTypes)) {
            header('HTTP/1.1 400 Bad Request');
            echo 'Invalid file type: ' . $name;
            exit;
        }

        // Check file size
        $maxImageSize = 2 * 1024 * 1024; // 2MB

        if (
            in_array($files['type'][$i], array_slice($allowedTypes, 0, 3))
            && $files['size'][$i] > $maxImageSize
        ) {
            header('HTTP/1.1 400 Bad Request');
            echo 'File size exceeds limit: ' . $name;
            exit;
        }

        // Generate unique file name
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $extension;
        $targetFile = $uploadDir . $fileName;

        // Save file to upload directory
        if (!move_uploaded_file($files['tmp_name'][$i], $targetFile)) {
            header('HTTP/1.1 500 Internal Server Error');
            echo 'Failed to upload file: ' . $name;
            exit;
        }

        // Execute the query
        $qs = new handleQuery();
        $res = $qs->execQuery("INSERT INTO `product_images`( `product_id`, `image_url`) VALUES (?, ?)", [$id,  $fileName]);
    }
}


if ($res > 0) {
    // If the client addition is successful
    echo "Success: Product updated successfully.";
} else {
    // If the client addition not successful
    echo "Error: an error Occured repeat the opration please.";
}

exit();
