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
    $('.editMode').click(function(){
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
    $.post(url, function(data){
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
    $('#edit_container > .container > form').submit(function(){
        var request = $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            dataType: "html"
        });

        request.done(function(msg) {
            if (msg != "0") {
                $('#edit_container').html(msg);
            }
            else {
                listMode();
                refreshList(false);
            }
        });

        request.fail(function(jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });

        return false;
    });
}