if ( typeof(MachoThemes) === 'undefined' ) {
	var MachoThemes = {};
}

MachoThemes.init = function ($) {
	function getOwnMethods(obj) {
		var props = Object.getOwnPropertyNames(obj);
		return props.filter(function (prop) {
			return obj[ prop ] && obj[ prop ].constructor &&
					obj[ prop ].call && obj[ prop ].apply;
		});
	}

	var methods = getOwnMethods(MachoThemes);
	methods.pop();

	$.each(methods, function () {
		var init = this;
		if ( typeof(MachoThemes[ init ]) === 'function' ) {
			MachoThemes[ init ]($);
		}
	});
};