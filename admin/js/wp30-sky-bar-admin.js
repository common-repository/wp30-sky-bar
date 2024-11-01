(function( $ ) {

	'use strict';

	$(function() {

		// Tabs
		$(document).on('click', '.wp30skybar-tabs-nav a', function(e){
			e.preventDefault();
			var $this = $(this),
				target = $this.attr('href');
			if ( !$this.hasClass('active') ) {
				$this.parent().parent().find('a.active').removeClass('active');
				$this.addClass('active');
				$this.parent().parent().next().children().siblings().removeClass('active');
				$this.parent().parent().next().find( target ).addClass('active');
				$this.parent().parent().prev().val( target.replace('#tab-',''));
			}
		});

		// Display conditions manager
		$(document).on('click', '.condition-checkbox', function(e){
			var $this = $(this),
				panel = '#'+$this.attr('id')+'-panel',
				disable = $this.data('disable');
			if ( !$this.hasClass('disabled') ) {
				if ( $this.hasClass('active') ) {
					$this.removeClass('active');
					$this.find('input').val('');
					$(panel).removeClass('active');
					if ( disable ) {
						$('#condition-'+disable).removeClass('disabled');
					}
				} else {
					$this.addClass('active');
					$(panel).addClass('active');
					$this.find('input').val('active');
					if ( disable ) {
						$('#condition-'+disable).addClass('disabled');
					}
				}
			}
		});

		// Preview Bar Button
		$(document).on('click', '#preview-bar', function(e){
			e.preventDefault();
			$('.wp30skybar').remove();
			$('body').css({ "padding-top": "0", "padding-bottom": "0" }).removeClass('has-wp30skybar');
			var form_data = $('form#post').serialize();
			var data = {
                action: 'preview_bar',
                form_data: form_data,
            };

            $.post( ajaxurl, data, function(response) {

                if ( response ) {
                    $('body').prepend( response );
                }
            }).done(function(result){
            	$( document ).trigger('wp30skybarPreviewLoaded');
            });

		});

		// Preview Bar
		$( document ).on( 'wp30skybarPreviewLoaded', function( event ) {

			var barHeight;

			if ( $('.wp30skybar').length > 0 ) {
				barHeight = $('.wp30skybar').outerHeight();
				$('body').css('padding-top', barHeight).addClass('has-wp30skybar');
			}

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

		// Color option
		$('.wp30skybar-color-picker').wpColorPicker();

		// Bar select
		function wp30skybarProcessPostSelectDataForSelect2( ajaxData, page, query ) {

			var items=[];

			for (var thisId in ajaxData) {
				var newItem = {
					'id': ajaxData[thisId]['id'],
					'text': ajaxData[thisId]['title']
				};
				items.push(newItem);
			}
			return { results: items };
		}

		$('input.wp30skybar-bar-select').each(function() {

			var $this = $(this);

			$this.select2( {
				placeholder: wp30skybar_locale.select_placeholder,
				multiple: true,
				maximumSelectionSize: 1,
				minimumInputLength: 2,
				ajax: {
					url: ajaxurl,
					dataType: 'json',
					data: function (term, page) {
						return {
							q: term,
							action: 'wp30skybar_get_bars',
						};
					},
					results: wp30skybarProcessPostSelectDataForSelect2
				},
				initSelection: function(element, callback) {

					var ids=$(element).val();
					if ( ids !== "" ) {
						$.ajax({
							url: ajaxurl,
							dataType: "json",
							data: {
								action: 'wp30skybar_get_bar_titles',
								post_ids: ids
							},
							
						}).done(function(response) {console.log(response);
							
							var processedData = wp30skybarProcessPostSelectDataForSelect2( response );
							callback( processedData.results );
						});
					}
				},
			});
		});
	});

})( jQuery );
