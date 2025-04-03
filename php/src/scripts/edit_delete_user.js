// this adds the delete properly the class .kick symbol (span)
document.querySelectorAll(".delete-symbol").forEach((button) => {
  button.addEventListener("dblclick", function () {
    // double click for ease of use
    alert("Are you sure?");
    // let userId =
    //   this.closest("tr").querySelector('[data-cell="id"]').textContent;
  });
});
