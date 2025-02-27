<div id="popup-quickorder">
<style>*::before, *::after {  box-sizing: border-box;}*:before, *:after {  box-sizing: border-box;}* {  box-sizing: border-box;}</style>
	<div class="popup-heading"><?php echo isset($config_title_popup_quickorder[$lang_id]) ? $config_title_popup_quickorder[$lang_id]['config_title_popup_quickorder'] : ''; ?></div>
	<div class="popup-center">
		<form id="fastorder_data" enctype="multipart/form-data" method="post">
			<?php if($config_general_image_product_popup !='1') { ?>
			<div class="col-smq-12 text-center">
				<?php if ($thumb) { ?><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" /><?php } ?>
			</div>
			<div class="col-smq-12 form-group text-center">
				<h4><?php echo $heading_title; ?></h4>
			</div>
			<div class="col-smq-12 form-group">
				<div class="price-quantity-quickorder text-center">
					<?php if (!$special) { ?>
						<div class="price_fast"><span id="formated_price_quickorder" data-price="<?php echo $price_value; ?>"><?php echo $price; ?></span></div>
						<input type="hidden" id="price_tax_plus_options" name="price_tax" value="<?php echo $price; ?>"/>
						<input type="hidden" id="price_no_tax_plus_options" name="price_no_tax" value="<?php echo $price_value; ?>"/>
					<?php } else { ?>
						<div class="special_fast">
							<div class="price-old"><span id="formated_price_quickorder" class="price-old" data-price="<?php echo $price_value; ?>"><?php echo $price;?></span></div>
							<div class="price-new"><span id="formated_special_quickorder" data-price="<?php echo $special_value; ?>"><?php echo $special;?></span></div>
							<input type="hidden" id="price_tax_plus_options" name="price_tax" value="<?php echo $special; ?>"/>
							<input type="hidden" id="price_no_tax_plus_options" name="price_no_tax" value="<?php echo $special_value; ?>"/>
						</div>
					<?php } ?>
						<div class="quantity_quickorder">							
							<input type="button" id="decrease_quickorder" value="-" onclick="btnminus_quickorder('1');recalculateprice_quickorder();" />
							<input type="text" class="qty_quickorder" name="quantity" id="htop_quickorder" size="2" value="1" />
							<input type="button" id="increase_quickorder" value="+" onclick="btnplus_quickorder();recalculateprice_quickorder();" />
						<?php if (!$special) { ?>
							<script type="text/javascript"><!--
								function btnminus_quickorder(a){
									document.getElementById("htop_quickorder").value>a?document.getElementById("htop_quickorder").value--:document.getElementById("htop_quickorder").value=a;						
								}
								function btnplus_quickorder(){
									document.getElementById("htop_quickorder").value++;	
								};
							//--></script>
						<?php } else {?>
							<script type="text/javascript"><!--
								function btnminus_quickorder(a){									
									document.getElementById("htop_quickorder").value>a?document.getElementById("htop_quickorder").value--:document.getElementById("htop_quickorder").value=a;															
								}									
								function btnplus_quickorder(){
									document.getElementById("htop_quickorder").value++;									
								};
								//--></script>
						<?php } ?>
						</div>
						<?php if (!$special) { ?>
							<input id="total_form" type="hidden" value="<?php echo $price;?>" name="total_fast"/>			
						<?php } else { ?>						
							<input id="total_form" type="hidden" value="<?php echo $special;?>" name="total_fast"/>
						<?php } ?>
					</div>
			</div>
	<?php } else { ?>
		<div class="col-smq-12">	
			<div class="well well-sm products" style="margin-top:10px;">
				<div class="product">
					<div class="row">
						<div class="col-xsq-12 col-smq-5">
							<div class="image">
								<?php if ($thumb_small) { ?><img src="<?php echo $thumb_small; ?>" alt="<?php echo $heading_title; ?>" /><?php } ?>
							</div>
							<div class="pr-name quick-cell">
								<div class="quick-cell-content">
									<?php echo $heading_title; ?>
								</div>
							</div>
						</div>
						<div class="col-xsq-12 col-smq-7">
								<div class="col-xsq-6 quantity_quickorder quick-cell">
									<div class="quick-cell-content pquantity">
										<div class="input-group-quickorder popup-quantity">
											<span class="input-group-btn-quickorder">
												<input class="btn btn-update-popup" type="button" id="decrease_quickorder" value="-" onclick="btnminus_quickorder('1');recalculateprice_quickorder();" />									
											</span>
											<input type="text" class="form-control input-sm qty_quickorder" name="quantity" id="htop_quickorder" size="2" value="1" />
											<span class="input-group-btn-quickorder">
												<input class="btn btn-update-popup" type="button" id="increase_quickorder" value="+" onclick="btnplus_quickorder();recalculateprice_quickorder();" />
											</span>
										</div>
									</div>
								</div>
								<?php if (!$special) { ?>
									<script type="text/javascript">
										function btnminus_quickorder(a){
											document.getElementById("htop_quickorder").value>a?document.getElementById("htop_quickorder").value--:document.getElementById("htop_quickorder").value=a;						
										}
										function btnplus_quickorder(){
											document.getElementById("htop_quickorder").value++;	
										};
									</script>
								<?php } else { ?>
									<script type="text/javascript">
										function btnminus_quickorder(a){									
											document.getElementById("htop_quickorder").value>a?document.getElementById("htop_quickorder").value--:document.getElementById("htop_quickorder").value=a;															
										}									
										function btnplus_quickorder(){
											document.getElementById("htop_quickorder").value++;									
										};
									</script>
								<?php } ?>
								<div class="col-xsq-6 text-center quick-cell">
									<div class="quick-cell-content">
										<?php if (!$special) { ?>
											<div class="price_fast"><span id="formated_price_quickorder" data-price="<?php echo $price_value; ?>"><?php echo $price; ?></span></div>
											<input type="hidden" id="price_tax_plus_options" name="price_tax" value="<?php echo $price; ?>"/>
											<input type="hidden" id="price_no_tax_plus_options" name="price_no_tax" value="<?php echo $price_value; ?>"/>	
											<input id="total_form" type="hidden" value="<?php echo $price;?>" name="total_fast"/>											
										<?php } else { ?>
											<div class="special_fast">
												<div class="price-old"><span id="formated_price_quickorder" class="price-old" data-price="<?php echo $price_value; ?>"><?php echo $price;?></span></div>
												<div class="price-new"><span id="formated_special_quickorder" data-price="<?php echo $special_value; ?>"><?php echo $special;?></span></div>
												<input type="hidden" id="price_tax_plus_options" name="price_tax" value="<?php echo $special; ?>"/>
												<input type="hidden" id="price_no_tax_plus_options" name="price_no_tax" value="<?php echo $special_value; ?>"/>
												<input id="total_form" type="hidden" value="<?php echo $special;?>" name="total_fast"/>
											</div>
										<?php } ?>								
									</div>
								</div>
						</div>						
					</div>
				</div>	
			</div>
		</div>
	<?php } ?>
<?php if ($options) { ?>
<div class="col-smq-12">
<div class="option-fastorder">				
    <div class="options">      
        <?php foreach ($options as $option) { ?>
			<?php if ($option['type'] == 'select') { ?>
            <div id="option-fast-<?php echo $option['product_option_id']; ?>" class="col-smq-6 option form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
			<div class="text-danger option-error-<?php echo $option['product_option_id']; ?>"></div>
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <select name="option-fast[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control option">
                <option value=""><?php echo $text_select; ?></option>
				<?php $opt_checked="checked"; ?>
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <option value="<?php echo $option_value['product_option_value_id']; ?>"  points="<?php echo (isset($option_value['points_value']) ? $option_value['points_value'] : 0); ?>" price_prefix="<?php echo $option_value['price_prefix']; ?>" price="<?php echo $option_value['price_value']; ?>"><?php echo $option_value['name']; ?>
                <?php if ($option_value['price']) { ?>
                (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                <?php } ?>
                </option>
                <?php } ?>
              </select>
            </div>
            <?php } ?>
			
			<?php if ($option['type'] == 'radio') { ?>
            <div id="option-fast-<?php echo $option['product_option_id']; ?>" class="col-smq-6 col-xsq-12 option form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <div class="text-danger option-error-<?php echo $option['product_option_id']; ?>"></div>
               <label class="control-label"><?php echo $option['name']; ?></label>
			  <div id="input-option<?php echo $option['product_option_id']; ?>">
			   <?php $opt_checked="checked"; ?>
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <div class="radio-checbox-options">
                  <input <?php echo (isset($opt_checked) ? $opt_checked : ''); $opt_checked=""; ?> type="radio" name="option-fast[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" points="<?php echo (isset($option_value['points_value']) ? $option_value['points_value'] : 0); ?>" price_prefix="<?php echo $option_value['price_prefix']; ?>" price="<?php echo $option_value['price_value']; ?>" id="option-value-<?php echo $option['product_option_id']; ?>-<?php echo $option_value['product_option_value_id']; ?>" />
					<label for="option-value-<?php echo $option['product_option_id']; ?>-<?php echo $option_value['product_option_value_id']; ?>">
                    <span class="option-name"><?php echo $option_value['name']; ?></span>
                    <?php if ($option_value['price']) { ?>
                    <span class="option-price"><?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?></span>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
			<?php if ($option['type'] == 'checkbox') { ?>
            <div id="option-fast-<?php echo $option['product_option_id']; ?>" class="col-smq-6 col-xsq-12 option form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
			 <div class="text-danger option-error-<?php echo $option['product_option_id']; ?>"></div>
              <label class="control-label"><?php echo $option['name']; ?></label>
              <div id="input-option<?php echo $option['product_option_id']; ?>">
			  <?php $opt_checked="checked"; ?>
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <div class="radio-checbox-options">
                  <input type="checkbox" name="option-fast[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" points="<?php echo (isset($option_value['points_value']) ? $option_value['points_value'] : 0); ?>" price_prefix="<?php echo $option_value['price_prefix']; ?>" price="<?php echo $option_value['price_value']; ?>" id="option-value-<?php echo $option['product_option_id']; ?>-<?php echo $option_value['product_option_value_id']; ?>" />
					<label for="option-value-<?php echo $option['product_option_id']; ?>-<?php echo $option_value['product_option_value_id']; ?>">
                    <span class="option-name"><?php echo $option_value['name']; ?></span>
                    <?php if ($option_value['price']) { ?>
                    <span class="option-price"><?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?></span>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
			<?php if ($option['type'] == 'image') { ?>
            <div id="option-fast-<?php echo $option['product_option_id']; ?>" class="col-smq-6 col-xsq-12 option form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <div class="text-danger option-error-<?php echo $option['product_option_id']; ?>"></div>
			  <label class="control-label"><?php echo $option['name']; ?></label>
              <div id="input-option<?php echo $option['product_option_id']; ?>">
			  <?php $opt_checked="checked"; ?>
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <div class="image-radio">
					<label>
						 <input <?php echo (isset($opt_checked) ? $opt_checked : ''); $opt_checked=""; ?> type="radio" name="option-fast[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" points="<?php echo (isset($option_value['points_value']) ? $option_value['points_value'] : 0); ?>" price_prefix="<?php echo $option_value['price_prefix']; ?>" price="<?php echo $option_value['price_value']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>"/>
						<img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" data-toggle="tooltip" title="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /> 
					</label>
				</div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
			<?php if ($option['type'] == 'text') { ?>
            <div id="option-fast-<?php echo $option['product_option_id']; ?>" class="col-smq-6 col-xsq-12 option form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <input type="text" name="option-fast[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
            </div>
            <?php } ?>
			 <?php if ($option['type'] == 'file') { ?>
            <div id="option-fast-<?php echo $option['product_option_id']; ?>" class="col-smq-6 col-xsq-12 option form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label"><?php echo $option['name']; ?></label>
              <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
              <input type="hidden" name="option-fast[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
            </div>
            <?php } ?>
			<?php if ($option['type'] == 'date') { ?>
            <div id="option-fast-<?php echo $option['product_option_id']; ?>" class="col-smq-6 col-xsq-12 option form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <div class="text-danger option-error-<?php echo $option['product_option_id']; ?>"></div>
			  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <div class="input-group date">
                <input type="text" name="option-fast[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
			
            <?php if ($option['type'] == 'datetime') { ?>
            <div id="option-fast-<?php echo $option['product_option_id']; ?>" class="col-smq-6 col-xsq-12 option form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <div class="text-danger option-error-<?php echo $option['product_option_id']; ?>"></div>
			  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <div class="input-group datetime">
                <input type="text" name="option-fast[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
			
            <?php if ($option['type'] == 'time') { ?>
            <div id="option-fast-<?php echo $option['product_option_id']; ?>" class="col-smq-6 col-xsq-12 option form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <div class="text-danger option-error-<?php echo $option['product_option_id']; ?>"></div>
			  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <div class="input-group time">
                <input type="text" name="option-fast[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
        <?php } ?>
      </div>    
	</div>
</div>
<?php } ?>
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
            <input id="contact-email" class="form-control contact-email input-quickorder" id="contact-email" type="text" placeholder="<?php echo $config_placeholder_fields_email[$lang_id]['config_placeholder_fields_email'];?>" value=""  name="email_buyer">
			<span class="input-icon"><i class="fa fa-envelope fa-fw"></i></span>
		</div>
      </div>
	  <?php } ?>
	  
	  <?php if($on_off_fields_comment) { ?>
		<div class="col-smq-6 col-om-12 form-group <?php echo $config_fields_comment_requared == '1' ? 'sections_block_rquaired' : 'sections_block' ; ?>">
		<div class="input-group-quickorder margin-bottom-sm">                          
            <input id="contact-comment" class="form-control contact-comment-buyer input-quickorder" name="comment_buyer" id="contact_comment_buyer"  placeholder="<?php echo $config_placeholder_fields_comment[$lang_id]['config_placeholder_fields_comment'];?>"/>
			<span class="input-icon"><i class="fa fa-comment fa-fw"></i></span>	
		</div>
		</div>
		<?php } ?>
		<div class="col-smq-12 form-group text-center"><?php echo isset($config_text_before_button_send[$lang_id]) ? $config_text_before_button_send[$lang_id]['config_text_before_button_send'] : ''; ?></div>
		<input type="hidden" id="callback_url" value="" name="url_site"  />
		<input type="hidden" id="this_prod_id" value="<?php echo $product_id;?>" name="this_prod_id"  />					
		
		
		
		</form>
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
        <div id="quickorder_btn">
			<button type="button" onclick="quickorder_confirm();" class="btn btn-quickorder"><i class="<?php echo $icon_send_fastorder;?> fa-fw"></i><?php echo $button_send; ?></button>
		</div>
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
<script type="text/javascript"><!--

function price_format(n)
{ 
    c = <?php echo (empty($currency['decimals']) ? "0" : $currency['decimals'] ); ?>;
    d = '<?php echo $currency['decimal_point']; ?>'; // decimal separator
    t = '<?php echo $currency['thousand_point']; ?>'; // thousands separator
    s_left = '<?php echo $currency['symbol_left']; ?>';
    s_right = '<?php echo $currency['symbol_right']; ?>';
      
    n = n * <?php echo $currency['value']; ?>;

    //sign = (n < 0) ? '-' : '';

    //extracting the absolute value of the integer part of the number and converting to string
    i = parseInt(n = Math.abs(n).toFixed(c)) + ''; 

    j = ((j = i.length) > 3) ? j % 3 : 0; 
    return s_left + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '') + s_right; 
}

function calculate_tax(price)
{
    <?php // Process Tax Rates
      if (isset($tax_rates) && $tax) {
         foreach ($tax_rates as $tax_rate) {
           if ($tax_rate['type'] == 'F') {
             echo 'price += '.$tax_rate['rate'].';';
           } elseif ($tax_rate['type'] == 'P') {
             echo 'price += (price * '.$tax_rate['rate'].') / 100.0;';
           }
         }
      }
    ?>
    return price;
}

function process_discounts(price, quantity)
{
    <?php
      foreach ($dicounts_unf as $discount) {
        echo 'if ((quantity >= '.$discount['quantity'].') && ('.$discount['price'].' < price)) price = '.$discount['price'].';'."\n";
      }
    ?>
    return price;
}


animate_delay = 20;

main_price_final = calculate_tax(Number($('#formated_price_quickorder').attr('data-price')));
main_price_start = calculate_tax(Number($('#formated_price_quickorder').attr('data-price')));
main_step = 0;
main_timeout_id = 0;

function animateMainPrice_callback_quickorder() {
    main_price_start += main_step;
    
    if ((main_step > 0) && (main_price_start > main_price_final)){
        main_price_start = main_price_final;
    } else if ((main_step < 0) && (main_price_start < main_price_final)) {
        main_price_start = main_price_final;
    } else if (main_step == 0) {
        main_price_start = main_price_final;
    }
    
    $('#formated_price_quickorder').html( price_format(main_price_start) );
    $('#total').html( price_format(main_price_start) );
    $('#total_form').val(main_price_start);

    if (main_price_start != main_price_final) {
        main_timeout_id = setTimeout(animateMainPrice_callback_quickorder, animate_delay);
    }
}

function animateMainPrice_quickorder(price) {
    main_price_start = main_price_final;
    main_price_final = price;
    main_step = (main_price_final - main_price_start) / 10;
    
    clearTimeout(main_timeout_id);
    main_timeout_id = setTimeout(animateMainPrice_callback_quickorder, animate_delay);
}


<?php if ($special) { ?>
special_price_final = calculate_tax(Number($('#formated_special_quickorder').attr('data-price')));
special_price_start = calculate_tax(Number($('#formated_special_quickorder').attr('data-price')));
special_step = 0;
special_timeout_id = 0;

function animateSpecialPrice_callback_quickorder() {
    special_price_start += special_step;
    
    if ((special_step > 0) && (special_price_start > special_price_final)){
        special_price_start = special_price_final;
    } else if ((special_step < 0) && (special_price_start < special_price_final)) {
        special_price_start = special_price_final;
    } else if (special_step == 0) {
        special_price_start = special_price_final;
    }
    
    $('#formated_special_quickorder').html( price_format(special_price_start) );
    $('#total').html( price_format(special_price_start) );
    $('#total_form').val(special_price_start);
   
    
    if (special_price_start != special_price_final) {
        special_timeout_id = setTimeout(animateSpecialPrice_callback_quickorder, animate_delay);
    }
}

function animateSpecialPrice_quickorder(price) {
    special_price_start = special_price_final;
    special_price_final = price;
    special_step = (special_price_final - special_price_start) / 10;
    
    clearTimeout(special_timeout_id);
    special_timeout_id = setTimeout(animateSpecialPrice_callback_quickorder, animate_delay);
}
<?php } ?>


function recalculateprice_quickorder()
{
    var main_price = Number($('#formated_price_quickorder').attr('data-price'));
	var input_quantity = $('input.qty_quickorder[name="quantity"]').val();
    var special = Number($('#formated_special_quickorder').attr('data-price'));
	
	
    var tax = 0;
    
    if (isNaN(input_quantity)) input_quantity = 0;
    
    // Process Discounts.
    <?php if ($special) { ?>
        special = process_discounts(special, input_quantity);
    <?php } else { ?>
        main_price = process_discounts(main_price, input_quantity);
    <?php } ?>
    tax = process_discounts(tax, input_quantity);
    
    
   <?php if ($points) { ?>
     var points = Number($('#formated_points').attr('points'));
     $('.option input:checked').each(function() {
       points += Number($(this).attr('points'));
     });
     $('.option option:selected').each(function() {
       points += Number($(this).attr('points'));
     });
     $('#formated_points').html(points);
   <?php } ?>
    
    var option_price = 0;
    
    $('.option input:checked,option:selected').each(function() {
      if ($(this).attr('price_prefix') == '=') {
        option_price += Number($(this).attr('price'));
        main_price = 0;
        special = 0;
      }
    });
    
    $('.option input:checked,option:selected').each(function() {
      if ($(this).attr('price_prefix') == '+') {
        option_price += Number($(this).attr('price'));
      }
      if ($(this).attr('price_prefix') == '-') {
        option_price -= Number($(this).attr('price'));
      }
      if ($(this).attr('price_prefix') == 'u') {
        pcnt = 1.0 + (Number($(this).attr('price')) / 100.0);
        option_price *= pcnt;
        main_price *= pcnt;
        special *= pcnt;
      }
      if ($(this).attr('price_prefix') == '*') {
        option_price *= Number($(this).attr('price'));
        main_price *= Number($(this).attr('price'));
        special *= Number($(this).attr('price'));
      }
    });
    
    special += option_price;
    main_price += option_price;
	 
	
	<?php if ($special) { ?>		
		$('#price_no_tax_plus_options').val(special);
    <?php } else { ?>		
		$('#price_no_tax_plus_options').val(main_price);
    <?php } ?>
	
    <?php if ($special) { ?>
      tax = special;
    <?php } else { ?>
      tax = main_price;
    <?php } ?>

    main_price = calculate_tax(main_price);
    special = calculate_tax(special);
	<?php if ($special) { ?>
		$('#price_tax_plus_options').val(special);
    <?php } else { ?>
		$('#price_tax_plus_options').val(main_price);
    <?php } ?>

    main_price *= input_quantity;	
    special *= input_quantity;

    animateMainPrice_quickorder(main_price);
      
    <?php if ($special) { ?>
      animateSpecialPrice_quickorder(special);
    <?php } ?>

    <?php if ($tax) { ?>
      $('#formated_tax').html( price_format(tax) );
    <?php } ?>
}

$(document).ready(function() {
    $('.option input[type="checkbox"]').bind('change', function() { recalculateprice_quickorder(); });
    $('.option input[type="radio"]').bind('change', function() { recalculateprice_quickorder(); });
    $('.option select').bind('change', function() { recalculateprice_quickorder(); });
    
    $quantity = $('input.qty_quickorder[name="quantity"]');
    $quantity.data('val', $quantity.val());
    (function() {
        if ($quantity.val() != $quantity.data('val')){
            $quantity.data('val',$quantity.val());
            recalculateprice_quickorder();
        }
        setTimeout(arguments.callee, 250);
    })();    
    
    recalculateprice_quickorder();
});

//--></script>
<script type="text/javascript"><!--
$('#popup-quickorder .date').datetimepicker({
	pickTime: false
});

$('#popup-quickorder .datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('#popup-quickorder .time').datetimepicker({
	pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script> 
</div>