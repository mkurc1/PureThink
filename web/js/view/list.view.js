ListView = Backbone.View.extend({
    initialize: function(options) {
        console.log('Initialize List View');

        this.isMainList = options.isMainList;

        this.paginationModel = new PaginationModel();
        this.paginationView = new PaginationView({
            el    : options.paginationEl,
            model : this.paginationModel,
            list  : this
        });

        this.select = new Select();
    },

    events: {
        'click table th'                    : 'changeOrder',
        'click table tr td.state > i'       : 'changeState',
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
     */
    changeState: function(e) {
        var selectId = $(e.currentTarget).parent().parent().attr('list_id');

        var list = this;

        $.ajax({
            type     : 'post',
            dataType : 'json',
            url      : list.model.get('url')+'state',
            data: {
                id: selectId
            },
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

        mainButtonView.toggleListMainButton();
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
            type     : 'post',
            dataType : 'json',
            async    : true,
            url      : list.model.get('url'),
            data: {
                rowsOnPage : list.paginationModel.get('rowsOnPage'),
                page       : list.paginationModel.get('page'),
                order      : list.model.get('order'),
                sequence   : list.model.get('sequence'),
                filtr      : list.model.get('filtr'),
                languageId : list.model.get('languageId'),
                groupId    : list.model.get('groupId'),
                sublistId  : list.model.get('sublistId')
            },
            beforeSend: function() {
                if (list.isMainList) {
                    filterView.showEl();
                }

                list.setMode();
                list.emptyContainer();
                list.showLoading();
            },
            complete: function() {
                list.arrowOrder();
                list.paginationView.showEl();
                list.paginationView.togglePagination();

                if (list.isMainList) {
                    editView.setEditModeAction();
                    mainButtonView.toggleListMainButton();
                }
                else {
                    setActionOnClickBrowseElement();
                }

                list.setActionOnHoverInfo();
                list.removeLoading();
            },
            success: function(data) {
                if (data.response) {
                    list.$el.append(data.list.toString());

                    list.paginationModel.set({
                        firstPage    : data.pagination.first_page,
                        previousPage : data.pagination.previous,
                        nextPage     : data.pagination.next,
                        lastPage     : data.pagination.last_page
                    });

                    list.paginationView.render(data.pagination.pages);

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
            type     : 'post',
            dataType : 'json',
            url      : list.model.get('url')+'delete',
            data: {
                arrayId: list.select.getAll()
            },
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
            groupId    : this.getGroupId(),
            languageId : this.getLanguageId()
        });
        this.paginationModel.set({ page: 1 });

        filterView.empty();
    },

    /**
     * Get group ID
     *
     * @return integer
     */
    getGroupId: function() {
        var groupId = $('#left_menu_container > .group').find('li.selected').find('a').attr('list_id');

        return (typeof groupId !== 'undefined') ? groupId : 0;
    },

    /**
     * Get language ID
     *
     * @return integer
     */
    getLanguageId: function() {
        var languageId = $('#left_menu_container > .language').find('li.selected').find('a').attr('list_id');

        return (typeof languageId !== 'undefined') ? languageId : 0;
    },

    /**
     * Refresh list
     *
     * @param boolean withLeftMenu
     */
    refresh: function(withLeftMenu) {
        this.select.empty();

        if (this.isMainList) {
            mainButtonView.createListButtons();
        }

        if (withLeftMenu) {
            leftMenuView.render();
            this.defaultParameters();
        }

        this.render();
    },

    /**
     * Set action on hover info
     */
    setActionOnHoverInfo: function() {
        this.$el.find('.info > i').qtip({
            content: {
                text: function(event, api) {
                    return $.ajax({
                        type     : 'POST',
                        dataType : 'json',
                        url      : links.fileInfo,
                        data: {
                            id: $(this).parent().parent().attr('list_id')
                        }
                    })
                    .then(function(data) {
                        var content = data.view.toString();

                        api.set('content.text', content);
                    }, function(xhr, status, error) {
                        api.set('content.text', status + ': ' + error);
                    });
                }
            },
            style: {
                classes: 'qtip-light qtip-shadow'
            }
        });
    }
});