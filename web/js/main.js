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