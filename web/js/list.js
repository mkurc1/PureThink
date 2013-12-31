/**
 * Object List Cunstructor
 */
function List() {
    this.groupId;
    this.languageId;
    this.sublistId;
    this.order;
    this.sequence;
    this.filtr;
    this.url;
    this.select = [];

    this.addToSelect = addToSelect;
    this.removeFromSelect = removeFromSelect;
    this.emptySelect = emptySelect;
    this.getCountSelect = getCountSelect;
    this.emptyList = emptyList;
    this.arrowOrder = arrowOrder;
    this.setActionOnChangeOrder = setActionOnChangeOrder;
    this.setActionOnChangeState = setActionOnChangeState;
    this.checkboxChangeAction = checkboxChangeAction;
    this.changeState = changeState;
    this.getList = getList;
    this.showLoading = showLoading;
    this.removeLoading = removeLoading;
    this.setMode = setMode;
    this.removeElements = removeElements;
    this.setDefaultParameters = setDefaultParameters;
    this.refresh = refresh;
    this.setActionOnSublistClick = setActionOnSublistClick;

    /**
     * Add to select
     *
     * @param integer id
     */
    function addToSelect(id) {
        this.select.push(id);
    }

    /**
     * Remove from select
     *
     * @param integer id
     */
    function removeFromSelect(id) {
        var i = this.select.indexOf(id);
        if(i != -1) {
            this.select.splice(i, 1);
        }
    }

    /**
     * Empty select
     */
    function emptySelect() {
        this.select.clear();
    }

    /**
     * Get count select
     * @return integer
     */
    function getCountSelect() {
        return this.select.length;
    }

    /**
     * Empty list
     */
    function emptyList() {
        $('#main_container').empty();
    }

    /**
     * set arrow order
     */
    function arrowOrder() {
        var imageContainer = '<img class="order" src="/images/arrow_'+this.sequence.toLowerCase()+'.png" />';

        $('#main_container > table th[column*="' + this.order + '"]').append(imageContainer);
    }

    /**
     * Set action on change order
     */
    function setActionOnChangeOrder() {
        var list = this;

        $('#main_container > table th').click(function() {
            var column = $(this).attr('column');

            if (typeof(column) !== "undefined") {
                if (list.order != column) {
                    list.order = column;
                }
                else {
                    if (list.sequence == "ASC") {
                        list.sequence = "DESC";
                    }
                    else {
                        list.sequence = "ASC";
                    }
                }

                list.refresh(false);
            }
        });
    }

    /**
     * Set action on change state
     */
    function setActionOnChangeState() {
        var list = this;

        $('#main_container > table tr td.state > img').click(function() {
            var selectId = $(this).parent().parent().attr('list_id');

            list.changeState(selectId);
        });
    }

    /**
     * Change state
     *
     * @param integer id
     */
    function changeState(id) {
        var list = this;

        $.ajax({
            type: "post",
            dataType: 'json',
            data: {
                id: id
            },
            url: list.url+'state',
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
    }

    /**
     * Checkbox change action
     */
    function checkboxChangeAction() {
        var list = this;

        $('#main_container > table tr > td.select > input.multi_check').click(function() {
            var selectId = $(this).parent().parent().attr('list_id');

            if ($(this).is(':checked')) {
                list.addToSelect(selectId);
            }
            else {
                list.removeFromSelect(selectId);
            }

            toggleListMainButton();
        });
    }

    /**
     * Set action on sublist click
     */
    function setActionOnSublistClick() {
        var list = this;

        $('.sublist').click(function() {
            list.url = $(this).attr('href');
            list.sublistId = $(this).attr('sublist_id');
            List.refresh(true);

            return false;
        });
    }

    /**
     * Get list
     */
    function getList() {
        var list = this;

        $.ajax({
            type: "post",
            dataType: 'json',
            data: {
                rowsOnPage: paginationListModel.get('rowsOnPage'),
                page: paginationListModel.get('page'),
                order: list.order,
                sequence: list.sequence,
                filtr: list.filtr,
                languageId: list.languageId,
                groupId: list.groupId,
                sublistId: list.sublistId
            },
            url: list.url,
            beforeSend: function() {
                list.setMode();
                list.emptyList();
                list.showLoading();
            },
            complete: function() {
                list.arrowOrder();
                list.setActionOnChangeOrder();
                list.setActionOnChangeState();
                list.setActionOnSublistClick();
                paginationListView.togglePagination();
                editView.setEditModeAction();
                list.checkboxChangeAction();
                toggleListMainButton();
                list.removeLoading();
            },
            success: function(data) {
                if (data.response) {
                    $('#main_container').append(data.list.toString());

                    paginationListModel.set({
                        firstPage: data.pagination.first_page,
                        previousPage: data.pagination.previous,
                        nextPage: data.pagination.next,
                        lastPage: data.pagination.last_page
                    });

                    paginationListView.render(data.pagination.pages);

                    if (data.order) {
                        list.order = data.order;
                    }
                }
            }
        });
    }

    /**
     * Show loading
     */
    function showLoading() {
        $('#main_container').append('<div class="loading"></div>');
    }

    /**
     * Remove loading
     */
    function removeLoading() {
        $('.loading').remove();
    }

    /**
     * Set mode
     */
    function setMode() {
        $('#main_container').show();
        $('#edit_container').empty().hide();
    }

    /**
     * Remove elements
     */
    function removeElements() {
        var list = this;

        $.ajax({
            type: "post",
            dataType: 'json',
            data: {
                arrayId: list.select
            },
            url: list.url+'delete',
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
    }

    /**
     * Set Default parameters
     */
    function setDefaultParameters() {
        this.order = 'a.name';
        this.sequence = 'ASC';
        this.filtr = '';
        this.groupId = 0;
        this.languageId = 0;
        paginationListModel.set({page: 1});

        emptyFilter();
    }

    /**
     * Refresh list
     *
     * @param boolean withLeftMenu
     */
    function refresh(withLeftMenu) {
        this.emptySelect();
        createListButtons();

        if (withLeftMenu) {
            this.setDefaultParameters();
            getLeftMenu(false);
        }

        this.getList();
    }
}