/**
 * Object Setting Constructior
 *
 * @param string url
 */
function Setting(url) {
    this.userId = 0;
    this.rowsOnPageId = 0;
    this.moduleId = 0;
    this.languageId = 0;
    this.url = '/app_dev.php/admin/user/setting';
    this.getUserSetting = getUserSetting;

    /**
     * Get user setting
     */
    function getUserSetting() {
        var setting = this;

        $.ajax({
            type: "post",
            dataType: 'json',
            url: this.url,
            beforeSend: function() {
            },
            complete: function() {
            },
            success: function(data) {
                if (data.response) {
                    setting.userId = data.setting.userId;
                    setting.rowsOnPageId = data.setting.rowsOnPageId;
                    setting.moduleId = data.setting.moduleId;
                    setting.languageId = data.setting.languageId;
                }
            }
        });
    }
}