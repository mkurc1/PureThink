FilterView = Backbone.View.extend({
    events: {
        "keyup input": "search"
    },

    /**
     * Search
     */
    search: function(e) {
        var search = this;
        if (search.timer) {
            clearTimeout(search.timer);
        }

        search.timer = setTimeout(function() {
            search.timer = null;

            listModel.set({ filtr: $(e.currentTarget).val() });
            listView.render();
        }, 800);
    },

    /**
     * Empty
     */
    empty: function() {
        this.$el.find('input').val('');
    },

    /**
     * Hide element
     */
    hideEl: function() {
        this.$el.hide();
    },

    /**
     * Show element
     */
    showEl: function() {
        this.$el.show();
    }
});