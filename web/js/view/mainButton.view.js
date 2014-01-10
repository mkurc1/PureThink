MainButtonView = Backbone.View.extend({
    events: {
        "click #create"  : "create",
        "click .refresh" : "refresh",
        "click .edit"    : "edit",
        "click .remove"  : "remove",
        "click .cancel"  : "cancel",
        "click .apply"   : "apply",
        "click .save"    : "save"
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

            var confirmation = confirm(confirmationText);
            if(confirmation) {
                listView.removeElements();
            }
        }
    },

    /**
     * Cancel
     */
    cancel: function() {
        if (isEditMode(getMainMenuUrl())) {
            editView.render();
        }
        else {
            this.createListButtons();
            this.toggleListMainButton();
            filterView.showEl();
            listView.paginationView.showEl();
            listView.paginationView.togglePagination();
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
        if (isEditMode(getMainMenuUrl())) {
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
            'select'  : '<button class="select"></button>',
            'refresh' : '<button class="refresh"></button>',
            'edit'    : '<button class="edit"></button>',
            'remove'  : '<button class="remove"></button>',
            'more'    : '<button class="more"></button>'
        };

        this.addMainButtons(buttons);
    },

    /**
     * Create edit buttons
     */
    createEditButtons: function() {
        this.removeMainButtons();

        var buttons = {
            'cancel' : '<button class="cancel"></button>',
            'apply'  : '<button class="apply"></button>',
            'save'   : '<button class="save"></button>'
        };

        this.addMainButtons(buttons);
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