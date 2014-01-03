// AJAX actions URL's
var links = {
    userSetting   : '/admin/user/setting',
    mainMenu      : '/admin/menu',
    lefMenu       : '/admin/left_menu',
    rowsOnPage    : '/admin/rows_on_page',
    setRowsOnPage : '/admin/user/setting/set_rows_on_page'
};

isDev();

// Object
var UserSetting = new Setting();
// Object
var paginationListModel = new PaginationModel();
var paginationListView;
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

    UserSetting.getUserSetting();

    listView = new ListView({
        el    : '#main_container',
        model : listModel
    });

    paginationListView = new PaginationView({
        el    : '#pagination',
        model : paginationListModel,
        list  : listView
    });

    editView = new EditView({
        el    : '#edit_container',
        model : editModel
    });

    $('#main_menu_list').setMainMenu(UserSetting.moduleId);
    getRowsOnPage(UserSetting.rowsOnPageId);
});

$(window).load(function() {
    selectFirstMenu();
});