<?php

// $db= false;     // setup

date_default_timezone_set('Europe/Luxembourg'); //! this isn't meant to change

// Global Variables
$logBasePath = "./logs/";   // global makes sense for this specific use case
$logFile = "log.txt";       // ditto
$uploadBasePath = "./uploads/"; // global makes sense for this specific use case
// // removed the ./ from in front of the path

$session_name = "delfin-session-cookie";    // prettier name
session_name("$session_name");              // now this is the cookie's name
// if function is always called before session_start (which is included in all the functions) ; then this will always be the cookie name

// Load Composer's autoloader
require 'vendor/autoload.php';

// required for composer "plugins"
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Document\Parser\Word;

use setasign\Fpdi\Fpdi;




function debug_test_env_delfin()
{
    echo "<br /><br />";
    var_dump(getenv());     // shows all environment variables
    echo "<br /><br />";
};

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
};

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
};

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
};

function session_checker_delfin()
{
    session_start();    // 
    if (isset($_POST['logout_button'])) {
        unset($_SESSION['id']);
        header("location: logout.php");
    }

    if (isset($_SESSION['id'])) {
        // echo "Welcome: $_SESSION[username] <br/>";
        // echo "<script>console.log('" . $_SESSION['username'] . " - " . $_SESSION['email'] . " - " . $_SESSION['id'] . "');</script>";
    } else {
        header("location: index.php");  // this requires a session from login
    }
};

// HTML ONLY
function send_mail_delfin($emailSender, $emailSenderName, $emailRecipient, $emailRecipientName, $emailSubject, $emailBody, $emailAttachement, $recipientId)
{
    if (strpos($emailRecipient, '@') === false || strlen($emailRecipient) < 3) {   // just checking if an @ is present to make the code faster ; and absolute minimum possible length
        echo "NO EMAIL: <strong>$emailRecipientName</strong> - ID: <strong>$recipientId</strong><br />";
        echo "<script>console.log('NO EMAIL: [ " . $emailRecipientName . " - ID: $recipientId ]');</script>";
        $logMessage = "NO EMAIL: $emailRecipientName - ID: $recipientId";
        write_log_delfin($logMessage);
        letter_required_delfin($recipientId);   //! saves it for future use ; currently working on this
    } else {
        usleep(1000);   // 1000 microseconds    // hardcoded 1ms delay ; I'm not removing it!
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
            $logMessage = "Email sent to: $emailRecipientName --- $emailRecipient - ID: $recipientId";
            write_log_delfin($logMessage);
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br />";
            $mailErrorInfo = json_encode($mail->ErrorInfo);         // made it a proper string for console logging
            echo "<script>console.log($mailErrorInfo);</script>";  // 
            echo "Message failed to send to: <strong>$emailRecipientName</strong> --- <strong>$emailRecipient</strong> - ID: <strong>$recipientId</strong><br />";
            echo "<script>console.log('Message failed to send to: [ " . $emailRecipientName . " - " . $emailRecipient . " - ID: $recipientId ]');</script>";
            // echo "<h3>The conosole.log is niche to have but it should write smth into the php logger</h3>";     // conosole FTW -> niche
            $logMessage = "Message failed to send to: $emailRecipientName --- $emailRecipient - ID: $recipientId";
            write_log_delfin($logMessage);
            letter_required_delfin($recipientId);   //! saves it for future use ; currently working on this ; i want to ensure those whose email doesn't work get at least a letter
        }
    }
};

function write_log_delfin($logMessage)
{
    $timestamp = date("H:i:s d.m.Y");   // i want to create the timestamp at the closest possible time of the logging process
    // // $logFileWithPath = "./log.txt";     // 
    $logBasePath = $GLOBALS['logBasePath'];  // global var
    $logDirUserId = $logBasePath . $_SESSION['id']; // 
    $logFile = $GLOBALS['logFile'];  // global var
    if (!is_dir($logDirUserId)) {
        mkdir($logDirUserId, 0777, true);  // Create directory; but everyone can access it :/
    }
    $logFileWithPath = $logDirUserId . "/" .  $logFile;

    $existingContent = @file_get_contents($logFileWithPath); // @file_get_contents surpresses the warning if the file doesn't yet exist, only relevant on first run or after deletion
    $logToFile = fopen($logFileWithPath, "w") or die("Unable to open loging file!"); // this also ensures the file is created if it doesn't exist
    fwrite($logToFile, PHP_EOL . $timestamp . PHP_EOL . $logMessage . PHP_EOL . $existingContent);
    fclose($logToFile); // yes
};

