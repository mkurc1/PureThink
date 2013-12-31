EditModel = Backbone.Model.extend({
    initialize: function() {
        console.log('Initialize Edit Model');

        this.on('invalid', function(model, error) {
            console.log(error);
        });
    },

    defaults: {
        languageId    : 0,
        isApplyOption : false
    }
});