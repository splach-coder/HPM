<?php
//start the session
session_start();

require_once "../config/db.php";
require_once "../utils/helpers/functions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["password"]) && isset($_POST["repassword"])) {

        $password = sanitizeInput($_POST["password"]);
        $repassword = sanitizeInput($_POST["repassword"]);

        // validate password format
        if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $password)) {
            $error_message = 'Invalid password format. Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.';
            header('Location: ../views/reset-pass.php?message=' . $error_message . '&type=danger');
            exit();
        }


        if (compareStrings($password, $repassword)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $user_id = $_SESSION['id'];

            // Use PDO to query the database for a user with the provided credentials
            $db = new db();
            $conn = $db->getConnection();

            $sql = "UPDATE `users` SET `password`=? WHERE `id` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$hashed_password, $user_id]);

            header('Location: ../views/login.php?message=Your password has been updated successfully.&type=success');
            exit();
        } else {
            header('Location: ../views/reset-password/reset-pass-form.php?message=The passwords you entered do not match. Please try again.&type=danger');
            exit();
        }
    } else {
        header('Location: ../views/reset-pass.php?message=Please fill the inputs.&type=danger');
        exit();
    }
}
