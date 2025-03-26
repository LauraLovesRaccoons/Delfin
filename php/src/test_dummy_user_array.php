<?php

// ob_start();

require "functions.php";

session_checker_delfin();


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (isset($_POST['enable_letter_mode'])) {
//         $_SESSION['letter_required'] = true;    // this is the easiest option to add this feature
//     }
//     elseif(isset($_POST['disable_letter_mode'])){
//         unset($_SESSION['letter_required']);
//     }
// }



// <!-- EXAMPLE ARRAY -->

$dummyAccounts = [
    [
        'emailRecipient' => $_SESSION['email'],
        'emailRecipientName' => $_SESSION['username'],
        // 'emailRecipientName' => "<em><u>This is YOUR account and your personal ID:</u></em> " . $_SESSION['username'] . " - " . $_SESSION['email'],     //? makes it more obvious
        'recipientId' => 0,     // normally from database ; but since this is testing it has id=0
        // 'recipientId' => $_SESSION['id'],   //? manual override
        // filling it with test data
        'allocation' => htmlspecialchars('!allocation!', ENT_QUOTES, 'UTF-8'),
        'nom' => htmlspecialchars('!nom!', ENT_QUOTES, 'UTF-8'),
        'nom2' => htmlspecialchars('!nom2!', ENT_QUOTES, 'UTF-8'),
        'fonction' => htmlspecialchars('!fonction!', ENT_QUOTES, 'UTF-8'),
        'adresse1' => htmlspecialchars('!adresse1!', ENT_QUOTES, 'UTF-8'),
        'adresse2' => htmlspecialchars('!adresse2!', ENT_QUOTES, 'UTF-8'),
        'allocationSpeciale' => htmlspecialchars('!allocationSpeciale!', ENT_QUOTES, 'UTF-8'),
        'nomCouponReponse' => htmlspecialchars('!nomCouponReponse!', ENT_QUOTES, 'UTF-8'),      //! verify actual field name!

        // ],
        // [
        //     'emailRecipient' => 'loser@petange.lu',
        //     'emailRecipientName' => 'LOSER Dummy Recipient',
        //     'recipientId' => 666
        // ],
        // [
        //     'emailRecipient' => 'holaura@protonmail.com',
        //     'emailRecipientName' => 'LOSER Dummy Recipient',
        //     'recipientId' => 455
        //     ],
        // [
        //     'emailRecipient' => 'NO-EMAIL',
        //     'emailRecipientName' => 'i do not have an email',
        //     'recipientId' => 555

    ]   //! the last one must drop the comma
];


$_SESSION['selectedList'] = "YOURSELF";         //? this is needed for the next page
$_SESSION['targetUsersArray'] = $dummyAccounts;

require "header.html";

echo '<div class="general-wrapper">';

echo "<br />";
echo "<h2>This will send a test email to yourself</h2><br />";
echo '<a href="file_upload.php"> GO TO:  UPLOAD FILE -> </a><br />';
echo "<br />";


?>

<!-- 
<form method="POST">
    <button type="submit" name="enable_letter_mode">Enable Letter Mode</button>
    <button type="submit" name="disable_letter_mode">Email Mode (default)</button>
</form>
 -->


</div>

<?php

require "footer.html";

?>

