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
     * Get edit
     */
    function getEdit() {
        var edit = this;

        $.ajax({
            type: "post",
            dataType: 'json',
            url: edit.url,
            data: {
                languageId: edit.languageId
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
                if (!Edit.isApplyOption) {
                    submitAction();
                }
                createEditButtons();
                toggleListMainButton();
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
            Edit.ckeditUpdateElement();

            $.ajax({
                type: "post",
                dataType: 'json',
                data: $(this).serialize(),
                url: $(this).attr('action'),
                beforeSend: function() {
                },
                complete: function(data) {
                    if (!data.response) {
                        Edit.html5validateOff();
                        beautifySelects();
                        Edit.submitAction();
                    }

                    Edit.isApplyOption = false;
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
                    }
                }
            });

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