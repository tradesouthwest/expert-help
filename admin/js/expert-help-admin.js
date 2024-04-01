(function( $ ) {
	'use strict';

	function save_main_options_ajax() {
		$('.main-options-form').submit( function () {
			 var b =  $(this).serialize();
			 $.post( 'options.php', b ).error( 
				 function() {
					 alert('error');
				 }).success( function() {
					 alert('success');   
				 });
				 return false;    
			 });
		 }
// usage: save_main_options_ajax();
})( jQuery );