function log_too_big_delfin()
{
    // used since the append thingy in the write_log function requires memory and the bigger the file the more memory it needs; which means the time until it explodes is getting shorter
    $logBasePath = $GLOBALS['logBasePath'];  // global var
    $logDirUserId = $logBasePath . $_SESSION['id']; // 
    $logFile = $GLOBALS['logFile'];  // global var
    $logFileWithPath = $logDirUserId . "/" .  $logFile;
    $maxLogSize = 1 * 1024 * 1024;  // 1MB -> Milton Bradley
    if (file_exists($logFileWithPath) && filesize($logFileWithPath) > $maxLogSize) {
        unlink($logFileWithPath);    // deletes the file
        echo "<script>console.log('Log File was too big and has been deleted');</script>";
    }
};

// requires a session to be set
function file_upload_delfin($file)
{
    $baseUploadDir = $GLOBALS['uploadBasePath'];    // global var
    $timestamp = time();
    $targetUploadDir = $baseUploadDir . $_SESSION['id'] . "/" . $timestamp . "/"; // ensures each upload folder is unique, user id is unique and timestamp is unique ; and if not I'm gonna play the lottery (since the filename would also have to be an exact match)
    if (!is_dir($targetUploadDir)) {
        mkdir($targetUploadDir, 0777, true);    // 0777 gives everyone access to it ; for simplicity purposes
    }
    $targetFile = $targetUploadDir . basename($file["name"]);   // 
    if (file_exists($targetFile)) {
        // echo "<strong>Somehow. Somehow, Palpatine returned... and made this file in this folder already exist!</strong><br />";
        unlink($targetFile);
    }
    if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
        echo "<strong>Something went terribly wrong!</strong><br />";
        return false;
    }
    $_SESSION['targetDir'] = $targetUploadDir;  // this makes stuff much easier later on; because of the timestamp shenanigans
    return $targetFile; // now i can use it
};


function delete_uploads_dir_delfin()
{
    $baseUploadDir = $GLOBALS['uploadBasePath'];    // global var
    // old method
    // // $UploadDirUserId = $baseUploadDir . "/" . $_SESSION['id'];  // this only targets the current user
    // // system("rm -rf " . escapeshellarg($UploadDirUserId)); // forces wipes the entire directory
    // 
    $userIdDir = $baseUploadDir . "/" . $_SESSION['id'] . "/";  // this limits the scope to the current user
    $currentTimestamp = time();
    // one month is 30 days for outsiders ;)
    $oneMonthInSeconds = 31 * 24 * 60 * 60;         // 31 days at least allows a wiggle room of a few days
    $thresholdInMonths = 3 * $oneMonthInSeconds;    // I just set it to 3 months for now
    $deletionThreshold = $currentTimestamp - $thresholdInMonths;    // calculates the range
    // i need a loop
    foreach (scandir($userIdDir) as $directory) {
        if ($directory !== '.' || $directory !== '..') {    // this should exclude the current and parent folder depending on the file system
            $directoryPath = $userIdDir . $directory;   // grabs the entire path
            if (is_dir($directoryPath)) {   // checks if the folder hasn't been removed
                if (is_numeric($directory)) {   // checks if the folder is entirely numeric
                    if ($deletionThreshold > $directory) {  // if the deletion treshold is newer than the directory...
                        system("rm -rf " . escapeshellarg($directoryPath)); // ...it annihilates it
                    }
                }
            }
        }
    }
};



