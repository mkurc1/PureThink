// Models
var userSettingModel = new UserSettingModel(),
    listModel        = new ListModel(),
    editModel        = new EditModel();

// Views
var mainButtonView,
    listView,
    editView,
    moduleView,
    footerView,
    leftMenuView,
    mainMenuView,
    filterView;

// Selected menu ID
var menuId;

$(function() {
    $.ajaxSetup({
        async: false,
        error: function (x, status, error) {
            if (x.status == 403) {
                notify("fail" ,"Sorry, your session has expired. Please login again to continue");
            }
            else {
                notify("fail" ,"An error occurred: " + status + "nError: " + error);
            }
        }
    });

    userSettingModel.getSetting();

    mainButtonView = new MainButtonView({
        el : "#main_button"
    });

    footerView = new FooterView({
        el : "#footer"
    });

    mainMenuView = new MainMenuView({
        el : "#main_menu_list"
    });

    leftMenuView = new LeftMenuView({
        el : "#left_menu_container"
    });

    filterView = new FilterView({
        el : "#search_box"
    });

    listView = new ListView({
        el           : "#main_container",
        model        : listModel,
        paginationEl : "#pagination",
        isMainList   : true
    });

    editView = new EditView({
        el         : "#edit_container",
        model      : editModel,
        isMainEdit : true
    });

    mainMenuView.render();

    footerView.getRowsOnPage(userSettingModel.get('rowsOnPageId'));

    $('#shortcut_attachment').popup();
});