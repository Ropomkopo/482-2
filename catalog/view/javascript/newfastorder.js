function quickorder_confirm() {
	var success = 'false';
		$('#callback_url').val(window.location.href);
		$.ajax({
			url: 'index.php?route=module/newfastorder',
			type: 'post',
			data: $('#fastorder_data').serialize() + '&action=send',
			dataType: 'json',
			beforeSend: function() {
				$('#fastorder_data').addClass('maskPopupQuickorder');
				$('#fastorder_data').after('<span class="loading_quick_order"><i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i></span>');	
			},
			success: function(json) {
				$('.loading_quick_order').remove();
				$('#fastorder_data').removeClass('maskPopupQuickorder');		
				$('#contact-name').removeClass('error_input');				
				$('#contact-phone').removeClass('error_input');			
				$('#contact-comment').removeClass('error_input');				
				$('#contact-email').removeClass('error_input');
				$('.text-danger').empty();
				if (json['error']) {
					if (json['error']['name_fastorder']) {						
						$('#contact-name').attr('placeholder',json['error']['name_fastorder']);
						$('#contact-name').addClass('error_input');							
					}										
					if (json['error']['phone']) {						
						$('#contact-phone').attr('placeholder',json['error']['phone']);
						$('#contact-phone').addClass('error_input');									
					}											
					if (json['error']['comment_buyer']) {
						$('#contact-comment').attr('placeholder',json['error']['comment_buyer']);
						$('#contact-comment').addClass('error_input');				
					}						
					if (json['error']['email_error']) {						
						$('#contact-email').attr('placeholder',json['error']['email_error']);
						$('#contact-email').addClass('error_input');						
					}
					if (json['error']['option']) {		
							for (i in json['error']['option']) {
								$('.option-error-'+ i).html(json['error']['option'][i]);
							}				
					}	
					
				}
				
				if (json['success']){ 	
				$.magnificPopup.close();
				html  = '<div id="modal-addquickorder" class="modal fade">';
				html += '  <div class="modal-dialog">';
				html += '    <div class="modal-content">';
				html += '      <div class="modal-body alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div>';
				html += '    </div>';
				html += '  </div>';
				html += '</div>';

				$('body').append(html);

				$('#modal-addquickorder').modal('show');
				}	
			}

		});
}

function quickorder_confirm_checkout() {
	$('#quickorder_url').val(window.location.href);
	var success = 'false';
	$.ajax({
		url: 'index.php?route=module/newfastordercart',
		type: 'post',
		data: $('#fastorder_data').serialize() + '&action=send',
		dataType: 'json',	
		beforeSend: function() {
			$('#fastorder_data').addClass('maskPopupQuickorder');
			$('#fastorder_data').after('<span class="loading_quick_order"><i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i></span>');	
		},		
		success: function(json) {	
			$('.loading_quick_order').remove();
			$('#fastorder_data').removeClass('maskPopupQuickorder');	
			$('#contact-name').removeClass('error_input');				
			$('#contact-phone').removeClass('error_input');				
			$('#contact-comment').removeClass('error_input');				
			$('#contact-email').removeClass('error_input');
			if (json['error']) {
				if (json['error']['name_fastorder']) {						
					$('#contact-name').attr('placeholder',json['error']['name_fastorder']);
					$('#contact-name').addClass('error_input');							
				}										
				if (json['error']['phone']) {						
					$('#contact-phone').attr('placeholder',json['error']['phone']);
					$('#contact-phone').addClass('error_input');									
				}											
				if (json['error']['comment_buyer']) {
					$('#contact-comment').attr('placeholder',json['error']['comment_buyer']);
					$('#contact-comment').addClass('error_input');				
				}						
				if (json['error']['email_error']) {						
					$('#contact-email').attr('placeholder',json['error']['email_error']);
					$('#contact-email').addClass('error_input');						
				}	
				if (json['error']['comment_buyer']) {
					$('#error_comment_buyer').html(json['error']['comment_buyer']);
				}												
			}
				
			if (json['success']){ 	
				$('#cart').load('index.php?route=common/cart/info');
				$.magnificPopup.close();
				html  = '<div id="modal-addquickorder" class="modal fade">';
				html += '  <div class="modal-dialog">';
				html += '    <div class="modal-content">';
				html += '      <div class="modal-body alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div>';
				html += '    </div>';
				html += '  </div>';
				html += '</div>';

				$('body').append(html);

				$('#modal-addquickorder').modal('show');
			}	
		}

		});
}