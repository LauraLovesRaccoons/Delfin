<?php

require "functions.php";

// I'm not messing around with wannabe hackerz
session_checker_delfin();


function kickUserFromList_delfin($id, $selectedList)
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

// KICK
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['selectedList'])) {
    $id = (int) $_POST['id'];
    $selectedList = $_POST['selectedList'];
    kickUserFromList_delfin($id, $selectedList);    // function call
    exit;
};




?>

