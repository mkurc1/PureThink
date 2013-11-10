var listUrl;

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
    this.rowsOnPage = rowsOnPage;
}

ListPagination = new Pagination(10);

var groupId;
var order;
var sequence;
var filtr;

$(function() {
    setDefaultParameters();

    refreshList();

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
 * Set Default parameters
 */
function setDefaultParameters() {
    order = 'a.name';
    sequence = 'ASC';
    filtr = '';
    groupId = '';
    ListPagination.page = 1;
}

/**
 * Set list URL
 */
function setListUrl() {
    listUrl = $('#main_menu_list > li.selected > a').attr('href');
}

/**
 * Refresh list
 */
function refreshList() {
    getList();
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

    refreshList();
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

        refreshList();
    });
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
            order: order,
            sequence: sequence
        },
        url: listUrl,
        beforeSend: function() {
            emptyList();
        },
        complete: function() {
        },
        success: function(data) {
            if (data.response) {
                emptyList();
                $('#main_container').append(data.list.toString());

                ListPagination.firstPage = data.pagination.first_page;
                ListPagination.previousPage = data.pagination.previous;
                ListPagination.nextPage = data.pagination.next;
                ListPagination.lastPage = data.pagination.last_page;

                arrowOrder();

                paging(data.pagination.pages);

                setActionOnChangeOrder();
            }
        }
    });
}

/**
 * set arrow order
 */
function arrowOrder() {
    $('th[column*="' + order + '"]').append('<img class="order" src="/images/arrow_'+sequence.toLowerCase()+'.png" />');
}

/**
 * Set action on change order
 */
function setActionOnChangeOrder() {
    $('th').click(function() {
        var column = $(this).attr('column')

        if (typeof(column) !== "undefined") {
            if (order != column)
                order = column;
            else
            if (sequence == "ASC")
                sequence = "DESC";
            else
                sequence = "ASC";

            refreshList();
        }
    });
}