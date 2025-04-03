   // this adds the kick properly the class .kick symbol (span)
   document.querySelectorAll('.kick-symbol').forEach(button => {
    button.addEventListener('dblclick', function() { // double click for ease of use
        let userId = this.closest('tr').querySelector('[data-cell="id"]').textContent;
        let columnName = selectedList;

        let value = 0;  // since I use update tinyint the functions kick and add to list are no longer needed
        // 0 obviously means false which removes someone from the list

        // creates a post request

        // fetch('ajax/list_kick_user.php', { // that's why ajax.php has been excluded from require at the top of the php
        //     method: 'POST',
        //     headers: {
        //         'Content-Type': 'application/x-www-form-urlencoded'
        //     },
        //     body: `id=${userId}&selectedList=${columnName}` // just hands over the id and db column name
        //     // you can just inspect element on the id to target ANY user from the db, not even those on that list
        //     // but if you are here you already have access to the entire db


        // ajax update tinyint
        fetch('ajax/update_tinyint.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${userId}&column=${columnName}&value=${encodeURIComponent(value)}`

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