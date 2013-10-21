/**
 * Get main menu
 * 
 * @param integer moduleId
 */
function getMainMenu(moduleId) {
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
        },
        success: function(data) {
            if (data.response) {
                $('#main_menu_list').empty().append(data.menu.toString());
            }
        }
    });
}