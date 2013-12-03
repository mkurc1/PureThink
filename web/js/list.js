/**
 * Object List Cunstructor
 */
function List() {
    this.groupId;
    this.languageId;
    this.order;
    this.sequence;
    this.filtr;
    this.url;
    this.select = new Array();
    this.addToSelect = addToSelect;
    this.removeFromSelect = removeFromSelect;
    this.emptySelect = emptySelect;

    /**
     * Add to select
     *
     * @param integer id
     */
    function addToSelect(id) {
        this.select.push(id);
    }

    /**
     * Remove from select
     *
     * @param integer id
     */
    function removeFromSelect(id) {
        var i = this.select.indexOf(id);
        if(i != -1) {
            this.select.splice(i, 1);
        }
    }

    /**
     * Empty select
     */
    function emptySelect() {
        this.select.clear();
    }
}

Pagination = new Pagination(10);

List = new List();

$(function() {
    Pagination.addActions();

    $('#search_box > input').keyup(function() {
        var search = this;
        if (search.timer) {
            clearTimeout(search.timer);
        }

        search.timer = setTimeout(function() {
            search.timer = null;

            List.filtr = search.value;
            refreshList();
        }, 800);
    });
});

/**
 * Checkbox change action
 */
function checkboxChangeAction() {
    $('tr > td.select > input.multi_check').click(function() {
        var selectId = $(this).parent().parent().attr('list_id');

        if ($(this).is(':checked')) {
            List.addToSelect(selectId);
        }
        else {
            List.removeFromSelect(selectId);
        }

        toggleListMainButton();
    });
}

/**
 * Show loading
 */
function showLoading() {
    $('#main_container').append('<div class="loading"></div>');
}

/**
 * Remove loading
 */
function removeLoading() {
    $('.loading').remove();
}

/**
 * Empty filtr
 */
function emptyFiltr() {
    $('#search_box > input').val('');
}

/**
 * Set Default parameters
 */
function setDefaultParameters() {
    List.order = 'a.name';
    List.sequence = 'ASC';
    List.filtr = '';
    List.groupId = 0;
    List.languageId = 0;
    Pagination.page = 1;

    emptyFiltr();
}

/**
 * Set list URL
 *
 * @param string url
 */
function setListUrl(url) {
    List.url = url;
}

/**
 * Refresh list
 *
 * @param boolean withLeftMenu
 */
function refreshList(withLeftMenu) {
    List.emptySelect();
    createListButtons();

    if (withLeftMenu) {
        setDefaultParameters();
        getLeftMenu(false);
    }

    getList();
}

/**
 * Empty list
 */
function emptyList() {
    $('#main_container').empty();
}

/**
 * Set list mode
 */
function listMode() {
    $('#main_container').show();
    $('#edit_container').empty().hide();
}

/**
 * Get list
 */
function getList() {
    $.ajax({
        type: "post",
        dataType: 'json',
        data: {
            rowsOnPage: Pagination.rowsOnPage,
            page: Pagination.page,
            order: List.order,
            sequence: List.sequence,
            filtr: List.filtr,
            languageId: List.languageId,
            groupId: List.groupId
        },
        url: List.url,
        beforeSend: function() {
            listMode();
            emptyList();
            showLoading();
        },
        complete: function() {
            arrowOrder();
            setActionOnChangeOrder();
            Pagination.togglePagination();
            editModeAjax();
            checkboxChangeAction();
            toggleListMainButton();
            removeLoading();
        },
        success: function(data) {
            if (data.response) {
                emptyList();
                $('#main_container').append(data.list.toString());

                Pagination.firstPage = data.pagination.first_page;
                Pagination.previousPage = data.pagination.previous;
                Pagination.nextPage = data.pagination.next;
                Pagination.lastPage = data.pagination.last_page;
                Pagination.totalCount = data.pagination.total_count;

                Pagination.paging(data.pagination.pages);
            }
        }
    });
}

/**
 * Delete from list
 */
function deleteFromList() {
    $.ajax({
        type: "post",
        dataType: 'json',
        data: {
            arrayId: List.select
        },
        url: List.url+'delete',
        beforeSend: function() {
        },
        complete: function() {

        },
        success: function(data) {
            if (data.response) {
                notify('success', data.message);
                refreshList(false);
            }
            else {
                notify('fail', data.message);
            }
        }
    });
}

/**
 * set arrow order
 */
function arrowOrder() {
    $('th[column*="' + List.order + '"]').append('<img class="order" src="/images/arrow_'+List.sequence.toLowerCase()+'.png" />');
}

/**
 * Set action on change order
 */
function setActionOnChangeOrder() {
    $('th').click(function() {
        var column = $(this).attr('column')

        if (typeof(column) !== "undefined") {
            if (List.order != column)
                List.order = column;
            else
            if (List.sequence == "ASC")
                List.sequence = "DESC";
            else
                List.sequence = "ASC";

            refreshList(false);
        }
    });
}