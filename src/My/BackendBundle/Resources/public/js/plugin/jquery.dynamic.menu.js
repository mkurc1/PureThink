(function($){
    $.fn.dynamicMenu = function(data) {
        /**
         * @type object
         */
        var menu = $(this);

        /**
         * @type string
         */
        var newUrl;

        /**
         * @type string
         */
        var editUrl;

        /**
         * @type string
         */
        var removeUrl;

        /**
         * @type string
         */
        var stateUrl;

        /**
         * @type integer
         */
        var listId;

        /**
         * @type integer
         */
        var moduleId = data.moduleId;

        /**
         * @type integer
         */
        var menuId = data.menuId;

        /**
         * @type boolean
         */
        var editMode = data.editMode;

        getUrl();
        addSelectAll();
        selectFirstElement();
        addActionOnClick();
        addActionOnClickChangeState();

        menu.find('> div > .edit > .remove').on('click', function() {
            if (!$(this).hasClass('disable')) {
                var confirmationText = 'Czy napewno chcesz usunąć wybraną pozycje?';

                var confirmation = confirm(confirmationText);
                if(confirmation) {
                    remove(listId);
                }
            }
        });

        menu.find('> div > .edit > .new').on('click', function() {
            if (!$(this).hasClass('disable')) {
                removeInput();

                var input = '<input class="new" type="text" placeholder="nazwa" />';

                if (menu.hasClass('language')) {
                    var inputAlias = '<input class="alias" type="text" placeholder="alias" />';
                    menu.find('> div > ul').prepend(inputAlias);

                    menu.find('> div > ul > input.alias').keypress(function(event) {
                        if ((event.which === 13) && ($(this).val() !== '')) {
                            add(menu.find('> div > ul > .new').val(), $(this).val());
                        }
                        else if (event.which === 0) {
                            removeInput();
                        }
                    });
                }

                menu.find('> div > ul').prepend(input);

                menu.find('> div > ul > .new').focus();
                menu.find('> div > ul > .new').keypress(function(event) {
                    if ((event.which === 13) && ($(this).val() !== '')) {
                        if (menu.hasClass('language')) {
                            menu.find('> div > ul > input.alias').focus();
                        }
                        else {
                            add($(this).val(), '');
                        }
                    }
                    else if (event.which === 0) {
                        removeInput();
                    }
                });
            }
        });

        menu.find('> div > .edit > .edit').on('click', function() {
            if (!$(this).hasClass('disable')) {
                removeInput();

                var selectedItem = menu.find('> div > ul > li > a[list_id="'+listId+'"]');
                var name = selectedItem.text();
                var input = '<input class="edit" type="text" value="'+name+'" />';

                selectedItem.parent().append(input);

                if (menu.hasClass('language')) {
                    var alias = selectedItem.parent().find('> span').text();
                    var inputAlias = '<input class="alias alias_edit_margin" type="text" value="'+alias+'" />';
                    selectedItem.parent().append(inputAlias);

                    selectedItem.parent().find('> span').hide();
                    selectedItem.parent().find('> div').hide();

                    menu.find('> div > ul input.alias').keypress(function(event) {
                        if ((event.which === 13) && ($(this).val() !== '')) {
                            edit(menu.find('> div > ul .edit').val(), $(this).val());
                        }
                        else if (event.which === 0) {
                            removeInput();
                        }
                    });
                }

                selectedItem.hide();

                menu.find('> div > ul .edit').focus();
                menu.find('> div > ul .edit').setCursorToTextEnd();

                menu.find('> div > ul .edit').keypress(function(event) {
                    if ((event.which === 13) && ($(this).val() !== '')) {
                        if (menu.hasClass('language')) {
                            menu.find('> div > ul input.alias').focus();
                            menu.find('> div > ul input.alias').setCursorToTextEnd();
                        }
                        else {
                            edit($(this).val(), '');
                        }
                    }
                    else if (event.which === 0) {
                        removeInput();
                    }
                });
            }
        });

        /**
         * Add select all
         */
        function addSelectAll() {
            if (!editMode) {
                var all = '<li><a list_id="0">Wszystkie</a></li>';

                menu.find('> div > ul').prepend(all);
            }
        }

        function selectFirstElement() {
            var firstElement = menu.find('> div > ul > li').eq(0);

            firstElement.addClass('selected');

            listId = firstElement.children('a').attr('list_id');

            toggleButton();
        }

        /**
         * Add action on click
         */
        function addActionOnClick() {
            menu.find('> div > ul > li > a').on('click', function() {
                removeInput();

                listId = $(this).attr('list_id');

                toggleButton();
            });
        }

        /**
         * Add action on click change State
         */
        function addActionOnClickChangeState() {
            menu.find('> div > ul > li > div.state').on('click', function() {
                removeInput();

                var listId = $(this).parent().find('> a').attr('list_id');

                state(listId);
            });
        }

        /**
         * Remove input
         */
        function removeInput() {
            menu.find('> div > ul .new').remove();
            menu.find('> div > ul .edit').remove();
            menu.find('> div > ul input.alias').remove();

            menu.find('> div > ul > li > a[list_id="'+listId+'"]').show();

            if (menu.hasClass('language')) {
                menu.find('> div > ul > li > a[list_id="'+listId+'"]').parent().find('> span').attr('style', '');
                menu.find('> div > ul > li > a[list_id="'+listId+'"]').parent().find('> div').attr('style', '');
            }
        }

        /**
         * Add
         *
         * @param string name
         * @param string alias
         */
        function add(name, alias) {
            $.ajax({
                type: "post",
                dataType: 'json',
                data: {
                    name: name,
                    alias: alias,
                    moduleId: moduleId,
                    menuId: menuId
                },
                url: newUrl,
                beforeSend: function() {
                },
                complete: function() {
                    addActionOnClick();
                    addActionOnClickChangeState();
                    sortList();
                },
                success: function(data) {
                    if (data.response) {
                        removeInput();
                        var newPosition = "<li><a list_id="+data.id+">"+name+"</a></li>";
                        menu.find('> div > ul').append(newPosition);

                        if (menu.hasClass('language')) {
                            var newAlias = '<span class="alias">'+alias+'</span>';
                            var newState = '<div class="state deactive"></div>';
                            menu.find('> div > ul > li > a[list_id="'+data.id+'"]').parent().append(newAlias+newState);
                        }

                        alertify.success(data.message);
                    }
                    else {
                        alertify.error(data.message);
                    }
                }
            });
        }

        /**
         * Edit
         *
         * @param string name
         * @param string alias
         */
        function edit(name, alias) {
            $.ajax({
                type: "post",
                dataType: 'json',
                data: {
                    name: name,
                    alias: alias,
                    id: listId
                },
                url: editUrl,
                beforeSend: function() {
                },
                complete: function() {
                    sortList();
                },
                success: function(data) {
                    if (data.response) {
                        removeInput();
                        menu.find('> div > ul > li > a[list_id="'+listId+'"]').text(name);

                        if (menu.hasClass('language')) {
                            menu.find('> div > ul > li > a[list_id="'+listId+'"]').parent().find('> span').text(alias);
                        }

                        alertify.success(data.message);
                    }
                    else {
                        alertify.error(data.message);
                    }
                }
            });
        }

        /**
         * Remove
         *
         * @param integer id
         */
        function remove(id) {
            $.ajax({
                type: "post",
                dataType: 'json',
                data: {
                    id: id
                },
                url: removeUrl,
                beforeSend: function() {
                },
                complete: function() {
                },
                success: function(data) {
                    if (data.response) {
                        menu.find('> div > ul > li > a[list_id="'+id+'"]').parent().remove();
                        menu.find('> div > ul > li').eq(0).find('> a').click();
                        alertify.success(data.message);
                    }
                    else {
                        alertify.error(data.message);
                    }
                }
            });
        }

        /**
         * Change state
         *
         * @param integer id
         */
        function state(id) {
            var changeObject = menu.find('> div > ul > li > a[list_id="'+id+'"]').parent().find('div.state');

            $.ajax({
                type: "post",
                dataType: 'json',
                data: {
                    id: id
                },
                url: stateUrl,
                beforeSend: function() {
                },
                complete: function() {
                },
                success: function(data) {
                    if (data.response) {
                        if (changeObject.hasClass('active')) {
                            changeObject.removeClass('active').addClass('deactive');
                        }
                        else {
                            changeObject.removeClass('deactive').addClass('active');
                        }
                        alertify.success(data.message);
                    }
                    else {
                        alertify.error(data.message);
                    }
                }
            });
        }

        /**
         * Toggle button
         */
        function toggleButton() {
            if (Number(listId) !== 0) {
                menu.find('> div > .edit > .edit').removeClass('disable');
                menu.find('> div > .edit > .remove').removeClass('disable');
            }
            else {
                menu.find('> div > .edit > .edit').addClass('disable');
                menu.find('> div > .edit > .remove').addClass('disable');
            }
        }

        /**
         * Get URL
         */
        function getUrl() {
            newUrl = menu.find('.edit > .new').attr('url');
            editUrl = menu.find('.edit > .edit').attr('url');
            removeUrl = menu.find('.edit > .remove').attr('url');
            stateUrl = menu.find('.edit > .state').attr('url');
        }

        /**
         * Sort list
         */
        function sortList() {
            menu.find('> div > ul > li > a[list_id!="0"]').parent().sort(ascSort).appendTo(menu.find('> div > ul'));
        }

        /**
         * Accending sort
         *
         * @param  object a
         * @param  object b
         * @return boolean
         */
        function ascSort(a, b) {
            return ($(b).text().toLowerCase()) < ($(a).text().toLowerCase()) ? 1 : -1;
        }

        /**
         * Decending sort
         *
         * @param  object a
         * @param  object b
         * @return boolean
         */
        function decSort(a, b) {
            return ($(b).text().toLowerCase()) > ($(a).text().toLowerCase()) ? 1 : -1;
        }
    };
})(jQuery);