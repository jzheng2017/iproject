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

var map;
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -4.397, lng: 10.644},
        zoom: 8
    });
}