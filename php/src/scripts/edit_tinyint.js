const tinyintSelector = tinyintColumns.map(col => `td[data-cell="${col}"]`).join(', '); // this passes the allowed data-cells into an array
const approvedListsSelector = approvedListsColumns.map(col => `td[data-cell="${col}"]`).join(', '); // this passes the allowed data-cells into an array
const combinedSelectorTinyInt = `${tinyintSelector}, ${approvedListsSelector}`
console.log()
// adds these to the selector
document.querySelectorAll(combinedSelectorTinyInt).forEach(td => {
    td.addEventListener('dblclick', function() {
        // yes I copied over originalText from the previous function
        let originalText = this.textContent.trim();
        let userId = this.closest('tr').querySelector('[data-cell="id"]').textContent;
        let columnName = this.getAttribute('data-cell');

        // Determine new value based on current value
        let newValue = originalText === '⚠' || originalText === '✅' ? '0' : '1'; // toggle
        let newSymbol;
        // Toggle the symbols based on column name
        if (columnName === 'letter_required') {
            newSymbol = newValue === '1' ? '✅' : '​';
        } else if (columnName === 'duplicate') {
            newSymbol = newValue === '1' ? '⚠' : '​';
        } else {
            // symbols for the list selection
            newSymbol = newValue === '1' ? '✅' : '❌';
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
            handleRowClass(columnName, newValue); // the class to style the entire row if we have a user with the duplicate flag set
        }).catch(() => {
            updateCell(originalText);
        });

        // Update the cell with the new symbol
        function updateCell(symbol) {
            td.innerHTML = `<span>${symbol}</span>`; // actually updates the symbol
        }

        // Handle adding/removing the 'duplicateUser' class based on the duplicate column value
        function handleRowClass(columnName, newValue) {
            let row = td.closest('tr'); // Get the closest row for this cell

            // Only apply/remove class for the 'duplicate' column
            if (columnName === 'duplicate') {
                if (newValue === '1') {
                    row.classList.add('duplicateUser'); // adds the class if true
                } else {
                    row.classList.remove('duplicateUser'); // everything else is treated like 0
                }
            }
        }
    });
});