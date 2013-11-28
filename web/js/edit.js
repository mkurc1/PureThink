/**
 * Hide edit container
 */
function hideEditContainer() {
    $('#edit_container').hide();
}

/**
 * Edit mode - AJAX
 */
function editModeAjax() {
    $('.editMode').click(function() {
        editMode($(this).attr('href'));

        return false;
    });
}

/**
 * Set edit mode
 *
 * @param string url
 */
function editMode(url) {
    $.post(url, function(data) {
        $('#edit_container').html(data);
    })
    .error(function() {
        alert('Wystąpił błąd!');
    })
    .success(function() {
        $('#main_container').hide();
        $('#edit_container').show();

        hidePagination();
        beautifySelects();
        submitAction();
    })
}

/**
 * CKEdit update element
 */
function ckeditUpdateElement() {
    for (instance in CKEDITOR.instances)
    {
        CKEDITOR.instances[instance].updateElement();
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
            complete: function() {
            },
            success: function(data) {
                if (data.response) {
                    notify('success', data.message);
                    listMode();
                    refreshList(false);
                }
                else {
                    $('#edit_container').html(data);
                }
            }
        });

        return false;
    });
}