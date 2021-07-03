jQuery(document).ready(function () {

	var newspaper_x_nr_actions_required = newspaperXWelcomeScreenObject.nr_actions_required;

	if ( (typeof newspaper_x_nr_actions_required !== 'undefined') && (newspaper_x_nr_actions_required != '0') ) {
		jQuery('li.newspaper-x-w-red-tab a').append('<span class="newspaper-x-actions-count">' + newspaper_x_nr_actions_required + '</span>');
	}

	/* Dismiss required actions */
	jQuery(".newspaper-x-required-action-button").on('click', function () {

		var id = jQuery(this).attr('id'),
				action = jQuery(this).attr('data-action');
		jQuery.ajax({
			type      : "GET",
			data      : { action: 'newspaper_x_dismiss_required_action', id: id, todo: action },
			dataType  : "html",
			url       : newspaperXWelcomeScreenObject.ajaxurl,
			beforeSend: function (data, settings) {
				jQuery('.newspaper-x-tab-pane#actions_required h1').append('<div id="temp_load" style="text-align:center"><img src=' + newspaperXWelcomeScreenObject.template_directory + '"/inc/libraries/welcome-screenreen/img/ajax-loader.gif" /></div>');
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
