/**
 * File epsilon.js.
 *
 *
 * Epsilon Framework
 */

(function ($) {
	var EpsilonFramework = {};

	EpsilonFramework.rangeSliders = function (selector) {
		var context = $(selector),
				slider = context.find('.ss-slider'),
				input = context.find('.rl-slider'),
				input_id = input.attr('id'),
				id = slider.attr('id'),
				min = $('#' + id).attr('data-attr-min'),
				max = $('#' + id).attr('data-attr-max'),
				step = $('#' + id).attr('data-attr-step');

		$('#' + id).slider({
			value: $('#' + input_id).attr('value'),
			range: 'min',
			min  : parseFloat(min),
			max  : parseFloat(max),
			step : parseFloat(step),
			slide: function (event, ui) {
				$('#' + input_id).attr('value', ui.value).change();
			}
		});

		$(input).on('focus', function () {
			$(this).blur();
		});

		$('#' + input_id).attr('value', ($('#' + id).slider("value")));
		$('#' + input_id).change(function () {
			$('#' + id).slider({
				value: $(this).val()
			});
		});
	};

	EpsilonFramework.typography = {
		/**
		 * Selectize instance
		 */
		_selectize: null,

		/**
		 * K/V Pair
		 */
		_linkedFonts: {},

		/**
		 * Initiate function
		 * @private
		 */
		_init: function (selector) {
			if ( selector.length ) {
				var self = this,
						numbers = $('.mte-number-field');

				$.each(selector, function () {
					var container = $(this),
							uniqueId = container.attr('data-unique-id'),
							selects = container.find('select'),
							inputs = container.find('.mte-typography-input');

					/**
					 * Instantiate the selectize javascript plugin
					 * and the input type number
					 */
					try {
						self._selectize = selects.selectize();

						$.each(selects, function () {
							self._linkedFonts[ $(selects[ 0 ]).attr('id') ] = $(selects[ 1 ]).attr('id');
						});

					}
					catch ( err ) {
						/**
						 * In case the selectize plugin is not loaded, raise an error
						 */
						console.warn('selectize not yet loaded');
					}
					/**
					 * On triggering the change event, create a json with the values and send it to the preview window
					 */
					inputs.on('change', function () {
						var val = EpsilonFramework.typography._parseJson(inputs, uniqueId);
						$('#hidden_input_' + uniqueId).val(val).trigger('change');
					});
				});

				$.each(numbers, function () {
					EpsilonFramework.typography._number($(this));
				});
				/**
				 * Add/subtract from the input type number fields
				 */
				$('.incrementor').on('click', function (e) {
					e.preventDefault();
					EpsilonFramework.typography._calcValue($(this));
				});

				/**
				 * Don't allow a value smaller than 0 in number fields
				 */
				numbers.find('input').on('change', function () {
					if ( $(this).val() < 0 ) {
						$(this).val(0).trigger('change');
					}
				});

				$.each(self._linkedFonts, function ($id, $target) {
					$('#' + $id).on('change', function () {
						if ( $(this).val() === 'Select font' || $(this).val() === 'default_font' ) {
							EpsilonFramework.typography._setSelects($(this).val(), $target, true);
						}

						EpsilonFramework.typography._setSelects($(this).val(), $target, false);
					});
				});

				/**
				 * Reset button
				 */
				$('.mte-typography-default').on('click', function (e) {
					e.preventDefault();
					var element = $(this);
					EpsilonFramework.typography._resetDefault(element);
				});
			}
		},

		/**
		 *
		 * @param value
		 * @param target
		 * @param reset
		 * @private
		 */
		_setSelects: function (value, target, reset) {
			var data = {
						'action': 'epsilon_retrieve_font_weights',
						'args'  : value
					},
					selectize = $('#' + target),
					instance = selectize[ 0 ].selectize;

			if ( reset ) {
				instance.clear();
				instance.clearOptions();
				instance.load(function (callback) {
					var obj = { 'text': 'Theme default', 'value': 'initial' };
					callback(obj);
				});
				instance.setValue('initial');

				return;
			}

			jQuery.ajax({
				dataType: 'json',
				type    : 'POST',
				url     : WPUrls.ajaxurl,
				data    : data,
				complete: function (json) {
					var json = $.parseJSON(json.responseText);
					instance.clear();
					instance.clearOptions();
					instance.load(function (callback) {
						callback(json);
					});
					instance.setValue('initial');
				}
			});
		},

		/**
		 * Reset defaults
		 *
		 * @param element
		 * @private
		 */
		_resetDefault: function (element) {
			var container = $(element).parent(),
					uniqueId = container.attr('data-unique-id'),
					selects = container.find('select'),
					inputs = container.find('inputs');

			var fontFamily = selects[ 0 ].selectize,
					fontWeight = selects[ 1 ].selectize,
					fontStyle = selects[ 2 ].selectize;

			var object = {
						action: 'epsilon_generate_typography_css',
						id    : uniqueId,
						data  : {
							'selectors': $('#selectors_' + uniqueId).val(),
							'json'     : {}
						}
					},
					api = wp.customize;

			fontFamily.setValue('default_font');
			fontStyle.setValue('initial');

			if ( $('#' + uniqueId + '-font-size').length ) {
				$('#' + uniqueId + '-font-size').val('15').trigger('blur');
				object.data.json[ 'font-size' ] = '15';
			}

			if ( $('#' + uniqueId + '-line-height').length ) {
				$('#' + uniqueId + '-line-height').val('22').trigger('change').trigger('blur');
				object.data.json[ 'line-height' ] = '22';
			}

			object.data.json[ 'font-family' ] = 'default_font';
			object.data.json[ 'font-weight' ] = 'initial';
			object.data.json[ 'font-style' ] = 'initial';

			api.previewer.send('update-inline-css', object);
		},

		/**
		 * parse/create the json and send it to the preview window
		 *
		 * @param inputs
		 * @param id
		 * @private
		 */
		_parseJson: function (inputs, id) {
			var object = {
						action: 'epsilon_generate_typography_css',
						id    : id,
						data  : {
							'selectors': $('#selectors_' + id).val(),
							'json'     : {}
						}
					},
					api = wp.customize;


			$.each(inputs, function (index, value) {
				var key = $(value).attr('id'),
						replace = id + '-';
				key = key.replace(replace, '');

				object.data[ 'json' ][ key ] = $(value).val();
			});

			api.previewer.send('update-inline-css', object);
			return JSON.stringify(object.data);
		},

		/**
		 * Initiate the Number fields
		 *
		 * @param el
		 * @private
		 */
		_number: function (el) {
			var input = el.find('input');
			input.on('blur keyup keypress change', function () {
				var unit = $(this).siblings('span');
				if ( $(this).val() > 99 ) {
					unit.animate({ 'left': 35 }, 0);
				} else {
					unit.animate({ 'left': 25 }, 0);
				}
			});

			el.append('<a href="#" class="arrow-up incrementor"  data-increment="up"><span class="dashicons dashicons-arrow-up"></span></a>' +
					'<a href="#" class="arrow-down incrementor" data-increment="down"><span class="dashicons dashicons-arrow-down"></span></a>');
		},

		/**
		 * Calculate the value of the input number fields
		 *
		 * @param el
		 * @private
		 */
		_calcValue: function (el) {
			var input = $(el.siblings('input')),
					unit = input.siblings('span');

			switch ( $(el).attr('data-increment') ) {
				case 'up':
					if ( input.val() == 100 ) {
						unit.animate({ 'left': 35 }, 10);
					}
					input.val(parseInt(input.val()) + 1).trigger('change');
					break;
				case 'down':
					if ( input.val() == 0 ) {
						return;
					}
					if ( input.val() == 99 ) {
						unit.animate({ 'left': 25 }, 10);
					}
					input.val(parseInt(input.val()) - 1).trigger('change');
					break;
			}
		}
	};

	EpsilonFramework.colorSchemes = function (selector) {
		/**
		 * Set variables
		 */
		var context = $(selector),
				options = context.find('.mte-color-option'),
				input = context.parent().find('.mte-color-scheme-input'),
				json = $.parseJSON(options.first().find('input').val()),
				api = wp.customize,
				colorSettings = [],
				css = {
					action: 'epsilon_generate_css',
					data  : {}
				};

		$.each(json, function (index, value) {
			index = index.replace(/-/g, '_');
			colorSettings.push('epsilon_' + index + '_color');
		});

		function updateCSS() {
			_.each(colorSettings, function (setting) {
				css.data[ setting ] = api(setting)();
			});
			api.previewer.send('update-inline-css', css)
		}

		_.each(colorSettings, function (setting) {
			api(setting, function (setting) {
				setting.bind(updateCSS);
			});
		});

		/**
		 * On clicking a color scheme, update the color pickers
		 */
		$('.mte-color-option').on('click', function () {
			var val = $(this).attr('data-color-id'),
					json = $.parseJSON($(this).find('input').val());

			/**
			 * find the customizer options
			 */
			$.each(json, function (index, value) {
				index = index.replace(/-/g, '_');
				colorSettings.push('epsilon_' + index + '_color');
				/**
				 * Set values
				 */
				wp.customize('epsilon_' + index + '_color').set(value);
			});

			/**
			 * Remove the selected class from siblings
			 */
			$(this).siblings('.mte-color-option').removeClass('selected');
			/**
			 * Make active the current selection
			 */
			$(this).addClass('selected');
			/**
			 * Trigger change
			 */
			input.val(val).change();

			_.each(colorSettings, function (setting) {
				api(setting, function (setting) {
					setting.bind(updateCSS());
				});
			});
		});
	};

	$(document).on('widget-updated widget-added', function (a, selector) {
		EpsilonFramework.rangeSliders(selector);
	});

	if ( typeof(wp) !== 'undefined' ) {
		if ( typeof(wp.customize) !== 'undefined' ) {
			wp.customize.bind('ready', function () {
				EpsilonFramework.colorSchemes('.mte-color-scheme');
				EpsilonFramework.typography._init($('.mte-typography-container'));
			});
		}
	}


})(jQuery);