(function( $ ) {
	'use strict';

	$( document ).ready(function() {
		//console.log(tppdn);
		$("#tppdn-tabs").tabs();
		
		$('.tp_colorpiker').minicolors();

		$('.tp_colorpiker_rgba').minicolors({
			format: 'rgb',
			opacity: true,
		});

	});

})( jQuery );
