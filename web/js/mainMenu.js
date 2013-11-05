var mainMenuUrl = '/app_dev.php/admin/menu';

(function($) {
    $.fn.setMainMenu = function(moduleId, menuId) {
        var menu = $(this);

        $.ajax({
            type: "post",
            dataType: 'json',
            data: {
                moduleId: moduleId,
                menuId: menuId
            },
            url: mainMenuUrl,
            beforeSend: function() {
            },
            complete: function() {
            },
            success: function(data) {
                if (data.response) {
                    menu.empty().append(data.menu.toString());
                }
            }
        });
    }
})(jQuery);