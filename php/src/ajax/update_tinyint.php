<?php

require "../functions.php";     //? i need to head to load it from the previous folder

// I'm not messing around with wannabe hackerz
session_checker_delfin();


// functions


// AJAX

// Update Tinyint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['column'], $_POST['value'])) {
    $id = (int) $_POST['id'];



?>

