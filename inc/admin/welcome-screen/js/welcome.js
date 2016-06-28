jQuery(document).ready(function () {

    /* If there are required actions, add an icon with the number of required actions in the About ensign page -> Actions required tab */
    var bugle_nr_actions_required = ensignWelcomeScreenObject.nr_actions_required;

    if ((typeof bugle_nr_actions_required !== 'undefined') && (bugle_nr_actions_required != '0')) {
        jQuery('li.bugle-w-red-tab a').append('<span class="bugle-actions-count">' + bugle_nr_actions_required + '</span>');
    }

    /* Dismiss required actions */
    jQuery(".bugle-dismiss-required-action").click(function () {

        var id = jQuery(this).attr('id');
        console.log(id);
        jQuery.ajax({
            type: "GET",
            data: {action: 'bugle_dismiss_required_action', dismiss_id: id},
            dataType: "html",
            url: ensignWelcomeScreenObject.ajaxurl,
            beforeSend: function (data, settings) {
                jQuery('.bugle-tab-pane#actions_required h1').append('<div id="temp_load" style="text-align:center"><img src="' + ensignWelcomeScreenObject.template_directory + '/inc/admin/welcome-screen/img/ajax-loader.gif" /></div>');
            },
            success: function (data) {
                jQuery("#temp_load").remove();
                /* Remove loading gif */
                jQuery('#' + data).parent().remove();
                /* Remove required action box */

                var bugle_actions_count = jQuery('.bugle-actions-count').text();
                /* Decrease or remove the counter for required actions */
                if (typeof bugle_actions_count !== 'undefined') {
                    if (bugle_actions_count == '1') {
                        jQuery('.bugle-actions-count').remove();
                        jQuery('.bugle-tab-pane#actions_required').append('<p>' + ensignWelcomeScreenObject.no_required_actions_text + '</p>');
                    }
                    else {
                        jQuery('.bugle-actions-count').text(parseInt(bugle_actions_count) - 1);
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    /* Tabs in welcome page */
    function bugle_welcome_page_tabs(event) {
        jQuery(event).parent().addClass("active");
        jQuery(event).parent().siblings().removeClass("active");
        var tab = jQuery(event).attr("href");
        jQuery(".bugle-tab-pane").not(tab).css("display", "none");
        jQuery(tab).fadeIn();
    }

    var bugle_actions_anchor = location.hash;

    if ((typeof bugle_actions_anchor !== 'undefined') && (bugle_actions_anchor != '')) {
        bugle_welcome_page_tabs('a[href="' + bugle_actions_anchor + '"]');
    }

    jQuery(".bugle-nav-tabs a").click(function (event) {
        event.preventDefault();
        bugle_welcome_page_tabs(this);
    });

    /* Tab Content height matches admin menu height for scrolling purpouses */
    $tab = jQuery('.bugle-tab-content > div');
    $admin_menu_height = jQuery('#adminmenu').height();
    if ((typeof $tab !== 'undefined') && (typeof $admin_menu_height !== 'undefined')) {
        $newheight = $admin_menu_height - 180;
        $tab.css('min-height', $newheight);
    }

});
