/**
 * Object Module Cunstructor
 */
function Module() {
    this.init = init;
    this.setActiveModule = setActiveModule;
    this.setActionOnChangeModule = setActionOnChangeModule;

    /**
     * Init
     */
    function init() {
        this.setActiveModule();
        this.setActionOnChangeModule();
    }

    /**
     * Set active module
     */
    function setActiveModule() {
        var module = $('#select_mode > #select_container_list > li[module_id="'+UserSettingModel.get('moduleId')+'"]');
        $('#select_mode > #select').text(module.text());
    }

    /**
     * Set action on change module
     */
    function setActionOnChangeModule() {
        var module = this;

        $('#select_mode > #select_container_list > li.module').click(function() {
            var moduleId = $(this).attr('module_id');

            if (UserSettingModel.get('moduleId') != moduleId) {
                UserSettingModel.set({ moduleId: moduleId });
                UserSettingModel.saveSetting();

                module.setActiveModule();

                $('#main_menu_list').setMainMenu(UserSettingModel.get('moduleId'));

                selectFirstMenu();
            }
        });
    }
}