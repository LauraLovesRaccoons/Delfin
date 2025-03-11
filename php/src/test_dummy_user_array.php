<?php

ob_start();

require "functions.php";

session_checker_delfin();


// <!-- EXAMPLE ARRAY -->

$dummyAccounts = [
    [
        'emailRecipient' => 'laura.hornick@petange.lu',
        'emailRecipientName' => 'Dummy Recipient 1',
        'RecipientId' => 1   // from database
    ],
    [
        'emailRecipient' => 'loser@petange.lu',
        'emailRecipientName' => 'LOSER Dummy Recipient',
        'RecipientId' => 3
    ],
    [
        'emailRecipient' => 'loser@email.com.lux',
        'emailRecipientName' => 'LOSER Dummy Recipient',
        'RecipientId' => 455
    ]
];

$_SESSION['targetUsersArray'] = $dummyAccounts;


echo "<br />";
echo "<h1>you now have a dummy emailing list ready</h1><br />";
echo '<a href="file_upload.php">UPLOAD FILE -> </a><br />';
echo "<br />";
