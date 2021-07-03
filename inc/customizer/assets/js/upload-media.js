jQuery(function ($) {
	mediaControl = {
		// Initializes a new media manager or returns an existing frame.
		// @see wp.media.featuredImage.frame()
		selector : null,
		size     : null,
		container: null,
		frame    : function () {
			if ( this._frame )
				return this._frame;

			this._frame = wp.media({
				title   : 'Image',
				library : {
					type: 'image'
				},
				button  : {
					text: 'Update'
				},
				multiple: false
			});

			this._frame.on('open', this.updateFrame).state('library').on('select', this.select);

			return this._frame;
		},

		select: function () {
			// Do something when the "update" button is clicked after a selection is made.
			var id = $('.attachments').find('.selected').attr('data-id');
			var selector = $('.newspaper-x-media-control').find(mediaControl.selector);

			if ( !selector.length ) {
				return false;
			}

			selector.val(id);
			var data = {
				action         : 'newspaper_x_get_attachment_image',
				attachment_id  : id,
				attachment_size: mediaControl.size
			};

			jQuery.post(ajaxurl, data, function (response) {
				$(mediaControl.container).find('img').remove();
				$(mediaControl.container).find('label').after(response);
				$('.newspaper-x-media-control').find(mediaControl.selector).change();
			});
		},

		init: function () {
			var context = $('#wpbody, .wp-customizer');
			context.on('click', '.newspaper-x-media-control > .upload-button', function (e) {
				e.preventDefault();
				var container = $(this).parent(),
						sibling = container.find('.image-id'),
						id = sibling.attr('id');

				mediaControl.size = $('[data-delegate="' + id + '"]').val();
				mediaControl.container = container;
				mediaControl.selector = '#' + id;
				mediaControl.frame().open();
			});

			context.on('click', '.newspaper-x-media-control > .remove-button', function (e) {
				e.preventDefault();
				var container = $(this).parent(),
						sibling = container.find('.image-id'),
						img = container.find('img');

				img.remove();
				sibling.val('').trigger('change');
			})
		}
	};

	mediaControl.init();
});