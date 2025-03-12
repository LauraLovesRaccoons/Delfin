<?php

ob_start();

require "functions.php";

// session id handoff
session_checker_delfin();



// if (isset($_GET['file'])) {
//     $targetFile = urldecode($_GET['file']);
//     if (!file_exists($targetFile)) {
//         header("Location: delfin.php"); // redirects if the file doesn't exist
//         exit();
//     }


if (isset($_SESSION['targetFile'])) {
    $emailAttachement = $_SESSION['targetFile'];
    unset($_SESSION['targetFile']); // prevents sending duplicate mails
    // run this before writing to the log file, as the older logs are less likely to be needed
    log_too_big_delfin();
}
// it's better to be sure this hasn't somehow been purged
if (isset($_SESSION['targetUsersArray'])) {
    $emailRecipientsArray = $_SESSION['targetUsersArray'];
    unset($_SESSION['targetUsersArray']); // prevents having a duplicate Array of Users and potentionally sending duplicate mails
} else {
    header("Location: delfin.php");
    exit();
}
// sets the Subject and Body and loads the default from the env file if it doesn't exist
if (isset($_SESSION['emailSubject'])){
    $emailSubject = $_SESSION['emailSubject'];
    unset($_SESSION['emailSubject']);   // wipe it ditto
} else {
    $emailSubject = getenv('DEFAULT_EMAIL_SUBJECT');
}
if (isset($_SESSION['emailBody'])){
    $emailBody = $_SESSION['emailBody'];
    unset($_SESSION['emailSubject']);   // wipe it ditto
} else {
    $emailBody = getenv('DEFAULT_EMAIL_BODY');
}


// echo "<h1>The file must be cleared afterwards</h1><br />";


?>


<?php
include 'header.html';
?>




<!-- <h1>BE PATIENT ! - MUST DISPLAY ON THE PREVIOUS PAGE </h1>
<h1>ESPECIALLY IF MAILS ARE FAILING TO SEND</h1> -->
<!-- <br />
<h1> </h1> -->
<?php




// // 
// $emailSender = $_SESSION['email'];
// $emailSenderName = $_SESSION['username'];
// $emailRecipient = 'holaura@protonmail.com';    // external requires proper configured mail server
// // $emailRecipient = 'laura.hornick@petange.lu';
// $emailRecipientName = 'RECEIVER-TEST';
// $emailSubject = 'TEST EMAIL Petange Intern';
// $emailBody = '<h2>Intern verschéckten Test Email, net entwäerten a keen Handlungsbedarf.</h2> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 🦆 <br> <br> <br> 北京烤鴨 <br>';
// // $emailAttachement = 'favicon.ico';
// // 
// // $RecipientId = 0; // from DB
// // send_mail_delfin($emailSender, $emailSenderName, $emailRecipient, $emailRecipientName, $emailSubject, $emailBody, $emailAttachement, $RecipientId);
// // 





// Loop through the array and send emails
foreach ($emailRecipientsArray as $recipientUser) {
    $emailSender = $_SESSION['email'];
    $emailSenderName = $_SESSION['username'];
    // // function customMessageSubject
    // // function customMessageBody
    // // first set the custom msg; just dump everything into the $_SESSION['targetUsersArray'] 
    // $emailSubject = 'TEST EMAIL Petange Intern';
    // $emailBody = '<h2>Intern verschéckten Test Email, net entwäerten a keen Handlungsbedarf.</h2> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 🦆 <br> <br> <br> 北京烤鴨 <br>';
    // // end of this note
    send_mail_delfin(
        $emailSender,
        $emailSenderName,
        $recipientUser['emailRecipient'],
        $recipientUser['emailRecipientName'],
        $emailSubject,
        $emailBody,
        $emailAttachement,
        $recipientUser['RecipientId']
    );
}
delete_uploads_dir_delfin();    // cleanup



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


<!-- EXAMPLE ARRAY -->

<!-- // $dummyAccounts = [
//     [
//         'emailRecipient' => 'laura.hornick@petange.lu',
//         'emailRecipientName' => 'Dummy Recipient 1',
//         'RecipientId' => 1   // from database
//     ],
//     [
//         'emailRecipient' => 'frank.merges@petange.lu',
//         'emailRecipientName' => 'Dummy Recipient 2',
//         'RecipientId' => 2
//     ] -->




<br />
<hr /><br />

<?php
//! IGNORE THE STUFF BELOW
?>


<br />
<hr />
<br />


<!-- 
<br /><br /><br /><br /><br /><br />
<h2>TESTING error logging simulated loop from an array</h2>
<br /><br /><br /> -->
<?php
// echo "<script>console.log('TEST LOOP');</script>";
// echo "<br />";
// $emailRecipient = '@';
// $emailRecipientName = 'HACKER';
// $RecipientId = 666; // from DB
// send_mail_delfin($emailSender, $emailSenderName, $emailRecipient, $emailRecipientName, $emailSubject, $emailBody, $emailAttachement, $RecipientId);
// // if (strpos($emailRecipient, '@') === false) {
// //     echo "NO EMAIL: $emailRecipientName <br />";
// //     echo "<script>console.log('NO EMAIL:  " . $emailRecipientName . "');</script>";
// // } else {
// //     send_mail_delfin($emailSender, $emailSenderName, $emailRecipient, $emailRecipientName, $emailSubject, $emailBody, $emailAttachement);
// //     echo "<br />";
// // }

// echo "<br />";
// // $emailRecipient = 'laura.hornick@petange.lu';
// // send_mail_delfin($emailSender, $emailSenderName, $emailRecipient, $emailRecipientName, $emailSubject, $emailBody, $emailAttachement);
// // echo "<br />";
// // $emailRecipient = 'laura.hornick@petange.lu';
// // send_mail_delfin($emailSender, $emailSenderName, $emailRecipient, $emailRecipientName, $emailSubject, $emailBody, $emailAttachement);
// // echo "<br />";
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



<!-- <br />
<br />
<hr />
<br />
<br />
<h1>This php must run at the end!!!</h1>
<br /> -->
<?php
// delete_uploads_dir_delfin();
?>