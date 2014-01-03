$(function() {
    $('#left_menu_toggle').click(function() {
        if ($('#left_menu').is(':visible')) {
            $('#left_menu').hide();
            $(this).addClass('hide_menu');
            $('#main').addClass('hide_menu');
            $('#footer > #pagination_count').addClass('hide_menu');
        }
        else {
            $('#left_menu').show();
            $(this).removeClass('hide_menu');
            $('#main').removeClass('hide_menu');
            $('#footer > #pagination_count').removeClass('hide_menu');
        }
    });
});

/**
 * Get left menu
 */
function getLeftMenu(editMode) {
    $.ajax({
        type: "post",
        dataType: 'json',
        data: {
            moduleId: UserSetting.moduleId,
            menuId: menuId,
            editMode: editMode
        },
        url: links.lefMenu,
        beforeSend: function() {
        },
        complete: function() {
            $('#left_menu_container').accordionMenu();
            setActionsOnLeftMenu();

            // if menuId == 2, don't show show all
            if (menuId == 2) {
                setDynamicMenu(true);
            }
            else {
                setDynamicMenu(editMode);
            }
        },
        success: function(data) {
            if (data.response) {
                $('#left_menu_container').empty().append(data.menu.toString());
            }
        }
    });
}

/**
 * Set dynamic menu
 *
 * @param boolean editMode
 */
function setDynamicMenu(editMode) {
    $('#left_menu_container > li.editable').each(function() {
        $(this).dynamicMenu({
            moduleId: UserSetting.moduleId,
            menuId: menuId,
            editMode: editMode
        });
    });
}

/**
 * Set actions on left menu
 */
function setActionsOnLeftMenu() {
    $('#left_menu_container > li > div > ul > li').on('click', 'a', function() {
        if (!$(this).parent().hasClass('selected')) {
            var url = getMainMenuUrl();

            $(this).parent().parent().find('> li').removeClass('selected');
            $(this).parent().addClass('selected');

            if ($(this).parent().parent().parent().parent().hasClass('group')) {
                listModel.set({ groupId: $(this).attr('list_id') });
            }

            if ($(this).parent().parent().parent().parent().hasClass('language')) {
                if (isEditMode(url)) {
                    editModel.set({ languageId: $(this).attr('list_id') });
                }
                else {
                    listModel.set({ languageId: $(this).attr('list_id') });
                }
            }

            if (isEditMode(url)) {
                editModel.set({isApplyOption: false});
                editView.render();
            }
            else {
                listView.refresh();
            }
        }

        return false;
    });
}