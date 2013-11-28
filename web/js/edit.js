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
        submitAction();
    })
}

function submitAction() {
    $('#edit_container > .container > form').submit(function() {
        for (instance in CKEDITOR.instances)
        {
            CKEDITOR.instances[instance].updateElement();
        }

        $.ajax({
            type: "post",
            dataType: 'html',
            data: $(this).serialize(),
            url: $(this).attr('action'),
            beforeSend: function() {
            },
            complete: function() {
            },
            success: function(data) {
                if (data.response) {
                    if (data != "0") {
                        $('#edit_container').html(data);
                    }
                    else {
                        listMode();
                        refreshList(false);
                    }
                }
            }
        });

        // var request = $.ajax({
        //     url: $(this).attr('action'),
        //     type: "POST",
        //     data: $(this).serialize(),
        //     dataType: "html"
        // });

        // request.done(function(msg) {
        //     if (msg != "0") {
        //         $('#edit_container').html(msg);
        //     }
        //     else {
        //         listMode();
        //         refreshList(false);
        //     }
        // });

        // request.fail(function(jqXHR, textStatus) {
        //     alert("Request failed: " + textStatus);
        // });

        return false;
    });
}