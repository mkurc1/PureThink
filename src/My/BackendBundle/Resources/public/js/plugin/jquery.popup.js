(function($) {

    $.fn.popup = function() {

        var url = this.attr('href');

        var editPopupModel = new EditModel();
        var editPopupView;

        $(this).click(function() {
            editPopupModel.set({
                menuId: 7,
                url: url
            });

            render();

            return false;
        });

        function render() {
            addBackground();
            addPopup();
        }

        function addBackground() {
            var bg = '<div class="popup-overall-bg"></div>';

            $('body').append(bg);
            addActionOnClickBackground();
        }

        function addActionOnClickBackground() {
            $('.popup-overall-bg').click(function() {
                close();
            });
        }

        function close() {
            $('.popup').remove();
            $('.popup-overall-bg').remove();
        }

        function addPopup() {
            var popup = $('<div class="popup"><div class="popup-close">X</div><div class="popup-content"></div></div>');

            $('body').append(popup);
            addActionOnClickClose();

            editPopupView = new EditView({
                el         : popup.find('.popup-content'),
                model      : editPopupModel,
                isMainEdit : false
            });

            popup.center();

            $.when(editPopupView.render()).done(function() {
                addSubmitButton(popup);

                popup.center();
            });
        }

        function addSubmitButton(popup) {
            var container = $('<div class="popup-button-container"></div>');
            var buttonClose = $('<button class="popup-button-close">Zamknij</button>');
            var buttonSubmit = $('<button class="popup-button-submit">Zapisz</button>');

            popup.append(container);
            container.append(buttonSubmit);
            container.append(buttonClose);

            addActionOnCloseButton(buttonClose);
            addActionOnSubmitButton(buttonSubmit);
        }

        function addActionOnCloseButton(button) {
            button.click(function() {
                close();
            });
        }

        function addActionOnSubmitButton(button) {
            button.click(function() {
                editPopupView.submit();
            });
        }

        function addActionOnClickClose() {
            $('.popup-close').click(function() {
                close();
            });
        }
    };

})(jQuery);