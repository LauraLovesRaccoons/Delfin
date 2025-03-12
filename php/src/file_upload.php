<?php

ob_start();

require "functions.php";

session_checker_delfin();

if (isset($_SESSION['targetUsersArray'])) {
  $targetUsersArray = $_SESSION['targetUsersArray'];
} else {
  header("Location: delfin.php");
  exit();
}


if (isset($_POST['submit_button'])) {
  // if(!isset($_FILES['fileToUplad'])){
  //   echo "<strong>Keen Fichier ausgewielt</strong><br />";
  //   // needs to come before the next line to handle custom empty file msg
  // }
  // elseif($_FILES['fileToUpload']['error'] !== UPLOAD_ERR_OK){
  //   echo "<strong>Fichier ass iwwert 20MB</strong><br />";
  //   // this doesn't work though ; future -> custom error msg
  // }
  // elseif (!empty($_FILES['fileToUpload']['name'])) {

  // next part
  // header('Location: send_mail.php');
  // exit();
  // else {
  //   echo "<strong>Keen Fichier ausgewielt</strong><br />";
  // }

  // store entered text or set default one from the env file
  $emailSubject = isset($_POST['email_subject']) && $_POST['email_subject'] !== '' ? $_POST['email_subject'] : getenv('DEFAULT_EMAIL_SUBJECT');
  $_SESSION['email_subject'] = $emailSubject;
  $emailBody = isset($_POST['email_body']) && $_POST['email_body'] !== '' ? $_POST['email_body'] : getenv('DEFAULT_EMAIL_BODY');
  $_SESSION['email_body'] = $emailBody;

  if (empty($_FILES['fileToUpload']['name'])) {
    echo "<strong>Keen Fichier ausgewielt</strong><br />";
  } else {
    $file = $_FILES['fileToUpload'];
    // var_dump($file);
    $targetFile = file_upload_delfin($file);  // now i can use the returned variable from the function
    // var_dump($targetFile);
    // next part:
    // header('Location: send_mail.php?file=' . urlencode($targetFile));
    $_SESSION['targetFile'] = $targetFile;  // save it inside the user's session
    header('Location: send_mail.php');
    exit();
  }
}




include 'header.html';

?>

<br />
<h2>Fichier uploaden a verschécken</h2><br />
<form method="POST" enctype="multipart/form-data">

  <em>Text personaliséieren?</em><br />
  <em>Limitt: 250 & 500 Zeechen</em><br />
  <label for="email_subject"></label>
  <strong>Email Subject: </strong><input type="text" name="email_subject" id="email_subject" maxlength="255" class="char256" placeholder=" Default: <?= getenv('DEFAULT_EMAIL_SUBJECT') ?> " value="<?= $_POST['email_subject'] ?? getenv('DEFAULT_EMAIL_SUBJECT') ?>">
  <br />
  <strong>Email Body: </strong><label for="email_body"></label>
  <input type="text" name="email_body" id="email_body" maxlength="511" class="char512" placeholder=" Default: <?= getenv('DEFAULT_EMAIL_BODY') ?> " value="<?= $_POST['email_body'] ?? getenv('DEFAULT_EMAIL_BODY') ?>">
  <br />

  <em>Fichier auswielen:</em><br />
  <label for="file"></label>
  <input type="file" name="fileToUpload" id="fileToUpload">
  <br />
  <label for="submit"></label>
  <input type="submit" value=" Upload File & Send Emails " name="submit_button" id="">
  <br />
</form>
<!-- <br /> -->
<strong>Kann ee bëssi daueren...</strong><br />
<em>Ënnert 20MB soss komme Feelermeldungen!</em><br />
<br />

<br />


<?php
include 'footer.html';
?>



<?php
// delete_uploads_dir_delfin();
?>

