$(document).ready(function () {
});

$('#editbtn').click(function () {
    for (i = 0; i <= 8; i++) {
        var $div = $('#uservalue' + i), isEditable = $div.is('.editable');

        $div.prop('contenteditable', !isEditable).toggleClass('editable')
    }
    togglebuttuns();
});

$('#canceledit').click(function () {
    for (i = 0; i <= 8; i++) {
        var $div = $('#uservalue' + i), isEditable = $div.is('.editable');

        $div.prop('contenteditable', !isEditable).toggleClass('editable')
    }
    togglebuttuns();
});
$('#saveedit').click(function () {
    for (i = 0; i <= 8; i++) {
        var $div = $('#uservalue' + i), isEditable = $div.is('.editable');

        $div.prop('contenteditable', !isEditable).toggleClass('editable')
    }
    togglebuttuns();
});

function togglebuttuns() {
        $('#editbtn').toggle();
        $('#savecancel').toggle();
}