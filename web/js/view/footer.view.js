FooterView = Backbone.View.extend({
    events: {
        "click #left_menu_toggle": "toggleLeftMenu"
    },

    /**
     * Toggle left menu
     */
    toggleLeftMenu: function(e) {
        $('#left_menu').toggle();
        $(e.currentTarget).toggleClass('hide_menu');
        $('#main').toggleClass('hide_menu');
        $('#pagination_count').toggleClass('hide_menu');
    }
});