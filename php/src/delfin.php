<?php 

require "functions.php";
session_checker_delfin();

// unsets every session variable apart from those related to login or essentials
// id, email, username
// in order
cleanup_session_vars_delfin();

// 


// if someone clicks it there will be a query here
$grabbedUsers = [];     // i need to save it in a users's array
// not needed here ; because of cleanup,,, function
// if (isset($_SESSION['targetUsersArray'])) {
//     unset($_SESSION['targetUsersArray']);
// }
$_SESSION['targetUsersArray'] = $grabbedUsers;



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



