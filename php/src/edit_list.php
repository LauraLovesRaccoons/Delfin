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
    const selectedList = "<?php echo $selectedList; ?>"; // i need to clean this a bit
    // 
    // this adds the kick properly the class .kick symbol (span)
    document.querySelectorAll('.kick-symbol').forEach(button => {
        button.addEventListener('dblclick', function() { // double click for ease of use
            let userId = this.closest('tr').querySelector('[data-cell="id"]').textContent;
            let columnName = selectedList;

            // creates a post request
            fetch('ajax/list_kick_user.php', { // that's why ajax.php has been excluded from require at the top of the php
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
                    let kickedMessage = document.createElement('span'); // span is the best option since i display text
                    kickedMessage.textContent = `User with id: ${userId} kicked`; // this requires these ` for js vars

                    kickedMessage.classList.add('kickedMessage'); // adds a class for styling

                    // append the span to my wrapper
                    let tableWrapper = document.querySelector('.table-wrapper');
                    tableWrapper.appendChild(kickedMessage);

                    // Remove the success message after 5(000 milli)seconds -> after fade out effect
                    setTimeout(() => {
                        kickedMessage.classList.add('fade-out');
                        setTimeout(() => kickedMessage.remove(), 1250); // 1.25 is fade out in my scss code
                    }, 5000);
                })
        });
    });

    // edit text script
    const allowedColumns = <?php echo json_encode($allowedColumnsText); ?>; // loads the array from the php global var as json
    const selector = allowedColumns.map(col => `td[data-cell="${col}"]`).join(', '); // this passes the allowed data-cells into an array
    // adds these to the selector
    document.querySelectorAll(selector).forEach(td => { // this doesn't need updating if new columns are added
        td.addEventListener('dblclick', function() {
            let originalText = this.textContent.trim();
            let userId = this.closest('tr').querySelector('[data-cell="id"]').textContent;
            let columnName = this.getAttribute('data-cell');

            // Create input field
            let input = document.createElement('input');
            input.type = 'text';
            input.value = originalText;
            input.classList.add('edit-input');

            // Clear TD and insert input
            this.innerHTML = '';
            this.appendChild(input);
            input.focus();

            // Save changes on blur or Enter key press
            function save() {
                let newValue = input.value.trim(); // this allows an empty string to be valid

                fetch('ajax/update_text.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${userId}&column=${columnName}&value=${encodeURIComponent(newValue)}`
                }).then(() => {
                    updateCell(newValue);
                }).catch(() => {
                    updateCell(originalText);
                });
            }

            function updateCell(text) {
                td.innerHTML = `<span>${text || ''}</span>`; // just adding an empty string, for screen readers perhaps
            }

            function cancelEdit() {
                updateCell(originalText);
            }

            input.addEventListener('blur', save);
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') save();
                if (e.key === 'Escape') cancelEdit();
            });
        });
    });

    // edit tinyint
    const tinyintColumns = <?php echo json_encode($allowedColumnsTinyint); ?>; // loads the array from the php global var as json
    const tinyintSelector = tinyintColumns.map(col => `td[data-cell="${col}"]`).join(', '); // this passes the allowed data-cells into an array
    // adds these to the selector
    document.querySelectorAll(tinyintSelector).forEach(td => {
        td.addEventListener('dblclick', function() {
            // yes I copied over originalText from the previous function
            let originalText = this.textContent.trim();
            let userId = this.closest('tr').querySelector('[data-cell="id"]').textContent;
            let columnName = this.getAttribute('data-cell');

            // Determine new value based on current value
            let newValue = originalText === '⚠' || originalText === '✅' ? '0' : '1';  // toggle
            let newSymbol;
            // Toggle the symbols based on column name
            if (columnName === 'letter_required') {
                newSymbol = newValue === '1' ? '✅' : '​';
            } else if (columnName === 'duplicate') {
                newSymbol = newValue === '1' ? '⚠' : '​';
            }

            // ajax update tinyint
            fetch('ajax/update_tinyint.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${userId}&column=${columnName}&value=${encodeURIComponent(newValue)}`
            }).then(() => {
                updateCell(newSymbol);
                handleRowClass(columnName, newValue);   // the class to style the entire row if we have a user with the duplicate flag set
            }).catch(() => {
                updateCell(originalText);
            });

            // Update the cell with the new symbol
            function updateCell(symbol) {
                td.innerHTML = `<span>${symbol}</span>`;    // actually updates the symbol
            }

            // Handle adding/removing the 'duplicateUser' class based on the duplicate column value
            function handleRowClass(columnName, newValue) {
                let row = td.closest('tr'); // Get the closest row for this cell

                // Only apply/remove class for the 'duplicate' column
                if (columnName === 'duplicate') {
                    if (newValue === '1') {
                        row.classList.add('duplicateUser');     // adds the class if true
                    } else {
                        row.classList.remove('duplicateUser');  // everything else is treated like 0
                    }
                }
            }
        });
    });
    
</script>

<?php
require "footer.html";
?>

<!--  -->