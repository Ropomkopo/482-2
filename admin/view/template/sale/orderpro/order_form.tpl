<?php echo $header; ?><?php echo $column_left; ?>
<div id="content" class="orderpro-content">
	<div class="page-header">
		<div class="container-fluid">
		  <div class="pull-right">
			<div class="buttons">
				<a onclick="javascript:location.href='<?php echo $setting; ?>';" data-toggle="tooltip" title="<?php echo $button_setting_tooltip; ?>" class="btn btn-primary btn-sm"><span><?php echo $button_setting; ?></span></a>
				<span style="display:inline-block;margin:0 20px;">|</span>
				<?php if ($order_id) { ?>
					<a onclick="window.open('<?php echo $invoice; ?>&order_id=<?php echo $order_id; ?>');" data-toggle="tooltip" title="<?php echo $button_invoce_tooltip; ?>" class="btn btn-primary btn-sm"><span><?php echo $button_invoce; ?></span></a>
					<a onclick="clone_order();" data-toggle="tooltip" title="<?php echo $button_clone_tooltip; ?>" class="btn btn-primary btn-sm"><span><?php echo $button_clone; ?></span></a>
					<span style="display:inline-block;margin:0 20px;">|</span>
					<a onclick="apple_order();" data-toggle="tooltip" title="<?php echo $button_apply_tooltip; ?>" class="btn btn-primary btn-sm"><span><?php echo $button_apply; ?></span></a>
				<?php } ?>
				<a onclick="$('#order_form').submit();" data-toggle="tooltip" title="<?php echo $button_save_tooltip; ?>" class="btn btn-success btn-sm"><span><?php echo $button_save; ?></span></a>
				<a onclick="javascript:location.href='<?php echo $cancel; ?>&cancel=<?php echo $temp_order_id; ?>';" data-toggle="tooltip" title="<?php echo $button_cancel_tooltip; ?>" class="btn btn-danger btn-sm"><span><?php echo $button_cancel; ?></span></a>
			</div>
		  </div>
		  <h1><?php echo $heading_title; ?></h1>
		  <ul class="breadcrumb">
			<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
			<?php } ?>
		  </ul>
		</div>
	</div>
	<div id="notifications"></div>
	<div class="container-fluid">
    <?php if ($success) { ?>
    <div class="alert alert-success" style="padding:10px;margin-bottom:17px;border: 1px solid transparent;border-radius:3px;"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close">&times;</button>
    </div>
    <?php } ?>
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger" style="padding:10px;margin-bottom:17px;border: 1px solid transparent;border-radius:3px;"><i class="fa fa-check-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close">&times;</button>
    </div>
    <?php } ?>
    <?php if ($error_license) { ?>
    <div class="alert-danger" style="padding:10px;margin-bottom:17px;border: 1px solid transparent;border-radius:3px;"><i class="fa fa-check-circle"></i> <?php echo $error_license; ?>
      <button type="button" class="close">&times;</button>
    </div>
    <?php } ?>
    <?php if ($status_del_warning) { ?>
    <div class="alert-danger" style="padding:10px;margin-bottom:17px;border: 1px solid transparent;border-radius:3px;"><i class="fa fa-check-circle"></i> <?php echo $error_del_product; ?>
      <button type="button" class="close">&times;</button>
    </div>
    <?php } ?>
    <?php if ($status_off_warning) { ?>
    <div class="alert-info" style="padding:10px;margin-bottom:17px;border: 1px solid transparent;border-radius:3px;"><i class="fa fa-check-circle"></i> <?php echo $error_off_product; ?>
      <button type="button" class="close">&times;</button>
    </div>
    <?php } ?>
    <?php if ($status_vars_warning) { ?>
    <div class="alert-info" style="padding:10px;margin-bottom:17px;border: 1px solid transparent;border-radius:3px;"><i class="fa fa-check-circle"></i> <?php echo $error_input_vars; ?>
      <button type="button" class="close">&times;</button>
    </div>
    <?php } ?>
	<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $order_number; ?></h3>
	</div>
	
	<div class="panel-body content">
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="order_form" class="order-form-all">
		<ul class="nav nav-tabs">
			<?php if (!$orderpro_notabs_mode) { ?>
				<li class="active"><a href="#tab-order" data-toggle="tab"><?php echo $tab_order; ?></a></li>
				<li><a href="#tab-history" data-toggle="tab"><?php echo $tab_order_history; ?></a></li>
				<li><a href="#tab-total" data-toggle="tab"><?php echo $tab_total; ?></a></li>
			<?php } else { ?>
				<li class="active"><a href="#tab-allorder" data-toggle="tab"><?php echo $tab_order; ?></a></li>
			<?php } ?>
		</ul>

		<div class="tab-content">
			<?php if ($orderpro_notabs_mode) { ?>
			<div id="tab-allorder" class="tab-pane active">
			<?php } ?>
			<div id="tab-order"<?php if (!$orderpro_notabs_mode) { ?> class="tab-pane active"<?php } ?>>
			<table class="form">
				<tr>
					<td style="padding:0;">
						<div class="tuhalf leftorder" style="width:100%">
							<div class="width13">
								<div class="paramdata">
								<?php if ($customer_id) { ?>
									<a style="float:left;" class="btn btn-default btn-sm"><span><?php echo $text_account_exist; ?></span></a>
								<?php } else { ?>
									<a id="button-registered" class="btn btn-primary btn-sm"><span><?php echo $button_create_account; ?></span></a>
									<a tabindex="0" class="btn btn-primary btn-sm btn-popover" role="button" data-toggle="popover" title="<?php echo $help_registered_head; ?>" data-content="<?php echo $help_registered; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
								<?php } ?>
								</div>
							</div>
							<div class="width13">
								<div class="paramname" style="padding-left:10px;"><?php echo $text_store; ?></div>
								<div class="paramdata"><select name="store_id">
									  <option value="0"><?php echo $text_default; ?></option>
									  <?php foreach ($stores as $store) { ?>
									  <?php if ($store['store_id'] == $store_id) { ?>
									  <option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['name']; ?></option>
									  <?php } else { ?>
									  <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
									  <?php } ?>
									  <?php } ?>
									</select>
								</div>
							</div>
							<div class="width13">
								<?php if ($currencies) { ?>
								<div class="paramname"><?php echo $text_currency; ?></div>
								<div class="paramdata"><select name="currency_code">
								  <?php foreach ($currencies as $currency) { ?>
								  <?php if ($currency_code == $currency['code']) { ?>
									  <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
									  <?php } else { ?>
									  <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
								  <?php } ?>
								  <?php } ?>
									</select>
								</div>
								<?php } ?>
							</div>
							<div class="width13">
								<?php if ($languages) { ?>
								<div class="paramname"><?php echo $text_language; ?></div>
								<div class="paramdata"><select name="language">
								  <?php foreach ($languages as $language) { ?>
								  <?php if ($admin_language == $language['code']) { ?>
									  <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
									  <?php } else { ?>
									  <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
								  <?php } ?>
								  <?php } ?>
									</select>
								</div>
								<?php } ?>
							</div>
							<div class="width27" style="text-align:right;padding-right:20px;">
								<div class="paramname" style="padding-left:10px;"><?php echo $text_status; ?></div>
								<div class="paramdata"><select name="order_status_id" id="order_status_id">
									<?php foreach ($order_statuses as $order_status) { ?>
									  <?php if ($order_status['order_status_id'] == $order_status_id) { ?>
									  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
									  <?php } else { ?>
									  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
									  <?php } ?>
									<?php } ?>
									</select>
									<a tabindex="0" class="btn btn-danger btn-sm btn-popover" role="button" data-toggle="popover" data-placement="left" title="<?php echo $help_order_status_head; ?>" data-content="<?php echo $help_order_status; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
								</div>
							</div>
						</div>
	
						<div class="half leftorder">
							<div class="width101">
								<div class="width100 width99">
									<div class="width66">
										<div class="paramname paramrazdel"><?php echo $text_customer; ?></div>
									</div>
									<div class="width33">
									</div>
								</div>
								
								<div class="width100">
									<div class="width60">
										<div class="paramname"><?php echo $entry_customer; ?><span class="help" style="display:inline-block;margin-left:5px;"><?php echo $help_autocomplite; ?></span><?php if ($show_similar && $similar_customer_id) { ?><span class="similar"><a onclick="getsimilar('customer_id');">(<?php echo $similar_customer_id; ?>)</a><a tabindex="0" class="btn-popover" role="button" data-toggle="popover" title="" data-content="<?php echo $help_similar; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a></span><?php } ?></div>
										<div class="paramdata"><input type="text" name="customer" value="<?php echo $customer; ?>" />
											<input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
											<input type="hidden" name="virtual_customer_id" value="<?php echo $virtual_customer_id; ?>" />
											<input type="hidden" name="customer_group_id" value="<?php echo $customer_group_id; ?>" />
											<input type="hidden" name="invoice_no" value="<?php echo $invoice_no; ?>" />
											<input type="hidden" name="date_added" value="<?php echo $date_added; ?>" />
											<input type="hidden" name="ip" value="<?php echo $ip; ?>" />
											<input type="hidden" name="clone" id="clone" value="<?php echo $clone; ?>" />
											<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
											<input type="hidden" name="temp_order_id" value="<?php echo $temp_order_id; ?>" />
										</div>
									</div>
									<div class="width40">
									</div>
								</div>
			
								<div class="width100">
									<div class="width60">
									  <div class="paramname"><?php echo $entry_firstname; ?></div>
									  <div class="paramdata"><input type="text" name="firstname" value="<?php echo $firstname; ?>" />
										<?php if ($error_firstname) { ?><span class="error"><?php echo $error_firstname; ?></span><?php } ?>
									  </div>
									</div>
									
									<div class="width40">
									  <div class="paramname"><?php echo $entry_lastname; ?><?php if ($show_similar && $similar_lastname) { ?><span class="similar"><a onclick="getsimilar('lastname');">(<?php echo $similar_lastname; ?>)</a><a tabindex="0" class="btn-popover" role="button" data-toggle="popover" title="" data-content="<?php echo $help_similar; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a></span><?php } ?></div>
									  <div class="paramdata"><input type="text" name="lastname" value="<?php echo $lastname; ?>" /></div>
									</div>
								</div>
		
								<div class="width100">
									<div class="width33">
										<div class="paramname"><?php echo $entry_email; ?><?php if ($show_similar && $similar_email) { ?><span class="similar"><a onclick="getsimilar('email');">(<?php echo $similar_email; ?>)</a><a tabindex="0" class="btn-popover" role="button" data-toggle="popover" title="" data-content="<?php echo $help_similar; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a></span><?php } ?></div>
										<div class="paramdata"><input type="text" name="email" value="<?php echo $email; ?>" />
											<?php if ($error_email) { ?><span class="error"><?php echo $error_email; ?></span><?php } ?>
										</div>
									</div>
									
									<div class="width33">
										<div class="paramname"><?php echo $entry_telephone; ?><?php if ($show_similar && $similar_telephone) { ?><span class="similar"><a onclick="getsimilar('telephone');">(<?php echo $similar_telephone; ?>)</a><a tabindex="0" class="btn-popover" role="button" data-toggle="popover" title="" data-content="<?php echo $help_similar; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a></span><?php } ?></div>
										<div class="paramdata"><input type="text" name="telephone" value="<?php echo $telephone; ?>" /></div>
									</div>
									
									<div class="width33">
										<div class="paramname"><?php echo $entry_fax; ?><?php if ($show_similar && $similar_fax) { ?><span class="similar"><a onclick="getsimilar('fax');">(<?php echo $similar_fax; ?>)</a><a tabindex="0" class="btn-popover" role="button" data-toggle="popover" title="" data-content="<?php echo $help_similar; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a></span><?php } ?></div>
										<div class="paramdata"><input type="text" name="fax" value="<?php echo $fax; ?>" /></div>
									</div>
								</div>
		
								<div class="width100">
									<div class="width66">
										<div class="paramname"><?php echo $entry_comment_customer; ?></div>
										<div class="paramdata"><textarea name="comment" style="width:96%;height:50px;resize:vertical;"><?php echo $comment; ?></textarea></div>
									</div>
									<div class="width33">
										<div class="paramname"><?php echo $entry_company; ?><?php if ($show_similar && $similar_company) { ?><span class="similar"><a onclick="getsimilar('company');">(<?php echo $similar_company; ?>)</a><a tabindex="0" class="btn-popover" role="button" data-toggle="popover" title="" data-content="<?php echo $help_similar; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a></span><?php } ?></div>
										<div class="paramdata"><input type="text" name="payment_company" value="<?php echo $payment_company; ?>" /></div>
									</div>
								</div>
							</div>
						</div>
		
						<div class="half rightorder">
							<div class="width103">
								<div class="width100 width99">
									<div class="width66">
										<div class="paramname paramrazdel"><?php echo $text_shipping; ?></div>
									</div>
									
									<div class="width33">
									</div>
								</div>

								<div class="width100">
									<div class="width60">
									  <div class="paramname"><?php echo $entry_address; ?></div>
									  <div class="paramdata"><select name="shipping_address" style="width:85%;">
										  <option value="0"><?php echo $text_none; ?></option>
										  <?php foreach ($addresses as $address) { ?>
										  <option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname'] . ' ' . $address['lastname'] . ', ' . $address['zone'] . ', ' . $address['city'] . ', ' . $address['address_1']; ?></option>
										  <?php } ?>
										</select></div>
									</div>
									
									<div class="width40" style="display:none;height:45px;">
									</div>
								</div>
								
								<div class="width100">
									<div class="width60">
									  <div class="paramname"><?php echo $entry_firstname; ?></div>
									  <div class="paramdata"><input type="text" name="shipping_firstname" value="<?php echo $shipping_firstname; ?>" />
										<?php if ($error_shipping_firstname) { ?><span class="error"><?php echo $error_shipping_firstname; ?></span><?php } ?>
									  </div>
									</div>
									
									<div class="width40">
									  <div class="paramname"><?php echo $entry_lastname; ?></div>
									  <div class="paramdata"><input type="text" name="shipping_lastname" value="<?php echo $shipping_lastname; ?>" /></div>
									</div>
								</div>
								
								<div class="width100">
									<div class="width33">
									  <div class="paramname"><?php echo $entry_country; ?></div>
									  <div class="paramdata"><select name="shipping_country_id" style="width:90%;">
										  <option value=""><?php echo $text_select; ?></option>
										  <?php foreach ($countries as $country) { ?>
										  <?php if ($country['country_id'] == $shipping_country_id) { ?>
										  <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
										  <?php } else { ?>
										  <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
										  <?php } ?>
										  <?php } ?>
										</select>
									  </div>
									</div>
									
									<div class="width40">
									  <div class="paramname"><?php echo $entry_zone; ?></div>
									  <div class="paramdata"><select name="shipping_zone_id" style="width:90%;"></select>
									  </div>
									</div>
									
									<div class="width20">
									  <div class="paramname"><?php echo $entry_postcode; ?></div>
									  <div class="paramdata"><input type="text" name="shipping_postcode" value="<?php echo $shipping_postcode; ?>" />
									  </div>
									</div>
								</div>

								<div class="width100">
									<div class="width33">
									  <div class="paramname"><?php echo $entry_city; ?></div>
									  <div class="paramdata"><input type="text" name="shipping_city" value="<?php echo $shipping_city; ?>" /></div>
									</div>
									
									<div class="width40">
									  <div class="paramname"><?php echo $entry_address_1; ?></div>
									  <div class="paramdata"><input type="text" name="shipping_address_1" value="<?php echo $shipping_address_1; ?>" /></div>
									</div>
									
									<div class="width20">
									  <div class="paramname"><?php echo $entry_address_2; ?></div>
									  <div class="paramdata"><input type="text" name="shipping_address_2" value="<?php echo $shipping_address_2; ?>" /></div>
									</div>
								</div>
							</div>
						</div>
						
						<?php if ($custom_fields) { ?>
						<div class="half" id="csfield">
							<?php if ($custom_fields && $account_custom_fields) { ?>
							<div class="width100 width99">
								<div class="width66">
									<div class="paramname paramrazdel"><?php echo $text_account_custom_field; ?></div>
								</div>
								<div class="width33">
								</div>
							</div>

							<div class="width100" id="csfield-account">
							  <?php foreach ($custom_fields as $custom_field) { ?>
							  <?php if ($custom_field['location'] == 'account') { ?>
							  <?php if ($custom_field['type'] == 'select') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata"><select name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>">
									<option value=""><?php echo $text_select; ?></option>
									<?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
									<?php if (isset($account_custom_field[$custom_field['custom_field_id']]) && ($custom_field_value['custom_field_value_id'] == $account_custom_field[$custom_field['custom_field_id']])) { ?>
									<option value="<?php echo $custom_field_value['custom_field_value_id']; ?>" selected="selected"><?php echo $custom_field_value['name']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $custom_field_value['custom_field_value_id']; ?>"><?php echo $custom_field_value['name']; ?></option>
									<?php } ?>
									<?php } ?>
								  </select>
								</div>
							  </div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'radio') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata">
									<?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
									<div class="radio">
									  <?php if (isset($account_custom_field[$custom_field['custom_field_id']]) && ($custom_field_value['custom_field_value_id'] == $account_custom_field[$custom_field['custom_field_id']])) { ?>
									  <label>
										<input type="radio" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" checked="checked" />
										<?php echo $custom_field_value['name']; ?></label>
									  <?php } else { ?>
									  <label>
										<input type="radio" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
										<?php echo $custom_field_value['name']; ?></label>
									  <?php } ?>
									</div>
									<?php } ?>
								</div>
							  </div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'checkbox') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata">
									<?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
									<div class="checkbox">
									  <?php if (isset($account_custom_field[$custom_field['custom_field_id']]) && in_array($custom_field_value['custom_field_value_id'], $account_custom_field[$custom_field['custom_field_id']])) { ?>
									  <label>
										<input type="checkbox" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" checked="checked" />
										<?php echo $custom_field_value['name']; ?></label>
									  <?php } else { ?>
									  <label>
										<input type="checkbox" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
										<?php echo $custom_field_value['name']; ?></label>
									  <?php } ?>
									</div>
									<?php } ?>
								  </div>
								</div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'text') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata">
								  <input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($account_custom_field[$custom_field['custom_field_id']]) ? $account_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" />
								</div>
							  </div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'textarea') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata">
								  <textarea name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" rows="2" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['value']; ?></textarea>
								</div>
							  </div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'file') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata upfile-block">
								  <a id="file-link-<?php echo $custom_field['custom_field_id']; ?>" class="file-link" title="<?php echo $text_download; ?>"<?php if ($custom_field['custom_field_href']) { ?> href="<?php echo $custom_field['custom_field_href']; ?>"<?php } ?>><?php echo $custom_field['custom_field_filename']; ?></a>
								  <a id="button-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="btn btn-primary btn-sm" title="<?php echo $text_upload; ?>"><i class="fa fa-upload"></i></a>
								  <input type="hidden" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($account_custom_field[$custom_field['custom_field_id']]) ? $account_custom_field[$custom_field['custom_field_id']] : ''); ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" />
								</div>
							  </div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'date') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata">
								  <div class="input-group date">
									<input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($account_custom_field[$custom_field['custom_field_id']]) ? $account_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" />
									<span class="input-group-btn">
									<a class="btn btn-default btn-sm"><i class="fa fa-calendar"></i></a>
									</span></div>
								</div>
							  </div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'time') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata">
								  <div class="input-group time">
									<input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($account_custom_field[$custom_field['custom_field_id']]) ? $account_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" />
									<span class="input-group-btn">
									<a class="btn btn-default btn-sm"><i class="fa fa-calendar"></i></a>
									</span></div>
								</div>
							  </div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'datetime') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata">
								  <div class="input-group datetime">
									<input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($account_custom_field[$custom_field['custom_field_id']]) ? $account_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" />
									<span class="input-group-btn">
									<a class="btn btn-default btn-sm"><i class="fa fa-calendar"></i></a>
									</span></div>
								</div>
							  </div>
							  <?php } ?>
							  <?php } ?>
							  <?php } ?>
							</div>
							<?php } ?>
						
							<?php if ($custom_fields && $address_custom_fields) { ?>
							<div class="width100 width99">
								<div class="width66">
									<div class="paramname paramrazdel"><?php echo $text_shipping_custom_field; ?></div>
								</div>
								<div class="width33">
								</div>
							</div>

							<div class="width100" id="csfield-shipping">
							  <?php foreach ($custom_fields as $custom_field) { ?>
							  <?php if ($custom_field['location'] == 'address') { ?>
							  <?php if ($custom_field['type'] == 'select') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata"><select name="shipping_custom_field[<?php echo $custom_field['custom_field_id']; ?>]" id="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>">
									<option value=""><?php echo $text_select; ?></option>
									<?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
									<?php if (isset($shipping_custom_field[$custom_field['custom_field_id']]) && ($custom_field_value['custom_field_value_id'] == $shipping_custom_field[$custom_field['custom_field_id']])) { ?>
									<option value="<?php echo $custom_field_value['custom_field_value_id']; ?>" selected="selected"><?php echo $custom_field_value['name']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $custom_field_value['custom_field_value_id']; ?>"><?php echo $custom_field_value['name']; ?></option>
									<?php } ?>
									<?php } ?>
								  </select>
								</div>
							  </div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'radio') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata">
									<?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
									<div class="radio">
									  <?php if (isset($shipping_custom_field[$custom_field['custom_field_id']]) && ($custom_field_value['custom_field_value_id'] == $shipping_custom_field[$custom_field['custom_field_id']])) { ?>
									  <label>
										<input type="radio" name="shipping_custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" checked="checked" />
										<?php echo $custom_field_value['name']; ?></label>
									  <?php } else { ?>
									  <label>
										<input type="radio" name="shipping_custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
										<?php echo $custom_field_value['name']; ?></label>
									  <?php } ?>
									</div>
									<?php } ?>
								</div>
								</div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'checkbox') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata">
									<?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
									<div class="checkbox">
									  <?php if (isset($shipping_custom_field[$custom_field['custom_field_id']]) && in_array($custom_field_value['custom_field_value_id'], $shipping_custom_field[$custom_field['custom_field_id']])) { ?>
									  <label>
										<input type="checkbox" name="shipping_custom_field[<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" checked="checked" />
										<?php echo $custom_field_value['name']; ?></label>
									  <?php } else { ?>
									  <label>
										<input type="checkbox" name="shipping_custom_field[<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
										<?php echo $custom_field_value['name']; ?></label>
									  <?php } ?>
									</div>
									<?php } ?>
								</div>
								</div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'text') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata">
								  <input type="text" name="shipping_custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($shipping_custom_field[$custom_field['custom_field_id']]) ? $shipping_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" id="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>" />
								</div>
							  </div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'textarea') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata">
								  <textarea name="shipping_custom_field[<?php echo $custom_field['custom_field_id']; ?>]" rows="2" placeholder="<?php echo $custom_field['name']; ?>" id="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo (isset($shipping_custom_field[$custom_field['custom_field_id']]) ? $shipping_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?></textarea>
								</div>
							  </div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'file') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata upfile-block">
								  <a id="file-link-<?php echo $custom_field['custom_field_id']; ?>" class="file-link" title="<?php echo $text_download; ?>"<?php if ($custom_field['custom_field_href']) { ?> href="<?php echo $custom_field['custom_field_href']; ?>"<?php } ?>><?php echo $custom_field['custom_field_filename']; ?></a>
								  <a id="button-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="btn btn-primary btn-sm" title="<?php echo $text_upload; ?>"><i class="fa fa-upload"></i></a>
								  <input type="hidden" name="shipping_custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($shipping_custom_field[$custom_field['custom_field_id']]) ? $shipping_custom_field[$custom_field['custom_field_id']] : ''); ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" />
								</div>
							  </div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'date') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata">
								  <div class="input-group date">
									<input type="text" name="shipping_custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($shipping_custom_field[$custom_field['custom_field_id']]) ? $shipping_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD" id="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>" />
									<span class="input-group-btn">
									<a class="btn btn-default btn-sm"><i class="fa fa-calendar"></i></a>
									</span></div>
								</div>
							  </div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'time') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata">
								  <div class="input-group time">
									<input type="text" name="shipping_custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($shipping_custom_field[$custom_field['custom_field_id']]) ? $shipping_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="HH:mm" id="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>" />
									<span class="input-group-btn">
									<a class="btn btn-default btn-sm"><i class="fa fa-calendar"></i></a>
									</span></div>
								</div>
							  </div>
							  <?php } ?>
							  <?php if ($custom_field['type'] == 'datetime') { ?>
							  <div class="width16 custom-field custom-field<?php echo $custom_field['custom_field_id']; ?>">
								<div class="paramname"><?php echo $custom_field['name']; ?></div>
								<div class="paramdata">
								  <div class="input-group datetime">
									<input type="text" name="shipping_custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($shipping_custom_field[$custom_field['custom_field_id']]) ? $shipping_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>" />
									<span class="input-group-btn">
									<a class="btn btn-default btn-sm"><i class="fa fa-calendar"></i></a>
									</span></div>
								</div>
							  </div>
							  <?php } ?>
							  <?php } ?>
							  <?php } ?>
							</div>
							<?php } ?>

						</div>
						<?php } ?>
						
						<div class="half" id="simplefield">
							<div id="simple_custblock"></div>
							<div id="simple_payblock"></div>
							<div id="simple_shipblock"></div>
						</div>
					</td>
				</tr>
			</table>
			</div>

			<div id="tab-payment" style="display:none;">
				<table class="form order-payment">
					<tbody>
						<tr>
						  <td><input type="text" name="payment_firstname" value="<?php echo $payment_firstname; ?>" /></td>
						  <td><input type="text" name="payment_lastname" value="<?php echo $payment_lastname; ?>" /></td>
						  <td><input type="text" name="payment_address_1" value="<?php echo $payment_address_1; ?>" /></td>
						  <td><input type="text" name="payment_address_2" value="<?php echo $payment_address_2; ?>" /></td>
						  <td><input type="text" name="payment_city" value="<?php echo $payment_city; ?>" /></td>
						  <td><input type="text" name="payment_postcode" value="<?php echo $payment_postcode; ?>" /></td>
						  <td><input type="text" name="payment_country_id" value="<?php echo $payment_country_id; ?>" /></td>
						  <td><input type="text" name="payment_zone_id" value="<?php echo $payment_zone_id; ?>" /></td>
						  <td><input type="text" name="shipping_company" value="<?php echo $shipping_company; ?>" /></td>
						</tr>
					</tbody>
				</table>
			</div>

			<?php if ($orderpro_notabs_mode) { ?>
			<div class="terminator"></div>
			<?php } ?>

			<div id="tab-history"<?php if (!$orderpro_notabs_mode) { ?> class="tab-pane"<?php } ?>>
				<div class="mode-history">
					<table id="order-history" class="form">
					<?php if ($order_id) { ?>
					  <tr>
					    <td class="status-history">
							<div class="paramblock">
								<div class="paramname"><?php echo $entry_order_status; ?></div>
								<div class="paramdata"><select id="horder_status_id">
									<?php foreach ($order_statuses as $order_statuses) { ?>
									<?php if ($order_statuses['order_status_id'] == $order_status_id) { ?>
									<option value="<?php echo $order_statuses['order_status_id']; ?>" selected="selected"><?php echo $order_statuses['name']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $order_statuses['order_status_id']; ?>"><?php echo $order_statuses['name']; ?></option>
									<?php } ?>
									<?php } ?>
								  </select></div>
							</div>
							<div class="paramblock line-block">
								<div class="paramname"><?php echo $entry_notify; ?></div>
								<div class="paramdata"><input type="checkbox" name="notify" value="1" /></div>
							</div>
							<div class="paramblock line-block">
								<div class="paramname"><?php echo $entry_notify_asnew; ?></div>
								<div class="paramdata">
									<input type="checkbox" name="notify_asnew" value="1" />
									<a tabindex="0" class="btn btn-primary btn-xs btn-popover" role="button" data-toggle="popover" title="" data-content="<?php echo $help_notify_asnew; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
								</div>
							</div>
							<span class="history-berth"></span>
						</td>
						<td class="status-comment">
							<div class="paramname"><?php echo $entry_comment; ?></div>
							<div class="paramdata"><textarea name="admin_comment" rows="4"></textarea></div>
						</td>
						<td class="status-add">
							<a id="button-history" class="btn btn-primary btn-sm"><?php echo $button_add_history; ?></a>
						</td>
					  </tr>
					<?php } else { ?>
					  <tr>
					    <td align="center"><?php echo $text_neworder_history; ?></td>
					  </tr>
					<?php } ?>
					</table>
				</div>
				<div id="history"></div>
			</div>

			<?php if ($orderpro_notabs_mode) { ?>
			<div class="terminator"></div>
			<?php } ?>

			<div id="tab-total"<?php if (!$orderpro_notabs_mode) { ?> class="tab-pane"<?php } ?>>
				<?php 
				$cart_colspan = 11;
				if ($show_pid) {$hide_pid = '';} else {$hide_pid = ' style="display:none;"';$cart_colspan -= 1;}
				if ($show_image) {$hide_image = '';} else {$hide_image = ' style="display:none;"';$cart_colspan -= 1;}
				if ($show_model) {$hide_model = '';} else {$hide_model = ' style="display:none;"';$cart_colspan -= 1;}
				if ($show_sku) {$hide_sku = '';} else {$hide_sku = ' style="display:none;"';$cart_colspan -= 1;}
				if ($show_upc) {$hide_upc = '';} else {$hide_upc = ' style="display:none;"';$cart_colspan -= 1;}
				if ($show_ean) {$hide_ean = '';} else {$hide_ean = ' style="display:none;"';$cart_colspan -= 1;}
				if ($show_jan) {$hide_jan = '';} else {$hide_jan = ' style="display:none;"';$cart_colspan -= 1;}
				if ($show_isbn) {$hide_isbn = '';} else {$hide_isbn = ' style="display:none;"';$cart_colspan -= 1;}
				if ($show_mpn) {$hide_mpn = '';} else {$hide_mpn = ' style="display:none;"';$cart_colspan -= 1;}
				if ($show_location) {$hide_location = '';} else {$hide_location = ' style="display:none;"';$cart_colspan -= 1;}
				if (($customer_id) && ($reward_status)) {$hide_reward = '';} else {$hide_reward = ' style="display:none;"';}
				if ($show_weight) {$hide_weight = '';} else {$hide_weight = ' style="display:none;"';}
				?>
				<table id="product" class="list order-products">
					<thead>
						<tr>
						    <td class="center column-pid"<?php echo $hide_pid; ?>><?php echo $column_pid; ?></td>
							<td class="center column-image"<?php echo $hide_image; ?>><?php echo $column_image; ?></td>
							<td class="center column-product"><?php echo $column_product; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-model"<?php echo $hide_model; ?>><?php echo $column_model; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-sku"<?php echo $hide_sku; ?>><?php echo $column_sku; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-upc"<?php echo $hide_upc; ?>><?php echo $column_upc; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-ean"<?php echo $hide_ean; ?>><?php echo $column_ean; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-jan"<?php echo $hide_jan; ?>><?php echo $column_jan; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-isbn"<?php echo $hide_isbn; ?>><?php echo $column_isbn; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-mpn"<?php echo $hide_mpn; ?>><?php echo $column_mpn; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-location"<?php echo $hide_location; ?>><?php echo $column_location; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-weight"<?php echo $hide_weight; ?>><?php echo $column_weight; ?><span class="help"><?php echo $help_weight; ?></span></td>
							<td class="center column-quantity"><?php echo $column_quantity; ?><span class="help"><?php echo $help_qty; ?></span></td>
							<td class="center column-realquantity"><?php echo $column_realquantity; ?><span class="help"><?php echo $help_stock; ?></span></td>
							<td class="center column-price"><?php echo $column_price; ?><img src="view/image/orderpro/delete16.png" id="empty-prices" alt="" title="<?php echo $help_empty_prices; ?>" /><span class="help"><?php echo $help_price; ?></span></td>
							<td class="center column-now_price"><?php echo $column_now_price; ?><span class="help"><?php echo $help_now_price; ?></span></td>
							<td class="center column-total"><?php echo $column_total; ?></td>
							<td class="center column-discount"><?php echo $column_discount; ?><img src="view/image/orderpro/delete16.png" id="empty-discounts" alt="" title="<?php echo $help_empty_discounts; ?>" /></td>
							<td class="center column-reward"<?php echo $hide_reward; ?>><span class="blong"><?php echo $column_reward; ?></span><span class="bshort"><?php echo $column_reward_short; ?></span></td>
							<td class="center column-action"></td>
						</tr>
					</thead>
					
					<?php $product_row = 0; ?>
					<input type="hidden" name="order_products" value='<?php echo urlencode(json_encode($order_products)); ?>' />
					<?php foreach ($order_products as $order_product) { ?>
					<tbody id="product-row<?php echo $product_row; ?>">
						<?php if ($order_product['status'] == '0') {$name_class = ' item-off';} elseif ($order_product['status'] == '3') {$name_class = ' item-del';} else {$name_class = '';} ?>
						<tr class="product-line<?php echo $name_class; ?>">
							<td class="center"<?php echo $hide_pid; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][product_id]" value="<?php echo $order_product['product_id']; ?>" class="input-pid" readonly /></td>
							<td class="center"<?php echo $hide_image; ?>>
								<div class="product-image" id="image_<?php echo $product_row; ?>">
									<a href="<?php echo $order_product['href']; ?>" target="_blank"><img src="<?php echo $order_product['image']; ?>" alt="<?php echo $order_product['name']; ?>" /></a>
									<?php if ($order_product['popap']) { ?><span id="popap_<?php echo $product_row; ?>" class="product-popap" data-popap="<?php echo $order_product['popap']; ?>"></span><?php } ?>
								</div>
							</td>
							<td class="center">
							  <input type="text" name="order_product[<?php echo $product_row; ?>][name]" value="<?php echo $order_product['name']; ?>" class="input-name" />
							  <input type="hidden" name="order_product[<?php echo $product_row; ?>][order_product_id]" value="<?php echo $order_product['order_product_id']; ?>" />
							  <input type="hidden" name="order_product[<?php echo $product_row; ?>][tax]" value="<?php echo $order_product['tax']; ?>" />
							  <input type="hidden" name="order_product[<?php echo $product_row; ?>][status]" value="<?php echo $order_product['status']; ?>" />
							  <div id="product_options<?php echo $product_row; ?>">
							  <?php if ($order_product['option']) { ?>
								  <div class="poptions">
								  <?php foreach ($order_product['option'] as $option) { ?>
								  <?php if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'image') { ?>
								  <div class="option">
									  <?php if ($option['required']) { ?>
										<span class="required">*</span>
									  <?php } ?>
									  <?php echo $option['name']; ?><br />
									  <select name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]">
										  <?php if (!$option['required']) { ?>
										  <option value=""><?php echo $text_select; ?></option>
										  <?php } ?>
										<?php foreach ($option['option_value'] as $option_value) { ?>
											<?php if (in_array($option_value['product_option_value_id'], $order_product['order_option'])) { ?>
												<option value="<?php echo $option_value['product_option_value_id']; ?>" selected="selected"><?php echo $option_value['name']; ?>
												<?php if ($option_value['price']) { ?>
												(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
												<?php } ?>
												</option>
											<?php } else {?>
												<option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
												<?php if ($option_value['price']) { ?>
												(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
												<?php } ?>
												</option>
											<?php } ?>
										<?php } ?>
									  </select>
								  </div>
								  <br />
								  <?php } ?>
								  <?php if ($option['type'] == 'checkbox') { ?>
								  <div>
								  <?php if ($option['required']) { ?><span class="required">*</span><?php } ?>
								  <?php echo $option['name']; ?><br />
								  <?php foreach ($option['option_value'] as $option_value) { ?>
								  <?php if (in_array($option_value['product_option_value_id'], $order_product['order_option'])) { ?>
									<input checked="checked" type="checkbox" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $product_row; ?>-<?php echo $option_value['product_option_value_id']; ?>" />
								  <?php } else { ?>
									<input type="checkbox" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $product_row; ?>-<?php echo $option_value['product_option_value_id']; ?>" />
								  <?php } ?>
								  <label for="option-value-<?php echo $product_row; ?>-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
									<?php if ($option_value['price']) { ?>
									(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
									<?php } ?>
								  </label><br />
								  <?php } ?>
								  </div>
								  <br />
								  <?php } ?>
								  <?php if ($option['type'] == 'text') { ?>
								  <div>
								  <?php if ($option['required']) { ?><span class="required">*</span><?php } ?>
								  <?php echo $option['name']; ?><br />
								  <input type="text" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
								  </div>
								  <br />
								  <?php } ?>
								  <?php if ($option['type'] == 'textarea') { ?>
								  <div>
								  <?php if ($option['required']) { ?><span class="required">*</span><?php } ?>
								  <?php echo $option['name']; ?><br />
								  <textarea name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
								  </div>
								  <br />
								  <?php } ?>
								  <?php if ($option['type'] == 'file') { ?>
								  <div class="upfile-block">
								  <?php if ($option['required']) { ?><span class="required">*</span><?php } ?>
								  <?php echo $option['name']; ?><br />
								  <a id="file-link-<?php echo $option['product_option_id']; ?>-<?php echo $product_row; ?>" class="file-link"<?php if ($option['href']) { ?> href="<?php echo $option['href']; ?>"<?php } ?> title="<?php echo $text_download; ?>"><?php echo $option['option_filename']; ?></a>
								  <a id="button-upload-<?php echo $option['product_option_id']; ?>-<?php echo $product_row; ?>" class="btn btn-primary btn-sm" title="<?php echo $text_upload; ?>"><i class="fa fa-upload"></i></a>
								  <input type="hidden" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
								  </div>
								  <br />
								  <?php } ?>
								  <?php if ($option['type'] == 'date') { ?>
								  <div>
								  <?php if ($option['required']) { ?><span class="required">*</span><?php } ?>
								  <?php echo $option['name']; ?><br />
								  <div class="date"><input type="text" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" data-date-format="YYYY-MM-DD" />
								  <span class="input-group-btn"><a class="btn btn-default btn-sm"><i class="fa fa-calendar"></i></a></span></div>
								  </div>
								  <br />
								  <?php } ?>
								  <?php if ($option['type'] == 'datetime') { ?>
								  <div>
								  <?php if ($option['required']) { ?><span class="required">*</span><?php } ?>
								  <?php echo $option['name']; ?><br />
								  <div class="datetime"><input type="text" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" data-date-format="YYYY-MM-DD HH:mm" />
								  <span class="input-group-btn"><a class="btn btn-default btn-sm"><i class="fa fa-calendar"></i></a></span></div>
								  </div>
								  <br />
								  <?php } ?>
								  <?php if ($option['type'] == 'time') { ?>
								  <div>
								  <?php if ($option['required']) { ?><span class="required">*</span><?php } ?>
								  <?php echo $option['name']; ?><br />
								  <div class="time"><input type="text" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" data-date-format="HH:mm" />
								  <span class="input-group-btn"><a class="btn btn-default btn-sm"><i class="fa fa-calendar"></i></a></span></div>
								  </div>
								  <br />
								  <?php } ?>
								  <?php } ?>
								  </div>
							  <?php } ?>
							  </div>
							</td>
							<td class="center"<?php echo $hide_model; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][model]" value="<?php echo $order_product['model']; ?>" class="input-model" /></td>
							<td class="center"<?php echo $hide_sku; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][sku]" value="<?php echo $order_product['sku']; ?>" class="input-sku" /></td>
							<td class="center"<?php echo $hide_upc; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][upc]" value="<?php echo $order_product['upc']; ?>" class="input-upc" /></td>
							<td class="center"<?php echo $hide_ean; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][ean]" value="<?php echo $order_product['ean']; ?>" class="input-ean" /></td>
							<td class="center"<?php echo $hide_jan; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][jan]" value="<?php echo $order_product['jan']; ?>" class="input-jan" /></td>
							<td class="center"<?php echo $hide_isbn; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][isbn]" value="<?php echo $order_product['isbn']; ?>" class="input-isbn" /></td>
							<td class="center"<?php echo $hide_mpn; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][mpn]" value="<?php echo $order_product['mpn']; ?>" class="input-mpn" /></td>
							<td class="center"<?php echo $hide_location; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][location]" value="<?php echo $order_product['location']; ?>" class="input-location" /></td>
							<td class="right product-weight"<?php echo $hide_weight; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][weight]" value="<?php echo $order_product['weight']; ?>" class="onlyread" readonly /></td>
							<td class="center product-quantity"><input type="text" name="order_product[<?php echo $product_row; ?>][quantity]" value="<?php echo $order_product['quantity']; ?>" /></td>
							<td class="center"><span id="realquantity_<?php echo $product_row; ?>"><?php echo $order_product['realquantity']; ?></span></td>
							<td class="right product-price">
								<input type="text" name="order_product[<?php echo $product_row; ?>][price]" value="<?php echo $order_product['price']; ?>" class="input-price" />
								<img src="view/image/orderpro/close14.png" class="price-empty" title="<?php echo $help_empty_price; ?>" alt="" />
							</td>
							<td class="right now_price">
								<span id="now_price_<?php echo $product_row; ?>"><?php echo $order_product['now_price']; ?></span>
								<span id="now_special_<?php echo $product_row; ?>" style="color:red;"><?php echo $order_product['now_special']; ?></span>
								<span id="now_discount_<?php echo $product_row; ?>" style="color:blue;"><?php echo $order_product['now_discount_qty']; ?>/<?php echo $order_product['now_discount']; ?></span>
							</td>
							<td class="right product-total"><input type="text" name="order_product[<?php echo $product_row; ?>][total]" value="<?php echo $order_product['total']; ?>" class="onlyread" readonly /></td>
							<td class="right product-discount" nowrap>
								<input type="text" name="order_product[<?php echo $product_row; ?>][discount_amount]" value="<?php echo $order_product['discount_amount']; ?>" class="input-amount" <?php if($order_product['discount_amount'] > 0) { ?>style="border: 1px solid #38AD38;" <?php } ?>/>
								<select name="order_product[<?php echo $product_row; ?>][discount_type]">
									<?php if ($order_product['discount_type'] == 'S') { ?>
										<option value="S" selected="selected">S</option>
										<option value="P">%</option>
									<?php } else { ?>
										<option value="P" selected="selected">%</option>
										<option value="S">S</option>
									<?php } ?>
								</select><img src="view/image/orderpro/close14.png" class="amount-empty" title="<?php echo $help_empty_discount; ?>" alt="" />
							</td>
							<td class="right product-reward"<?php echo $hide_reward; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][reward]" value="<?php echo $order_product['reward']; ?>" class="onlyread" readonly /></td>
							<td class="premove center"><a onclick="$('#product-row<?php echo $product_row; ?>').remove();" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></a></td>
						</tr>
					</tbody>
					<?php $product_row++; ?>
					<?php } ?>
					<tfoot>
						<tr class="total-line">
							<td class="left cart-colspan" colspan="<?php echo $cart_colspan; ?>"></td>
							<td class="right cart-weight"<?php echo $hide_weight; ?>><input type="text" id="weight_cart" value="<?php echo $weight_cart; ?>" class="onlyread" readonly /></td>
							<td class="right cart-items"><input type="text" id="items_cart" value="<?php echo $items_cart; ?>" class="onlyread" readonly /></td>
							<td class="left" colspan="3"></td>
							<td class="right cart-total"><input type="text" id="total_cart" value="<?php echo $total_cart; ?>" class="onlyread" readonly /></td>
							<td class="right cart-discount"><input type="text" id="discount_cart" value="<?php echo $discount_cart; ?>" class="onlyread" readonly /></td>
							<td class="right cart-reward"<?php echo $hide_reward; ?>><input type="text" id="reward_cart" value="<?php echo $reward_cart; ?>" class="onlyread" readonly /></td>
							<td class="center cart-add"><a onclick="addProduct();" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></a></td>
						</tr>
					</tfoot>
				</table>
				
				<?php if ($customer_id && $reward_status) { ?>
				<table class="list form" id="order-reward">
					<tbody>
						<tr>
						  <td>
							<div class="reward-title"><?php echo $entry_reward_total; ?></div>
							<div class="reward-data" id="reward-total"><span class="rtotal"><?php echo $reward_total; ?></span>/<span class="ptotal"><?php echo $reward_possibly; ?></span></div>
						  </td>
						  <td>
							<div class="reward-title"><?php echo $entry_reward_recived; ?></div>
							<div class="reward-data" id="reward-recived">
								<span><?php echo $reward_recived; ?></span>
								<a id="reward-remove" title="" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></a>
								<a tabindex="0" class="btn btn-primary btn-xs btn-popover" role="button" data-toggle="popover" title="<?php echo $help_reward_removed_head; ?>" data-content="<?php echo $help_reward_removed; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
							</div>
						  </td>
						  <td>
							<div class="reward-title"><?php echo $entry_reward; ?></div>
							<div class="reward-data">
								<input type="text" name="reward_cart" value="<?php echo $reward_cart; ?>" />
								<a id="reward-add" title="" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></a>
								<a tabindex="0" class="btn btn-primary btn-xs btn-popover" role="button" data-toggle="popover" data-placement="left" title="<?php echo $help_reward_add_head; ?>" data-content="<?php echo $help_reward_add; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
							</div>
						  </td>
						  <td>
							<div class="reward-title"><?php echo $entry_reward_use; ?></div>
							<div class="reward-data" id="rewards-available">
								<input type="text" name="reward_use" value="<?php echo $reward_use; ?>" style="vertical-align:middle;"/><span class="reward-use"></span>
								<a tabindex="0" class="btn btn-danger btn-xs btn-popover" role="button" data-toggle="popover" data-placement="left" title="" data-content="<?php echo $help_reward_use; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
							</div>
						  </td>
						</tr>
					</tbody>
				</table>
				<?php } ?>

				<?php if ($coupon_status || $voucher_status || ($order_id && ($show_affiliate || $affiliate))) { ?>
				<table class="list form" id="order-dops">
					<tbody>
						<tr>
							<td>
							<?php if ($coupon_status) { ?>
								<div id="coupon" class="dops-block">
									<div class="title-order-coupon"><?php echo $entry_coupon; ?><span class="help"><?php echo $help_autocomplite; ?></span></div>
									<input type="text" name="coupon_code" value="<?php echo $coupon_code; ?>" />
									<a tabindex="0" class="btn btn-primary btn-xs btn-popover" role="button" data-toggle="popover" title="<?php echo $help_coupon_head; ?>" data-content="<?php echo $help_coupon; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
									<a tabindex="0" class="btn btn-danger btn-xs btn-popover" role="button" data-toggle="popover" title="" data-content="<?php echo $help_coupon_use; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
								</div>
							<?php } ?>
							</td>
							<td>
							<?php if ($voucher_status) { ?>
								<div id="voucher" class="dops-block">
									<div class="title-order-voucher"><?php echo $entry_voucher; ?><span class="help"><?php echo $help_autocomplite; ?></span></div>
									<input type="text" name="voucher_code" value="<?php echo $voucher_code; ?>" />
									<a tabindex="0" class="btn btn-primary btn-xs btn-popover" role="button" data-toggle="popover" data-placement="left" title="<?php echo $help_voucher_head; ?>" data-content="<?php echo $help_voucher; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
									<a tabindex="0" class="btn btn-danger btn-xs btn-popover" role="button" data-toggle="popover" data-placement="left" title="" data-content="<?php echo $help_voucher_use; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
								</div>
							<?php } ?>
							</td>
							<td>
							<?php if ($order_id && ($show_affiliate || $affiliate)) { ?>
								<div id="order-affiliate" class="dops-block affiliate-block">
									<div class="paramname"><?php echo $entry_affiliate; ?><span class="help"><?php echo $help_autocomplite; ?></span></div>
									<div class="paramdata" id="commission">
										<input type="text" name="affiliate" value="<?php echo $affiliate; ?>" />
										<span class="commission-add" <?php if ($commission_total) { ?>style="display:none;"<?php } ?>>
											<a id="commission_add" title="" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></a>
											<a tabindex="0" class="btn btn-primary btn-xs btn-popover" role="button" data-toggle="popover" data-placement="left" title="<?php echo $help_commission_add_head; ?>" data-content="<?php echo $help_commission_add; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
										</span>
										<span class="commission-remove" <?php if (!$commission_total) { ?>style="display:none;"<?php } ?>>
											<a id="commission_remove" title="" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></a>
											<a tabindex="0" class="btn btn-primary btn-xs btn-popover" role="button" data-toggle="popover" data-placement="left" title="<?php echo $help_commission_remove_head; ?>" data-content="<?php echo $help_commission_remove; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
										</span>
										<span class="commission-value"><?php echo $commission_order; ?></span>
										<input type="hidden" name="affiliate_id" value="<?php echo $affiliate_id; ?>" />
										<input type="hidden" name="commission" value="<?php echo $commission; ?>" />
									</div>
								</div>
							<?php } ?>
							</td>
						</tr>
					</tbody>
				</table>
				<?php } ?>
					
				<table class="list form payment_shipping" id="payment_shipping">
					<tbody>
						<tr>
							<td class="left payment-td">
							  <div class="paramblock">
								  <div class="paramname"><?php echo $entry_payment; ?></div>
								  <div class="paramdata">
									  <select class="payment" name="payments">
										<option value=""><?php echo $text_select; ?></option>
										<?php if ($payment_code) { ?>
											<option value="<?php echo $payment_code; ?>" selected="selected"><?php echo $payment_method; ?></option>
										<?php } ?>
									  </select>
									  <input type="hidden" name="payment_method" value="<?php echo $payment_method; ?>" />
									  <input type="hidden" name="payment_code" value="<?php echo $payment_code; ?>" />
									  <?php if ($error_payment_method) { ?><span class="error"><?php echo $error_payment_method; ?></span><?php } ?>
								  </div>
							  </div>
							  <div class="paramblock">
								<div class="paramname"><?php echo $entry_now_payment; ?></div>
								<div class="paramdata"><div id="now_payment_method"><?php echo $payment_method; ?></div></div>
							  </div>
							</td>
							<td class="center getmethod-td">
								<div class="tbutton">
									<a onclick="getMethods();" class="btn btn-primary btn-sm"><span><?php echo $button_getmethods; ?></span></a>
									<a tabindex="0" class="btn btn-primary btn-sm btn-popover" role="button" data-toggle="popover" title="<?php echo $help_getmethods_head; ?>" data-content="<?php echo $help_getmethods; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
								</div>
							</td>
							<td class="left shipping-td">
							  <div class="paramblock">
								  <div class="paramname"><?php echo $entry_shipping; ?></div>
								  <div class="paramdata">
									  <select class="shipping" name="shippings">
											<option value=""><?php echo $text_select; ?></option>
											<?php if ($shipping_code) { ?>
												<option value="<?php echo $shipping_code; ?>" selected="selected"><?php echo $shipping_method; ?></option>
											<?php } ?>
									  </select>
									  <input type="hidden" name="shipping_method" value="<?php echo $shipping_method; ?>" />
									  <input type="hidden" name="shipping_code" value="<?php echo $shipping_code; ?>" />
									  <?php if ($error_shipping_method) { ?><span class="error"><?php echo $error_shipping_method; ?></span><?php } ?>
								  </div>
							  </div>
							  <div class="paramblock">
								<div class="paramname"><?php echo $entry_now_shipping; ?></div>
								<div class="paramdata"><div id="now_shipping_method"><?php echo $shipping_method; ?></div></div>
							  </div>
							</td>
						</tr>
					</tbody>
				</table>
					
				<table class="list order-total" id="total">
					<thead>
						<tr>
							<td class="center"><?php echo $column_desc; ?></td>
							<td class="center"><?php echo $column_cost; ?></td>
							<td class="center"><?php echo $column_total; ?></td>
							<td class="center"><?php echo $column_nocalc; ?>
								<a tabindex="0" class="btn btn-primary btn-xs btn-popover" role="button" data-toggle="popover" data-placement="left" title="<?php echo $help_nocalc_head; ?>" data-content="<?php echo $help_nocalc; ?>" style="margin-left:3px;"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
							</td>
							<td class="center"><?php echo $column_sort; ?></td>
							<td></td>
						</tr>
					</thead>
					<?php $total_row = 0; ?>
					<?php foreach ($order_totals as $order_total) { ?>
					<tbody id="total-row<?php echo $total_row; ?>">
					<?php if (count($tax_class_id = explode(',', $order_total['code'])) > 1) { $correct = true; $order_total['code'] = 'correct'; echo '<input type="hidden" value="' . $tax_class_id[1] . '" name="order_total[' . $total_row . '][tax_class_id]">'; } ?>

					<?php if ($order_total['code'] == 'discount') {$discount_status = true;} ?>
						<tr>
							<td class="center total-title">
								<input type="hidden" name="order_total[<?php echo $total_row; ?>][order_total_id]" value="<?php echo $order_total['order_total_id']; ?>" />
								<input type="hidden" name="order_total[<?php echo $total_row; ?>][code]" value="<?php echo $order_total['code']; ?>" />
								<input type="text" style="width: 98%;" name="order_total[<?php echo $total_row; ?>][title]" value="<?php echo $order_total['title']; ?>" />
							</td>
							<td class="right total-value">
								<input type="hidden" name="order_total[<?php echo $total_row; ?>][text]" value="<?php echo $order_total['text']; ?>" />
								<?php if ($order_total['code'] == 'sub_total' || $order_total['code'] == 'total') { ?>
									<input type="hidden" name="order_total[<?php echo $total_row; ?>][value]" value="<?php echo $order_total['value']; ?>" />
								<?php } else { ?>
									<input type="text" name="order_total[<?php echo $total_row; ?>][value]" value="<?php echo $order_total['value']; ?>" />
								<?php } ?>
							</td>
							<td class="right total-text"><?php echo $order_total['text']; ?></td>
							<td class="center total-nocalc">
								<?php if ($order_total['code'] == 'shipping') { ?>
									<input class="no_calc" type="checkbox" name="<?php echo $order_total['code']; ?>" value="0" checked="checked"/>
								<?php } else { ?>
									<input class="no_calc" type="checkbox" name="<?php echo $order_total['code']; ?>" value="0" />
								<?php } ?>
							</td>
							<td class="center total-sort">
								<?php if (($order_total['code'] == 'correct') || ($order_total['code'] == 'discount')) { ?>
									<input type="hidden" name="order_total[<?php echo $total_row; ?>][sort_order]" value="<?php echo $order_total['sort_order']; ?>" />
								<?php } else { ?>
									<input style="width:30px;text-align:center;" type="text" name="order_total[<?php echo $total_row; ?>][sort_order]" value="<?php echo $order_total['sort_order']; ?>" />
								<?php } ?>
							</td>
							<td class="right total-delete">
								<a onclick="$('#total-row<?php echo $total_row; ?>').remove();<?php if ($order_total['code'] == 'discount' || $order_total['code'] == 'correct') { echo '$(\'.' . $order_total['code'] . ' .tbutton\').css(\'display\',\'block\');'; } ?>" class="btn btn-danger btn-sm"><span><?php echo $button_remove; ?></span></a>
							</td>
						</tr>
					</tbody>
					<?php $total_row++; ?>
					<?php } ?>
					<tfoot>
						<tr><td class="left message" colspan="6"></td></tr>
						<tr class="actions-buttons">
							<td class="right"></td>
							<td class="correct right" colspan="2">
								<div class="tbutton"<?php if (isset($correct)) { ?> style="display:none"<?php } ?>>
									<a onclick="addCorrect();" class="btn btn-primary btn-sm"><span><?php echo $button_correct; ?></span></a>
									<a tabindex="0" class="btn btn-primary btn-sm btn-popover" role="button" data-toggle="popover" title="<?php echo $help_correct_head; ?>" data-content="<?php echo $help_correct; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
								</div>
							</td>
							<td class="discount right" colspan="2">
								<div class="tbutton"<?php if (isset($discount_status)) { ?> style="display:none"<?php } ?>>
									<a onclick="addDiscount();" class="btn btn-primary btn-sm"><span><?php echo $button_discount; ?></span></a>
									<a tabindex="0" class="btn btn-primary btn-sm btn-popover" role="button" data-toggle="popover" data-placement="left" title="<?php echo $help_discount_head; ?>" data-content="<?php echo $help_discount; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
								</div>
							</td>
							<td class="right">
								<div class="tbutton">
								<?php if (!$status_del_warning) { ?>
									<a id="recalc-button" onclick="recalculate();" class="btn btn-success btn-sm"><span><?php echo $button_recalculate; ?></span></a>
									<a tabindex="0" class="btn btn-success btn-sm btn-popover" role="button" data-toggle="popover" data-placement="left" title="<?php echo $help_recalculate_head; ?>" data-content="<?php echo $help_recalculate; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
								<?php } else { ?>
									<a id="recalc-button" class="btn btn-default btn-sm"><span><?php echo $button_recalculate; ?></span></a>
									<a tabindex="0" class="btn btn-danger btn-sm btn-popover" role="button" data-toggle="popover" data-placement="left" title="<?php echo $help_recalculate_head; ?>" data-content="<?php echo $help_recalculate_bad; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
								<?php } ?>
								</div>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			
			<?php if ($orderpro_notabs_mode) { ?>
			</div>
			<?php } ?>
		
		</div>
		</form>
	</div>
	
	</div>
	</div>
