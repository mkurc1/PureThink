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