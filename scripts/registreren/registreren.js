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
var getUrl = window.location;
var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
$('#TOStext').load(baseUrl + "/website/views/registreren/TOS.txt");



$('#agree').on('click', function() {
    $('#TOS').prop('checked', true);
});