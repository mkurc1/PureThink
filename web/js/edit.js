/**
 * Object Edit Cunstructor
 */
function Edit() {
    this.url;
    this.languageId;
}

var Edit = new Edit();

/**
 * Set default parameters on edit
 */
function setDefaultParametersOnEdit() {
    Edit.languageId = 0;
}

/**
 * Set edit URL
 *
 * @param string url
 */
function setEditUrl(url) {
    Edit.url = url;
}

/**
 * Hide edit container
 */
function hideEditContainer() {
    $('#edit_container').hide();
}

/**
 * Empty edit container
 */
function emptyEditContainer() {
    $('#edit_container').empty();
}

/**
 * Edit mode - AJAX
 */
function editModeAjax() {
    $('.editMode').click(function() {
        setEditUrl($(this).attr('href'));
        editMode();

        return false;
    });
}

/**
 * Set edit mode
 */
function editMode() {
    $.ajax({
        type: "post",
        dataType: 'json',
        url: Edit.url,
        data: {
            languageId: Edit.languageId
        },
        beforeSend: function() {
            emptyEditContainer();
        },
        complete: function() {
            $('#main_container').hide();
            $('#edit_container').show();

            hidePagination();
            html5validateOff();
            beautifySelects();
            submitAction();
            createEditButtons();
        },
        success: function(data) {
            if (data.response) {
                $('#edit_container').html(data.view.toString());
            }
        }
    });
}

/**
 * HTML5 validate set off
 */
function html5validateOff() {
    $('#edit_container > .container > form').attr('novalidate', 'novalidate');
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
 * Submit action
 */
function submitAction() {
    $('#edit_container > .container > form').submit(function() {
        ckeditUpdateElement();

        $.ajax({
            type: "post",
            dataType: 'json',
            data: $(this).serialize(),
            url: $(this).attr('action'),
            beforeSend: function() {
            },
            complete: function(data) {
                if (!data.response) {
                    html5validateOff();
                    beautifySelects();
                    submitAction();
                }
            },
            success: function(data) {
                if (data.response) {
                    notify('success', data.message);
                    listMode();
                    refreshList(false);
                }
                else {
                    $('#edit_container').html(data.view);
                }
            }
        });

        return false;
    });
}