jQuery(document).ready(function () {

    /* If there are required actions, add an icon with the number of required actions in the About newspaperx page -> Actions required tab */
    var newspaperx_nr_actions_required = newspaperxWelcomeScreenObject.nr_actions_required;

    if ((typeof newspaperx_nr_actions_required !== 'undefined') && (newspaperx_nr_actions_required != '0')) {
        jQuery('li.newspaperx-w-red-tab a').append('<span class="newspaperx-actions-count">' + newspaperx_nr_actions_required + '</span>');
    }

    /* Dismiss required actions */
    jQuery(".newspaperx-dismiss-required-action").click(function () {

        var id = jQuery(this).attr('id');
        console.log(id);
        jQuery.ajax({
            type: "GET",
            data: {action: 'newspaperx_dismiss_required_action', dismiss_id: id},
            dataType: "html",
            url: newspaperxWelcomeScreenObject.ajaxurl,
            beforeSend: function (data, settings) {
                jQuery('.newspaperx-tab-pane#actions_required h1').append('<div id="temp_load" style="text-align:center"><img src="' + newspaperxWelcomeScreenObject.template_directory + '/inc/admin/welcome-screen/img/ajax-loader.gif" /></div>');
            },
            success: function (data) {
                jQuery("#temp_load").remove();
                /* Remove loading gif */
                jQuery('#' + data).parent().remove();
                /* Remove required action box */

                var newspaperx_actions_count = jQuery('.newspaperx-actions-count').text();
                /* Decrease or remove the counter for required actions */
                if (typeof newspaperx_actions_count !== 'undefined') {
                    if (newspaperx_actions_count == '1') {
                        jQuery('.newspaperx-actions-count').remove();
                        jQuery('.newspaperx-tab-pane#actions_required').append('<p>' + newspaperxWelcomeScreenObject.no_required_actions_text + '</p>');
                    }
                    else {
                        jQuery('.newspaperx-actions-count').text(parseInt(newspaperx_actions_count) - 1);
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    /* Tabs in welcome page */
    function newspaperx_welcome_page_tabs(event) {
        jQuery(event).parent().addClass("active");
        jQuery(event).parent().siblings().removeClass("active");
        var tab = jQuery(event).attr("href");
        jQuery(".newspaperx-tab-pane").not(tab).css("display", "none");
        jQuery(tab).fadeIn();
    }

    var newspaperx_actions_anchor = location.hash;

    if ((typeof newspaperx_actions_anchor !== 'undefined') && (newspaperx_actions_anchor != '')) {
        newspaperx_welcome_page_tabs('a[href="' + newspaperx_actions_anchor + '"]');
    }

    jQuery(".newspaperx-nav-tabs a").click(function (event) {
        event.preventDefault();
        newspaperx_welcome_page_tabs(this);
    });

    /* Tab Content height matches admin menu height for scrolling purpouses */
    $tab = jQuery('.newspaperx-tab-content > div');
    $admin_menu_height = jQuery('#adminmenu').height();
    if ((typeof $tab !== 'undefined') && (typeof $admin_menu_height !== 'undefined')) {
        $newheight = $admin_menu_height - 180;
        $tab.css('min-height', $newheight);
    }

});
