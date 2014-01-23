(function($) {
    $.fn.popup = function() {
        /**
         * @type string
         */
        var url = this.attr('href');

        // Object
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

        /**
         * Render
         */
        function render() {
            addBackground();
            addPopup();
        }

        /**
         * Add background
         */
        function addBackground() {
            var bg = '<div class="popup-overall-bg"></div>';

            $('body').append(bg);
            addActionOnClickBackground();
        }

        /**
         * Add action on click background
         */
        function addActionOnClickBackground() {
            $('.popup-overall-bg').click(function() {
                close();
            });
        }

        /**
         * Close
         */
        function close() {
            $('.popup').remove();
            $('.popup-overall-bg').remove();
        }

        /**
         * Add popup
         */
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

        /**
         * Add submit button
         *
         * @param object popup
         */
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

        /**
         * Add action on close button
         *
         * @param object button
         */
        function addActionOnCloseButton(button) {
            button.click(function() {
                close();
            });
        }

        /**
         * Add action on submit button
         *
         * @param object button
         */
        function addActionOnSubmitButton(button) {
            button.click(function() {
                editPopupView.submit();
            });
        }

        /**
         * Add action on click close
         */
        function addActionOnClickClose() {
            $('.popup-close').click(function() {
                close();
            });
        }
    };
})(jQuery);