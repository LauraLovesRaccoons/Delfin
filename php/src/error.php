<?php

require "functions.php";


// this must come before the other one
session_checker_delfin();

cleanup_session_vars_delfin();  // this is probably a good idea if someone uses the back button

?>


<?php require 'header.php'; ?>

<div class="general-wrapper">
    <br />
    <h1 class="landing-page-h1">Something went wrong :(<br />Due to security reasons I can't tell you why.</h1>
    <h2 class="landing-page-h1"><a class="above20MB" href="delfin.php">Go Back to the Main Page</a></h2>
    <br /><h3 class="landing-page-h1">:(</h3>
</div>
<?php require 'footer.php'; ?>