<?php

// $db= false;     // setup

function logout()
{
    session_start();
    session_destroy();
    // header('Location: index.php');
    // exit();
}

function db_connect()
{
    $serviceMysql = "mysql";                      // from compose.yaml !
    $username = "delphinus";
    $password = "Inia_geoffrensis";
    $dbname = "delfin_db";
    // Create connection to DB
    mysqli_report(MYSQLI_REPORT_OFF);           // this allows the upcoming @ to supress warnings from the user
    $db = @mysqli_connect($serviceMysql, $username, $password, $dbname);    // @ means surpress error message
    if (!$db) {
        //     // // error_log(mysqli_connect_error());
        echo "Datenbank huet een Problem <br>";
    } elseif ($db) {
        echo "Datenbank ass aktiv <br>";
    } else {
        echo "Een Dëcken Hardware Problem mam Server <br>";
    }
    return $db; // this gives me the cannot modify header information warning
}

function db_close($db)
{
    if ($db) {
        mysqli_close($db);  // closes the database connection
        // echo "Closed the Database Connection";
    }
    // else{
    //     echo "There was NO Database Connection";
    // }
}
