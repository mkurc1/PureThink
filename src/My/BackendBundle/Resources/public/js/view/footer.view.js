FooterView = Backbone.View.extend({
    events: {
        "click #left_menu_toggle"               : "toggleLeftMenu",
        "change #pagination > .number_of_lines" : "changeRowsOnPage"
    },

    /**
     * Toggle left menu
     */
    toggleLeftMenu: function(e) {
        $('#left_menu').toggle();
        $(e.currentTarget).toggleClass('hide_menu');
        $('#main').toggleClass('hide_menu');
        $('#pagination_count').toggleClass('hide_menu');
    },

    /**
     * Change rows on page
     */
    changeRowsOnPage: function(e) {
        listView.paginationModel.set({ 'rowsOnPage': $(e.currentTarget).val() });
        listView.paginationModel.set({ page: 1 });
        this.setRowsOnPage();
        listView.refresh();
    },

    /**
     * Get rows on page
     *
     * @param integer rowsOnPageId
     */
    getRowsOnPage: function(rowsOnPageId) {
        var rows = this;

        $.ajax({
            type     : "post",
            dataType : "json",
            url      : Routing.generate('my_backend_rowsonpage_getrowsonpage'),
            data: {
                rowsOnPageId: userSettingModel.get('rowsOnPageId')
            },
            complete: function() {
                listView.paginationModel.set({ 'rowsOnPage': rows.$el.find("#pagination > .number_of_lines").val() });
                rows.addBeautifySelect();
            },
            success: function(data) {
                if (data.response) {
                    rows.$el.find('#pagination').append(data.rows.toString());
                }
            }
        });
    },

    /**
     * Add beautify select
     */
    addBeautifySelect: function() {
        if (listView.paginationView.isPaginationVisible()) {
            beautifySelects();
        }
        else {
            listView.paginationView.showEl();
            beautifySelects();
            listView.paginationView.hideEl();
        }
    },

    /**
     * Set rows on page
     */
    setRowsOnPage: function() {
        $.ajax({
            type     : "post",
            dataType : "json",
            url      : Routing.generate('my_user_usersetting_setrowsonpage'),
            data: {
                rowsOnPage: listView.paginationModel.get('rowsOnPage')
            },
            success: function(data) {
                if (data.response) {
                    userSettingModel.set({ rowsOnPageId: data.row_id });
                }
            }
        });
    }
});