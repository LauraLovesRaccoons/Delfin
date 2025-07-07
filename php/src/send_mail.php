<?php

// // use Enflow\DocumentReplacer\Converters\UnoserverConverter;

// ob_start();

require "functions.php";

// session id handoff
session_checker_delfin();

// expansion
require "./functions/signature_template.php";   //? since a session is required this MUST come after the session_checker_delfin() function call



// if (isset($_GET['file'])) {
//     $targetFile = urldecode($_GET['file']);
//     if (!file_exists($targetFile)) {
//         header("Location: /delfin.php"); // redirects if the file doesn't exist
//         exit();
//     }


if (isset($_SESSION['targetFile'])) {

    //? WAITING PART IF SOMEONE IS ALREADY USING THIS
    batchJobAlreadyRunning_delfin();
    set_batchJobAlreadyRunning_delfin();
    //? If you somehow have a target file in the session but not the other stuff , you're gonna wait as a punishment!

    $templateFile = $_SESSION['targetFile'];
    unset($_SESSION['targetFile']); // prevents sending duplicate mails

    // start expansion V1.2.0
    if (isset($_SESSION['targetSecondAttachement'])) {
        $secondAttachement = $_SESSION['targetSecondAttachement'];  // sets the second attachement in a local var
        unset($_SESSION['targetSecondAttachement']);
    } else {
        $secondAttachement = "";    // if there isn't a second attachement, this will be an empty string "path"
    }
    // end expansion V1.2.0

    // run this before writing to the log file, as the older logs are less likely to be needed
    log_too_big_delfin();
    // the IF is just to be sure no shenanigans are going on
    if (isset($_SESSION['targetDir'])) {
        $templateDir = $_SESSION['targetDir'];
        unset($_SESSION['targetDir']);
    } else {
        clear_batchJobAlreadyRunning_delfin();  //? prevents the job lock flag from becoming stuck
        header("Location: /delfin.php");
        exit();
    }
} else {
    header("Location: /delfin.php");     // I'm not messing around with wannabe hackers
    exit();
};

// it's better to be sure this hasn't somehow been purged
if (isset($_SESSION['targetUsersArray'])) {
    $emailRecipientsArray = $_SESSION['targetUsersArray'];
    unset($_SESSION['targetUsersArray']); // prevents having a duplicate Array of Users and potentionally sending duplicate mails
} else {
    clear_batchJobAlreadyRunning_delfin();  //? prevents the job lock flag from becoming stuck
    header("Location: /delfin.php");
    exit();
};

// sets the Subject and Body and loads the default from the env file if it doesn't exist
if (isset($_SESSION['emailSubject'])) {
    $emailSubject = $_SESSION['emailSubject'];
    unset($_SESSION['emailSubject']);   // wipe it ditto
} else {
    $emailSubject = getenv('DEFAULT_EMAIL_SUBJECT');
};

if (isset($_SESSION['emailBody'])) {
    $emailBody = $_SESSION['emailBody'];
    unset($_SESSION['emailBody']);  // wipe it ditto
} else {
    $emailBody = getenv('DEFAULT_EMAIL_BODY');
};

// append signature to the email body
$emailBody = appendSignature_delfin($emailBody);


// echo "<h1>The file must be cleared afterwards</h1><br />";


?>


<?php
include 'header.php';  //? this code should never cancel if there is an issue loading the header
?>

