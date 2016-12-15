jQuery(document).ready(function () {

	/* If there are required actions, add an icon with the number of required actions in the About newsmag page -> Actions required tab */
	var newspaper_x_nr_actions_required = newsmagWelcomeScreenObject.nr_actions_required;

	if ( (typeof newspaper_x_nr_actions_required !== 'undefined') && (newspaper_x_nr_actions_required != '0') ) {
		jQuery('li.newspaper-x-w-red-tab a').append('<span class="newspaper-x-actions-count">' + newspaper_x_nr_actions_required + '</span>');
	}

	/* Dismiss required actions */
	jQuery(".newspaper-x-required-action-button").click(function () {

		var id = jQuery(this).attr('id'),
				action = jQuery(this).attr('data-action');
		jQuery.ajax({
			type      : "GET",
			data      : { action: 'newspaper_x_dismiss_required_action', id: id, todo: action },
			dataType  : "html",
			url       : newsmagWelcomeScreenObject.ajaxurl,
			beforeSend: function (data, settings) {
				jQuery('.newspaper-x-tab-pane#actions_required h1').append('<div id="temp_load" style="text-align:center"><img src="' + newsmagWelcomeScreenObject.template_directory + '/inc/admin/welcome-screen/img/ajax-loader.gif" /></div>');
			},
			success   : function (data) {
				location.reload();
				jQuery("#temp_load").remove();
				/* Remove loading gif */
			},
			error     : function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
			}
		});
	});
});
