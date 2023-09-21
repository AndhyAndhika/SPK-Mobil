// Untuk Show Dan Hide pada id navbar-toggler di navbar

document.addEventListener("DOMContentLoaded", function() {
    const toggleButton = document.getElementById("navbar-toggler");
    const content = document.getElementById("navbarNav");

    toggleButton.addEventListener("click", function() {
      content.classList.toggle("show");
    });
});

$(function() {
    $('#tooltip').tooltip();
  });

function DisabledButtomSubmit() {
    document.getElementById("submit").disabled = true;
}
