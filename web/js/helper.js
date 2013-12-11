/**
 * Is ID exitst
 *
 * @param string id
 * @return boolean
 */
function isIdExitst(id) {
    var element = document.getElementById(id);
    if (typeof (element) != undefined && typeof (element) != null && typeof (element) != 'undefined') {
        return false;
    }
    else {
        return true;
    }
}

/**
 * Set beautify selects
 */
function beautifySelects() {
    $('.sintetic-select').chosen({
        allow_single_deselect: true
    });

    $('.sintetic-select_top').chosen({
        allow_single_deselect: true,
        top: true,
        disable_search: true
    });
}

/**
 * Get URL Parameter
 *
 * @param string name
 * @return string
 */
function getURLParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
        );
}

/**
 * Array clear function
 */
Array.prototype.clear = function()
{
    this.length = 0;
};

(function($) {
    $.fn.setCursorToTextEnd = function() {
        $initialVal = this.val();
        this.val($initialVal + ' ');
        this.val($initialVal);
    };
})(jQuery);