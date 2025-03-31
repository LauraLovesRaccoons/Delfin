<?php

// include_once "functions.php";   //? yes


// // I'm not messing around with wannabe hackerz
// session_checker_delfin();


// actually checks if someone does have permissions ; why these specifically? Well since these were added later into my DB
if (!isset($_SESSION['signatureName'], $_SESSION['signaturePhone'], $_SESSION['signatureService'])) {
    header("Location: delfin.php");     //? since this doesn't call the session, i just redirect the landing page which handles unauthorized access
    exit();     //? this will never execute if the function below is called from another page that has a proper session set
};


//? template vars
$user['signatureName'] = $_SESSION['signatureName'];
$user['signaturePhone'] = $_SESSION['signaturePhone'];
$user['signatureService'] = $_SESSION['signatureService'];

//! template
$template = "<br /> SIGNATURE IS POSSIBLE <br />" .
    "<br />" .
    "<strong>" . $user['signatureName'] . "</strong><br />" .
    "<strong>" . $user['signaturePhone'] . "</strong><br />" .
    "<strong>" . $user['signatureService'] . "</strong><br />" .
    "<br />FAREWELL";


// function to append the filled in template
function appendSignature_delfin($emailBody)
{
    global $template;   //? i need to call it with global
    $emailBody = $emailBody . $template;    //? catenates both strings into one
    return $emailBody;
};


?>
