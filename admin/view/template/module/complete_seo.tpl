<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<div id="modal-info" class="modal <?php if ($OC_V2) echo ' fade'; ?>" tabindex="-1" role="dialog" aria-hidden="true"></div>
	<?php if ($OC_V2) { ?>
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
	
  <div class="<?php if ($OC_V2) echo 'container-fluid' ?>">
	<?php if (isset($success) && $success) { ?><div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><script type="text/javascript">setTimeout("$('.alert-success').slideUp();",5000);</script><?php } ?>
	<?php if (isset($info) && $info) { ?><div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $info; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><?php } ?>
	<?php if (isset($error) && $error) { ?><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><?php } ?>
    <?php if (isset($error_warning) && $error_warning) { ?><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><?php } ?>
<div class="<?php if(!$OC_V2) echo 'box'; ?> panel panel-default">
  <div class="heading panel-heading">
    <h3 class="panel-title"><img style="vertical-align:top;padding-right:4px" src="view/seo_package/img/icon-big.png"/> <?php echo $heading_title; ?></h3>
    <div class="buttons"><a onclick="$('#form').submit();" class="button blue"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button red"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content panel-body">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-editor" data-toggle="tab"><i class="fa fa-edit"></i><?php echo $_language->get('tab_seo_editor'); ?></a></li>
			<li><a href="#tab-update" data-toggle="tab"><i class="fa fa-bolt"></i><?php echo $_language->get('tab_seo_update'); ?></a></li>
			<li><a href="#tab-general" data-toggle="tab"><i class="fa fa-wrench"></i><?php echo $_language->get('tab_seo_options'); ?></a></li>
			<li><a href="#tab-store" data-toggle="tab"><i class="fa fa-area-chart"></i><?php echo $_language->get('tab_seo_store'); ?></a></li>
			<li><a href="#tab-fpp" data-toggle="tab"><i class="fa fa-location-arrow"></i><?php echo $_language->get('tab_seo_fpp'); ?></a></li>
			<li><a href="#tab-snippet" data-toggle="tab"><i class="fa fa-thumbs-o-up"></i><?php echo $_language->get('tab_seo_snippets'); ?></a></li>
			<li><a href="#tab-cron" data-toggle="tab"><i class="fa fa-terminal"></i><?php echo $_language->get('tab_seo_cron'); ?></a></li>
			<li><a href="#tab-about" data-toggle="tab"><i class="fa fa-info"></i><?php echo $_language->get('tab_seo_about'); ?></a></li>
		</ul>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <input type="hidden" name="mlseo_enabled" value="1"/>
		<div class="tab-content">
		<div class="tab-pane active" id="tab-editor" style="position:relative;">
			<ul  id="tabs_editor_lang" class="nav nav-tabs" style="position:absolute; top:0; margin:0; <?php echo ($_language->get('direction')) == 'rtl' ? 'left:0;' : 'right:0;'; ?>">
				<?php $f=0; foreach ($languages as $language) { ?>
				<li class="pull-right <?php if(!$f) echo 'active'; $f = 1; ?>"><a href="#editorlang-<?php echo $language['language_id']; ?>" editor-lang="<?php echo $language['language_id']; ?>" editor-lang-code="<?php echo $language['code']; ?>" data-toggle="tab"><img src="<?php echo $language['image']; ?>" alt=""/></a></li>
				<?php } ?>
			</ul>
			<ul id="tabs_editor" class="nav nav-tabs">
				<?php $editor_types = array('product', 'category', 'information', 'manufacturer', 'image', 'common', 'special', 'redirect'); ?>
				<?php $f = 0; foreach ($editor_types as $type) { ?>
					<li <?php if(!$f) echo 'class="active"'; $f = 1; ?>><a href="#tab-editor-<?php echo $type; ?>" editor-type="<?php echo $type; ?>" data-toggle="tab"><?php echo $_language->get('tab_seo_editor_'.$type); ?></a></li>
				<?php } ?>
			</ul>
			<div class="tab-content">
			  <?php $f=0; foreach ($editor_types as $type) { ?>
				<div id="tab-editor-<?php echo $type; ?>" class="tab-pane<?php if(!$f) {echo ' active'; $f=1;} ?>">
					<table id="seo_editor_<?php echo $type; ?>" class="seo_editor table table-condensed table-hover table-striped table-curved" width="100%" cellspacing="0">
						<thead>
							<tr>
                <?php if($type == 'redirect') { ?>
									<th data-column="query"><?php echo $_language->get('text_editor_query_'.$type); ?></th>
									<th data-column="redirect"><?php echo $_language->get('text_editor_url_'.$type); ?></th>
									<th data-column="delete"></th>
								<?php } else if($type == 'image') { ?>
                  <th style="width:1px"></th>
									<th data-column="name"><?php echo $_language->get('text_editor_item_name'); ?></th>
									<th data-column="image"><?php echo $_language->get('text_editor_image_name'); ?></th>
									<th data-column="image_alt"><?php echo $_language->get('text_editor_image_alt'); ?></th>
									<th data-column="image_title"><?php echo $_language->get('text_editor_image_title'); ?></th>
								<?php } else if(in_array($type, array('common', 'special'))) { ?>
									<th data-column="query"><?php echo $_language->get('text_editor_query_'.$type); ?></th>
									<th data-column="keyword"><?php echo $_language->get('text_editor_url'); ?></th>
									<th data-column="delete"></th>
								<?php } else { ?>
									<?php if(in_array($type, array('product', 'category', 'manufacturer'))) { ?>
										<th style="width:1px"></th>
										<th data-column="name"><?php echo $_language->get('text_editor_name'); ?></th>
									<?php } ?>
									<?php if(in_array($type, array('information'))) { ?>
										<th data-column="title"><?php echo $_language->get('text_editor_title'); ?></th>
									<?php } ?>
									<th data-column="seo_keyword"  style="width:25%"><?php echo $_language->get('text_editor_url'); ?></th>
									<?php if(!in_array($type, array('manufacturer'))) { ?>
										<th data-column="meta_title"><?php echo $_language->get('text_editor_meta_title'); ?></th>
										<th data-column="meta_keyword"><?php echo $_language->get('text_editor_meta_keyword'); ?></th>
										<th data-column="meta_description"><?php echo $_language->get('text_editor_meta_description'); ?></th>
									<?php } ?>
									<?php if(in_array($type, array('product')) && $OC_VERSION > 153) { ?>
										<th data-column="tag"><?php echo $_language->get('text_editor_tag'); ?></th>
									<?php } ?>
                  <?php if(in_array($type, array('product'))) { ?>
										<th data-column="related"><?php echo $_language->get('text_editor_related'); ?></th>
									<?php } ?>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<tr><td style="height:200px"></td></tr>
						</tbody>
					</table>
          <?php if($type == 'redirect') { ?>
					<div class="btn-group more_actions">
					  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#newAliasModal"><i class="fa fa-plus"></i> <?php echo $_language->get('text_seo_add_url'); ?></button>
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
					  <ul class="dropdown-menu" role="menu">
						<li><a data-toggle="modal" data-target="#newAliasModal"><i class="fa fa-plus"></i> <?php echo $_language->get('text_seo_add_url'); ?></a></li>
					  <?php if($type == 'common') { ?>
						<li data-toggle="tooltip" data-placement="right" title="<?php echo $_language->get('text_seo_reset_urls_tooltip'); ?>"><a class="restoreAliases"><i class="fa fa-magic"></i> <?php echo $_language->get('text_seo_reset_urls'); ?></a></li>
						<li data-toggle="tooltip" data-placement="right" title="<?php echo $_language->get('text_seo_export_urls_tooltip'); ?>"><a class="exportAliases"><i class="fa fa-save"></i> <?php echo $_language->get('text_seo_export_urls'); ?></a></li>
					  <?php } ?>
						<li><a class="deleteAliases"><i class="fa fa-close"></i> <?php echo $_language->get('text_seo_remove_urls'); ?></a></li>
					  </ul>
					</div>
					<?php } else if(in_array($type, array('common', 'special'))) { ?>
					<div class="btn-group more_actions">
					  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#newAliasModal"><i class="fa fa-plus"></i> <?php echo $_language->get('text_seo_add_url'); ?></button>
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
					  <ul class="dropdown-menu" role="menu">
						<li><a data-toggle="modal" data-target="#newAliasModal"><i class="fa fa-plus"></i> <?php echo $_language->get('text_seo_add_url'); ?></a></li>
					  <?php if($type == 'common') { ?>
						<li data-toggle="tooltip" data-placement="right" title="<?php echo $_language->get('text_seo_reset_urls_tooltip'); ?>"><a class="restoreAliases"><i class="fa fa-magic"></i> <?php echo $_language->get('text_seo_reset_urls'); ?></a></li>
						<li data-toggle="tooltip" data-placement="right" title="<?php echo $_language->get('text_seo_export_urls_tooltip'); ?>"><a class="exportAliases"><i class="fa fa-save"></i> <?php echo $_language->get('text_seo_export_urls'); ?></a></li>
					  <?php } ?>
						<li><a class="deleteAliases"><i class="fa fa-close"></i> <?php echo $_language->get('text_seo_remove_urls'); ?></a></li>
					  </ul>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="tab-pane" id="tab-general">
			<ul class="nav nav-pills nav-stacked col-md-2">
				<li class="active"><a href="#tab-general-1" data-toggle="pill"><i class="fa fa-cog"></i> <?php echo $_language->get('text_seo_tab_general_1'); ?></a></li>
				<li><a href="#tab-general-2" data-toggle="pill"><i class="fa fa-globe"></i> <?php echo $_language->get('text_seo_tab_general_2'); ?></a></li>
				<li><a href="#tab-general-9" data-toggle="pill"><i class="fa fa-sitemap"></i> <?php echo $_language->get('text_seo_tab_general_9'); ?></a></li>
				<li><a href="#tab-general-3" data-toggle="pill"><i class="fa fa-flag"></i> <?php echo $_language->get('text_seo_tab_general_3'); ?></a></li>
				<li><a href="#tab-general-6" data-toggle="pill"><i class="fa fa-file-o"></i> <?php echo $_language->get('text_seo_tab_general_6'); ?></a></li>
				<li><a href="#tab-general-4" data-toggle="pill"><i class="fa fa-edit"></i> <?php echo $_language->get('text_seo_tab_general_4'); ?></a></li>
				<li><a href="#tab-general-8" data-toggle="pill"><i class="fa fa-code-fork"></i> <?php echo $_language->get('text_seo_tab_general_8'); ?></a></li>
				<li><a href="#tab-general-10" data-toggle="pill"><i class="fa fa-comments-o"></i> <?php echo $_language->get('text_seo_tab_general_10'); ?></a></li>
				<li><a href="#tab-general-7" data-toggle="pill"><i class="fa fa-bolt"></i> <?php echo $_language->get('text_seo_tab_general_7'); ?></a></li>
				<li><a href="#tab-general-5" data-toggle="pill"><i class="fa fa-magic"></i> <?php echo $_language->get('text_seo_tab_general_5'); ?></a></li>
			</ul>
			<div class="tab-content col-md-10">
				<div class="tab-pane active" id="tab-general-1">
			<table class="form">
				<tr>
					<td><?php echo $_language->get('text_seo_friendly'); ?></td>
					<td><input class="switch" type="checkbox" id="mlseo_friendly" name="mlseo_friendly" value="1" <?php if($mlseo_friendly) echo 'checked="checked"'; ?> /></td>
					<td></td>
				</tr>
				<tr>
					<td style="width:250px;"><?php echo $_language->get('text_seo_absolute'); ?></td>
					<td style="width:120px;"><input class="switch" type="checkbox" id="mlseo_absolute" name="mlseo_absolute" value="1" <?php if($mlseo_absolute) echo 'checked="checked"'; ?> /></td>
					<td></td>
				</tr>
				<tr>
						<td><?php echo $_language->get('text_seo_redirect_dynamic'); ?></td>
						  <td><input class="switch" type="checkbox" id="mlseo_redirect_dynamic" name="mlseo_redirect_dynamic" value="1" <?php if($mlseo_redirect_dynamic) echo 'checked="checked"'; ?> /></td>
						  <td></td>
						</tr>
						<tr>
					<td><?php echo $_language->get('text_seo_cat_slash'); ?></td>
					<td><input class="switch" type="checkbox" id="mlseo_cat_slash" name="mlseo_cat_slash" value="1" <?php if($mlseo_cat_slash) echo 'checked="checked"'; ?> /></td>
					<td></td>
				</tr>
        <tr>
						  <td><?php echo $_language->get('text_seo_banner'); ?></td>
									<td><input class="switch" type="checkbox" id="mlseo_banners" name="mlseo_banners" value="1" <?php if($mlseo_banners) echo 'checked="checked"'; ?> /></td>
						  <td><span class="help"><?php echo $_language->get('text_seo_banner_help'); ?></span></td>
						</tr>
						<tr class="info">
							<td><i class='fa fa-info'></i></td>
							<td colspan="2" style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_general'); ?></td>
						</tr>
					  </table>
				</div>
				<div class="tab-pane" id="tab-general-2">
					<table class="form">
            <tr>
              <td><?php echo $_language->get('text_seo_flag'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_flag" name="mlseo_flag" value="1" <?php if($mlseo_flag) echo 'checked="checked"'; ?> /></td>
              <td></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_flag_short'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_flag_short" name="mlseo_flag_short" value="1" <?php if($mlseo_flag_short) echo 'checked="checked"'; ?> /></td>
              <td></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_flag_default'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_flag_default" name="mlseo_flag_default" value="1" <?php if($mlseo_flag_default) echo 'checked="checked"'; ?> /></td>
              <td></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_flag_upper'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_flag_upper" name="mlseo_flag_upper" value="1" <?php if($mlseo_flag_upper) echo 'checked="checked"'; ?> /></td>
              <td></td>
            </tr>
            <tr class="info">
              <td><i class='fa fa-info'></i></td>
              <td colspan="2" style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_general_2'); ?></td>
            </tr>
          </table>
				</div>
        <div class="tab-pane" id="tab-general-9">
					<table class="form">
						<tr>
              <td><?php echo $_language->get('text_seo_substore'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_store_mode" name="mlseo_store_mode" value="1" <?php if($mlseo_store_mode) echo 'checked="checked"'; ?> /></td>
              <td></td>
            </tr>
						<tr class="info">
							<td><i class='fa fa-info'></i></td>
							<td colspan="2" style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_general_9'); ?></td>
            </tr>
          </table>
				</div>
				<div class="tab-pane" id="tab-general-3">
					<table class="form">
		<tr>
							<td><?php echo $_language->get('text_seo_hreflang'); ?></td>
							<td><input class="switch" type="checkbox" id="mlseo_hreflang" name="mlseo_hreflang" value="1" <?php if($mlseo_hreflang) echo 'checked="checked"'; ?> /></td>
          <td></td>
        </tr>
				<tr class="info">
			  <td><i class='fa fa-info'></i></td>
							<td colspan="2" style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_general_3'); ?></td>
        </tr>
      </table>
		</div>
    <div class="tab-pane" id="tab-general-6">
					<table class="form">
            <tr>
							<td><?php echo $_language->get('text_seo_pagination'); ?></td>
							<td><input class="switch" type="checkbox" id="mlseo_pagination" name="mlseo_pagination" value="1" <?php if($mlseo_pagination) echo 'checked="checked"'; ?> /></td>
          <td></td>
        </tr>
        <?php if ($OC_V2) { ?>
        <tr>
          <td><?php echo $_language->get('text_seo_pagination_fix'); ?></td>
          <td><input class="switch" type="checkbox" id="mlseo_pagination_fix" name="mlseo_pagination_fix" value="1" <?php if($mlseo_pagination_fix) echo 'checked="checked"'; ?> /></td>
          <td></td>
        </tr>
        <?php } ?>
				<tr class="info">
			  <td><i class='fa fa-info'></i></td>
							<td colspan="2" style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_general_6'); ?></td>
        </tr>
      </table>
		</div>
				<div class="tab-pane" id="tab-general-4">
        <table class="form">
				<tr>
          <td style="width:250px;"><?php echo $_language->get('text_seo_whitespace'); ?></td>
          <td><input class="form-control" type="text" name="mlseo_whitespace" value="<?php echo $mlseo_whitespace; ?>" size="1" /></td>
        </tr>
        <tr>
			<td><?php echo $_language->get('text_seo_extension'); ?></td>
			<td><input class="form-control" type="text" name="mlseo_extension" value="<?php echo $mlseo_extension; ?>" size="7" placeholder=".html"/></td>
		</tr>
        <tr>
          <td><?php echo $_language->get('text_seo_lowercase'); ?></td>
						<td><input class="switch" type="checkbox" id="mlseo_lowercase" name="mlseo_lowercase" value="1" <?php if($mlseo_lowercase) echo 'checked="checked"'; ?> /></td>
        </tr>
				<tr>
          <td><?php echo $_language->get('text_seo_duplicate'); ?></td>
						<td><input class="switch" type="checkbox" id="mlseo_duplicate" name="mlseo_duplicate" value="1" <?php if($mlseo_duplicate) echo 'checked="checked"'; ?> /></td>
        </tr>
				<tr>
          <td><?php echo $_language->get('text_seo_ascii'); ?></td>
						<td class="imgCheckbox">
							<?php foreach ($languages as $language) { ?>
              <img style="position:relative; bottom:12px; left:50px;" src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <input type="checkbox" class="checkable" value="1" data-label="<?php echo $language['name']; ?>" id="mlseo_ascii_<?php echo $language['language_id']; ?>" name="mlseo_ascii_<?php echo $language['language_id']; ?>" <?php if ($_config->get('mlseo_ascii_'.$language['language_id'])) echo 'checked="checked"'; ?>/> <br />
              <?php } ?>
						</td>
        </tr>
        <tr class="info">
			  <td><i class='fa fa-info'></i></td>
          <td style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_transform'); ?></td>
        </tr>
		  </table>
		  </td>
        </tr>
        </div>
				<div class="tab-pane" id="tab-general-5">
       <table class="form">
        <tr>
          <td><?php echo $_language->get('text_seo_autofill_desc'); ?></td>
			<td>
			<table class="form">
				<tr>
					<td><?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_url'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
					<td class="multiple_switch">
					<div>
						<span><?php echo $_language->get('text_insert'); ?></span>
						<input class="switch" type="checkbox" id="mlseo_insertautourl" name="mlseo_insertautourl" value="1" <?php if($mlseo_insertautourl) echo 'checked="checked"'; ?> />
					</div>
					<div>
						<span><?php echo $_language->get('text_edit'); ?></span>
						<input class="switch" type="checkbox" id="mlseo_editautourl" name="mlseo_editautourl" value="1" <?php if($mlseo_editautourl) echo 'checked="checked"'; ?> />
					</div>
				  </td>
			  </tr>
			  <tr>
					<td><?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_title'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
					<td class="multiple_switch">
					<div>
						<span><?php echo $_language->get('text_insert'); ?></span>
						<input class="switch" type="checkbox" id="mlseo_insertautoseotitle" name="mlseo_insertautoseotitle" value="1" <?php if($mlseo_insertautoseotitle) echo 'checked="checked"'; ?> />
					</div>
					<div>
						<span><?php echo $_language->get('text_edit'); ?></span>
						<input class="switch" type="checkbox" id="mlseo_editautoseotitle" name="mlseo_editautoseotitle" value="1" <?php if($mlseo_editautoseotitle) echo 'checked="checked"'; ?> />
					</div>
				  </td>
			  </tr>
			  <tr>
					<td><?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_keyword'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
					<td class="multiple_switch">
					<div>
						<span><?php echo $_language->get('text_insert'); ?></span>
						<input class="switch" type="checkbox" id="mlseo_insertautometakeyword" name="mlseo_insertautometakeyword" value="1" <?php if($mlseo_insertautometakeyword) echo 'checked="checked"'; ?> />
					</div>
					<div>
						<span><?php echo $_language->get('text_edit'); ?></span>
						<input class="switch" type="checkbox" id="mlseo_editautometakeyword" name="mlseo_editautometakeyword" value="1" <?php if($mlseo_editautometakeyword) echo 'checked="checked"'; ?> />
					</div>
				  </td>
			  </tr>
			  <tr>
					<td><?php echo $_language->get('text_seo_autofill'); ?> <?php echo $_language->get('text_seo_mode_description'); ?> <?php echo $_language->get('text_seo_autofill_on'); ?></td>
					<td class="multiple_switch">
					<div>
						<span><?php echo $_language->get('text_insert'); ?></span>
						<input class="switch" type="checkbox" id="mlseo_insertautometadesc" name="mlseo_insertautometadesc" value="1" <?php if($mlseo_insertautometadesc) echo 'checked="checked"'; ?> />
					</div>
					<div>
						<span><?php echo $_language->get('text_edit'); ?></span>
						<input class="switch" type="checkbox" id="mlseo_editautometadesc" name="mlseo_editautometadesc" value="1" <?php if($mlseo_editautometadesc) echo 'checked="checked"'; ?> />
					</div>
				  </td>
			  </tr>
		  </table>
		  </td>
        </tr>
        <tr>
          <td><?php echo $_language->get('text_seo_autotitle'); ?></td>
			<td class="multiple_switch">
            <div>
				<span> <?php echo $_language->get('text_insert'); ?></span>
				<input class="switch" type="checkbox" id="mlseo_insertautotitle" name="mlseo_insertautotitle" value="1" <?php if($mlseo_insertautotitle) echo 'checked="checked"'; ?> />
			</div>
			<div>
				<span><?php echo $_language->get('text_edit'); ?></span>
				<input class="switch" type="checkbox" id="mlseo_editautotitle" name="mlseo_editautotitle" value="1" <?php if($mlseo_editautotitle) echo 'checked="checked"'; ?> />
			</div>
          </td>
        </tr>
			</table>
        </div>
        <div class="tab-pane" id="tab-general-7">
          <table class="form">
            <tr>
						  <td><?php echo $_language->get('text_seo_urlcache'); ?></td>
						  <td><input class="switch" type="checkbox" id="mlseo_cache" name="mlseo_cache" value="1" <?php if($mlseo_cache) echo 'checked="checked"'; ?> /></td>
						  <td></td>
						</tr>
            <tr class="info">
              <td><i class='fa fa-info'></i></td>
							<td colspan="2" style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_general_7'); ?></td>
            </tr>
          </table>
        </div>
        <div class="tab-pane" id="tab-general-8">
					<table class="form">
            <tr>
              <td><?php echo $_language->get('text_seo_canonical'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_canonical" name="mlseo_canonical" value="1" <?php if($mlseo_canonical) echo 'checked="checked"'; ?> /></td>
              <td></td>
            </tr>
            <tr class="info">
              <td><i class='fa fa-info'></i></td>
							<td colspan="2" style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_general_8'); ?></td>
            </tr>
          </table>
        </div>
         <div class="tab-pane" id="tab-general-10">
					<table class="form">
            <tr>
              <td><?php echo $_language->get('text_seo_reviews'); ?></td>
              <td>
                <select class="form-control" name="mlseo_reviews">
                  <option value=""><?php echo $_language->get('text_disabled'); ?></option>
                  <option value="5" <?php if($mlseo_reviews == '5') echo 'selected="selected"'; ?>>5</option>
                  <option value="10" <?php if($mlseo_reviews == '10') echo 'selected="selected"'; ?>>10</option>
                  <option value="25" <?php if($mlseo_reviews == '25') echo 'selected="selected"'; ?>>25</option>
                  <option value="50" <?php if($mlseo_reviews == '50') echo 'selected="selected"'; ?>>50</option>
                  <option value="999" <?php if($mlseo_reviews == '999') echo 'selected="selected"'; ?>><?php echo $_language->get('text_all'); ?></option>
                </select>
              <!--input class="switch" type="checkbox" id="mlseo_reviews" name="mlseo_reviews" value="1" <?php if($mlseo_reviews) echo 'checked="checked"'; ?> /-->
              </td>
              <td></td>
            </tr>
            <tr class="info">
              <td><i class='fa fa-info'></i></td>
							<td colspan="2" style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_general_10'); ?></td>
            </tr>
          </table>
        </div>
        </div>
				<div style="clear:both"></div>
		</div>
		<div class="tab-pane" id="tab-store">
			<ul class="nav nav-pills nav-stacked col-md-2" id="stores">
			  <?php $first=0; foreach ($stores as $store) { ?>
				  <li<?php if(!$first) { echo ' class="active"'; $first=1;} ?>><a href="#tab-store-<?php echo $store['store_id']; ?>" data-toggle="pill"><?php echo $store['name']; ?></a></li>
			  <?php } ?>
			  </ul>
			<div class="tab-content col-md-10">
			<?php $first=0; foreach ($stores as $store) { ?>
			<div id="tab-store-<?php echo $store['store_id']; ?>" class="tab-pane<?php if(!$first) { echo ' active'; $first=1;} ?>">
			  <ul id="language-<?php echo $store['store_id']; ?>" class="nav nav-tabs">
				<?php $first=0; foreach ($languages as $language) { ?>
				<li<?php if(!$first) { echo ' class="active"'; $first=1;} ?>><a href="#tab-language-<?php echo $store['store_id']; ?>-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo $language['image']; ?>" alt=""/> <?php echo $language['name']; ?></a></li>
				<?php } ?>
			  </ul>
				<div class="tab-content">
			  <?php $first=0; foreach ($languages as $language) { ?>
			  <div id="tab-language-<?php echo $store['store_id']; ?>-<?php echo $language['language_id']; ?>" class="tab-pane<?php if(!$first) { echo ' active'; $first=1;} ?>">
				<table class="form">
				 <tr>
					<td><?php echo $_language->get('entry_store_seo_title'); ?></td>
					<td><input type="text" class="form-control" name="mlseo_store[<?php echo $store['store_id'] . $language['language_id']; ?>][seo_title]" value="<?php echo isset($mlseo_store[$store['store_id'].$language['language_id']]['seo_title']) ? $mlseo_store[$store['store_id'].$language['language_id']]['seo_title'] : ''; ?>" size="63"/></td>
				 </tr>
				 <tr>
					<td><?php echo $_language->get('entry_store_title'); ?></td>
					<td><input type="text" class="form-control" name="mlseo_store[<?php echo $store['store_id'] . $language['language_id']; ?>][title]" value="<?php echo isset($mlseo_store[$store['store_id'].$language['language_id']]['title']) ? $mlseo_store[$store['store_id'].$language['language_id']]['title'] : ''; ?>" size="63"/></td>
				 </tr>
         <tr>
					<td><?php echo $_language->get('entry_store_h2'); ?></td>
					<td><input type="text" class="form-control" name="mlseo_store[<?php echo $store['store_id'] . $language['language_id']; ?>][h2]" value="<?php echo isset($mlseo_store[$store['store_id'].$language['language_id']]['h2']) ? $mlseo_store[$store['store_id'].$language['language_id']]['h2'] : ''; ?>" size="63"/></td>
				 </tr>
         <tr>
					<td><?php echo $_language->get('entry_store_h3'); ?></td>
					<td><input type="text" class="form-control" name="mlseo_store[<?php echo $store['store_id'] . $language['language_id']; ?>][h3]" value="<?php echo isset($mlseo_store[$store['store_id'].$language['language_id']]['h3']) ? $mlseo_store[$store['store_id'].$language['language_id']]['h3'] : ''; ?>" size="63"/></td>
				 </tr>
				 <tr>
					<td><?php echo $_language->get('entry_store_desc'); ?></td>
					<td><textarea class="form-control" name="mlseo_store[<?php echo $store['store_id'] . $language['language_id']; ?>][description]" cols="60" rows="6"><?php echo isset($mlseo_store[$store['store_id'].$language['language_id']]['description']) ? $mlseo_store[$store['store_id'].$language['language_id']]['description'] : ''; ?></textarea></td>
				  </tr>
				   <tr>
					<td><?php echo $_language->get('entry_store_keywords'); ?></td>
					<td><textarea class="form-control" name="mlseo_store[<?php echo $store['store_id'] . $language['language_id']; ?>][keywords]" cols="60" rows="6"><?php echo isset($mlseo_store[$store['store_id'].$language['language_id']]['keywords']) ? $mlseo_store[$store['store_id'].$language['language_id']]['keywords'] : ''; ?></textarea></td>
				  </tr>
				</table>
			  </div>
			  <?php } ?>
			</div>
			</div>
			<?php } ?>
			</div>
			<table class="form" style="clear:both">
				<tr class="info">
			  <td><i class='fa fa-info'></i></td>
			  <td><?php echo $_language->get('text_info_store'); ?></td>
			</tr>
		</table>
		</div>
		<div class="tab-pane" id="tab-snippet">
      <ul class="nav nav-pills nav-stacked col-md-2">
				<li class="active"><a href="#tab-snippet-1" data-toggle="pill"><i class="fa fa-google"></i> <?php echo $_language->get('text_seo_tab_snippet_1'); ?></a></li>
				<li><a href="#tab-snippet-4" data-toggle="pill"><i class="fa fa-google"></i> <?php echo $_language->get('text_seo_tab_snippet_4'); ?></a></li>
				<li><a href="#tab-snippet-2" data-toggle="pill"><i class="fa fa-facebook-square"></i> <?php echo $_language->get('text_seo_tab_snippet_2'); ?></a></li>
				<li><a href="#tab-snippet-3" data-toggle="pill"><i class="fa fa-twitter"></i> <?php echo $_language->get('text_seo_tab_snippet_3'); ?></a></li>
			</ul>
			<div class="tab-content col-md-10">
				<div class="tab-pane active" id="tab-snippet-1">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('entry_enable_microdata'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_microdata" name="mlseo_microdata" value="1" <?php if($mlseo_microdata) echo 'checked="checked"'; ?> /></td>
            </tr>
          </table>
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-microdata-1" data-toggle="tab"><?php echo $_language->get('tab_microdata_1'); ?></a></li>
            <li><a href="#tab-microdata-2" data-toggle="tab"><?php echo $_language->get('tab_microdata_2'); ?></a></li>
            <li><a href="#tab-microdata-3" data-toggle="tab"><?php echo $_language->get('tab_microdata_3'); ?></a></li>
            <li><a href="#tab-microdata-4" data-toggle="tab"><?php echo $_language->get('tab_microdata_4'); ?></a></li>
            <li><a href="#tab-microdata-5" data-toggle="tab"><?php echo $_language->get('tab_microdata_5'); ?></a></li>
            <li><a href="#tab-microdata-6" data-toggle="tab"><?php echo $_language->get('tab_microdata_6'); ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-microdata-1">
              <table class="form">
                <tr>
                  <td><?php echo $_language->get('text_enabled'); ?></td>
                  <td><input class="switch" type="checkbox" id="mlseo_microdata_data_product" name="mlseo_microdata_data[product]" value="1" <?php if(!empty($mlseo_microdata_data['product'])) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_snippet_data'); ?></td>
                  <td>
                    <input class="checkable" data-label="<?php echo $_language->get('entry_model'); ?>" type="checkbox" id="mlseo_microdata_data_model" name="mlseo_microdata_data[model]" value="1" <?php if(!empty($mlseo_microdata_data['model'])) echo 'checked="checked"'; ?> /><br />
                    <input class="checkable" data-label="<?php echo $_language->get('entry_description'); ?>" type="checkbox" id="mlseo_microdata_data_desc" name="mlseo_microdata_data[desc]" value="1" <?php if(!empty($mlseo_microdata_data['desc'])) echo 'checked="checked"'; ?> /><br />
                    <input class="checkable" data-label="<?php echo $_language->get('entry_manufacturer'); ?>" type="checkbox" id="mlseo_microdata_brand" name="mlseo_microdata_data[brand]" value="1" <?php if(!empty($mlseo_microdata_data['brand'])) echo 'checked="checked"'; ?> /><br />
                    <input class="checkable" data-label="<?php echo $_language->get('entry_reviews'); ?>" type="checkbox" id="mlseo_microdata_reviews" name="mlseo_microdata_data[reviews]" value="1" <?php if(!empty($mlseo_microdata_data['reviews'])) echo 'checked="checked"'; ?> /><br />
                    <!--<input class="checkable" data-label="<?php echo $_language->get('entry_rating'); ?>" type="checkbox" id="mlseo_microdata_rating" name="mlseo_microdata_data[rating]" value="1" <?php if(!empty($mlseo_microdata_data['rating'])) echo 'checked="checked"'; ?> />-->
                  </td>
                </tr>
              </table>
            </div>
            <div class="tab-pane" id="tab-microdata-2">
              <table class="form">
                <tr>
                  <td><?php echo $_language->get('text_enabled'); ?></td>
                  <td><input class="switch" type="checkbox" id="mlseo_microdata_data_organization" name="mlseo_microdata_data[organization]" value="1" <?php if(!empty($mlseo_microdata_data['organization'])) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_snippet_data'); ?></td>
                  <td>
                    <input class="checkable" data-label="<?php echo $_language->get('entry_microdata_search'); ?>" type="checkbox" id="mlseo_microdata_data_org_search" name="mlseo_microdata_data[organization_search]" value="1" <?php if(!empty($mlseo_microdata_data['organization_search'])) echo 'checked="checked"'; ?> /><br />
                  </td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_snippet_contact'); ?></td>
                  <td>
                    <div class="input-group" style="width:100%">
                      <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                      <input style="width:60%" type="text" class="form-control" placeholder="<?php echo $_language->get('entry_phone'); ?>" name="mlseo_microdata_data[contact][0][phone]" value="<?php if(!empty($mlseo_microdata_data['contact'][0]['phone'])) echo $mlseo_microdata_data['contact'][0]['phone']; ?>" />
                      <select class="form-control" name="mlseo_microdata_data[contact][0][type]" style="width:40%">
                        <?php foreach (array('customer support', 'technical support', 'billing support', 'bill payment', 'sales', 'reservations', 'credit card support', 'emergency', 'baggage tracking', 'roadside assistance', 'package tracking') as $mdc_type) { ?>
                        <option value="<?php echo $mdc_type; ?>" <?php if(!empty($mlseo_microdata_data['contact'][0]['type']) && $mlseo_microdata_data['contact'][0]['type'] == $mdc_type) echo 'selected="selected"'; ?>><?php echo ucfirst($mdc_type); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="input-group" style="width:100%; margin-top:10px;">
                      <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                      <input style="width:60%" type="text" class="form-control" placeholder="<?php echo $_language->get('entry_phone'); ?>" name="mlseo_microdata_data[contact][1][phone]" value="<?php if(!empty($mlseo_microdata_data['contact'][1]['phone'])) echo $mlseo_microdata_data['contact'][0]['phone']; ?>" />
                      <select class="form-control" name="mlseo_microdata_data[contact][1][type]" style="width:40%">
                        <?php foreach (array('customer support', 'technical support', 'billing support', 'bill payment', 'sales', 'reservations', 'credit card support', 'emergency', 'baggage tracking', 'roadside assistance', 'package tracking') as $mdc_type) { ?>
                        <option value="<?php echo $mdc_type; ?>" <?php if(!empty($mlseo_microdata_data['contact'][1]['type']) && $mlseo_microdata_data['contact'][1]['type'] == $mdc_type) echo 'selected="selected"'; ?>><?php echo ucfirst($mdc_type); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="input-group" style="width:100%; margin-top:10px;">
                      <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                      <input style="width:60%" type="text" class="form-control" placeholder="<?php echo $_language->get('entry_phone'); ?>" name="mlseo_microdata_data[contact][2][phone]" value="<?php if(!empty($mlseo_microdata_data['contact'][2]['phone'])) echo $mlseo_microdata_data['contact'][0]['phone']; ?>" />
                      <select class="form-control" name="mlseo_microdata_data[contact][2][type]" style="width:40%">
                        <?php foreach (array('customer support', 'technical support', 'billing support', 'bill payment', 'sales', 'reservations', 'credit card support', 'emergency', 'baggage tracking', 'roadside assistance', 'package tracking') as $mdc_type) { ?>
                        <option value="<?php echo $mdc_type; ?>" <?php if(!empty($mlseo_microdata_data['contact'][2]['type']) && $mlseo_microdata_data['contact'][2]['type'] == $mdc_type) echo 'selected="selected"'; ?>><?php echo ucfirst($mdc_type); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div class="tab-pane" id="tab-microdata-3">
              <table class="form">
                <tr>
                  <td><?php echo $_language->get('text_enabled'); ?></td>
                  <td><input class="switch" type="checkbox" id="mlseo_microdata_data_store" name="mlseo_microdata_data[store]" value="1" <?php if(!empty($mlseo_microdata_data['store'])) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_snippet_data'); ?></td>
                  <td>
                    <input class="checkable" data-label="<?php echo $_language->get('entry_microdata_logo'); ?>" type="checkbox" id="mlseo_microdata_data_store_logo" name="mlseo_microdata_data[store_logo]" value="1" <?php if(!empty($mlseo_microdata_data['store_logo'])) echo 'checked="checked"'; ?> /><br />
                    <input class="checkable" data-label="<?php echo $_language->get('entry_email'); ?>" type="checkbox" id="mlseo_microdata_data_store_mail" name="mlseo_microdata_data[store_mail]" value="1" <?php if(!empty($mlseo_microdata_data['store_mail'])) echo 'checked="checked"'; ?> /><br />
                    <input class="checkable" data-label="<?php echo $_language->get('entry_phone'); ?>" type="checkbox" id="mlseo_microdata_data_store_phone" name="mlseo_microdata_data[store_phone]" value="1" <?php if(!empty($mlseo_microdata_data['store_phone'])) echo 'checked="checked"'; ?> /><br />
                    <input class="checkable" data-label="<?php echo $_language->get('entry_microdata_address'); ?>" type="checkbox" id="mlseo_microdata_data_address" name="mlseo_microdata_data[address]" value="1" <?php if(!empty($mlseo_microdata_data['address'])) echo 'checked="checked"'; ?> /><br />
                  </td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_microdata_address'); ?></td>
                  <td>
                    <input type="text" class="form-control" placeholder="<?php echo $_language->get('entry_address_street'); ?>" name="mlseo_microdata_data[address_street]" value="<?php if(!empty($mlseo_microdata_data['address_street'])) echo $mlseo_microdata_data['address_street']; ?>" />
                    <input type="text" style="margin-top:10px;" class="form-control" placeholder="<?php echo $_language->get('entry_address_city'); ?>" name="mlseo_microdata_data[address_city]" value="<?php if(!empty($mlseo_microdata_data['address_city'])) echo $mlseo_microdata_data['address_city']; ?>" />
                    <input type="text" style="margin-top:10px;" class="form-control" placeholder="<?php echo $_language->get('entry_address_region'); ?>" name="mlseo_microdata_data[address_region]" value="<?php if(!empty($mlseo_microdata_data['address_region'])) echo $mlseo_microdata_data['address_region']; ?>" />
                    <input type="text" style="margin-top:10px;" class="form-control" placeholder="<?php echo $_language->get('entry_address_code'); ?>" name="mlseo_microdata_data[address_code]" value="<?php if(!empty($mlseo_microdata_data['address_code'])) echo $mlseo_microdata_data['address_code']; ?>" />
                    <input type="text" style="margin-top:10px;" class="form-control" placeholder="<?php echo $_language->get('entry_address_country'); ?>" name="mlseo_microdata_data[address_country]" value="<?php if(!empty($mlseo_microdata_data['address_country'])) echo $mlseo_microdata_data['address_country']; ?>" />
                  </td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_snippet_same_as'); ?></td>
                  <td>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-link"></i></span>
                      <input type="text" class="form-control" placeholder="https://twitter.com/MyStore" name="mlseo_microdata_data[same_as][0]" value="<?php if(!empty($mlseo_microdata_data['same_as'][0])) echo $mlseo_microdata_data['same_as'][0]; ?>" />
                    </div>
                    <div class="input-group" style="margin-top:10px">
                      <span class="input-group-addon"><i class="fa fa-link"></i></span>
                      <input type="text" class="form-control" placeholder="https://www.pinterest.com/MyStore" name="mlseo_microdata_data[same_as][1]" value="<?php if(!empty($mlseo_microdata_data['same_as'][1])) echo $mlseo_microdata_data['same_as'][1]; ?>" />
                    </div>
                    <div class="input-group" style="margin-top:10px">
                      <span class="input-group-addon"><i class="fa fa-link"></i></span>
                      <input type="text" class="form-control" placeholder="https://www.facebook.com/MyStore" name="mlseo_microdata_data[same_as][2]" value="<?php if(!empty($mlseo_microdata_data['same_as'][2])) echo $mlseo_microdata_data['same_as'][2]; ?>" />
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div class="tab-pane" id="tab-microdata-4">
              <table class="form">
                <tr>
                  <td><?php echo $_language->get('text_enabled'); ?></td>
                  <td><input class="switch" type="checkbox" id="mlseo_microdata_data_website" name="mlseo_microdata_data[website]" value="1" <?php if(!empty($mlseo_microdata_data['website'])) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_snippet_data'); ?></td>
                  <td>
                    <input class="checkable" data-label="<?php echo $_language->get('entry_microdata_search'); ?>" type="checkbox" id="mlseo_microdata_data_websearch" name="mlseo_microdata_data[website_search]" value="1" <?php if(!empty($mlseo_microdata_data['website_search'])) echo 'checked="checked"'; ?> /><br />
                  </td>
                </tr>
              </table>
            </div>
            <div class="tab-pane" id="tab-microdata-5">
              <table class="form">
                <tr>
                  <td><?php echo $_language->get('text_enabled'); ?></td>
                  <td><input class="switch" type="checkbox" id="mlseo_microdata_data_place" name="mlseo_microdata_data[place]" value="1" <?php if(!empty($mlseo_microdata_data['place'])) echo 'checked="checked"'; ?> /></td>
                </tr>
                <tr>
                  <td><?php echo $_language->get('entry_microdata_gps'); ?></td>
                  <td>
                    <div class="input-group" style="width:100%;">
                      <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                      <input style="width:50%" type="text" class="form-control" placeholder="<?php echo $_language->get('entry_gps_lat'); ?>" name="mlseo_microdata_data[gps_lat]" value="<?php if(!empty($mlseo_microdata_data['gps_lat'])) echo $mlseo_microdata_data['gps_lat']; ?>" />
                      <input style="width:50%" type="text" class="form-control" placeholder="<?php echo $_language->get('entry_gps_long'); ?>" name="mlseo_microdata_data[gps_long]" value="<?php if(!empty($mlseo_microdata_data['gps_long'])) echo $mlseo_microdata_data['gps_long']; ?>" />
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div class="tab-pane" id="tab-microdata-6">
              <table class="form">
                <tr>
                  <td><?php echo $_language->get('text_enabled'); ?></td>
                  <td><input class="switch" type="checkbox" id="mlseo_microdata_data_breadcrumbs" name="mlseo_microdata_data[breadcrumbs]" value="1" <?php if(!empty($mlseo_microdata_data['breadcrumbs'])) echo 'checked="checked"'; ?> /></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
				<div class="tab-pane" id="tab-snippet-2">
					<table class="form">
						<tr>
              <td><?php echo $_language->get('entry_enable_opengraph'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_opengraph" name="mlseo_opengraph" value="1" <?php if($mlseo_opengraph) echo 'checked="checked"'; ?> /></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('entry_opengraph_id'); ?></td>
              <td>
                <input type="text" class="form-control" placeholder="111122223333444" name="mlseo_opengraph_data[page_id]" value="<?php if(!empty($mlseo_opengraph_data['page_id'])) echo $mlseo_opengraph_data['page_id']; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('entry_product_data'); ?></td>
              <td>
                <input class="checkable" data-label="<?php echo $_language->get('entry_description'); ?>" type="checkbox" id="mlseo_opengraph_data_desc" name="mlseo_opengraph_data[desc]" value="1" <?php if(!empty($mlseo_opengraph_data['desc'])) echo 'checked="checked"'; ?> />
              </td>
            </tr>
          </table>
				</div>
        <div class="tab-pane" id="tab-snippet-3">
					<table class="form">
						<tr>
              <td><?php echo $_language->get('entry_enable_tcard'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_tcard" name="mlseo_tcard" value="1" <?php if($mlseo_tcard) echo 'checked="checked"'; ?> /></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('entry_twitter_nick'); ?></td>
              <td>
                <input type="text" class="form-control" placeholder="@nickname" name="mlseo_tcard_data[nick]" value="<?php if(!empty($mlseo_tcard_data['nick'])) echo $mlseo_tcard_data['nick']; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('entry_twitter_home_type'); ?></td>
              <td>
                <select class="form-control" name="mlseo_tcard_data[home_type]">
                  <option value="summary" <?php if(!empty($mlseo_tcard_data['home_type']) && $mlseo_tcard_data['home_type'] == 'summary') echo 'selected="selected"'; ?>><?php echo $_language->get('entry_twitter_summary'); ?></option>
                  <option value="summary_large_image" <?php if(!empty($mlseo_tcard_data['home_type']) && $mlseo_tcard_data['home_type'] == 'summary_large_image') echo 'selected="selected"'; ?>><?php echo $_language->get('entry_twitter_summary_large'); ?></option>
                </select>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('entry_product_data'); ?></td>
              <td>
                <input class="checkable" data-label="<?php echo $_language->get('entry_description'); ?>" type="checkbox" id="mlseo_tcard_data_desc" name="mlseo_tcard_data[desc]" value="1" <?php if(!empty($mlseo_tcard_data['desc'])) echo 'checked="checked"'; ?> />
              </td>
            </tr>
          </table>
				</div>
         <div class="tab-pane" id="tab-snippet-4">
					<table class="form">
						<tr>
              <td><?php echo $_language->get('entry_enable_gpublisher'); ?></td>
              <td><input class="switch" type="checkbox" id="mlseo_gpublisher" name="mlseo_gpublisher" value="1" <?php if($mlseo_gpublisher) echo 'checked="checked"'; ?> /></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('entry_gpublisher_url'); ?></td>
              <td>
                <input type="text" class="form-control" placeholder="https://plus.google.com/my_google_plus/" name="mlseo_gpublisher_data[url]" value="<?php if(!empty($mlseo_gpublisher_data['url'])) echo $mlseo_gpublisher_data['url']; ?>" />
              </td>
            </tr>
          </table>
				</div>
      </div>
      <div style="clear:both"></div>
		</div>
		<div class="tab-pane" id="tab-fpp">
      <!-- start fpp -->
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-fpp-1" data-toggle="tab"><?php echo $_language->get('tab_fpp_product'); ?></a></li>
        <li><a href="#tab-fpp-2" data-toggle="tab"><?php echo $_language->get('tab_fpp_category'); ?></a></li>
        <li><a href="#tab-fpp-3" data-toggle="tab"><?php echo $_language->get('tab_fpp_manufacturer'); ?></a></li>
        <li><a href="#tab-fpp-4" data-toggle="tab"><?php echo $_language->get('tab_fpp_search'); ?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab-fpp-1">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_fpp_mode'); ?></td>
              <td>
                <select name="mlseo_fpp_mode" class="form-control">
                  <option value="0" <?php if($mlseo_fpp_mode == '0') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_0'); ?></option>
                  <option value="1" <?php if($mlseo_fpp_mode == '1') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_1'); ?></option>
                  <option value="2" <?php if($mlseo_fpp_mode == '2') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_2'); ?></option>
                  <option value="3" <?php if($mlseo_fpp_mode == '3') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_3'); ?></option>
                </select>
              </td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_mode_help'); ?></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_fpp_depth'); ?></td>
              <td>
                <select name="mlseo_fpp_depth" class="form-control">
                  <option value="0" <?php if($mlseo_fpp_depth == '0') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_unlimited'); ?></option>
                  <option value="1" <?php if($mlseo_fpp_depth == '1') echo 'selected="selected"'; ?>>1</option>
                  <option value="2" <?php if($mlseo_fpp_depth == '2') echo 'selected="selected"'; ?>>2</option>
                  <option value="3" <?php if($mlseo_fpp_depth == '3') echo 'selected="selected"'; ?>>3</option>
                  <option value="4" <?php if($mlseo_fpp_depth == '4') echo 'selected="selected"'; ?>>4</option>
                  <option value="5" <?php if($mlseo_fpp_depth == '5') echo 'selected="selected"'; ?>>5</option>
                  <option value="6" <?php if($mlseo_fpp_depth == '6') echo 'selected="selected"'; ?>>6</option>
                  <option value="7" <?php if($mlseo_fpp_depth == '7') echo 'selected="selected"'; ?>>7</option>
                </select>
              </td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_depth_help'); ?></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_fpp_breadcrumbs_fix'); ?></td>
              <td>
                <select name="mlseo_fpp_breadcrumbs" class="form-control">
                  <option value="0" <?php if($mlseo_fpp_breadcrumbs == '0') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_breadcrumbs_0'); ?></option>
                  <option value="1" <?php if($mlseo_fpp_breadcrumbs == '1') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_breadcrumbs_1'); ?></option>
                  <option value="2" <?php if($mlseo_fpp_breadcrumbs == '2') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_breadcrumbs_2'); ?></option>
                </select>
              </td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_breadcrumbs_help'); ?></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_fpp_bc_mode'); ?></td>
              <td>
                <select name="mlseo_fpp_bc_mode" class="form-control">
                  <option value="0" <?php if($mlseo_fpp_bc_mode == '0') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_0'); ?></option>
                  <option value="1" <?php if($mlseo_fpp_bc_mode == '1') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_1'); ?></option>
                  <option value="2" <?php if($mlseo_fpp_bc_mode == '2') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_2'); ?></option>
                  <option value="3" <?php if($mlseo_fpp_bc_mode == '3') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_mode_3'); ?></option>
                </select>
              </td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_mode_help'); ?></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_fpp_bypasscat'); ?></td>
              <td><input class="switch" type="checkbox" name="mlseo_fpp_bypasscat" id="mlseo_fpp_bypasscat" value="1" <?php if($mlseo_fpp_bypasscat) echo 'checked="checked"'; ?> /></td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_bypasscat_help'); ?></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('entry_category'); ?></td>
              <td colspan="2"><div class="scrollbox" style="width:90%;height:350px">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($category['category_id'],(array) $mlseo_fpp_categories)) { ?>
                    <input type="checkbox" name="mlseo_fpp_categories[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                    <?php echo $category['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="mlseo_fpp_categories[]" value="<?php echo $category['category_id']; ?>" />
                    <?php echo $category['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $_language->get('text_select_all'); ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $_language->get('text_unselect_all'); ?></a></td>
            </tr>
          </table>
        </div>
        <div class="tab-pane active" id="tab-fpp-2">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_fpp_directcat'); ?></td>
              <td>
                <select name="mlseo_fpp_directcat" class="form-control">
                  <option value="1" <?php if($mlseo_fpp_directcat == '1') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_cat_mode_0'); ?></option>
                  <option value="" <?php if(!$mlseo_fpp_directcat) echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_cat_mode_1'); ?></option>
                </select>
              </td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_directcat_help'); ?></td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_fpp_cat_canonical'); ?></td>
              <td>
                <select name="mlseo_fpp_cat_canonical" class="form-control">
                  <option value="" <?php if(!$mlseo_fpp_cat_canonical) echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_cat_mode_0'); ?></option>
                  <option value="1" <?php if($mlseo_fpp_cat_canonical == '1') echo 'selected="selected"'; ?>><?php echo $_language->get('text_fpp_cat_mode_1'); ?></option>
                </select>
              </td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_cat_canonical_help'); ?></td>
            </tr>
          </table>
          <script type="text/javascript">
            $('select[name=mlseo_fpp_directcat]').change(function(){
              $('select[name=mlseo_fpp_cat_canonical]').prop('disabled', $(this).val());
              if ($(this).val()) {
                $('select[name=mlseo_fpp_cat_canonical]').val('');
              }
            });
            $('select[name=mlseo_fpp_directcat]').change();
          </script>
        </div>
        <div class="tab-pane active" id="tab-fpp-3">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_fpp_brand_parent'); ?></td>
              <td><input class="switch" type="checkbox" name="mlseo_fpp_brand_parent" id="mlseo_fpp_brand_parent" value="1" <?php if($mlseo_fpp_brand_parent) echo 'checked="checked"'; ?> /></td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_brand_parent_help'); ?></td>
            </tr>
          </table>
        </div>
        <div class="tab-pane active" id="tab-fpp-4">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_fpp_remove_search'); ?></td>
              <td><input class="switch" type="checkbox" name="mlseo_fpp_remove_search" id="mlseo_fpp_remove_search" value="1" <?php if($mlseo_fpp_remove_search) echo 'checked="checked"'; ?> /></td>
              <td style="padding-left:50px"><?php echo $_language->get('text_fpp_remove_search_help'); ?></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- end fpp -->
		</div>

		<div class="tab-pane" id="tab-update">
			 <table class="form">
       <tr>
        <td colspan="2">
          <div class="row-fluid clearfix jumbo">
            <label class="col-sm-2"><?php echo $_language->get('text_seo_simulate'); ?></label>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-floppy-o"></i></span>
                <input type="text" name="simulate" value="1" class="toggler" data-mode="background" data-on-text="<?php echo $_language->get('text_simulation'); ?>" data-off-text="<?php echo $_language->get('text_write'); ?>" data-icons="" data-on-color="#f0a357" data-off-color="#5ca455"/>
              </div>
            </div>
            <div class="col-sm-1"></div>
            <label class="col-sm-2"><?php echo $_language->get('text_seo_empty_only'); ?></label>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-magic"></i></span>
                <input type="text" name="empty_only" value="1" class="toggler" data-mode="background" data-on-text="<?php echo $_language->get('text_empty_only'); ?>" data-off-text="<?php echo $_language->get('text_all_values'); ?>" data-icons="" data-on-color="#f0a357" data-off-color="#5ca455"/>
              </div>
            </div>
            <!--
            <label class="col-sm-2"><?php echo $_language->get('text_seo_redirect_mode'); ?></label>
            <div class="col-sm-2">
              <input class="switch" type="checkbox" id="redirect_mode"  name="redirect_mode" value="1" checked="checked"/>
            </div>
            -->
          </div>
         </td>
        </tr>
				<tr>
					<td><?php echo $_language->get('text_seo_languages'); ?>:</td>
					<td class="imgCheckbox">
            <?php foreach ($languages as $language) { ?>
            <img style="position:relative; bottom:12px; left:50px;" src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <input type="checkbox" class="checkable" value="<?php echo $language['language_id']; ?>" data-label="<?php echo $language['name']; ?>" id="langs_selector_<?php echo $language['language_id']; ?>" name="langs[]" checked="checked"/> 
            <?php } ?>
          </td>
				</tr>
				<tr>
				  <td><?php echo $_language->get('text_seo_generator_product'); ?></td>
				  <td>
					<table class="generator">
						<tr>
							<td class="patterns" rowspan="14"><?php echo $_language->get('text_seo_generator_product_desc'); ?></td>
							<td>
                <!--
                <div class="input-group">
                  <input class="form-control" type="text" name="mlseo_product_url_pattern" value="<?php echo $mlseo_product_url_pattern; ?>" size="50" />
                  <div class="input-group-btn">
                    <button onclick="seo_update('product', 'url');" class="btn btn-success mubtn" type="submit"><i class="fa fa-link"></i> <?php echo $_language->get('text_seo_generator_url'); ?></button>
                  </div>
                  </div>
                -->
                  <input type="text" name="mlseo_product_url_pattern" value="<?php echo $mlseo_product_url_pattern; ?>" size="50" />
                 
                  </td>
							<td>
                <a onclick="seo_update('product', 'url');" class="button"><span><i class="fa fa-link"></i> <?php echo $_language->get('text_seo_generator_url'); ?></span></a>
              </td>
						</tr>
            <tr>
							<td><input type="text" name="mlseo_product_h1_pattern" value="<?php echo $mlseo_product_h1_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('product', 'h1');" class="button"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h1'); ?></span></a></td>
						</tr>
            <tr>
							<td><input type="text" name="mlseo_product_h2_pattern" value="<?php echo $mlseo_product_h2_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('product', 'h2');" class="button"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h2'); ?></span></a></td>
						</tr>
            <tr>
							<td><input type="text" name="mlseo_product_h3_pattern" value="<?php echo $mlseo_product_h3_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('product', 'h3');" class="button"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h3'); ?></span></a></td>
						</tr>
						<tr>
							<td><input type="text" name="mlseo_product_title_pattern" value="<?php echo $mlseo_product_title_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('product', 'title');" class="button"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_title'); ?></span></a></td>
						</tr>
						<tr>
							<td><input type="text" name="mlseo_product_keyword_pattern" value="<?php echo $mlseo_product_keyword_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('product', 'keyword');" class="button"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_keywords'); ?></span></a></td>
						</tr>
						<tr>
							<td><input type="text" name="mlseo_product_description_pattern" value="<?php echo $mlseo_product_description_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('product', 'description');" class="button"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_desc'); ?></span></a></td>
						</tr>
            <tr>
							<td><input type="text" name="mlseo_product_image_alt_pattern" value="<?php echo $mlseo_product_image_alt_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('product', 'image_alt');" class="button"><span><i class="fa fa-picture-o"></i> <?php echo $_language->get('text_seo_generator_imgalt'); ?></span></a></td>
						</tr>
            <tr>
							<td><input type="text" name="mlseo_product_image_title_pattern" value="<?php echo $mlseo_product_image_title_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('product', 'image_title');" class="button"><span><i class="fa fa-picture-o"></i> <?php echo $_language->get('text_seo_generator_imgtitle'); ?></span></a></td>
						</tr>
            <tr>
							<td><input type="text" name="mlseo_product_image_name_pattern" value="<?php echo $mlseo_product_image_name_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('product', 'image_name');" class="button"><span><i class="fa fa-picture-o"></i> <?php echo $_language->get('text_seo_generator_imgname'); ?></span></a></td>
						</tr>
						<?php if ($OC_VERSION > 153) { ?>
						<tr>
							<td><input type="text" name="mlseo_product_tag_pattern" value="<?php echo $mlseo_product_tag_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('product', 'tag');" class="button"><span><i class="fa fa-tags"></i> <?php echo $_language->get('text_seo_generator_tag'); ?></span></a></td>
						</tr>
						<?php } ?>
            <tr>
							<td><textarea name="mlseo_product_full_desc_pattern" style="width:370px;height:70px"><?php echo $mlseo_product_full_desc_pattern; ?></textarea></td>
							<td><a onclick="seo_update('product', 'full_desc');" class="button"><span><i class="fa fa-align-left"></i> <?php echo $_language->get('text_seo_generator_full_desc'); ?></span></a></td>
						</tr>
            <tr>
							<td>
                <?php echo $_language->get('text_seo_generator_related_no'); ?> <input type="text" name="mlseo_product_related_no" value="<?php echo $mlseo_product_related_no; ?>" size="2" />
                <?php echo $_language->get('text_seo_generator_related_relevance'); ?> <input type="text" name="mlseo_product_related_relevance" value="<?php echo $mlseo_product_related_relevance; ?>" size="2" />
              </td>
							<td><a onclick="seo_update('product', 'related');" class="button"><span><i class="fa fa-sitemap"></i> <?php echo $_language->get('text_seo_generator_related'); ?></span></a></td>
						</tr>
            <tr>
							<td>&nbsp;</td>
							<td><a onclick="seo_update('redirect', 'product');" class="button"><span><i class="fa fa-share"></i> <?php echo $_language->get('text_seo_generator_redirect'); ?></span></a></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
				  <td><?php echo $_language->get('text_seo_generator_category'); ?></td>
				  <td>
					<table class="generator">
						<tr>
							<td class="patterns" rowspan="9"><?php echo $_language->get('text_seo_generator_category_desc'); ?></td>
							<td><input type="text" name="mlseo_category_url_pattern" value="<?php echo $mlseo_category_url_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('category', 'url');" class="button"><span><i class="fa fa-link"></i> <?php echo $_language->get('text_seo_generator_url'); ?></span></a></td>
						</tr>
            <tr>
							<td><input type="text" name="mlseo_category_h1_pattern" value="<?php echo $mlseo_category_h1_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('category', 'h1');" class="button"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h1'); ?></span></a></td>
						</tr>
            <tr>
							<td><input type="text" name="mlseo_category_h2_pattern" value="<?php echo $mlseo_category_h2_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('category', 'h2');" class="button"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h2'); ?></span></a></td>
						</tr>
            <tr>
							<td><input type="text" name="mlseo_category_h3_pattern" value="<?php echo $mlseo_category_h3_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('category', 'h3');" class="button"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h3'); ?></span></a></td>
						</tr>
						<tr>
							<td><input type="text" name="mlseo_category_title_pattern" value="<?php echo $mlseo_category_title_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('category', 'title');" class="button"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_title'); ?></span></a></td>
						</tr>
						<tr>
							<td><input type="text" name="mlseo_category_keyword_pattern" value="<?php echo $mlseo_category_keyword_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('category', 'keyword');" class="button"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_keywords'); ?></span></a></td>
						</tr>
						<tr>
							<td><input type="text" name="mlseo_category_description_pattern" value="<?php echo $mlseo_category_description_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('category', 'description');" class="button"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_desc'); ?></span></a></td>
						</tr>
            <tr>
							<td><textarea name="mlseo_category_full_desc_pattern" style="width:370px;height:70px"><?php echo $mlseo_category_full_desc_pattern; ?></textarea></td>
							<td><a onclick="seo_update('category', 'full_desc');" class="button"><span><i class="fa fa-align-left"></i> <?php echo $_language->get('text_seo_generator_full_desc'); ?></span></a></td>
						</tr>
            <tr>
							<td>&nbsp;</td>
							<td><a onclick="seo_update('redirect', 'category');" class="button"><span><i class="fa fa-share"></i> <?php echo $_language->get('text_seo_generator_redirect'); ?></span></a></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
				  <td><?php echo $_language->get('text_seo_generator_information'); ?></td>
				  <td>
					<table class="generator">
						<tr>
							<td class="patterns" rowspan="9"><?php echo $_language->get('text_seo_generator_information_desc'); ?></td>
							<td><input type="text" name="mlseo_information_url_pattern" value="<?php echo $mlseo_information_url_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('information', 'url');" class="button"><span><i class="fa fa-link"></i> <?php echo $_language->get('text_seo_generator_url'); ?></span></a></td>
						</tr>
            <tr>
							<td><input type="text" name="mlseo_information_h1_pattern" value="<?php echo $mlseo_information_h1_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('information', 'h1');" class="button"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h1'); ?></span></a></td>
						</tr>
            <tr>
							<td><input type="text" name="mlseo_information_h2_pattern" value="<?php echo $mlseo_information_h2_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('information', 'h2');" class="button"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h2'); ?></span></a></td>
						</tr>
            <tr>
							<td><input type="text" name="mlseo_information_h3_pattern" value="<?php echo $mlseo_information_h3_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('information', 'h3');" class="button"><span><i class="fa fa-header"></i> <?php echo $_language->get('text_seo_generator_h3'); ?></span></a></td>
						</tr>
						<tr>
							<td><input type="text" name="mlseo_information_title_pattern" value="<?php echo $mlseo_information_title_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('information', 'title');" class="button"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_title'); ?></span></a></td>
						</tr>
						<tr>
							<td><input type="text" name="mlseo_information_keyword_pattern" value="<?php echo $mlseo_information_keyword_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('information', 'keyword');" class="button"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_keywords'); ?></span></a></td>
						</tr>
						<tr>
							<td><input type="text" name="mlseo_information_description_pattern" value="<?php echo $mlseo_information_description_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('information', 'description');" class="button"><span><i class="fa fa-code"></i> <?php echo $_language->get('text_seo_generator_desc'); ?></span></a></td>
						</tr>
            <tr>
							<td><textarea name="mlseo_information_full_desc_pattern" style="width:370px;height:70px"><?php echo $mlseo_information_full_desc_pattern; ?></textarea></td>
							<td><a onclick="seo_update('information', 'full_desc');" class="button"><span><i class="fa fa-align-left"></i> <?php echo $_language->get('text_seo_generator_full_desc'); ?></span></a></td>
						</tr>
            <tr>
							<td>&nbsp;</td>
							<td><a onclick="seo_update('redirect', 'information');" class="button"><span><i class="fa fa-share"></i> <?php echo $_language->get('text_seo_generator_redirect'); ?></span></a></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
				  <td><?php echo $_language->get('text_seo_generator_manufacturer'); ?></td>
				  <td>
					<table class="generator">
						<tr>
							<td class="patterns" rowspan="3"><?php echo $_language->get('text_seo_generator_manufacturer_desc'); ?></td>
							<td><input type="text" name="mlseo_manufacturer_url_pattern" value="<?php echo $mlseo_manufacturer_url_pattern; ?>" size="50" /></td>
							<td><a onclick="seo_update('manufacturer', 'url');" class="button"><span><i class="fa fa-link"></i> <?php echo $_language->get('text_seo_generator_url'); ?></span></a></td>
						</tr>
            <tr>
							<td>&nbsp;</td>
							<td><a onclick="seo_update('redirect', 'manufacturer');" class="button"><span><i class="fa fa-share"></i> <?php echo $_language->get('text_seo_generator_redirect'); ?></span></a></td>
						</tr>
					 </table>
					</td>
				</tr>
				
				<tr>
          <td><?php echo $_language->get('text_seo_result'); ?></td>
			<td>
        <div id="update_result">
          <div>
            <div class="fullscreen" onclick="javascript:fullscreen();"><?php echo $_language->get('text_seo_fullscreen'); ?></div>
            <div class="simulation simu"><?php echo $_language->get('text_seo_simulation_mode'); ?></div>
            <div class="simulation write" style="display:none"><?php echo $_language->get('text_seo_write_mode'); ?></div>
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th style="width:1%"></th>
                  <th><?php echo $_language->get('text_seo_item'); ?></th>
                  <th><?php echo $_language->get('text_seo_old_value'); ?></th>
                  <th><?php echo $_language->get('text_seo_new_value'); ?></th>
                </tr>
              </thead>
              <tbody>
                <tr data-lang="0" style="display:none"><td colspan="4"></td></tr>
                <?php $f=0; foreach ($languages as $language) { ?>
                <tr data-lang="<?php echo $language['language_id']; ?>" style="display:none"><td colspan="4"><?php echo $language['name']; ?></td></tr>
                <?php } ?>
                <tr><td colspan="4" class="text-center"><?php echo $_language->get('text_seo_update_info'); ?></td></tr>
                <tr data-lang="loading" id="loading" style="display:none"><td colspan="4" class="text-center" style="padding:30px 0"><img src="view/seo_package/img/loading.gif" alt=""/></td></tr>
              </tbody>
            </table>
          </div>
        </div>
        <div id="generateProgress" class="progress" style="margin-top:15px;display:none">
          <div class="progress-bar progress-bar-striped progress-bar-success active"></div>
        </div>
      </td>
		</tr>
		<tr class="generator">
      <td><?php echo $_language->get('text_cache'); ?></td>
      <td>
				<a onclick="seo_update('cache', 'create');" class="button"><span><i class="fa fa-refresh"></i> <?php echo $_language->get('text_cache_create_btn'); ?></span></a>
				<a onclick="seo_update('cache', 'delete');" class="button"><span><i class="fa fa-eraser"></i> <?php echo $_language->get('text_cache_delete_btn'); ?></span></a>
			</td>
    </tr>
		<tr class="generator">
      <td><?php echo $_language->get('text_report'); ?></td>
      <td>
				<a onclick="seo_update('report', 'url_alias');" class="button"><span><i class="fa fa-file-text-o"></i> <?php echo $_language->get('text_url_alias_report_btn'); ?></span></a>
			</td>
    </tr>
    <tr class="generator">
      <td><?php echo $_language->get('text_cleanup'); ?></td>
      <td>
				<a onclick="seo_update('cleanup', 'duplicate');" class="button"><span><i class="fa fa-copy"></i> <?php echo $_language->get('text_cleanup_duplicate_btn'); ?></span></a>
				<a onclick="seo_update('cleanup', 'url');" class="button"><span><i class="fa fa-repeat"></i> <?php echo $_language->get('text_cleanup_btn'); ?></span></a>
			</td>
    </tr>
				<tr class="info">
			  <td><i class='fa fa-info'></i></td>
          <td style="color:#555;padding:40px 100px 40px 0;"><?php echo $_language->get('text_info_update'); ?></td>
        </tr>
			</table>
		</div>
		<div class="tab-pane" id="tab-cron">
      <ul class="nav nav-pills nav-stacked col-md-2">
				<li class="active"><a href="#tab-cron-1" data-toggle="pill"><i class="fa fa-cogs"></i> <?php echo $_language->get('text_tab_cron_1'); ?></a></li>
				<li><a href="#tab-cron-2" data-toggle="pill"><i class="fa fa-file-text-o"></i> <?php echo $_language->get('text_tab_cron_2'); ?></a></li>
			</ul>
			<div class="tab-content col-md-10">
				<div class="tab-pane active" id="tab-cron-1">
          <table class="form">
            <tr>
              <td><?php echo $_language->get('text_seo_simulate'); ?></td>
              <td>
                <input class="switch" type="checkbox" id="cron_simulate"  name="mlseo_cron[simulation]" value="1" <?php if(!empty($mlseo_cron['simulation'])) echo 'checked="checked"'; ?>/>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_empty_only'); ?></td>
              <td>
                <input class="switch" type="checkbox" id="cron_empty_only"  name="mlseo_cron[empty_only]" value="1" <?php if(!empty($mlseo_cron['empty_only'])) echo 'checked="checked"'; ?>/>
              </td>
            </tr>
            <tr>
              <td><?php echo $_language->get('text_seo_cron_update'); ?></td>
              <td>
              <table class="cron">
                <tr>
                  <td>
                    <b><?php echo $_language->get('text_seo_generator_product'); ?></b><br />
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_url'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="url" <?php if(isset($mlseo_cron['update']['product']) && in_array('url', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/> <br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_title'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="title" <?php if(isset($mlseo_cron['update']['product']) && in_array('title', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/> <br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_keyword'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="keyword" <?php if(isset($mlseo_cron['update']['product']) && in_array('keyword', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/> <br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_description'); ?>" type="checkbox" name="mlseo_cron[update][product][]" value="description" <?php if(isset($mlseo_cron['update']['product']) && in_array('description', $mlseo_cron['update']['product'])) echo 'checked="checked"'; ?>/> 
                  </td>
                  <td>
                    <b><?php echo $_language->get('text_seo_generator_category'); ?></b><br />
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_url'); ?>" type="checkbox" name="mlseo_cron[update][category][]" value="url" <?php if(isset($mlseo_cron['update']['category']) && in_array('url', $mlseo_cron['update']['category'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_title'); ?>" type="checkbox" name="mlseo_cron[update][category][]" value="title" <?php if(isset($mlseo_cron['update']['category']) && in_array('title', $mlseo_cron['update']['category'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_keyword'); ?>" type="checkbox" name="mlseo_cron[update][category][]" value="keyword" <?php if(isset($mlseo_cron['update']['category']) && in_array('keyword', $mlseo_cron['update']['category'])) echo 'checked="checked"'; ?>/> <br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_description'); ?>" type="checkbox" name="mlseo_cron[update][category][]" value="description" <?php if(isset($mlseo_cron['update']['category']) && in_array('description', $mlseo_cron['update']['category'])) echo 'checked="checked"'; ?>/> 
                  </td>
                  <td>
                    <b><?php echo $_language->get('text_seo_generator_information'); ?></b><br />
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_url'); ?>" type="checkbox" name="mlseo_cron[update][information][]" value="url" <?php if(isset($mlseo_cron['update']['information']) && in_array('url', $mlseo_cron['update']['information'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_title'); ?>" type="checkbox" name="mlseo_cron[update][information][]" value="title" <?php if(isset($mlseo_cron['update']['information']) && in_array('title', $mlseo_cron['update']['information'])) echo 'checked="checked"'; ?>/><br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_keyword'); ?>" type="checkbox" name="mlseo_cron[update][information][]" value="keyword" <?php if(isset($mlseo_cron['update']['information']) && in_array('keyword', $mlseo_cron['update']['information'])) echo 'checked="checked"'; ?>/> <br/>
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_description'); ?>" type="checkbox" name="mlseo_cron[update][information][]" value="description" <?php if(isset($mlseo_cron['update']['information']) && in_array('description', $mlseo_cron['update']['information'])) echo 'checked="checked"'; ?>/> 
                  </td>
                  <td>
                    <b><?php echo $_language->get('text_seo_generator_manufacturer'); ?></b><br />
                    <input class="checkable" data-label="<?php echo $_language->get('text_seo_mode_url'); ?>" type="checkbox" name="mlseo_cron[update][manufacturer][]" value="url" <?php if(isset($mlseo_cron['update']['manufacturer']) && in_array('url', $mlseo_cron['update']['manufacturer'])) echo 'checked="checked"'; ?>/><br/>
                  </td>
                </tr>
              </table>
              </td>
            </tr>
            <tr class="info">
              <td><i class='fa fa-info'></i></td>
              <td><?php echo $_language->get('text_info_cron'); ?></td>
            </tr>
          </table>
        </div>
        <div class="tab-pane" id="tab-cron-2">
          <textarea wrap="off" rows="30" readonly class="form-control"><?php echo $cli_log; ?></textarea>
          <div class="text-center" style="margin-top:20px">
            <a class="btn btn-success" <?php if(!$cli_log_link || !$cli_log) { echo 'disabled'; } else { echo 'href="'.$cli_log_link.'"';} ?>><i class="fa fa-download"></i> <?php echo $_language->get('text_cli_log_save'); ?></a>
            <a <?php if(!$cli_log_link || !$cli_log) { echo 'disabled not'; } ?>onclick="confirm('<?php echo $_language->get('text_confirm'); ?>') ? location.href='<?php echo $action.'&clear_cli_logs=1'; ?>' : false;" class="btn btn-danger"><i class="fa fa-eraser"></i> <?php echo $_language->get('text_clear_logs'); ?></a>
          </div>
        </div>
      </div>
		</div>
		<div class="tab-pane" id="tab-about">
			<table class="form about">
				<tr>
					<td colspan="2" style="text-align:center;padding:30px 0 50px"><img src="view/seo_package/img/logo<?php echo rand(1,1); ?>.gif"/></td>
				</tr>
				<tr>
					<td>Version</td>
					<td><?php echo $module_version; ?> - <?php echo $module_type; ?></td>
				</tr>
				<tr>
					<td>Free support</td>
					<td>Top quality module guaranteed.<br/>In case of bug, incompatibility, or if you want a new feature, just contact me on my mail.</td>
				</tr>
				<tr>
					<td>Contact</td>
					<td><a href="mailto:sirius_box-dev@yahoo.fr">sirius_box-dev@yahoo.fr</a></td>
				</tr>
				<tr>
					<td>Links</td>
					<td>
						If you like this module, please consider to make a star rating <span style="position:relative;top:3px;width:80px;height:17px;display:inline-block;background:url(data:data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAARCAYAAADUryzEAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAwNy8wNy8xMrG4sToAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzbovLKMAAACr0lEQVQ4jX1US0+TURA98/Xri0KBYqG8BDYItBoIBhFBBdRNTTQx0Q0gujBiAkEXxoXxD6iJbRcaY1iQEDXqTgwQWkWDIBU3VqWQoEgECzUU+n5910VbHhacZHLvzD05c+fMzaVhgxYJIwIYi+8B8FJ5bzjob9ucB4DmLttGMGyoAGMsyc1G7bEvA91roz2NL7Y7TziHHSxFmWsorbuUFgn79BaTLnMn3LYEZqPukCKruFAUGEd54w1ekqK69x8CSkoqMnJv72noTmN+O9Q5KlE44GqxmHTS7Qho5MH+X8SJUuMhAIbM/CrS1tSnCYsmkOoUnO7SiP3dHV8Mw5AoKkRCfTwR96ei+ZZGVVDDJQhIWAVbfhjDe8eQnd/Aq8+/VAIsAcGbR8ejQiR8jcwGbYZEkTFVd7I9B4IXcL+GEPwdK4SN0XJSDaCoAvHZsA4/93hWHNVNnbZpjoG5gl7XvpFnxggxAZRaA0rokliIAIkaxMnwdWLE7XW77jd12qYBgCMiNHfZlhgTCkZfPfUDBAYGItoiL0lK8N0+51txzD1u7Ji8njTGpk6bg/iUhSiU4GT5YOtPL940AOfiDyHod9/dMsYEzmLS5bBoKE/ES8ECCyACSF4IFledAdhd2SIFUdtmAp7i92QM+uKqVg6RJXDKakCcjyjSwcldMUDgG7I0h8WKdI0ewM2kFuTpmlb1bp2UMYBJyjBjm/FYh57MjA/1+1wuESNZOfjoLPwe516zUSdLIgi6l+sl3CIW5leD7/v7HPNTE+cOtr8tDXhWy+zWAcvnDx/XoiEPiirPBomgXxd32KAFEWp3FR0YdP60pop4sfHI5cmr+MfMRl2tXKnqzS5pyFuaHRusu2A5EyeoAEAQS2Q94VDg4pY/YUOf9ZgxnBaJJSeOdny6AgB/AYEpKtpaTusRAAAAAElFTkSuQmCC)"></span> on the module page :]<br/><br/>
						<b>Module page :</b> <a target="new" href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=9486">Complete SEO Package</a><br/>
						<b>Other modules :</b> <a target="new" href="http://www.opencart.com/index.php?route=extension/extension&filter_username=woodruff">My modules on opencart</a><br/>
					</td>
				</tr>
			</table>
		</div>
  	</div>
	</form>
  </div>
</div>
</div>
</div>
<div class="modal" id="newAliasModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $_language->get('text_seo_new_alias_title'); ?></h4>
      </div>
      <div class="modal-body">
	<form class="form-stacked" role="form">
		   <div class="container-fluid">
			<div class="row clearfix modalinfo common"><div class="col-md-12 column"><?php echo $_language->get('text_seo_new_alias_info'); ?></div></div>
			<div class="row clearfix modalinfo special"><div class="col-md-12 column"><?php echo $_language->get('text_seo_new_spec_alias_info'); ?></div></div>
			<div class="row clearfix modalinfo redirect"><div class="col-md-12 column"><?php echo $_language->get('text_seo_new_redirect'); ?></div></div>
			<hr />
			<div class="row clearfix">
				<div class="form-group">
          <label><?php echo $_language->get('text_editor_query'); ?></label>
					<input class="form-control" name="query" type="text" placeholder="<?php echo $_language->get('text_editor_query'); ?>"/>
				</div>
				<div class="form-group">
        <label class="modalinfo common special"><?php echo $_language->get('text_editor_url'); ?></label>
        <label class="modalinfo redirect"><?php echo $_language->get('text_editor_url_redirect'); ?></label>
					<input class="form-control" name="keyword" type="text" placeholder="<?php echo $_language->get('text_editor_url'); ?>"/>
				</div>
			</div>
		</div>
	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary addAlias">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('.toggler').toggler();
$('input.switch').iToggle({easing: 'swing',speed: 200});
jQuery.each( jQuery('input.checkable'), function(){ jQuery(this).prettyCheckable(); });

<?php if (false && !$OC_V2) { ?>
$('#tabs a').tabs();
$('#tabs_editor a').tabs();
$('#language-friendly a').tabs();
$('#tabs_editor_lang a').tabs();

$('#stores a').tabs();
<?php foreach ($stores as $store) { ?>
$('#language-<?php echo $store['store_id']; ?> a').tabs();
<?php } ?>
<?php }/*!OC_V2*/ ?>

function reset_urls(type, lang){
	location = '<?php echo str_replace('&amp;', '&', $_url->link('module/complete_seo/reset_urls', 'token=' . $token, 'SSL')); ?>&type='+type+'&lang='+lang;
}
function seo_update(type, mode){
  $('html,body').animate({scrollTop:$('#update_result').offset().top}, 500);
	$('#loading').show();
  
  $('#generateProgress').show();
  $('#generateProgress .progress-bar').addClass('active');
  
  $('#generateProgress .progress-bar').css('width','0%').css('min-width', '2em').html('0 %');

  $('#update_result tbody tr:not([data-lang])').remove();
  
  processQueue(type, mode, 0);
  return '';
  
	//$('#update_result *').fadeOut();
	/*$('#update_result').html('<img style="padding-left:40%" src="view/seo_package/img/bigloader.gif"/>');
	$.ajax({
		url: 'index.php?route=module/complete_seo/generator&type='+type+'&mode='+mode+'&token=<?php echo $token; ?>',
		data: $('#tab-update :input').serialize(),
		dataType: 'text',
		success: function(data){
			$('#update_result').html(data);
			$('#loading').hide();
		}
	});
  */
}
function display_old(){
	$('.toggle').toggleClass('active');
	$('.res_table td:nth-child(3)').toggle();
}
function fullscreen(){
	if($('#update_result').hasClass('full')){
		$('.fullscreen').removeClass('active');
		$('#update_result').removeClass('full');
		$('html, body').css({'overflow': 'auto','height': 'auto'});
	} else {
		$('.fullscreen').addClass('active');
		$('#update_result').addClass('full');
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	}
}

function processQueue(type, mode, start) {
  $.ajax({
    url: 'index.php?route=module/complete_seo/generator&type='+type+'&mode='+mode+'&start='+start+'&token=<?php echo $token; ?>',
    type: 'POST',
		data: $('#tab-update :input').serialize(),
		dataType: 'json',
		success: function(data){
      if(data.success) {
        $('#generateProgress .progress-bar').css('width',data.progress + '%').html(data.progress + ' %');
        
        if (data.log.langs) {
          $.each(data.log.langs, function(lang_id, lang) {
            $.each(lang.rows, function(i, item) {
              var img = name = changed = '';
              if (lang.lang_img) {
                img = '<img src="'+lang.lang_img+'" alt=""/>';
              }
              
              if (item.link) {
                name = '<a href="'+item.link+'" target="_blank">'+item.name+'</a>';
              } else {
                name = item.name;
              }
              
              if (item.changed) {
                changed = ' class="c"';
              }
              
              $('#update_result tr[data-lang="'+lang_id+'"]').before('<tr><td>'+img+'</td><td>'+name+'</td><td>'+item.old_value+'</td><td'+changed+'>'+item.value+'</td></tr>');
            });
            
            if (lang.no_old) {
              $('#update_result table td:nth-child(3), #update_result table th:nth-child(3)').hide();
            } else {
              $('#update_result table td:nth-child(3), #update_result table th:nth-child(3)').show();
            }
          });
          
        }
        
        if (!data.finished) {
          processQueue(type, mode, data.processed);
        } else {
          $('#generateProgress .progress-bar').removeClass('active');
          $('#loading').hide();
          if ($('#update_result tbody tr:not([data-lang])').length == 0) {
             $('#update_result table tbody').append('<tr><td colspan="4" style="padding:30px 0" class="text-center"><?php echo $_language->get('text_nothing_changed'); ?></td></tr>');
          }
        }
      }
		},
    error: function(xhr) {
      $('#generateProgress .progress-bar').removeClass('active');
      $('#loading').hide();
      if (xhr.responseText.length > 1000) {
        alert('Your session has terminated, please log-in again');
      } else {
        alert(xhr.responseText);
      }
    }
	});
}
$(document).ready(function () { 
  $('input[name="simulate"]').on('change', function() {
    if ($(this).val() == 1) {
      $('#update_result .write').hide();
      $('#update_result .simu').show();
    } else {
      $('#update_result .simu').hide();
      $('#update_result .write').show();
    }
  });
});
--></script>
<script type="text/javascript"><!--
var editor_type, editor_lang;

var columnsArray = function(type){
	if (type == 'product') {
		return [
			{'width': '1%', 'orderable': false, 'searchable': false},
			null,
			{'width': '13%'},
			{'width': '13%'},
			{'width': '13%'},
			<?php if ($OC_VERSION > 153) { ?>
			{'width': '13%'},
			<?php } ?>
			{'width': '13%'},
			{'width': '13%', 'orderable': false, 'searchable': false}
		];
	}
	else if (type == 'category') {
		return [
			{'width': '1%', 'orderable': false, 'searchable': false},
			null,
			{'width': '25%'},
			{'width': '15%'},
			{'width': '15%'},
			{'width': '15%'}
		];
	}
	else if (type == 'information') {
		return [
			null,
			{'width': '22%'},
			{'width': '19%'},
			{'width': '19%'},
			{'width': '19%'}
		];
	}
	else if (type == 'manufacturer') {
		return [
			{'width': '1%', 'orderable': false, 'searchable': false},
			null,
			{'width': '47%'}
		];
	}
  else if (type == 'image') {
		return [
			{'width': '1%', 'orderable': false, 'searchable': false},
			null,
			{'width': '25%'},
			{'width': '25%'},
			{'width': '25%'},
		];
	}
	else if (type == 'common' || type == 'special' || type == 'redirect') {
		return [
			{'width': '47%'},
			null,
			{'width': '1%', 'orderable': false, 'class': 'center'}
		];
	}
}
// save number of rows to display between each table
var lastPageLength = 10;
$('#tab-editor').on('change', '.dataTables_length select', function(e) {
	lastPageLength = this.value;
});

function reloadCurrentTable() {
	editor_type = $('#tabs_editor > li.active > a').attr('editor-type');
	lang = $('#tabs_editor_lang > li.active > a').attr('editor-lang');
	
	$('#seo_editor_'+editor_type).dataTable().api().page.len(lastPageLength);
	$('#seo_editor_'+editor_type).dataTable().api().ajax.url('index.php?route=module/complete_seo/editor_data&type=' + editor_type + '&lang=' + lang + '&token=<?php echo $token; ?>').load();
}
	
$(document).ready(function() {
	
	
	$('#tabs_editor a, #tabs_editor_lang a').on('shown.bs.tab', function() {
		editor_type = $('#tabs_editor > li.active > a').attr('editor-type');
		lang = $('#tabs_editor_lang > li.active > a').attr('editor-lang');
		is_instancied = $($('#tabs_editor > li.active > a').attr('href') + ' .dataTable').length;
		if(!is_instancied) {
			$('#seo_editor_'+editor_type).dataTable({
				"processing": true,
				"serverSide": true,
				"ajax": 'index.php?route=module/complete_seo/editor_data&type=' + editor_type + '&lang=' + lang + '&token=<?php echo $token; ?>',
				"order": [1, 'asc'],
				"lengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
				"pageLength": lastPageLength,
				"language": {
					paginate: {
						first: '<<',
						previous: '<',
						next: '>',
						last: '>>'
					},
					"processing": '<img style="z-index:10;position:absolute;left:43%" src="view/seo_package/img/bigloader.gif"/>',
					"info": '_START_ - _END_ / _TOTAL_',
					"infoFiltered": ''
				},
				"columns": columnsArray(editor_type)
			});
		}
		else {
			reloadCurrentTable();
		}
	});
	
	$('#tabs_editor a:first').trigger('shown.bs.tab');
	
	// editor
	$.fn.editable.defaults.mode = 'inline';
	$.fn.editable.defaults.emptytext = '';
	
  <?php /*
  var products = [<?php foreach ($products as $p) { ?>{id:'<?php echo $p['product_id']?>', text:'<?php echo $p['name']?>'},<?php } ?>];
  */ ?>

  var select2Active = false;
  
  $('.seo_editor').on('click', 'a.select2', function(e) {
    var select =  $(this).parent().find('select');
    if (!select.is(':visible')) {
      $('.select2-input').hide();
      $('a.select2').show();
      $(this).hide();
      $(this).prev().show();
      select.attr('data-pk');
      select.select2({
        minimumInputLength:1,
        width: '100%',
        placeholder: 'Choose product',
        ajax: {
          url: 'index.php?route=module/complete_seo/product_search&token=<?php echo $token; ?>',
          dataType: 'json',
          delay: 250,
        }
      });
    }
    select2Active = true;
  });

  $('.seo_editor').on('click', 'button.select2-submit', function(e) {
    e.preventDefault();
    
    $.ajax({
      url: 'index.php?route=module/complete_seo/editor_update&token=<?php echo $token; ?>',
      data: {
        'pk': $(this).parent().parent().find('select').attr('data-pk'),
        'col': $(this).parent().parent().find('select').attr('data-col'),
        'value': $(this).parent().parent().find('select').val()
      },
      dataType: 'json',
      method: 'post',
      success: function(data){
        $('a.select2[pk='+data.pk+']').html(data.msg);
        $('.select2-input').hide();
        $('a.select2').show();
        
        var $e = $('a.select2[pk='+data.pk+']').closest('td');
                    
        $e.css('background-color', '#9EC499');
        setTimeout(function(){
          $e.css('background-color', '');
          $e.addClass('editable-bg-transition');
          setTimeout(function(){
             $e.removeClass('editable-bg-transition');  
          }, 1700);
        }, 10);
      },
      error: function(xhr){
        if (xhr.responseText.length > 1000) {
          alert('Your session has terminated, please log-in again');
        } else {
          alert(xhr.responseText);
        }
      }
    });
  });
  
  // close selector on click elsewhere
  $('html').on('click', function(e) {
    if(!select2Active && !$('.select2-container').is('.select2-container--open')) {
      $('.select2-input').hide();
      $('a.select2').show();
    }
    select2Active = false;
  });
  
  // prevent closing selector
	$('.seo_editor').on('select2:unselect select2:close', '.select2-input', function(e) {
     select2Active = true;
	});
	$('.seo_editor').on('click', '.select2-container--open', function(e) {
      select2Active = true;
	});
  
	$('.seo_editor').editable({
		selector: 'a[data-pk]',
		highlight: false,
		ajaxOptions: {dataType: 'json'},
		success: function(response, newValue) {
			
			var $e = $(this).closest('td');
                    
			$e.css('background-color', '#9EC499');
			setTimeout(function(){
				$e.css('background-color', '');
				$e.addClass('editable-bg-transition');
				setTimeout(function(){
				   $e.removeClass('editable-bg-transition');  
				}, 1700);
			}, 10);
			
			if(!response) {
				return "Unknown error";
			} else if(response.status == 'error') {
				return response.msg;
			} else if(response.status == 'success') {
				return {newValue: response.msg};
			}else if(response.status == 'success-related') {
        $e.html(response.msg);
        //$('a.related[data-pk="'+response.pk+'"]').text(response.msg);
				//return {newValue: response.val};
			}
			
		},
	    error: function(response, newValue) {
			return 'Request error (session terminated ?)';
		},
		url: 'index.php?route=module/complete_seo/editor_update&token=<?php echo $token; ?>'
	});
  
	$('.seo_editor').on('click', 'td', function(e) {
    $('.editable').editable('option', 'params', {
      'type': $('#tabs_editor > li.active > a').attr('editor-type'),
      'col': $(e.target).closest('.seo_editor').find('th').eq($(this).index()).attr('data-column'),
      'lang': $('#tabs_editor_lang > li.active > a').attr('editor-lang')
    });
    
    if ($(this).find('.select2-input').is(':visible')) {
      select2Active = true;
    }
    
		if ($(e.target).is('td') && $(this).find('> a').length) {
			$(this).find('> a').trigger('click');
			return false;
		} else if ($(e.target).is('td') && $(this).find('> a.modal-related').length) {
			$(this).find('> a.modal-related').trigger('click');
			return false;
		}
	});
  
  $('body').on('click', '.info-btn', function() {
    $('#modal-info').html('<div style="text-align:center"><img src="view/complete_seo/img/loader.gif" alt=""/></div>');
    $('#modal-info').load('index.php?route=module/complete_seo/modal_info&token=<?php echo $token; ?>', {'info': $(this).attr('data-info')});
  });
  
  $('body').on('click', '.modal-related', function() {
    $('#modal-info').html('<div style="text-align:center"><img src="view/complete_seo/img/loader.gif" alt=""/></div>');
    $('#modal-info').load('index.php?route=module/complete_seo/modal_related&token=<?php echo $token; ?>', {'id': $(this).attr('data-pk')});
  });
	
	$('.seo_editor').on('click', '.deleteAlias', function(e) {
		if (confirm('<?php echo $_language->get('text_seo_confirm'); ?>')) {
      editor_type = $('#tabs_editor > li.active > a').attr('editor-type');
			$.ajax({
				url: 'index.php?route=module/complete_seo/editor_delete_alias&type='+ editor_type +'&pk='+$(this).attr('data-pk')+'&token=<?php echo $token; ?>',
				success: function(){ reloadCurrentTable(); }
			});
		}
	});
	$('#newAliasModal').on('show.bs.modal', function (e) {
	  editor_type = $('#tabs_editor > li.active > a').attr('editor-type');
		$('#newAliasModal .modalinfo').hide();
    $('#newAliasModal .' + editor_type).show();
	})
	$('.modal').on('click', '.addAlias', function(e) {
		editor_type = $('#tabs_editor > li.active > a').attr('editor-type');
		lang = $('#tabs_editor_lang > li.active > a').attr('editor-lang');
		$.ajax({
			url: 'index.php?route=module/complete_seo/editor_add_alias&type='+ editor_type +'&lang='+ lang +'&token=<?php echo $token; ?>',
			data: $('#newAliasModal form').serialize(),
			success: function(){ $('#newAliasModal').modal('hide'); reloadCurrentTable(); }
		});
	});
	$('.more_actions').on('click', '.restoreAliases', function(e) {
		if (confirm('<?php echo $_language->get('text_seo_confirm'); ?>')) {
			editor_type = $('#tabs_editor > li.active > a').attr('editor-type');
			lang = $('#tabs_editor_lang > li.active > a').attr('editor-lang');
			lang_code = $('#tabs_editor_lang > li.active > a').attr('editor-lang-code');
			$.ajax({
				url: 'index.php?route=module/complete_seo/editor_restore_aliases&type='+ editor_type +'&lang='+ lang +'&lang_code='+ lang_code +'&token=<?php echo $token; ?>',
				success: function(){ reloadCurrentTable(); }
			});
		}
	});
	$('.more_actions').on('click', '.exportAliases', function(e) {
		editor_type = $('#tabs_editor > li.active > a').attr('editor-type');
		lang = $('#tabs_editor_lang > li.active > a').attr('editor-lang');
		lang_code = $('#tabs_editor_lang > li.active > a').attr('editor-lang-code');
		url = 'index.php?route=module/complete_seo/editor_export_aliases&type='+ editor_type +'&lang='+ lang +'&lang_code='+ lang_code +'&token=<?php echo $token; ?>';
		window.open(url, '_blank');
	});
	$('.more_actions').on('click', '.deleteAliases', function(e) {
		if (confirm('<?php echo $_language->get('text_seo_confirm'); ?>')) {
			editor_type = $('#tabs_editor > li.active > a').attr('editor-type');
			lang = $('#tabs_editor_lang > li.active > a').attr('editor-lang');
			$.ajax({
				url: 'index.php?route=module/complete_seo/editor_delete_aliases&type='+ editor_type +'&lang='+ lang +'&token=<?php echo $token; ?>',
				success: function(){ reloadCurrentTable(); }
			});
		}
	});
});
//--></script>
<?php if ($OC_V2) { ?>
<style>
#update_result{margin-top:40px;}
</style>
<?php } ?>
<?php echo $footer; ?>