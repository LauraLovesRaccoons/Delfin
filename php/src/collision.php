<?php

require "functions.php";


// this must come before the other one
session_checker_delfin();

cleanup_session_vars_delfin();  // this is probably a good idea if someone uses the back button

?>


<?php require 'header.php'; ?>

<div class="general-wrapper">
    <br />
    <h1 class="landing-page-h1">You are currently logged in somewhere else and you did just submit a job and for safety reasons this file upload has been canceled.<br />The other job is already running and can't be stopped.</h1>
    <h2 class="landing-page-h1"><a class="above20MB" href="delfin.php">Go Back to the Main Page</a></h2>
</div>
<?php require 'footer.php'; ?>