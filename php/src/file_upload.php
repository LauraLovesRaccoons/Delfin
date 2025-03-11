<?php

// ob_start();

require "functions.php";

session_checker_delfin();


if (isset($_POST['submit_button'])) {
  if(!isset($_FILES['fileToUplad'])){
    echo "<strong>Keen Fichier ausgewielt</strong><br />";
    // needs to come before the next line to handle custom empty file msg
  }
  elseif($_FILES['fileToUpload']['error'] !== UPLOAD_ERR_OK){
    echo "<strong>Fichier ass iwwert 20MB</strong><br />";
    // this doesn't work though ; future -> custom error msg
  }
  elseif (!empty($_FILES['fileToUpload']['name'])) {
    $file = $_FILES['fileToUpload'];
    file_upload_delfin($file);
    // next part
    // header('Location: send_mail.php');
    // exit();
  } 
  // else {
  //   echo "<strong>Keen Fichier ausgewielt</strong><br />";
  // }
}




require 'header.html';

?>


<br />
<form method="POST" enctype="multipart/form-data">

  <em>Select pdf file to upload:</em><br />
  <label for="file"></label>
  <input type="file" name="fileToUpload" id="fileToUpload">
  <br />
  <label for="submit"></label>
  <input type="submit" value="Upload File" name="submit_button" id="">
</form>
<br />


<?php require 'footer.html'; ?>



<?php
// delete_uploads_dir_delfin();
?>


