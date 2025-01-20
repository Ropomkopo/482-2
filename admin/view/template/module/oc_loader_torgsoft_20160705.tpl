<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content">

    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
            	<?php if (isset($oc_loader_torgsoft_file_exist)){ ?>
            	  <?php if ($oc_loader_torgsoft_file_exist){ ?>
                   <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                  <?php } ?>
                <?php }else{ ?>
                  <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <?php } ?>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
            <h1 style="background: url(view/image/oc_loader_torgsoft.png) no-repeat;display:block;">&nbsp;&nbsp;&nbsp;<?php echo $heading_title; ?></h1>
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
        <?php if ($error) { ?>
        <?php foreach ($error as $key => $error_message){ ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_message; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $oc_loader_torgsoft_text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
                    <ul id="tabs" class="nav nav-tabs tab-up">
                        <li class="active"><a href="#tab-general" data-target="#tab-general" class="media_node active span" id="general_tab" data-toggle="tabajax" rel="tooltip"><?php echo $oc_loader_torgsoft_text_tab_general; ?></a></li>
                        <li><a href="#tab-product" data-target="#tab-product" class="media_node span" id="product_tab" data-toggle="tabajax" rel="tooltip"><?php echo $oc_loader_torgsoft_text_tab_product; ?></a></li>
                        <li><a href="#tab-order" data-target="#tab-order" class="media_node span" id="order_tab" data-toggle="tabajax" rel="tooltip"><?php echo $oc_loader_torgsoft_text_tab_order; ?></a></li>
                    </ul>
                    <div class="tab-content">

                        <div id="tab-general" class="tab-pane active">
                        	<div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_status"><?php echo $oc_loader_torgsoft_text_status; ?></label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="oc_loader_torgsoft_status">
                                    <?php if ($oc_loader_torgsoft_status) { ?>
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
                            <?php if ($oc_loader_torgsoft_enabled){ ?>
                         			<center><label class="col-sm-4 control-label" style="float:none; width:auto; color:green;"><?php echo $oc_loader_torgsoft_licese_msg ?></label></center>
                         	<?php } ?>
                         	</div>
                        </div>

					<?php if ($oc_loader_torgsoft_enabled){ ?>
                        <div id="tab-product" class="tab-pane">
                        	<div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_trs_dir"><span data-toggle="tooltip" title="<?php echo $oc_loader_torgsoft_help_text_trs_file; ?>"><?php echo $oc_loader_torgsoft_text_trs_file; ?></span></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_trs_file" type="text" value="<?php echo $oc_loader_torgsoft_trs_file; ?>" /></div>
                            </div>

							<?php if (!$oc_loader_torgsoft_file_exist){ ?>
							<div class="form-group">
								<center>
									<font color="red" weight="bold"><?php echo $oc_loader_torgsoft_attention; ?></font>
									<br /><br />
							 		<button type="submit" form="form" name="return" value="test_file"><?php echo $oc_loader_torgsoft_save_trs_file; ?></button>
							 	</center>
							 </div>
							<?php }else{ ?>
                            <hr />
                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_file_code"><?php echo $oc_loader_torgsoft_text_file_code; ?></label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="oc_loader_torgsoft_file_code">
                                    <?php if ($oc_loader_torgsoft_file_code == 'windows') { ?>
                                    <option value="windows" selected="selected">windows</option>
                                    <option value="utf-8">utf-8</option>
                                    <?php } else { ?>
                                    <option value="windows">windows</option>
                                    <option value="utf-8" selected="selected">utf-8</option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                            	<?php echo $two_strings; ?>
                            </div>
                            <div class="form-group">
								<center>
							 		<button type="submit" form="form" name="return" value="test_file"><?php echo $oc_loader_torgsoft_save_file_code; ?></button>
							 	</center>
							 </div>
							 <hr />
							 <div class="form-group" style="overflow-x:scroll;">
								<center>
							 		<?php echo $table12 ?>
							 	</center>
							 </div>
							 
							<hr />
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo $oc_loader_torgsoft_text_add_new_products; ?></td></label>
                                <div class="col-sm-8">
                                <select class="form-control" name="oc_loader_torgsoft_add_new_products">
                                <?php foreach ($oc_loader_torgsoft_add_new_products as $i => $value){ ?>
                                	<option value="<?php echo $value['value'];?>" <?php echo ($value['selected']==1)? 'selected' : '' ;?>><?php echo $value['name'];?></option>
                                <?php } ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo $oc_loader_torgsoft_text_add_new_products_zero; ?></td></label>
                                <div class="col-sm-8">
                                <select class="form-control" name="oc_loader_torgsoft_add_new_products_zero">
                                <?php foreach ($oc_loader_torgsoft_add_new_products_zero as $i => $value){ ?>
                                	<option value="<?php echo $value['value'];?>" <?php echo ($value['selected']==1)? 'selected' : '' ;?>><?php echo $value['name'];?></option>
                                <?php } ?>
                                </select>
                                </div>
                            </div>
							 
                            <hr />
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo $oc_loader_torgsoft_text_parameters; ?></td></label>
                                <div class="col-sm-8"><?php echo $oc_loader_torgsoft_text_column_title; ?></div>
                            </div>
                            
                            <?php foreach ($oc_loader_torgsoft_main as $pole => $main){ ?>
                            <div class="form-group <?php echo $main['star']==''?'':'required'; ?>">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_<?php echo $pole ?>"><?php echo $main['title'].'<br/>'.$main['comment']; ?></td></label>
                                <div class="col-sm-8">
                                <select class="form-control" name="oc_loader_torgsoft_<?php echo $pole ?>">
                                <?php foreach ($main['option'] as $i => $value){ ?>
                                	<option value="<?php echo $value['name'];?>" <?php echo ($value['selected']==1)? 'selected' : '' ;?>><?php echo $value['name'];?></option>
                                <?php } ?>
                                </select>
                                	<?php if ($pole != 'GoodID'){ ?>
                                	<div class="col-sm-10">
                                    <label class="checkbox-inline">
                   						<input type="checkbox" name="oc_loader_torgsoft_update_<?php echo $pole ?>" value="1" <?php echo $main['checked'] ?> /> <?php echo $oc_loader_torgsoft_text_update ?>
                   	                 </label>
                                 	</div>
                                 	<?php } ?>
                                 	<?php if ($pole == 'name'){ ?>
                                 		<div class="col-sm-10">
                                   		<label class="checkbox-inline">
                   							<input type="checkbox" name="oc_loader_torgsoft_strip_name" value="1" <?php echo $main['strip_name'] ?> /> <?php echo $oc_loader_torgsoft_text_strip ?>
                   	                 	</label>
                                 	</div>
                                 	<?php } ?>
                                 	<?php if (in_array($pole, $keys)){ ?>
	                                 	<div class="col-sm-10">
	                 					<label class="radio-inline">
	                                    <input type="radio" name="oc_loader_torgsoft_key" value="<?php echo $pole; ?>" <?php echo $main['key_checked'] ?> /> <?php echo $oc_loader_torgsoft_text_keys ?>
	                                    </label>
	                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                            	
                            <hr />
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo $oc_loader_torgsoft_text_attributes_title; ?></td></label>
                                <div class="col-sm-8"></div>
                            </div>
                            
                             <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_attributes_group"><?php echo $oc_loader_torgsoft_text_attributes_group_title; ?></td></label>
                                <div class="col-sm-8">
                                <select class="form-control" name="oc_loader_torgsoft_attributes_group">
                                <?php foreach ($attributes_groups as $i => $value){ ?>
                                	<option value="<?php echo $value['value'];?>" <?php echo ($value['selected']==1)? 'selected' : '' ;?>><?php echo $value['name'];?></option>
                                <?php } ?>
                                </select>
                                </div>
                            </div>
                             <div class="form-group">
								<center>
							 		<button type="submit" form="form" name="return" value="test_file"><?php echo $oc_loader_torgsoft_save_attributes_group; ?></button>
							 	</center>
							 </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo $oc_loader_torgsoft_text_attributes_title2; ?></td></label>
                                <div class="col-sm-8"><?php echo $oc_loader_torgsoft_text_column_title; ?></div>
                            </div>
                            
                            <?php foreach ($oc_loader_torgsoft_attributes as $pole => $attribute){ ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_<?php echo $pole ?>"><?php echo $attribute['star'].$attribute['title'].'<br/>'.$attribute['comment']; ?></td></label>
                                <div class="col-sm-8">
                                <?php if (isset($attribute['alert'])){ ?>
                                	<?php echo $oc_loader_torgsoft_text_attributes_alert; ?>
                                <? }else{ ?>
	                                <select class="form-control" name="oc_loader_torgsoft_<?php echo $pole ?>">
	                                <?php foreach ($attribute['option'] as $i => $value){ ?>
	                                	<option value="<?php echo $value['name'];?>" <?php echo ($value['selected']==1)? 'selected' : '' ;?>><?php echo $value['name'];?></option>
	                                 <?php } ?>
	                                </select>
                                	<div class="col-sm-10">
                                     <label class="checkbox-inline">
                   						<input type="checkbox" name="oc_loader_torgsoft_update_<?php echo $pole ?>" value="1" <?php echo $attribute['checked'] ?> /> <?php echo $oc_loader_torgsoft_text_update ?>
                   	                 </label>
                                 	</div>
                                <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                            
                            <hr />
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo $oc_loader_torgsoft_text_parameters_title; ?></td></label>
                                <div class="col-sm-8"></div>
                            </div>
                            
                            <?php foreach ($oc_loader_torgsoft_defailt_values as $pole => $default){ ?>
                            	<?php if (isset($default['option'])){ ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_<?php echo $pole ?>"><?php echo $default['title']; ?></td></label>
                                <div class="col-sm-8">
                                <select class="form-control" name="oc_loader_torgsoft_<?php echo $pole ?>">
                                <?php foreach ($default['option'] as $i => $value){ ?>
                                	<option value="<?php echo $value['value'];?>" <?php echo ($value['selected']==1)? 'selected' : '' ;?>><?php echo $value['name'];?></option>
                                <?php } ?>
                                </select>
                                </div>
                            </div>
                            	<?php }else{ ?>
                            <div class="form-group">
                            	<label class="col-sm-4 control-label" for="oc_loader_torgsoft_<?php echo $pole ?>"><?php echo $default['title']; ?></td></label>
                            	<div class="col-sm-8">
                            	<input class="form-control" name="oc_loader_torgsoft_<?php echo $pole ?>" type="text" value="<?php echo $default['value']; ?>" />
                            	</div>
                            </div>
                            	<?php } ?>
                            <?php } ?>
                            
                            <hr />
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo $oc_loader_torgsoft_text_formulas_category; ?></td></label>
                                <div class="col-sm-8"><?php echo $oc_loader_torgsoft_text_formulas_category_comment; ?></div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_meta_title_category"><?php echo $oc_loader_torgsoft_text_meta_title_category; ?></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_meta_title_category" type="text" value="<?php echo $oc_loader_torgsoft_meta_title_category; ?>" /></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_meta_h1_category"><?php echo $oc_loader_torgsoft_text_meta_h1_category; ?></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_meta_h1_category" type="text" value="<?php echo $oc_loader_torgsoft_meta_h1_category; ?>" /></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_meta_description_category"><?php echo $oc_loader_torgsoft_text_meta_description_category; ?></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_meta_description_category" type="text" value="<?php echo $oc_loader_torgsoft_meta_description_category; ?>" /></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_meta_keywords_category"><?php echo $oc_loader_torgsoft_text_meta_keywords_category; ?></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_meta_keywords_category" type="text" value="<?php echo $oc_loader_torgsoft_meta_keywords_category; ?>" /></div>
                            </div>
                            
                            <hr />
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo $oc_loader_torgsoft_text_formulas_product; ?></td></label>
                                <div class="col-sm-8"><?php echo $oc_loader_torgsoft_text_formulas_product_comment; ?></div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_meta_title"><?php echo $oc_loader_torgsoft_text_meta_title; ?></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_meta_title" type="text" value="<?php echo $oc_loader_torgsoft_meta_title; ?>" />
                            	<div class="col-sm-10">
                                  <label class="checkbox-inline">
                   					<input type="checkbox" name="oc_loader_torgsoft_update_meta_title" value="1" <?php echo $oc_loader_torgsoft_update_meta_title ?> /> <?php echo $oc_loader_torgsoft_text_update ?>
                   	              </label>
                                 </div>
                                 </div>
                            </div>
                             <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_meta_h1"><?php echo $oc_loader_torgsoft_text_meta_h1; ?></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_meta_h1" type="text" value="<?php echo $oc_loader_torgsoft_meta_h1; ?>" />
                            	<div class="col-sm-10">
                                  <label class="checkbox-inline">
                   					<input type="checkbox" name="oc_loader_torgsoft_update_meta_h1" value="1" <?php echo $oc_loader_torgsoft_update_meta_h1 ?> /> <?php echo $oc_loader_torgsoft_text_update ?>
                   	              </label>
                                 </div>
                                 </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_meta_description"><?php echo $oc_loader_torgsoft_text_meta_description; ?></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_meta_description" type="text" value="<?php echo $oc_loader_torgsoft_meta_description; ?>" />
                                <div class="col-sm-10">
                                  <label class="checkbox-inline">
                   					<input type="checkbox" name="oc_loader_torgsoft_update_meta_description" value="1" <?php echo $oc_loader_torgsoft_update_meta_description ?> /> <?php echo $oc_loader_torgsoft_text_update ?>
                   	              </label>
                                 </div>
                                 </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_meta_keywords"><?php echo $oc_loader_torgsoft_text_meta_keywords; ?></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_meta_keywords" type="text" value="<?php echo $oc_loader_torgsoft_meta_keywords; ?>" />
                                <div class="col-sm-10">
                                  <label class="checkbox-inline">
                   					<input type="checkbox" name="oc_loader_torgsoft_update_meta_keywords" value="1" <?php echo $oc_loader_torgsoft_update_meta_keywords?> /> <?php echo $oc_loader_torgsoft_text_update ?>
                   	              </label>
                                 </div>
                                 </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_seourl"><?php echo $oc_loader_torgsoft_text_seourl; ?></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_seourl" type="text" value="<?php echo $oc_loader_torgsoft_seourl; ?>" />
                                <div class="col-sm-10">
                                  <label class="checkbox-inline">
                   					<input type="checkbox" name="oc_loader_torgsoft_update_seourl" value="1" <?php echo $oc_loader_torgsoft_update_seourl?> /> <?php echo $oc_loader_torgsoft_text_update ?>
                   	              </label>
                                 </div>
                                 </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_words_deleted_from_tag"><?php echo $oc_loader_torgsoft_text_words_deleted_from_tag; ?></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_words_deleted_from_tag" type="text" value="<?php echo $oc_loader_torgsoft_words_deleted_from_tag; ?>" />
                                <div class="col-sm-10">
                                  <label class="checkbox-inline">
                   					<input type="checkbox" name="oc_loader_torgsoft_update_words_deleted_from_tag" value="1" <?php echo $oc_loader_torgsoft_update_words_deleted_from_tag ?> /> <?php echo $oc_loader_torgsoft_text_update_tag ?>
                   	              </label>
                                 </div>
                                 </div>
                            </div>
                            
                            <hr />
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo $oc_loader_torgsoft_text_images; ?></td></label>
                                <div class="col-sm-8"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_image_ext"><?php echo $oc_loader_torgsoft_text_image_ext; ?></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_image_ext" type="text" value="<?php echo $oc_loader_torgsoft_image_ext; ?>" /></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_image_output"><?php echo $oc_loader_torgsoft_text_image_output; ?></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_image_output" type="text" value="<?php echo $oc_loader_torgsoft_image_output; ?>" /></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_image_quality"><?php echo $oc_loader_torgsoft_text_image_quality; ?></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_image_quality" type="text" value="<?php echo $oc_loader_torgsoft_image_quality; ?>" /></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_image_dir"><?php echo $oc_loader_torgsoft_text_image_dir; ?></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_image_dir" type="text" value="<?php echo $oc_loader_torgsoft_image_dir; ?>" /></div>
                            </div>
                            
                            <hr />
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo $oc_loader_torgsoft_text_special; ?></td></label>
                                <div class="col-sm-8"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo $oc_loader_torgsoft_text_hide_missing_products; ?></td></label>
                                <div class="col-sm-8">
                                <select class="form-control" name="oc_loader_torgsoft_hide_missing_products">
                                <?php foreach ($oc_loader_torgsoft_hide_missing_products as $i => $value){ ?>
                                	<option value="<?php echo $value['value'];?>" <?php echo ($value['selected']==1)? 'selected' : '' ;?>><?php echo $value['name'];?></option>
                                <?php } ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo $oc_loader_torgsoft_text_hide_products_with_zero_quantity; ?></td></label>
                                <div class="col-sm-8">
                                <select class="form-control" name="oc_loader_torgsoft_hide_products_with_zero_quantity">
                                <?php foreach ($oc_loader_torgsoft_hide_products_with_zero_quantity as $i => $value){ ?>
                                	<option value="<?php echo $value['value'];?>" <?php echo ($value['selected']==1)? 'selected' : '' ;?>><?php echo $value['name'];?></option>
                                <?php } ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?php echo $oc_loader_torgsoft_text_show_not_changed; ?></td></label>
                                <div class="col-sm-8">
                                <select class="form-control" name="oc_loader_torgsoft_show_not_changed">
                                <?php foreach ($oc_loader_torgsoft_show_not_changed as $i => $value){ ?>
                                	<option value="<?php echo $value['value'];?>" <?php echo ($value['selected']==1)? 'selected' : '' ;?>><?php echo $value['name'];?></option>
                                <?php } ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_cache"><span data-toggle="tooltip" title="<?php echo $oc_loader_torgsoft_text_help_cache; ?>"><?php echo $oc_loader_torgsoft_text_cache; ?></span></label>
                                <div class="col-sm-8"><input class="form-control" name="oc_loader_torgsoft_cache" type="text" value="<?php echo $oc_loader_torgsoft_cache; ?>" /></div>
                            </div>
                            
                        <?php } ?>
                        </div>

						<?php if ($oc_loader_torgsoft_file_exist){ ?>
                        <div id="tab-order" class="tab-pane">
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_order_status_to_exchange"><?php echo $oc_loader_torgsoft_text_entry_order_status_to_exchange; ?></label>
                                <div class="col-sm-8"><select class="form-control" name="oc_loader_torgsoft_order_status_to_exchange">
                                            <?php foreach ($order_statuses as $order_status) { ?>
                                            <option value="<?php echo $order_status['order_status_id'];?>" <?php echo ($oc_loader_torgsoft_order_status_to_exchange == $order_status['order_status_id'])? 'selected' : '' ;?>><?php echo $order_status['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="oc_loader_torgsoft_order_status"><?php echo $oc_loader_torgsoft_text_entry_order_status; ?></label>
                                <div class="col-sm-8">
                                        <select class="form-control" name="oc_loader_torgsoft_order_status">
                                            <?php foreach ($order_statuses as $order_status) { ?>
                                            <option value="<?php echo $order_status['order_status_id'];?>" <?php echo ($oc_loader_torgsoft_order_status == $order_status['order_status_id'])? 'selected' : '' ;?>><?php echo $order_status['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                </div>
                            </div>
						<?php } ?>
                        </div>
                    <?php } ?>
                </div>
                
            <hr />
            <div style="text-align:center; opacity: .5">
                <p><?php echo $oc_loader_torgsoft_version_text; ?> | <a target="_blank" href="<?php echo $LS; ?>"><?php echo $oc_loader_torgsoft_text_homepage; ?></a> | <a target="_blank" href="http://torgsoft.ua">Торгсофт</a></p>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    //$('.panel-body #tabs a').click(function (e) {
    $('[data-toggle="tabajax"]').click(function (e){
        e.preventDefault();
        $(this).tab('show');
        return false;
    });
</script>

<script type="text/javascript">
    var filesToUpload;
    $('#fileInput').on('change', function(e){
        filesToUpload = e.target.files;
    });

    $('#button-upload').click(function(e){
        e.preventDefault();
        var data = new FormData();
        $.each(filesToUpload, function(key,value){
            data.append('file',value);
        });
        var progress = $('#loading');
        $.ajax({
            url: "index.php?route=module/oc_loader_torgsoft/manualImport&token=<?php echo $token; ?>",
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            xhr: function (){
                var xhr = new XMLHttpRequest();
                xhr.addEventListener('progress',function(e){
                    //console.log(e.lengthComputable);
                    if (e.lengthComputable){
                        var percentComplete = e.loaded / e.total;
                        progress.html(Math.round(percentComplete * 100)+"%");
                    }
                },false);
                return xhr;
            },
            beforeSend: function (){
                progress.removeClass('hide');
            },
            complete: function (){
                progress.addClass('hide');
            },
            success: function(data, textStatus, jqXHR){
                if (typeof data.error === 'undefined'){
                    return false;
                }else{
                    console.log('ERROR: '+data.error);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
                console.log(errorThrown);
            }
        });
        return false;
    });

</script>

    <!--<script type="text/javascript" src="view/javascript/jquery/ajaxupload.js"></script>
    <script type="text/javascript"><!--
        new AjaxUpload('#button-upload', {
            action: 'index.php?route=module/oc_loader_torgsoft/manualImport&token=<?php echo $token; ?>',
            name: 'file',
            autoSubmit: true,
            responseType: 'json',
            onSubmit: function(file, extension) {
                $('#button-upload').after('<img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" />');
                $('#button-upload').attr('disabled', true);
            },
            onComplete: function(file, json) {
                $('#button-upload').attr('disabled', false);
                $('.loading').remove();

                if (json['success']) {
                    alert(json['success']);
                }

                if (json['error']) {
                    alert(json['error']);
                }
            }
        });
</script>-->

<script type="text/javascript"><!--
function image_upload(field, thumb) {
  $('#dialog').remove();

  $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

  $('#dialog').dialog({
    title: '<?php echo $text_image_manager; ?>',
    close: function (event, ui) {
      if ($('#' + field).attr('value')) {
        $.ajax({
          url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
          dataType: 'text',
          success: function(data) {
            $('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
          }
        });
      }
    },
    bgiframe: false,
    width: 800,
    height: 400,
    resizable: false,
    modal: false
  });
};
//--></script>

<?php echo $footer; ?>