$(function() {
    showNotifications();
});

function showNotifications() {
    $.each($('.flash-message div'), function(index, value) {
        $value = $(value);

        switch($value.attr('type')) {
            case 'success':
                showSuccessNotification($value.text());
                break;
            case 'error':
                showErrorNotification($value.text());
                break;
            default:
                showDefaultNotification($value.text());
        }
    });
}

function showSuccessNotification(text) {
    alertify.success(text);
}

function showErrorNotification(text) {
    alertify.error(text);
}

function showDefaultNotification(text) {
    alertify.log(text);
}