<?php

require "functions.php";




?>


<?php require 'header.html'; ?>




<h1>BE PATIENT ! - MUST DISPLAY ON THE PREVIOUS PAGE </h1>
<h1>ESPECIALLY IF MAILS ARE FAILING TO SEND</h1>
<br />
<h1> </h1>
<?php




// 
$emailSender = 'noreply-laura.hornick@petange.lu';
$emailSenderName = 'DO NOT REPLY - LAURA HORNICK';
$emailRecipient = 'holaura@protonmail.com';    // external requires proper configured mail server
// $emailRecipient = 'laura.hornick@petange.lu';
$emailRecipientName = 'RECEIVER-TEST';
$emailSubject = 'TEST EMAIL Petange Intern';
$emailBody = '<h2>Intern verschéckten Test Email, net entwäerten a keen Handlungsbedarf.</h2> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 🦆 <br> <br> <br> 北京烤鴨 <br>';
$emailAttachement = 'favicon.ico';
// 
$RecipientId = 0; // from DB
send_mail_delfin($emailSender, $emailSenderName, $emailRecipient, $emailRecipientName, $emailSubject, $emailBody, $emailAttachement, $RecipientId);



?>

<!-- <br /><br /><br />
<h1> ADD A LOGGER THAT REGISTERS ALL FAILED SEND MESSAGES ; EXCEPTIONS IN THE FUNCTION </h1>
<br /><br /><br /> -->


<?php require 'footer.html'; ?>


<?php
// debug_test_env_delfin();
?>


<br />
<hr />
<br />

<br /><br /><br /><br /><br /><br />
<h2>TESTING error logging simulated loop from an array</h2>
<br /><br /><br />
<?php
echo "<script>console.log('TEST LOOP');</script>";
echo "<br />";
$emailRecipient = '@';
$emailRecipientName = 'HACKER';
$RecipientId = 666; // from DB
send_mail_delfin($emailSender, $emailSenderName, $emailRecipient, $emailRecipientName, $emailSubject, $emailBody, $emailAttachement, $RecipientId);
// if (strpos($emailRecipient, '@') === false) {
//     echo "NO EMAIL: $emailRecipientName <br />";
//     echo "<script>console.log('NO EMAIL:  " . $emailRecipientName . "');</script>";
// } else {
//     send_mail_delfin($emailSender, $emailSenderName, $emailRecipient, $emailRecipientName, $emailSubject, $emailBody, $emailAttachement);
//     echo "<br />";
// }

echo "<br />";
// $emailRecipient = 'laura.hornick@petange.lu';
// send_mail_delfin($emailSender, $emailSenderName, $emailRecipient, $emailRecipientName, $emailSubject, $emailBody, $emailAttachement);
// echo "<br />";
// $emailRecipient = 'laura.hornick@petange.lu';
// send_mail_delfin($emailSender, $emailSenderName, $emailRecipient, $emailRecipientName, $emailSubject, $emailBody, $emailAttachement);
// echo "<br />";
?>
<br />
<hr />
<br />

<?php


// this works

// Define an array of dummy accounts
// $dummyAccounts = [
//     [
//         'emailRecipient' => 'laura.hornick@petange.lu',
//         'emailRecipientName' => 'Dummy Recipient 1',
//         'RecipientId' => 1
//     ],
//     [
//         'emailRecipient' => 'frank.merges@petange.lu',
//         'emailRecipientName' => 'Dummy Recipient 2',
//         'RecipientId' => 2
//     ],
//     [
//         'emailRecipient' => 'patrick.wagner@petange.lu',
//         'emailRecipientName' => 'Dummy Recipient 3',
//         'RecipientId' => 3
//     ],
//     [
//         'emailRecipient' => 'dummy@example.com',
//         'emailRecipientName' => 'Dummy Recipient 4 - invalid email',
//         'RecipientId' => 4
//     ],
//     [
//         'emailRecipient' => '/',
//         'emailRecipientName' => 'Backslash',
//         'RecipientId' => 5
//     ],
//     [
//         'emailRecipient' => 'noreply-laura.hornick@petange.lu',
//         'emailRecipientName' => 'Dummy Recipient 6',
//         'RecipientId' => 6
//     ]
// ];

// // Loop through the array and send emails
// foreach ($dummyAccounts as $account) {
//     send_mail_delfin(
//         $emailSender,
//         $emailSenderName,
//         $account['emailRecipient'],
//         $account['emailRecipientName'],
//         $emailSubject,
//         $emailBody,
//         $emailAttachement,
//         $account['RecipientId']
//     );
// }


?>


