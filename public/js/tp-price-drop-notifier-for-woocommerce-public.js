(function( $ ) {
	'use strict';

	$( document ).ready(function() {
		// console.log( "ready!" );

		//tppdn.activate_price_drop

		$(".tppdn-form-send").click(function() {
			var pid = $(this).data('pid');
			var product_id    = $('#tppdn-id-'+pid).val();
			var variation_id  = 0;

			var client_name      = $('#tppdn-client-name-'+pid).val();
			var client_email     = $('#tppdn-client-email-'+pid).val();
			var price_lower_than = $('#tppdn-price-lower-than-'+pid).val();
			var typee            = $('#tppdn-type-'+pid).val();
			var referer          = $('#tppdn-referer-'+pid).val();
			var nonce            = $('#tppdn-nonce-'+pid).val();

			if(tppdn.add_newsletter){
				if ($('#tppdn-newsletter-'+pid).is(':checked')) {
					var newsletter = 1;
				}
				else{
					var newsletter = 0;
				}
			}
			else{
				var newsletter = $('#tppdn-newsletter-'+pid).val();
			}

			// alert(newsletter);
			// return false;

			if($("input[name=variation_id]").length){
				variation_id = $("input[name=variation_id]").val();
			}

			// console.log(cname);
			// console.log(cemail);
			// console.log(product_id);
			// console.log(product_name);
			// console.log(price);

			if(product_id && client_name && client_email){
				jQuery.ajax({
					type: "post",
					//dataType: "json",
					contentType: "application/x-www-form-urlencoded;charset=utf-8",
					url: tppdn.ajaxurl,
					data: {
						action: "save_price_drop_notifier",
						product_id: product_id,
						variation_id: variation_id,
						newsletter: newsletter,
						typee: typee,
						referer: referer,
						client_name: client_name,
						client_email: client_email,
						price_lower_than: price_lower_than,
						nonce: nonce
					},
					beforeSend: function() {
						jQuery(".tppdnlds-loading-mask").show();
					},
					success: function(response) {

						jQuery(".tppdnlds-loading-mask").hide();
						jQuery("#tppdn-required-validation-"+pid).html(response);

					}
				});  
			}
			else{
				var validation_message = '<span class="tppdn-required-validation">'+tppdn.validation_message+'</span>';
				jQuery("#tppdn-required-validation-"+pid).html(validation_message);
			}

		});

	});

})( jQuery );
