$(function() {
    $('#main_button > div > #create').click(function() {
        setEditUrl(List.url+'new');
        editMode();
    });
});

/**
 * Set action on list main buttons
 */
function setActionOnListMainButtons() {
    $('#main_button > div > div > .refresh').click(function() {
        refreshList(true);
    });

    $('#main_button > div > div > .edit').click(function() {
        if (!$(this).parent().hasClass('disable')) {
            var listId = List.select[0];
            var editUrl = $('#main_container > table > tbody tr[list_id="'+listId+'"]').find('.editMode').attr('href');

            setEditUrl(editUrl);
            editMode();
        }
    });

    $('#main_button > div > div > .remove').click(function() {
        if (!$(this).parent().hasClass('disable')) {
            deleteFromList();
        }
    });
}

/**
 * Set action on edit main buttons
 */
function setActionOnEditMainButtons() {
    $('#main_button > div > div > .cancel').click(function() {
        createListButtons();
        toggleListMainButton();
        togglePagination();
        listMode();
    });

    $('#main_button > div > div > .apply').click(function() {

    });

    $('#main_button > div > div > .save').click(function() {
        $('#edit_container > .container > form').submit();
    });
}

/**
 * Toggle lsit main button
 */
function toggleListMainButton() {
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
 * Remove main buttons
 */
function removeMainButtons() {
    $('#main_button > .center').empty();
}

/**
 * Create list buttons
 */
function createListButtons() {
    removeMainButtons();

    var buttons = {
        'select'  : '<button class="select"></button>',
        'refresh' : '<button class="refresh"></button>',
        'edit'    : '<button class="edit"></button>',
        'remove'  : '<button class="remove"></button>',
        'more'    : '<button class="more"></button>'
    };

    addMainButtons(buttons);
    setActionOnListMainButtons();
}

/**
 * Create edit buttons
 */
function createEditButtons() {
    removeMainButtons();

    var buttons = {
        'cancel' : '<button class="cancel"></button>',
        'apply'  : '<button class="apply"></button>',
        'save'   : '<button class="save"></button>'
    };

    addMainButtons(buttons);
    setActionOnEditMainButtons();
}

/**
 * Add main buttons
 *
 * @param array tab
 */
function addMainButtons(tab) {
    $.each(tab, function(index, val) {
         $('#main_button > .center').append('<div class="button_container">'+val+'</div>');
    });
}

/**
 * Enable main button edit
 */
function enableMainButtonEdit() {
    $('#main_button > div > div > .edit').parent().removeClass('disable');
}

/**
 * Disable main button edit
 */
function disableMainButtonEdit() {
    $('#main_button > div > div > .edit').parent().addClass('disable');
}

/**
 * Enable main button remove
 */
function enableMainButtonRemove() {
    $('#main_button > div > div > .remove').parent().removeClass('disable');
}

/**
 * Disable main button remove
 */
function disableMainButtonRemove() {
    $('#main_button > div > div > .remove').parent().addClass('disable');
}