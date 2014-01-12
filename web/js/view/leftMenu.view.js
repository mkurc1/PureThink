LeftMenuView = Backbone.View.extend({
    events: {
        "click > li > div > ul > li > a": "selectEl"
    },

    /**
     * Render left menu
     */
    render: function(editMode) {
        var leftMenu = this;

        $.ajax({
            type: "post",
            dataType: 'json',
            data: {
                moduleId: userSettingModel.get('moduleId'),
                menuId: menuId,
                editMode: editMode
            },
            url: links.lefMenu,
            beforeSend: function() {
            },
            complete: function() {
                leftMenu.$el.accordionMenu();

                // if menuId == 2, don't show show all
                if (menuId == 2) {
                    leftMenu.setDynamicMenu(true);
                }
                else {
                    leftMenu.setDynamicMenu(editMode);
                }
            },
            success: function(data) {
                if (data.response) {
                    leftMenu.$el.empty().append(data.menu.toString());
                }
            }
        });
    },

    /**
     * Set dynamic menu
     *
     * @param boolean editMode
     */
    setDynamicMenu: function(editMode) {
        this.$el.find('> li.editable').each(function() {
            $(this).dynamicMenu({
                moduleId : userSettingModel.get('moduleId'),
                menuId   : menuId,
                editMode : editMode
            });
        });
    },

    /**
     * Select element
     */
    selectEl: function(e) {
        if (!$(e.currentTarget).parent().hasClass('selected')) {
            var url = mainMenuView.getMainMenuUrl();

            $(e.currentTarget).parent().parent().find('> li').removeClass('selected');
            $(e.currentTarget).parent().addClass('selected');

            if ($(e.currentTarget).parent().parent().parent().parent().hasClass('group')) {
                listModel.set({ groupId: $(e.currentTarget).attr('list_id') });
            }

            if ($(e.currentTarget).parent().parent().parent().parent().hasClass('language')) {
                if (mainMenuView.isEditMode(url)) {
                    editModel.set({ languageId: $(e.currentTarget).attr('list_id') });
                }
                else {
                    listModel.set({ languageId: $(e.currentTarget).attr('list_id') });
                }
            }

            if (mainMenuView.isEditMode(url)) {
                editModel.set({ isApplyOption: false });
                editView.render();
            }
            else {
                listView.refresh();
            }
        }

        return false;
    }
});