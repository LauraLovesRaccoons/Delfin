<!-- Import a file -> stop the script if problem return an error -->
<?php require 'header.html'; ?>
<!--  Import a file -> warning of issue, script continues to run -->




<!-- Import a file -> stop the script if problem return an error -->
<?php require 'footer.html'; ?>
<!--  Import a file -> warning of issue, script continues to run -->



<!-- test -->
<br />
<br /><br /><br />
<br />
<p>hello</p>
<br />
<h1>
    TEST Divison
</h1>

<br />
<br /><br /><br />
<br />

<!--  -->


<?php require 'db_connect.php'; ?>


<!--  -->
<br /><br /><br /><br />
<a href="https://www.youtube.com/watch?v=L5E2HSHrDjw&t=302s">tutorial video</a>
<br /><br /><br /><br />
<p>.env reading</p>

<?php
var_dump(getenv('APP_NAME'));
echo 'This application is called ' . $_ENV["APP_NAME"] . '!';
?>
<br />
<br />

<!--  -->


<!--  -->
<br /><br /><br /><br />
<p>hash test</p>
<?php
echo hash('sha256', 'The quick brown fox jumped over the lazy dog.');
?>
<p>hash test end</p>
<br /><br /><br /><br />
<!--  -->


