<?php

require "../functions.php";     //? i need to head to load it from the previous folder

// I'm not messing around with wannabe hackerz
session_checker_delfin();


// functions
function editUserTinyint_delfin($id, $column, $value)
{
    $db = db_connect_delfin();  // Database connection

    // Prepare the update query for the specific column
    $query = "UPDATE Users SET $column = ? WHERE id = ?";
    $stmt = $db->prepare($query);

    // Bind the parameters to the prepared statement
    // 'ii' means we are binding two integers (value and id)
    $stmt->bind_param("ii", $value, $id);

    // Execute the statement and check if it was successful
    $result = $stmt->execute();

    // Close the prepared statement and database connection
    $stmt->close();
    db_close_delfin($db);

    return $result;  // Return the result of the query execution (true or false)
};


// AJAX

// Update Tinyint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['column'], $_POST['value'])) {
    $id = (int) $_POST['id'];       // obvious...
    $column = $_POST['column'];     // i need the column
    $value = (int) $_POST['value']; // forces it to be an integer and 0 and 1 are valid but other integers are treated like 0

    // checking if the db column is allowed to have tinyint
    if (!in_array($column, $allowedColumnsTinyint)) {  // global var
        exit;
    }
    
    // i don't want a 2 or 3 in there!
    if ($value !== 0 && $value !== 1) {
        $value = 0; // which is false ; I don't care if you edited your browser to send a 2 or 3 and showing you a wrong visual value until you refresh the page!!!
    }

    $result = editUserTinyint_delfin($id, $column, $value); // function handling the db

    exit;
}


?>

