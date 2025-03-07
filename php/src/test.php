<?php

require "functions.php";




?>


<?php require 'header.html'; ?>




<h1>TEST EXTENSIONS</h1>
<br />
<h1> </h1>
<?php




// 
$emailSender = 'laura.hornick@petange.lu';
$emailSenderName = 'TEST WOMAN';
$emailRecipient = 'holaura@protonmail.com';    // external requires proper configured mail server
$emailRecipientName = 'RECEIVER';
$emailSubject = 'TEST EMAIL';
$emailBody = 'This is a test email';
$emailAttachement = 'favicon.ico';
// 
send_mail_delfin($emailSender, $emailSenderName, $emailRecipient, $emailRecipientName, $emailSubject, $emailBody, $emailAttachement);



?>

<br /><br /><br />
<h1> ADD A LOGGER THAT REGISTERS ALL FAILED SEND MESSAGES ; EXCEPTIONS IN THE FUNCTION </h1>
<br /><br /><br />


<?php require 'footer.html'; ?>


<?php
// debug_test_env_delfin();
?>
