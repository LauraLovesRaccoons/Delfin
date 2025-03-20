<?php

require "functions.php";

// unsets every session variable apart from those related to login or essentials
// id, email, username
// in order
cleanup_session_vars_delfin();

// a little later than usual  but i want to be sure everything is clean
session_checker_delfin();



// 
$approvedSelectedList = ["list_A", "list_B",];      //! this needs updating if new lists are added
// 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["editEntireDb"])) {        // checks if the editEntireDb button was pressed
        header("location: edit_entire_db.php");
        exit;
    }
    if (isset($_POST["selectedList"])) {        // checks if someone wishes to send a mailing list
        $selectedList = $_POST["selectedList"];
        // checking if someone wants to send an example file
        if ($selectedList === "test") {
            header("location: test_dummy_user_array.php");  // it still has its debugging name :barry:
            exit;
        }

        // if someone inspect element on the hidden value field, we're gonna have a bad time
        if (!in_array($selectedList, $approvedSelectedList)) {
            header("location: delfin.php"); // redirect
            exit;
        }

        // redirects to the edit_list.php page
        if (isset($_POST["editList"])) {
            header("location: edit_list.php?" . urlencode($selectedList));  // urlencode might make the most sense here
            exit;   // if there is no exit, it will proceed with the remainder of the code
        }

        // $selectedList = "list_A";   // this is usefull

        $db = db_connect_delfin();

        // $query = "SELECT id, allocation, nom, nom2, fonction, adresse1, adresse2, allocationSpeciale, email, nomCouponReponse, letter_required FROM Users WHERE $selectedList = ?";
        $queryResult = query_grab_user_list($selectedList, $db);    // $queryResult is self explanatory

        // 
        $grabbedUsers = turn_fetched_users_into_array_delfin($queryResult);     // the return from the function NEEDS to be saved into a variable
        // 
        if (isset($_SESSION['targetUsersArray'])) {
            unset($_SESSION['targetUsersArray']);   // just to be sure, even if cleanup_session_vars_delfin already ran
        }
        // 
        $_SESSION['targetUsersArray'] = $grabbedUsers;  // grabbedUsers was returned
        header("location: file_upload.php");    // redirect
        exit;   // this is needed
    }
}


?>


<?php require 'header.html'; ?>



<h1>LOGGED IN</h1>

<!-- <br />
<a href="test_dummy_user_array.php">Test mailing list (on yourself)</a>
<br /> -->

<!-- <br />
<h3> <span>LIST A</span><span>&nbsp;---&nbsp;</span><span>EDIT</span> </h3>
<h3>List A</h3> -->

<br />

<div class="selectListsForm">

    <form method="POST">
        <label for="submit"></label>
        <input type="hidden" name="selectedList" value="list_A"> <!-- ensure the value is always transmited -->
        <button type="submit" class="list-button">Select List A</button>
        <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
    </form>

    <form method="POST">
        <label for="submit"></label>
        <input type="hidden" name="selectedList" value="list_B">
        <button type="submit" class="list-button">Select List B</button>
        <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
    </form>
    <form method="POST">
        <label for="submit"></label>
        <input type="hidden" name="selectedList" value="HACKER">
        <button type="submit" class="list-button">HACKER</button>
        <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
    </form>
    <form method="POST">
        <label for="submit"></label>
        <input type="hidden" name="selectedList" value="test">
        <button type="submit" class="list-button">Test mailing list (on yourself)</button>
    </form>
    <br />
    <br />
    <form method="POST">
        <label for="edit-entire-db"></label>
        <input type="hidden" name="editEntireDb" value="1">
        <button type="submit" class="edit-entire-db-button">Edit the entire database</button>
    </form>

</div>





<?php require 'footer.html'; ?>



