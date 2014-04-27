CollectionView = Backbone.View.extend({
    initialize: function () {
        this.$el.data('index', this.$el.find(':input').length);

        this.insertAddButton();
    },

    events: {
        "click .add": "add",
        "click .remove": "remove"
    },

    insertAddButton: function () {
        if (this.$el.find('.add').length > 0) {
            return;
        }

        var button = '<a class="collection add">Dodaj</a>';

        this.$el.append(button);
    },

    insertRemoveButton: function ($container) {
        var button = '<a class="collection remove">x</a>';

        $container.append(button);
    },

    insertFileField: function ($container) {
        if (!$container.find('input[file]')) {
            return;
        }

        var $file = $('<div class="input_file"></div><button class="browse">Przeglądaj</button>');

        $container.append($file);
    },

    add: function (e) {
        var $container = $('<div class="dane_element"></div>');

        var index = this.$el.data('index');

        var prototype = this.$el.data('prototype');
        var $newForm = $(prototype.replace(/__name__/g, index));

        this.$el.data('index', index + 1);

        $(e.currentTarget).before($container);
        $container.append($newForm.children());

        this.insertFileField($container);
        this.insertRemoveButton($container);
    },

    remove: function (e) {
        var index = this.$el.data('index');

        this.$el.data('index', index - 1);
        $(e.currentTarget).parent().remove();
    }
});