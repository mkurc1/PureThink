ListView = Backbone.View.extend({
    initialize: function (options) {
        this.isMainList = options.isMainList;

        this.paginationModel = new PaginationModel();
        this.paginationView = new PaginationView({
            el: options.paginationEl,
            model: this.paginationModel,
            list: this
        });

        this.select = new Select();
    },

    events: {
        'click table th': 'changeOrder',
        'click table tr td.state > i': 'changeState',
        'click table tr td.lock > i': 'changeLock',
        'click td.select input.multi_check': 'checkboxChange',
        'click .sublist': 'sublist'
    },

    emptyContainer: function () {
        this.$el.empty();
    },

    arrowOrder: function () {
        var imageContainer = '<img class="order" src="/images/arrow_' + this.model.get('sequence').toLowerCase() + '.png" />';

        this.$el.find('table th[column*="' + this.model.get('order') + '"]').append(imageContainer);
    },

    changeOrder: function (e) {
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

    changeState: function (e) {
        this.change(e, 'state');
    },

    changeLock: function (e) {
        this.change(e, 'lock');
    },

    change: function (e, uri) {
        var selectId = $(e.currentTarget).parent().parent().attr('list_id');

        var list = this;

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: list.model.get('url') + uri,
            data: {
                id: selectId
            },
            success: function (data) {
                if (data.response) {
                    alertify.success(data.message);
                    list.refresh(false);
                }
                else {
                    alertify.error(data.message);
                }
            }
        });
    },

    checkboxChange: function (e) {
        var selectId = $(e.currentTarget).parent().parent().attr('list_id');

        if ($(e.currentTarget).is(':checked')) {
            this.select.add(selectId);
        }
        else {
            this.select.remove(selectId);
        }

        mainButtonView.toggleListMainButton();
    },

    sublist: function (e) {
        this.model.set({
            url: $(e.currentTarget).attr('href'),
            sublistId: $(e.currentTarget).attr('sublist_id')
        });

        this.refresh(true);

        return false;
    },

    render: function () {
        var list = this;

        $.ajax({
            type: 'get',
            dataType: 'json',
            async: true,
            url: list.model.get('url'),
            data: {
                rowsOnPage: list.paginationModel.get('rowsOnPage'),
                page: list.paginationModel.get('page'),
                order: list.model.get('order'),
                sequence: list.model.get('sequence'),
                filter: list.model.get('filter'),
                languageId: list.model.get('languageId'),
                groupId: list.model.get('groupId'),
                sublistId: list.model.get('sublistId')
            },
            beforeSend: function () {
                if (list.isMainList) {
                    filterView.showEl();
                }

                list.setMode();
                list.emptyContainer();
                list.showLoading();
            },
            complete: function () {
                list.arrowOrder();

                if (list.isMainList) {
                    editView.setEditModeAction();
                    mainButtonView.toggleListMainButton();
                }
                else {
                    setActionOnClickBrowseElement();
                }

                list.setActionOnHoverInfo();
                list.setDragAndDrop();
                list.removeLoading();
            },
            success: function (data) {
                if (data.response) {
                    list.$el.append(data.list.toString());

                    if (data.pagination.hide) {
                        list.paginationModel.set({
                            hide: true
                        });
                        list.paginationView.hideEl();
                    }
                    else {
                        list.paginationModel.set({
                            firstPage: data.pagination.first_page,
                            previousPage: data.pagination.previous,
                            nextPage: data.pagination.next,
                            lastPage: data.pagination.last_page,
                            hide: false
                        });
                        list.paginationView.render(data.pagination.pages);
                        list.paginationView.showEl();
                        list.paginationView.togglePagination();
                    }

                    if (data.order) {
                        list.model.set({ order: data.order });
                    }
                }
            }
        });
    },

    setDragAndDrop: function () {
        var list = this;

        this.$el.find('table.drag-and-drop tbody').multidrag({
            url: list.model.get('url') + 'sequence'
        });
    },

    showLoading: function () {
        this.$el.append('<div class="loading"><i class="fa fa-spinner fa-spin"></i></div>');
    },

    removeLoading: function () {
        this.$el.find('.loading').remove();
    },

    setMode: function () {
        this.$el.show();
        $('#edit_container').empty().hide();
    },

    removeElements: function () {
        var list = this;

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: list.model.get('url') + 'delete',
            data: {
                arrayId: list.select.getAll()
            },
            beforeSend: function () {
            },
            complete: function () {
            },
            success: function (data) {
                if (data.response) {
                    alertify.success(data.message);
                    list.refresh(false);
                }
                else {
                    alertify.error(data.message);
                }
            }
        });
    },

    exportElements: function () {
        var list = this;

        if (list.select.count() == 0) {
            return;
        }

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: list.model.get('url') + 'export',
            data: {
                arrayId: list.select.getAll()
            },
            success: function (data) {
                if (data.response) {
                    var link = $('<a></a>');
                    $('body').append(link);
                    link.attr({
                        'download': 'data.json',
                        'href': 'data:text/x-json;charset=utf-8,' + encodeURIComponent(data.json),
                        'target': '_blank'
                    }).bind("click", (function () {
                            this.click();
                        })).click().remove();
                }
            }
        });
    },

    defaultParameters: function () {
        this.model.set({
            order: 'a.name',
            sequence: 'ASC',
            filter: '',
            groupId: this.getGroupId(),
            languageId: this.getLanguageId()
        });
        this.paginationModel.set({ page: 1 });

        filterView.empty();
    },

    getGroupId: function () {
        var groupId = $('#left_menu_container > .group').find('li.selected').find('a').attr('list_id');

        return (typeof groupId !== 'undefined') ? groupId : 0;
    },

    getLanguageId: function () {
        var languageId = $('#left_menu_container > .language').find('li.selected').find('a').attr('list_id');

        return (typeof languageId !== 'undefined') ? languageId : 0;
    },

    refresh: function (withLeftMenu) {
        var list = this;

        list.select.empty();

        if (list.isMainList) {
            mainButtonView.createListButtons();
        }

        if (withLeftMenu) {
            $.when(leftMenuView.render()).done(function () {
                list.defaultParameters();
                list.render();
            });
        }
        else {
            list.render();
        }
    },

    setActionOnHoverInfo: function () {
        this.$el.find('.info > i').qtip({
            content: {
                text: function (event, api) {
                    return $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: Routing.generate('my_file_file_info'),
                        data: {
                            id: $(this).parent().parent().attr('list_id')
                        }
                    })
                        .then(function (data) {
                            var content = data.view.toString();

                            api.set('content.text', content);
                        }, function (xhr, status, error) {
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