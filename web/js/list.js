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
 * Empty filtr
 */
function emptyFiltr() {
    $('#search_box > input').val('');
}

/**
 * Show pagination
 */
function showPagination() {
    if (ListPagination.firstPage != ListPagination.lastPage) {
        $('#pagination > .pagination').show();
    }
    else {
        $('#pagination > .pagination').hide();
    }
}

/**
 * Set Default parameters
 */
function setDefaultParameters() {
    List.order = 'a.name';
    List.sequence = 'ASC';
    List.filtr = '';
    List.groupId = '';
    List.languageId = '';
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
            filtr: List.filtr
        },
        url: List.url,
        beforeSend: function() {
            emptyList();
        },
        complete: function() {
            arrowOrder();
            setActionOnChangeOrder();
            showPagination();
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