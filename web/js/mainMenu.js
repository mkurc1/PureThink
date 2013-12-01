var mainMenuUrl = '/app_dev.php/admin/menu';

(function($) {
    $.fn.setMainMenu = function(moduleId) {
        var menu = $(this);

        $.ajax({
            type: "post",
            dataType: 'json',
            data: {
                moduleId: moduleId
            },
            url: mainMenuUrl,
            beforeSend: function() {
            },
            complete: function() {
                setActionOnClickMenu();
            },
            success: function(data) {
                if (data.response) {
                    menu.empty().append(data.menu.toString());
                }
            }
        });
    }
})(jQuery);

/**
 * Select first menu
 */
function selectFirstMenu() {
    $('#main_menu_list > li').eq(2).addClass('selected');
    setMenuId();
    startMode();
}

/**
 * Start mode
 */
function startMode() {
    var url = getMainMenuUrl();

    if (isEditMode(url)) {
        setEditUrl(url);
        getLeftMenu();
        editMode();
    }
    else {
        setListUrl(url);
        refreshList(true);
    }
}

/**
 * Get main menu URL
 *
 * @return string
 */
function getMainMenuUrl() {
    return $('#main_menu_list > li.selected > a').attr('href');
}

/**
 * Get mode by menu URL
 *
 * @param string url
 * @return boolean
 */
function isEditMode(url) {
    var pathArray = url.split('/');
    var temp = pathArray[pathArray.length-2];

    if (temp == 'edit') {
        return true;
    }
    else {
        return false;
    }
}

/**
 * Set menu Id
 */
function setMenuId() {
    menuId = $('#main_menu_list > li.selected > a').attr('menu_id');
}

/**
 * Set action on click main menu
 */
function setActionOnClickMenu() {
    $('#main_menu_list > li > a').click(function() {
        $('#main_menu_list > li').removeClass('selected');
        $(this).parent().addClass('selected');

        if ($(this).attr('menu_id') != menuId) {
            setMenuId();
            startMode();
        }

        return false;
    })
}