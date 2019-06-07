$(document).ready(function () {
    hideDropdown();
});
let changableFields = 6;
var dataArray = [];

//functie van de edit button(zorgt dat je de velden kan aanpassen)
$('#editbtn').click(function () {
    setValues();
    for (i = 0; i <= changableFields; i++) {
        let value = $("#uservalue" + i);
        var $div = value, isEditable = $div.is('.editable');

        $div.prop('contenteditable', !isEditable).toggleClass('editable')
    }
    togglebuttuns();
});

//functie van de cancel button(zorgt dat je de veldenniet meer kan aanpassen en zet de oude waardes terug)
$('#canceledit').click(function () {
    for (i = 0; i <= changableFields; i++) {
        let value = $("#uservalue" + i);
        var $div = value, isEditable = $div.is('.editable');

        $div.prop('contenteditable', !isEditable).toggleClass('editable');
    }
    resetValues();
    togglebuttuns();
});

$('#saveedit').click(function () {
    if(checkInput()) {
        saveValues();
        togglebuttuns();
        for (i = 0; i <= changableFields; i++) {
            var $div = $('#uservalue' + i), isEditable = $div.is('.editable');

            $div.prop('contenteditable', !isEditable).toggleClass('editable')
    }
}});

function hideDropdown() {
    var x = document.getElementById("dropdown");
    var y = document.getElementById("uservalue4");

    if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
    } else {
        x.style.display = "none";
        y.style.display = "block";
    }
}

function togglebuttuns() {
    $('#editbtn').toggle();
    $('#savecancel').toggle();
    hideDropdown();
}

function resetValues() {
    document.getElementById("uservalue1").innerHTML = dataArray[1];
    document.getElementById("uservalue2").innerHTML = dataArray[2];
    document.getElementById("uservalue3").innerHTML = dataArray[3];
    document.getElementById("uservalue4").innerHTML = dataArray[4];
    document.getElementById("uservalue5").innerHTML = dataArray[5];
    document.getElementById("uservalue6").innerHTML = dataArray[6];
}

function setValues() {
    dataArray[1] = document.getElementById("uservalue1").innerHTML;
    dataArray[2] = document.getElementById("uservalue2").innerHTML;
    dataArray[3] = document.getElementById("uservalue3").innerHTML;
    dataArray[4] = document.getElementById("uservalue4").innerHTML;
    dataArray[5] = document.getElementById("uservalue5").innerHTML;
    dataArray[6] = document.getElementById("uservalue6").innerHTML;
}

function saveValues() {
    var land = document.getElementById("land");
    var gekozenLand = land.options[land.selectedIndex].value;
    document.getElementById("uservalue4").innerHTML = gekozenLand;

    var data = {
        Voornaam: document.getElementById("uservalue1").innerHTML,
        Achternaam: document.getElementById("uservalue2").innerHTML,
        Stad: document.getElementById("uservalue3").innerHTML,
        Land: gekozenLand,
        Email: document.getElementById("uservalue5").innerHTML,
        Telefoon: document.getElementById("uservalue6").innerHTML,
    };

    $.ajax(base_url + "profiel", {
        method: 'post',
        data: data,
        success: function (data) {
            console.log(data);
        }
    });
}

function checkInput() {
    var format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
    var telformat = /[ !@#$%^&*()_\-=\[\]{};':"\\|,.<>\/?]/;
    var emailformat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (format.test(document.getElementById("uservalue1").innerHTML)) {
        alert("Voornaam mag geen speciale characters hebben");
        return false;
    }
    else if(document.getElementById("uservalue1").innerHTML.length < 1) {
        alert("Voornaam mag niet leeg zijn");
        return false;
    }
    else if (format.test(document.getElementById("uservalue2").innerHTML)) {
        alert("Achternaam mag geen speciale characters hebben");
        return false;
    }
    else if(document.getElementById("uservalue2").innerHTML.length < 1) {
        alert("Achternaam mag niet leeg zijn");
        return false;
    }
    else if(format.test(document.getElementById("uservalue3").innerHTML)){
        alert("Stad mag geen speciale characters hebben");
        return false;
    }
    else if(document.getElementById("uservalue3").innerHTML.length < 1) {
        alert("Stad mag niet leeg zijn");
        return false;
    }
    else if(!emailformat.test(document.getElementById("uservalue5").innerHTML) || document.getElementById("uservalue5").innerHTML.length < 1){
        alert("Geen geldige email");
    }
    else if(document.getElementById("uservalue5").innerHTML.length < 1) {
        alert("Email mag niet leeg zijn");
        return false;
    }
    else if(telformat.test(document.getElementById("uservalue6").innerHTML)){
        alert("Telefoonnummer mag geen speciale characters hebben");
        return false;
    }
    else if(document.getElementById("uservalue6").innerHTML.length < 1) {
        alert("Telefoonnummer mag niet leeg zijn");
        return false;
    }
    else {
        return true;
    }
}