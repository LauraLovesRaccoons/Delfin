<?php

ob_start();

require "functions.php";

session_checker_delfin();

$dummyAccounts = [
    [
        'fonction' => 'MASTER',
        'nom' => 'LAURA',
        'userId' => 1   // from database
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
  upload_pdf_delfin();
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

