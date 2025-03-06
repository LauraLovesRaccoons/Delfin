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


// junk code 
// ! DO NOT USE

try {
    // Create new instance
    $mail = new PHPMailer(true);

    // Set up SMTP settings (if needed)
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'user@example.com';
    $mail->Password = 'password';

    // Send mail
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('to@example.com', 'User');

    $mail->Subject = 'Hello World';
    $mail->Body = 'This is a test email.';

    if ($mail->send()) {
        echo 'Email sent successfully.';
    } else {
        echo 'Error sending email: ' . $mail->error;
    }
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ' . $e->getMessage();
}
?>

<?php require 'footer.html'; ?>
