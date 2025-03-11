<?php

// $db= false;     // setup

date_default_timezone_set('Europe/Luxembourg'); //! this isn't meant to change

// Global Variables
$logFileWithPath = "./logs/log.txt";    // global makes sense for this specific use case
$uploadPath = "./uploads/";             // global makes sense for this specific use case

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
        // echo "Datenbank huet een Problem <br>";
        echo "<script>console.log('Datenbank huet een Problem');</script>";
    } elseif ($db) {
        // echo "Datenbank ass aktiv <br>";
        echo "<script>console.log('Datenbank ass aktiv');</script>";
    } else {
        // echo "Een Dëcken Hardware Problem mam Server <br>";
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
        unset($_SESSION['id']);
        header("location: logout.php");
    }

    if (isset($_SESSION['id'])) {
        echo "Welcome: $_SESSION[username] <br/>";
        echo "<script>console.log('" . $_SESSION['username'] . " - " . $_SESSION['email'] . " - " . $_SESSION['id'] . "');</script>";
    } else {
        header("location: index.php");  // this requires a session from login
    }
}

// HTML ONLY
function send_mail_delfin($emailSender, $emailSenderName, $emailRecipient, $emailRecipientName, $emailSubject, $emailBody, $emailAttachement, $RecipientId)
{
    if (strpos($emailRecipient, '@') === false || strlen($emailRecipient) < 3) {   // just checking if an @ is present to make the code faster ; and absolute minimum possible length
        echo "NO EMAIL: <strong>$emailRecipientName</strong> - ID: <strong>$RecipientId</strong><br />";
        echo "<script>console.log('NO EMAIL: [ " . $emailRecipientName . " - ID: $RecipientId ]');</script>";
        $logMessage = "NO EMAIL: $emailRecipientName - ID: $RecipientId";
        write_log_delfin($logMessage);
    } else {
        $mail = new PHPMailer(true);    // true enables exceptions
        try {
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                  //Enable verbose debug output
            $mail->isSMTP();                                        //Send using SMTP
            $encryptionType = strtolower(getenv('SMTP_SECURE'));    // forces lowercase
            // echo "<script>console.log('.env encryption type in lower case: [ $encryptionType ]');</script>";
            if ($encryptionType == 'tls') {
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                // echo "<script>console.log('encryption type: TLS');</script>";
            } elseif ($encryptionType == 'ssl') {
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                // echo "<script>console.log('encryption type: SSL');</script>";
            } else {
                // Internal Company Mail Server
                $mail->SMTPAuth = false;    // password authentication DISABELD
                $mail->SMTPSecure = '';     // which means unencrypted
                // echo "<script>console.log('encryption type: NONE');</script>";
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
            // echo "<script>console.log('Debug: [ $mail->Host ]');</script>";
            // // var_dump($mail);
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
            // echo 'Message has been sent<br />';
            $mail->SmtpClose();     // close the connection ; Very Smort -> stonks
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br />";
            $mailErrorInfo = json_encode($mail->ErrorInfo);         // made it a proper string for console logging
            echo "<script>console.log($mailErrorInfo);</script>";  // 
            echo "Message failed to send to: <strong>$emailRecipientName</strong> --- <strong>$emailRecipient</strong> - ID: <strong>$RecipientId</strong><br />";
            echo "<script>console.log('Message failed to send to: [ " . $emailRecipientName . " - " . $emailRecipient . " - ID: $RecipientId ]');</script>";
            // echo "<h3>The conosole.log is niche to have but it should write smth into the php logger</h3>";     // conosole FTW -> niche
            $logMessage = "Message failed to send to: $emailRecipientName --- $emailRecipient - ID: $RecipientId";
            write_log_delfin($logMessage);
        }
    }
}

function write_log_delfin($logMessage)
{
    $timestamp = date("H:i:s d.m.Y");   // i want to create the timestamp at the closest possible time of the logging process
    // $logFileWithPath = "./log.txt";     // 
    $logFWP = $GLOBALS['logFileWithPath'];  // global var
    $existingContent = @file_get_contents($logFWP); // @file_get_contents surpresses the warning if the file doesn't yet exist, only relevant on first run or after deletion
    $logToFile = fopen($logFWP, "w") or die("Unable to open loging file!"); // this also ensures the file is created if it doesn't exist
    fwrite($logToFile, PHP_EOL . $timestamp . PHP_EOL . $logMessage . PHP_EOL . $existingContent);
    fclose($logToFile); // yes
}

function log_too_big_delfin(){
    // used since the append thingy in the write_log function requires memory and the bigger the file the more memory it needs; which means the time until it explodes is getting shorter
    $logFWP = $GLOBALS['logFileWithPath'];  // global var
    $maxLogSize = 1 * 1024 * 1024;  // 1MB -> Milton Bradley
    if (file_exists($logFWP) && filesize($logFWP) > $maxLogSize) {
        unlink($logFWP);    // deletes the file
        echo "<script>console.log('Log File was too big and has been deleted');</script>";
    }
}

// requires a session to be set
function pdf_upload_delfin($file){
    $baseUploadDir = $GLOBALS['uploadPath'];    // global var
    $timestamp = time();
    $targetUploadDir = $baseUploadDir . "/" . $_SESSION['id'] . "/" . $timestamp . "/"; // ensures each upload folder is unique, user id is unique and timestamp is unique ; and if not I'm gonna play the lottery (since the filename would also have to be an exact match)
    if (!is_dir($targetUploadDir)){
        mkdir($targetUploadDir, 0777, true);    // 0777 gives everyone access to it ; for simplicity purposes
    }


    // $targetFile = $targetUploadDir . basename($file["name"]);
}


