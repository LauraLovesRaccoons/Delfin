<?php

// ob_start();

require "functions.php";

// require "ajax.php";

session_checker_delfin();

// // wipes it, if it exists already
// if (isset($_SESSION['targetUsersArray'])) {
//     unset($_SESSION['targetUsersArray']);
// }


// $approvedSelectedList = approved_lists_delfin();    // yes it's a function

$selectedList = list_url_decode_delfin();

// $selectedList = "list_A";   // this is usefull

// var_dump($selectedList);


$db = db_connect_delfin();

$queryResult = query_grab_user_list($selectedList, $db);


require 'header.html';

// 
?>

<div class="table-wrapper">
    <table>
        <caption>
            Edit Users Only in <?php echo $selectedList ?> <!-- this dynamically adjusts the name -->
        </caption>
        <thead>
            <tr>
                <th class="kick">KICK</th>
                <th>id</th>
                <?php
                foreach ($docXFields as $field) {
                    echo "<th>{$field}</th>";
                }
                ?>
                <th>E-Mail</th>
                <th>letter required</th>
                <th>*duplicate user*</th>
                <!-- <th class="spacer"></th> -->
            </tr>
        </thead>

        <!-- !data-cell should have the RAW column name from the database! -->

        <!-- <tbody>
            <tr>
                <td data-cell="kick" class="kick">X</td>
                <td data-cell="id">id</td>
                <td data-cell="allocation">sss</td>
                <td data-cell="nom"></td>
                <td data-cell="nom2"></td>
                <td data-cell="fonction"></td>
                <td data-cell="adresse1"></td>
                <td data-cell="adresse2"></td>
                <td data-cell="allocationSpeciale"></td>
                <td data-cell="nomCouponReponse"></td>
                <td data-cell="email"></td>
                <td data-cell="letter_required"></td>
                <td data-cell="duplicate"></td>
            </tr>
        </tbody> -->
        <tbody>
            <?php while ($row = $queryResult->fetch_assoc()): ?>
                <tr class="<?= $row['duplicate'] ? 'duplicateUser' : '' ?>">
                    <td data-cell="kick" class="kick"><span class="kick-symbol">🦶</span></td> <!-- span is used to limit the selection to just the symbol -->
                    <td data-cell="id"><span><?= htmlspecialchars($row['id']) ?></span></td>
                    <td data-cell="allocation"><span><?= htmlspecialchars($row['allocation']) ?></span></td>
                    <td data-cell="nom"><span><?= htmlspecialchars($row['nom']) ?></span></td>
                    <td data-cell="nom2"><span><?= htmlspecialchars($row['nom2']) ?></span></td>
                    <td data-cell="fonction"><span><?= htmlspecialchars($row['fonction']) ?></span></td>
                    <td data-cell="adresse1"><span><?= htmlspecialchars($row['adresse1']) ?></span></td>
                    <td data-cell="adresse2"><span><?= htmlspecialchars($row['adresse2']) ?></span></td>
                    <td data-cell="allocationSpeciale"><span><?= htmlspecialchars($row['allocationSpeciale']) ?></span></td>
                    <td data-cell="nomCouponReponse"><span><?= htmlspecialchars($row['nomCouponReponse']) ?></span></td>
                    <td data-cell="email"><span><?= htmlspecialchars($row['email']) ?></span></td>
                    <td data-cell="letter_required"><span><?= $row['letter_required'] == 1 ? '✅' : '​' ?></span></td>
                    <td data-cell="duplicate"><span><?= $row['duplicate'] == 1 ? '⚠' : '​' ?></span></td>
                    <!-- <td data-cell="spacer" class="spacer"></td> -->
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>



<!--  -->

<script>
    // kick script
    const selectedList = <?php echo json_encode($selectedList); ?>; // i need to clean this a bit
</script>
<script src="scripts/edit_kick.js"></script>
<script>
    // edit text script
    const allowedColumns = <?php echo json_encode($allowedColumnsText); ?>; // loads the array from the php global var as json
</script>
<script src="scripts/edit_text.js"></script>
<script>
    // edit tinyint
    const tinyintColumns = <?php echo json_encode($allowedColumnsTinyint); ?>; // loads the array from the php global var as json
</script>
<script src="scripts/edit_tinyint.js"></script>
</script>

<?php
require "footer.html";
?>

<!--  -->