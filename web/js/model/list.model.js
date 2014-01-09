ListModel = Backbone.Model.extend({
    initialize: function() {
        console.log('Initialize List Model');

        this.on('invalid', function(model, error) {
            console.log(error);
        });
    },

    defaults: {
        groupId    : 0,
        languageId : 0,
        sublistId  : false,
        order      : 'a.name',
        sequence   : 'ASC',
        filtr      : ''
    }
});