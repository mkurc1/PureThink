var listUrl;

/**
 * Set list URL
 */
function setListUrl() {
    listUrl = $('#main_menu_list > li.selected > a').attr('href');
}

/**
 * Refresh list
 */
function refreshList() {
    setList();
}

/**
 * Set list
 */
function setList() {
    $.ajax({
        type: "post",
        dataType: 'json',
        data: {
        },
        url: listUrl,
        beforeSend: function() {
        },
        complete: function() {
        },
        success: function(data) {
            if (data.response) {
                $('#main_container').empty().append(data.list.toString());
            }
        }
    });
}