<?php if ($show_model || $show_sku || $show_upc || $show_ean || $show_jan || $show_isbn || $show_mpn || $show_location || $show_image) { ?>
<style>@media (max-width:1199px) {td.column-product{width:400px;}}</style>
<?php } ?>
<div id="similar_block"></div>
<div id="shoverlay"><img src="view/image/orderpro/load-line.gif" alt="" /></div>
<script type="text/javascript"><!--
$('#product').delegate('.product-popap', 'click', function() {
	var imgsrc = $(this).attr('data-popap');
	$.colorbox({
		maxWidth: "85%",
		maxHeight: "85%",
		href: imgsrc
	});
});
$('input[name=\'firstname\']').blur(function() {
	var firstname = $('input[name=\'firstname\']').val();
	var shipping_firstname = $('input[name=\'shipping_firstname\']').val();
	$('input[name=\'payment_firstname\']').val(firstname);
	if ((shipping_firstname.length < 1) || (shipping_firstname == '<?php echo $text_noname; ?>')) {
	   $('input[name=\'shipping_firstname\']').val(firstname);
	}
});
$('input[name=\'lastname\']').blur(function() {
	var lastname = $('input[name=\'lastname\']').val();
	var shipping_lastname = $('input[name=\'shipping_lastname\']').val();
	$('input[name=\'payment_lastname\']').val(lastname);
	if (shipping_lastname.length < 1) {
	   $('input[name=\'shipping_lastname\']').val(lastname);
	}
});
$('input[name=\'payment_company\']').blur(function() {
	var payment_company = $('input[name=\'payment_company\']').val();
	$('input[name=\'shipping_company\']').val(payment_company);
});
$('input[name=\'shipping_address_1\']').blur(function() {
	var shipping_address_1 = $('input[name=\'shipping_address_1\']').val();
	$('input[name=\'payment_address_1\']').val(shipping_address_1);
});
$('input[name=\'shipping_address_2\']').blur(function() {
	var shipping_address_2 = $('input[name=\'shipping_address_2\']').val();
	$('input[name=\'payment_address_2\']').val(shipping_address_2);
});
$('input[name=\'shipping_city\']').blur(function() {
	var shipping_city = $('input[name=\'shipping_city\']').val();
	$('input[name=\'payment_city\']').val(shipping_city);
});
$('input[name=\'shipping_postcode\']').blur(function() {
	var shipping_postcode = $('input[name=\'shipping_postcode\']').val();
	$('input[name=\'payment_postcode\']').val(shipping_postcode);
});

