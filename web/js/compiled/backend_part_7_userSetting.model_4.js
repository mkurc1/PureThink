UserSettingModel = Backbone.Model.extend({
    initialize: function() {
        this.url = links.userSetting;
    },

    defaults: {
        userId       : 0,
        rowsOnPageId : 0,
        moduleId     : 0,
        languageId   : 0
    },

    getSetting: function() {
        var setting = this;

        $.ajax({
            type     : "post",
            dataType : 'json',
            url      : setting.url,
            complete: function() {
                moduleView = new ModuleView({
                    el: "#select_mode"
                });
            },
            success: function(data) {
                if (data.response) {
                    setting.set({
                        userId       : data.setting.userId,
                        rowsOnPageId : data.setting.rowsOnPageId,
                        moduleId     : data.setting.moduleId,
                        languageId   : data.setting.languageId
                    });
                }
            }
        });
    },

    saveSetting: function() {
        var setting = this;

        $.ajax({
            type     : "post",
            dataType : 'json',
            async    : true,
            url      : setting.url+'/set',
            data: {
                rowsOnPageId : setting.get('rowsOnPageId'),
                moduleId     : setting.get('moduleId'),
                languageId   : setting.get('languageId')
            }
        });
    }
});