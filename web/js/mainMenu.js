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
                selectFirstMenu();
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
    setListUrl();
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
            setListUrl();
            refreshList(true);
        }

        return false;
    })
}