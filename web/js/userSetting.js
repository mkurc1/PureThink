var userSettingUrl = '/app_dev.php/admin/user/setting';

function getUserSetting() {
    $.ajax({
        type: "post",
        dataType: 'json',
        url: userSettingUrl,
        beforeSend: function() {
        },
        complete: function() {
        },
        success: function(data) {
            if (data.response) {
                userId = data.setting.userId;
                rowsOnPageId = data.setting.rowsOnPageId;
                moduleId = data.setting.moduleId;
                languageId = data.setting.languageId;
                menuId = data.setting.menuId;
            }
        }
    });
}