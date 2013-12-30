$(function() {
    $('#main_button > div').on('click', '#create', function() {
        if (!$(this).parent().hasClass('disable')) {
            Edit.url = List.url+'new';
            Edit.getEdit();
        }
    });
});

/**
 * Set action on list main buttons
 */
function setActionOnListMainButtons() {
    $('#main_button > div > div').on('click', '.refresh', function() {
        List.refresh(true);
    });

    $('#main_button > div > div').on('click', '.edit', function() {
        if (!$(this).parent().hasClass('disable')) {
            var listId = List.select[0];

            var editObject = $('#main_container > table > tbody tr[list_id="'+listId+'"]');
            var editUrl;

            if (editObject.find('.editMode').length > 0) {
                editUrl = editObject.find('.editMode').attr('href');
            }
            else {
                editUrl = List.url+listId+'/edit';
            }

            Edit.url = editUrl;
            Edit.getEdit();
        }
    });

    $('#main_button > div > div').on('click', '.remove', function() {
        if (!$(this).parent().hasClass('disable')) {
            var confirmationText;
            if (List.getCountSelect() > 1) {
                confirmationText = 'Czy napewno chcesz usunąć wybrane pozycje?';
            }
            else {
                confirmationText = 'Czy napewno chcesz usunąć wybraną pozycje?';
            }

            var confirmation = confirm(confirmationText);
            if(confirmation) {
                List.removeElements();
            }
        }
    });
}

/**
 * Set action on edit main buttons
 */
function setActionOnEditMainButtons() {
    $('#main_button > div > div').on('click', '.cancel', function() {
        if (isEditMode(getMainMenuUrl())) {
            Edit.getEdit();
        }
        else {
            createListButtons();
            toggleListMainButton();
            paginationListView.togglePagination();
            List.setMode();
        }
    });

    $('#main_button > div > div').on('click', '.apply', function() {
        Edit.isApplyOption = true;

        $('#edit_container > .container > form').submit();
    });

    $('#main_button > div > div').on('click', '.save', function() {
        if (!$(this).parent().hasClass('disable')) {
            Edit.isApplyOption = false;

            $('#edit_container > .container > form').submit();
        }
    });
}

/**
 * Toggle list main button
 */
function toggleListMainButton() {
    if (isEditMode(getMainMenuUrl())) {
        toggleListMainButtonForEditMode();
    }
    else {
        toggleListMainButtonForListMode();
    }
}

/**
 * Toggle list main button for list mode
 */
function toggleListMainButtonForListMode() {
    enableMainButtonCreate();

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
 * Toggle list main button for edit mode
 */
function toggleListMainButtonForEditMode() {
    disableMainButtonSave();
    disableMainButtonCreate();
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

/**
 * Disable main button save
 */
function disableMainButtonSave() {
    $('#main_button > div > div > .save').parent().addClass('disable');
}

/**
 * Disable main button create
 */
function disableMainButtonCreate() {
    $('#main_button > div > #create').parent().addClass('disable');
}

/**
 * Enable main button create
 */
function enableMainButtonCreate() {
    $('#main_button > div > #create').parent().removeClass('disable');
}