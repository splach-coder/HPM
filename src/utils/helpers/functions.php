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

function checkOneHourElapsed($datetime)
{
    // Convert MySQL datetime string to Unix timestamp
    $datetimeTimestamp = $datetime;

    // Calculate the Unix timestamp for one hour ago
    $oneHourAgoTimestamp = time() - 3600;

    // Compare the given datetime timestamp with one hour ago
    if ($datetimeTimestamp >= $oneHourAgoTimestamp) {
        // Return true if less than one hour has elapsed
        return true;
    } else {
        // Return false if more than one hour has elapsed
        return false;
    }
}


function compareStrings($string1, $string2)
{
    // Compare the two strings using the strcmp() function
    $result = strcmp($string1, $string2);

    // Return true if the result is 0 (i.e. the strings are equal)
    // Otherwise, return false
    return $result === 0;
}

function remember_me()
{
    // Verify the token when the user visits the site
    if (isset($_COOKIE['remember_token'])) {

        $token = $_COOKIE['remember_token'];

        $sql = "SELECT u.`id`, u.`username`, u.`fullname`, u.`email`, u.`password`, r.name AS 'role', company_id, image, c.`business_name` , c.`city`, c.`logo`
        FROM `users` AS u
        INNER JOIN `company` AS c ON u.company_id = c.id
        INNER JOIN `roles` AS r ON u.role_id = r.id
        WHERE u.remember_me_token = ? AND u.remember_me_token_expires_at > NOW();";

        $query = new handleQuery();
        $user = $query->selectQuery($sql, [$token]);

        if ($user) {
            // Log the user in automatically
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

            // Redirect the user to the home page or another protected resource
            header('Location: ../views/dashboard.php');
            exit;
        } else {

            //remove the cookie from the browser
            setcookie('remember_token', '', time() - 3600, '/');
            // unset all session variables
            $_SESSION = array();

            // destroy the session
            session_destroy();
        }
    }
}
