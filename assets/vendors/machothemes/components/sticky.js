if ( typeof(MachoThemes) === 'undefined' ) {
	var MachoThemes = {};
}

MachoThemes.initStickyMenu = function ($) {
	var selector = $('.stick-menu'),
			container = selector.find('.stick-menu-logo'),
			img = container.find('img'),
			lists = selector.find('.nav-menu > li'),
			width = 0,
			maxWidth = container.parents('.container').outerWidth() - 200;

	$.each(lists, function () {
		width += $(this).outerWidth();
	});

	if ( selector.length ) {
		var window_w = jQuery(window).width();
		if ( window_w > 768 ) {
			selector.sticky();

			if ( width >= maxWidth ) {
				return false;
			}

			selector.on('sticky-start', function () {
				img.animate({ width: '100%' });
				container.animate({ 'margin-right': '60px' });
			});

			selector.on('sticky-end', function () {
				img.animate({ width: 0 });
				container.animate({ 'margin-right': '0' });
			});
		}

		$(window).resize(function () {
			window_w = $(window).width();
			if ( window_w < 768 ) {
				selector.unstick();
			} else {
				selector.sticky();
			}
		});
	}
};