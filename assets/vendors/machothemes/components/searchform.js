if ( typeof(MachoThemes) === 'undefined' ) {
	var MachoThemes = {};
}

MachoThemes.initSearchForm = function ($) {
	var element = $('.header-search-form'),
			input = $('#search-field-top-bar'),
			inputSubmit = $('#search-top-bar-submit'),
			trigger = $('.search-form-opener');

	trigger.on('click', function (e) {
		e.preventDefault();
		trigger.toggleClass('hide');
		element.toggleClass('opened');
		if ( input.val() !== '' ) {
			inputSubmit.addClass('submit-button').removeClass('close-button');
			inputSubmit.html('<span class="fa fa-search"></span>');
		}
	});

	input.on('keyup', function () {
		if ( $(this).val() !== '' ) {
			inputSubmit.addClass('submit-button').removeClass('close-button');
			inputSubmit.html('<span class="fa fa-search"></span>');
		} else {
			inputSubmit.addClass('close-button').removeClass('submit-button');
			inputSubmit.html('<span class="first-bar"></span><span class="second-bar"></span>');
		}
	});

	inputSubmit.on('click', function () {
		if ( $(this).hasClass('submit-button') ) {
			$(this).parent().submit();
		} else {
			trigger.toggleClass('hide');
			element.toggleClass('opened');
		}
	});
};