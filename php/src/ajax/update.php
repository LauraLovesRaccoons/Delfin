<?php

require "../functions.php";     //? i need to head to load it from the previous folder

// I'm not messing around with wannabe hackerz
session_checker_delfin();


// functions
function updateUser_delfin($id, $selectedList)
{
    $db = db_connect_delfin();
    $fieldValue = 0;    // tinyint 0 means false

    $query = "UPDATE Users SET $selectedList = ? WHERE id = ?";
    $stmt = $db->prepare($query);


    $stmt->bind_param("ii", $fieldValue, $id);
    $result = $stmt->execute();

    $stmt->close();
    db_close_delfin($db);

    return $result;
};


// AJAX

// Update User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['column'], $_POST['value'])) {
    $id = (int) $_POST['id'];
    $column = $_POST['column'];
    $value = trim($_POST['value']);

    // Only allow updates to specific columns
    $allowedColumns = ['nom'];
    if (!in_array($column, $allowedColumns)) {
        exit('Invalid column');
    }

    $db = db_connect_delfin();
    $query = "UPDATE Users SET $column = ? WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("si", $value, $id);
    $stmt->execute();

    $stmt->close();
    db_close_delfin($db);
    exit;
}

?>

