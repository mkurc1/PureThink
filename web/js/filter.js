$(function() {
    $('#search_box > input').keyup(function() {
        var search = this;
        if (search.timer) {
            clearTimeout(search.timer);
        }

        search.timer = setTimeout(function() {
            search.timer = null;

            List.filtr = search.value;
            refreshList();
        }, 800);
    });
});

/**
 * Empty filter
 */
function emptyFilter() {
    $('#search_box > input').val('');
}