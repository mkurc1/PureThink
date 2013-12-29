PaginationView = Backbone.View.extend({
    initialize: function() {
        console.log('Initialize Pagination View');
    },

    events: {
        "click #pagination_first"    : "firstPage",
        "click #pagination_last"     : "lastPage",
        "click #pagination_previous" : "previousPage",
        "click #pagination_next"     : "nextPage",
        "click .page"                : "changePage"
    },

    /**
     * Render paging
     *
     * @param array pages
     */
    render: function(pages) {
        this.$el.find('.pages').empty();

        for(i = 0; i < pages.length; i++) {
            if(pages[i] == this.model.get('page')) {
                this.$el.find('.pages').append('<span class="page" id="str_selected">' + pages[i] + '</span>');
            }
            else {
                this.$el.find('.pages').append('<span class="page">' + pages[i] + '</span>');
            }
        }
    },

    /**
     * Set page
     *
     * @param  integer page
     */
    page: function(page) {
        this.model.set({page: page});

        this.$el.find('.pages span').removeAttr('id');
        this.$el.find('.pages span').eq(page - 1).attr('id', 'str_selected');

        List.refresh(false);
    },

    /**
     * First page
     */
    firstPage: function() {
        if (this.model.get('page') != 1) {
            this.page(this.model.get('firstPage'));
        }
    },

    /**
     * Last page
     */
    lastPage: function() {
        if (this.model.get('page') != this.model.get('lastPage')) {
            this.page(this.model.get('lastPage'));
        }
    },

    /**
     * Previous page
     */
    previousPage: function() {
        if ((this.model.get('page') != this.model.get('previousPage')) && (this.model.get('previousPage') > 0)) {
            this.page(this.model.get('previousPage'));
        }
    },

    /**
     * Next page
     */
    nextPage: function() {
        if ((this.model.get('page') != this.model.get('nextPage')) && (this.model.get('nextPage') <= this.model.get('lastPage'))) {
            this.page(this.model.get('nextPage'));
        }
    },

    /**
     * Change page
     */
    changePage: function(e) {
        this.page($(e.currentTarget).text());
    },

    /**
     * Toggle pagination
     */
    togglePagination: function() {
        if (this.model.get('firstPage') != this.model.get('lastPage')) {
            this.showPagination();
        }
        else {
            this.hidePagination();
        }
    },

    /**
     * Show pagination
     */
    showPagination: function() {
        this.$el.find('.pagination').show();
    },

    /**
     * Hide pagination
     */
    hidePagination: function() {
        this.$el.find('.pagination').hide();
    }
});