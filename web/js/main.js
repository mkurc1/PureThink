// Object
var UserSetting;
// Object
var ListPagination;

var menuId;

$(function() {
    $.ajaxSetup({async: false});

    $(document).ajaxStart(function() {
        showLoading();
    });

    $(document).ajaxStop(function() {
        hideLoading();
    });

    UserSetting = new Setting();
    UserSetting.getUserSetting();

    $('#main_menu_list').setMainMenu(UserSetting.moduleId);
    getRowsOnPage(UserSetting.rowsOnPageId);
});

/**
 * Show loading
 */
function showLoading() {
    $('#loading').show();
}

/**
 * Hide loading
 */
function hideLoading() {
    $('#loading').hide();
}