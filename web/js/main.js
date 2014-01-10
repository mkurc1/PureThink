// Object
var userSettingModel = new UserSettingModel();
// Object
var mainButtonView;
// Object
var listModel = new ListModel();
var listView;
// Object
var editModel = new EditModel();
var editView;
// Object
var moduleView;
// Object
var footerView;
// Object
var leftMenuView;
// Object
var filterView;

var menuId;

$(function() {
    $.ajaxSetup({ async: false });

    userSettingModel.getSetting();

    mainButtonView = new MainButtonView({
        el : '#main_button'
    });

    footerView = new FooterView({
        el : "#footer"
    });

    leftMenuView = new LeftMenuView({
        el : "#left_menu_container"
    });

    filterView = new FilterView({
        el : "#search_box"
    });

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

    $('#main_menu_list').setMainMenu(userSettingModel.get('moduleId'));
    getRowsOnPage(userSettingModel.get('rowsOnPageId'));

    $('#shortcut_attachment').popup();
});

$(window).load(function() {
    selectFirstMenu();
});