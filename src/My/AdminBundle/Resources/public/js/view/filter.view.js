FilterView = Backbone.View.extend({
    events: {
        "keyup input": "search"
    },

    search: function(e) {
        var search = this;
        if (search.timer) {
            clearTimeout(search.timer);
        }

        search.timer = setTimeout(function() {
            search.timer = null;

            listModel.set({ filter: $(e.currentTarget).val() });
            listView.render();
        }, 800);
    },

    empty: function() {
        this.$el.find('input').val('');
    },

    hideEl: function() {
        this.$el.hide();
    },

    showEl: function() {
        this.$el.show();
    }
});