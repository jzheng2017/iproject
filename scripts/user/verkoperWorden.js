$(document).ready(function () {
    $('#creditcardNummer').attr('disabled', !this.checked)
});
$('.modal').modal();

$('#TOV').on('click', function () {
});

$('#creditCardEnabled').change(function () {
    var creditField = $('#creditcardNummer')
    creditField.attr('disabled', !this.checked);
    creditField.attr('required', this.checked);
});

$('#agree').on('click', function () {
    $('#creditCheck').prop('checked', true);
});