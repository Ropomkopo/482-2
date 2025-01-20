<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
       <div class="pull-right">
      <div class="buttons">
	  <a class="btn btn-primary" onclick="$('#form').attr('action', '<?php echo $update; ?>'); $('#form').submit();" class="button"><span  data-toggle="tooltip" title="<?php echo $status_done; ?>" ><i class="fa fa-refresh"></i></span></a>
	  <a data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="$('form').submit();" class="button"><span><i class="fa fa-trash-o fa-fw"></i></span></a>
		<a class="button btn btn-primary" href="<?php echo $fastorder_setting ?>"><span><?php echo $button_fastorder_setting;?></span></a></div>
	</div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="alert alert-success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="content">
   
    <div class="container-fluid">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="table table-bordered table-hover">
          <thead>       
              <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="text-center"><?php if ($sort == 'fast_id') { ?>
                <a href="<?php echo $sort_fast_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $text_id; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_fast_id; ?>"><?php echo $text_id; ?></a>
                <?php } ?></td>
              <td class="center"><?php if ($sort == 'name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
             
			  <td class="text-center"><i class="fa fa-comments"></i><?php echo $text_comment_buyer; ?></td>
			  <td class="text-center"><?php echo $number_order_id; ?></td>
			  <td class="text-center"><?php echo $product_name_fast; ?></td>
			  <td class="text-center"><?php echo $text_total_all; ?></td>
			  <td class="text-center"><?php echo $text_newfastorder_url; ?></td>
			  <td class="text-center"><i class="fa fa-comments"></i><?php echo $text_comment; ?></td>
			  <td class="text-center"><?php if ($sort == 'username') { ?>
                <a href="<?php echo $sort_username; ?>" class="<?php echo strtolower($order); ?>"><?php echo $text_manager; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_username; ?>"><?php echo $text_manager; ?></a>
                <?php } ?></td>
			 
              <td class="text-center"><?php echo $text_status; ?></td>
              <td class="text-center"><?php echo $text_added; ?></td>
              <td class="text-center"><?php echo $text_modified; ?></td>
              <td class="text-center"><i class="btn btn-primary fa fa-pencil"></i></td>
            </tr>
			<tr>
				<td class="text-center"></td>
				<td class="text-center"></td>
				<td class="text-center"><input name="searh_info_user" class="form-control" value="<?php echo $searh_info_user;?>"/></td>
				<td class="text-center"></td>
				<td class="text-center"></td>
				<td class="text-center"></td>
				<td class="text-center"></td>
				<td class="text-center"><input name="filter_url" class="form-control" value="<?php echo $filter_url;?>"/></td>
				<td class="text-center"></td>
				<td class="text-center">
					<select class="form-control" name="filter_manager">
						<?php if (!empty($filter_manager)) { ?>
							<option value="" selected="selected"><?php echo " --- ";?></option>
						<?php } else { ?>
							<option value=""><?php echo " --- ";?></option>
						<?php } ?>	
											
					<?php foreach ($users as $user){?>
						<?php if (!empty($filter_manager)) { ?>
							<?php if ($filter_manager == $user['username'])?>
							<option selected="selected" value="<?php echo $user['username']?>"><?php echo $user['username']?></option>
						<?php } else { ?>
						<option value="<?php echo $user['username']?>"><?php echo $user['username']?></option>
						<?php } ?>
					<?php }?>					
					</select>
				</td>
				<td class="text-center">
				<select class="form-control" name="filter_status">
					<option value="" selected="selected"><?php echo " --- ";?></option>
					<option <?php if($filter_status == '1') { ?>selected="selected" <?php } ?> value="1"><?php echo $status_done;?></option>
					<option <?php if($filter_status == '0') { ?>selected="selected" <?php } ?>  value="0"><?php echo $status_wait;?></option>
				</select>
				</td>
				<td class="text-center">
					<div class="input-group date">
						<input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
						<span class="input-group-btn">
						<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
						</span>
					</div>
				</td>
				<td class="text-center">
					<div class="input-group date">
						<input type="text" name="filter_date_modified" value="<?php echo $filter_date_modified; ?>" data-date-format="YYYY-MM-DD" id="input-date-modified" class="form-control" />
						<span class="input-group-btn">
						<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
						</span>
					</div>
				</td>			
				<td class="text-center"><button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i></button></td>
			</tr>
          </thead>
          <tbody>
            <?php if ($newfastorders) { ?>
            <?php foreach ($newfastorders as $newfastorder) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($newfastorder['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $newfastorder['newfastorder_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $newfastorder['newfastorder_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $newfastorder['newfastorder_id']; ?></td>
              <td class="left" style="min-width:180px;">
				<div class="firstname"><i class="fa fa-user fa-fw"></i> <?php echo $newfastorder['name']; ?></div>
				<div class="telephone"><i class="fa fa-phone fa-fw"></i><?php echo $newfastorder['telephone']; ?></div>
				<?php if($newfastorder['email_buyer'] !='') { ?><div class="email"><i class="fa fa-envelope-o fa-fw"></i> <?php echo $newfastorder['email_buyer']; ?></div><?php } ?>
			  </td>            
              <td class="left"><?php echo utf8_substr(strip_tags($newfastorder['comment_buyer']),0,50); ?></td>
             
              
              <td class="center"><a href="index.php?route=sale/order/edit&token=<?php echo $token;?>&order_id=<?php echo $newfastorder['order_id']?>"><?php echo $text_number_order_id_;?><?php echo $newfastorder['order_id']; ?></a></td>
              <td class="left">
			  
				<?php foreach ($newfastorder['fastproduct'] as $result_prod){ ?>
					<div class="product_name"><a target="_blank" href="index.php?route=catalog/product/edit&token=<?php echo $token;?>&product_id=<?php echo $result_prod['product_id'];?>"><?php echo $result_prod['product_name'];?></a></div>
					<div class="product_model"><?php echo $result_prod['model'];?></div>
						<?php foreach ($result_prod['options'] as $res_option) { ?>
							<small>- <?php echo $res_option['name'];?>: <?php echo $res_option['value'];?></small><br>
						<?php } ?>
					<div><img style="max-height:50px;" src="<?php echo $result_prod['product_image']; ?>"/></div>
					
					<div class="price_fast"><?php echo $result_prod['price'];?> x <?php echo $result_prod['quantity'];?> = <?php echo $result_prod['total'];?></div>	
				<br>
				<?php } ?>
			  </td>
			 <style>
				.price_fast {
					display: block;
					min-width: 180px;
				}
				.product_model{
					font-weight:bold;
				}
			 </style>
				<td class="right" style="font-weight:bold;"><?php echo $newfastorder['total']; ?></td>
              <td class="text-center">
			   <span><a data-toggle="tooltip" title="<?php echo $text_link_description; ?>" class="btn btn-info" href="<?php echo $newfastorder['url_site']; ?>" target="_blank"><?php echo $text_link;?></a></span>
			  </td>
			  <td class="left"><?php echo utf8_substr(strip_tags($newfastorder['comment']),0,50); ?></td> 
			  <td class="right"><?php echo $newfastorder['username']; ?></td>
           <?php if ($newfastorder['status'] == $status_done) { ?>
              <td class="right" style="background:#0BED0B;"><?php echo $newfastorder['status']; ?></td>
            <?php } else { ?>
              <td class="right" style="background:#EDB40B;"><?php echo $newfastorder['status']; ?></td>
            <?php } ?>
              <td class="right"><?php echo $newfastorder['date_added']; ?></td>
             <td class="right"><?php echo $newfastorder['date_modified']; ?></td>
              <td class="text-right"><a href="<?php echo $newfastorder['action']; ?>" data-toggle="tooltip" title="<?php echo $text_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="text-center" colspan="9"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=sale/newfastorder&token=<?php echo $token; ?>';

	var searh_info_user = $('input[name=\'searh_info_user\']').val();

	if (searh_info_user) {
		url += '&searh_info_user=' + encodeURIComponent(searh_info_user);
	}
	var filter_url = $('input[name=\'filter_url\']').val();

	if (filter_url) {
		url += '&filter_url=' + encodeURIComponent(filter_url);
	}
	var filter_manager = $('select[name=\'filter_manager\']').val();

	if (filter_manager) {
		url += '&filter_manager=' + encodeURIComponent(filter_manager);
	}
	
	var filter_status = $('select[name=\'filter_status\']').val();

	if (filter_status) {
		url += '&filter_status=' + encodeURIComponent(filter_status);
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
$('input[name=\'searh_info_user\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/newfastorder/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['fast_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'searh_info_user\']').val(item['label']);
	}
});
//--></script>
<?php echo $footer; ?>
