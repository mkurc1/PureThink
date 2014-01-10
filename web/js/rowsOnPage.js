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
            rowsOnPageId: userSettingModel.get('rowsOnPageId')
        },
        url: links.rowsOnPage,
        beforeSend: function() {
        },
        complete: function() {
            listView.paginationModel.set({ 'rowsOnPage': $("#pagination > .number_of_lines").val() });
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
        listView.paginationModel.set({ 'rowsOnPage': $(this).val() });
        listView.paginationModel.set({page: 1});
        setRowsOnPage();
        listView.refresh();
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
            rowsOnPage: listView.paginationModel.get('rowsOnPage')
        },
        url: links.setRowsOnPage,
        beforeSend: function() {
        },
        complete: function() {
        },
        success: function(data) {
            if (data.response) {
                userSettingModel.set({ rowsOnPageId: data.row_id });
            }
        }
    });
}