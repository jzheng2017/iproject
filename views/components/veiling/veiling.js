document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.materialboxed');
    var instances = M.Materialbox.init(elems, {});
});

$(function() {
    $('.card-counter').each(function(elem) {
        veilingCardCounter(this, function(id) {
            let veilingCard = $("#" + id);
            veilingCard.remove();
        })();
    });

});

function veilingCardCounter(elem,zeroCallback) {
    return function() {
        let veilingCounter = $(elem);
        let seconds = veilingCounter.data("value") - Date.now() / 1000;
        let time = new String(seconds).toHHMMSS();
        veilingCounter.text(time);
        if (seconds > 0) {
            setTimeout(veilingCardCounter(elem,zeroCallback), 1000);
        } else {
            zeroCallback(veilingCounter.data('parent'));
        }
    };
}