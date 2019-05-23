$(document).ready(function () {
    $('select').formSelect();
});

function checkPrijs() {
    if ($("#minPrijs").val() > $("#maxPrijs").val()) {
        alert("Minimaale prijs moet hoger zijn dan de maximale prijs");
    }
}