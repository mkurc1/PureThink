(function($) {
    $.fn.accordionMenu = function() {
        var menu = $(this);
        var spaceForElements;
        var spaceForElement;
        var openElementCount;

        setMenuHideClass();
        hideAll();
        getSpaceForElements();
        setOpenElementCount();
        setSpaceForElement();
        getOpenElements();

        $(this).find('> li > a').click(function() {
            var menuClick = $(this).parent().find('.submenu_left');

             if (menuClick.hasClass('hideMenu')) {
                menuClick.removeClass('hideMenu');
                menuClick.addClass('showMenu');
                menuClick.show();
                incrementOpenElementCount();
                changeHeightElements();
            }
            else {
                menuClick.removeClass('showMenu');
                menuClick.addClass('hideMenu');
                decrementOpenElementCount();
                changeHeightElements();
            }
        });

        $(window).resize(function() {
            getSpaceForElements();
            setSpaceForElement();
            setElementHeight();
        });

        /**
         * Hide all
         */
        function hideAll() {
            menu.find('> li > div.hideMenu').hide();
        }

        /**
         * Get open elements
         */
        function getOpenElements() {
            $.each(menu.find('> li'), function(index, val) {
                $(val).find('.submenu_left')
                    .removeClass('hideMenu')
                    .addClass('showMenu')
                    .show();

                incrementOpenElementCount();
            });

            changeHeightElements();
        }

        /**
         * Change height elements
         */
        function changeHeightElements() {
            setSpaceForElement();
            setElementHeight();
        }

        /**
         * Set open element count
         */
        function setOpenElementCount() {
            openElementCount = menu.find('> li > div:visible').length;
        }

        /**
         * Increment open element count
         */
        function incrementOpenElementCount() {
            openElementCount++;
        }

        /**
         * Decrement open element count
         */
        function decrementOpenElementCount() {
            openElementCount--;
        }

        /**
         * Get space for elements
         */
        function getSpaceForElements() {
            var windowHeight = $(window).height();
            var menuMarginTop = menu.offset().top-$(window).scrollTop();
            var menuMaxHeight = windowHeight-menuMarginTop;
            var menuElementCount = menu.find('> li').length;
            var openElementPadding = getIntegerPart(menu.find('> li > div > ul').css('padding-top'), 'px');
            openElementPadding += getIntegerPart(menu.find('> li > div > ul').css('padding-bottom'), 'px');
            var menuElementCloseHeight = menu.find('> li > a').outerHeight(true);
            spaceForElements = menuMaxHeight - (menuElementCount*menuElementCloseHeight) - (menuElementCount*openElementPadding) - 41;
        }

        /**
         * Set space for element
         */
        function setSpaceForElement() {
            if (openElementCount === 0) {
                spaceForElement = spaceForElements;
            }
            else {
                spaceForElement = parseInt(spaceForElements/openElementCount, 10);
            }
        }

        /**
         * Set element height
         */
        function setElementHeight() {
            menu.find('> li > div.showMenu > ul').height(spaceForElement-26);

            menu.find('> li > div.showMenu').stop().animate({
                height: spaceForElement,
                queue: false
            }, 1000);

            menu.find('> li > div.hideMenu').stop().animate({
                height: 0,
            }, 1000, function() {
                menu.find('> li > div.hideMenu').hide();
            });
        }

        /**
         * Set menu hide class
         */
        function setMenuHideClass() {
            menu.find('> li > div.submenu_left').addClass('hideMenu');
        }

        /**
         * Get integer part
         *
         * @param string value
         * @param string removeValue
         * @return intger
         */
        function getIntegerPart(value, removeValue) {
            if (value)
                return parseInt(value.replace(removeValue, ''), 10);
            else
                return 0;
        }
    };
})(jQuery);