/**
 * Object Setting Constructior
 */
function Setting() {
    this.userId = 0;
    this.rowsOnPageId = 0;
    this.moduleId = 0;
    this.languageId = 0;
    this.url = links.userSetting;

    this.getUserSetting = getUserSetting;
    this.setUserSetting = setUserSetting;

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
                Module.init();
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

    /**
     * Set user setting
     */
    function setUserSetting() {
        var setting = this;

        $.ajax({
            type: "post",
            dataType: 'json',
            data: {
                rowsOnPageId: setting.rowsOnPageId,
                moduleId: setting.moduleId,
                languageId: setting.languageId
            },
            url: this.url+'/set',
            beforeSend: function() {
            },
            complete: function() {
            },
            success: function() {
            }
        });
    }
}