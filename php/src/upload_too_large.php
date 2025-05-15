<?php

require "functions.php";


// this must come before the other one
session_checker_delfin();

?>


<?php require 'header.html'; ?>

<div class="general-wrapper">
    <br />
    <h1 class="landing-page-h1">Your (Total) Upload was above 20MB, emails can't process this!</h1>
    <h2 class="landing-page-h1"><a class="above20MB" href="delfin.php">Go Back to the Main Page</a></h2>
</div>
<?php require 'footer.html'; ?>