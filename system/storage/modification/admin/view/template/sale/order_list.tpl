<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">

		<?php if ($aqe_enabled) { ?><label for="batch_edit" class="hidden" id="batch-edit-container"><input type="checkbox" id="batch-edit"<?php echo ($batch_edit) ? ' checked' : ''; ?>> <?php echo $text_batch_edit; ?></label><?php } ?>
			

	    <a id="button-merge" onclick="getmerge();" data-toggle="tooltip" title="Объединить заказы" class="btn btn-warning"><i class="fa fa-share-alt-square" aria-hidden="true"></i></a>
						
        <button type="submit" id="button-shipping" form="form-order" formaction="<?php echo $shipping; ?>" data-toggle="tooltip" title="<?php echo $button_shipping_print; ?>" class="btn btn-info"><i class="fa fa-truck"></i></button>
        <button type="submit" id="button-invoice" form="form-order" formaction="<?php echo $invoice; ?>" data-toggle="tooltip" title="<?php echo $button_invoice_print; ?>" class="btn btn-info"><i class="fa fa-print"></i></button>
        <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>

		<?php if ($aqe_enabled) { ?>
  <div class="alerts">
    <div class="container-fluid" id="alerts">
    </div>
  </div>
		<?php } ?>
			
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
 
		<div class="row">
			<div class="col-sm-1">
				<div class="form-group">
					<label class="control-label" for="input-order-id"><?php echo $entry_build_yes_no; ?></label>
					<select name="filter_build_price_yes_no" class="form-control">
						<option value=""></option>
						<option value="Y" <?php echo $filter_build_price_yes_no == 'Y' ? 'selected' : '' ; ?>><?php echo $text_yes; ?></option>
						<option value="N" <?php echo $filter_build_price_yes_no == 'N' ? 'selected' : ''?>><?php echo $text_no; ?></option>
					</select>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="form-group">
					<label class="control-label" for="input-order-id"><?php echo $entry_rise_yes_no; ?></label>
					<select name="filter_rise_product_yes_no" class="form-control">
						<option value=""></option>
						<option value="Y" <?php echo $filter_rise_product_yes_no == 'Y' ? 'selected' : '' ; ?>><?php echo $text_yes; ?></option>
						<option value="N" <?php echo $filter_rise_product_yes_no == 'N' ? 'selected' : ''?>><?php echo $text_no; ?></option>
					</select>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label class="control-label" for="input-total"><?php echo $entry_delivery_price; ?></label>
					<input type="text" name="filter_delivery_price" value="<?php echo $filter_delivery_price; ?>" placeholder="<?php echo $entry_delivery_price; ?>" id="input-total" class="form-control" />
				</div>
            </div>
			<div class="col-sm-2">
				<div class="form-group">
					<label class="control-label" for="input-total"><?php echo $entry_calculated_summ; ?></label>
					<input type="text" name="filter_calculated_summ" value="<?php echo $filter_calculated_summ; ?>" placeholder="<?php echo $entry_calculated_summ; ?>" id="input-total" class="form-control" />
				</div>
            </div>
			<div class="col-sm-2">
				<div class="form-group">
					<label class="control-label" for="input-order-id"><?php echo $entry_manager_process_orders; ?></label>
					<select name="filter_manager_process_orders" class="form-control">
						<option value=""></option>
						<?php foreach ($users as $manager){?>
							 <?php if ($manager['username'] == $filter_manager_process_orders) { ?>
								<option value="<?php echo $manager['username']?>" selected="selected"><?php echo $manager['username']?></option>
							<?php } else { ?>
								<option value="<?php echo $manager['username']?>"><?php echo $manager['username']?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label class="control-label" for="filter_date_added_start"><?php echo $entry_date_added_start; ?></label>
					<div class="input-group date">
						<input type="text" name="filter_date_added_start" value="<?php echo $filter_date_added_start; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
						<span class="input-group-btn">
						<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
						</span></div>
				</div>
            </div>
			<div class="col-sm-2">
				<div class="form-group">
					<label class="control-label" for="filter_date_added_end"><?php echo $entry_date_added_end; ?></label>
					<div class="input-group date">
						<input type="text" name="filter_date_added_end" value="<?php echo $filter_date_added_end; ?>" data-date-format="YYYY-MM-DD" id="filter_date_added_end" class="form-control" />
						<span class="input-group-btn">
						<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
						</span></div>
				</div>
            </div>
		</div>
		
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-order-id"><?php echo $entry_order_id; ?></label>
                <input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" placeholder="<?php echo $entry_order_id; ?>" id="input-order-id" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
                <select name="filter_order_status" id="input-order-status" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_order_status == '0') { ?>
                  <option value="0" selected="selected"><?php echo $text_missing; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_missing; ?></option>
                  <?php } ?>
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $filter_order_status) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-total"><?php echo $entry_total; ?></label>
                <input type="text" name="filter_total" value="<?php echo $filter_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-date-modified"><?php echo $entry_date_modified; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_modified" value="<?php echo $filter_date_modified; ?>" placeholder="<?php echo $entry_date_modified; ?>" data-date-format="YYYY-MM-DD" id="input-date-modified" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked).trigger('change');" /></td>
                  <td class="text-right"><?php if ($sort == 'o.order_id') { ?>
                    <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_order; ?>"><?php echo $column_order_id; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'customer') { ?>
                    <a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
                    <?php } ?></td>
 
		<?php if($on_off_column_product !='0') { ?><td><?php echo $text_column_products;?></td><?php } ?>
		<?php if($on_off_column_rise_product !='0') { ?><td><?php echo $text_column_rise_product;?></td><?php } ?>
		<?php if($on_off_column_build !='0') { ?><td><?php echo $text_column_build_price;?></td><?php } ?>
		<?php if($on_off_column_delivery_price !='0') { ?><td><?php echo $text_column_delivery_price;?></td><?php } ?>
		<?php if($on_off_column_price_purchase !='0') { ?><td><?php echo $text_column_price_purchase;?></td><?php } ?>	
		<?php if($on_off_column_total_profit !='0') { ?><td><?php echo $text_column_total_profit;?></td><?php } ?>
		<?php if($on_off_column_send_ttn_email !='0') { ?><td><?php echo $text_column_send_ttn_email;?></td><?php } ?>
		<?php if($on_off_column_comment_manager !='0') { ?><td><?php echo $text_column_comment_manager;?></td><?php } ?>		
		<?php if($on_off_column_manager_process_orders !='0') { ?><td><?php echo $text_column_manager_process_orders;?></td><?php } ?>
		
		
                  <td class="text-left"><?php if ($sort == 'status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php if ($sort == 'o.total') { ?>
                    <a href="<?php echo $sort_total; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_total; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_total; ?>"><?php echo $column_total; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'o.date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'o.date_modified') { ?>
                    <a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($orders) { ?>
                 
		<?php foreach ($orders as $order) { ?>
		<tr class="salerow" id="row_<?php echo $order['order_id']; ?>" style="color: <?php echo $order['row_color_text'] ? $order['row_color_text'] : '#666666'; ?> !important; background-color: <?php echo $order['row_color'] ? $order['row_color'] : '#F4F4F8'; ?> !important;">
		
                  <td class="text-center"><?php if (in_array($order['order_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" />
                    <?php } ?>
                    <input type="hidden" name="shipping_code[]" value="<?php echo $order['shipping_code']; ?>" /></td>
                  <td class="text-right"><?php echo $order['order_id']; ?></td>
                   
				<td class="text-left" style="min-width:210px;">
					<div><i class="fa fa-user fa-fw"></i> <?php echo $order['customer']; ?></div>
					<?php if($order['shipping_city']) { ?><div><i class="fa fa-globe fa-fw"></i> <?php echo $order['shipping_city']; ?></div><?php } ?>
					<?php if($order['shipping_address_1']) { ?><div><i class="fa fa-home fa-fw"></i> <?php echo $order['shipping_address_1']; ?></div><?php } ?>
					<?php if($order['telephone']) { ?><div><i class="fa fa-phone fa-fw"></i> <?php echo $order['telephone']; ?></div><?php } ?>
					<?php if($order['email']) { ?><div><i class="fa fa-envelope-o fa-fw"></i> <?php echo $order['email']; ?>	</div><?php } ?>
					<?php if($on_off_order_payment_method !='0') { ?><?php if($order['payment_method']) { ?><div><i class="fa fa-credit-card fa-fw"></i> <?php echo $order['payment_method']; ?></div><?php } ?><?php } ?>
					<?php if($on_off_order_shipping_method !='0') { ?><?php if($order['shipping_method']) { ?><div><i class="fa fa-truck fa-fw"></i> <?php echo $order['shipping_method']; ?></div><?php } ?><?php } ?>
				  </td>
				 <?php if($on_off_column_product !='0') { ?>
				  <td class="text-left" style="min-width:300px;">
				  <div>
						<?php $i = 0;?>
						<?php foreach($order['products'] as $product){ ?>
						<div class="product_cont_<?php echo $order['order_id']; ?> <?php if($i > 0){ ?>cl hid <?php } ?>">
						<div><a href="<?php echo $product['href']; ?>" target="_blank"><?php echo $product['name']; ?></a></div>
						<div class="col-sm-3">
							<?php if ($product['thumb']) { ?><div style="float: left;"><img style="border: 1px solid #DDDDDD; margin-right: 3px;" src="<?php echo $product['thumb']; ?>" id="image" /></div><?php } ?>
						</div>
						<div class="col-sm-9">
							<div style="font-weight:bold;"><?php echo $product['price']; ?> x <?php echo $product['quantity']; ?></div>
							<?php if($on_off_model_product !='0') { ?><div><span style="font-weight:bold;"><?php echo $text_product_model ?></span> - <?php echo $product['model']; ?></div><?php } ?>
							<?php if($on_off_sku_product !='0') { ?><?php if($product['sku'] !='') { ?><div><span style="font-weight:bold;"><?php echo $text_product_sku ?></span> - <?php echo $product['sku']; ?></div><?php } ?><?php } ?>
							<?php if($on_off_upc_product !='0') { ?><?php if($product['upc'] !='') { ?><div><span style="font-weight:bold;"><?php echo $text_product_upc ?></span> - <?php echo $product['upc']; ?></div><?php } ?><?php } ?>
							<div class="options-product">
								<?php foreach ($product['option'] as $option) { ?>
								<?php if ($option['type'] != 'file') { ?>
								&nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
								<?php } else { ?>
								&nbsp;<small> - <?php echo $option['name']; ?>: <a href="<?php echo $option['href']; ?>"><?php echo $option['value']; ?></a></small>
								<?php } ?></br>
								<?php } ?>
							</div>
						</div>
							<div class="clearfix"></div><br />
							<?php $i++ ;?>	
						</div>	
						<?php } ?>
						
						<?php if($i > 1){?>
							   <div class="btn btn-default click_pr_btn_<?php echo $order['order_id']; ?> open_all_product"></div>
						<?php } ?>
						</div>	
					<script>
					$(document).ready(function() { 
						$(".click_pr_btn_<?php echo $order['order_id']; ?>").click(function(){ 
							$('.product_cont_<?php echo $order['order_id']; ?>.cl').toggleClass('hid');
							$('.click_pr_btn_<?php echo $order['order_id']; ?>').toggleClass('active');
						});
					});
					</script>
					
				  </td>
				  <?php } ?>
				  <td style="min-width:220px; <?php if($on_off_column_rise_product =='0'){?> display:none;<?php } ?>">
				  <input style="width:10%; display:inline-block;" type="checkbox" value="<?php echo $order['rise_product_yes_no']; ?>" <?php echo ($order['rise_product_yes_no'] == "Y" ? "checked" : "")?> onChange="updateRiseProduct(<?php echo $order['order_id'] ?>, this.checked ? 'Y' : 'N');" />
				  <select onChange="savePriceZak(<?php echo $order['order_id']; ?>, this.value);" class="rise_product_price_prefix_<?php echo $order['order_id']; ?> form-control" style="width:40%; display:inline-block;" name="rise_product_price_prefix">					
					<?php if($order['rise_product_price_prefix']=='+'){ ?>
						<option value="+" selected="selected"><?php echo "+";?></option>
						<option value="-"><?php echo "-";?></option>
					<?php } else { ?>
						<option value="+"><?php echo "+";?></option>
						<option value="-" selected="selected"><?php echo "-";?></option>
					<?php } ?>			
				  </select>
				  <input style="width:40%; display:inline-block;" class='rise_product_price_<?php echo $order['order_id']; ?> form-control' value="<?php echo $order['rise_product_price']?>" contenteditable="true" onBlur="savePriceZak(<?php echo $order['order_id']; ?>, this.value);"></input>
				  </td>
				  
				 
				  <td style="min-width:220px; <?php if($on_off_column_build =='0') { ?>display:none;<?php } ?>">
				  <input style="width:10%; display:inline-block;" type="checkbox" value="<?php echo $order['build_price_yes_no']; ?>" <?php echo ($order['build_price_yes_no'] == "Y" ? "checked" : "")?> onChange="updateBuild(<?php echo $order['order_id'] ?>, this.checked ? 'Y' : 'N');" />
				  <select onChange="savePriceZak(<?php echo $order['order_id']; ?>, this.value);" class="build_price_prefix_<?php echo $order['order_id']; ?> form-control" style="width:40%; display:inline-block;" name="build_price_prefix">					
					<?php if($order['build_price_prefix']=='+'){ ?>
						<option value="+" selected="selected"><?php echo "+";?></option>
						<option value="-"><?php echo "-";?></option>
					<?php } else { ?>
						<option value="+"><?php echo "+";?></option>
						<option value="-" selected="selected"><?php echo "-";?></option>
					<?php } ?>
				  </select>
				  <input style="width:40%; display:inline-block;" class='build_price_<?php echo $order['order_id']; ?> form-control' value="<?php echo $order['build_price']?>" contenteditable="true" onBlur="savePriceZak(<?php echo $order['order_id']; ?>, this.value);"></input>
				  </td>
				
				  
				  <td style="min-width:110px; <?php if($on_off_column_delivery_price =='0') { ?>display:none;<?php } ?>">
				  <input class='delivery_price_<?php echo $order['order_id']; ?> price_2 form-control' value="<?php echo $order['delivery_price']?>" contenteditable="true" onBlur="savePriceZak(<?php echo $order['order_id']; ?>, this.value);"></input>
				  </td>
				  
				  
				  <td style="min-width:110px; <?php if($on_off_column_price_purchase =='0') { ?> display:none;<?php } ?>">
					<?php foreach($order['products'] as $product){ ?>
				  	<input class="price_zak_<?php echo $product['order_id']; ?> form-control price_zak" contenteditable="true" onBlur="savePriceZak(<?php echo $product['order_id']; ?>, this.value, '<?php echo $product['product_id'];?>');" sum="<?php echo $product['quantity']; ?>" value="<?php echo $product['price_zak']; ?>"></input>
					<?php } ?>
				  </td>
				  
				  <?php if($on_off_column_total_profit !='0') { ?>
					<td id="calculated_summ_<?php echo $order['order_id']; ?>"><?php echo $order['calculated_summ'];?></td>
				  <?php } ?>
				  <?php if($on_off_column_send_ttn_email !='0') { ?>
				  <td style="min-width:250px;">
					 <button style="margin-bottom:10px;" onclick="sendTTN(<?php echo $order['order_id']; ?>);" type="button" id="button-customer_<?php echo $order['order_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-envelope-o"></i> <?php echo $text_btn_send_ttn; ?></button>
						<textarea  id='number_ttn_<?php echo $order['order_id']; ?>' class="form-control ttn_send" contenteditable="true" onBlur="saveTTN(<?php echo $order['order_id']; ?>, this.value);" value="<?php echo $order['text_ttn']; ?>"><?php echo $order['text_ttn']; ?></textarea>
					<input type="hidden" id="email_<?php echo $order['order_id']; ?>" value="<?php echo $order['email']; ?>"></input>
				 </td>
				  <?php } ?>
				 <?php if($on_off_column_comment_manager !='0') { ?>
				  <td style="min-width:250px;">
					<textarea  id='comment_manager_<?php echo $order['order_id']; ?>' class="form-control comment_manager" contenteditable="true" onBlur="saveCommentManager(<?php echo $order['order_id']; ?>, this.value);" value="<?php echo $order['comment_manager']; ?>"><?php echo $order['comment_manager']; ?></textarea>
				  </td>
				  <?php } ?>
				  
				  
				  <?php if($on_off_column_manager_process_orders !='0') { ?>
				  <td style="min-width:150px;"><div id='note4_<?php echo $order['order_id']; ?>'  >
							<select class="form-control" name="username" onChange="saveManagerUser(<?php echo $order['order_id']; ?>, this.value);">
							<?php if ($order['manager_process_orders'] !='') { ?>
							<option value="<?php echo $order['manager_process_orders'];?>"><?php echo $order['manager_process_orders']; ?></option>
							<?php } else { ?>
							<option value=""></option>
							<?php } ?>
							<?php foreach ($users as $user){?>
							<option value="<?php echo $user['username']?>"><?php echo $user['username']?></option>
							<?php }?>
							</select>
						</div> </td>
					<?php } ?>	
				
		
                  <?php if ($aqe_enabled) { ?>
		<td class="<?php echo $column_info["status"]['align']; ?><?php echo ($column_info["status"]['qe_status']) ? ' ' . $column_info["status"]['type'] : ''; ?>" id="<?php echo "status-" . $order['order_id']; ?>"><?php echo $order["status"]; ?></td>
		<?php } else { ?>
		 
		<td class="text-left" style="min-width:200px;">
					<select class="form-control" name="order_status_select" onChange="setOrderStatus(<?php echo $order['order_id'] ?>, this.value,'<?php echo $logged; ?>');">
		                  <?php foreach ($order_statuses as $order_status) { ?>
		                  <?php if ($order_status['order_status_id'] == $order['order_status_id']) { ?>
		                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
		                  <?php } else { ?>
		                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
		                  <?php } ?>
		                  <?php } ?>
		            </select>
				</td>
		
		<?php } ?>
                  <td class="text-right"><?php echo $order['total']; ?></td>
                  <td class="text-left"><?php echo $order['time_date_added']; ?></td>
                  <td class="text-left"><?php echo $order['date_modified']; ?></td>
                  <td class="text-right"><a href="<?php echo $order['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a> <a href="<?php echo $order['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" id="button-edit" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                    <button type="button" value="<?php echo $order['order_id']; ?>" id="button-delete<?php echo $order['order_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=sale/order&token=<?php echo $token; ?>';

 
		var filter_build_price_yes_no = $('select[name=\'filter_build_price_yes_no\']').val();

		if (filter_build_price_yes_no) {
			url += '&filter_build_price_yes_no=' + encodeURIComponent(filter_build_price_yes_no);
		}
		var filter_rise_product_yes_no = $('select[name=\'filter_rise_product_yes_no\']').val();

		if (filter_rise_product_yes_no) {
			url += '&filter_rise_product_yes_no=' + encodeURIComponent(filter_rise_product_yes_no);
		}
		var filter_delivery_price = $('input[name=\'filter_delivery_price\']').val();

		if (filter_delivery_price) {
			url += '&filter_delivery_price=' + encodeURIComponent(filter_delivery_price);
		}
		var filter_calculated_summ = $('input[name=\'filter_calculated_summ\']').val();

		if (filter_calculated_summ) {
			url += '&filter_calculated_summ=' + encodeURIComponent(filter_calculated_summ);
		}
		var filter_manager_process_orders = $('select[name=\'filter_manager_process_orders\']').val();

		if (filter_manager_process_orders) {
			url += '&filter_manager_process_orders=' + encodeURIComponent(filter_manager_process_orders);
		}
		
		var filter_date_added_start = $('input[name=\'filter_date_added_start\']').val();

		if (filter_date_added_start) {
			url += '&filter_date_added_start=' + encodeURIComponent(filter_date_added_start);
		}
		
		var filter_date_added_end = $('input[name=\'filter_date_added_end\']').val();

		if (filter_date_added_end) {
			url += '&filter_date_added_end=' + encodeURIComponent(filter_date_added_end);
		}
		
	var filter_order_id = $('input[name=\'filter_order_id\']').val();

	if (filter_order_id) {
		url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
	}

	var filter_customer = $('input[name=\'filter_customer\']').val();

	if (filter_customer) {
		url += '&filter_customer=' + encodeURIComponent(filter_customer);
	}

	var filter_order_status = $('select[name=\'filter_order_status\']').val();

	if (filter_order_status != '*') {
		url += '&filter_order_status=' + encodeURIComponent(filter_order_status);
	}

	var filter_total = $('input[name=\'filter_total\']').val();

	if (filter_total) {
		url += '&filter_total=' + encodeURIComponent(filter_total);
	}

	var filter_date_added = $('input[name=\'filter_date_added\']').val();

	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

	var filter_date_modified = $('input[name=\'filter_date_modified\']').val();

	if (filter_date_modified) {
		url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
	}

	location = url;
});
//--></script>
  <script type="text/javascript"><!--
$('input[name=\'filter_customer\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['customer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_customer\']').val(item['label']);
	}
});
//--></script>
  <script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() {
	$('#button-shipping, #button-invoice').prop('disabled', true);

	var selected = $('input[name^=\'selected\']:checked');

	if (selected.length) {
		$('#button-invoice').prop('disabled', false);
	}

	for (i = 0; i < selected.length; i++) {
		if ($(selected[i]).parent().find('input[name^=\'shipping_code\']').val()) {
			$('#button-shipping').prop('disabled', false);

			break;
		}
	}
});

