(function($) {
    var show_search = true;
    $('.searchbar-trigger').on('click', function (event){
        var target = $("#" + $(this).data("target"));
        if (show_search) {
            target.attr("style", "display: block !important");
        } else {
            target.attr("style", "display: none !important");
        }
        show_search = !show_search;
    });
})($);