<?php

require "functions.php";

// unsets every session variable apart from those related to login or essentials
// id, email, username
// in order
cleanup_session_vars_delfin();

// a little later than usual  but i want to be sure everything is clean
session_checker_delfin();



// 


$selectedList = "list_A";   // this is usefull

$db = db_connect_delfin();

// $query = "SELECT id, allocation, nom, nom2, fonction, adresse1, adresse2, allocationSpeciale, email, nomCouponReponse, letter_required FROM Users WHERE $selectedList = ?";
query_grab_user_list($selectedList, $db);

// 
turn_fetched_users_into_array_delfin($queryResult);     // $queryResult is self explanatory
// 
if (isset($_SESSION['targetUsersArray'])) {
    unset($_SESSION['targetUsersArray']);   // just to be sure, even if cleanup_session_vars_delfin already ran
}
// 
$_SESSION['targetUsersArray'] = $grabbedUsers;  // grabbedUsers was returned
header("location: file_upload.php");    // redirect
exit;   // this is needed



?>


<?php require 'header.html'; ?>



<h1>LOGGED IN</h1>

<br />
<a href="test_dummy_user_array.php">Test mailing list (on yourself)</a>
<br />

<br />
<h3> <span>LIST A</span><span>&nbsp;---&nbsp;</span><span>EDIT</span> </h3>
<h3>List A</h3>


<?php require 'footer.html'; ?>


