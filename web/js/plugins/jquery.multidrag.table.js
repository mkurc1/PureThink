(function($) {
    $.fn.multidrag = function(options) {
        var defaults = {
            placeholder : "placeholder",
            cursor      : "move",
            distance    : 8,
            opacity     : 0.6,
            page        : 1,
            rowsOnPage  : 10,
            childMargin : 50
        };

        var settings = $.extend({}, defaults, options);

        /**
         * Sort
         *
         * @param object e
         * @param object ui
         */
        function sort(e, ui) {
            if (ui.position.left > settings.childMargin) {
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
         * Stop
         *
         * @param object e
         * @param object ui
         */
        function stop(e, ui) {
            $.each(ui.item.find('tbody tr'), function(index, val) {
                ui.item.after($(val));
            });
            ui.item.find('tbody').remove();

            var row        = 0,
                page       = settings.page,
                rowsOnPage = settings.rowsOnPage;

            if (page > 1) {
                row = (page-1)*rowsOnPage;
            }

            $('td.lp', ui.item.parent()).each(function (i) {
                $(this).html((++row)+'.');
            });

            if (ui.position.left > settings.childMargin) {
                var prevEl = ui.item.prev();
                if (prevEl.attr('parent-id') !== 'undefined')
                    ui.item.attr('parent-id', prevEl.attr('parent-id'));
                else {
                    ui.item.attr('parent-id', prevEl.attr('list_id'));
                }
                ui.item.find('td.name').addClass('submenu');
            }
            else {
                ui.item.removeAttr('parent-id');
                ui.item.find('td.name').removeClass('submenu');
            }
        }

        $(this).sortable({
            placeholder : settings.placeholder,
            cursor      : settings.cursor,
            distance    : settings.distance,
            opacity     : settings.opacity,
            sort        : sort,
            start       : start,
            stop        : stop
        }).disableSelection();
    };
})(jQuery);