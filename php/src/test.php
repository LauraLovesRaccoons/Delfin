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
$emailRecipient = 'frank.merges@petange.lu';    // external disabled atm
$emailRecipientName = 'RECEIVER';
$emailSubject = 'TEST EMAIL';
$emailBody = 'This is a test email';
$emailAttachement = 'favicon.ico';
// 
send_mail_delfin($emailSender, $emailSenderName, $emailRecipient, $emailRecipientName, $emailSubject, $emailBody, $emailAttachement);




?>

<?php require 'footer.html'; ?>


<?php
debug_test_env_delfin();
?>
