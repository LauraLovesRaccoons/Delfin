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

    // Process text fields
    foreach ($allowedColumnsText as $column) {
        $data[$column] = isset($_POST[$column]) ? trim($_POST[$column]) : null;
        $types .= "s";
    }

    // Process tinyint fields
    foreach ($allowedColumnsTinyint as $column) {
        $data[$column] = isset($_POST[$column]) ? (int) $_POST[$column] : 0;
        $types .= "i";
    }

    // Process approved lists checkboxes
    foreach (approved_lists_delfin() as $list) {
        $data[$list] = isset($_POST[$list]) ? 1 : 0;
        $types .= "i";
    }

    // Create the user
    if (createUser_delfin($data, $types)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Query failed"]);    // this will be added back in js ...
    }

    exit;
}

?>
