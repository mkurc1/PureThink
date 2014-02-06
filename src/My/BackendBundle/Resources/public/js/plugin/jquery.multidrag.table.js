(function($) {
    $.fn.multidrag = function(options) {
        var defaults = {
            placeholder : "placeholder",
            cursor      : "move",
            distance    : 8,
            opacity     : 0.6,
            childMargin : 50
        };

        var settings = $.extend({}, defaults, options);

        /**
         * Is Submenu
         *
         * @param object e
         * @param object ui
         */
        function isSubmenu(e, ui) {
            // console.log({
            //     item: ui.item.index(),
            //     placeholder: ui.placeholder.index(),
            //     event: e.type
            // });

            // if have children return false
            if (ui.item.parent().find('tr[parent-id="'+ui.item.attr('list_id')+'"]').length > 0) {
                return false;
            }

            if (e.type == "sortstop") {
                if (ui.item.index() === 0) {
                    return false;
                }
            }

            if (e.type == "sort") {
                if ((ui.item.index() === 0) && (ui.placeholder.index() === 1)) {
                    return false;
                }

                if (ui.placeholder.index() === 0) {
                    return false;
                }
            }

            if (ui.position.left < settings.childMargin) {
                return false;
            }

            return true;
        }

        /**
         * Sort
         *
         * @param object e
         * @param object ui
         */
        function sort(e, ui) {
            if (isSubmenu(e, ui)) {
                ui.placeholder.addClass('children');
            }
            else {
                ui.placeholder.removeClass('children');
            }
        }

        /**
         * Start
         *
         * @param object e
         * @param object ui
         */
        function start(e, ui) {
            var listId = ui.item.attr('list_id');

            ui.item.append('<tbody></tbody>');

            $.each(ui.item.parent().children('tr'), function(index, val) {
                if ($(val).attr('parent-id') == listId) {
                    ui.item.find('tbody').append($(val));
                }
            });
        }

        /**
         * Set numbers
         *
         * @param object ui
         */
        function setNumbers(ui) {
            var items = ui.item.parent().find('tr'),
                j = 0,
                k, item, i, parentId;

            for (i=0; i<items.length; i++) {
                item = items.eq(i);

                item.find('td.lp').html((i+1)+'.');

                if (item.hasAttr('parent-id')) {
                    if (parentId != item.attr('parent-id')) {
                        k = 0;
                        parentId = item.attr('parent-id');
                    }

                    item.attr('sequence', ++k);
                }
                else {
                    item.attr('sequence', ++j);
                }
            }
        }

        /**
         * Drop children
         *
         * @param object ui
         */
        function dropChildren(ui) {
            $.each(ui.item.find('tbody tr'), function(index, val) {
                ui.item.after($(val));
            });

            ui.item.find('tbody').remove();
        }

        /**
         * Stop
         *
         * @param object e
         * @param object ui
         */
        function stop(e, ui) {
            dropChildren(ui);

            var prevEl = ui.item.prev();

            if (isSubmenu(e, ui)) {
                if (prevEl.hasAttr('parent-id')) {
                    ui.item.attr('parent-id', prevEl.attr('parent-id'));
                }
                else {
                    prevEl.addClass('parent');
                    ui.item.attr('parent-id', prevEl.attr('list_id'));
                }
                ui.item.find('td.name').addClass('submenu');
                ui.item.find('td.lp').addClass('submenu');
            }
            else {
                prevEl.removeClass('parent');
                ui.item.removeAttr('parent-id');
                ui.item.find('td.name').removeClass('submenu');
                ui.item.find('td.lp').removeClass('submenu');
            }

            setNumbers(ui);
            send(ui);
        }

        /**
         * Prepare data to send
         *
         * @param object ui
         * @return array
         */
        function prepareDataToSend(ui) {
            var items = ui.item.parent().find('tr'),
                tab = {};

            $.each(items, function(index, val) {
                tab[index] = {
                    id: $(val).attr('list_id'),
                    sequence: $(val).attr('sequence'),
                    parentId: $(val).attr('parent-id')
                };
            });

            return tab;
        }

        /**
         * Send
         *
         * @param object ui
         */
        function send(ui) {
            $.ajax({
                type     : 'post',
                dataType : 'json',
                url      : settings.url,
                data: {
                    sequence: prepareDataToSend(ui)
                },
                success: function(data) {
                    if (data.response) {
                        notify('success', data.message);
                    }
                    else {
                        notify('fail', data.message);
                    }
                }
            });
        }

        $(this).sortable({
            placeholder : settings.placeholder,
            cursor      : settings.cursor,
            distance    : settings.distance,
            opacity     : settings.opacity,
            axis        : "y",
            sort        : sort,
            start       : start,
            stop        : stop
        }).disableSelection();
    };
})(jQuery);