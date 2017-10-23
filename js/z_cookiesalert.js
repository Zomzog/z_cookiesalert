$(document).ready(function() {
    $('.accept-cookie').click(function () {
        $.getJSON($('div.cookies_alert').data('url'), {}, function(data) {
        //$.getJSON(ajax_link, {parameter1 : "value"}, function(data) {
            if(typeof data.status !== "undefined") {
                // Use your new datas here
                console.log(data);
            }
        });
    });
});