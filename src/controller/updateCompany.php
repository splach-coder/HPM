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
$business_name = sanitizeInput($_POST['name']);
$address_line1 = sanitizeInput($_POST['address1']);
$address_line2 = sanitizeInput($_POST['address2']);
$postal_code = sanitizeInput($_POST['zip']);
$city = sanitizeInput($_POST['city']);
$country = sanitizeInput($_POST['country']);
$telephone = sanitizeInput($_POST['telephone']);
$mobile = sanitizeInput($_POST['mobile']);
$fax = sanitizeInput($_POST['fax']);
$email = sanitizeInput($_POST['email']);


// Check if required fields are not empty
if (empty($business_name) || empty($city)) {
    // Handle the case where required fields are empty
    echo "Please fill in all required fields.";
    exit;
}

$query = "UPDATE `company` SET `business_name`= ? ,`address_line1`= ? ,`address_line2`= ? ,`postal_code`= ? ,`city`= ? ,`country`= ? ,`telephone`= ? ,`mobile`= ?,`fax`= ? ,`email`= ? , `updated_at`= CURRENT_TIMESTAMP() WHERE `id`= ?";

$params = [$business_name, $address_line1, $address_line2, $postal_code, $city, $country, $telephone, $mobile, $fax, $email,  $_SESSION['companyID']];

// Execute the query
$q = new handleQuery();
$res = $q->execQuery($query, $params);

if ($res > 0) {
    $_SESSION['business_name'] = $business_name;
    $_SESSION['city'] = $city;

    // If the client addition is successful
    echo "Success: Company Infos updated successfully.";
} else {
    // If the client addition not successful
    echo "Error: an error Occured repeat the opration please.";
}

exit();
