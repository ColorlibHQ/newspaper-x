jQuery(document).ready(function () {
	var newspaper_x_aboutpage = newspaperXWelcomeScreenCustomizerObject.aboutpage;
	var newspaper_x_nr_actions_required = newspaperXWelcomeScreenCustomizerObject.nr_actions_required;

    /* Number of required actions */
	if ((typeof newspaper_x_aboutpage !== 'undefined') && (typeof newspaper_x_nr_actions_required !== 'undefined') && (newspaper_x_nr_actions_required != '0')) {
		jQuery('#accordion-section-themes .accordion-section-title').append('<a href="' + newspaper_x_aboutpage + '"><span class="newspaper-x-actions-count">' + newspaper_x_nr_actions_required + '</span></a>');
	}


});
