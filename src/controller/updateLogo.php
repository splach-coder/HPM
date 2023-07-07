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

//case: image changed
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

    $query = "UPDATE `company` SET `updated_at`= CURRENT_TIMESTAMP(), `logo` = ? WHERE `id`= ?";

    $params = [$fileName, $_SESSION['companyID']];

    $_SESSION['logo'] = $fileName;

    // Execute the query
    $q = new handleQuery();
    $res = $q->execQuery($query, $params);

    if ($res > 0) {
        // If the client addition is successful
        echo "Success: Logo updated successfully.";
    } else {
        // If the client addition not successful
        echo "Error: an error Occured repeat the opration please.";
    }

    exit();
}
