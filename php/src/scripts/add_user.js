// double click as usual
// document.getElementById("submitAddUser").addEventListener("dblclick", function () {
["submitAddUser", "submitAddUser_Omega"].forEach((id) => {
  const both_submitAddUser_btn = document.getElementById(id);
  if (both_submitAddUser_btn) {
    both_submitAddUser_btn.addEventListener("dblclick", function () {
      console.log("Add User Form being processed");
      const form = document.getElementById("addUserForm");
      const formData = new FormData(form);

      fetch("ajax/create.php", {
        method: "POST",
        body: new URLSearchParams(formData),
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      })
        .then((response) => {
          if (response.ok) {
            return response.json();
          } else {
            throw new Error("Failed to add user.");
          }
        })
        .then((data) => {
          if (data.success) {
            alert("User successfully added to the bottom");
            console.log("User successfully added to the bottom");
            location.reload(); // Reload the page to show the new user
          } else {
            // not sure when this is shows
            alert("Failed to add user: " + data.message); // ... create.php -> here
          }
        })
        .catch((error) => {
          console.log("Error:", error);
          alert("An error occurred while adding the user.");
        });
    });
  }
});
