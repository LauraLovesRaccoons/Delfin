<!-- Import a file -> stop the script if problem return an error -->
<?php require 'header.html';?>
<!--  Import a file -> warning of issue, script continues to run -->




<!-- Import a file -> stop the script if problem return an error -->
<?php require 'footer.html';?>
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

<!-- THIS SHOULD LOAD FROM THE ENV AT A LATER POINT -->

<h1>This doesn't load from the .env file YET!</h1>

<?php
// Database connection parameters
// this is only for xampp apache!
// $dbIpAndPort = "localhost:3306";
// // $dbIpAndPort = "localhost:3308";
$serviceMysql = "mysql";                      // from compose.yaml !
$username = "delphinus";
$password = "Inia_geoffrensis";
// $username = "-delphinus";
// $password = "-Inia_geoffrensis";
// $username = "root";
// $password = "root";
$dbname = "delfin_db";
// $dbname = "FAKE_NAME";

// Create connection
$db = mysqli_connect($serviceMysql, $username, $password, $dbname);

if($db){
    echo "Connection works!";
    $query = "SELECT * FROM Books";

    $results = mysqli_query($db, $query);

    $books = mysqli_fetch_all($results, MYSQLI_ASSOC);

    mysqli_close($db);
}else{
    echo "Problem connection to the DB <br>";
}

?>


<!--  -->
<br /><br /><br /><br />
<a href="https://www.youtube.com/watch?v=L5E2HSHrDjw&t=302s">tutorial video</a>
<br /><br /><br /><br />
<p>.env reading</p>

<?php
var_dump(getenv('APP_NAME'));
echo 'This application is called ' .$_ENV["APP_NAME"] . '!';
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






