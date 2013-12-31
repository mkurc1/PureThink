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
var paginationListModel = new PaginationModel({rowsOnPage: 10});
var paginationListView;
// Object
var List = new List();
// Object
var editModel = new EditModel();
var editView;
// Object
var Module = new Module();


var menuId;

$(function() {
    $.ajaxSetup({async: false});

    UserSetting.getUserSetting();

    paginationListView = new PaginationView({
        el: '#pagination',
        model: paginationListModel
    });

    editView = new EditView({
        el: '#edit_container',
        model: editModel
    });

    $('#main_menu_list').setMainMenu(UserSetting.moduleId);
    getRowsOnPage(UserSetting.rowsOnPageId);
});

$(window).load(function() {
    selectFirstMenu();
});

/**
 * Is dev
 */
function isDev() {
    var url = document.URL;

    if (url.indexOf("app_dev.php") > 0) {
        $.each(links, function(index, val) {
             links[index] = '/app_dev.php'+val;
        });
    }
}