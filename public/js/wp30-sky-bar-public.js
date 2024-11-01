(function( $ ) {

	'use strict';

	$(function() {

		var barHeight;

		// Show notification bar
		if ( $('.wp30skybar').length > 0 ) {
			barHeight = $('.wp30skybar').outerHeight();
			$('body').css('padding-top', barHeight).addClass('has-wp30skybar');
		}

		// Hide Button
		$(document).on('click', '.wp30skybar-hide', function(e) {

			e.preventDefault();

			var $this = $(this);

			if ( !$this.hasClass('active') ) {
				$this.closest('.wp30skybar').removeClass('wp30skybar-shown').addClass('wp30skybar-hidden');
				$('body').css('padding-top', 0);
			}
		});

		// Show Button
		$(document).on('click', '.wp30skybar-show', function(e) {

			e.preventDefault();

			var $this = $(this);
			
			if ( !$this.hasClass('active') ) {
				barHeight = $('.wp30skybar').outerHeight();
				$this.closest('.wp30skybar').removeClass('wp30skybar-hidden').addClass('wp30skybar-shown');
				$('body').css('padding-top', barHeight);
			}
		});
	});

})( jQuery );
