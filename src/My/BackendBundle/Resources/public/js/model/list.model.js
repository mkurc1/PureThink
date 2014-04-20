ListModel = Backbone.Model.extend({
    defaults: {
        groupId    : 0,
        languageId : 0,
        sublistId  : false,
        order      : 'a.name',
        sequence   : 'ASC',
        filter     : ''
    }
});