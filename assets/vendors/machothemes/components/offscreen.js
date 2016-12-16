if ( typeof(MachoThemes) === 'undefined' ) {
	var MachoThemes = {};
}

MachoThemes.initOffscreen = function ($) {
	$('.sub-menu').on('hover', function () {
		$(this).find('.sub-menu').offscreen({
			rightClass : 'right-edge',
			widthOffset: 40, //px value
			smartResize: true
		});
	});
};