if ( typeof(MachoThemes) === 'undefined' ) {
	var MachoThemes = {};
}

MachoThemes.initNewsTicker = function ($) {
	$('.newspaper-x-news-carousel').owlCarousel({
				items          : 1,
				autoplay       : true,
				dots           : false,
				autoplayTimeout: 5000,
				loop           : true
			}
	);
};