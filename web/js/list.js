/**
 * Object List Cunstructor
 */
function List() {
    this.groupId;
    this.laguageId;
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

/**
 * Object Pagination Constructior
 *
 * @param integer rowsOnPage
 */
function Pagination(rowsOnPage) {
    this.page = 1;
    this.start = 0;
    this.end = 0;
    this.firstPage = 0;
    this.lastPage = 0;
    this.previousPage = 0;
    this.nextPage = 0;
    this.totalCount = 0;
    this.rowsOnPage = rowsOnPage;
}

ListPagination = new Pagination(10);
List = new List();

$(function() {
    setDefaultParameters();

    refreshList(true);

    $('#search_box > input').keyup(function() {
        List.filtr = $(this).val();
        refreshList();
    });

    $('#pagination_first').click(function() {
        if (ListPagination.page != 1)
            setPage(ListPagination.firstPage);
    });

    $('#pagination_last').click(function() {
        if (ListPagination.page != ListPagination.lastPage)
            setPage(ListPagination.lastPage);
    });

    $('#pagination_previous').click(function() {
        if ((ListPagination.page != ListPagination.previousPage) && (ListPagination.previousPage > 0))
            setPage(ListPagination.previousPage);
    });

    $('#pagination_next').click(function() {
        if ((ListPagination.page != ListPagination.nextPage) && (ListPagination.nextPage <= ListPagination.lastPage))
            setPage(ListPagination.nextPage);
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

        toggleMainButton();
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
 * Toggle pagination
 */
function togglePagination() {
    if (ListPagination.firstPage != ListPagination.lastPage) {
        showPagination();
    }
    else {
        hidePagination();
    }
}

/**
 * Show pagination
 */
function showPagination() {
    $('#pagination > .pagination').show();
}

/**
 * Hide pagination
 */
function hidePagination() {
    $('#pagination > .pagination').hide();
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
    ListPagination.page = 1;

    emptyFiltr();
}

/**
 * Set list URL
 */
function setListUrl() {
    List.url = $('#main_menu_list > li.selected > a').attr('href');
}

/**
 * Refresh list
 *
 * @param boolean withLeftMenu
 */
function refreshList(withLeftMenu) {
    List.emptySelect();
    getList();

    if (withLeftMenu)
        getLeftMenu();
}

/**
 * Empty list
 */
function emptyList() {
    $('#main_container').empty();
}

/**
 * Set page
 *
 * @param integer str
 */
function setPage(str) {
    ListPagination.page = str;

    $('#str span').removeAttr('id');
    $('#str span').eq(str - 1).attr('id', 'str_selected');

    refreshList(false);
}

/**
 * Paging
 *
 * @param array pages
 */
function paging(pages) {
    $('#str span').remove();

    for(i = 0; i < pages.length; i++) {
        if(pages[i] == ListPagination.page)
            $('#str').append('<span id="str_selected">' + pages[i] + '</span>');
        else
            $('#str').append('<span>' + pages[i] + '</span>');
    }

    setActionOnChangePage();
}

/**
 * Set action on change page
 */
function setActionOnChangePage() {
    $('#str span').click(function() {
        ListPagination.page = $(this).text();
        $('#str span').removeAttr('id');
        $(this).attr('id', 'str_selected');

        refreshList(false);
    });
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
            rowsOnPage: ListPagination.rowsOnPage,
            page: ListPagination.page,
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
            togglePagination();
            editModeAjax();
            checkboxChangeAction();
            toggleMainButton();
            removeLoading();
        },
        success: function(data) {
            if (data.response) {
                emptyList();
                $('#main_container').append(data.list.toString());

                ListPagination.firstPage = data.pagination.first_page;
                ListPagination.previousPage = data.pagination.previous;
                ListPagination.nextPage = data.pagination.next;
                ListPagination.lastPage = data.pagination.last_page;
                ListPagination.totalCount = data.pagination.total_count;

                paging(data.pagination.pages);
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
                refreshList(false);
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