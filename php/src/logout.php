<?php
session_start();
session_destroy();
// include('db_close.php');
header('Location: index.php');
exit();
?>
