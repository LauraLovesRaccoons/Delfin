<?php

require "../functions.php";     //? i need to head to load it from the previous folder

// I'm not messing around with wannabe hackerz
session_checker_delfin();


// functions
function createUser_delfin($data, $types)
{
    $db = db_connect_delfin();

    // construct query
    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), "?"));
    $query = "INSERT INTO Users ($columns) VALUES ($placeholders)";

    $stmt = $db->prepare($query);

    // construct bind params
    $stmt->bind_param($types, ...array_values($data));

    $result = $stmt->execute();

    $stmt->close();
    db_close_delfin($db);

    return $result;
};


// AJAX

// CREATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $allowedColumnsText, $allowedColumnsTinyint; // I have to call these as globals

    // Collect and sanitize input data
    $data = [];
    $types = ""; // For bind_param types

    // 

    // Sanitize text fields (strip tags, trim, limit length, etc.)
    foreach ($allowedColumnsText as $column) {
        $value = isset($_POST[$column]) ? trim($_POST[$column]) : null;

        if ($value !== null) {
            $value = trim($value);
            $value = substr($value, 0, 250);    // varchar 255 with some wiggle room
            // // $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); // I'm not messing around ;)
        }
        else {
            $value = null;  // technically not needed since it was null before
        }

        $data[$column] = $value;
        $types .= "s";
    }

    // Sanitize tinyint fields
    foreach ($allowedColumnsTinyint as $column) {
        $data[$column] = isset($_POST[$column]) && $_POST[$column] === "1" ? 1 : 0;
        $types .= "i";
    }

    // Sanitize approved lists
    foreach (approved_lists_delfin() as $list) {
        $data[$list] = isset($_POST[$list]) && $_POST[$list] === "1" ? 1 : 0;
        $types .= "i";
    }

    // Create the user
    if (createUser_delfin($data, $types)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Query failed"]);
    }

    exit;
}

?>
