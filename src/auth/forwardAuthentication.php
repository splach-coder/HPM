<?php
//start the session
session_start();

include '../model/handleQuery.php';
include '../utils/helpers/functions.php';

remember_me();
checkLogin();
