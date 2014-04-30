UserSettingModel = Backbone.Model.extend({
    defaults: {
        userId: 0,
        rowsOnPageId: 0,
        moduleId: 0,
        languageId: 0
    },

    getSetting: function () {
        var setting = this;

        $.ajax({
            type: "get",
            dataType: 'json',
            url: Routing.generate('purethink_user_usersetting_getusersetting'),
            complete: function () {
                moduleView = new ModuleView({
                    el: "#select_mode"
                });
            },
            success: function (data) {
                setting.set({
                    userId: data.userId,
                    rowsOnPageId: data.rowsOnPageId,
                    moduleId: data.moduleId,
                    languageId: data.languageId
                });
            }
        });
    },

    saveSetting: function () {
        var setting = this;

        $.ajax({
            type: "post",
            url: Routing.generate('purethink_user_usersetting_setusersetting'),
            data: {
                rowsOnPageId: setting.get('rowsOnPageId'),
                moduleId: setting.get('moduleId'),
                languageId: setting.get('languageId')
            }
        });
    }
});