document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.carousel');
    var instances = M.Carousel.init(elems, {});
    var instance = M.Carousel.init({
        fullWidth: true
    });
});

$('.carousel').carousel({
    padding: 200
});

$(document).ready(function(){
    $('ul.tabs').tabs();
});

$(document).ready(function() {
    M.updateTextFields();
});

autoplay();
function autoplay() {
    $('.carousel').carousel('next');
    setTimeout(autoplay, 4500);
}



