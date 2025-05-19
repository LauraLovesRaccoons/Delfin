<?php

// ob_start();

require "functions.php";

// require "ajax.php";

session_checker_delfin();


$selectedList = "ENTIRE DATABASE";



$db = db_connect_delfin();

$queryResult = query_grab_user_list_delfin($selectedList, $db);


require 'header.html';

// 
?>



<!-- toggle button -->
<button class="editButton" id="editButton">Enable Editing</button>
<button class="editButtonAlpha">Live Editing Enabled</button>
<!-- yes a different div -->
<div class="table-wrapper">
    <div class="entire-db-table-wrapper">
        <table>
            <caption>
                Edit Users in the <?php echo $selectedList ?> <!-- this dynamically adjusts the name -->
            </caption>
            <thead>
                <tr>
                    <th class="delete">DELETE</th>
                    <th>id</th>
                    <?php
                    foreach ($docXFields as $field) {
                        echo "<th>{$field}</th>";
                    }
                    ?>
                    <th>E-Mail</th>
                    <th>letter required</th>
                    <th>*duplicate user*</th>
                    <th class="spacer"></th>
                    <!-- Dynamically add names for the lists -->
                    <?php $approvedLists = approved_lists_delfin(); ?> <!-- calls the function with the list names --> <!-- also used later -->
                    <?php foreach ($approvedLists as $list): ?>
                        <th><?= htmlspecialchars(str_replace('_', ' ', ucfirst($list))) ?></th> <!-- replaces the _ with a space abd capitalises the first Letter -->
                    <?php endforeach; ?>
                    <th class="spacer"></th>
                    <th>id</th>
                </tr>
            </thead>

            <!--  -->
            <tr class="addUserRow">
                <form class="addUserForm" method="post" id="addUserForm">

                    <td class="spacer" colspan="1"></td>

                    <td data-cell="add-user" class="add-user">
                        <button type="button" id="submitAddUser" class="submitAddUser" title="Add user">✅</button>
                    </td>

                    <?php foreach ($allowedColumnsText as $col): ?>
                        <td data-cell="<?= $col ?>" class="table_text_add-form">
                            <input type="text" name="<?= $col ?>" />
                        </td>
                    <?php endforeach; ?>

                    <?php foreach ($allowedColumnsTinyint as $col): ?>
                        <td data-cell="<?= $col ?>" class="table_tinyint_add-form">
                            <input type="checkbox" name="<?= $col ?>" value="1" /> <!-- value is one if checked! -->
                        </td>
                    <?php endforeach; ?>

                    <td data-cell="spacer" class="spacer"></td>

                    <?php foreach ($approvedLists as $list): ?>
                        <td data-cell="<?= $list ?>" class="table_tinyint_add-form">
                            <input type="checkbox" name="<?= $list ?>" value="1" /> <!-- value is one if checked! -->
                        </td>
                    <?php endforeach; ?>

                    <td class="spacer"></td>
                    <td data-cell="add" class="add-user">
                        <button type="button" id="submitAddUser_Omega" class="submitAddUser" title="Add user">✅</button>
                    </td>
                </form>
            </tr>


            <!--  -->

            <!-- !data-cell should have the RAW column name from the database! -->

            <!-- <tbody>
            <tr>
                <td data-cell="delete" class="delete">X</td>
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
                <td data-cell="spacer"></td>
            </tr>
        </tbody> -->
            <tbody>
                <?php while ($row = $queryResult->fetch_assoc()): ?>
                    <tr class="<?= $row['duplicate'] ? 'duplicateUser' : '' ?>">
                        <td data-cell="delete" class="delete"><span class="delete-symbol">🪓</span></td> <!-- span is used to limit the selection to just the symbol -->
                        <td data-cell="id" class="table_id"><span><?= htmlspecialchars($row['id']) ?></span></td>
                        <td data-cell="allocation" class="table_text"><span><?= htmlspecialchars($row['allocation']) ?></span></td>
                        <td data-cell="nom" class="table_text"><span><?= htmlspecialchars($row['nom']) ?></span></td>
                        <td data-cell="nom2" class="table_text"><span><?= htmlspecialchars($row['nom2']) ?></span></td>
                        <td data-cell="fonction" class="table_text"><span><?= htmlspecialchars($row['fonction']) ?></span></td>
                        <td data-cell="adresse1" class="table_text"><span><?= htmlspecialchars($row['adresse1']) ?></span></td>
                        <td data-cell="adresse2" class="table_text"><span><?= htmlspecialchars($row['adresse2']) ?></span></td>
                        <td data-cell="allocationSpeciale" class="table_text"><span><?= htmlspecialchars($row['allocationSpeciale']) ?></span></td>
                        <td data-cell="nomCouponReponse" class="table_text"><span><?= htmlspecialchars($row['nomCouponReponse']) ?></span></td>
                        <td data-cell="email" class="table_text"><span><?= htmlspecialchars($row['email']) ?></span></td>
                        <td data-cell="letter_required" class="table_tinyint"><span><?= $row['letter_required'] == 1 ? '✅' : '​' ?></span></td>
                        <td data-cell="duplicate" class="table_tinyint"><span><?= $row['duplicate'] == 1 ? '⚠' : '​' ?></span></td>
                        <td data-cell="spacer" class="spacer"></td>
                        <!-- Dynamically add fields for the lists -->
                        <?php foreach ($approvedLists as $list): ?>
                            <td data-cell="<?= htmlspecialchars($list) ?>" class="table_tinyint">
                                <span>
                                    <?= isset($row[$list]) && $row[$list] == 1 ? '✅' : '❌' ?>
                                </span>
                            </td>
                        <?php endforeach; ?>
                        <th class="spacer"></th>
                        <td data-cell="id" class="table_id"><span><?= htmlspecialchars($row['id']) ?></span></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <span class="padding-for-table-bottom-horizontal-scrollbar">​</span> <!-- adds a small space before the horizontal scrollbar -->
    </div>
</div>



<!--  -->

<script>
    // // // kick script
    // // const selectedList =  echo json_encode($selectedList); ; // i need to clean this a bit
    // edit text script
    const textColumns = <?php echo json_encode($allowedColumnsText); ?>; // loads the array from the php global var as json
    // edit tinyint
    const tinyintColumns = <?php echo json_encode($allowedColumnsTinyint); ?>; // loads the array from the php global var as json
    const approvedListsColumns = <?php echo json_encode($approvedLists); ?>; // loads the array from the php global var as json
    // delete script
    // const selectedList = ; // i need to clean this a bit
</script>

<script src="scripts/enable_editing.js"></script>
<!--  -->
<script src="scripts/add_user.js"></script> <!-- No edit button needed -->
<!--  -->



<?php require 'footer.html'; ?>