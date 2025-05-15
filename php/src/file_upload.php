<?php

// handling the 20MB upload limit
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    empty($_POST) &&
    empty($_FILES) &&
    isset($_SERVER['CONTENT_LENGTH']) &&
    (int)$_SERVER['CONTENT_LENGTH'] > 20000000  // this is a bit under 20MB
) {
    header("Location: logout.php");
    exit;
}

ob_start();   //? yeah i need this ... 

require "functions.php";

session_checker_delfin();

if (isset($_SESSION['targetUsersArray'])) {
  $targetUsersArray = $_SESSION['targetUsersArray'];
} else {
  header("Location: delfin.php");
  exit();
}

if (isset($_SESSION['selectedList'])) {
  $selectedList = $_SESSION['selectedList'];
  // unset($_SESSION['selectedList']);    // this doesn't work on a refresh
} else {
  header("Location delfin.php");
  exit;
}

require 'header.html';

echo '<div class="general-wrapper">';
echo '<div class="file_upload-wrapper">';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['enable_letter_mode'])) {
    $_SESSION['letter_required'] = true;    // this is the easiest option to add this feature
  } elseif (isset($_POST['disable_letter_mode'])) {
    unset($_SESSION['letter_required']);
  }
}


// var_dump($selectedList);



// 
email_or_letter_mode_delfin();  // this shows the current mode
// 



if (isset($_POST['submit_button'])) {
  // store entered text or set default one from the env file  // overkill since the default env message is also set on the next page
  $emailSubject = isset($_POST['email_subject']) && $_POST['email_subject'] !== '' ? $_POST['email_subject'] : getenv('DEFAULT_EMAIL_SUBJECT');
  $_SESSION['emailSubject'] = $emailSubject;
  $emailBody = isset($_POST['email_body']) && $_POST['email_body'] !== '' ? $_POST['email_body'] : getenv('DEFAULT_EMAIL_BODY');
  $_SESSION['emailBody'] = $emailBody;
  upload_docX_delfin();
  // the animation is handled much letter   // much letter ftw 
}



?>


<article class="upload-file-form-wrapper"> <!-- article makes sense - easier css styling -->

  <?php
  if (isset($_SESSION['letter_required'])) {
    echo "<h3>Upload File and Create Letters: &nbsp; $selectedList</h3>";
  } else {
    echo "<h3>Upload File and Send Emails: &nbsp; $selectedList</h3>";
  }
  // echo "<h4> $selectedList </h4>";
  ?>
  <!-- <br /> -->
  <form id="heavyFormSubmission" action="" method="POST" enctype="multipart/form-data"> <!-- id is needed for the animation part -->
    <?php if (!isset($_SESSION['letter_required'])): ?>
      <em>Personalize Email?</em><br />
      <!-- <em>Limitt: 500 & 2000 Zeechen</em><br /> -->
      <!-- maxlength="" removed -->

      <label for="email_subject"></label>
      <strong>Email Subject: </strong><input type="text" name="email_subject" id="email_subject" class="email_subject" placeholder=" Default: <?= getenv('DEFAULT_EMAIL_SUBJECT') ?> " value="<?= $_POST['email_subject'] ?? getenv('DEFAULT_EMAIL_SUBJECT') ?>"> <!-- . -->
      <br />
      <strong>Email Message: </strong><label for="email_body"></label>
      <input type="text" name="email_body" id="email_body" class="email_body" placeholder=" Default: <?= getenv('DEFAULT_EMAIL_BODY') ?> " value="<?= $_POST['email_body'] ?? getenv('DEFAULT_EMAIL_BODY') ?>">
      <br /><br />
    <?php endif; ?>
    <em>Select Invitation (.docx):</em><br />
    <label for="file"></label>
    <input type="file" name="fileToUpload" id="fileToUpload" required>
    <br /><br />
    <!-- start expansion V1.2.0-->
    <?php if (!isset($_SESSION['letter_required'])): ?>   <!-- attachements for letters are redundant -->
      <em>Select Attachement (*):</em><br />
      <label for="file"></label>
      <input type="file" name="secondAttachementUpload" id="secondAttachementUpload" optional>
      <!-- <br /><em>(optional)</em> -->
      <br />
      <br />
    <?php endif; ?>
    <!-- end expansion V1.2.0-->
    <label for="submit"></label>
    <?php if (isset($_SESSION['letter_required'])): ?>
      <!-- <input type="submit" value=" Upload File & Prepare Letters " name="submit_button" id=""> -->
      <input type="button" value=" Upload File & Prepare Letters " name="submit_button" id="sendMailOrLetterButton">
    <?php else: ?>
      <!-- <input type="submit" value=" Upload File & Send Emails " name="submit_button" id=""> -->
      <input type="button" value=" Upload File & Send Emails " name="submit_button" id="sendMailOrLetterButton">
    <?php endif; ?>
    <br />
  </form>
  <!-- <br /> -->
  <div>
    <strong>This might take a while...</strong><br />
    <em>Keep it below 20MB (combined) or else!</em><br />
  </div>
  <br />
  <?php
  if (isset($_SESSION['letter_required'])) {
    echo '<span id="loadingScreen">Preparing Letters... &nbsp; <div id="loadingScreenAnimation"></div></span>';
  } else {
    echo '<span id="loadingScreen">Sending Emails... &nbsp; <div id="loadingScreenAnimation"></div></span>';
  }
  ?>

</article> <!-- closes the article and css styling -->


<!-- mode switcher is now handled in the php function -->

</div>
</div>


<!-- loading animation -->
<!-- yes this can't be in the footer somehow -->  <!-- it might be because of the dom content loaded -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const loadingScreen = document.getElementById("loadingScreen");
    loadingScreen.style.display = "none"; // start as hidden

    document.getElementById("heavyFormSubmission").addEventListener("submit", function() {
      loadingScreen.style.display = "flex"; // makes it visible
    });
    
    // requires the send mail or letter button to be a double press
    // also now the php always has to handle the message for no file selected ; no front end help for end users ;(
    document.querySelectorAll('input[name="submit_button"]').forEach(button => {
      console.log("query selector active");
      button.ondblclick = () => {
        console.log("double click event now processes");
        // I force the loading screen to show up asap when the buttton is double clicked
        loadingScreen.style.display = "flex"; // makes it visible
        // since this bypasses the default html form submission, the old way may no longer work (still keeping it though)
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = button.name;
        hidden.value = button.value;
        button.form.appendChild(hidden);
        button.form.submit();
      };
    });

  });
</script>


<?php require 'footer.html'; ?>
