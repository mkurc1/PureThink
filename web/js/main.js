// Object
var UserSetting;
// Object
var ListPagination;

var menuId;

$(function() {
    $.ajaxSetup({async: false});

    hideEditContainer();

    UserSetting = new Setting();
    UserSetting.getUserSetting();

    $('#main_menu_list').setMainMenu(UserSetting.moduleId);
    getRowsOnPage(UserSetting.rowsOnPageId);
});

$(window).load(function() {
    selectFirstMenu();
});

/**
 * Set beautify selects
 */
function beautifySelects() {
    $('.sintetic-select').chosen({
        allow_single_deselect: true
    });
}

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