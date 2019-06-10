document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems, {
        format: 'dd-mm-yyyy',
        defaultDate: new Date(new Date().setFullYear(new Date().getFullYear() - 20)),
        setDefaultDate: true,
        yearRange: [(new Date().getFullYear()) - 116,(new Date().getFullYear()) - 16],
        maxDate: new Date(new Date().setFullYear(new Date().getFullYear() - 16)),
        minData: new Date(new Date().setFullYear(new Date().getFullYear() - 116))
    });
});

$('select').formSelect();
$('.modal').modal();
$('#TOS').on('click', function() {
});



$('#agree').on('click', function() {
    $('#TOS').prop('checked', true);
});