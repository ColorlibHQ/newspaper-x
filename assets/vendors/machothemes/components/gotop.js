if ( typeof(MachoThemes) === 'undefined' ) {
	var MachoThemes = {};
}

MachoThemes.initGoToTop = function ($) {
	var offset = 300,
			scroll_top_duration = 700,
			$back_to_top = $('#back-to-top');
	jQuery(window).scroll(function () {
		( jQuery(this).scrollTop() > offset ) ? $back_to_top.addClass('back-to-top-is-visible') : $back_to_top.removeClass('back-to-top-is-visible');
	});
	$back_to_top.on('click', function (event) {
		event.preventDefault();
		jQuery('body,html').animate({
					scrollTop: 0
				}, scroll_top_duration
		);
	});
};