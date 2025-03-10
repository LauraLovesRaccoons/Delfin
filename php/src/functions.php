<?php

// $db= false;     // setup

$session_name = "delfin-session-cookie";    // prettier name
session_name("$session_name");              // now this is the cookie's name
// if function is always called before session_start (which is included in all the functions) ; then this will always be the cookie name

// Load Composer's autoloader
require 'vendor/autoload.php';

// required for functions
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function debug_test_env_delfin()
{
    echo "<br /><br />";
    var_dump(getenv());     // shows all environment variables
    echo "<br /><br />";
}

function logout_delfin($session_name)
{
    session_start();
    session_unset();
    session_destroy();
    // cookie removal on client
    setcookie($session_name, "", time() - 999999, "/");   //! must use the same name as the session name
    // since there is a session start there always is a cookie session present ; unless someone messes with the cookie or the browser blocks them
    header('Location: index.php');
    exit();
}

function db_connect_delfin()
{
    $serviceMysql = getenv('MYSQL_SERVICE_NAME');   // (from compose.yaml) -> .env
    $username = getenv('MYSQL_USER');
    $password = getenv('MYSQL_PASSWORD');
    $dbname = getenv('MYSQL_DATABASE');

    // Create connection to DB
    mysqli_report(MYSQLI_REPORT_OFF);           // this allows the upcoming @ to supress warnings from the user
    $db = @mysqli_connect($serviceMysql, $username, $password, $dbname);    // @ means surpress error message
    if (!$db) {
        //     // // error_log(mysqli_connect_error());
        echo "Datenbank huet een Problem <br>";
        echo "<script>console.log('Datenbank huet een Problem');</script>";
    } elseif ($db) {
        echo "Datenbank ass aktiv <br>";
        echo "<script>console.log('Datenbank ass aktiv');</script>";
    } else {
        echo "Een Dëcken Hardware Problem mam Server <br>";
        echo "<script>console.log('Een Dëcken Hardware Problem mam Server');</script>";
    }
    return $db; // this gives me the cannot modify header information warning
}

function db_close_delfin($db)
{
    if ($db) {
        mysqli_close($db);  // closes the database connection
        // echo "Closed the Database Connection";
        echo "<script>console.log('Closed the Database Connection');</script>";
    } else {
        // echo "There was NO Database Connection";
        echo "<script>console.log('There was NO Database Connection');</script>";
    }
}

function session_checker_delfin()
{
    session_start();    // 
    if (isset($_POST['logout_button'])) {
        unset($_SESSION['username']);
        header("location: logout.php");
    }

    if (isset($_SESSION['username'])) {
        echo "Welcome: $_SESSION[username] <script>console.log('Welcome: $_SESSION[username]');</script>";
    } else {
        header("location: index.php");  // this requires a session from login
    }
}

// HTML ONLY
function send_mail_delfin($emailSender, $emailSenderName, $emailRecipient, $emailRecipientName, $emailSubject, $emailBody, $emailAttachement)
{
    if (strpos($emailRecipient, '@') === false) {           // just checking if an @ is present to make the code faster
        echo "NO EMAIL: $emailRecipientName <br />";
        echo "<script>console.log('NO EMAIL:  " . $emailRecipientName . "');</script>";
    } else {
        $mail = new PHPMailer(true);    // true enables exceptions
        try {
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                  //Enable verbose debug output
            $mail->isSMTP();                                        //Send using SMTP
            $encryptionType = strtolower(getenv('SMTP_SECURE'));    // forces lowercase
            echo "<script>console.log('.env encryption type in lower case: [ $encryptionType ]');</script>";
            if ($encryptionType == 'tls') {
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                echo "<script>console.log('encryption type: TLS');</script>";
            } elseif ($encryptionType == 'ssl') {
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                echo "<script>console.log('encryption type: SSL');</script>";
            } else {
                // Internal Company Mail Server
                $mail->SMTPAuth = false;    // password authentication DISABELD
                $mail->SMTPSecure = '';     // which means unencrypted
                echo "<script>console.log('encryption type: NONE');</script>";
                // Disable SSL certificate verification
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
            }
            $mail->Encoding = 'base64';     // not exactly sure but it might help with the character set
            $mail->CharSet = "UTF-8";       // this makes symbols commonly used in Luxembourg work

            $mail->Host = getenv('SMTP_SERVER');        // Internal Company Mail Server might need ip address instead of domain name
            $mail->Username = getenv('SMTP_USERNAME');  // this doesn't do anything if SMTPAuth is false
            $mail->Password = getenv('SMTP_PASSWORD');  // ditto
            $mail->Port = intval(getenv('SMTP_PORT'));  // needs to be an integer
            echo "<script>console.log('Debug: [ $mail->Host ]');</script>";
            // var_dump($mail);
            // Recipients
            $mail->setFrom($emailSender, $emailSenderName);
            $mail->addAddress($emailRecipient, $emailRecipientName);
            // Attachments
            $mail->addAttachment($emailAttachement);
            // Content
            $mail->isHTML(true);
            $mail->Subject = $emailSubject;
            $mail->Body = $emailBody;
            $mail->send();
            echo 'Message has been sent';
            $mail->SmtpClose();     // close the connection ; Very Smort -> stonks
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            echo "<script>console.log('Message failed to send to: [ " . $emailRecipient . " - " . $emailRecipientName . " ] ');</script>";
            echo "<h3>The conosole.log is niche to have but it should write smth into the php logger</h3>";     // conosole FTW -> niche
        }
    }
}
