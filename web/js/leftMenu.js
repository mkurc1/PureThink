var leftMenuUrl = '/app_dev.php/admin/left_menu';

$(function() {
    $('#left_menu_toggle').click(function() {
        if ($('#left_menu').is(':visible')) {
            $('#left_menu').hide();
            $(this).addClass('hide_menu');
            $('#main').addClass('hide_menu');
            $('#footer > #pagination_count').addClass('hide_menu');
        }
        else {
            $('#left_menu').show();
            $(this).removeClass('hide_menu');
            $('#main').removeClass('hide_menu');
            $('#footer > #pagination_count').removeClass('hide_menu');
        }
    });
});

/**
 * Get left menu
 */
function getLeftMenu() {
    $.ajax({
        type: "post",
        dataType: 'json',
        data: {
            moduleId: UserSetting.moduleId,
            menuId: menuId
        },
        url: leftMenuUrl,
        beforeSend: function() {
        },
        complete: function() {
            $('#left_menu_container').accordionMenu();
            setActionsOnLeftMenu()
            setDynamicMenu();
        },
        success: function(data) {
            if (data.response) {
                $('#left_menu_container').empty().append(data.menu.toString());
            }
        }
    });
}

function setDynamicMenu() {
    $('#left_menu_container > li.editable').each(function() {
        $(this).dynamicMenu();
    });
}

/**
 * Set actions on left menu
 */
function setActionsOnLeftMenu() {
    $('#left_menu_container > li > div > ul > li > a').click(function() {
        if (!$(this).parent().hasClass('selected')) {
            $(this).parent().parent().find('> li').removeClass('selected');
            $(this).parent().addClass('selected');

            if ($(this).attr('group_id')) {
                List.groupId = $(this).attr('group_id');
            }

            if ($(this).attr('language_id')) {
                List.languageId = $(this).attr('language_id');
            }

            refreshList();
        }

        return false;
    });
}