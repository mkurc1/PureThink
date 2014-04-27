PaginationModel = Backbone.Model.extend({
    defaults: {
        page         : 1,
        start        : 0,
        end          : 0,
        firstPage    : 0,
        lastPage     : 0,
        previousPage : 0,
        nextPage     : 0,
        rowsOnPage   : 10,
        hide         : false
    }
});