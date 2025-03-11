<?php

require "functions.php";

session_checker_delfin();


// $target_dir = $GLOBALS['uploadPath'];   // this is a global var

// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// $uploadOk = 1;


pdf_upload_delfin($file);




require 'header.html';

?>


<form action="upload.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>



<?php require 'footer.html'; ?>



