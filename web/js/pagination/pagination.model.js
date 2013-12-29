PaginationModel = Backbone.Model.extend({
    initialize: function() {
        console.log('Initialize Pagination Model');
        this.on('change:rowsOnPage', function() {
            console.log(this.get('rowsOnPage') + ' is now the value for rowsOnPage');
        });

        this.on('change:page', function() {
            console.log(this.get('page') + ' is now the value for page');
        });

        this.on('invalid', function(model, error) {
            console.log(error);
        });
    },

    defaults: {
        page         : 1,
        start        : 0,
        end          : 0,
        firstPage    : 0,
        lastPage     : 0,
        previousPage : 0,
        nextPage     : 0,
        rowsOnPage   : 10
    },

    validate: function(attrs, options) {
        if (attrs.rowsOnPage < 1) {
            return "Value must be over 0";
        }
    }
});