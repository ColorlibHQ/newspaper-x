/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {

	// Header text color.
	wp.customize('header_textcolor', function (value) {
		value.bind(function (to) {
			if ( 'blank' === to ) {
				$('.site-title, .site-description').css({
					'clip'    : 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				});
			} else {
				$('.site-title, .site-description').css({
					'clip'    : 'auto',
					'position': 'relative'
				});
				$('.site-title, .site-description').css({
					'color': to
				});
			}
		});
	});

})(jQuery);

/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {
	$(document).ready(function () {
		if ( 'undefined' === typeof wp || !wp.customize || !wp.customize.selectiveRefresh ) {
			return;
		}

		wp.customize.selectiveRefresh.bind('widget-updated', function (placement) {
			MachoThemes.initBlazyLoad($);
		});
	});
})(jQuery);