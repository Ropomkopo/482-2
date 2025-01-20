<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<?php if (OC_V2) { ?>
		<div class="page-header">
		    <div class="container-fluid">
		      <div class="pull-right">
		        <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
		        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			  </div>
		      <h1><?php echo $heading_title; ?></h1>
		      <ul class="breadcrumb">
		        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
		        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		        <?php } ?>
		      </ul>
		    </div>
		  </div>
	<?php } else { ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php } ?>
	
 <div class="<?php if (OC_V2) echo 'container-fluid' ?>">
	<?php if (isset($success) && $success) { ?><div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><script type="text/javascript">setTimeout("$('.alert-success').slideUp();",5000);</script><?php } ?>
	<?php if (isset($info) && $info) { ?><div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $info; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><?php } ?>
	<?php if (isset($error) && $error) { ?><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><?php } ?>
    <?php if (isset($error_warning) && $error_warning) { ?><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><?php } ?>
<div class="<?php if(!OC_V2) echo 'box'; ?> panel panel-default">
  <div class="heading panel-heading">
    <h3 class="panel-title"><img style="vertical-align:top;padding-right:4px" src="view/seo_package/img/icon-big.png"/> <?php echo $heading_title; ?></h3>
    <div class="buttons"><a onclick="$('#form').submit();" class="button blue"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button red"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content panel-body">

      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="seopackage_sitemap_status">
                <?php if ($seopackage_sitemap_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_data_feed; ?></td>
            <td><a style="text-decoration:none;" href="<?php echo $data_feed; ?>" target="new"><?php echo $data_feed; ?></a></td>
          </tr>
		  <tr class="info">
			<td><i class='fa fa-info'></i></td>
			<td colspan="2" style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info'); ?></td>
		</tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>