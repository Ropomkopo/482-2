<?php echo $header; ?><?php echo $column_left; ?>
<div id="content" class="setting-content">
	<div class="page-header">
		<div class="container-fluid">
		  <div class="pull-right">
			<div class="buttons">
				<a onclick="$('#setting_form').submit();" class="btn btn-success btn-sm"><span><?php echo $button_save; ?></span></a>
				<a onclick="javascript:location.href='<?php echo $cancel; ?>';" class="btn btn-danger btn-sm"><span><?php echo $button_cancel; ?></span></a>
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
	<div class="container-fluid setting-form">
    <?php if ($error_warning) { ?>
    <div class="alert-danger"><i class="fa fa-check-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close">&times;</button>
    </div>
    <?php } ?>
    <?php if ($error_license) { ?>
    <div class="alert-danger"><i class="fa fa-check-circle"></i> <?php echo $error_license; ?>
      <button type="button" class="close">&times;</button>
    </div>
    <?php } ?>
	<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_heading; ?></h3><span class="version"><?php echo $orderpro_version; ?></span>
	</div>
	
	<div class="panel-body">
		<form action="<?php echo $action; ?>" method="post" id="setting_form" enctype="multipart/form-data">
		<div class="nwell">
			<div class="row">
			<div class="col-sm-12">
				<div class="well form-horizontal">
					<div class="form-group">
						<label class="control-label col-lg-2 col-md-3 col-sm-4" style="padding-top:7px;"><?php echo $entry_license; ?></label>
						<div class="col-lg-10 col-md-9 col-sm-8">
							<input type="text" class="form-control input-license" name="orderpro_license" value="<?php echo $orderpro_license; ?>" />
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
		
		<div class="nwell">
			<div class="row">
			<div class="col-md-4 col-sm-6 setting-order">
				<div class="well">
				<div class="form-group form-title">
					<label class="control-label"><?php echo $column_setting_order; ?></label>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_show_pid">
						<?php if ($orderpro_show_pid) { ?>
							<input type="checkbox" name="orderpro_show_pid" id="orderpro_show_pid" value="1" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_show_pid" id="orderpro_show_pid" value="1" />
						<?php } ?>
						<?php echo $entry_show_pid; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_show_image">
						<?php if ($orderpro_show_image) { ?>
							<input type="checkbox" name="orderpro_show_image" value="1" id="orderpro_show_image" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_show_image" value="1" id="orderpro_show_image" />
						<?php } ?>
						<?php echo $entry_show_image; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_show_model">
						<?php if ($orderpro_show_model) { ?>
							<input type="checkbox" name="orderpro_show_model" value="1" id="orderpro_show_model" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_show_model" value="1" id="orderpro_show_model" />
						<?php } ?>
						<?php echo $entry_show_model; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_show_sku">
						<?php if ($orderpro_show_sku) { ?>
							<input type="checkbox" name="orderpro_show_sku" value="1" id="orderpro_show_sku" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_show_sku" value="1" id="orderpro_show_sku" />
						<?php } ?>
						<?php echo $entry_show_sku; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_show_upc">
						<?php if ($orderpro_show_upc) { ?>
							<input type="checkbox" name="orderpro_show_upc" value="1" id="orderpro_show_upc" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_show_upc" value="1" id="orderpro_show_upc" />
						<?php } ?>
						<?php echo $entry_show_upc; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_show_ean">
						<?php if ($orderpro_show_ean) { ?>
							<input type="checkbox" name="orderpro_show_ean" value="1" id="orderpro_show_ean" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_show_ean" value="1" id="orderpro_show_ean" />
						<?php } ?>
						<?php echo $entry_show_ean; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_show_jan">
						<?php if ($orderpro_show_jan) { ?>
							<input type="checkbox" name="orderpro_show_jan" value="1" id="orderpro_show_jan" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_show_jan" value="1" id="orderpro_show_jan" />
						<?php } ?>
						<?php echo $entry_show_jan; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_show_isbn">
						<?php if ($orderpro_show_isbn) { ?>
							<input type="checkbox" name="orderpro_show_isbn" value="1" id="orderpro_show_isbn" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_show_isbn" value="1" id="orderpro_show_isbn" />
						<?php } ?>
						<?php echo $entry_show_isbn; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_show_mpn">
						<?php if ($orderpro_show_mpn) { ?>
							<input type="checkbox" name="orderpro_show_mpn" value="1" id="orderpro_show_mpn" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_show_mpn" value="1" id="orderpro_show_mpn" />
						<?php } ?>
						<?php echo $entry_show_mpn; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_show_location">
						<?php if ($orderpro_show_location) { ?>
							<input type="checkbox" name="orderpro_show_location" value="1" id="orderpro_show_location" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_show_location" value="1" id="orderpro_show_location" />
						<?php } ?>
						<?php echo $entry_show_location; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_show_weight">
						<?php if ($orderpro_show_weight) { ?>
							<input type="checkbox" name="orderpro_show_weight" value="1" id="orderpro_show_weight" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_show_weight" value="1" id="orderpro_show_weight" />
						<?php } ?>
						<?php echo $entry_show_weight; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_invoice_type">
						<?php if ($orderpro_invoice_type) { ?>
							<input type="checkbox" name="orderpro_invoice_type" value="1" id="orderpro_invoice_type" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_invoice_type" value="1" id="orderpro_invoice_type" />
						<?php } ?>
						<?php echo $entry_invoice_type; ?>
						</label>
					</div>
				</div>
				<div class="form-group has-popover">
					<div class="checkbox">
						<label class="control-label" for="orderpro_virtual_customer">
						<?php if ($orderpro_virtual_customer) { ?>
							<input type="checkbox" name="orderpro_virtual_customer" value="1" id="orderpro_virtual_customer" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_virtual_customer" value="1" id="orderpro_virtual_customer" />
						<?php } ?>
						<?php echo $entry_virtual_customer; ?>
						</label>
						<a tabindex="0" class="btn btn-primary btn-xs btn-popover" role="button" data-toggle="popover" title="" data-content="<?php echo $help_virtual_customer; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_autocomplete_type">
						<?php if ($orderpro_autocomplete_type) { ?>
							<input type="checkbox" name="orderpro_autocomplete_type" value="1" id="orderpro_autocomplete_type" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_autocomplete_type" value="1" id="orderpro_autocomplete_type" />
						<?php } ?>
						<?php echo $entry_autocomplete_type; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_show_affiliate">
						<?php if ($orderpro_show_affiliate) { ?>
							<input type="checkbox" name="orderpro_show_affiliate" value="1" id="orderpro_show_affiliate" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_show_affiliate" value="1" id="orderpro_show_affiliate" />
						<?php } ?>
						<?php echo $entry_show_affiliate; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_auto_addreward">
						<?php if ($orderpro_auto_addreward) { ?>
							<input type="checkbox" name="orderpro_auto_addreward" value="1" id="orderpro_auto_addreward" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_auto_addreward" value="1" id="orderpro_auto_addreward" />
						<?php } ?>
						<?php echo $entry_auto_addreward; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_neworder_notify">
						<?php if ($orderpro_neworder_notify) { ?>
							<input type="checkbox" name="orderpro_neworder_notify" value="1" id="orderpro_neworder_notify" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_neworder_notify" value="1" id="orderpro_neworder_notify" />
						<?php } ?>
						<?php echo $entry_neworder_notify; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_notabs_mode">
						<?php if ($orderpro_notabs_mode) { ?>
							<input type="checkbox" name="orderpro_notabs_mode" value="1" id="orderpro_notabs_mode" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_notabs_mode" value="1" id="orderpro_notabs_mode" />
						<?php } ?>
						<?php echo $entry_tabs_mode; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_show_similar">
						<?php if ($orderpro_show_similar) { ?>
							<input type="checkbox" name="orderpro_show_similar" value="1" id="orderpro_show_similar" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_show_similar" value="1" id="orderpro_show_similar" />
						<?php } ?>
						<?php echo $entry_show_similar; ?>
						</label>
					</div>
				</div>
				</div>
			</div>
			
			<div class="col-md-4 col-sm-6 setting-invoice">
				<div class="well">
				<div class="form-group form-title">
					<label class="control-label"><?php echo $column_setting_invoice; ?></label>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_invoice_pid">
						<?php if ($orderpro_invoice_pid) { ?>
							<input type="checkbox" name="orderpro_invoice_pid" id="orderpro_invoice_pid" value="1" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_invoice_pid" id="orderpro_invoice_pid" value="1" />
						<?php } ?>
						<?php echo $entry_show_pid; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_invoice_image">
						<?php if ($orderpro_invoice_image) { ?>
							<input type="checkbox" name="orderpro_invoice_image" value="1" id="orderpro_invoice_image" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_invoice_image" value="1" id="orderpro_invoice_image" />
						<?php } ?>
						<?php echo $entry_show_image; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_invoice_model">
						<?php if ($orderpro_invoice_model) { ?>
							<input type="checkbox" name="orderpro_invoice_model" value="1" id="orderpro_invoice_model" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_invoice_model" value="1" id="orderpro_invoice_model" />
						<?php } ?>
						<?php echo $entry_show_model; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_invoice_sku">
						<?php if ($orderpro_invoice_sku) { ?>
							<input type="checkbox" name="orderpro_invoice_sku" value="1" id="orderpro_invoice_sku" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_invoice_sku" value="1" id="orderpro_invoice_sku" />
						<?php } ?>
						<?php echo $entry_show_sku; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_invoice_upc">
						<?php if ($orderpro_invoice_upc) { ?>
							<input type="checkbox" name="orderpro_invoice_upc" value="1" id="orderpro_invoice_upc" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_invoice_upc" value="1" id="orderpro_invoice_upc" />
						<?php } ?>
						<?php echo $entry_show_upc; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_invoice_ean">
						<?php if ($orderpro_invoice_ean) { ?>
							<input type="checkbox" name="orderpro_invoice_ean" value="1" id="orderpro_invoice_ean" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_invoice_ean" value="1" id="orderpro_invoice_ean" />
						<?php } ?>
						<?php echo $entry_show_ean; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_invoice_jan">
						<?php if ($orderpro_invoice_jan) { ?>
							<input type="checkbox" name="orderpro_invoice_jan" value="1" id="orderpro_invoice_jan" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_invoice_jan" value="1" id="orderpro_invoice_jan" />
						<?php } ?>
						<?php echo $entry_show_jan; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_invoice_isbn">
						<?php if ($orderpro_invoice_isbn) { ?>
							<input type="checkbox" name="orderpro_invoice_isbn" value="1" id="orderpro_invoice_isbn" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_invoice_isbn" value="1" id="orderpro_invoice_isbn" />
						<?php } ?>
						<?php echo $entry_show_isbn; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_invoice_mpn">
						<?php if ($orderpro_invoice_mpn) { ?>
							<input type="checkbox" name="orderpro_invoice_mpn" value="1" id="orderpro_invoice_mpn" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_invoice_mpn" value="1" id="orderpro_invoice_mpn" />
						<?php } ?>
						<?php echo $entry_show_mpn; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_invoice_location">
						<?php if ($orderpro_invoice_location) { ?>
							<input type="checkbox" name="orderpro_invoice_location" value="1" id="orderpro_invoice_location" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_invoice_location" value="1" id="orderpro_invoice_location" />
						<?php } ?>
						<?php echo $entry_show_location; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_invoice_weight">
						<?php if ($orderpro_invoice_weight) { ?>
							<input type="checkbox" name="orderpro_invoice_weight" value="1" id="orderpro_invoice_weight" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_invoice_weight" value="1" id="orderpro_invoice_weight" />
						<?php } ?>
						<?php echo $entry_show_weight; ?>
						</label>
					</div>
				</div>
				</div>
			</div>
			
			<div class="col-md-4 col-sm-6 setting-mail">
				<div class="well">
				<div class="form-group form-title">
					<label class="control-label"><?php echo $column_setting_mail; ?></label>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_neworder_pid">
						<?php if ($orderpro_neworder_pid) { ?>
							<input type="checkbox" name="orderpro_neworder_pid" id="orderpro_neworder_pid" value="1" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_neworder_pid" id="orderpro_neworder_pid" value="1" />
						<?php } ?>
						<?php echo $entry_show_pid; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_neworder_image">
						<?php if ($orderpro_neworder_image) { ?>
							<input type="checkbox" name="orderpro_neworder_image" value="1" id="orderpro_neworder_image" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_neworder_image" value="1" id="orderpro_neworder_image" />
						<?php } ?>
						<?php echo $entry_show_image; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_neworder_model">
						<?php if ($orderpro_neworder_model) { ?>
							<input type="checkbox" name="orderpro_neworder_model" value="1" id="orderpro_neworder_model" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_neworder_model" value="1" id="orderpro_neworder_model" />
						<?php } ?>
						<?php echo $entry_show_model; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_neworder_sku">
						<?php if ($orderpro_neworder_sku) { ?>
							<input type="checkbox" name="orderpro_neworder_sku" value="1" id="orderpro_neworder_sku" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_neworder_sku" value="1" id="orderpro_neworder_sku" />
						<?php } ?>
						<?php echo $entry_show_sku; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_neworder_upc">
						<?php if ($orderpro_neworder_upc) { ?>
							<input type="checkbox" name="orderpro_neworder_upc" value="1" id="orderpro_neworder_upc" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_neworder_upc" value="1" id="orderpro_neworder_upc" />
						<?php } ?>
						<?php echo $entry_show_upc; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_neworder_ean">
						<?php if ($orderpro_neworder_ean) { ?>
							<input type="checkbox" name="orderpro_neworder_ean" value="1" id="orderpro_neworder_ean" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_neworder_ean" value="1" id="orderpro_neworder_ean" />
						<?php } ?>
						<?php echo $entry_show_ean; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_neworder_jan">
						<?php if ($orderpro_neworder_jan) { ?>
							<input type="checkbox" name="orderpro_neworder_jan" value="1" id="orderpro_neworder_jan" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_neworder_jan" value="1" id="orderpro_neworder_jan" />
						<?php } ?>
						<?php echo $entry_show_jan; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_neworder_isbn">
						<?php if ($orderpro_neworder_isbn) { ?>
							<input type="checkbox" name="orderpro_neworder_isbn" value="1" id="orderpro_neworder_isbn" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_neworder_isbn" value="1" id="orderpro_neworder_isbn" />
						<?php } ?>
						<?php echo $entry_show_isbn; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_neworder_mpn">
						<?php if ($orderpro_neworder_mpn) { ?>
							<input type="checkbox" name="orderpro_neworder_mpn" value="1" id="orderpro_neworder_mpn" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_neworder_mpn" value="1" id="orderpro_neworder_mpn" />
						<?php } ?>
						<?php echo $entry_show_mpn; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_neworder_location">
						<?php if ($orderpro_neworder_location) { ?>
							<input type="checkbox" name="orderpro_neworder_location" value="1" id="orderpro_neworder_location" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_neworder_location" value="1" id="orderpro_neworder_location" />
						<?php } ?>
						<?php echo $entry_show_location; ?>
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label class="control-label" for="orderpro_neworder_weight">
						<?php if ($orderpro_neworder_weight) { ?>
							<input type="checkbox" name="orderpro_neworder_weight" value="1" id="orderpro_neworder_weight" checked="checked" />
						<?php } else { ?>
							<input type="checkbox" name="orderpro_neworder_weight" value="1" id="orderpro_neworder_weight" />
						<?php } ?>
						<?php echo $entry_show_weight; ?>
						</label>
					</div>
				</div>
				</div>
			</div>
			</div>
		</div>
		</form>
	</div>
	
	</div>
	</div>
<script type="text/javascript"><!--
$('.setting-order .btn-popover').popover({
	trigger: "hover",
	placement: "top"
});
//--></script></div>
<?php echo $footer; ?>