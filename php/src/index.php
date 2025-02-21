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



<!--  -->

