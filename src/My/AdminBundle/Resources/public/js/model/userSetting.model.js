UserSettingModel = Backbone.Model.extend({
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
            url      : Routing.generate('my_user_usersetting_getusersetting'),
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
            url      : Routing.generate('my_user_usersetting_setusersetting'),
            data: {
                rowsOnPageId : setting.get('rowsOnPageId'),
                moduleId     : setting.get('moduleId'),
                languageId   : setting.get('languageId')
            }
        });
    }
});