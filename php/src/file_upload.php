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

  // store entered text or set default one from the env file  // overkill since the default env message is also set on the next page
  $emailSubject = isset($_POST['email_subject']) && $_POST['email_subject'] !== '' ? $_POST['email_subject'] : getenv('DEFAULT_EMAIL_SUBJECT');
  $_SESSION['emailSubject'] = $emailSubject;
  $emailBody = isset($_POST['email_body']) && $_POST['email_body'] !== '' ? $_POST['email_body'] : getenv('DEFAULT_EMAIL_BODY');
  $_SESSION['emailBody'] = $emailBody;

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
}




include 'header.html';

?>

<br />
<h2>Fichier uploaden a verschécken</h2><br />
<form method="POST" enctype="multipart/form-data">

  <em>Text personaliséieren?</em><br />
  <!-- <em>Limitt: 500 & 2000 Zeechen</em><br /> -->
  <!-- maxlength="" removed -->
  <label for="email_subject"></label>
  <strong>Email Subject: </strong><input type="text" name="email_subject" id="email_subject" class="email_subject" placeholder=" Default: <?= getenv('DEFAULT_EMAIL_SUBJECT') ?> " value="<?= $_POST['email_subject'] ?? getenv('DEFAULT_EMAIL_SUBJECT') ?>">
  <br />
  <strong>Email Body: </strong><label for="email_body"></label>
  <input type="text" name="email_body" id="email_body" class="email_body" placeholder=" Default: <?= getenv('DEFAULT_EMAIL_BODY') ?> " value="<?= $_POST['email_body'] ?? getenv('DEFAULT_EMAIL_BODY') ?>">
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

