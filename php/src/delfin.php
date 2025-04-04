<?php

require "functions.php";


// this must come before the other one
session_checker_delfin();

// unsets every session variable apart from those related to login or essentials
// id, email, username
// in order
cleanup_session_vars_delfin();


// 
$approvedSelectedList = approved_lists_delfin();    // yes it's a function
// 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["importCsv"])) {       // checks if the importCsv button was pressed
        header("location: import_csv.php"); // FUTURE EXPANSION
        exit;                               // uncomment this as well
    }
    if (isset($_POST["editEntireDb"])) {        // checks if the editEntireDb button was pressed
        header("location: edit_entire_db.php");
        exit;
    }
    if (isset($_POST["log"])) {         // if someone wants to open their personal log
        $logUrlId = $logBasePath . $_SESSION['id'] . '/' . $logFile;    // these are globals
        echo "<script>window.open('$logUrlId', '_blank');</script>";    // javascript
        // exit;    // no exit allowed
    }

    if (isset($_POST["selectedList"])) {        // checks if someone wishes to send a mailing list
        $selectedList = $_POST["selectedList"];
        // checking if someone wants to send an example file
        if ($selectedList === "test") {
            // header("location: test_dummy_user_array.php");  // it still has its debugging name :barry:
            // exit;
            if (isset($_SESSION['targetUsersArray'])) {
                unset($_SESSION['targetUsersArray']);   // just to be sure, even if cleanup_session_vars_delfin already ran
            };
            dummyAccounts_delfin();
            header("location: file_upload.php");    // redirect
            exit;
        }

        // if someone inspect element on the hidden value field, we're gonna have a bad time
        if (!in_array($selectedList, $approvedSelectedList)) {
            header("location: delfin.php"); // redirect
            exit;
        }

        // redirects to the edit_list.php page
        if (isset($_POST["editList"])) {
            header("location: edit_list.php?selectedList=" . urlencode($selectedList));     // urlencode might make the most sense here
            exit;   // if there is no exit, it will proceed with the remainder of the code
        }

        // $selectedList = "list_A";   // this is usefull

        $db = db_connect_delfin();

        // $query = "SELECT id, allocation, nom, nom2, fonction, adresse1, adresse2, allocationSpeciale, email, nomCouponReponse, letter_required FROM Users WHERE $selectedList = ?";
        $queryResult = query_grab_user_list($selectedList, $db);    // $queryResult is self explanatory

        // 
        $grabbedUsers = turn_fetched_users_into_array_delfin($queryResult);     // the return from the function NEEDS to be saved into a variable
        // 
        if (isset($_SESSION['targetUsersArray'])) {
            unset($_SESSION['targetUsersArray']);   // just to be sure, even if cleanup_session_vars_delfin already ran
        }
        // 
        $_SESSION['targetUsersArray'] = $grabbedUsers;  // grabbedUsers was returned
        $_SESSION['selectedList'] = $selectedList;      //? added this so I can display it on the file upload page
        header("location: file_upload.php");    // redirect
        exit;   // this is needed
    }
}


?>


<?php require 'header.html'; ?>

<div class="general-wrapper">

    <h1 class="landing-page-h1">Choose your action</h1>



    <!-- <br /> -->

    <div class="selectListsForm">

        <div class="side-by-side-form">

            <div class="left-side-form">
                <form method="POST">
                    <label for="submit"></label>
                    <input type="hidden" name="selectedList" value="list_A"> <!-- ensure the value is always transmited -->
                    <button type="submit" class="list-button">Select List A</button>
                    <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
                </form>

                <form method="POST">
                    <label for="submit"></label>
                    <input type="hidden" name="selectedList" value="list_B">
                    <button type="submit" class="list-button">Select List B</button>
                    <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
                </form>

                <form method="POST">
                    <label for="submit"></label>
                    <input type="hidden" name="selectedList" value="list_C">
                    <button type="submit" class="list-button">Select List C</button>
                    <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
                </form>
            </div>

            <div class="left-middle-side-form">
                <form method="POST">
                    <label for="submit"></label>
                    <input type="hidden" name="selectedList" value="list_D">
                    <button type="submit" class="list-button">Select List D</button>
                    <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
                </form>

                <form method="POST">
                    <label for="submit"></label>
                    <input type="hidden" name="selectedList" value="list_E">
                    <button type="submit" class="list-button">Select List E</button>
                    <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
                </form>

                <form method="POST">
                    <label for="submit"></label>
                    <input type="hidden" name="selectedList" value="list_F">
                    <button type="submit" class="list-button">Select List F</button>
                    <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
                </form>
            </div>

            <div class="right-middle-side-form">
                <form method="POST">
                    <label for="submit"></label>
                    <input type="hidden" name="selectedList" value="nouvel_an">
                    <button type="submit" class="list-button">Nouvel An</button>
                    <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
                </form>

                <form method="POST">
                    <label for="submit"></label>
                    <input type="hidden" name="selectedList" value="fete_nationale">
                    <button type="submit" class="list-button">Fête nationale</button>
                    <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
                </form>

                <form method="POST">
                    <label for="submit"></label>
                    <input type="hidden" name="selectedList" value="tennis">
                    <button type="submit" class="list-button">Tennis</button>
                    <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
                </form>
            </div>

            <div class="right-side-form">
                <form method="POST">
                    <label for="submit"></label>
                    <input type="hidden" name="selectedList" value="temp">
                    <button type="submit" class="list-button">List temp</button>
                    <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
                </form>

                <!-- <form method="POST">
                    <label for="submit"></label>
                    <input type="hidden" name="selectedList" value="temp">
                    <button type="submit" class="list-button">List temp</button>
                    <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
                </form>

                <form method="POST">
                    <label for="submit"></label>
                    <input type="hidden" name="selectedList" value="temp">
                    <button type="submit" class="list-button">List temp</button>
                    <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
                </form> -->
            </div>

        </div> <!-- don't comment this one !!! -->


        <!-- <form method="POST">
        <label for="submit"></label>
        <input type="hidden" name="selectedList" value="HACKER">
        <button type="submit" class="list-button">HACKER</button>
        <button type="submit" name="editList" class="edit-button" value="1">Edit</button>
    </form> -->
        <!-- <br /> -->

        <div class="rest-of-the-form">
            <form method="POST">
                <label for="edit-entire-db"></label>
                <input type="hidden" name="editEntireDb" value="1">
                <button type="submit" class="edit-entire-db-button">Edit the entire database</button>
            </form>
            <!-- <br /> -->
            <form method="POST">
                <label for="submit"></label>
                <input type="hidden" name="selectedList" value="test">
                <button type="submit" class="list-button" id="button-yourself">Test document <br />(on yourself)</button>
            </form>
            <!-- <br /> -->
            <form method="POST">
                <label for="your-log"></label>
                <input type="hidden" name="log" value="log">
                <button type="submit" class="list-button" id="your-log">Check out your log 🪵 </button>
            </form>
            <!-- <br />
            <hr />
            <br /> -->
            <form method="POST">

                <label for="import-csv-db"></label>
                <input type="hidden" name="importCsv" value="1">
                <button type="submit" class="import-csv-button">Import .csv file as a mailing list</button>
                <p>
                    <em>Future expansion</em>
                </p>
            </form>
        </div>
    </div>


    <!-- <br /> -->
    <!-- <br /> -->


    <!-- opens your personal logging file in a new tab -->
    <!-- <a href="<?= $logBasePath . $_SESSION['id'] . '/' . $logFile ?>" target="_blank">Check out your log 🪵 </a><br /> -->

</div>

<?php require 'footer.html'; ?>