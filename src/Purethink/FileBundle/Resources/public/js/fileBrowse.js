var fileCatalog = '/uploads/';
var CKEditorFuncNum;

var listBrowseModel = new ListModel({
    url: Routing.generate('purethink_file_filebrowse_list')
});

$(function() {
    getCKEditorFuncNum();

    listBrowsView = new ListView({
        el           : '#file_borwse_list',
        model        : listBrowseModel,
        paginationEl : '#file_borwse_pagination',
        isMainList   : false
    });

    listBrowsView.render();
});

function setActionOnClickBrowseElement() {
    $('#file_borwse_list .browse_element').click(function() {
        var path = fileCatalog+$(this).attr('path');

        window.opener.CKEDITOR.tools.callFunction(CKEditorFuncNum, path);
        window.close();
    });
}

function getCKEditorFuncNum() {
    CKEditorFuncNum = getURLParameter('CKEditorFuncNum');
}