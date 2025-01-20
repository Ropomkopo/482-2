<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-order-status').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-order-status">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
 
		<td class="left"><?php echo $column_select_bg_os; ?></td>
		<td class="left"><?php echo $column_select_color_text_os; ?></td>
		<td class="left"><?php echo $column_on_off_send_mail; ?></td>
		
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($order_statuses) { ?>
                <?php foreach ($order_statuses as $order_status) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($order_status['order_status_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order_status['order_status_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $order_status['name']; ?></td>
 
		<!--added--><td class="left"><input type="color" value="<?php echo $order_status['row_color']; ?>" name="colorbox" onChange="setOrderStatusColor(<?php echo $order_status['order_status_id']; ?>, this.value)" /></td>
		<!--added--><td class="left"><input type="color" value="<?php echo $order_status['row_color_text']; ?>" name="colorbox_text" onChange="setOrderStatusColorText(<?php echo $order_status['order_status_id']; ?>, this.value)" /></td>
		<!--added--><td class="left"><input type="checkbox" value="<?php echo $order_status['status_send_on_off']; ?>" <?php echo ($order_status['status_send_on_off'] == "Y" ? "checked" : "")?> onChange="sendMailThisStatusOnOff(<?php echo $order_status['order_status_id'] ?>, this.checked ? 'Y' : 'N');" /></td>
		
                  <td class="text-right"><a href="<?php echo $order_status['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="3"><?php echo $text_no_results; ?></td>
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
</div>
 
		<script type="text/javascript">
				function setOrderStatusColor(orderStatusId, rowColor) {
					$.ajax({
						url: 'index.php?route=localisation/order_status/setOrderStatusColor&token=<?php echo $token; ?>',
						type: 'post',
						data: '&order_status_id=' + orderStatusId + '&row_color=' + rowColor,
						dataType: 'json',
						beforeSend: function() {
							$('.success, .warning, .attention, .error').remove();
						},							
						success: function(json) {
							$('.success, .warning, .attention, .information, .error').remove();			
							if (json['error']) {
								$('.box').before('<div class="success" style="display: none;">' + json['error'] + '</div>');
								$('.warning').fadeIn('slow');				
							}	
				
						}
					});
				}
				function setOrderStatusColorText(orderStatusId, rowColorText) {
					$.ajax({
						url: 'index.php?route=localisation/order_status/setOrderStatusColorText&token=<?php echo $token; ?>',
						type: 'post',
						data: '&order_status_id=' + orderStatusId + '&row_color_text=' + rowColorText,
						dataType: 'json',
						beforeSend: function() {
							$('.success, .warning, .attention, .error').remove();
						},							
						success: function(json) {
							$('.success, .warning, .attention, .information, .error').remove();			
							if (json['error']) {
								$('.box').before('<div class="success" style="display: none;">' + json['error'] + '</div>');
								$('.warning').fadeIn('slow');				
							}	
				
						}
					});
				}
				function sendMailThisStatusOnOff(orderStatusId, status_send_on_off) {
					$.ajax({
						url: 'index.php?route=localisation/order_status/sendMailThisStatusOnOff&token=<?php echo $token; ?>',
						type: 'post',
						data: '&order_status_id=' + orderStatusId + '&status_send_on_off=' + status_send_on_off,
						dataType: 'json',
						beforeSend: function() {
							$('.success, .warning, .attention, .error').remove();
						},							
						success: function(json) {
							$('.success, .warning, .attention, .information, .error').remove();				
							if (json['success']) {				
							}	
							if (json['error']) {
								$('.box').before('<div class="success" style="display: none;">' + json['error'] + '</div>');
								$('.warning').fadeIn('slow');				
							}	
				
						}
					});
				}
		</script>		
		
<?php echo $footer; ?> 