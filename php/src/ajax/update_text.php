<?php

require "../functions.php";     //? i need to head to load it from the previous folder

// I'm not messing around with wannabe hackerz
session_checker_delfin();


// functions

function editUsersText_delfin($id, $column, $value)
{
    $db = db_connect_delfin();

    $query = "UPDATE Users SET $column = ? WHERE id = ?";
    $stmt = $db->prepare($query);

    $stmt->bind_param("si", $value, $id);
    $result = $stmt->execute();

    $stmt->close();
    db_close_delfin($db);

    return $result;
};


// AJAX

// Update Text
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['column'], $_POST['value'])) {
    $id = (int) $_POST['id'];
    $column = trim($_POST['column']);
    $value = trim($_POST['value']);

    // checking if the db column is allowed to have text
    if (!in_array($column, $allowedColumnsText)) {  // global var
        exit;
    }

    $value = substr($value, 0, 250);    // varchar 255 with some wiggle room
    // // $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); // I'm not messing around ;)

    $result = editUsersText_delfin($id, $column, $value);       // function handling the db

    exit;
}


?>

