var rowsOnPageUrl = '/app_dev.php/admin/rows_on_page';

function getRowsOnPage(rowsOnPageId) {
    $.ajax({
        type: "post",
        dataType: 'json',
        data: {
            rowsOnPageId: rowsOnPageId
        },
        url: rowsOnPageUrl,
        beforeSend: function() {
        },
        complete: function() {
            rowsOnPage = $("#pagination > .number_of_lines").val();
        },
        success: function(data) {
            if (data.response) {
                $('#pagination').append(data.rows.toString());
            }
        }
    });
}