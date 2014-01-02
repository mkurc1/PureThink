ListView = Backbone.View.extend({
    initialize: function() {
        console.log('Initialize List View');

        this.select = new Select();
    },

    events: {
        'click table th'                    : 'changeOrder',
        'click table tr td.state > img'     : 'changeState',
        'click td.select input.multi_check' : 'checkboxChange',
        'click .sublist'                    : 'sublist'
    },

    /**
     * Empty container
     */
    emptyContainer: function() {
        this.$el.empty();
    },

    /**
     * Set arrow order
     */
    arrowOrder: function() {
        var imageContainer = '<img class="order" src="/images/arrow_'+this.model.get('sequence').toLowerCase()+'.png" />';

        this.$el.find('table th[column*="'+this.model.get('order')+'"]').append(imageContainer);
    },

    /**
     * Change order action
     */
    changeOrder: function(e) {
        var column = $(e.currentTarget).attr('column');

        if (typeof(column) !== "undefined") {
            if (this.model.get('order') != column) {
                this.model.set({order: column});
            }
            else {
                if (this.model.get('sequence') == "ASC") {
                    this.model.set({sequence: "DESC"});
                }
                else {
                    this.model.set({sequence: "ASC"});
                }
            }

            this.refresh(false);
        }
    },

    /**
     * Change state action
     *
     * @param integer id
     */
    changeState: function(e) {
        var selectId = $(e.currentTarget).parent().parent().attr('list_id');

        var list = this;

        $.ajax({
            type     : "post",
            dataType : 'json',
            data: {
                id: selectId
            },
            url: list.model.get('url')+'state',
            beforeSend: function() {
            },
            complete: function() {
            },
            success: function(data) {
                if (data.response) {
                    notify('success', data.message);
                    list.refresh(false);
                }
                else {
                    notify('fail', data.message);
                }
            }
        });
    },

    /**
     * Checkbox change action
     */
    checkboxChange: function(e) {
        var selectId = $(e.currentTarget).parent().parent().attr('list_id');

        if ($(e.currentTarget).is(':checked')) {
            this.select.add(selectId);
        }
        else {
            this.select.remove(selectId);
        }

        toggleListMainButton();
    },

    /**
     * Sublist click action
     */
    sublist: function(e) {
        this.model.set({
            url       : $(e.currentTarget).attr('href'),
            sublistId : $(e.currentTarget).attr('sublist_id')
        });

        this.refresh(true);

        return false;
    },

    /**
     * Render
     */
    render: function() {
        var list = this;

        $.ajax({
            type     : "post",
            dataType : 'json',
            data: {
                rowsOnPage : paginationListModel.get('rowsOnPage'),
                page       : paginationListModel.get('page'),
                order      : list.model.get('order'),
                sequence   : list.model.get('sequence'),
                filtr      : list.model.get('filtr'),
                languageId : list.model.get('languageId'),
                groupId    : list.model.get('groupId'),
                sublistId  : list.model.get('sublistId')
            },
            url: list.model.get('url'),
            beforeSend: function() {
                list.setMode();
                list.emptyContainer();
                list.showLoading();
            },
            complete: function() {
                list.arrowOrder();
                paginationListView.togglePagination();
                editView.setEditModeAction();
                toggleListMainButton();
                list.removeLoading();
            },
            success: function(data) {
                if (data.response) {
                    list.$el.append(data.list.toString());

                    paginationListModel.set({
                        firstPage    : data.pagination.first_page,
                        previousPage : data.pagination.previous,
                        nextPage     : data.pagination.next,
                        lastPage     : data.pagination.last_page
                    });

                    paginationListView.render(data.pagination.pages);

                    if (data.order) {
                        list.model.set({ order: data.order });
                    }
                }
            }
        });
    },

    /**
     * Show loading
     */
    showLoading: function() {
        this.$el.append('<div class="loading"></div>');
    },

    /**
     * Remove loading
     */
    removeLoading: function() {
        this.$el.find('.loading').remove();
    },

    /**
     * Set mode
     */
    setMode: function() {
        this.$el.show();
        $('#edit_container').empty().hide();
    },

    /**
     * Remove elements
     */
    removeElements: function() {
        var list = this;

        $.ajax({
            type: "post",
            dataType: 'json',
            data: {
                arrayId: list.select.getAll()
            },
            url: list.model.get('url')+'delete',
            beforeSend: function() {
            },
            complete: function() {
            },
            success: function(data) {
                if (data.response) {
                    notify('success', data.message);
                    list.refresh(false);
                }
                else {
                    notify('fail', data.message);
                }
            }
        });
    },

    /**
     * Set Default parameters
     */
    defaultParameters: function() {
        this.model.set({
            order      : 'a.name',
            sequence   : 'ASC',
            filtr      : '',
            groupId    : 0,
            languageId : 0
        });

        paginationListModel.set({ page: 1 });

        emptyFilter();
    },

    /**
     * Refresh list
     *
     * @param boolean withLeftMenu
     */
    refresh: function(withLeftMenu) {
        this.select.empty();
        createListButtons();

        if (withLeftMenu) {
            this.defaultParameters();
            getLeftMenu(false);
        }

        this.render();
    }
});