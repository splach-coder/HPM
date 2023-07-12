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
    header('Location: ../views/signup.php');
    exit;
}

// Store the form data in the session
$_SESSION["form_data"] = $_POST;

// Check if status field is empty
if (empty($_POST['username'])) {
    // If the user has not submitted the login form, display the login view
    $error_message = 'Invalid username or password.';
    header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
    exit();
}

// Check if status field is empty
if (empty($_POST['email'])) {
    // If the user has not submitted the login form, display the login view
    $error_message = 'Invalid lastname or password.';
    header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
    exit();
}

// Check if status field is empty
if (empty($_POST['password'])) {
    // If the user has not submitted the login form, display the login view
    $error_message = 'Invalid lastname or password.';
    header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
    exit();
}

// Check if status field is empty
if (empty($_POST['name'])) {
    // If the user has not submitted the login form, display the login view
    $error_message = 'Invalid email or password.';
    header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
    exit();
}


// sanitize user inputs
function sanitize_input($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// retrieve user inputs
$username = sanitize_input($_POST['username']);
$name = sanitize_input($_POST['name']);
$email = sanitize_input($_POST['email']);
$password = sanitize_input($_POST['password']);


// validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_message = 'Invalid email format. Please enter a valid UPM email address.';
    header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
    exit();
}

// validate password format
if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $password)) {
    $error_message = 'Invalid password format. Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.';
    header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
    exit();
}

//connect with db
$db = new db();
$conn = $db->getConnection();

if (userExists($conn, $email)) {
    $error_message = 'User with email ' . $email . ' already exists.';
    header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
    exit();
}

if (brandNameExists($conn, $email)) {
    $error_message = 'Company with brand name ' . $email . ' already exists.';
    header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
    exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = 'INSERT INTO `company`(`business_name`) VALUES (?)';
$params = [$name];

$query = new handleQuery();
$c = $query->execQuery($sql, $params);

$companyID = getSingleValue($conn, 'company', 'id', " `business_name` = '$name' ORDER BY `created_at` DESC LIMIT 1");

$sql = "INSERT INTO `users`(`username`, `email`, `password`, company_id, role_id) VALUES (?, ?, ?, ?, 'b15a4b45-026a-11ee-a4d4-089798ad5b2f')";

$params = [$username, $email, $hashed_password, $companyID];

$query = new handleQuery();
$c = $query->execQuery($sql, $params);

$defaultColorPalette = [
    ['name' => '--primary-color', 'color' => '#2A5FAB'],
    ['name' => '--dark-primary', 'color' => '#222A50'],
    ['name' => '--light-primary', 'color' => '#7BA4D8'],
    ['name' => '--dark-color', 'color' => '#232323'],
    ['name' => '--white-color', 'color' => '#ffffff'],
];

foreach ($defaultColorPalette as $color) {
    $sql1 = "INSERT INTO `color_pallete` (`name`, `color`, `company_id`) VALUES (?, ?, ?)";

    $query = new handleQuery();
    $c = $query->execQuery($sql1, [$color['name'], $color['color'], $companyID]);
}


$success_message = 'Log in with credentials please';
header('Location: ../views/login.php?message=' . $success_message . '&type=success');
exit();
