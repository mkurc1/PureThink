MainMenuView = Backbone.View.extend({
    events: {
        "click > li > a" : "setMenu"
    },

    /**
     * Render
     */
    render: function() {
        var menu = this;

        $.ajax({
            type     : "post",
            dataType : 'json',
            url      : links.mainMenu,
            data: {
                moduleId: userSettingModel.get('moduleId')
            },
            beforeSend: function() {
                menu.emptyContainer();
            },
            complete: function() {
                menu.selectFirstMenu();
            },
            success: function(data) {
                if (data.response) {
                    menu.$el.append(data.menu.toString());
                }
            }
        });
    },

    /**
     * Empty container
     */
    emptyContainer: function() {
        this.$el.empty();
    },

    /**
     * Select first menu
     */
    selectFirstMenu: function() {
        this.$el.find('> li').eq(0).addClass('selected');
        this.setMenuId();
        this.startMode();
    },

    /**
     * Start mode
     */
    startMode: function() {
        var url = this.getMainMenuUrl();

        if (this.isEditMode(url)) {
            editModel.set({url: url});
            leftMenuView.render(true);
            editView.defaultParameters();
            editView.render();
        }
        else {
            listModel.set({ url: url });
            listView.sublistId = 0;
            listView.refresh(true);
        }
    },

    /**
     * Get main menu URL
     *
     * @return string
     */
    getMainMenuUrl: function() {
        return this.$el.find('> li.selected > a').attr('href');
    },

    /**
     * Get mode by menu URL
     *
     * @param string url
     * @return boolean
     */
    isEditMode: function(url) {
        var pathArray = url.split('/');
        var temp = pathArray[pathArray.length-2];

        if (temp == 'edit') {
            return true;
        }
        else {
            return false;
        }
    },

    /**
     * Set menu Id
     */
    setMenuId: function() {
        var id = this.$el.find('> li.selected > a').attr('menu_id');

        menuId = id;
        editModel.set({ menuId: id });
    },

    /**
     * Set menu
     */
    setMenu: function(e) {
        this.$el.find('> li').removeClass('selected');
        $(e.currentTarget).parent().addClass('selected');

        this.setMenuId();
        this.startMode();

        return false;
    }
});