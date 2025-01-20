<div id="popup-quickorder">
<style>*::before, *::after {  box-sizing: border-box;}*:before, *:after {  box-sizing: border-box;}* {  box-sizing: border-box;}</style>
	<div class="popup-heading"><?php echo isset($config_title_popup_quickorder[$lang_id]) ? $config_title_popup_quickorder[$lang_id]['config_title_popup_quickorder'] : ''; ?></div>
	<div class="popup-center">
		<form id="fastorder_data" enctype="multipart/form-data" method="post">
			<div style="margin-top:10px;">
				<div id="quick_checkout_cart">
				<?php if ($products) { ?>
					<div class="col-smq-12 text-center">
						<div class="well well-sm products">
							<?php foreach($products as $product) { ?>
								<div class="product">
									<div class="row">
										<div class="col-xsq-12 col-smq-5">
											<div class="image">
												<?php if ($product['thumb']) { ?>
												<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
												<?php } ?>
											</div>
											<div class="pr-name quick-cell">
												<div class="quick-cell-content">
													<a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
													<?php if ($product['option']) { ?>
													<br />
														<?php foreach ($product['option'] as $option) { ?>
															- <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small><br />
														<?php } ?>
													<?php } ?>
												<?php if ($product['recurring']) { ?>
													<small><?php echo $text_recurring; ?> <?php echo $product['recurring']; ?></small>
												<?php } ?>
												</div>
											</div>
										</div>
										<div class="col-xsq-12 col-smq-7">
											<div class="col-xsq-5 quantity_quickorder quick-cell">
												<div class="quick-cell-content pquantity">
													<div class="input-group-quickorder popup-quantity">
														<span class="input-group-btn-quickorder">
															<button class="btn btn-update-popup" type="button" onclick="updateQuantity('<?php echo $product['cart_id']; ?>','<?php echo $product['quantity']-1; ?>');" >-</button>
														</span>
														<input type="text" class="form-control input-sm" value="<?php echo $product['quantity']; ?>" onchange="updateQuantity('<?php echo $product['cart_id']; ?>', $(this).val());">
														<span class="input-group-btn-quickorder">
															<button class="btn btn-update-popup" type="button" onclick="updateQuantity('<?php echo $product['cart_id']; ?>','<?php echo $product['quantity']+1; ?>');">+</button>
														</span>
													</div>
												</div>
											</div>
											<div class="col-xsq-5 quick-cell pprice">
												<div class="quick-cell-content">
													<?php echo $product['total']; ?>
												</div>
											</div>
											<div class="col-xsq-2 quick-cell text-center delete-pr">
												<div class="quick-cell-content">
													<a href="javascript:void(0);" onclick="deleteProduct('<?php echo $product['cart_id']; ?>');return false;" title="<?php echo $button_remove; ?>" class=""><i class="fa fa-trash-o fa-lg"></i></a>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>						
					</div>
					<div class="col-xsq-12 col-smq-12 col-mdq-12 form-group">	
						<div class="totals text-center">
							<a class="popupTotal collapsed" data-toggle="collapse" href="#total-quick-ckeckout" title="Подробнее"><?php echo $text_total_qucik_ckeckout; ?>&nbsp;&nbsp;<i class="fa fa-angle-down"></i></a>
							<div id="total-quick-ckeckout" class="collapse">
								<table class="table table-condensed">
									<?php foreach ($totals as $total) { ?>
									<tr>
										<td class="text-right" style="width: 50%"><strong><?php echo $total['title']; ?></strong></td>
										<td class="text-left" style="width: 50%"><?php echo $total['text']; ?></td>
									</tr>
									<?php } ?>
									<input type="hidden" value="<?php echo $total_order; ?>" name="total_order" />
									<input type="hidden" id="quickorder_url" value="" name="url_site"  />
								</table>
							</div>
						</div>
					</div>
				<?php } else { ?>
				<div class="text-center" style="padding: 30px 0"><?php echo $text_empty; ?></div>
				<?php } ?>
				</div>
			</div>
		<?php if ($products) { ?>
			<?php if($on_off_fields_firstname == '1') { ?>
				<div class="col-smq-6 col-smq-12 form-group <?php echo $config_fields_firstname_requared == '1' ? 'sections_block_rquaired' : 'sections_block' ; ?>">
					<div class="input-group-quickorder margin-bottom-sm">			
						 <input id="contact-name" class="form-control contact-name input-quickorder" type="text" placeholder="<?php echo $config_placeholder_fields_firstname[$lang_id]['config_placeholder_fields_firstname']; ?>" value="" name="name_fastorder">		
						<span class="input-icon"><i class="fa fa-user fa-fw"></i></span>
					</div>					
				</div>
			<?php } ?>
			
			<?php if($on_off_fields_phone == '1') { ?>
				<div class="col-smq-6 col-smq-12 form-group <?php echo $config_fields_phone_requared == '1' ? 'sections_block_rquaired' : 'sections_block' ; ?>">
					<div class="input-group-quickorder margin-bottom-sm">			
						 <input id="contact-phone" class="form-control contact-phone input-quickorder" type="text" placeholder="<?php echo $config_placeholder_fields_phone[$lang_id]['config_placeholder_fields_phone']; ?>" value="" name="phone">		
						<span class="input-icon"><i class="fa fa-phone-square fa-fw"></i></span>
					</div>					
				</div>
			<?php } ?>
			<?php if($on_off_fields_email) { ?>
				<div class="col-smq-6 col-smq-12 form-group <?php echo $config_fields_email_requared == '1' ? 'sections_block_rquaired' : 'sections_block' ; ?>">
				<div class="input-group-quickorder margin-bottom-sm">                         
					<input class="form-control contact-email input-quickorder" id="contact-email" type="text" placeholder="<?php echo $config_placeholder_fields_email[$lang_id]['config_placeholder_fields_email'];?>" value=""  name="email_buyer">
					<span class="input-icon"><i class="fa fa-envelope fa-fw"></i></span>
				</div>				
			  </div>
			<?php } ?>
	  
			<?php if($on_off_fields_comment) { ?>
				<div class="col-smq-6 col-om-12 form-group <?php echo $config_fields_comment_requared == '1' ? 'sections_block_rquaired' : 'sections_block' ; ?>">
				<div class="input-group-quickorder margin-bottom-sm">                          
					<input class="form-control contact-comment-buyer input-quickorder" name="comment_buyer" id="contact-comment" placeholder="<?php echo $config_placeholder_fields_comment[$lang_id]['config_placeholder_fields_comment'];?>"/>
					<span class="input-icon"><i class="fa fa-comment fa-fw"></i></span>	
				</div>				
				</div>
			<?php } ?>
		<?php } ?>
		</form>
		<div class="col-smq-12 form-group text-center"><?php echo isset($config_text_before_button_send[$lang_id]) ? $config_text_before_button_send[$lang_id]['config_text_before_button_send'] : ''; ?></div>
	</div>
	<div class="popup-footer">
		<style>
			#quickorder_btn .btn-quickorder{
				  background-color: #<?php echo $background_button_send_fastorder;?> !important;
				  border-color: #<?php echo $background_button_send_fastorder;?> !important;
			}
			#quickorder_btn .btn-quickorder:hover, #quickorder_btn .btn-quickorder:focus{
				background-color:#<?php echo $background_button_send_fastorder_hover;?> !important;
			}
		</style>
		<?php if ($products) { ?>
		<div id="quickorder_btn">
			<button type="button" onclick="quickorder_confirm_checkout();" class="btn btn-quickorder"><i class="<?php echo $icon_send_fastorder;?> fa-fw"></i><?php echo $button_send; ?></button>
		</div>
		<?php } else { ?>
			<div id="quickorder_btn">
				<button type="button" onclick="$.magnificPopup.close();" class="btn btn-quickorder"><?php echo $text_continue; ?></button>
			</div>
		<?php } ?>
		<?php if($config_any_text_at_the_bottom[$lang_id]['config_any_text_at_the_bottom'] !='') { ?>
			<div class="col-smq-12 form-group text-center" style="margin-top:10px;"><span style="color:#<?php echo $any_text_at_the_bottom_color;?>"><?php echo isset($config_any_text_at_the_bottom[$lang_id]) ? $config_any_text_at_the_bottom[$lang_id]['config_any_text_at_the_bottom'] : ''; ?></span></div>
		<?php } ?>
		</div>
