<?php

ob_start();

require "functions.php";

session_checker_delfin();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['enable_letter_mode'])) {
        $_SESSION['letter_required'] = true;    // this is the easiest option to add this feature
    } elseif (isset($_POST['disable_letter_mode'])) {
        unset($_SESSION['letter_required']);
    }
}

// wipes it, if it exists already
if (isset($_SESSION['targetUsersArray'])) {
    unset($_SESSION['targetUsersArray']);
}




include 'header.html';

$selectedList = "list_A";   // this is usefull

$grabbedUsers = [];

$db = db_connect_delfin();

// $query = "SELECT id, allocation, nom, nom2, fonction, adresse1, adresse2, allocationSpeciale, email, nomCouponReponse, letter_required FROM Users WHERE $selectedList = ?";
$query = "SELECT * FROM Users WHERE $selectedList = ?";     //? I just grab everything for possible future expansions
$stmt = $db->prepare($query);
$listTrue = 1;
$stmt->bind_param("i", $listTrue);
$stmt->execute();
$result = $stmt->get_result();


while ($recipientUser = $result->fetch_assoc()) {
    $grabbedUsers[] = [
        'recipientId' => $recipientUser['id'],
        'emailRecipient' => $recipientUser['letter_required'] ? '' : $recipientUser['email'],   // if the person requires a letter, this invalidates the email
        'emailRecipientName' => empty(trim($recipientUser['nom'])) ? $recipientUser['nom2'] : $recipientUser['nom'],    // this if for logging purposes ; if nom is empty, it will grab nom2
        'allocation' => $recipientUser['allocation'],
        'nom' => $recipientUser['nom'],
        'nom2' => $recipientUser['nom2'],
        'fonction' => $recipientUser['fonction'],
        'adresse1' => $recipientUser['adresse1'],
        'adresse2' => $recipientUser['adresse2'],
        'allocationSpeciale' => $recipientUser['allocationSpeciale'],
        'nomCouponReponse' => $recipientUser['nomCouponReponse'],
    ];
}

$stmt->close();

db_close_delfin($db);

$_SESSION['targetUsersArray'] = $grabbedUsers;


echo "<br />";
echo "<h1>you now have a <strong>DATABASE</strong> emailing list ready</h1><br />";
echo '<a href="file_upload.php">UPLOAD FILE -> </a><br />';
echo "<br />";






// $myName = "SUPER";

// // Define the replacements
// $replacements = [
//     '«Allocation»' => 'Madame',
//     '«Nom»' => $myName,
//     '«Nom2»' => 'Laura',
//     '«Fonction»' => '',
//     '«Adresse1»' => 'Place JFK',
//     '«Adresse2»' => 'Pétange',
//     '«Allocation_Spéciale»' => 'Prinzessin',
//     '«ERRORRRORRRRR»' => 'AA<AAAAASHBSJBU989965S',
// ];

// function here


?>

<br />
<hr />
<br />
<h3>Mode Switch</h3>
<form method="POST">
    <label for="submit"></label>
    <button type="submit" name="enable_letter_mode">Switch to Letter Mode</button>
    <br />
    <label for="submit"></label>
    <button type="submit" name="disable_letter_mode">Switch to Email Mode (default)</button>
</form>
<br />
<hr />
<br />




<?php
include 'footer.html';
?>