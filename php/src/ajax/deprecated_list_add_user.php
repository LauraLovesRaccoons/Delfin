<?php

require "../functions.php";     //? i need to head to load it from the previous folder

// I'm not messing around with wannabe hackerz
session_checker_delfin();


// functions
function addUserToList_delfin($id, $selectedList)
{
    $db = db_connect_delfin();
    $fieldValue = 1;    // tinyint 1 means true

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
    $id = (int) $_POST['id'];   // filters everything and turns it into an integer and if no numbers are found it defaults to 0
    $selectedList = trim($_POST['selectedList']);
    if (!in_array($selectedList, approved_lists_delfin())) {
        exit;
    };
    addUserToList_delfin($id, $selectedList);    // function call
    exit;
};




?>

