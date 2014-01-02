$(function() {
    $('#search_box > input').keyup(function() {
        var search = this;
        if (search.timer) {
            clearTimeout(search.timer);
        }

        search.timer = setTimeout(function() {
            search.timer = null;

            listModel.set({ filtr: search.value });
            listView.render();
        }, 800);
    });
});

/**
 * Empty filter
 */
function emptyFilter() {
    $('#search_box > input').val('');
}