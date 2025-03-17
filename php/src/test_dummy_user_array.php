<?php

ob_start();

require "functions.php";

session_checker_delfin();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['letter_required'] = true;    // this is the easiest option to add this feature
}



// <!-- EXAMPLE ARRAY -->

$dummyAccounts = [
    [
        'emailRecipient' => $_SESSION['email'],
        'emailRecipientName' => $_SESSION['username'],
        'recipientId' => 0,     // normally from database ; but since this is testing it has id=0
        // filling it with test data
        'allocation' => 'Madame',
        'nom' => 'Laura Enterprise',
        'nom2' => 'HORNICK Laura',
        'fonction' => '',
        'adresse1' => 'Place JFK',
        'adresse2' => 'L-0000 Pétange',
        'allocationSpeciale' => 'Prinzessin',
        'nomCouponReponse' => '',       //! verify actual field name!

    // ],
    // [
    //     'emailRecipient' => 'loser@petange.lu',
    //     'emailRecipientName' => 'LOSER Dummy Recipient',
    //     'recipientId' => 666
    // ],
    // [
    //     'emailRecipient' => 'holaura@protonmail.com',
    //     'emailRecipientName' => 'LOSER Dummy Recipient',
    //     'recipientId' => 455
    //     ],
    // [
    //     'emailRecipient' => 'NO-EMAIL',
    //     'emailRecipientName' => 'i do not have an email',
    //     'recipientId' => 555

    ]   //! the last one must drop the comma
];

$_SESSION['targetUsersArray'] = $dummyAccounts;


echo "<br />";
echo "<h1>you now have a dummy emailing list ready</h1><br />";
echo '<a href="file_upload.php">UPLOAD FILE -> </a><br />';
echo "<br />";


?>


<form method="post">
    <button type="submit">Enable Letter Required Flag</button>
</form>


