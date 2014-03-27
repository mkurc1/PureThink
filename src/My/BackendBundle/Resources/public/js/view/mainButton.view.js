MainButtonView = Backbone.View.extend({
    events: {
        "click #create" : "create",
        "click .refresh": "refresh",
        "click .edit"   : "edit",
        "click .remove" : "remove",
        "click .cancel" : "cancel",
        "click .apply"  : "apply",
        "click .save"   : "save"
    },

    /**
     * Create
     */
    create: function(e) {
        if (!$(e.currentTarget).parent().hasClass('disable')) {
            editModel.set({url: listModel.get('url')+'new'});
            editView.render();
        }
    },

    /**
     * Refresh
     */
    refresh: function() {
        listView.refresh(true);
    },

    /**
     * Edit
     */
    edit: function(e) {
        if (!$(e.currentTarget).parent().hasClass('disable')) {
            var listId = listView.select.get(0);

            var editObject = $('#main_container > table > tbody tr[list_id="'+listId+'"]');
            var editUrl;

            if (editObject.find('.editMode').length > 0) {
                editUrl = editObject.find('.editMode').attr('href');
            }
            else {
                editUrl = listModel.get('url')+listId+'/edit';
            }

            editModel.set({ url: editUrl });
            editView.render();
        }
    },

    /**
     * Remove
     */
    remove: function(e) {
        if (!$(e.currentTarget).parent().hasClass('disable')) {
            var confirmationText;
            if (listView.select.count() > 1) {
                confirmationText = 'Czy napewno chcesz usunąć wybrane pozycje?';
            }
            else {
                confirmationText = 'Czy napewno chcesz usunąć wybraną pozycje?';
            }

            alertify.confirm(confirmationText, function (e) {
                if (e) {
                    listView.removeElements();
                }
            });
        }
    },

    /**
     * Cancel
     */
    cancel: function() {
        if (mainMenuView.isEditMode(mainMenuView.getMainMenuUrl())) {
            editView.render();
        }
        else {
            this.createListButtons();
            this.toggleListMainButton();
            filterView.showEl();

            if (listView.paginationModel.get('hide')) {
                listView.paginationView.hideEl();
            }
            else {
                listView.paginationView.showEl();
                listView.paginationView.togglePagination();
            }

            listView.setMode();
        }
    },

    /**
     * Apply
     */
    apply: function() {
        editModel.set({ isApplyOption: true });

        $('#edit_container > .container > form').submit();
    },

    /**
     * Save
     */
    save: function(e) {
        if (!$(e.currentTarget).parent().hasClass('disable')) {
            editModel.set({ isApplyOption: false });

            $('#edit_container > .container > form').submit();
        }
    },

    /**
     * Toggle list main button
     */
    toggleListMainButton: function() {
        if (mainMenuView.isEditMode(mainMenuView.getMainMenuUrl())) {
            this.toggleListMainButtonForEditMode();
        }
        else {
            this.toggleListMainButtonForListMode();
        }
    },

    /**
     * Toggle list main button for list mode
     */
    toggleListMainButtonForListMode: function() {
        this.enableMainButtonCreate();

        switch(listView.select.count()) {
            case 0:
                this.disableMainButtonEdit();
                this.disableMainButtonRemove();
                break;
            case 1:
                this.enableMainButtonEdit();
                this.enableMainButtonRemove();
                break;
            default:
                this.disableMainButtonEdit();
                this.enableMainButtonRemove();
                break;
        }
    },

    /**
     * Toggle list main button for edit mode
     */
    toggleListMainButtonForEditMode: function() {
        this.disableMainButtonSave();
        this.disableMainButtonCreate();
    },

    /**
     * Remove main buttons
     */
    removeMainButtons: function() {
        this.$el.find('.center').empty();
    },

    /**
     * Create list buttons
     */
    createListButtons: function() {
        this.removeMainButtons();

        var buttons = {
            'select'  : '<div class="select"><i class="fa fa-square-o spacing"></i><i class="fa fa-caret-down"></i></div>',
            'refresh' : '<div class="refresh"><i class="fa fa-refresh"></i></div>',
            'edit'    : '<div class="edit"><i class="fa fa-pencil-square-o"></i></div>',
            'remove'  : '<div class="remove"><i class="fa fa-trash-o"></i></div>',
            'more'    : '<div class="more"><i class="fa fa-ellipsis-h spacing"></i><i class="fa fa-caret-down"></i></div>'
        };

        this.addMainButtons(buttons);
        this.createSelectMenu();
        this.createMoreMenu();
    },

    /**
     * Create edit buttons
     */
    createEditButtons: function() {
        this.removeMainButtons();

        var buttons = {
            'cancel' : '<div class="cancel"><i class="fa fa-times"></i></div>',
            'apply'  : '<div class="apply"><i class="fa fa-pencil"></i></div>',
            'save'   : '<div class="save"><i class="fa fa-floppy-o"></i></div>'
        };

        this.addMainButtons(buttons);
    },

    /**
     * Create select menu
     */
    createSelectMenu: function() {
        var mainButton = this;

        var menu = {
            'select-header'  : '<li class="header">Zaznacz</li>',
            'select-all'     : '<li class="select-all">Zaznacz wszystkie</li>',
            'select-clear'   : '<li class="select-clear">Odznacz wszystkie</li>',
            'select-reverse' : '<li class="select-reverse">Odwróć zaznaczenie</li>'
        };

        var menuList = $('<ul></ul>');

        $.each(menu, function(index, val) {
            menuList.append(val);
        });


        mainButton.$el.find('.select').append(menuList);
    },

    /**
     * Create more menu
     */
    createMoreMenu: function() {
        var mainButton = this;

        var menu = {
            'data-header' : '<li class="header">Dane</li>',
            'data-import' : '<li class="data-import">Importuj dane</li>',
            'data-export' : '<li class="data-export">Eksportuj dane</li>',
        };

        var menuList = $('<ul></ul>');

        $.each(menu, function(index, val) {
            menuList.append(val);
        });


        mainButton.$el.find('.more').append(menuList);
    },

    /**
     * Add main buttons
     *
     * @param array tab
     */
    addMainButtons: function(tab) {
        var mainButton = this;

        $.each(tab, function(index, val) {
            mainButton.$el.find('.center').append('<div class="button_container">'+val+'</div>');
        });
    },

    /**
     * Enable main button edit
     */
    enableMainButtonEdit: function() {
        this.$el.find('.edit').parent().removeClass('disable');
    },

    /**
     * Disable main button edit
     */
    disableMainButtonEdit: function() {
        this.$el.find('.edit').parent().addClass('disable');
    },

    /**
     * Enable main button remove
     */
    enableMainButtonRemove: function() {
        this.$el.find('.remove').parent().removeClass('disable');
    },

    /**
     * Disable main button remove
     */
    disableMainButtonRemove: function() {
        this.$el.find('.remove').parent().addClass('disable');
    },

    /**
     * Disable main button save
     */
    disableMainButtonSave: function() {
        this.$el.find('.save').parent().addClass('disable');
    },

    /**
     * Disable main button create
     */
    disableMainButtonCreate: function() {
        this.$el.find('#create').parent().addClass('disable');
    },

    /**
     * Enable main button create
     */
    enableMainButtonCreate: function() {
        this.$el.find('#create').parent().removeClass('disable');
    },
});