<div class="general-wrapper">

    <article class="batch-job-wrapper">

        <h2>Batch Job Finished</h2>

        <span id="downloadLinkMsg"></span> <!-- the span will be overwritten by outerHTML with JS -->
        <br />
        <div id="emailNotSendInfoBox"> <!-- the id allows me to completely hide it with javacript -->

            <?php

            // removing the full path from the file or else it will get too compilcated
            $templateFileName = str_replace($templateDir, "", $templateFile);
            // $templateFileName = ltrim($templateFile, '/');  // this would remove the / in front of the filename ,but it's already contained in the full path (dir)
            // 
            // Loop through the array and send emails
            foreach ($emailRecipientsArray as $recipientUser) {
                $emailSender = $_SESSION['email'];
                $emailSenderName = $_SESSION['username'];
                // path stuff
                $timestamp = time();    //? yes -> 
                $recipientUserId = $recipientUser['recipientId'];

                // 
                // replacing docX fields with data
                $templateDocX = $templateFile;
                // i might need to create the directory before trying to write to it
                // $outputDocXDir = $templateDir . $recipientUserId . "/" . $timestamp . "/";  //? dropped; creates an unnecessary folder named after another timestamp in directory named already after a timestamp
                $outputDocXDir = $templateDir . $recipientUserId . "/";     //? much easier to use IF files are kept
                $outputDocX = $outputDocXDir . $templateFileName;
                if (!is_dir($outputDocXDir)) {
                    mkdir($outputDocXDir, 0777, true);  // Create directory; but everyone can access it :/
                } else {
                    system("rm -rf " . escapeshellarg($outputDocXDir)); // witchcraft ; libre office would force overwrite it though ; but my docX editor doesn't
                };
                // $outputDocX = $GLOBALS['uploadBasePath'] . "IT-WORKZ.docx"; // proof that it requires the directory to exist
                // 
                modify_docX_delfin($templateDocX, $outputDocX, $recipientUser);
                // con(v)ert filled in docX to pdf
                $inputDocX = $outputDocX;   // easier to read code
                $outputPdf = preg_replace('/\.docx$/i', '.pdf', $inputDocX);    // changes .docx to .pdf ; since the tool doesn't dew it
                $inputDocXDir = $outputDocXDir; // easier to read code
                convertDocXToPdf_delfin($inputDocX, $outputPdf, $inputDocXDir);
                //? deleting the "temporary" filled in docX files to only have the pdf in the directory
                if (file_exists($inputDocX)) {
                    unlink($inputDocX);     //? uncomment this if you need to debug smth
                }
                //? this is currently only .odt
                $otherFormatDocX = str_ireplace(".docx", ".odt", $inputDocX);   //? .docx is case insensitive
                if (file_exists($otherFormatDocX)) {
                    unlink($otherFormatDocX);   //? uncomment this if you need to debug smth
                }
                //? copy the if above for other formats

                //! Future
                $signedPdf = digitally_sign_pdf_delfin($outputPdf);
                // therefore the line below
                $emailAttachement = $signedPdf;
                // if a letter is specifically required this will make the email invalid
                //  the send_mail function has smth built in for this
                if (isset($_SESSION['letter_required'])) {
                    if ($_SESSION['letter_required'] === true) {
                        $recipientUser['emailRecipient'] = "";
                    }
                }
                // actual sending part
                send_mail_delfin(
                    $emailSender,
                    $emailSenderName,
                    $recipientUser['emailRecipient'],
                    $recipientUser['emailRecipientName'],
                    $emailSubject,
                    $emailBody,
                    $emailAttachement,
                    $recipientUser['recipientId'],
                    $secondAttachement      // expansion V1.2.0
                );
                // wait for 1 millisecond ; don't go below that!
                usleep(1000);   // 1000 microseconds
            }
            $timestamp = time();    //? I have no idea why, but I can no longer rely on the one above
            combine_all_letters_into_one_pdf_delfin($templateDir, $templateFile, $timestamp);  //? hello darkness my old friend  I've come to talk with you again
            // cleans these session variables
            if (isset($_SESSION['letter_required'])) {
                unset($_SESSION['letter_required']);
                // I don't want the emailNotSendInfoBox visible in letter mode and this is the last place where I can detect if letter mode was used
                echo "<script>
                    document.getElementById('emailNotSendInfoBox').style.display = 'none';
                </script>";
            }
            //? this was added much later
            if (isset($_SESSION['selectedList'])) {
                //? creates an empty directory named after the selected list
                // just to be able to easily check which list was selected
                $stringSelectedList = (string)$_SESSION['selectedList'];
                $directoryNamedAfterSelectedList = $templateDir . $stringSelectedList . "/";
                if (!is_dir($directoryNamedAfterSelectedList)) {
                    mkdir($directoryNamedAfterSelectedList, 0777, true);
                };
                // happy
                unset($_SESSION['selectedList']);
            }
            delete_uploads_dir_delfin();    // cleanup
            //?
            clear_batchJobAlreadyRunning_delfin();

            ?>
        </div>
    </article>
</div>

<?php
include 'footer.php';  //? the code above should never cancel
?>