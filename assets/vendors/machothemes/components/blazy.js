if ( typeof(MachoThemes) === 'undefined' ) {
	var MachoThemes = {};
}

MachoThemes.initBlazyLoad = function ($) {
	setTimeout(function(){
		var selector = new Blazy({
			selector: '.blazy',
			offset  : 250
		});
	}, 500);
};