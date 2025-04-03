<?php

// ob_start();

require "functions.php";

// require "ajax.php";

session_checker_delfin();


// $selectedList = list_url_decode_delfin();



$db = db_connect_delfin();

// $queryResult = query_grab_user_list($selectedList, $db);


require 'header.html';

// 
?>



<!-- toggle button -->
<button class="editButton" id="editButton">Enable Editing</button>
<button class="editButtonAlpha">Live Editing Enabled</button>
<!-- yes a different div -->
<div class="table-wrapper">

</div>



<!--  -->

<script>
    // // // kick script
    // // const selectedList =  echo json_encode($selectedList); ; // i need to clean this a bit
    // edit text script
    const textColumns = <?php echo json_encode($allowedColumnsText); ?>; // loads the array from the php global var as json
    // edit tinyint
    const tinyintColumns = <?php echo json_encode($allowedColumnsTinyint); ?>; // loads the array from the php global var as json
    // delete script
    // const selectedList = ; // i need to clean this a bit
</script>

<script src="scripts/enable_editing.js"></script>
<!--  -->

<?php
require "footer.html";
?>

<!--  -->