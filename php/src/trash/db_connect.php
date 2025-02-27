


<?php

require 'functions.php';
db_connect();


// echo "<h1>This doesn't load from the .env file YET!</h1><br />";

// Database connection parameters
// this is only for xampp apache!
// $dbIpAndPort = "localhost:3306";
// // $dbIpAndPort = "localhost:3308";
// $serviceMysql = "mysql";                      // from compose.yaml !
// $username = "delphinus";
// $password = "Inia_geoffrensis";
// // $username = "-delphinus";
// // $password = "-Inia_geoffrensis";
// // $username = "root";
// // $password = "root";
// $dbname = "delfin_db";
// // $dbname = "FAKE_NAME";


// // Create connection to DB
// mysqli_report(MYSQLI_REPORT_OFF);           // this allows the upcoming @ to supress warnings from the user
// $db = @mysqli_connect($serviceMysql, $username, $password, $dbname);    // @ means surpress error message
// if (!$db) {
//     // // error_log(mysqli_connect_error());
//     echo "Datenbank huet een Problem <br>";
// } elseif ($db) {
//     echo "Datenbank ass aktiv <br>";
// } else {
//     echo "Een Dëcken Hardware Problem mam Server <br>";
// }


// // if ($db) {
//     echo "TEST <br>";
//     $query = "SELECT * FROM Books";

//     $results = mysqli_query($db, $query);

//     $books = mysqli_fetch_all($results, MYSQLI_ASSOC);

//     // mysqli_close($db);          // wichteg
//     require 'db_close.php';         // call close db connection

// }

?>