$('input[name^=\'selected\']:first').trigger('change');

// Login to the API
var token = '';

$.ajax({
	url: '<?php echo $store; ?>index.php?route=api/login',
	type: 'post',
	data: 'key=<?php echo $api_key; ?>',
	dataType: 'json',
	crossDomain: true,
	success: function(json) {
        $('.alert').remove();

        if (json['error']) {
    		if (json['error']['key']) {
    			$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['key'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    		}

        if (json['error']['ip']) {
    			$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['ip'] + ' <button type="button" id="button-ip-add" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger btn-xs pull-right"><i class="fa fa-plus"></i> <?php echo $button_ip_add; ?></button></div>');
    			$('#button-edit').attr('disabled', 'disabled');
    		}
        }

		if (json['token']) {
			token = json['token'];
		}
	},
	error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	}
});

$(document).delegate('#button-ip-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=user/api/addip&token=<?php echo $token; ?>&api_id=<?php echo $api_id; ?>',
		type: 'post',
		data: 'ip=<?php echo $api_ip; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#button-ip-add').button('loading');
		},
		complete: function() {
			$('#button-ip-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
        $('#button-edit').removeAttr('disabled');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('button[id^=\'button-delete\']').on('click', function(e) {
	if (confirm('<?php echo $text_confirm; ?>')) {
		var node = this;

		$.ajax({
			url: '<?php echo $store; ?>index.php?route=api/order/delete&token=' + token + '&order_id=' + $(node).val(),
			dataType: 'json',
			crossDomain: true,
			beforeSend: function() {
				$(node).button('loading');
			},
			complete: function() {
				$(node).button('reset');
			},
			success: function(json) {
				$('.alert').remove();

				if (json['error']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				if (json['success']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});
//--></script>

<div id="merge_block"></div>
<style>
#merge_form .alert {text-align:center;font-size:13px;}
</style>
<script type="text/javascript">
$(document).delegate('#old_order', 'change', function() {
	if ($(this).val() == 1) {
		$('#merge_form .old-status').slideDown('slow');
	} else {
		$('#merge_form .old-status').slideUp('slow');
	}
});

function getmerge() {
	$('#merge_modal').remove();
    $.ajax({
        url: 'index.php?route=sale/orderpro/getMerge&token=<?php echo $token; ?>',
        type: 'post',
        dataType: 'json',
        data: $('#form-order :checked'),
		beforeSend: function() {
			$('.alert').remove();
			$('#button-merge').children('.fa').addClass('fa-cog fa-spin');
		},
        success: function(json) {
			if (json['error']) {
				$('#button-merge').children('.fa').removeClass('fa-cog fa-spin');
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}
			if (json['html']) {
				$('#merge_block').html(json['html']);
				setTimeout (function() {
					$('#merge_modal').modal('show');
					$('#button-merge').children('.fa').removeClass('fa-cog fa-spin');
				}, 800);
			}
        },
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

function merge_order() {
    $.ajax({
        url: 'index.php?route=sale/orderpro/MergeOrder&token=<?php echo $token; ?>',
        type: 'post',
        dataType: 'json',
        data: $('#merge_form :input'),
		beforeSend: function() {
			$('#merge_modal .btn-success').remove();
		},
        success: function(json) {
			if (json['error']) {
				$('#merge_form').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' </div>');
			}
			if (json['success']) {
				$('#merge_form').prepend('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> ' + json['success'] + ' </div>');
			}
        },
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}
</script>
						
  <script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>

		<?php if ($aqe_enabled) { ?>
		<script type="text/javascript"><!--
		!function(t,e){t.batch_edit=parseInt("<?php echo (int)$batch_edit; ?>"),t.texts=e.extend({},t.texts,{error_ajax_request:"<?php echo addslashes($error_ajax_request); ?>"}),e(function(){e(".status_qe").editable(function(i,o){var a=e("#notify",this).is(":checked")?1:0,n={notify:a,api_token:token};return t.quick_update(this,i,o,"<?php echo $update_url; ?>",n).done(e.proxy(t.update_finished,{column:e(this).attr("id").split("-")[0]})).fail(e.proxy(t.update_failed,this)),o.indicator},{type:"status_edit",data:"<?php echo trim($status_select); ?>",indicator:"<?php echo $text_saving; ?>",tooltip:"<?php echo $aqe_tooltip; ?>",event:"<?php echo $aqe_quick_edit_on; ?>",onblur:"cancel",notify_customer_text:"<?php echo $text_notify_customer; ?>",notify_customer:parseInt("<?php echo (int)$notify_customer; ?>")})})}(window.bull5i=window.bull5i||{},jQuery);
		//--></script>
		<?php } ?>
			
 
		
		<script>
		$(document).ready(function() {
		var table_out_width = $('.table').outerWidth();
		var table_responsive = $('.table-responsive').outerWidth();
		if ($('.table').outerWidth() > $('.table-responsive').outerWidth()) {
				var html = '<div class="joystick shadow"><div class="joystick_left"></div><div class="joystick_right"></div></div>';
				$('.table-responsive').prepend(html);
				$('.joystick').hover(
					function () { $(this).animate({'opacity':'1.0'}, 300); },
					function () { $(this).animate({'opacity':'0.5'}, 300); }
				);
				
				$('.joystick_left, .joystick_right').click(function() {
					var this_ = $(this);
					var width = $('.table-responsive').outerWidth();
					var scroll_left = $('.table-responsive').scrollLeft();
					
					if (this_.attr('class') == 'joystick_left') {
						$('.table-responsive').animate({'scrollLeft':(scroll_left - 700)}, 700);
					} else {
						$('.table-responsive').animate({'scrollLeft':(scroll_left + 700)}, 700);
					}
				});
			}
		});
		</script>
		<style>
			.joystick {
					position:fixed;
					top:50%;
					left:50%;
					width:150px;
					background:#F0F0F0;
					opacity:0.5;
					margin-left:-50px;
					padding:5px;
					border:1px solid #CCC;
					border-radius:3px;
					z-index:9999;
				}
				.joystick_left {
					float:left;
					background:url(view/image/go_left.png) no-repeat top center;
				}
				.joystick_right {
					float:right;
					background:url(view/image/go_right.png) no-repeat top center;
				}
				.joystick_left, .joystick_right {
					width:36px;
					height:36px;
					border:1px solid #F0F0F0;
					padding-bottom:2px;
				}
				.joystick_left:hover, .joystick_right:hover {
					border:1px solid #CCC;
					border-radius:3px;
					cursor:pointer;
				}
		</style>
		<script>
				function setOrderStatus(orderId, statusId, user_change) {
					$.ajax({
						url: 'index.php?route=sale/order/setOrderStatus&token=<?php echo $token; ?>',
						type: 'post',
						data: '&order_id=' + orderId + '&order_status_id=' + statusId + '&user_change=' + user_change,
						dataType: 'json',
						beforeSend: function() {
							$('.success, .warning, .attention, .error').remove();
						},			
						success: function(json) {
							$('.success, .warning, .attention, .information, .error').remove();	
							$('#row_' + orderId).attr('style', 'background-color: ' + json['background_color'] + ' !important; color:'+ json['color_text'] +'');	
						}
					});
				}
				function saveCommentManager(orderId,value) {				
					$.ajax({
						url: 'index.php?route=sale/order/saveCommentManager&token=<?php echo $token; ?>',
						type: 'post',
						data: '&order_id=' + orderId + '&comment_manager=' + value,
						dataType: 'json',
						success: function(json) {
							$('.success, .warning, .attention, .information, .error').remove();
							if (json['success']) {
							}	
						}
					});
				}
				function saveTTN(orderId,value) {				
					$.ajax({
						url: 'index.php?route=sale/order/saveTTN&token=<?php echo $token; ?>',
						type: 'post',
						data: '&order_id=' + orderId + '&text_ttn=' + value,
						dataType: 'json',
						success: function(json) {
							$('.success, .warning, .attention, .information, .error').remove();
							if (json['success']) {
							}	
						}
					});
				}
				function sendTTN(orderId) {	
				
					var number_ttn = $('#number_ttn_' + orderId).val();
					var email_user = $('#email_' + orderId).val();	
					$.ajax({
						url: 'index.php?route=sale/order/sendTTN&token=<?php echo $token; ?>',
						type: 'post',
						data: '&order_id=' + orderId + '&number_ttn=' + number_ttn + '&email_user=' + email_user,
						dataType: 'json',
						beforeSend: function() {
							$('#button-customer_'+ orderId).button('loading');
						},
						complete: function() {
							$('#button-customer_'+ orderId).button('reset');
						},
						success: function(json) {
							$('.success, .warning, .attention, .information, .error').remove();
							if (json['success']) {
							}	
						}
					});
				}
				
				function savePriceZak(orderId,value, product_id) {
				var arr = new Array();
						var sum_price_zak = 0;
						$('.price_zak_' + orderId).each(function() {
							  sum_price_zak+=parseFloat($(this).val()*$(this).attr('sum'));
						});	
						$('.delivery_price_' + orderId).each(function() {
							delivery_price_val = $(this).val();
							if(delivery_price_val ==''){
								delivery_price = '0';
							} else { 
								delivery_price = delivery_price_val;
							}
						});	
						var build_price = $('.build_price_' + orderId).val();
					    var build_price_prefix = $('.build_price_prefix_' + orderId).val();							
						
						$('.rise_product_price_' + orderId).each(function() {
							rise_product_price_val = $(this).val();
							if(rise_product_price_val ==''){
								rise_product_price = '0';
							} else { 
								rise_product_price = rise_product_price_val;
							}
						});	
						
						$('.rise_product_price_prefix_' + orderId).each(function() {
							rise_product_price_prefix = $(this).val();							
						});	
										
					$.ajax({
						url: 'index.php?route=sale/order/savePriceZak&token=<?php echo $token; ?>',
						type: 'post',						
						data: '&order_id=' + orderId + '&price_zak=' + value + '&product_id=' + product_id + '&sum_price_zak=' + sum_price_zak + '&delivery_price=' + delivery_price + '&build_price=' + build_price + '&build_price_prefix=' +  encodeURIComponent(build_price_prefix) + '&rise_product_price=' + rise_product_price + '&rise_product_price_prefix=' + encodeURIComponent(rise_product_price_prefix),
						dataType: 'json',
						success: function(json) {
							$('.success, .warning, .attention, .information, .error').remove();
							if (json['success']) {
							}
							if (json['calculated_summ']) {
								$('#calculated_summ_' + orderId).text(json['calculated_summ']);
							}							
						}
					});
				}
				function saveManagerUser(orderId,value) {				
					$.ajax({
						url: 'index.php?route=sale/order/saveManagerUser&token=<?php echo $token; ?>',
						type: 'post',
						data: '&order_id=' + orderId + '&manager_user=' + value,
						dataType: 'json',
						success: function(json) {
							$('.success, .warning, .attention, .information, .error').remove();
							if (json['success']) {
							}	
						}
					});
				}
				function updateBuild(orderId,build_price_yes_no) {				
					$.ajax({
						url: 'index.php?route=sale/order/updateBuild&token=<?php echo $token; ?>',
						type: 'post',
						data: '&order_id=' + orderId + '&build_price_yes_no=' + build_price_yes_no,
						dataType: 'json',
						success: function(json) {
							$('.success, .warning, .attention, .information, .error').remove();
							if (json['success']) {
							}	
						}
					});
				}
				function updateRiseProduct(orderId,rise_product_yes_no) {				
					$.ajax({
						url: 'index.php?route=sale/order/updateRiseProduct&token=<?php echo $token; ?>',
						type: 'post',
						data: '&order_id=' + orderId + '&rise_product_yes_no=' + rise_product_yes_no,
						dataType: 'json',
						success: function(json) {
							$('.success, .warning, .attention, .information, .error').remove();
							if (json['success']) {
							}	
						}
					});
				}
</script>
		
<?php echo $footer; ?>

		<style>
					.cl.hid {
						display:none;
					}
					.cl {
						display:block;
					}
					.open_all_product {
						background:#fff;
						border:1px solid #d9d9d9;
						border-radius:5px;
						text-align:center;
						position:relative;
						height:20px;
						width:100%;
						
					}
					.open_all_product:before {
						width: 0; 
						height: 0; 
						border-left: 5px solid transparent;
						border-right: 5px solid transparent;
						border-top: 5px solid #000;
						content:"";
						position:absolute;
						top:7px;
					}
					.open_all_product.active:after {
						width: 0; 
						height: 0; 
						border-left: 5px solid transparent;
						border-right: 5px solid transparent;
						border-bottom: 5px solid #000;
						content:"";
						position:absolute;
						top:7px;
					}
					.open_all_product.active:before {
						width: 0; 
						height: 0; 
						border-left: 0px solid transparent;
						border-right: 0px solid transparent;
						border-bottom: 0px solid #000;
						content:"";
						position:absolute;
						top:5px;
					}
					.options-product {
						word-wrap:break-word;
					}
				</style>
		
