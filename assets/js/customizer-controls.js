/**
 * Keeps a range control's readout in step with its slider.
 *
 * Used by the Customizer control and by the post widgets' forms. Delegated from
 * the document rather than bound per control: the Customizer and the widgets
 * screen both build their markup lazily, so a control may not exist yet when
 * this runs.
 */
( function () {
	'use strict';

	document.addEventListener( 'input', function ( event ) {
		var input = event.target;

		if ( ! input.matches ) {
			return;
		}

		var output;

		if ( input.matches( '.newspaper-x-range input[type="range"]' ) ) {
			output = input.parentNode.querySelector( '.newspaper-x-range__value' );
		} else if ( input.matches( 'input[type="range"].newspaper-x-widget-range' ) ) {
			output = input.nextElementSibling;
		}

		if ( output && 'OUTPUT' === output.tagName ) {
			output.value = input.value;
		}
	} );
}() );
