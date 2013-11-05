var userSettingUrl = '/app_dev.php/admin/user/setting';

//user setting
var moduleId;
var languageId;
var rowsOnPage;
var userId;

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
            }
        }
    });
}