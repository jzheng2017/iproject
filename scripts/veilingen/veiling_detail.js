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
    M.updateTextFields();

    setVeilingCounter(function(id) {
        let veilingCounter = $("#" + id);
        veilingCounter.html("<h3 class='center-align no-margin veiling-counter'>Gesloten</h3><div class='row'></div>");
    })();


    function getBiedingen() {
        let id = $("#veiling-detail").data('id');
        $.ajax( 'http://iproject21.icasites.nl/api/veilingen/' + id +'/biedingen' , {
            method: 'get',
            success: function(response) {
                let result = response.body;
                let list = $('#biedingen-list');
                list.html("");
                for (let i in result) {
                    list.append('<tr>\n<td class="left">' + result[i].naam + '</td>\n<td>€ ' + parseFloat(Math.round(result[i].bod) / 100).toFixed(2) + '</td>\n</tr>')
                }
                setTimeout( getBiedingen,1000);
            }
        })
    }

    $('form').submit(function( ) {
        $('.disable-on-click').attr('disabled', true);
    });

    getBiedingen();
});

function setVeilingCounter(zeroCallback) {
    return function() {
        let veilingCounter = $(".veiling-counter");
        let seconds = veilingCounter.data("end") - Date.now() / 1000;
        let time = new String(seconds).toHHMMSS();
        veilingCounter.text(time);
        if (seconds > 0) {
            setTimeout(setVeilingCounter(zeroCallback), 1000);
        } else {
            zeroCallback(veilingCounter.data('id'));
        }
    };
}

autoplay();
function autoplay() {
    $('.carousel').carousel('next');
    setTimeout(autoplay, 4500);
}




