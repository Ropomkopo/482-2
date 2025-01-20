<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-order-status" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-order-status" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <?php foreach ($languages as $language) { ?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                <input type="text" name="order_status[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($order_status[$language['language_id']]) ? $order_status[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
              </div>
              <?php if (isset($error_name[$language['language_id']])) { ?>
              <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
              <?php } ?>
              <?php } ?>
            </div>
          </div>
 
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
							<textarea name="order_status[<?php echo $language['language_id'] ?>][order_status_subject]" id="order_status_subject<?php echo $language['language_id'] ?>" cols="50" rows="3"><?php echo isset($order_status[$language['language_id']]) ? $order_status[$language['language_id']]['order_status_subject'] : ''; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="ttn_description<?php echo $language['language_id']; ?>"><b><?php echo $text_email_template;?></b><br /><?php echo $ttn_subject_text_variables;?>
						<div class="container<?php echo $language['language_id'] ?>">
								<a href="javascript:PopUpShow<?php echo $language['language_id'] ?>()"><?php echo $list_of_variables_text ?></a>
						</div>
						<div class="list_of_variables_entry<?php echo $language['language_id'] ?> close_variable"><?php echo $list_of_variables_entry;?></div>
						</label>
						<div class="col-sm-10">
							<textarea name="order_status[<?php echo $language['language_id'] ?>][os_email_template]" id="os_email_template<?php echo $language['language_id'] ?>" cols="50" rows="3"><?php echo isset($order_status[$language['language_id']]) ? $order_status[$language['language_id']]['os_email_template'] : ''; ?></textarea>
						</div>
					</div>
				</div>
			<?php } ?>
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
$('#os_email_template<?php echo $language['language_id'] ?>').summernote({height: 300});
<?php } ?>
//--></script>
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
		
<?php echo $footer; ?>