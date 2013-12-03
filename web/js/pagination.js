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

    this.setPage = setPage;
    this.setFirstPage = setFirstPage;
    this.setLastPage = setLastPage;
    this.setPreviousPage = setPreviousPage;
    this.setNextPage = setNextPage;
    this.togglePagination = togglePagination;
    this.showPagination = showPagination;
    this.hidePagination = hidePagination;
    this.paging = paging;

    this.addActions = addActions;
    this.setActionOnChangePage = setActionOnChangePage;

    /**
     * Set page
     *
     * @param integer page
     */
    function setPage(page) {
        this.page = page;

        $('#str span').removeAttr('id');
        $('#str span').eq(page - 1).attr('id', 'str_selected');

        List.refresh(false);
    }

    /**
     * Set first page
     */
    function setFirstPage() {
        if (this.page != 1) {
            this.setPage(this.firstPage);
        }
    }

    /**
     * Set last page
     */
    function setLastPage() {
        if (this.page != this.lastPage) {
            this.setPage(this.lastPage);
        }
    }

    /**
     * Set previous page
     */
    function setPreviousPage() {
        if ((this.page != this.previousPage) && (this.previousPage > 0)) {
            this.setPage(this.previousPage);
        }
    }

    /**
     * Set next page
     */
    function setNextPage() {
        if ((this.page != this.nextPage) && (this.nextPage <= this.lastPage)) {
            this.setPage(this.nextPage);
        }
    }

    /**
     * Paging
     *
     * @param array pages
     */
    function paging(pages) {
        $('#str span').remove();

        for(i = 0; i < pages.length; i++) {
            if(pages[i] == this.page) {
                $('#str').append('<span id="str_selected">' + pages[i] + '</span>');
            }
            else {
                $('#str').append('<span>' + pages[i] + '</span>');
            }
        }

        this.setActionOnChangePage();
    }

    /**
     * Toggle pagination
     */
    function togglePagination() {
        if (this.firstPage != this.lastPage) {
            this.showPagination();
        }
        else {
            this.hidePagination();
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
     * Add actions
     */
    function addActions() {
        var pagination = this;

        $('#pagination_first').click(function() {
            pagination.setFirstPage();
        });

        $('#pagination_last').click(function() {
            pagination.setLastPage();
        });

        $('#pagination_previous').click(function() {
            pagination.setPreviousPage();
        });

        $('#pagination_next').click(function() {
            pagination.setNextPage();
        });
    }

    /**
     * Set action on change page
     */
    function setActionOnChangePage() {
        var pagination = this;

        $('#str span').click(function() {
            pagination.setPage($(this).text());
        });
    }
}