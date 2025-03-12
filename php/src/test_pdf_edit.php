<?php

ob_start();

require "functions.php";

session_checker_delfin();

$dummyAccounts = [
    [
        'emailRecipient' => 'laura.hornick@petange.lu',
        'emailRecipientName' => 'Dummy Recipient 1',
        'RecipientId' => 1   // from database
    ],
    [
        'emailRecipient' => 'loser@petange.lu',
        'emailRecipientName' => 'LOSER Dummy Recipient',
        'RecipientId' => 3
    ],
    [
        'emailRecipient' => 'loser@email.com.lux',
        'emailRecipientName' => 'LOSER Dummy Recipient',
        'RecipientId' => 455
    ]
];

$_SESSION['targetUsersArray'] = $dummyAccounts;

if (isset($_SESSION['targetUsersArray'])) {
  $targetUsersArray = $_SESSION['targetUsersArray'];
} else {
  header("Location: delfin.php");
  exit();
}


if (isset($_POST['submit_button'])) {

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
      header('Location: test_pdf_download.php');
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
<h2>TEST !!!!!!! </h2><br />
<form method="POST" enctype="multipart/form-data">



  <em>Fichier auswielen:</em><br />
  <label for="file"></label>
  <input type="file" name="fileToUpload" id="fileToUpload" required>
  <br />
  <label for="submit"></label>
  <input type="submit" value=" Upload File & Send Emails " name="submit_button" id="">
  <br />
</form>
<br />

<br />

<br />


<?php
include 'footer.html';
?>



<?php
// delete_uploads_dir_delfin();
?>

