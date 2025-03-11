<?php

require "functions.php";

session_checker_delfin();


// $target_dir = $GLOBALS['uploadPath'];   // this is a global var

// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// $uploadOk = 1;

if (isset($_POST['submit_button'])) {
  pdf_upload_delfin($file);
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
  <input type="submit" value="Upload Image" name="submit_button" id="">
</form>
<br />


<?php require 'footer.html'; ?>


