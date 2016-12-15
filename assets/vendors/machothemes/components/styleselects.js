if ( typeof(MachoThemes) === 'undefined' ) {
	var MachoThemes = {};
}

MachoThemes.initStyleSelects = function ($) {
	var selects = $('select');
	$.each(selects, function () {
		if ( $(this).parent().hasClass('styled-select') ) {
			return false;
		}

		$(this).wrap('<div class="styled-select"></div>');
	});
};