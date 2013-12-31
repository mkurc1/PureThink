EditView = Backbone.View.extend({
    initialize: function() {
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
        this.$el.find('.container > form').attr('novalidate', 'novalidate');
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
        if (this.$el.find('> .container > form').find('div.cke').length > 0) {
            $.each(CKEDITOR.instances, function(index, val) {
                CKEDITOR.instances[index].updateElement();
            });
        }
    },

    /**
     * Submit
     */
    submit: function() {
        var edit = this;

        this.$el.find('form').ajaxSubmit({
            type: "post",
            dataType: 'json',
            data: {
                menuId: menuId,
                sublistId: List.sublistId
            },
            beforeSerialize: function() {
                edit.ckeditUpdateElement();
            },
            success: function(data) {
                if (data.response) {
                    notify('success', data.message);

                    if (!edit.model.get('isApplyOption')) {
                        List.refresh(false);
                    }
                }
                else {
                    edit.$el.html(data.view);

                    edit.html5validateOff();
                    edit.defaultSelectValue();
                    beautifySelects();
                }

                edit.model.set({isApplyOption: false});
            }
        });

        return false;
    },

    /**
     * Render
     */
    render: function() {
        var edit = this;

        $.ajax({
            type: "post",
            dataType: 'json',
            url: edit.model.get('url'),
            data: {
                languageId: edit.model.get('languageId'),
                menuId: menuId,
                sublistId: List.sublistId
            },
            beforeSend: function() {
                edit.emptyContainer();
            },
            complete: function() {
                $('#main_container').hide();
                edit.$el.show();

                paginationListView.hidePagination();
                edit.html5validateOff();
                edit.defaultSelectValue();
                beautifySelects();
                createEditButtons();
                toggleListMainButton();
                edit.setFocusOnFirstInput();

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
        $.each(this.$el.find('> .container > form select'), function(index, val) {
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
    }
});