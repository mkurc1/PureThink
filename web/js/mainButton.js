$(function() {
    $('#main_button > div > #create').click(function() {
        editMode(List.url+'new');
    });
});

/**
 * Set action on list main buttons
 */
function setActionOnListMainButtons() {
    $('#main_button > div > .refresh').click(function() {
        refreshList(true);
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
}

/**
 * Set action on edit main buttons
 */
function setActionOnEditMainButtons() {
    $('#main_button > div > .cancel').click(function() {
        createListButtons();
        toggleListMainButton();
        listMode();
    });

    $('#main_button > div > .apply').click(function() {

    });

    $('#main_button > div > .save').click(function() {
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
         $('#main_button > .center').append(val);
    });
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