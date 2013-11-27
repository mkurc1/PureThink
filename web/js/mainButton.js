$(function() {
    $('#main_button > div > .refresh').click(function() {
        refreshList(true);
    });

    $('#main_button > div > #create').click(function() {
        editMode(List.url+'new');
    });

    $('#main_button > div > .edit').click(function() {
        if (!$(this).hasClass('disable')) {
            var listId = List.select[0];
            var editUrl = $('#main_container > table > tbody tr[list_id="'+listId+'"]').find('.editMode').attr('href');

            editMode(editUrl);
        }
    });

    $('#main_button > div > .remove').click(function() {
        if (!$(this).hasClass('disable')) {
            deleteFromList();
        }
    });
});

/**
 * Toggle main button
 */
function toggleMainButton() {
    switch(List.select.length) {
        case 0:
            disableMainButtonEdit();
            disableMainButtonRemove();
            break;
        case 1:
            enableMainButtonEdit();
            enableMainButtonRemove();
            break;
        default:
            disableMainButtonEdit();
            enableMainButtonRemove();
            break;
    }
}

/**
 * Enable main button edit
 */
function enableMainButtonEdit() {
    $('#main_button > div > .edit').removeClass('disable');
}

/**
 * Disable main button edit
 */
function disableMainButtonEdit() {
    $('#main_button > div > .edit').addClass('disable');
}

/**
 * Enable main button remove
 */
function enableMainButtonRemove() {
    $('#main_button > div > .remove').removeClass('disable');
}

/**
 * Disable main button remove
 */
function disableMainButtonRemove() {
    $('#main_button > div > .remove').addClass('disable');
}