$('#button-registered').on('click', function() {
	$.ajax({
		url: 'index.php?route=sale/orderpro/createCustomer&token=<?php echo $token; ?>',
		type: 'post',
		data: $('#tab-payment :input, #tab-order :input'),
		dataType: 'json',
		success: function(json) {
			$('#notifications').html('');
			var html = '';
			if (json['error_warning']) {
					html += '';
					$.each(json['error_warning'], function(key, item) {
						html += '<div class="warning">' + item + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>';
					});
					$('#notifications').html(html);
			}
			if (json['success']) {
					html += '<div class="success">' + json['success'] + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>';
					$('#notifications').html(html);
					$('#button-registered').removeClass('btn-primary').addClass('btn-default').removeAttr('id');
					$('input[name=\'customer_id\']').val(json['customer_id']);
					setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 4000);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

var shipping_zone_id = '<?php echo $shipping_zone_id; ?>';

$('select[name=\'shipping_zone_id\']').on('change', function() {
	$('input[name=\'payment_zone_id\']').val(this.value);
});

$('select[name=\'shipping_country_id\']').on('change', function() {
	$('input[name=\'payment_country_id\']').val(this.value);
	$.ajax({
		url: 'index.php?route=sale/orderpro/country&token=<?php echo $token; ?>&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'shipping_country_id\']').after('<span class="wait">&nbsp;<img src="view/image/orderpro/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {}
			
			html = '<option value=""><?php echo $text_select; ?></option>';
			
			if (json != '' && json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';
	    			
					if (json['zone'][i]['zone_id'] == shipping_zone_id) {
	      				html += ' selected="selected"';
	    			}
	
	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			
			$('select[name=\'shipping_zone_id\']').html(html);
			$('select[name=\'shipping_zone_id\']').trigger('change');
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'shipping_country_id\']').trigger('change');

$('select[name=\'shipping_address\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=sale/orderpro/customerAddress&token=<?php echo $token; ?>&address_id=' + this.value,
		dataType: 'json',
		success: function(json) {
			if (json != '') {
				$('input[name=\'shipping_firstname\']').val(json['firstname']);
				$('input[name=\'shipping_lastname\']').val(json['lastname']);
				$('input[name=\'shipping_company\']').val(json['company']);
				$('input[name=\'shipping_address_1\']').val(json['address_1']);
				$('input[name=\'shipping_address_2\']').val(json['address_2']);
				$('input[name=\'shipping_city\']').val(json['city']);
				$('input[name=\'shipping_postcode\']').val(json['postcode']);
				$('select[name=\'shipping_country_id\']').val(json['country_id']);
				
				shipping_zone_id = json['zone_id'];
				
				$('select[name=\'shipping_country_id\']').trigger('change');

				$('input[name=\'payment_firstname\']').val(json['firstname']);
				$('input[name=\'payment_lastname\']').val(json['lastname']);
				$('input[name=\'payment_company\']').val(json['company']);
				$('input[name=\'payment_address_1\']').val(json['address_1']);
				$('input[name=\'payment_address_2\']').val(json['address_2']);
				$('input[name=\'payment_city\']').val(json['city']);
				$('input[name=\'payment_postcode\']').val(json['postcode']);
				$('input[name=\'payment_country_id\']').val(json['country_id']);
				$('input[name=\'payment_zone_id\']').val(json['zone_id']);
				
				for (i in json['custom_field']) {
					$('#csfield-shipping select[name=\'shipping_custom_field[' + i + ']\']').val(json['custom_field'][i]);
					$('#csfield-shipping textarea[name=\'shipping_custom_field[' + i + ']\']').val(json['custom_field'][i]);
					$('#csfield-shipping input[name^=\'shipping_custom_field[' + i + ']\'][type=\'text\']').val(json['custom_field'][i]);
					if (json['custom_field'][i] != '') {
						$('#csfield-shipping a#file-link-' + i).empty().attr('href', 'index.php?route=sale/orderpro/download&token=<?php echo $token; ?>&code=' + json['custom_field'][i]).append('Скачать файл').show('fast');
					}
					$('#csfield-shipping input[name^=\'shipping_custom_field[' + i + ']\'][type=\'hidden\']').val(json['custom_field'][i]);
					$('#csfield-shipping input[name^=\'shipping_custom_field[' + i + ']\'][type=\'radio\'][value=\'' + json['custom_field'][i] + '\']').prop('checked', true);
					$('#csfield-shipping input[name^=\'shipping_custom_field[' + i + ']\'][type=\'checkbox\'][value=\'' + json['custom_field'][i] + '\']').prop('checked', true);

					if (json['custom_field'][i] instanceof Array) {
						for (j = 0; j < json['custom_field'][i].length; j++) {
							$('#csfield-shipping input[name^=\'shipping_custom_field[' + i + ']\'][type=\'checkbox\'][value=\'' + json['custom_field'][i][j] + '\']').prop('checked', true);
						}
					}
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'coupon_code\']').autocomplete({
	delay: 500,
	'source': function(request, response) {
		if(request.length >= 1) {
		$.ajax({
			url: 'index.php?route=sale/orderpro/couponAutocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['code']
					}
				}));
			}
		});
		}
	}, 
	'select': function(item) {
		$(this).val(item['value']);
	}
});

$('input[name=\'voucher_code\']').autocomplete({
	delay: 500,
	'source': function(request, response) {
		if(request.length >= 1) {
		$.ajax({
			url: 'index.php?route=sale/orderpro/voucherAutocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['code']
					}
				}));
			}
		});
		}
	},
	'select': function(item) {
		$(this).val(item['value']);
	}
});

$('input[name=\'customer\']').autocomplete({
	delay: 500,
	'source': function(request, response) {
		if(request.length >= 1) {
			$.ajax({
				url: 'index.php?route=sale/orderpro/customerAutocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
				dataType: 'json',
				success: function(json) {
					response($.map(json, function(item) {
					return {
						category: item['customer_group'],
						label: item['name'],
						value: item['customer_id'],
						customer_group_id: item['customer_group_id'],
						firstname: item['firstname'],
						lastname: item['lastname'],
						email: item['email'],
						telephone: item['telephone'],
						fax: item['fax'],
						virtual_customer_id: item['virtual_customer_id'],
						custom_field: item['custom_field'],
						address: item['address']
						}
					}));
				}
			});
		}
	},
	'select': function(item) {
		$('input[name=\'customer\']').val(item['label']);
		$('input[name=\'customer_id\']').val(item['value']);
		$('input[name=\'firstname\']').val(item['firstname']);
		$('input[name=\'lastname\']').val(item['lastname']);
		$('input[name=\'email\']').val(item['email']);
		$('input[name=\'telephone\']').val(item['telephone']);
		$('input[name=\'fax\']').val(item['fax']);
		$('input[name=\'virtual_customer_id\']').val(item['virtual_customer_id']);
		
		for (i in item.custom_field) {
			$('#csfield-account select[name=\'custom_field[' + i + ']\']').val(item.custom_field[i]);
			$('#csfield-account textarea[name=\'custom_field[' + i + ']\']').val(item.custom_field[i]);
			$('#csfield-account input[name^=\'custom_field[' + i + ']\'][type=\'text\']').val(item.custom_field[i]);
			if (item.custom_field[i] != '') {
				$('#csfield-account a#file-link-' + i).empty().attr('href', 'index.php?route=sale/orderpro/download&token=<?php echo $token; ?>&code=' + item.custom_field[i]).append('Скачать файл').show('fast');
			}
			$('#csfield-account input[name^=\'custom_field[' + i + ']\'][type=\'hidden\']').val(item.custom_field[i]);
			$('#csfield-account input[name^=\'custom_field[' + i + ']\'][type=\'radio\'][value=\'' + item.custom_field[i] + '\']').prop('checked', true);

			if (item.custom_field[i] instanceof Array) {
				for (j = 0; j < item.custom_field[i].length; j++) {
					$('#csfield-account input[name^=\'custom_field[' + i + ']\'][type=\'checkbox\'][value=\'' + item.custom_field[i][j] + '\']').prop('checked', true);
				}
			}
		}
			
		html = '<option value="0"><?php echo $text_none; ?></option>'; 
			
		for (i in  item['address']) {
			html += '<option value="' + item['address'][i]['address_id'] + '">' + item['address'][i]['firstname'] + ' ' + item['address'][i]['lastname'] + ', ' + item['address'][i]['address_1'] + ', ' + item['address'][i]['city'] + ', ' + item['address'][i]['zone'] + '</option>';
		}
		
		$('select[name=\'shipping_address\']').html(html);
		
		$('input[name=\'customer_group_id\']').val(item['customer_group_id']);
		controlReward();
	}
});

$('input[name=\'affiliate\']').autocomplete({
	delay: 500,
	'source': function(request, response) {
		if(request.length >= 1) {
		$.ajax({
			url: 'index.php?route=marketing/affiliate/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['affiliate_id']
					}
				}));
			}
		});
		}
	},
	'select': function(item) {
		$('input[name=\'affiliate\']').val(item['label']);
		$('input[name=\'affiliate_id\']').val(item['value']);
	}
});
//--></script>
<script type="text/javascript"><!--
var product_row = <?php echo $product_row; ?>;

