if ( typeof(MachoThemes) === 'undefined' ) {
	var MachoThemes = {};
}

MachoThemes.initAdsenseLoader = function ($) {
	var selector = $('.newspaper-x-adsense');
	if ( selector.length ) {
		// jQuery
		selector.adsenseLoader({
			onLoad: function ($ad) {
				$ad.addClass('adsense--loaded');
			}
		});
	}
};