<?php

// $db= false;     // setup

session_name("delfin-session-cookie");

function logout_delfin()
{
    session_start();
    session_unset();
    session_destroy();
    // cookie removal on client
    setcookie("delfin-session-cookie", "", time() - 999999, "/");
    // since there is a session start there always is a cookie session present ; unless someone messes with the cookie or the browser blocks them
    header('Location: index.php');
    exit();
}

function db_connect_delfin()
{
    // $serviceMysql = "mysql";                      // from compose.yaml !
    // $username = "delphinus";
    // $password = "Inia_geoffrensis";
    // $dbname = "delfin_db";

    $serviceMysql = getenv('MYSQL_SERVICE_NAME');   // from compose.yaml !
    $username = getenv('MYSQL_USER');
    $password = getenv('MYSQL_PASSWORD');
    $dbname = getenv('MYSQL_DATABASE');

    // Create connection to DB
    mysqli_report(MYSQLI_REPORT_OFF);           // this allows the upcoming @ to supress warnings from the user
    $db = @mysqli_connect($serviceMysql, $username, $password, $dbname);    // @ means surpress error message
    if (!$db) {
        //     // // error_log(mysqli_connect_error());
        echo "Datenbank huet een Problem <br>";
        echo "<script>console.log('Datenbank huet een Problem');</script>";
    } elseif ($db) {
        echo "Datenbank ass aktiv <br>";
        echo "<script>console.log('Datenbank ass aktiv');</script>";
    } else {
        echo "Een Dëcken Hardware Problem mam Server <br>";
        echo "<script>console.log('Een Dëcken Hardware Problem mam Server');</script>";
    }
    return $db; // this gives me the cannot modify header information warning
}

function db_close_delfin($db)
{
    if ($db) {
        mysqli_close($db);  // closes the database connection
        // echo "Closed the Database Connection";
        echo "<script>console.log('Closed the Database Connection');</script>";
    } else {
        // echo "There was NO Database Connection";
        echo "<script>console.log('There was NO Database Connection');</script>";
    }
}

function session_checker_delfin()
{
    session_start();    // 
    if (isset($_POST['logout_button'])) {
        unset($_SESSION['username']);
        header("location: logout.php");
    }

    if (isset($_SESSION['username'])) {
        echo "Welcome: $_SESSION[username] <script>console.log('Welcome: $_SESSION[username]');</script>";
    } else {
        header("location: index.php");  // this requires a session from login
    }
}
