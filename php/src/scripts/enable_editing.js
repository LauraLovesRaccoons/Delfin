const editButton = document.getElementById("editButton");

editButton.addEventListener("click", function () {
  console.log("Event listeners are now enabled.");

  // I'm append a new class but keep the old one as well for stylesheet reasons
  document.querySelectorAll(".kick-symbol").forEach((element) => {
    element.classList.add("kick-symbol_edit");
  });

  document.querySelectorAll(".table_text").forEach((element) => {
    element.classList.add("table_text_edit");
  });

  document.querySelectorAll(".table_tinyint").forEach((element) => {
    element.classList.add("table_tinyint_edit");
  });
});
