$(document).ready(function() {
    $('select').formSelect();
    $('.modal').modal();
    $('#TOS').on('click', function() {
    });
    $('#TOStext').load("http://localhost/IProject/website/views/registreren/TOS.txt");
});

function validate(str){
    var re = /^[A-Za-z]+$/;
    return re.test(str.val().toString());
}

function checkRegistratie() {

    if ($("#wachtwoord").val() !== $("#wachtwoord2").val()) {
        alert("Wachtwoorden niet gelijk");
    }
    else if ($("#email").val() !== $("#email2").val()) {
         alert("e-mail adressen niet gelijk");
    }
    else if (!validate($("#voornaam"))) {
        alert("geen geldige voornaam");
    }
    else if (!validate($("#achternaam"))) {
        alert("geen geldige achternaam");
    }
    else if (!validate($("#provincie"))) {
        alert("geen geldige provincie");
    }
    else {
    }

}