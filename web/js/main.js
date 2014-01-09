// Object
var UserSettingModel = new UserSettingModel();
// Object
var listModel = new ListModel();
var listView;
// Object
var editModel = new EditModel();
var editView;
// Object
var Module = new Module();

var menuId;

$(function() {
    $.ajaxSetup({ async: false });

    UserSettingModel.getSetting();

    listView = new ListView({
        el           : '#main_container',
        model        : listModel,
        paginationEl : '#pagination',
        isMainList   : true
    });

    editView = new EditView({
        el         : '#edit_container',
        model      : editModel,
        isMainEdit : true
    });

    $('#main_menu_list').setMainMenu(UserSettingModel.get('moduleId'));
    getRowsOnPage(UserSettingModel.get('rowsOnPageId'));

    $('#shortcut_attachment').popup();
});

$(window).load(function() {
    selectFirstMenu();
});