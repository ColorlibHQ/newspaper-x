if ( typeof(MachoThemes) === 'undefined' ) {
	var MachoThemes = {};
}

MachoThemes.initBlazyLoad = function ($) {
	var selector = new Blazy({
		selector: '.blazy',
		offset  : -50
	});
};