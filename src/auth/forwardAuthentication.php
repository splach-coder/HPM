<?php
//start the session
session_start();

include '../config/db.php';
include '../utils/helpers/functions.php';

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

remember_me($conn);
checkLogin();