function addProduct(){
	html='<tbody id="product-row'+product_row+'">';
	html+=' <tr class="product-line">';
	html+='  <td class="center"<?php echo $hide_pid; ?>><input type="text" name="order_product['+product_row+'][product_id]" value="" /></td>';
	html+='  <td class="center"<?php echo $hide_image; ?>><div class="product-image" id="image_'+product_row+'"></div></td>';
	html+='  <td class="center"><input type="text" name="order_product['+product_row+'][name]" value="" class="input-name" /><input type="hidden" name="order_product['+product_row+'][order_product_id]" value="" /><input type="hidden" name="order_product['+product_row+'][tax]" value="" /><input type="hidden" name="order_product['+product_row+'][status]" value="" /><div id="product_options'+product_row+'"></div></td>';
	html+='  <td class="center"<?php echo $hide_model; ?>><input type="text" name="order_product['+product_row+'][model]" value="" class="input-model" /></td>';
	html+='  <td class="center"<?php echo $hide_sku; ?>><input type="text" name="order_product['+product_row+'][sku]" value="" class="input-sku" /></td>';
	html+='  <td class="center"<?php echo $hide_upc; ?>><input type="text" name="order_product['+product_row+'][upc]" value="" class="input-upc" /></td>';
	html+='  <td class="center"<?php echo $hide_ean; ?>><input type="text" name="order_product['+product_row+'][ean]" value="" class="input-ean" /></td>';
	html+='  <td class="center"<?php echo $hide_jan; ?>><input type="text" name="order_product['+product_row+'][jan]" value="" class="input-jan" /></td>';
	html+='  <td class="center"<?php echo $hide_isbn; ?>><input type="text" name="order_product['+product_row+'][isbn]" value="" class="input-isbn" /></td>';
	html+='  <td class="center"<?php echo $hide_mpn; ?>><input type="text" name="order_product['+product_row+'][mpn]" value="" class="input-mpn" /></td>';
	html+='  <td class="center"<?php echo $hide_location; ?>><input type="text" name="order_product['+product_row+'][location]" value="" class="input-location" /></td>';
	html+='  <td class="right product-weight"<?php echo $hide_weight; ?>><input type="text" name="order_product['+product_row+'][weight]" value="" class="onlyread" readonly /></td>';
	html+='  <td class="center product-quantity"><input type="text" name="order_product['+product_row+'][quantity]" value="1" /></td>';
	html+='  <td class="center"><span id="realquantity_'+product_row+'"></span></td>';
	html+='  <td class="right product-price"><input type="text" name="order_product['+product_row+'][price]" value="" class="input-price" /><img src="view/image/orderpro/close14.png" class="price-empty" alt="" /></td>';
	html+='  <td class="right now_price"><span id="now_price_'+product_row+'"></span><span id="now_special_'+product_row+'" style="color:red;"></span><span id="now_discount_'+product_row+'" style="color:blue;"></span></td>';
	html+='  <td class="right product-total"><input type="text" name="order_product['+product_row+'][total]" value="" class="onlyread" readonly /></td>';
	html+='  <td class="right product-discount" nowrap><input type="text" name="order_product['+product_row+'][discount_amount]" value="" class="input-amount" /> ';
	html+='   <select name="order_product['+product_row+'][discount_type]">';
	html+='    <option value="P" selected="selected">%</option>';
	html+='    <option value="S">S</option>';
	html+='   </select><img src="view/image/orderpro/close14.png" class="amount-empty" alt="" /></td>';
	html+='  <td class="right product-reward"<?php echo $hide_reward; ?>><input type="text" id="reward_'+product_row+'" name="order_product['+product_row+'][reward]" value="" class="onlyread" readonly /></td>';
	html+='  <td class="center premove"><a onclick="$(\'#product-row'+product_row+'\').remove();" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></a></td>';
	html+=' </tr>';
	html+='</tbody>';
	
	$("#product tfoot").before(html);
	
	product_autocomplete(product_row);
	product_row++;
}

