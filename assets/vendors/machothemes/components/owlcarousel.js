if ( typeof(MachoThemes) === 'undefined' ) {
	var MachoThemes = {};
}

MachoThemes.initOwlCarousel = function ($) {
	if ( typeof $.fn.owlCarousel !== 'undefined' ) {

		$('.owlCarousel').each(function (index) {

			var sliderSelector = '#owlCarousel-' + $(this).data('slider-id'); // this is the slider selector
			var sliderItems = $(this).data('slider-items');
			var sliderSpeed = $(this).data('slider-speed');
			var sliderAutoPlay = $(this).data('slider-auto-play');
			var sliderSingleItem = $(this).data('slider-single-item');

			//conversion of 1 to true & 0 to false


			// auto play
			sliderAutoPlay = !(sliderAutoPlay == 0 || sliderAutoPlay == 'false');
			// Custom Navigation events outside of the owlCarousel mark-up
			$(".newspaper-x-owl-next").on('click', function (event) {
				event.preventDefault();
				$(sliderSelector).trigger('next.owl.carousel');
			});
			$(".newspaper-x-owl-prev").on('click', function (event) {
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
};