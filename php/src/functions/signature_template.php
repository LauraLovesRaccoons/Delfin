<?php

// since this is only intended to be called during another php page, there is no session set
// meaning this will always redirect if manually typed into the browser

// actually checks if someone does have permissions ; why these specifically? Well since these were added later into my DB
if (!isset($_SESSION['signatureName'], $_SESSION['signaturePhone'], $_SESSION['signatureService'], $_SESSION['signatureTitle'], $_SESSION['signatureOffice'], $_SESSION['signatureGSM'], $_SESSION['signatureFax'])) {
    header("Location: /delfin.php");    //? since this doesn't call the session, i just redirect to the landing page which handles unauthorized access  // also targets the root of the server
                                        //? also I need to move into the previous directory
    exit();     //? this will never execute if the function below is called from another page that has a proper session set
};


//? template vars
$signatureName = $_SESSION['signatureName'];
$signaturePhone = $_SESSION['signaturePhone'];
$signatureService = $_SESSION['signatureService'];
$signatureEmail = $_SESSION['email'];   // the email is universal
$signatureTitle = $_SESSION['signatureTitle'];
$signatureOffice = $_SESSION['signatureOffice'];
$signatureGSM = $_SESSION['signatureGSM'];
$signatureFax = $_SESSION['signatureFax'];
// optional vars will check if string is bigger then 1 and then load the string with the variable
//? optional vars
$signatureTitle = (empty($signatureTitle) || strlen($signatureTitle ?? '') < 2) ? '' : '<br><i>' . $signatureTitle . '</i>';
$signatureOffice = (empty($signatureOffice) || strlen($signatureOffice ?? '') < 2) ? '' : '<br><i>' . $signatureOffice . '</i>';
$signatureGSM = (empty($signatureGSM) || strlen($signatureGSM ?? '') < 2) ? '' : '<br><i>GSM: ' . $signatureGSM . '</i>';
$signatureFax = (empty($signatureFax) || strlen($signatureFax ?? '') < 2) ? '' : '<br><i>Fax: ' . $signatureFax . '</i>';
// banner
$banner = 
    '<tr><td width="410" height="109" colspan="2" style="border:none;padding:10px 1px;">' . 
    '<a href="https://petange.lu/canaux-de-communication/"><img src="{banner}" alt="https://petange.lu/canaux-de-communication/"></a>' . 
    '</td></tr>' ;
// $banner = '';   // can be used to disable the banner ; was used previously as a placeholder variable for the banner

//! template
$template = 
    '<br />' . 
    '<table border=1 cellspacing=0 cellpadding=0 style="border-collapse:collapse;border:none;"><tr>' . 
    '<td width="110" valign=top align=center style="border:solid black 1.0pt;border-right:none;padding:15px 8px 15px 8px;">' . 
    '<p><img width=94 height=58 src="{logo}" alt="Logo P&eacute;tange"></p></td>' . 
    '<td width="300" valign=top style="border:solid black 1.0pt;border-left:none;padding:15px 5px 15px 5px;">' . 
    '<span style="font-family:Calibri;color:#1f497d;font-size:10pt;">' . 
    '<b><span style="color:#101010;">' . $signatureName . '</span></b>' . 
    '<br><i>Administration communale de Pétange</i>' . 
    '<br><i>' . $signatureService . '</i>' . 
    $signatureTitle . 
    $signatureOffice . 
    '<br><i>T&eacute;l: ' . $signaturePhone . '</i>' . 
    $signatureGSM . 
    $signatureFax . 
    '<br><i>E-Mail&nbsp;:&nbsp;<a href="mailto:' . $signatureEmail . '">' . $signatureEmail . '</a></i>' . 
    '<br><i>Web&nbsp;:&nbsp;</i><a href="https://www.petange.lu"><i>https://www.petange.lu</i></a>' . 
    '</span></td></tr>' . 
    $banner . 
    '</table>' . 
    '<br />'
    ;


    // echo "<br />";
    // var_dump($signatureTitle, $signatureOffice, $signatureGSM, $signatureFax);
    // echo "<br />";
    // echo $template;
    // echo "<br />";



// function to append the filled in template
function appendSignature_delfin($emailBody)
{
    global $template;   //? i need to call it with global
    // $emailBody = $emailBody . "<br />" . $template;     //? catenates both strings into one ; with a line break
    $emailBody = "<p>" . $emailBody . "</p>" . $template;     //? catenates both strings into one ; and the message is its own paragraph
    return $emailBody;
};
?>
