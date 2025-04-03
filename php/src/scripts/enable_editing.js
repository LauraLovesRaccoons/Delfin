const editButton = document.getElementById("editButton");

editButton.addEventListener("click", function () {
  console.log("Event listeners are now enabled.");

  // I'm gonna switch all the classes to _edit classes because this is the way I'm thinking of and it works, plus the stylesheet can be customized or just target both classes
  document.querySelectorAll(".kick-symbol").forEach((element) => {
    element.classList.add("kick-symbol_edit");
    // element.classList.remove("kick-symbol"); // Remove the old class
  });

  document.querySelectorAll(".table_text").forEach((element) => {
    element.classList.add("table_text_edit");
    element.classList.remove("table_text"); // Remove the old class
  });

  document.querySelectorAll(".table_tinyint").forEach((element) => {
    element.classList.add("table_tinyint_edit");
    element.classList.remove("table_tinyint"); // Remove the old class
  });
});
