<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-featured" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-featured" class="form-horizontal">
        <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
        </ul>
		  <div class="tab-content">
			<?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="ttn_subject<?php echo $language['language_id']; ?>"><b><?php echo $ttn_subject_text;?></b><br /><?php echo $ttn_subject_text_variables;?></label>
						<div class="col-sm-10">
							<textarea name="ttn_subject<?php echo $language['language_id'] ?>" id="ttn_subject<?php echo $language['language_id'] ?>" cols="50" rows="3"><?php echo isset(${'ttn_subject' . $language['language_id']}) ? ${'ttn_subject' . $language['language_id']} : ''; ?></textarea>   
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="ttn_description<?php echo $language['language_id']; ?>"><b><?php echo $entry_description_send_email_ttn;?></b><br /><?php echo $ttn_subject_text_variables;?>
						<div class="container<?php echo $language['language_id'] ?>">
								<a href="javascript:PopUpShow<?php echo $language['language_id'] ?>()"><?php echo $list_of_variables_text ?></a>
						</div>
						<div class="list_of_variables_entry<?php echo $language['language_id'] ?> close_variable"><?php echo $list_of_variables_entry;?></div>
						</label>
						<div class="col-sm-10">
							<textarea name="ttn_description<?php echo $language['language_id'] ?>" id="ttn_description<?php echo $language['language_id'] ?>" cols="50" rows="3"><?php echo isset(${'ttn_description' . $language['language_id']}) ? ${'ttn_description' . $language['language_id']} : ''; ?></textarea>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="config_on_off_order_payment_method"><?php echo $entry_on_off_payment_method; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_order_payment_method" id="config_on_off_order_payment_method" class="form-control">
                <?php if ($config_on_off_order_payment_method) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="config_on_off_order_shipping_method"><?php echo $entry_on_off_shipping_method; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_order_shipping_method" id="config_on_off_order_shipping_method" class="form-control">
                <?php if ($config_on_off_order_shipping_method) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		 <div class="form-group">
            <label class="col-sm-2 control-label" for="config_on_off_model_product"><?php echo $entry_on_off_model_product; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_model_product" id="config_on_off_model_product" class="form-control">
                <?php if ($config_on_off_model_product) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="config_on_off_sku_product"><?php echo $entry_on_off_sku_product; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_sku_product" id="config_on_off_sku_product" class="form-control">
                <?php if ($config_on_off_sku_product) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="config_on_off_upc_product"><?php echo $entry_on_off_upc_product; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_upc_product" id="config_on_off_upc_product" class="form-control">
                <?php if ($config_on_off_upc_product) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="config_on_off_column_product"><?php echo $entry_on_off_column_product; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_column_product" id="config_on_off_column_product" class="form-control">
                <?php if ($config_on_off_column_product) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="config_on_off_column_comment_manager"><?php echo $entry_on_off_column_comment_manager; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_column_comment_manager" id="config_on_off_column_comment_manager" class="form-control">
                <?php if ($config_on_off_column_comment_manager) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="config_on_off_column_send_ttn_email"><?php echo $entry_on_off_column_send_ttn_email; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_column_send_ttn_email" id="config_on_off_column_send_ttn_email" class="form-control">
                <?php if ($config_on_off_column_send_ttn_email) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="config_on_off_column_price_purchase"><?php echo $entry_on_off_column_price_purchase; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_column_price_purchase" id="config_on_off_column_price_purchase" class="form-control">
                <?php if ($config_on_off_column_price_purchase) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="config_on_off_column_total_profit"><?php echo $entry_on_off_column_total_profit; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_column_total_profit" id="config_on_off_column_total_profit" class="form-control">
                <?php if ($config_on_off_column_total_profit) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="config_on_off_column_manager_process_orders"><?php echo $entry_on_off_column_manager_process_orders; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_column_manager_process_orders" id="config_on_off_column_manager_process_orders" class="form-control">
                <?php if ($config_on_off_column_manager_process_orders) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="config_on_off_column_delivery_price"><?php echo $entry_on_off_column_delivery_price; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_column_delivery_price" id="config_on_off_column_delivery_price" class="form-control">
                <?php if ($config_on_off_column_delivery_price) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="config_on_off_column_build"><?php echo $entry_on_off_column_build; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_column_build" id="config_on_off_column_build" class="form-control">
                <?php if ($config_on_off_column_build) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="config_on_off_column_rise_product"><?php echo $entry_on_off_column_rise_product; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_column_rise_product" id="config_on_off_column_rise_product" class="form-control">
                <?php if ($config_on_off_column_rise_product) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" type="text/css" href="../catalog/view/javascript/jquery/colorbox/colorbox.css" media="screen" />
<script type="text/javascript" src="../catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js"></script>
<script>
	<?php foreach ($languages as $language) { ?>
		function PopUpShow<?php echo $language['language_id'] ?>(){
			var d = $(this);
			$.colorbox({
				width: 700,
				inline: true,
				opacity: 0.5,
				href: '.list_of_variables_entry<?php echo $language['language_id'] ?>',
				onOpen: function(){
					$('.list_of_variables_entry<?php echo $language['language_id'] ?>').fadeIn()
				},
				onCleanup: function(){
					$('.list_of_variables_entry<?php echo $language['language_id'] ?>').hide();
				}
			}); 
		};	
	<?php } ?>
</script>
<style>
.close_variable {
	display:none;
}						
					</style>
  <script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#ttn_description<?php echo $language['language_id'] ?>').summernote({height: 300});
<?php } ?>
//--></script>
<style>
.close {
	display:none;
}						
</style>
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>