// pdf upload
function upload_pdf_delfin()
{
    if (empty($_FILES['fileToUpload']['name'])) {
        echo "<strong>Keen Fichier ausgewielt</strong><br />";
    } elseif (isset($_FILES['fileToUpload'])) {

        // preparing the file checking
        $fileNAME = $_FILES['fileToUpload']['name'];
        $fileMIME = mime_content_type($_FILES['fileToUpload']['tmp_name']); // mime needs tmp_name
        // var_dump($_FILES['fileToUpload']);
        // var_dump($fileMIME);

        // checks the file extension
        if (!preg_match("/\.pdf$/i", $fileNAME)) {
            echo "<strong>.PDF obligatoresch</strong><br />";
        }
        // checks the file's mime type
        elseif ($fileMIME === 'application/pdf') {
            // and continues if valid
            $file = $_FILES['fileToUpload'];
            // var_dump($file);
            $targetFile = file_upload_delfin($file);  // now i can use the returned variable from the function
            // var_dump($targetFile);
            // next part:
            // header('Location: send_mail.php?file=' . urlencode($targetFile));
            $_SESSION['targetFile'] = $targetFile;  // save it inside the user's session
            header('Location: send_mail.php');
            exit();
        } else {
            echo "<strong>Muss ee richteg formatéierte PDF Fichier sinn</strong><br />";
        }
        // }


    } else {
        echo "<strong>Unknown Error Occured</strong><br />";
    }
};



