<?php

ob_start();

require "functions.php";

session_checker_delfin();


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



<?php 
include 'footer.html';
 ?>



<?php
// delete_uploads_dir_delfin();
?>


