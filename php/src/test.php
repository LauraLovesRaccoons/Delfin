<?php

require "functions.php";




?>


<?php require 'header.html'; ?>




<h1>TEST EXTENSIONS</h1>
<br />
<h1> </h1>
<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

# variables for mail server
$mail = new PHPMailer(true);    // true enables exceptions
$mail->isSMTP();
// $mail->SMTPAuth = filter_var(getenv('SMTP_AUTH'), FILTER_VALIDATE_BOOLEAN);
// if (!$mail->SMTPAuth) {
//     $mail->SMTPSecure = '';
// }
// else {
    debug_test_env_delfin();
$twssss = getenv('SMTP_SECURE');
var_dump($twssss);
$encryptionType = strtolower(getenv('SMTP_SECURE'));    // forces lowercase
echo "<script>console.log('encryption type: $encryptionType');</script>";
var_dump($encryptionType);
if ($encryptionType == 'encryption type: tls') {
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    echo "<script>console.log('TLS');</script>";
} elseif ($encryptionType == 'encryption type: ssl') {
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    echo "<script>console.log('SSL');</script>";
} else {
    $mail->SMTPAuth = false;
    $mail->SMTPSecure = ''; // which means unencrypted
    echo "<script>console.log('encryption type: NONE');</script>";
}
// }

$mail->Host = getenv('SMTP_SERVER');
$mail->Username = getenv('SMTP_USERNAME');
$mail->Password = getenv('SMTP_PASSWORD');
$mail->Port = getenv('SMTP_PORT');




// // junk code 
// // ! DO NOT USE

// try {
//     // Create new instance
//     $mail = new PHPMailer(true);

//     // Set up SMTP settings (if needed)
//     $mail->isSMTP();
//     $mail->Host = 'smtp.example.com';
//     $mail->SMTPAuth = true;
//     $mail->Username = 'user@example.com';
//     $mail->Password = 'password';

//     // Send mail
//     $mail->setFrom('from@example.com', 'Mailer');
//     $mail->addAddress('to@example.com', 'User');

//     $mail->Subject = 'Hello World';
//     $mail->Body = 'This is a test email.';

//     if ($mail->send()) {
//         echo 'Email sent successfully.';
//     } else {
//         echo 'Error sending email: ' . $mail->error;
//     }
// } catch (Exception $e) {
//     echo 'Message could not be sent. Mailer Error: ' . $e->getMessage();
// }
// 
?>

<?php require 'footer.html'; ?>