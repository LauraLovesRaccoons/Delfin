<?php

ob_start();

require "functions.php";

// session id handoff
session_checker_delfin();
// run this before writing to the log file, as the older logs are less likely to be needed
log_too_big_delfin();



?>


<?php 
include 'header.html';
 ?>




<h1>BE PATIENT ! - MUST DISPLAY ON THE PREVIOUS PAGE </h1>
<h1>ESPECIALLY IF MAILS ARE FAILING TO SEND</h1>
<br />
<h1> </h1>
<?php




// 
$emailSender = $_SESSION['email'];
$emailSenderName = $_SESSION['username'];
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


<?php 
include 'footer.html';
 ?>


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
// // $emailRecipient = "NO"; // ensures there always is a string present
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


