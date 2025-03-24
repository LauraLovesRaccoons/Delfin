<?php

// ob_start();

require "functions.php";

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
            Edit Users Only in <?php echo $selectedList ?>  <!-- this dynamically adjusts the name -->
        </caption>
        <thead>
            <tr>
                <th class="kick">KICK</th>
                <th>id</th>
                <th>«Allocation»</th>
                <th>«Nom»</th>
                <th>«Nom2»</th>
                <th>«Fonction»</th>
                <th>«Adresse1»</th>
                <th>«Adresse2»</th>
                <th>«Allocation_Spéciale»</th>
                <th>«Nom_coupon-réponse»</th>
                <th>E-Mail</th>
                <th>letter required</th>
                <th>fonction multiple</th>
                <!-- <th class="spacer"></th> -->
            </tr>
        </thead>
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
                    <td data-cell="kick" class="kick">🦶</td>
                    <td data-cell="id"><?= htmlspecialchars($row['id']) ?></td>
                    <td data-cell="allocation"><?= htmlspecialchars($row['allocation']) ?></td>
                    <td data-cell="nom"><?= htmlspecialchars($row['nom']) ?></td>
                    <td data-cell="nom2"><?= htmlspecialchars($row['nom2']) ?></td>
                    <td data-cell="fonction"><?= htmlspecialchars($row['fonction']) ?></td>
                    <td data-cell="adresse1"><?= htmlspecialchars($row['adresse1']) ?></td>
                    <td data-cell="adresse2"><?= htmlspecialchars($row['adresse2']) ?></td>
                    <td data-cell="allocationSpeciale"><?= htmlspecialchars($row['allocationSpeciale']) ?></td>
                    <td data-cell="nomCouponReponse"><?= htmlspecialchars($row['nomCouponReponse']) ?></td>
                    <td data-cell="email"><?= htmlspecialchars($row['email']) ?></td>
                    <td data-cell="letter_required"><?= $row['letter_required'] ? '✅' : '❌' ?></td>
                    <td data-cell="duplicate"><?= $row['duplicate'] ? '⚠' : '' ?></td>
                    <!-- <td data-cell="spacer" class="spacer"></td> -->
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>



<!--  -->

<?php
require "footer.html";
?>

<!--  -->