<?php

//start the session
session_start();


// Import the DB class to handle database connections
require_once('../config/db.php');
require_once('../utils/helpers/functions.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $token = $_GET["token"];

    // Use PDO to query the database for a user with the provided credentials
    $db = new db();
    $conn = $db->getConnection();

    $sql = "SELECT `id`, `reset_token`, `reset_token_expires_at` FROM `users`  WHERE `reset_token` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION["id"] = $user["id"];
        $timestamp = $user["reset_token_expires_at"];

        // Check if the token has expired (1 hour)
        if (checkOneHourElapsed($timestamp)) {
            // Token is valid, show the password reset form
            header("Location: ../views/reset-pass.php");
            exit();
        } else {
            // Token has expired, display an error message
            echo 'Password reset token has expired. Please resubmit your email to generate a new token. ';
        }
    } else {
        // Token is invalid, display an error message
        echo 'Sorry some thing got wrong. Please resubmit your email to reset a new password. ';
    }
}
