//start and set baner
$(function(){

    $('#main_menu ul li.has_submenu > a').removeAttr('href');

    //cookies policy
    if (getCookie('cookies_policy') != "true") {
        $('#cookie').show();
    }

    $('#cookie').find('a.close').click(function() {
        $('#cookie').remove();

        setCookie('cookies_policy', true, 365);
    });

    $('#baner > .container').slidesjs({
        width: 1000,
        height: 296,
        play: {
            auto: true,
            interval: 8000,
            swap: true
        },
        navigation: {
            effect: "slide"
        },
        pagination: {
            effect: "slide"
        },
        effect: {
            slide: {
                speed: 500
            }
        }
    });

});