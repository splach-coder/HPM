<?Php
function sanitizeInput($input)
{
    $clean_input = filter_var($input, FILTER_SANITIZE_STRING);
    $clean_input = trim($clean_input);
    $clean_input = stripslashes($clean_input);
    $clean_input = htmlentities($clean_input, ENT_QUOTES, 'UTF-8');
    $clean_input = str_replace(array("\n", "\r", "\t"), '', $clean_input);

    return $clean_input;
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
    $query = "SELECT $columnName FROM $tableName WHERE $condition";

    try {
        // Execute the query
        $stmt = $conn->query($query);
        $value = $stmt->fetchColumn();

        return strval($value);
    } catch (PDOException $e) {
        return "Failed to fetch the value from the database: " . $e->getMessage();
    }
}
