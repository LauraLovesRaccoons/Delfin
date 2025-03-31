<?php

// include_once "../functions.php";    //? yes


// // I'm not messing around with wannabe hackerz
// session_checker_delfin();


// actually checks if someone does have permissions ; why these specifically? Well since these were added later into my DB
if (!isset($_SESSION['signatureName'], $_SESSION['signaturePhone'], $_SESSION['signatureService'])) {
    header("Location: ../delfin.php");  //? since this doesn't call the session, i just redirect the landing page which handles unauthorized access
                                        //? also I need to move in the previous directory
    exit();     //? this will never execute if the function below is called from another page that has a proper session set
};


//? template vars
$signatureName = $_SESSION['signatureName'];
$signaturePhone = $_SESSION['signaturePhone'];
$signatureService = $_SESSION['signatureService'];
$signatureEmail = $_SESSION['email'];   // the email is universal
//! optional vars will check if string is bigger then 1 and then load the string with the variable
//? optional vars
$signatureTitle = "'<br><i>{#title}</i>'";
$sigantureOffice = "'<br><i>{#office}</i>'";
$sigantureGSM = "<br><i>GSM: {#mobile}</i>";
$sigantureFax = "<br><i>Fax: {#fax}</i>";
// banner
$banner = "";     //? leaving this empty for now (or forever?)

//! template
$template = 
    '<br />' . 
    '<table border=1 cellspacing=0 cellpadding=0 style="border-collapse:collapse;border:none;"><tr>' . 
    '<td width="110" valign=top align=center style="border:solid black 1.0pt;border-right:none;padding:15px 8px 15px 8px;">' . 
    '<p><img width=94 height=58 src="http://web.petange.lu/signature/email.logo.jpg" alt="Logo P&eacute;tange"></p></td>' . 
    '<td width="300" valign=top style="border:solid black 1.0pt;border-left:none;padding:15px 5px 15px 5px;">' . 
    '<span style="font-family:Calibri;color:#1f497d;font-size:10pt;">' . 
    '<b><span style="color:#101010;">' . $signatureName . '</span></b>' . 
    '<br><i>Administration communale de Pétange</i>' . 
    '<br><i>' . $signatureService . '</i>' . 
    $signatureTitle . 
    $sigantureOffice . 
    '<br><i>T&eacute;l: ' . $signaturePhone . '</i>' . 
    $sigantureGSM . 
    $sigantureFax . 
    '<br><i>E-Mail&nbsp;:&nbsp;<a href="mailto:' . $signatureEmail . '">' . $signatureEmail . '</a></i>' . 
    '<br><i>Web&nbsp;:&nbsp;</i><a href="https://www.petange.lu"><i>https://www.petange.lu</i></a>' . 
    '</span></td></tr>' . 
    $banner . 
    '<br />'
    ;



// function to append the filled in template
function appendSignature_delfin($emailBody)
{
    global $template;   //? i need to call it with global
    $emailBody = $emailBody . "<br />" . $template;     //? catenates both strings into one ; with a line break
    return $emailBody;
};


?>
