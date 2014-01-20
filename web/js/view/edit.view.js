EditView = Backbone.View.extend({
    initialize: function(options) {
        this.isMainEdit = options.isMainEdit;

        console.log('Initialize Edit View');
    },

    events: {
        'click button.browse'  : 'uploadFileButton',
        'click div.input_file' : 'uploadFileButton',
        'submit'               : 'submit'
    },

    /**
     * Default parameters
     */
    defaultParameters: function() {
        this.model.set({
            languageId    : 0,
            isApplyOption : false
        });
    },

    /**
     * HTML5 validate set off
     */
    html5validateOff: function() {
        this.$el.find('form').attr('novalidate', 'novalidate');
    },

    /**
     * Empty container
     */
    emptyContainer: function() {
        this.$el.empty();
    },

    /**
     * Set focus on first visible input
     */
    setFocusOnFirstInput: function() {
        this.$el.find('form :input:visible:first')
            .focus()
            .setCursorToTextEnd();
    },

    /**
     * Upload file button
     */
    uploadFileButton: function(e) {
        var button = $(e.currentTarget);

        var upload = button.parent().find('input[type="file"]');
        upload.click();

        upload.change(function() {
            button.parent().find('div.input_file').text($(this).val());
        });

        return false;
    },

    /**
     * CKEdit update element
     */
    ckeditUpdateElement: function() {
        if (this.$el.find('form div.cke').length > 0) {
            $.each(CKEDITOR.instances, function(index, val) {
                CKEDITOR.instances[index].updateElement();
            });
        }
    },

    /**
     * Helper
     */
    helper: function() {
        this.html5validateOff();
        this.addStarToRequiredFields();
        this.defaultSelectValue();
        beautifySelects();
        this.setFocusOnFirstInput();
    },

    /**
     * Add star to required fields
     */
    addStarToRequiredFields: function() {
        var star = '<span class="star">*</span>';

        $.each(this.$el.find('label.required'), function(index, val) {
            $(val).append(star);
        });
    },

    /**
     * Submit
     */
    submit: function() {
        var edit = this;

        this.$el.find('form').ajaxSubmit({
            type     : "post",
            dataType : 'json',
            data: {
                menuId    : edit.model.get('menuId'),
                sublistId : listModel.get('sublistId')
            },
            beforeSerialize: function() {
                edit.ckeditUpdateElement();
            },
            success: function(data) {
                if (data.response) {
                    notify('success', data.message);

                    if (edit.isMainEdit) {
                        if (!edit.model.get('isApplyOption')) {
                            listView.refresh(false);
                        }
                    }
                    else {
                        edit.closePopup();

                        if (menuId == 7) {
                            listView.refresh(false);
                        }
                    }
                }
                else {
                    edit.$el.html(data.view);

                    edit.helper();
                }

                edit.model.set({ isApplyOption: false });
            }
        });

        return false;
    },

    /**
     * Close popup
     */
    closePopup: function() {
        $('.popup').remove();
        $('.popup-overall-bg').remove();
    },

    /**
     * Render
     */
    render: function() {
        var edit = this;

        $.ajax({
            type     : "post",
            dataType : 'json',
            url      : edit.model.get('url'),
            data: {
                languageId : edit.model.get('languageId'),
                menuId     : edit.model.get('menuId'),
                sublistId  : listModel.get('sublistId')
            },
            beforeSend: function() {
                edit.emptyContainer();

                if (edit.isMainEdit) {
                    filterView.hideEl();
                    listView.$el.hide();
                    listView.paginationView.hideEl();
                }

                edit.$el.show();
                edit.showLoading();
            },
            complete: function() {
                edit.helper();

                if (edit.isMainEdit) {
                    mainButtonView.createEditButtons();
                    mainButtonView.toggleListMainButton();
                }

                edit.removeLoading();
            },
            success: function(data) {
                if (data.response) {
                    edit.$el.html(data.view.toString());
                }
            }
        });
    },

    /**
     * Default select value
     */
    defaultSelectValue: function() {
        $.each(this.$el.find('form select'), function(index, val) {
            if ($(val).attr('selected_id')) {
                var selected = $(val).attr('selected_id');

                $(val).find('option[selected="selected"]').removeAttr('selected');
                $(val).find('option[value="'+selected+'"]').attr('selected', 'selected');
            }
        });
    },

    /**
     * Set edit mode action
     */
    setEditModeAction: function() {
        var edit = this;

        $('.editMode').click(function(e) {
            edit.model.set({url: $(e.currentTarget).attr('href')});
            edit.render();

            return false;
        });
    },

    /**
     * Show loading
     */
    showLoading: function() {
        this.$el.append('<div class="loading"></div>');
    },

    /**
     * Remove loading
     */
    removeLoading: function() {
        this.$el.find('.loading').remove();
    },
});