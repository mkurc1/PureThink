/**
 * Set cookie
 *
 * @param string c_name
 * @param string value
 * @param integer exdays
 */
function setCookie(c_name, value, exdays) {
    var exdate = new Date();

    exdate.setDate(exdate.getDate() + exdays);

    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());

    document.cookie = c_name + "=" + c_value;
}

/**
 * Get cookie
 *
 * @param string c_name
 * @return string
 */
function getCookie(c_name) {
    var i, x, y;
    var ARRcookies = document.cookie.split(";");

    for (i = 0; i < ARRcookies.length; i++)
    {
        x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);

        x=x.replace(/^\s+|\s+$/g,"");

        if (x == c_name)
            return unescape(y);
    }

    return false;
}