$(function() {
    $.ajax(base_url + 'sluitveilingen', {
        method: 'post',
        dataType: 'json',
        data: {
            "test": "test"
        },
        success: function(result) {
            console.log(result);
        }
    })
});