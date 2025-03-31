<?php

// require "functions.php";    //? yes

// // I'm not messing around with wannabe hackerz
// session_checker_delfin();



// if (isset($_SESSION['signatureName']) || isset($_SESSION['signaturePhone']) || isset($_SESSION['signatureService'])) {
//     // header("Location: delfin.php");
//     // exit();
//     echo "<strong>Signature not set</strong><br />";
// }

// if (!isset($_SESSION['id'])) {
//     header("Location: delfin.php");
//     exit();
// };

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
    "<br />";


// function to append the filled in template
function appendSignature_delfin($emailBody)
{
    $emailBody = $emailBody . $GLOBALS['template']; //? i need to call the template as a global var
    return $emailBody;
};


?>
