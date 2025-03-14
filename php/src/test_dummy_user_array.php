<?php

ob_start();

require "functions.php";

session_checker_delfin();


// <!-- EXAMPLE ARRAY -->

$dummyAccounts = [
    [
        'emailRecipient' => $_SESSION['email'],
        'emailRecipientName' => $_SESSION['username'],
        'RecipientId' => 0   // normally from database ; but since this is testing it has id=0

    // ],
    // [
    //     'emailRecipient' => 'loser@petange.lu',
    //     'emailRecipientName' => 'LOSER Dummy Recipient',
    //     'RecipientId' => 3
    // ],
    // [
    //     'emailRecipient' => 'loser@email.com.lux',
    //     'emailRecipientName' => 'LOSER Dummy Recipient',
    //     'RecipientId' => 455
    
    ]   //! the last one must drop the comma
];

$_SESSION['targetUsersArray'] = $dummyAccounts;


echo "<br />";
echo "<h1>you now have a dummy emailing list ready</h1><br />";
echo '<a href="file_upload.php">UPLOAD FILE -> </a><br />';
echo "<br />";
