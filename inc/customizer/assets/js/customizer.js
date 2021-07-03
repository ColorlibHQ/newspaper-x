(function ($) {
	jQuery(document).ready(function ($) {
		/**
		 * Bind an event for the add new widget
		 */
		$('.add-new-widget').on('click', function (event) {
			/**
			 * Define variables used in the script
			 * @type {any}
			 */
			var parent = $(this).parent(),
					id = parent.attr('id'),
					search = $('#widgets-search'),
					widgetList = $('#available-widgets-list').find('.widget-tpl');

			/**
			 * Reset the widget display state
			 */
			$.each(widgetList, function ($k, $v) {
				$(this).show();
			});

			/**
			 * Initiate a switch for the sidebars
			 */
			switch ( id ) {
				case 'customize-control-sidebars_widgets-header-widget-area':
				case 'customize-control-sidebars_widgets-content-area':
				case 'customize-control-sidebars_widgets-after-content-area':
					return true;
					break;
				default:
					$.each(widgetList, function ($k, $v) {
						search.removeAttr('disabled');
						var individualId = $(this).attr('data-widget-id');
						if ( individualId.search('newspaper_x_widget') != -1 || individualId.search('newspaper_x_header_module') != -1 || individualId.search('newspaper_x_banner') != -1 ) {
							$(this).hide();
						} else {
							$(this).show();
						}
					});
					break;
			}
		});
	});
})(jQuery);