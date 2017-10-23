$(document).ready(function() {
    var cookieContent = $('.cookies_alert');

    $('.accept-cookie').click(function () {
        $.getJSON($('div.cookies_alert').data('url'), {}, function(data) {
            if(typeof data.status !== "undefined") {
                // TODO print something ?
                console.log(data);
            }
        });
        cookieContent.hide(500);
    });
});