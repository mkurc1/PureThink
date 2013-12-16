/**
 * Object Edit Cunstructor
 */
function Edit() {
    this.url;
    this.languageId;
    this.isApplyOption;

    this.setDefaultParameters = setDefaultParameters;
    this.html5validateOff = html5validateOff;
    this.emptyEditContainer = emptyEditContainer;
    this.getEdit = getEdit;
    this.submitAction = submitAction;
    this.ckeditUpdateElement = ckeditUpdateElement;
    this.setEditAction = setEditAction;
    this.setFocusOnFirstInput = setFocusOnFirstInput;
    this.setActionOnUploadFileButtons = setActionOnUploadFileButtons;

    /**
     * Set default parameters
     */
    function setDefaultParameters() {
        this.languageId = 0;
        this.isApplyOption = false;
    }

    /**
     * HTML5 validate set off
     */
    function html5validateOff() {
        $('#edit_container > .container > form').attr('novalidate', 'novalidate');
    }

    /**
     * Empty edit container
     */
    function emptyEditContainer() {
        $('#edit_container').empty();
    }

    /**
     * Set focus on first visible input
     */
    function setFocusOnFirstInput() {
        var input = $('#edit_container form :input:visible:first');
        input.focus();
        input.setCursorToTextEnd();
    }

    /**
     * Set action on upload file buttons
     */
    function setActionOnUploadFileButtons() {
        $('#edit_container > .container').on('click', 'button.browse', function() {
            var button = $(this);

            var upload = $(this).parent().find('input[type="file"]');
            upload.click();

            upload.change(function() {
                button.parent().find('div.input_file').text($(this).val());
            });

            return false;
        });
    }

    /**
     * Get edit
     */
    function getEdit() {
        var edit = this;

        $.ajax({
            type: "post",
            dataType: 'json',
            url: edit.url,
            data: {
                languageId: edit.languageId,
                menuId: menuId
            },
            beforeSend: function() {
                edit.emptyEditContainer();
            },
            complete: function() {
                $('#main_container').hide();
                $('#edit_container').show();

                Pagination.hidePagination();
                edit.html5validateOff();
                beautifySelects();
                submitAction();
                createEditButtons();
                toggleListMainButton();
                edit.setActionOnUploadFileButtons();
                edit.setFocusOnFirstInput();
            },
            success: function(data) {
                if (data.response) {
                    $('#edit_container').html(data.view.toString());
                }
            }
        });
    }

    /**
     * Submit action
     */
    function submitAction() {
        $('#edit_container > .container').on('submit', 'form', function() {
            $(this).ajaxForm({
                type: "post",
                dataType: 'json',
                data: {
                    menuId: menuId,
                    sublistId: List.sublistId
                },
                beforeSerialize: function() {
                    Edit.ckeditUpdateElement();
                },
                success: function(data) {
                    if (data.response) {
                        notify('success', data.message);

                        if (Edit.isApplyOption) {
                            Edit.getEdit();
                        }
                        else {
                            List.refresh(false);
                        }
                    }
                    else {
                        $('#edit_container').html(data.view);
                        Edit.html5validateOff();
                        beautifySelects();
                        Edit.submitAction();
                    }

                    Edit.isApplyOption = false;
                }
            });

            $(this).submit();

            return false;
        });
    }

    /**
     * CKEdit update element
     */
    function ckeditUpdateElement() {
        if ($('#edit_container > .container > form').find('div.cke').length > 0) {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
        }
    }

    /**
     * Set edit action
     */
    function setEditAction() {
        var edit = this;

        $('.editMode').click(function() {
            edit.url = $(this).attr('href');
            edit.getEdit();

            return false;
        });
    }
}