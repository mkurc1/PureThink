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

});