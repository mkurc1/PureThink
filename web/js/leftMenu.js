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
        },
        success: function(data) {
            if (data.response) {
                $('#left_menu_container').empty().append(data.menu.toString());
            }
        }
    });
}