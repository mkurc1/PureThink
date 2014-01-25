(function($) {
    $.fn.multidrag = function(options) {
        var settings = $.extend({
            placeholder : "placeholder",
            cursor      : "move",
            distance    : 8,
            opacity     : 0.6,
            page        : 1,
            rowsOnPage  : 10
        }, options);

        $(this).sortable({
            placeholder : settings.placeholder,
            cursor      : settings.cursor,
            distance    : settings.distance,
            opacity     : settings.opacity,

            sort: function(event, ui) {
                if (ui.position.left > 50) {
                    ui.placeholder.addClass('children');
                }
                else {
                    ui.placeholder.removeClass('children');
                }
            },

            start: function(e, ui) {
                var listId = ui.item.attr('list_id');

                ui.item.append('<tbody></tbody>');

                $.each(ui.item.parent().children('tr'), function(index, val) {
                    if ($(val).attr('parent-id') == listId) {
                        ui.item.find('tbody').append($(val));
                    }
                });
            },

            stop: function(e, ui) {
                $.each(ui.item.find('tbody tr'), function(index, val) {
                    ui.item.after($(val));
                });
                ui.item.find('tbody').remove();

                var row        = 0,
                    page       = page,
                    rowsOnPage = rowsOnPage;

                if (page > 1) {
                    row = (page-1)*rowsOnPage;
                }

                $('td.lp', ui.item.parent()).each(function (i) {
                    $(this).html((++row)+'.');
                });

                if (ui.position.left > 50) {
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
        }).disableSelection();
    };
})(jQuery);