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
$raisonSocial = sanitizeInput($_POST['raisonSocial']);
$nom = sanitizeInput($_POST['nom']);
$prenom = sanitizeInput($_POST['prenom']);
$gender = sanitizeInput($_POST['gender']);
$email = sanitizeInput($_POST['email']);
$phone = sanitizeInput($_POST['phone']);
$codePostal = sanitizeInput($_POST['codePostal']);
$city = sanitizeInput($_POST['city']);
$country = sanitizeInput($_POST['country']);
$address1 = sanitizeInput($_POST['adress1']);
$address2 = sanitizeInput($_POST['adress2']);

// Check if required fields are not empty
if (empty($raisonSocial) || empty($nom) || empty($prenom) || $gender === "none") {
    // Handle the case where required fields are empty
    echo "Please fill in all required fields.";
    exit;
}

$query = '';
$params = [];
$companyID = $_SESSION['companyID'];

if (isset($_FILES['image'])) {
    // Set upload directory
    $uploadDir = '../static/images/';

    $name = $_FILES['image']['name'];

    // Check if file was uploaded without errors
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        header('HTTP/1.1 500 Internal Server Error tchak');
        echo 'Failed to upload file: ' . $name;
        exit;
    }

    // Check file type
    $allowedTypes = array('image/png', 'image/jpeg', 'image/jpg');

    if (!in_array($_FILES['image']['type'], $allowedTypes)) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Invalid file type: ' . $name;
        exit;
    }

    // Check file size
    $maxImageSize = 2 * 1024 * 1024; // 2MB

    if (
        in_array($_FILES['image']['type'], array_slice($allowedTypes, 0, 3))
        && $_FILES['image']['size'] > $maxImageSize
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
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        header('HTTP/1.1 500 Internal Server Error');
        echo 'Failed to upload file: ' . $name;
        exit;
    }

    $query = "INSERT INTO `clients` (
        `business_name`, `first_name`, `last_name`, `address1`, `address2`, `code_postale`, `Ville`, `Pays`, `phone`, `email`, `gender`, `company_id`, `image`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [$raisonSocial, $prenom, $nom, $address1, $address2, $codePostal, $city, $country, $phone, $email, $gender, $companyID, $fileName];
} else {
    $query = "INSERT INTO `clients` (
        `business_name`, `first_name`, `last_name`, `address1`, `address2`, `code_postale`, `Ville`, `Pays`, `phone`, `email`, `gender`, `company_id`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [$raisonSocial, $prenom, $nom, $address1, $address2, $codePostal, $city, $country, $phone, $email, $gender, $companyID];
}

// Execute the query
$q = new handleQuery();
$res = $q->execQuery($query, $params);

if ($res > 0) {
    // If the client addition is successful
    echo "Success: Client added successfully.";
} else {
    // If the client addition not successful
    echo "Error: an error Occured repeat the opration please.";
}

exit();
