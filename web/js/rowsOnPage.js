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
        url: links.rowsOnPage,
        beforeSend: function() {
        },
        complete: function() {
            paginationModel.set({'rowsOnPage': $("#pagination > .number_of_lines").val()});
            setActionOnChangeRowsOnPage();
            beautifySelects();
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
        paginationModel.set({'rowsOnPage': $(this).val()});
        paginationModel.set({page: 1});
        setRowsOnPage();
        List.refresh();
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
            rowsOnPage: paginationModel.get('rowsOnPage')
        },
        url: links.setRowsOnPage,
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