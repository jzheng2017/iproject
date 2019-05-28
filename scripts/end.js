$(function() {
    $.ajax(base_url + 'sluitveilingen', {
        method: 'post',
        dataType: 'json'
    })
});