function product_autocomplete(product_row) {
	var reqname = '<?php echo $orderpro_autocomplete_type; ?>';
	var cr_group_id = $('input[name=\'customer_group_id\']').val();
	$('input[name=\'order_product[' + product_row + '][product_id]\'], input[name=\'order_product[' + product_row + '][name]\'], input[name=\'order_product[' + product_row + '][model]\'], input[name=\'order_product[' + product_row + '][sku]\'], input[name=\'order_product[' + product_row + '][upc]\'], input[name=\'order_product[' + 
	product_row + '][ean]\'], input[name=\'order_product[' + product_row + '][jan]\'], input[name=\'order_product[' + product_row + '][isbn]\'], input[name=\'order_product[' + product_row + '][mpn]\'], input[name=\'order_product[' + product_row + '][location]\']').autocomplete({
		delay: 500,
		'source': function(request, response) {
			var requested = $(this).attr('class');
			$.ajax({
				url: 'index.php?route=sale/orderpro/productAutocomplete&token=<?php echo $token; ?>',
				dataType: 'json',
                data: {
					filter_pid: $('input[name=\'order_product[' + product_row + '][product_id]\']').val(),
                    filter_name: $('input[name=\'order_product[' + product_row + '][name]\']').val(),
                    filter_model: $('input[name=\'order_product[' + product_row + '][model]\']').val(),
					filter_sku: $('input[name=\'order_product[' + product_row + '][sku]\']').val(),
					filter_upc: $('input[name=\'order_product[' + product_row + '][upc]\']').val(),
					filter_ean: $('input[name=\'order_product[' + product_row + '][ean]\']').val(),
					filter_jan: $('input[name=\'order_product[' + product_row + '][jan]\']').val(),
					filter_isbn: $('input[name=\'order_product[' + product_row + '][isbn]\']').val(),
					filter_mpn: $('input[name=\'order_product[' + product_row + '][mpn]\']').val(),
					filter_location: $('input[name=\'order_product[' + product_row + '][location]\']').val()
                },
				success: function(data) {
					response($.map(data, function(item) {
						if(reqname){
							var requested_label = item['name'];
						} else {
							if(requested == 'input-model'){
								var requested_label = item['model'];
							} else if(requested == 'input-sku'){
								var requested_label = item['sku'];
							} else if(requested == 'input-upc'){
								var requested_label = item['upc'];
							} else if(requested == 'input-ean'){
								var requested_label = item['ean'];
							} else if(requested == 'input-jan'){
								var requested_label = item['jan'];
							} else if(requested == 'input-isbn'){
								var requested_label = item['isbn'];
							} else if(requested == 'input-mpn'){
								var requested_label = item['mpn'];
							} else if(requested == 'input-location'){
								var requested_label = item['location'];
							} else {
								var requested_label = item['name'];
							}
						}
						return {
							label: requested_label,
                            name: item['name'],
							value: item['product_id'],
							model: item['model'],
							sku: item['sku'],
							upc: item['upc'],
							ean: item['ean'],
							jan: item['jan'],
							isbn: item['isbn'],
							mpn: item['mpn'],
							location: item['location']
						}
					}));
				}
			});
		},
		'complete': function() {},
		'select': function(item) {
			$.ajax({
				url: 'index.php?route=sale/orderpro/getToProduct&product_id=' + item['value'] + '&customer_group_id=' + cr_group_id + '&token=<?php echo $token; ?>',
				dataType: 'json',
				success: function(json) {
				if (json != '') {
					$('input[name=\'order_product[' + product_row + '][product_id]\']').val(json.product_id).attr('readonly', 'readonly');
					$('input[name=\'order_product[' + product_row + '][name]\']').val(json.name);
					$('input[name=\'order_product[' + product_row + '][model]\']').val(json.model);
					$('input[name=\'order_product[' + product_row + '][sku]\']').val(json.sku);
					$('input[name=\'order_product[' + product_row + '][upc]\']').val(json.upc);
					$('input[name=\'order_product[' + product_row + '][ean]\']').val(json.ean);
					$('input[name=\'order_product[' + product_row + '][jan]\']').val(json.jan);
					$('input[name=\'order_product[' + product_row + '][isbn]\']').val(json.isbn);
					$('input[name=\'order_product[' + product_row + '][mpn]\']').val(json.mpn);
					$('input[name=\'order_product[' + product_row + '][location]\']').val(json.location);
					$('input[name=\'order_product[' + product_row + '][weight]\']').val(json.weight);
					$('#now_price_' + product_row).html(parseFloat(json.price).toFixed(2));
					$('#now_special_' + product_row).html(parseFloat(json.special).toFixed(2));
					$('#now_discount_' + product_row).html(json.discount_qty + '/' + parseFloat(json.discount).toFixed(2));
					$('#realquantity_' + product_row).html(json.quantity);
					$('#image_' + product_row).html('<a href="'+ json.href +'" target="_blank"><img src="'+ json.image +'" alt="'+ json.name +'"></a>');
					if (json.popap) {
						$('#image_' + product_row).append('<span id="popap_'+ product_row +'"></span>');
						$('#popap_' + product_row).addClass('product-popap').attr('data-popap', json.popap);
					}
					$('input[name=\'order_product[' + product_row + '][reward]\']').val(json.reward);
					$('input[name=\'order_product[' + product_row + '][status]\']').val(json.status);

					if (json.option != '') {
						html = '<div class="poptions">';
			
						for (i = 0; i < json.option.length; i++) {
							option = json.option[i];
							
							if (option['type'] == 'select' || option['type'] == 'radio' || option['type'] == 'image') {
								html += '<div class="option">';
								
								if (option['required'] == '1') {
									html += '<span class="required">*</span>';
								}
							
								html += option['name'] + '<br />';
								html += '<select name="order_product[' + product_row + '][option][' + option['product_option_id'] + ']">';
							
								if (option['required'] == '0') {
									html += '<option value=""><?php echo $text_select; ?></option>';
								}

								for (j = 0; j < option['product_option_value'].length; j++) {
									option_value = option['product_option_value'][j];
									
									html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];
									
									if (option_value['price']) {
										html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
									}
									
									html += '</option>';
								}
									
								html += '</select>';
								html += '</div>';
								html += '<br />';
							}

							if (option['type'] == 'checkbox') {
								html += '<div>';
								
								if (option['required'] == '1') {
									html += '<span class="required">*</span>';
								}
								
								html += option['name'] + '<br />';
								
								for (j = 0; j < option['product_option_value'].length; j++) {
									option_value = option['product_option_value'][j];
									
									html += '<input type="checkbox" name="order_product[' + product_row + '][option][' + option['product_option_id'] + '][]" value="' + option_value['product_option_value_id'] + '" id="option-value-' + product_row + '-' + option_value['product_option_value_id'] + '" />';
									html += '<label for="option-value-' + product_row + '-' + option_value['product_option_value_id'] + '">' + option_value['name'];
									
									if (option_value['price']) {
										html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
									}
									
									html += '</label>';
									html += '<br />';
								}
								
								html += '</div>';
								html += '<br />';
							}

							if (option['type'] == 'text') {
								html += '<div>';
								
								if (option['required'] == '1') {
									html += '<span class="required">*</span>';
								}
								
								html += option['name'] + '<br />';
								html += '<input type="text" name="order_product[' + product_row + '][option][' + option['product_option_id'] + ']" value="' + option['value'] + '" />';
								html += '</div>';
								html += '<br />';
							}
							
							if (option['type'] == 'textarea') {
								html += '<div>';
								
								if (option['required'] == '1') {
									html += '<span class="required">*</span>';
								}
								
								html += option['name'] + '<br />';
								html += '<textarea name="order_product[' + product_row + '][option][' + option['product_option_id'] + ']" cols="40" rows="5">' + option['value'] + '</textarea>';
								html += '</div>';
								html += '<br />';
							}
							
							if (option['type'] == 'file') {
								html += '<div class="upfile-block">';
								
								if (option['required'] == '1') {
									html += '<span class="required">*</span> ';
								}
								
								html += option['name'] + '<br />';
								
								html += '<a id="file-link-' + option['product_option_id'] + '-' + product_row + '" class="file-link" title="<?php echo $text_download; ?>"></a>';
								html += '<a id="button-upload-' + option['product_option_id'] + '-' + product_row + '" class="btn btn-primary btn-sm" title="<?php echo $text_upload; ?>"><i class="fa fa-upload"></i></a>';
								html += '<input type="hidden" name="order_product[' + product_row + '][option][' + option['product_option_id'] + ']" value="' + option['value'] + '" />';
								html += '</div>';
								html += '<br />';
							}

							if (option['type'] == 'date') {
								html += '<div>';
								
								if (option['required'] == '1') {
									html += '<span class="required">*</span>';
								}
								
								html += option['name'] + '<br />';
								html += '<div class="date"><input type="text" name="order_product[' + product_row + '][option][' + option['product_option_id'] + ']" value="' + option['value'] + '" data-date-format="YYYY-MM-DD" /><span class="input-group-btn"><a class="btn btn-default btn-sm"><i class="fa fa-calendar"></i></a></span></div>';
								html += '</div>';
								html += '<br />';
							}
							
							if (option['type'] == 'datetime') {
								html += '<div>';
								
								if (option['required'] == '1') {
									html += '<span class="required">*</span>';
								}
								
								html += option['name'] + '<br />';
								html += '<div class="datetime"><input type="text" name="order_product[' + product_row + '][option][' + option['product_option_id'] + ']" value="' + option['value'] + '" data-date-format="YYYY-MM-DD HH:mm" /><span class="input-group-btn"><a class="btn btn-default btn-sm"><i class="fa fa-calendar"></i></a></span></div>';
								html += '</div>';
								html += '<br />';
							}
							
							if (option['type'] == 'time') {
								html += '<div>';
								
								if (option['required'] == '1') {
									html += '<span class="required">*</span>';
								}
								
								html += option['name'] + '<br />';
								html += '<div class="time"><input type="text" name="order_product[' + product_row + '][option][' + option['product_option_id'] + ']" value="' + option['value'] + '" data-date-format="HH:mm" /><span class="input-group-btn"><a class="btn btn-default btn-sm"><i class="fa fa-calendar"></i></a></span></div>';
								html += '</div>';
								html += '<br />';
							}
						}
						
						html += '</div>';
						
						$('#product_options' + product_row).empty().append(html);

						$('.date').datetimepicker({
							pickTime: false
						});

						$('.datetime').datetimepicker({
							pickDate: true,
							pickTime: true
						});

						$('.time').datetimepicker({
							pickDate: false
						});
				
					} else {
						$('#product_options' + product_row).empty();
					}
					controlReward();
				}
				}
			});
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

$('#product tbody').each(function(index, element) {
	product_autocomplete(index);
});
//--></script>
<script type="text/javascript"><!--
var old_order_status_id = '<?php echo $order_status_id; ?>';
var order_id = '<?php echo $order_id; ?>';

$('select[id=\'order_status_id\']').on('change', function() {
	var new_order_status_id = this.value;
	
	if (old_order_status_id != new_order_status_id) {
		$.ajax({
			url: 'index.php?route=sale/orderpro/history&token=<?php echo $token; ?>&order_id=<?php echo (!empty($order_id)) ? $order_id : $temp_order_id; ?>',
			type: 'post',
			dataType: 'html',
			data: 'order_status_id=' + new_order_status_id + '&notify=0&comment=',
			beforeSend: function() {
				$('.success, .warning').remove();
			},
			complete: function() {
				$('.attention').remove();
			},
			success: function(html) {
				$('#history').html(html);
				$('textarea[name=\'admin_comment\']').val('');
				$('select[id=\'horder_status_id\']').val(new_order_status_id);
				$('#notifications').html('<div class="success"><?php echo $success_order_history; ?><img src="view/image/orderpro/close16.png" alt="" class="close" /></div>');
				setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 3000);
				old_order_status_id = new_order_status_id;
				controlReward();
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});

function recalculate() {
	$('.no_calc').each(function () {
		if (this.checked) {$(this).val('1');}
	});
	$('.alert, .success, .attention, .warning').remove();
	$("#shoverlay").show();
	$.ajax({
		url: '<?php echo $store_url; ?>index.php?route=checkout/recalculate&token=<?php echo $token; ?>&order_id=<?php echo (!empty($order_id)) ? $order_id : $temp_order_id; ?>',
		type: 'post',
		dataType: 'html',
		data: $('#tab-order :input, #tab-payment :input, #product :checked, #product input:hidden, #product input:text, .option :input, .product-discount :input, #order-reward :input, #order-dops :input, #payment_shipping :input, #total :input'),
		complete: function() {
			$('#shoverlay').hide();
		},
		success: function(json) {
			$('.autocomplete div').remove();
			var obj = jQuery.parseJSON(json);
			
			if (!obj.error) {
				var row = 0;
				var thead = $('#total thead').html();
				var tfoot = $('#total tfoot').html();
				var button_remove = '<?php echo $button_remove; ?>';
				html = '<thead>' + thead + '</thead>';

				$.each(obj.order_total, function(key, value) {
					html += '<tbody id="total-row' + row + '">';
					html += ' <tr>';
					html += '   <td class="center total-title">';
					html += '    <input type="hidden" value="0" name="order_total[' + row + '][order_total_id]">';
					html += '    <input type="hidden" value="' + value.code + '" name="order_total[' + row + '][code]">';
					html += '    <input type="text" value="' + value.title + '" name="order_total[' + row + '][title]" style="width:98%">';
					html += '   </td>';
					html += '   <td class="right total-value">';
					html += '    <input type="hidden" value="' + value.text + '" name="order_total[' + row + '][text]">';
					if ((value.code == 'sub_total') || (value.code == 'total')) {
						html += '    <input type="hidden" value="' + parseFloat(value.value).toFixed(2) + '" name="order_total[' + row + '][value]">';
					} else {
						html += '    <input type="text" value="' + parseFloat(value.value).toFixed(2) + '" name="order_total[' + row + '][value]">';
					}
					html += '   </td>';
					html += '   <td class="right total-text">' + value.text + '</td>';
					html += '   <td class="center total-nocalc">';
					if (value.code == 'shipping') {
						html += '    <input class="no_calc" type="checkbox" name="' + value.code + '" value="0" checked="checked" />';
					} else {
						html += '    <input class="no_calc" type="checkbox" name="' + value.code + '" value="0" />';
					}
					html += '   </td>';
					html += '   <td class="center total-sort">';
					if (value.correct) { value.code = 'correct'; }
					if ((value.code == 'discount') || (value.code == 'correct')) {
						html += '    <input type="hidden" value="' + value.sort_order + '" name="order_total[' + row + '][sort_order]">';
					} else {
						html += '    <input type="text" style="width:30px; text-align:center;" value="' + value.sort_order + '" name="order_total[' + row + '][sort_order]">';
					}
					html += '   </td>';
					html += '   <td class="right total-delete">';
					if ((value.code == 'discount') || (value.code == 'correct')) {
						html += '    <a class="btn btn-danger btn-sm" onclick="$(\'#total-row' + row + '\').remove();$(\'.' + value.code + ' .tbutton\').css(\'display\',\'block\');">' + button_remove + '</a>';
					} else {
						html += '    <a class="btn btn-danger btn-sm" onclick="$(\'#total-row' + row + '\').remove();">' + button_remove + '</a>';
					}
					html += '  </td>';
					html += ' </tr>';
					html += '</tbody>';

					row++;
				});

				html = html + '<tfoot>' + tfoot + '</tfoot>';
				$('#total').unbind().html(html);
				
				if (obj.commission) {
					$('input[name=\'commission\']').val(obj.commission.value);
					$('#commission span.commission-value').html(obj.commission.text);
				}

				$.each(obj.del_product_rows, function(key, prod_row) {
					$('#product-row' + prod_row).remove();
				});

				$.each(obj.order_product, function(prod_row, value) {
					if (value.discount) {
						var name_value = $('input[name=\'order_product[' + prod_row + '][name]\']');
						var name_explode = $(name_value).val().split(' |');
                        $(name_value).val(name_explode[0] + '<?php echo $text_discount; ?> ' + value.discount);
					} else {
						$('input[name=\'order_product[' + prod_row + '][name]\']').val(value.name);
					}
					
					$('input[name=\'order_product[' + prod_row + '][quantity]\']').val(value.quantity);
					$('input[name=\'order_product[' + prod_row + '][tax]\']').val(value.tax);
					$('input[name=\'order_product[' + prod_row + '][total]\']').val(value.total);
					$('input[name=\'order_product[' + prod_row + '][price]\']').val(value.price);
					$('input[name=\'order_product[' + prod_row + '][reward]\']').val(value.reward);
					$('input[name=\'order_product[' + prod_row + '][weight]\']').val(value.weight);
				});
				
				$('#weight_cart').val(obj.weight_cart);
				$('#items_cart').val(obj.items_cart);
				$('#total_cart').val(obj.total_cart);
				$('#discount_cart').val(obj.discount_cart);
				$('input[name=\'reward_cart\']').val(obj.reward_cart);
				$('#reward_cart').val(obj.reward_cart);

				if (obj.warning_reward) {
					$('#rewards-available span').html(obj.warning_reward);
				}
				
				if (obj.warning) {
					var html = '';
					$.each(obj.warning, function(key, value) {
						html += '<div class="attention">' + value + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>';
					});
					
					$('.message').append(html);
				}
				
				$('#total .btn-popover').popover({
					trigger: "hover"
				});

				if ($('input[name=\'customer_id\']').val() != ''){
					controlReward();
				}
				
			} else {
				var html = '';
				$.each(obj.error, function(key, value) {
					html += '<div class="warning">' + value + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>';
				});
			
				$('.message').append(html);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

function controlReward() {
    var customer_id = $('input[name=\'customer_id\']').val();
    var customer_group_id = $('input[name=\'customer_group_id\']').val();
    $.ajax({
        url: '<?php echo $store_url; ?>index.php?route=checkout/recalculate/controlReward&token=<?php echo $token; ?>&order_id=<?php echo (!empty($order_id)) ? $order_id : $temp_order_id; ?>&customer_id=' + encodeURIComponent(customer_id) + '&customer_group_id=' + encodeURIComponent(customer_group_id),
        type: 'post',
        dataType: 'json',
        data: $('#product :checked, #product input:hidden, #product input:text, .option :input'),
        success: function(json) {
			if (json.error) {
				$('#notifications').html('<div class="warning">' + json.error + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>');
			} else {
				var reward_use = Number($('input[name=\'reward_use\']').val());

				if (reward_use <= json.reward_possibly) {
					$('#rewards-available span').html('<?php echo $entry_reward_max; ?>' + json.reward_possibly);
				} else {
					$('#rewards-available span').html('<span style="color:red;"><?php echo $entry_reward_max; ?>' + json.reward_possibly + '</span>');
					$('input[name=\'reward_use\']').val(json.reward_possibly);
				}
				
				$('#reward-total span.rtotal').html(json.reward_total);
				$('#reward-total span.ptotal').html(json.reward_possibly);
				$('#reward-recived span').html(json.reward_recived);
				$('input[name=\'reward_cart\']').val(json.reward_cart);
			}
        }
	});
}

$('input[name=\'reward_use\']').blur(function () {
    controlReward();
});

function getMethods() {
	$.ajax({
		url: '<?php echo $store_url; ?>index.php?route=checkout/recalculate/getMethods&token=<?php echo $token; ?>',
		type: 'post',
		data: $('#tab-order :input, #tab-payment :input, #product :checked, #product input:hidden, #product input:text, .option :input, .product-discount :input, #order-reward :input, #order-dops :input, #payment_shipping :input, #total :input'),
		dataType: 'json',	
		beforeSend: function() {
			$('select[name=\'shippings\'], select[name=\'payments\']').css('opacity', '0.5').after('<span class="wait">&nbsp;<img src="view/image/orderpro/loading.gif" alt="" /></span>');
			$('.message').empty();
		},
		complete: function() {
			$('.wait').remove();
			$('select[name=\'shippings\'], select[name=\'payments\']').css('opacity', '1');
		},
		success: function(json) {
			if (json['error']) {
				var html = '';
				$.each(json['error'], function(key, value) {
					html += '<div class="warning">' + value + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>';
				});
				
				$('.message').append(html);
			}
			
			if (json['warning']) {
				var html = '';
				$.each(json['warning'], function(key, value) {
					html += '<div class="attention">' + value + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>';
				});
				
				$('.message').append(html);
			}
			
			if (json['shipping_method']) {
				html = '<option value=""><?php echo $text_select; ?></option>';

				for (i in json['shipping_method']) {
					html += '<optgroup label="' + json['shipping_method'][i]['title'] + '">';

					for (j in json['shipping_method'][i]['quote']) {
						if (json['shipping_method'][i]['quote'][j]['code'] == $('input[name=\'shipping_code\']').val()) {
							if (!json['shipping_method'][i]['error']) {
								html += '<option value="' + json['shipping_method'][i]['quote'][j]['code'] + '" selected="selected">' + json['shipping_method'][i]['quote'][j]['title'] + '</option>';
							} else {
								html += '<option style="color:#676;" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" selected="selected">' + json['shipping_method'][i]['quote'][j]['title'] + ' ' + json['shipping_method'][i]['error'] + '</option>';
							}
						} else {
							if (!json['shipping_method'][i]['error']) {
								html += '<option value="' + json['shipping_method'][i]['quote'][j]['code'] + '">' + json['shipping_method'][i]['quote'][j]['title'] + '</option>';
							} else {
								html += '<option style="color:#676;" value="' + json['shipping_method'][i]['quote'][j]['code'] + '">' + json['shipping_method'][i]['quote'][j]['title'] + ' ' + json['shipping_method'][i]['error'] + '</option>';
							}
						}
					}
					
					html += '</optgroup>';
				}
		
				$('select[name=\'shippings\']').html(html);
			}
			
			if (json['payment_method']) {
				html = '<option value=""><?php echo $text_select; ?></option>';
				
				for (i in json['payment_method']) {
					if (json['payment_method'][i]['code'] == $('input[name=\'payment_code\']').val()) {
						if (!json['payment_method'][i]['error']) {
							html += '<option value="' + json['payment_method'][i]['code'] + '" selected="selected">' + json['payment_method'][i]['title'] + '</option>';
						} else {
							html += '<option style="color:#676;" value="' + json['payment_method'][i]['code'] + '" selected="selected">' + json['payment_method'][i]['title'] + ' ' + json['payment_method'][i]['error'] + '</option>';
						}
					} else {
						if (!json['payment_method'][i]['error']) {
							html += '<option value="' + json['payment_method'][i]['code'] + '">' + json['payment_method'][i]['title'] + '</option>';
						} else {
							html += '<option style="color:#676;" value="' + json['payment_method'][i]['code'] + '">' + json['payment_method'][i]['title'] + ' ' + json['payment_method'][i]['error'] + '</option>';
						}
					}
				}
		
				$('select[name=\'payments\']').html(html);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

var regex2 = '<?php echo $error_method_available; ?>';

$('select[name=\'payments\']').on('change', function() {
	if (this.value) {
		$('input[name=\'payment_method\']').val($('select[name=\'payments\'] option:selected').text().replace(regex2, ''));
		$('#now_payment_method').empty().append($('select[name=\'payments\'] option:selected').text().replace(regex2, ''));
	} else {
		$('input[name=\'payment_method\']').val('');
		$('#now_payment_method').empty();
	}
	
	$('input[name=\'payment_code\']').val(this.value);
});

$('select[name=\'shippings\']').on('change', function() {
	if (this.value) {
		$('input[name=\'shipping_method\']').val($('select[name=\'shippings\'] option:selected').text().replace(regex2, ''));
		$('#now_shipping_method').empty().append($('select[name=\'shippings\'] option:selected').text().replace(regex2, ''));
	} else {
		$('input[name=\'shipping_method\']').val('');
		$('#now_shipping_method').empty();
	}
	
	$('input[name=\'shipping_code\']').val(this.value);
});

$(document).ready(function() {
	setTimeout (function() {controlReward();}, 500);
	setTimeout (function() {getMethods();}, 1000);
});
//--></script>
<script type="text/javascript"><!--
function addTotal(type, title) {
	var row = 0;
	var thead = $('#total thead').html();
	var tfoot = $('#total tfoot').html();
	html = '<thead>' + thead + '</thead>';
	
	$('#total tbody').each(function(index) {
		html += '<tbody id="total-row' + row + '">';
		html += $(this).html();
		html += '</tbody>';
		row++;
	});

	html += '<tbody id="total-row' + row + '">';
	html += ' <tr>';
	html += '  <td class="center total-title">';
	html += '    <input type="hidden" value="' + type + '" name="order_total[' + row + '][code]">';
	html += '    <input type="text" value="' + title + '" name="order_total[' + row + '][title]" style="width:98%;">';
	html += '    <input type="hidden" name="' + type + '" value="1" />';
	html += '  </td>';
	html += '  <td class="right total-value">';
	html += '    <input type="text" value="" name="order_total[' + row + '][value]">';
	html += '  </td>';
	html += '  <td class="right total-text">';
	html += '    <input type="hidden" value="" name="order_total[' + row + '][text]">';
	html += '  </td>';
	if (type == 'correct') {
		html += '  <td class="center" colspan="2">';
		html += '    <?php echo $entry_tax; ?><select name="order_total[' + row + '][tax_class_id]" class="select-correct">';
		html += '      <option value="0"><?php echo $text_none; ?></option>';
		<?php foreach ($tax_classes as $tax_class) { ?>
		html += '      <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>';
		<?php } ?>
		html += '    </select>';
		html += '  </td>';						
	} else {
		html += '  <td class="center total-nocalc">';
		html += '  </td>';
		html += '  <td class="center total-sort">';
		html += '    <input type="hidden" value="2" name="order_total[' + row + '][sort_order]">';
		html += '  </td>';
	}
	html += '  <td class="right total-delete">';
	html += '    <a class="btn btn-danger btn-sm" onclick="$(\'#total-row' + row + '\').remove();$(\'.' + type + ' .tbutton\').css(\'display\',\'block\');"><span><?php echo $button_remove; ?></span></a>';
	html += '  </td>';
	html += ' </tr>';
	html += '</tbody>';
	
	html = html + '<tfoot>' + tfoot + '</tfoot>';
	$('#total').unbind().html(html);
	
	$('#total .btn-popover').popover({
		trigger: "hover"
	});
	
	$('.' + type + ' .tbutton').css('display','none');
}

function addDiscount() {
    addTotal('discount', '<?php echo $entry_discount; ?>');
}

function addCorrect() {
    addTotal('correct', '<?php echo $entry_correct; ?>');
}

function clone_order() {
    $('#clone').val('1');
	$('#order_form').submit();
}

function apple_order() {
	$('#order_form').attr('action', $('#order_form').attr('action') + '&reopen=1');
	$('#order_form').submit();
}

<?php if ($customer_id && $reward_status) { ?>
$('#order-reward').delegate('#reward-add', 'click', function() {
	$('.success, .warning').remove();
	$("#shoverlay").show();
	$.ajax({
		url: 'index.php?route=sale/orderpro/addOrderReward&token=<?php echo $token; ?>&order_id=<?php echo (!empty($order_id)) ? $order_id : $temp_order_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $('#tab-order :input, #order-reward :input'),
		success: function(json) {
			$("#shoverlay").hide();
			if (json.error) {
				$('#notifications').html('<div class="warning">' + json.error + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>');
			}
			if (json.success) {
				$('#reward-recived span').html(json.reward_total);
				$('#notifications').html('<div class="success">' + json.success + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>');
				setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 3000);
				controlReward();
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#order-reward').delegate('#reward-remove', 'click', function() {
	$('.success, .warning').remove();
	$("#shoverlay").show();
	$.ajax({
		url: 'index.php?route=sale/orderpro/removeOrderReward&token=<?php echo $token; ?>&order_id=<?php echo (!empty($order_id)) ? $order_id : $temp_order_id; ?>',
		dataType: 'json',
		success: function(json) {
			$("#shoverlay").hide();
			if (json.error) {
				$('#notifications').html('<div class="warning">' + json.error + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>');
			}
			if (json.success) {
                $('#reward-recived span').html('0');
				$('#notifications').html('<div class="success">' + json.success + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>');
				setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 3000);
                controlReward();
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
<?php } ?>
<?php if ($order_id) { ?>
$('#order-affiliate').delegate('#commission_add', 'click', function() {
	$('.success, .warning').remove();
	$("#shoverlay").show();
	$.ajax({
		url: 'index.php?route=sale/orderpro/addCommission&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		dataType: 'json',
		success: function(json) {
			$("#shoverlay").hide();
			if (json.error) {
				$('#notifications').html('<div class="warning">' + json.error + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>');
			}
			if (json.success) {
				$('#notifications').html('<div class="success">' + json.success + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>');
				setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 3000);
				$('.commission-add').fadeOut();
				$('.commission-remove').fadeIn();
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#order-affiliate').delegate('#commission_remove', 'click', function() {
	$('.success, .warning').remove();
	$("#shoverlay").show();
	$.ajax({
		url: 'index.php?route=sale/orderpro/removeCommission&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		dataType: 'json',
		success: function(json) {
			$("#shoverlay").hide();
			if (json.error) {
				$('#notifications').html('<div class="warning">' + json.error + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>');
			}
			if (json.success) {
				$('#notifications').html('<div class="success">' + json.success + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>');
				setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 3000);
				$('.commission-remove').fadeOut();
				$('.commission-add').fadeIn();
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#history').load('index.php?route=sale/orderpro/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');

$('#history').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();
	$('#history').load(this.href);
});

$('#button-history').on('click', function() {
	var new_hstatus_order_id = $('select[id=\'horder_status_id\']').val();
	$.ajax({
		url: 'index.php?route=sale/orderpro/history&token=<?php echo $token; ?>&order_id=<?php echo (!empty($order_id)) ? $order_id : $temp_order_id; ?>',
		type: 'post',
		dataType: 'html',
		data: 'order_status_id=' + encodeURIComponent($('select[id=\'horder_status_id\']').val()) + '&notify=' + encodeURIComponent($('input[name=\'notify\']').prop('checked') ? 1 : 0) + '&notify_asnew=' + encodeURIComponent($('input[name=\'notify_asnew\']').prop('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'admin_comment\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-history').attr('disabled', true);
			$('#history').prepend('<div class="attention"><img src="view/image/orderpro/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-history').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(html) {
			$('#history').html(html);
			$('textarea[name=\'admin_comment\']').val('');
			$('select[id=\'order_status_id\']').val(new_hstatus_order_id);
			old_order_status_id = new_hstatus_order_id;
			controlReward();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
<?php } ?>
//--></script>
<script type="text/javascript"><!--
function decodeEntities(input) {
  var y = document.createElement('textarea');
  y.innerHTML = input;
  return y.value;
}

$('#content').delegate('a[id^=\'button-upload\'], a[id^=\'button-custom-field\'], a[id^=\'button-payment-custom-field\'], a[id^=\'button-shipping-custom-field\']', 'click', function() {
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
				url: 'index.php?route=sale/orderpro/upload&token=<?php echo $token; ?>',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('.success, .error, .warning').remove();
					$(node).children('.fa').addClass('fa-cog fa-spin');
				},
				complete: function() {
					$(node).children('.fa').removeClass('fa-cog fa-spin');
				},
				success: function(json) {
					$(node).parent().find('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input[type=\'hidden\']').after('<div class="text-danger">' + json['error'] + '</div>');
						$('#notifications').html('<div class="warning">' + json['error'] + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>');
					}

					if (json['success']) {
						$('#notifications').html('<div class="success">' + json['success'] + '<img src="view/image/orderpro/close16.png" alt="" class="close" /></div>');
						setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 3000);
						if (json['filename'] && json['href']) {
							$(node).parent().find('a[id^=\'file-link\']').empty().attr('href', decodeEntities(json['href'])).append(json['filename']).show('fast');
						}
						if (json['code']) {
							$(node).parent().find('input[type=\'hidden\']').val(json['code']);
						}
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});

function getsimilar(pole) {
	$('#similar_modal').remove();
	$('#similar_block').load('index.php?route=sale/orderpro/getsimilar&order_id=<?php echo $order_id; ?>&pole='+ pole +'&token=<?php echo $token; ?>', function() {
		$('#similar_modal').modal('show');
	});
}

$('#empty-prices').on('click', function() {
    $('.product-price input').val('');
});

$('#product').delegate('.price-empty', 'click', function() {
    $(this).parent().find('.input-price').val('');
});

$('#empty-discounts').on('click', function() {
    $('.product-discount input').val('');
});

$('#product').delegate('.amount-empty', 'click', function() {
    $(this).parent().find('.input-amount').val('');
});

$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

$('#content').delegate('.close', 'click', function() {
	$(this).parent().fadeOut('slow', function() {$(this).remove();});
});

$('.btn-popover').popover({
	trigger: "hover"
});
//--></script></div>
<?php echo $footer; ?>