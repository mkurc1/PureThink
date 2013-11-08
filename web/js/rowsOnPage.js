var rowsOnPageUrl = '/app_dev.php/admin/rows_on_page';
var setRowsOnPageUrl = '/app_dev.php/admin/user/setting/set_rows_on_page';

/**
 * Get rows on page
 *
 * @param integer rowsOnPageId
 */
function getRowsOnPage(rowsOnPageId) {
    $.ajax({
        type: "post",
        dataType: 'json',
        data: {
            rowsOnPageId: UserSetting.rowsOnPageId
        },
        url: rowsOnPageUrl,
        beforeSend: function() {
        },
        complete: function() {
            ListPagination.rowsOnPage = $("#pagination > .number_of_lines").val();
            setActionOnChangeRowsOnPage();
        },
        success: function(data) {
            if (data.response) {
                $('#pagination').append(data.rows.toString());
            }
        }
    });
}

/**
 * Set action on change rows on page
 */
function setActionOnChangeRowsOnPage() {
    $("#pagination > .number_of_lines").change(function() {
        ListPagination.rowsOnPage = $(this).val();
        ListPagination.page = 1;
        setRowsOnPage();
        refreshList();
    });
}

/**
 * Set rows on page
 */
function setRowsOnPage() {
    $.ajax({
        type: "post",
        dataType: 'json',
        data: {
            rowsOnPage: pagination.rowsOnPage
        },
        url: setRowsOnPageUrl,
        beforeSend: function() {
        },
        complete: function() {
        },
        success: function(data) {
            if (data.response) {
                UserSetting.rowsOnPageId = data.row_id;
            }
        }
    });
}