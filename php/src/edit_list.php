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

<script>
    const selectedList = "<?php echo $selectedList; ?>"; // i need to clean this a bit

    // this adds the kick properly to the entire cell
    document.querySelectorAll('.kick-symbol').forEach(button => {
        button.addEventListener('click', function() {
            let userId = this.closest('tr').querySelector('[data-cell="id"]').textContent;
            let columnName = selectedList;

            // creates a post request
            fetch('ajax.php', {     // that's why ajax.php has been excluded from require at the top of the php
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${userId}&selectedList=${columnName}` // just hands over the id and db column name
                        // you can just inspect element on the id to target ANY user from the db, not even those on that list
                        // but if you are here you already have access to the entire db
                })
                .then(() => {
                    // just visual removal
                    // since tr encapsulates the table entry
                    this.closest('tr').remove();

                    // animation
                    let kickedMessage = document.createElement('span');             // span is the best option since i display text
                    kickedMessage.textContent = `User with id: ${userId} kicked`;   // this requires these ` for js vars

                    kickedMessage.classList.add('kickedMessage');   // adds a class for styling

                    // append the span to my wrapper
                    let tableWrapper = document.querySelector('.table-wrapper');
                    tableWrapper.appendChild(kickedMessage);

                    // Remove the success message after 5(000 milli)seconds -> after fade out effect
                    setTimeout(() => {
                        kickedMessage.classList.add('fade-out');
                        setTimeout(() => kickedMessage.remove(), 1250);     // 1.25 is fade out in my scss code
                    }, 5000);
                })
        });
    });
</script>

<?php
require "footer.html";
?>

<!--  -->

