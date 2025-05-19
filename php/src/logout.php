<?php
ob_start();
require('functions.php');       // this also loads $session_name
logout_delfin($session_name);   // this needs the variable name to be passed to the function
?>