// docX upload
function upload_docX_delfin()
{
    if (empty($_FILES['fileToUpload']['name'])) {
        echo "<strong>Keen Fichier ausgewielt</strong><br />";
    } elseif (isset($_FILES['fileToUpload'])) {

        // preparing the file checking
        $fileNAME = $_FILES['fileToUpload']['name'];
        $fileMIME = mime_content_type($_FILES['fileToUpload']['tmp_name']); // mime needs tmp_name
        // var_dump($_FILES['fileToUpload']);
        // var_dump($fileMIME);

        // checks the file extension
        if (!preg_match("/\.docx$/i", $fileNAME)) {
            echo "<strong>.DOXC obligatoresch</strong><br />";
        }
        // checks the file's mime type
        elseif ($fileMIME === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {  // yes this is docX
            // and continues if valid
            $file = $_FILES['fileToUpload'];
            // var_dump($file);
            $targetFile = file_upload_delfin($file);  // now i can use the returned variable from the function
            // var_dump($targetFile);
            // next part:
            // header('Location: send_mail.php?file=' . urlencode($targetFile));
            $_SESSION['targetFile'] = $targetFile;  // save it inside the user's session
            header('Location: send_mail.php');
            exit();
        } else {
            echo "<strong>Muss ee richteg formatéierte DOCX Fichier sinn</strong><br />";
        }
        // }


    } else {
        echo "<strong>Unknown Error Occured</strong><br />";
    }
};

// docX fill data {hard coded fields!}
function modify_docX_delfin($templateDocX, $outputDocX, $recipientUser)
{
    //! $recipientUser used inside the array as variables
    $replacementsArray = [
        '«Allocation»' => $recipientUser['allocation'] ?: '​',
        '«Nom»' => $recipientUser['nom'] ?: '​',
        '«Nom2»' => $recipientUser['nom2'] ?: '​',
        '«Fonction»' => $recipientUser['fonction'] ?: '​',      //? if variable is empty or null or false it will use U+200B ; which is not empty on purpose
        '«Adresse1»' => $recipientUser['adresse1'] ?: '​',
        '«Adresse2»' => $recipientUser['adresse2'] ?: '​',
        '«Allocation_Spéciale»' => $recipientUser['allocationSpeciale'] ?: '​',
        '«Nom_coupon-réponse»' => $recipientUser['nomCouponReponse'] ?: '​',        //! verify actual field name! 
    ];
    ob_start();         // output buffer so it removes the annnoying notification from this extension
    $word = new Word();
    $word->findAndReplace($templateDocX, $outputDocX, $replacementsArray);
    // echo "<br />";  // File written! is always printed :/ 
    ob_end_clean();     // do i need to explain this ?!?
};

// convert docX to pdf (libre office plugin)
function convertDocXToPdf($inputDocX, $outputPdf, $inputDocXDir)
{
    // $inputDocXDir;   // 
    // $recipientId = $recipientUser['recipientId'];
    $inputDocX = escapeshellarg($inputDocX);    // requires real path
    $outputPdf = escapeshellarg($outputPdf);    // ditto
    if (file_exists($outputPdf)) {
        unlink($outputPdf);         // it can't overwrite exisiting files
    }
    // /var/www/html/ is from compose.yaml
    // $command = "HOME=/tmp libreoffice --headless --convert-to pdf --outdir /var/www/html/uploads $inputDocX 2>&1";  // this one works
    // $outDir = "/var/www/html/" . $GLOBALS['uploadBasePath'];
    $outDir = "/var/www/html/" . $inputDocXDir;
    $command = "HOME=/tmp libreoffice --headless --convert-to pdf --outdir $outDir $inputDocX 2>&1";
    $output = shell_exec($command);     //? the $output variable can be used for logging purposes

    // file_put_contents('/var/www/html/uploads/convert_log.txt', $output);    // logging file
    // echo "<pre>$output</pre>";  // visible on the webpage
    // echo "<br />";  // 

    return file_exists($outputPdf) ? $outputPdf : false;    // black magive / witchcraft prevention
};

// ! UNUSED
function digitally_sign_pdf_delfin($pdfToSign)
{
    // new filename or directory or force overwrite required; PERHAPS ?
    // input path + file => DIR /signed/ ; most edit the original though , so not actually needed
    return $pdfToSign;
};



function letter_required_delfin($recipientId)
{
    $_SESSION['letter_id_array'][] = $recipientId;  // this needs to be an array
    // var_dump($_SESSION['letter_id_array']);
    // echo "<br />";
};

function combine_all_letters_into_one_pdf_delfin($baseDir, $templateFile, $timestamp)
{
    if (!isset($_SESSION['letter_id_array'])) {
        exit;   // no point in continuing
    }
    if (empty($_SESSION['letter_id_array'])) {
        unset($_SESSION['letter_id_array']);    // cleanup , just to be sure
        exit;
    }
    // go on
    $targetFName = str_replace($baseDir, '', $templateFile);    // gets just the reference file with extension
    $targetFName = str_replace('.docx', '.pdf', $targetFName);  // this still has the .docx file extension
    $outputRefName = str_replace('.pdf', '', $targetFName);     // this is for the line just below
    $combinedFile = $baseDir . "Nëmmen Bréiwer!" . " - " . $outputRefName . " - " . $timestamp . ".pdf";    // fancy name ; and a filestamp to prevent duplicates on the user's side
    // var_dump($combinedFile);
    // echo "<br />";
    $pdf = new Fpdi();  // I need to initiliaze the fpdi plugin
    // i prefer for each loops over i++
    foreach ($_SESSION['letter_id_array'] as $recipientId) {
        $pdfId = $baseDir . $recipientId . "/" . $targetFName;  // the file with its path
        // var_dump($pdfId);
        // echo "<br />";
        if (file_exists($pdfId)) {    // if somehow palpatine returned and used sith magic i at least want this to drop a non existing file
            $pageCount = $pdf->setSourceFile($pdfId);
            foreach (range(1, $pageCount) as $page) {
                $pdf->AddPage();
                $pdf->useTemplate($pdf->importPage($page));
            }
        }
    }
    // verifiying if there is smth at least
    if ($pdf->PageNo() > 0) {
        $pdf->Output($combinedFile, 'F');
    }
    // the end
    unset($_SESSION['letter_id_array']);    // this is needed
    echo "<br /><a href='" . $combinedFile . "' download>Download PDF for printing for those who require a letter or for those whose email failed to send</a><br />";
};

function email_or_letter_mode_delfin()
{
    if (isset($_SESSION['letter_required'])) {
        if ($_SESSION['letter_required'] === true) {
            echo '<br /><h2 style="color: blue;">Letter Mode</h2><br />';
        }
    }
    else {
        echo '<br /><h2 style="color: red;">Email Mode</h2><br />';
    }
}



