//user setting
var moduleId;
var languageId;
var rowsOnPageId;
var userId;
var menuId;

var groupId;
var order;
var sequence;
var filtr;

var page = 1;
var start = 0;
var end = 0;
var lastPage = 0;
var beforePage = 0;
var nextPage = 0;

$(function() {
    $.ajaxSetup({async: false});

    getUserSetting();
    $('#main_menu_list').setMainMenu(moduleId, menuId);
    getRowsOnPage(rowsOnPageId);
});