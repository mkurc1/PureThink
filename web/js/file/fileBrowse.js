var fileCatalog = '/uploads/';
var CKEditorFuncNum;

$(function() {
    getCKEditorFuncNum();

    $('#file_borwse_list tr td .browse_element').click(function() {
        var path = fileCatalog+$(this).attr('path');

        window.opener.CKEDITOR.tools.callFunction(CKEditorFuncNum, path);
        window.close();
    });
});

/**
 * Get CKEditorFuncNum
 */
function getCKEditorFuncNum() {
    CKEditorFuncNum = getURLParameter('CKEditorFuncNum');
}