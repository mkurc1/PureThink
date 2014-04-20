MainMenuView = Backbone.View.extend({
    events: {
        "click > li > a" : "setMenu"
    },

    render: function() {
        var menu = this;

        $.ajax({
            type     : "post",
            dataType : 'json',
            async    : true,
            url      : Routing.generate('my_backend_admin_menu'),
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

    emptyContainer: function() {
        this.$el.empty();
    },

    selectFirstMenu: function() {
        this.$el.find('> li').eq(0).addClass('selected');
        this.setMenuId();
        this.startMode();
    },

    startMode: function() {
        var url = this.getMainMenuUrl();

        if (this.isEditMode(url)) {
            editModel.set({ url: url });

            $.when(leftMenuView.render(true)).done(function() {
                editView.defaultParameters();
                editView.render();
            });
        }
        else {
            listModel.set({ url: url });
            listView.sublistId = 0;
            listView.refresh(true);
        }
    },

    getMainMenuUrl: function() {
        return this.$el.find('> li.selected > a').attr('href');
    },

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

    setMenuId: function() {
        var id = this.$el.find('> li.selected > a').attr('menu_id');

        menuId = id;
        editModel.set({ menuId: id });
    },

    setMenu: function(e) {
        this.$el.find('> li').removeClass('selected');
        $(e.currentTarget).parent().addClass('selected');

        this.setMenuId();
        this.startMode();

        return false;
    }
});