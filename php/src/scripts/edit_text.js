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