<?Php
function sanitizeInput($input)
{
    $clean_input = filter_var($input, FILTER_SANITIZE_STRING);
    $clean_input = trim($clean_input);
    $clean_input = stripslashes($clean_input);
    $clean_input = str_replace(array("\n", "\r", "\t"), '', $clean_input);

    return $clean_input;
}

function userExists($conn, $value)
{

    // Prepare the query
    $stmt = $conn->prepare("SELECT COUNT(*) FROM `users` WHERE `email` = ?");

    // Bind the value to the parameter
    $stmt->bindParam(1, $value);

    // Execute the query and fetch the result
    $stmt->execute();
    $count = $stmt->fetchColumn();

    // If count is greater than zero, the user exists in the database
    return $count > 0;
}

function brandNameExists($conn, $value)
{

    // Prepare the query
    $stmt = $conn->prepare("SELECT COUNT(*) FROM `company` WHERE `business_name` = ?");

    // Bind the value to the parameter
    $stmt->bindParam(1, $value);

    // Execute the query and fetch the result
    $stmt->execute();
    $count = $stmt->fetchColumn();

    // If count is greater than zero, the user exists in the database
    return $count > 0;
}




function areStringsEqual($string1, $string2)
{
    $result = strcmp($string1, $string2);

    if ($result === 0) {
        return true; // Strings are equal
    } else {
        return false; // Strings are not equal
    }
}

function removeImage($fileName, $folderPath)
{
    $filePath = $folderPath . '/' . $fileName;

    // Check if the file exists
    if (file_exists($filePath)) {
        // Attempt to delete the file
        if (unlink($filePath)) {
            return "Successfully";
        } else {
            return "Failed to remove the image '$fileName' from the folder.";
        }
    } else {
        return "Image '$fileName' not found in the folder.";
    }
}

function getSingleValue($conn, $tableName, $columnName, $condition)
{
    // Prepare the SQL query
    $query = "SELECT $columnName FROM $tableName WHERE $condition;";

    try {
        // Execute the query
        $stmt = $conn->query($query);
        $value = $stmt->fetchColumn();

        return strval($value);
    } catch (PDOException $e) {
        return "Failed to fetch the value from the database: " . $e->getMessage();
    }
}


function getStockStatus($stock)
{
    if ($stock >= 10) {
        return 'en stock';
    } elseif ($stock >= 5 && $stock <= 10) {
        return 'Stock faible';
    } elseif ($stock <= 5  && $stock >= 1) {
        return 'Stock critique';
    } else {
        return 'en rupture de stock';
    }
}

function checkLogin()
{
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
        // Redirect the user to the home page or another protected resource
        header('Location: ../views/dashboard.php');
        exit;
    }
}

function remember_me($conn)
{
    // Verify the token when the user visits the site
    if (isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];
        $sql = "SELECT `id`, `username`, `role` FROM `users` WHERE `reset_token` = ? AND `reset_token_expires_at` > NOW();";
        $user = $conn->prepare($sql)->execute([$token]);

        if ($user) {
            // Log the user in automatically
            // Store the user's session information
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['loggedIn'] = true;

            // Redirect the user to the home page or another protected resource
            header('Location: ../views/dashboard.php');
            exit;
        } else {
            //remove the cookie from the browser
            setcookie('remember_token', '', time() - 3600, '/');
        }
    }
}
