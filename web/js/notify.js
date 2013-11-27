/**
 * Notify
 *
 * @param string type
 * @param string message
 */
function notify(type, message) {
    if (!isIdExitst('notify_container')) {
        var notifyContainer = '<div id="notify_container"></div>';
        $('body').append(notifyContainer);
    }

    var notifyTimer = setInterval(removeNotify, 10000);

    var hover = type;

    switch(type) {
        case 'success':
            hover = "Sukces";
            break;
        case 'fail':
            hover = "Porażka";
            break;
    }

    var container = $('<div class="notify '+type+'"><div class="left"></div><span><span class="hover">'+hover+'</span>'+message+'</span><div class="close">x</div></div>');
    $('#notify_container').prepend(container);
    container.find('.close').click(removeNotify);

    /**
     * Remove notify
     */
    function removeNotify() {
        this.notifyTimer = clearInterval(notifyTimer);

        $('.notify').last().fadeOut(function() {
            $(this).remove();

            if ($('#notify_container > .notify').length == 0) {
                $('#notify_container').remove();
            }
        });
    }
}