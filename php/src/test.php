<?php

require "functions.php";




?>


<?php require 'header.html'; ?>




<h1>TEST EXTENSIONS</h1>
<br />
<h1> </h1>
<?php




// 
$emailSender = 'noreply-laura.hornick@petange.lu';
$emailSenderName = 'DO NOT REPLY - LAURA HORNICK';
$emailRecipient = 'laura.hornick@petange.lu';    // external requires proper configured mail server
$emailRecipientName = 'RECEIVER';
$emailSubject = 'TEST EMAIL Petange Intern';
$emailBody = '<h2>Intern verschéckten Test Email, net entwäerten a keen Handlungsbedarf.</h2> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 🦆 <br> <br> <br> 北京烤鴨 <br>';
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
