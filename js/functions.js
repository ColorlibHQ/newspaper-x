jQuery(document).ready(function ($) {
	Bugle.initOwlCarousel($);
	Bugle.initNewsTicker($('.bugle-news-carousel'));
	Bugle.initGoToTop($);
	Bugle.initLazyLoad($);
	Bugle.initSearchForm($);
});


var Bugle = {
	initSearchForm : function ($) {
		$('#search-top-bar-submit').on('click', function (e) {
			e.preventDefault();
			$('#search-field-top-bar').toggleClass('opened');
		});
	},
	initLazyLoad   : function ($) {
		$(".lazy").lazyload({
			effect        : "fadeIn",
			skip_invisible: false
		});
		$("img.lazy").each(function() {
			$(this).attr("src", $(this).attr("data-original"));
			$(this).removeAttr("data-original");
		});
	},
	initGoToTop    : function ($) {
		var back_to_top = $('#back-to-top');

		back_to_top.on('click', function (event) {
			event.preventDefault();
			$('body,html').animate({
						scrollTop: 0
					}, 700
			);
		});
	},
	// News ticker carousel
	initNewsTicker : function (element) {
		element.owlCarousel({
					items          : 1,
					autoplay       : true,
					dots           : false,
					autoplayTimeout: 5000,
					loop           : true
				}
		);
	},
	// Owl Carousel - used to create carousels throughout the site
	// http://owlgraphic.com/owlcarousel/
	initOwlCarousel: function ($) {
		if ( typeof $.fn.owlCarousel !== 'undefined' ) {

			$('.owlCarousel').each(function (index) {

				var sliderSelector = '#owlCarousel-' + $(this).data('slider-id'); // this is the slider selector
				var sliderItems = $(this).data('slider-items');
				var sliderSpeed = $(this).data('slider-speed');
				var sliderAutoPlay = $(this).data('slider-auto-play');
				var sliderSingleItem = $(this).data('slider-single-item');

				//conversion of 1 to true & 0 to false


				// auto play
				if ( sliderAutoPlay == 0 || sliderAutoPlay == 'false' ) {
					sliderAutoPlay = false;
				} else {
					sliderAutoPlay = true;
				}
				// Custom Navigation events outside of the owlCarousel mark-up
				$(".bugle-owl-next").on('click', function (event) {
					event.preventDefault();
					$(sliderSelector).trigger('next.owl.carousel');
				});
				$(".bugle-owl-prev").on('click', function (event) {
					event.preventDefault();
					$(sliderSelector).trigger('prev.owl.carousel');
				});


				// instantiate the slider with all the options
				$(sliderSelector).owlCarousel({
					items          : sliderItems,
					loop           : false,
					margin         : 20,
					autoplay       : sliderAutoPlay,
					dots           : false,
					autoplayTimeout: sliderSpeed * 10,
					responsive     : {
						0  : {
							items: 1
						},
						768: {
							items: sliderItems
						}
					}
				});

			});

		} // end
	}
};