<script src="catalog/view/javascript/jquery/maskedinput.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		<?php if ($mask_phone_number != '') { ?>
			$("#contact-phone").mask("<?php echo $mask_phone_number;?>");
		<?php } ?>
	});
</script>
<script type="text/javascript">
function updateQuantity(key,quantity){
$.ajax({
	url: 'index.php?route=module/newfastordercart/editCartQuick',
	type: 'post',
	data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
	dataType: 'json',
	beforeSend: function() {
		$('#quick_checkout_cart').addClass('maskPopupQuickorder');
		$('#fastorder_data').after('<span class="loading_quick_order"><i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i></span>');
			$('#cart > button').button('loading');
		},
		success: function(json) {
			$('#cart > button').button('reset');
			setTimeout(function () {
				$('#cart').load('index.php?route=common/cart/info');
			}, 100);

			if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
				location = 'index.php?route=checkout/cart';
			} else {
				$.ajax({
					url: 'index.php?route=module/newfastordercart',
					type: 'get',
					dataType: 'html',
					success: function(data){
						$('#popup-quickorder #fastorder_data').html($(data).find('#fastorder_data').html());
						$('#popup-quickorder .popup-footer').html($(data).find('.popup-footer').html());
						$('.loading_quick_order').remove();
						$('#quick_checkout_cart').removeClass('maskPopupQuickorder');
					}
				});
			}
		},
	    error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	    }
});	
};
function deleteProduct(key){
$.ajax({
	url: 'index.php?route=checkout/cart/remove',
	type: 'post',
	data: 'key=' + key,
	dataType: 'json',
	beforeSend: function() {
		$('#quick_checkout_cart').addClass('maskPopupQuickorder');
		$('#fastorder_data').after('<span class="loading_quick_order"><i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i></span>');
		$('#cart > button').button('loading');
	},
	complete: function() {
		$('#cart > button').button('reset');
	},
	success: function(json) {
		setTimeout(function () {
			$('#cart').load('index.php?route=common/cart/info');
		}, 100);

		if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
			location = 'index.php?route=checkout/cart';
		} else {
			$.ajax({
				url: 'index.php?route=module/newfastordercart',
				type: 'get',
				dataType: 'html',
				success: function(data){
					$('#popup-quickorder #fastorder_data').html($(data).find('#fastorder_data').html());
					$('#popup-quickorder .popup-footer').html($(data).find('.popup-footer').html());
					$('.loading_quick_order').remove();
					$('#quick_checkout_cart').removeClass('maskPopupQuickorder');
				}
			});
		}
	},
	error: function(xhr, ajaxOptions, thrownError) {
	    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	}
});
};	
</script>
</div>
</div>