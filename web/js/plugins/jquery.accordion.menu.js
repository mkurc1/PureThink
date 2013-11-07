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
            var menuClick = $(this);

             if (menuClick.parent().find('.submenu_left').hasClass('hideMenu')) {
                menuClick.parent().find('.submenu_left').show();
                menuClick.parent().find('.submenu_left').removeClass('hideMenu');
                menuClick.parent().find('.submenu_left').addClass('showMenu');
                incrementOpenElementCount();
                changeHeightElements();
            }
            else {
                menuClick.parent().find('.submenu_left').removeClass('showMenu');
                menuClick.parent().find('.submenu_left').addClass('hideMenu');
                decrementOpenElementCount();
                changeHeightElements();
            }
        });

        $(window).resize(function() {
            getSpaceForElements();
            setSpaceForElement();
            setElementHeight();
        });

        function hideAll() {
            menu.find('> li > div.hideMenu').hide();
        }

        function getOpenElements() {
            $.each(menu.find('> li'), function(index, val) {
                $(this).find('.submenu_left').removeClass('hideMenu');
                $(this).find('.submenu_left').addClass('showMenu');
                $(this).find('.submenu_left').show();
                $(this).css('background-color', '#f8f9fa');
                incrementOpenElementCount();
            });

            changeHeightElements();
        }

        function changeHeightElements() {
            setSpaceForElement();
            setElementHeight();
        }

        function setOpenElementCount() {
            openElementCount = menu.find('> li > div:visible').length;
        }

        function incrementOpenElementCount() {
            openElementCount++;
        }

        function decrementOpenElementCount() {
            openElementCount--;
        }

        function getSpaceForElements() {
            var windowHeight = $(window).height();
            var menuMarginTop = menu.offset().top;
            var menuMaxHeight = windowHeight - menuMarginTop;
            var menuElementCount = menu.find('> li').length;
            var openElementPadding = getIntegerPart(menu.find('> li > div > ul').css('padding-top'), 'px');
            openElementPadding += getIntegerPart(menu.find('> li > div > ul').css('padding-bottom'), 'px');
            var menuElementCloseHeight = menu.find('> li > a').outerHeight(true);
            spaceForElements = menuMaxHeight - (menuElementCount * menuElementCloseHeight) - (menuElementCount * openElementPadding) - 1;
        }

        function setSpaceForElement() {
            if (openElementCount == 0)
                spaceForElement = spaceForElements;
            else
                spaceForElement = parseInt(spaceForElements / openElementCount);
        }

        function setElementHeight() {
            menu.find('> li > div.showMenu').animate({
                height: spaceForElement,
                queue: false
            }, 1000);

            menu.find('> li > div.hideMenu').animate({
                height: 0
            }, 1000, function() {
                menu.find('> li > div.hideMenu').hide();
            });
        }

        function setMenuHideClass() {
            menu.find('> li > div.submenu_left').addClass('hideMenu');
        }

        function getIntegerPart(value, removeValue) {
            if (value)
                return parseInt(value.split(removeValue)[0]);
            else
                return 0;
        }
    }
})(jQuery);
