const editButton = document.getElementById("editButton");
//
editButton.addEventListener("click", function () {
  console.log("Event listeners are now enabled.");

  // I'm append a new class but keep the old one as well for stylesheet reasons

  document.querySelectorAll(".kick-symbol").forEach((element) => {
    element.classList.add("kick-symbol_edit");
  });
  //
  const script_edit_kick = document.createElement("script");
  script_edit_kick.src = "./scripts/edit_kick.js";
  script_edit_kick.type = "text/javascript";
  document.head.appendChild(script_edit_kick);
  //
  document.querySelectorAll(".table_text").forEach((element) => {
    element.classList.add("table_text_edit");
  });
  //
  const script_edit_text = document.createElement("script");
  script_edit_text.src = "./scripts/edit_text.js";
  script_edit_text.type = "text/javascript";
  document.head.appendChild(script_edit_text);
  //
  document.querySelectorAll(".table_tinyint").forEach((element) => {
    element.classList.add("table_tinyint_edit");
  });
  //
  const script_edit_tinyint = document.createElement("script");
  script_edit_tinyint.src = "./scripts/edit_tinyint.js";
  script_edit_tinyint.type = "text/javascript";
  document.head.appendChild(script_edit_tinyint);
});
