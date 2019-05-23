$(document).ready(function() {
    $('.collapsible').collapsible();

    $('#collapseFilterBar').on('click', function() {
        $(".collapsible").collapsible('close');
    });
    $('#openFilterBar').on('click', function() {
        $(".collapsible").collapsible('open');
    });
});