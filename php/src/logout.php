<?php
ob_start();
require('functions.php');       // this also loads $session_name
// // $db=db_connect_delfin();
// // $db=db_close_delfin($db);  // this will throw an error that will get skipped ; since the line above is commented out
logout_delfin($session_name);   // this needs the variable name to be passed to the function
?>
