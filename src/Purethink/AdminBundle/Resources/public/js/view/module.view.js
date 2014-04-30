ModuleView = Backbone.View.extend({
    initialize: function() {
        this.setActiveModule();
    },

    events: {
        "click #select_container_list > li.module": "changeModule"
    },

    changeModule: function(e) {
        var moduleId = $(e.currentTarget).attr('module_id');

        if (userSettingModel.get('moduleId') != moduleId) {
            userSettingModel.set({ moduleId: moduleId });
            userSettingModel.saveSetting();

            this.setActiveModule();

            mainMenuView.render();
        }
    },

    setActiveModule: function() {
        var module = this.$el.find('#select_container_list > li[module_id="'+userSettingModel.get('moduleId')+'"]');
        this.$el.find('#select').text(module.text());
    }
});