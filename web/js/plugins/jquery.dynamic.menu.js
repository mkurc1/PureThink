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

        getUrl();

        menu.find('> div > ul > li > a').on('click', function() {
            removeInput();

            listId = $(this).attr('list_id');

            enableButton();
        });

        menu.find('> div > .edit > .remove').on('click', function() {
            if (!$(this).hasClass('disable')) {
                remove(listId);
            }
        });

        menu.find('> div > .edit > .new').on('click', function() {
            if (!$(this).hasClass('disable')) {
                removeInput();

                var input = '<input class="new" type="text" placeholder="nazwa" />';
                menu.find('> div > ul').prepend(input);

                menu.find('> div > ul > .new').focus();
                menu.find('> div > ul > .new').keypress(function(event) {
                    if ((event.which == 13) && ($(this).val() != '')) {
                        add($(this).val());
                    }
                });
            }
        });

        menu.find('> div > .edit > .edit').on('click', function() {
            if (!$(this).hasClass('disable')) {
                alert(listId);
            }
        });

        /**
         * Remove input
         */
        function removeInput() {
            menu.find('> div > ul > .new').remove();
            menu.find('> div > ul > .edit').remove();
        }

        /**
         * Add
         *
         * @param string name
         */
        function add(name) {
            $.ajax({
                type: "post",
                dataType: 'json',
                data: {
                    name: name,
                    moduleId: moduleId,
                    menuId: menuId
                },
                url: newUrl,
                beforeSend: function() {
                },
                complete: function() {
                },
                success: function(data) {
                    if (data.response) {
                        removeInput();
                        var newPosition = "<li><a list_id="+data.id+">"+name+"</a></li>";
                        menu.find('> div > ul').append(newPosition);
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
                        menu.find('> div > ul > li > a[list_id="0"]').click();
                    }
                }
            });
        }

        /**
         * Enable / Disable button
         */
        function enableButton() {
            if (listId != 0) {
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
        }
    }
})(jQuery);