// this adds the delete properly the class .kick symbol (span)
document.querySelectorAll(".delete-symbol").forEach((button) => {
  button.addEventListener("dblclick", function () {
    // double click for ease of use

    const userId =
      this.closest("tr").querySelector('[data-cell="id"]').textContent;
    // Confirm deletion
    if (
      confirm(
        `Are you sure you want to delete the user with the ID: ${userId} ?`
      )
    ) {
      // Get the user ID from the closest row
      // const userId = this.closest("tr").querySelector('[data-cell="id"]').textContent;
      console.log("Deletion Submitted");

      // Send the AJAX request to delete the user
      fetch("ajax/delete.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${encodeURIComponent(userId)}`,
      }).then(() => {
        // Remove the row from the table if the deletion was successful
        this.closest("tr").remove();
        // animation  --> copied from the kick script
        let deleteMessage = document.createElement("span"); // span is the best option since i display text
        deleteMessage.textContent = `User with id: ${userId} DELETED 💀 `; // this requires these ` for js vars

        deleteMessage.classList.add("deleteMessage"); // adds a class for styling

        // append the span to my wrapper
        let tableWrapper = document.querySelector(".table-wrapper");
        tableWrapper.appendChild(deleteMessage);

        // Remove the success message after 5(000 milli)seconds -> after fade out effect
        setTimeout(() => {
          deleteMessage.classList.add("fade-out");
          setTimeout(() => deleteMessage.remove(), 1250); // 1.25 is fade out in my scss code
        }, 5000);
      });
    } else {
      console.log("Deletion Process Aborted"); // I pressed Cancel
    }
  });
});
