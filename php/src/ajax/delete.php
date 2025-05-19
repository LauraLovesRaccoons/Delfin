<?php

require "../functions.php";     //? i need to head to load it from the previous folder

// I'm not messing around with wannabe hackerz
session_checker_delfin();


// functions
function deleteUser_delfin($id)
{
    $db = db_connect_delfin();

    $query = "DELETE FROM Users WHERE id = ?";
    $stmt = $db->prepare($query);


    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    $stmt->close();
    db_close_delfin($db);

    return $result;
};


// AJAX

// DELETE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];   // Sanitize the user ID

    $result = deleteUser_delfin($id);

    exit;
}
?>