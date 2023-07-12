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
    header('Location: ../views/login.php');
    exit;
}


if (isset($_POST['email']) && isset($_POST['password'])) {

    // Get the user's credentials from the form submission
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize the input using the function
    $sanitizedEmail = sanitizeInput($email);
    $sanitizedPassword = sanitizeInput($password);

    $query = new handleQuery();
    $user = $query->selectQuery("SELECT u.`id`, u.`username`, u.`fullname`, u.`email`, u.`password`, r.name AS 'role', company_id, image, c.`business_name` , c.`city`, c.`logo`
    FROM `users` AS u
    INNER JOIN `company` AS c ON u.company_id = c.id
    INNER JOIN `roles` AS r ON u.role_id = r.id
    WHERE u.`email` = ?", [$sanitizedEmail]);


    // If a user is found with the provided username, check their password
    if ($user && password_verify($sanitizedPassword, $user[0]['password'])) {
        if (isset($_POST['rememberme'])) {
            // Generate a random token and store it in a cookie
            $token = bin2hex(openssl_random_pseudo_bytes(16));

            setcookie('remember_token', $token, time() + (86400 * 30), '/'); // Cookie expires in 30 days

            // Store the token in the database
            $user_id = $user[0]['id']; // Replace with the actual user ID

            $expiry_date = date('Y-m-d H:i:s', time() + (86400 * 30)); // Token expires in 30 days

            $sql = "UPDATE `users` SET `remember_me_token`=?,`remember_me_token_expires_at`= ? WHERE `id`= ? ;";

            $query = new handleQuery();
            $res = $query->execQuery($sql, [$token, $expiry_date, $user_id]);
        }

        // Store the user's session information
        $_SESSION['id'] = $user[0]['id'];
        $_SESSION['companyID'] = $user[0]['company_id'];
        $_SESSION['business_name'] = $user[0]['business_name'];
        $_SESSION['city'] = $user[0]['city'];
        $_SESSION['logo'] = $user[0]['logo'];
        $_SESSION['username'] = $user[0]['username'];
        $_SESSION['fullname'] = $user[0]['fullname'];
        $_SESSION['email'] = $user[0]['email'];
        $_SESSION['role'] = $user[0]['role'];
        $_SESSION['image'] = $user[0]['image'];
        $_SESSION['loggedIn'] = true;

        header('Location: ../views/dashboard.php');
        exit;
    } else {
        // If the user's credentials are invalid, display an error message
        $error_message = 'Invalid username or password.';
        header('Location: ../views/login.php?message=' . $error_message . '&type=danger');
        exit();
    }
}
