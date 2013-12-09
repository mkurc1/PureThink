// Object
var UserSetting = new Setting();
// Object
var Pagination = new Pagination(10);
// Object
var List = new List();
// Object
var Edit = new Edit();
// Object
var Module = new Module();

var menuId;

$(function() {
    $.ajaxSetup({async: false});

    UserSetting.getUserSetting();

    Pagination.addActions();

    $('#main_menu_list').setMainMenu(UserSetting.moduleId);
    getRowsOnPage(UserSetting.rowsOnPageId);
});

$(window).load(function() {
    selectFirstMenu();
});