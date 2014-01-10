ModuleView = Backbone.View.extend({
    initialize: function() {
        this.setActiveModule();
    },

    events: {
        "click #select_container_list > li.module": "changeModule"
    },

    /**
     * Change module
     */
    changeModule: function(e) {
        var moduleId = $(e.currentTarget).attr('module_id');

        if (userSettingModel.get('moduleId') != moduleId) {
            userSettingModel.set({ moduleId: moduleId });
            userSettingModel.saveSetting();

            this.setActiveModule();

            $('#main_menu_list').setMainMenu(userSettingModel.get('moduleId'));

            selectFirstMenu();
        }
    },

    /**
     * Set active module
     */
    setActiveModule: function() {
        var module = this.$el.find('#select_container_list > li[module_id="'+userSettingModel.get('moduleId')+'"]');
        this.$el.find('#select').text(module.text());
    }
});