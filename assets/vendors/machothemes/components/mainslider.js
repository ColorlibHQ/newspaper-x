if ( typeof(MachoThemes) === 'undefined' ) {
	var MachoThemes = {};
}

MachoThemes.initMainSlider = function ($) {
	var owl = $('.newspaper-x-slider');
	if ( owl.length ) {

		owl.on('initialized.owl.carousel', function () {
			$('.owl-nav-list').addClass('active');
		});

		owl.owlCarousel({
			loop           : true,
			items          : 1,
			dots           : false,
			mouseDrag      : true,
			navText        : '',
			// navText     : [ "<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>" ],
			navClass       : [ "main-slider-previous", "main-slider-next" ],
			autoplay       : true,
			autoplayTimeout: 17000,
			responsive     : {
				1   : {
					nav : false,
					dots: false
				},
				600 : {
					nav : false,
					dots: true
				},
				991 : {
					nav : false,
					dots: true

				},
				1300: {
					nav : true,
					dots: true
				}
			}
		}).on('translated.owl.carousel', function (event) {

			$('.owl-nav-list li.active').removeClass('active');
			$('.owl-nav-list li:eq(' + event.page.index + ')').addClass('active');

		}).on('changed.owl.carousel', function (event) {

			// future enhancement

		});

		$('.owl-nav-list li').click(function () {
			var slide_index = $(this).index();

			owl.trigger("to.owl.carousel", [ slide_index, 300 ]);
			return false;
		})

	}
};