<?php 
	// ID Base For Label Navigation
	$_id	= 'store_' . $store['store_id'] . '_label_' . $label_id;
?>

<div id="<?php echo $_id; ?>" class="tab-pane">
	<ul class="nav nav-pills languageTabs">
		<li class="disabled"><a>Label Settings For Language:</a></li>
		<?php $i=0; foreach ($languages as $language) : ?>
			<?php 
				// ID Base Per Language
				$_id	= 'store_' . $store['store_id'] . '_label_' . $label_id . '_language_' . $language['language_id'];
			?>
			<li <?php echo ($i == 0) ? 'class="active"' : ''; ?>> <a href="#<?php echo $_id; ?>" data-toggle="pill">
					<?php echo $language['name'] ?>
					<?php if ($language['flag']) { ?>
						<img src="<?php echo $language['flag']; ?>" title="<?php echo $language['name']; ?>"  alt="<?php echo $language['name']; ?>" />
					<?php } ?>
			</a></li>
		<?php $i++; endforeach; ?>
	</ul>

	<hr />

	<div class="tab-content">
		<!-- Labels Settings Per Language -->
		<?php $i=0; foreach ($languages as $language) : ?>
			<?php 
				// ID Base Per Language
				$_id	= 'store_' . $store['store_id'] . '_label_' . $label_id . '_language_' . $language['language_id'];
				
				// Label Name Base Per Language
				$_lnb	= 'LabelMaker[' . $store['store_id'] . '][Labels][' . $label_id . '][' . $language['language_id']. ']';
				
				// Label
				if (!empty($data['LabelMaker'][$store['store_id']]['Labels'][$label_id][$language['language_id']])) {
					$_label	= $data['LabelMaker'][$store['store_id']]['Labels'][$label_id][$language['language_id']];
				} else {
					$_label	= NULL;
				}
			?>

			<div id="<?php echo $_id; ?>" class="tab-pane <?php echo ($i == 0) ? 'active' : ''; ?>">
				<div class="image_editor container-fluid"><div class="row">
					<div class="col-xs-6">
						<label><h3>1. Choose which products to label</h3></label>
						<div class="labelmaker-tab-container">
							<div class="labelmaker-tab-menu">
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-default <?php echo ((!empty($_label['LabelType']) && $_label['LabelType'] == 'category') || empty($_label['LabelType'])) ? 'active' : '' ?>">
										<input type="radio" name="<?php echo $_lnb; ?>[LabelType]" value="category" <?php echo !empty($_label['LabelType']) && $_label['LabelType'] == 'category' ? 'checked="checked"' : '' ?>>Category
									</label>
									<label class="btn btn-default <?php echo !empty($_label['LabelType']) && $_label['LabelType'] == 'specific' ? 'active' : '' ?>">
										<input type="radio" name="<?php echo $_lnb; ?>[LabelType]" value="specific" <?php echo !empty($_label['LabelType']) && $_label['LabelType'] == 'specific' ? 'checked="checked"' : '' ?>>Specific
									</label>
									<label class="btn btn-default <?php echo !empty($_label['LabelType']) && $_label['LabelType'] == 'manufacturer' ? 'active' : '' ?>">
										<input type="radio" name="<?php echo $_lnb; ?>[LabelType]" value="manufacturer" <?php echo !empty($_label['LabelType']) && $_label['LabelType'] == 'manufacturer' ? 'checked="checked"' : '' ?>>Manufacturer
									</label>
									<label class="btn btn-default <?php echo !empty($_label['LabelType']) && $_label['LabelType'] == 'product_module' ? 'active' : '' ?>">
										<input type="radio" name="<?php echo $_lnb; ?>[LabelType]" value="product_module" <?php echo !empty($_label['LabelType']) && $_label['LabelType'] == 'product_module' ? 'checked="checked"' : '' ?>>Product Type
									</label>
									<label class="btn btn-default <?php echo !empty($_label['LabelType']) && $_label['LabelType'] == 'special_condition' ? 'active' : '' ?>">
										<input type="radio" name="<?php echo $_lnb; ?>[LabelType]" value="special_condition" <?php echo !empty($_label['LabelType']) && $_label['LabelType'] == 'special_condition' ? 'checked="checked"' : '' ?>>Other Conditions
									</label>
								</div>
							</div>
							<div class="labelmaker-tab">
								<div class="labelmaker-tab-content active">
									<label><?php echo $entry_label_image_limit_categories; ?></label>
									<select class="form-control toggle-fade-next" name="<?php echo $_lnb; ?>[LimitCategories]">
										<option value="all"<?php echo !empty($_label['LimitCategories']) && $_label['LimitCategories'] == 'all' ? ' selected="selected"' : ''; ?>><?php echo $entry_all_categories; ?></option>
										<option value="specific"<?php echo !empty($_label['LimitCategories']) && $_label['LimitCategories'] == 'specific' ? ' selected="selected"' : ''; ?>><?php echo $entry_following_categories; ?></option>
									</select>
									<div <?php echo (empty($_label['LimitCategories']) || (!empty($_label['LimitCategories']) && $_label['LimitCategories'] == 'all')) ? ' style="display:none;"' : ''; ?>>
										<input class="form-control category-autocomplete" placeholder="Autocomplete.." data-store-id="<?php echo $store['store_id']; ?>" data-label-id="<?php echo $label_id; ?>" data-language-id="<?php echo $language['language_id']; ?>" type="text" /><br />
										<div id="product-category_<?php echo $_id; ?>" class="scrollbox">
											<?php if (!empty($product_categories)) { ?>
												<?php foreach ($product_categories[$store['store_id']]['Labels'][$label_id][$language['language_id']] as $product_category) { ?>
												<div id="product-category_<?php echo $_id; ?>_<?php echo $product_category['category_id']; ?>"> <?php echo $product_category['name']; ?><i class="fa-minus removeIcon"></i>
													<input type="hidden" name="<?php echo $_lnb; ?>[LimitCategoriesList][]" value="<?php echo $product_category['category_id']; ?>" />
												</div>
												<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="labelmaker-tab-content">
									<label><?php echo $entry_label_image_limit_products; ?></label>
									<select class="form-control toggle-fade-next" name="<?php echo $_lnb; ?>[LimitProducts]">
										<option value="all"<?php echo !empty($_label['LimitProducts']) && $_label['LimitProducts'] == 'all' ? ' selected="selected"' : ''; ?>><?php echo $entry_all_products; ?></option>
										<option value="specific"<?php echo !empty($_label['LimitProducts']) && $_label['LimitProducts'] == 'specific' ? ' selected="selected"' : ''; ?>><?php echo $entry_following_products; ?></option>
									</select>
									<div <?php echo (empty($_label['LimitProducts']) || (!empty($_label['LimitProducts']) && $_label['LimitProducts'] == 'all')) ? ' style="display:none;"' : ''; ?>>
										<input class="form-control products-autocomplete" placeholder="Autocomplete.." data-store-id="<?php echo $store['store_id']; ?>" data-label-id="<?php echo $label_id; ?>" data-language-id="<?php echo $language['language_id']; ?>" type="text" /><br />
										<div id="product-<?php echo $_id; ?>" class="scrollbox">
											<?php if (!empty($products)) { ?>
												<?php foreach ($products[$store['store_id']]['Labels'][$label_id][$language['language_id']] as $product) { ?>
												<div id="product-<?php echo $_id; ?>_<?php echo $product['product_id']; ?>"> <?php echo $product['name']; ?><i class="fa-minus removeIcon"></i>
													<input type="hidden" name="<?php echo $_lnb; ?>[LimitProductsList][]" value="<?php echo $product['product_id']; ?>" />
												</div>
												<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="labelmaker-tab-content">
									<label>Apply the label to products from these manufacturers:</label>
									<select class="form-control toggle-fade-next" name="<?php echo $_lnb; ?>[LimitManufacturers]">
										<option value="all"<?php echo !empty($_label['LimitManufacturers']) && $_label['LimitManufacturers'] == 'all' ? ' selected="selected"' : ''; ?>>All manufacturers</option>
										<option value="specific"<?php echo !empty($_label['LimitManufacturers']) && $_label['LimitManufacturers'] == 'specific' ? ' selected="selected"' : ''; ?>>The following manufacturers</option>
									</select>
									<div <?php echo (empty($_label['LimitManufacturers']) || (!empty($_label['LimitManufacturers']) && $_label['LimitManufacturers'] == 'all')) ? ' style="display:none;"' : ''; ?>>
										<input class="form-control manufacturer-autocomplete" placeholder="Autocomplete.." data-store-id="<?php echo $store['store_id']; ?>" data-label-id="<?php echo $label_id; ?>" data-language-id="<?php echo $language['language_id']; ?>" type="text" /><br />
										<div id="product-manufacturer_<?php echo $_id; ?>" class="scrollbox">
											<?php if (!empty($product_manufacturers)) { ?>
												<?php foreach ($product_manufacturers[$store['store_id']]['Labels'][$label_id][$language['language_id']] as $product_manufacturer) { ?>
												<div id="product-manufacturer_<?php echo $_id; ?>_<?php echo $product_manufacturer['manufacturer_id']; ?>"><?php echo $product_manufacturer['name']; ?><i class="fa-minus removeIcon"></i>
													<input type="hidden" name="<?php echo $_lnb; ?>[LimitManufacturersList][]" value="<?php echo $product_manufacturer['manufacturer_id']; ?>" />
												</div>
												<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="labelmaker-tab-content">
									<label>Apply the label on certain product types<span class="help">These are also applied to the default OpenCart product modules.</span></label>
									<div class="row">
										<div class="btn-group col-xs-12" data-toggle="buttons">
											<label class="btn btn-default <?php echo !empty($_label['ProductModules']['Bestseller']) && (int)$_label['ProductModules']['Bestseller'] == 1 ? 'active' : '' ?>">
												<input <?php echo !empty($_label['ProductModules']['Bestseller']) && (int)$_label['ProductModules']['Bestseller'] == 1 ? 'checked="checked"' : '' ?> type="checkbox" name="<?php echo $_lnb; ?>[ProductModules][Bestseller]" value="1">Bestseller
											</label>
											<label class="btn btn-default <?php echo !empty($_label['ProductModules']['Special']) && (int)$_label['ProductModules']['Special'] == 1 ? 'active' : '' ?>">
												<input <?php echo !empty($_label['ProductModules']['Special']) && (int)$_label['ProductModules']['Special'] == 1 ? 'checked="checked"' : '' ?> type="checkbox" name="<?php echo $_lnb; ?>[ProductModules][Special]" value="1">Special
											</label>
											<label class="btn btn-default <?php echo !empty($_label['ProductModules']['Latest']) && (int)$_label['ProductModules']['Latest'] == 1 ? 'active' : '' ?>">
												<input <?php echo !empty($_label['ProductModules']['Latest']) && (int)$_label['ProductModules']['Latest'] == 1 ? 'checked="checked"' : '' ?> type="checkbox" name="<?php echo $_lnb; ?>[ProductModules][Latest]" value="1">Latest
											</label>
											<!-- Disabled In OC2 -->
											<!-- <label class="btn btn-default <?php echo !empty($_label['ProductModules']['Featured']) && (int)$_label['ProductModules']['Featured'] == 1 ? 'active' : '' ?>">
												<input <?php echo !empty($_label['ProductModules']['Featured']) && (int)$_label['ProductModules']['Featured'] == 1 ? 'checked="checked"' : '' ?> type="checkbox" name="<?php echo $_lnb; ?>[ProductModules][Featured]" value="1">Featured
											</label> -->
										</div>
									</div>
									<hr />
									<div class="row">
										<div class="col-xs-6">
											<label>Limit labeled bestseller products to:</label>
											<input class="form-control" type="text" name="<?php echo $_lnb; ?>[ProductModules][BestsellerLimit]" value="<?php echo (!empty($_label['ProductModules']['BestsellerLimit'])) ? (int)$_label['ProductModules']['BestsellerLimit']  : '10'; ?>">
										</div>
										<div class="col-xs-6">
											<label>Limit labeled latest products to:</label>
											<input class="form-control" type="text" name="<?php echo $_lnb; ?>[ProductModules][LatestLimit]" value="<?php echo (!empty($_label['ProductModules']['LatestLimit'])) ? (int)$_label['ProductModules']['LatestLimit']  : '10'; ?>">
										</div>
									</div>
								</div>
								<div class="labelmaker-tab-content">
									<label>Apply the label if out of stock status is</label>
									<div class="row">
										<div class="col-xs-12 stock_status_limit">
											<div class="bfh-selectbox" data-name="<?php echo $_lnb; ?>[StockStatus]" data-value="<?php echo (!empty($_label['StockStatus'])) ? $_label['StockStatus']  : 'no_limit'; ?>">
												<div data-value="no_limit">Any stock status (Don't limit)</div>

												<?php foreach ($stock_statuses as $stock_status) { ?> 
												<div data-value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></div>
												<?php } ?>
											</div>
										</div>
									</div>
									<br />
									<label>Apply the label if quantity is</label>
									<div class="row">
										<div class="col-xs-6 quantity_limit">
											<div class="bfh-selectbox" data-name="<?php echo $_lnb; ?>[QuantityType]" data-value="<?php echo (!empty($_label['QuantityType'])) ? $_label['QuantityType']  : 'no_limit'; ?>">
												<div data-value="no_limit">Any quantity (Don't limit)</div>
												<div data-value="more_than">More than</div>
												<div data-value="less_than">Less than</div>
											</div>
										</div>
										<div class="col-xs-6" <?php echo (empty($_label['QuantityType']) || (!empty($_label['QuantityType']) && $_label['QuantityType'] == 'no_limit')) ? ' style="display:none;"' : ''; ?>>
											<input type="number" class="form-control" name="<?php echo $_lnb; ?>[QuantityLimit]" min="0" value="<?php echo (!empty($_label['QuantityLimit'])) ? $_label['QuantityLimit'] : 10; ?>">
										</div>
									</div>
									<hr />
									<label>Apply the label if price is</label>
									<div class="row">
										<div class="col-xs-6 price_limit">
											<div class="bfh-selectbox" data-name="<?php echo $_lnb; ?>[PriceType]" data-value="<?php echo (!empty($_label['PriceType'])) ? $_label['PriceType']  : 'no_limit'; ?>">
												<div data-value="no_limit">Any price (Don't limit)</div>
												<div data-value="more_than">More than</div>
												<div data-value="less_than">Less than</div>
											</div>
										</div>
										<div class="col-xs-6" <?php echo (empty($_label['PriceType']) || (!empty($_label['PriceType']) && $_label['PriceType'] == 'no_limit')) ? ' style="display:none;"' : ''; ?>>
											<input type="number" class="form-control" name="<?php echo $_lnb; ?>[PriceLimit]" min="0" value="<?php echo (!empty($_label['PriceLimit'])) ? $_label['PriceLimit'] : 10; ?>">
										</div>
									</div>
								</div>
								<hr />
								<div class="row">
									<div class="col-xs-6">
										<label class="checkbox">
											<input type="checkbox" name="<?php echo $_lnb; ?>[AdditionalImages]" value="1" <?php echo (!empty($_label['AdditionalImages']) && $_label['AdditionalImages'] == 1) ? 'checked="checked"' : ''; ?>/>
											Apply label to additional images<br /><span class="help">Check this if you want to apply the label to the additional images of a product.</span>
										
										</label>
									</div>
									<div class="col-xs-6">
										<label class="checkbox">
											<input type="checkbox" name="<?php echo $_lnb; ?>[Thumbs]" value="1" <?php echo (!empty($_label['Thumbs']) && $_label['Thumbs'] == 1) ? 'checked="checked"' : ''; ?>/>
											Apply label to thumbnails<br /><span class="help">Check this if you want to apply the label to the thumbnail images of a product.</span>
										</label>
									</div>
								</div>
							</div>
						</div>

						<!-- HR --><hr />

						<label><h3>2. Label image editor</h3></label>
						<div class="label_editor_wrap">
							<div class="row">
								<div class="col-xs-6 form-group">
									<label for="<?php echo $_lnb; ?>[Text]"><?php echo $entry_text; ?></label>
									<input class="form-control" type="text" name="<?php echo $_lnb; ?>[Text]" id="<?php echo $_lnb; ?>[Text]" placeholder="My Label">	
								</div>
								<div class="col-xs-3 form-group">
									<label for="<?php echo $_lnb; ?>[FontSize]"><?php echo $entry_font_size; ?></label>
									<div class="input-group">
										<input class="form-control" type="number" min="8" max="100" name="<?php echo $_lnb; ?>[FontSize]" id="<?php echo $_lnb; ?>[FontSize]" value="14"/>
										<span class="input-group-addon">px</span>
									</div>
								</div>
								<div class="col-xs-3 form-group">
									<label><?php echo $entry_text_color; ?></label>
									<div class="bfh-colorpicker" data-placeholder="HEX Code" data-name="<?php echo $_lnb; ?>[Color]" data-color="#000000" data-close="false"></div>
								</div>
							</div>
							<div class="row">
								
								<div class="col-xs-8 form-group">
									<label>Your font collection:</label>
									<div class="uploaded_fonts_list_wrap">
										<a class="btn btn-primary" data-toggle="modal" data-target="#google-webfonts-modal">Get More&nbsp;&nbsp;<i class="fa-download-alt"></i></a>
										<div class="uploaded_fonts_list" data-store-id="<?php echo $store['store_id']; ?>" data-label-id="<?php echo $label_id; ?>" data-language-id="<?php echo $language['language_id']; ?>">
											<?php require(DIR_APPLICATION.'view/template/module/labelmaker/fonts_loop.tpl'); ?>
										</div>
									</div>
								</div>
								<div class="col-xs-4 form-group">
									<label>Generate label from text:</label>
									<a class="btn btn-success btn-block btn-add-text" data-store-id="<?php echo $store['store_id']; ?>" data-label-id="<?php echo $label_id; ?>" data-language-id="<?php echo $language['language_id']; ?>" data-rel="<?php echo $_id; ?>_imagepreview">
										Add Text&nbsp;&nbsp;&nbsp;<i class="fa fa-cog"></i>
									</a>
								</div>
							</div>
							
							<!-- HR --><hr />
								
							<div class="row">
								<div class="col-xs-6 form-group">
									<label>Uploaded Images:</label>
									<div class="image_list uploaded_images_list well" data-store-id="<?php echo $store['store_id']; ?>" data-label-id="<?php echo $label_id; ?>" data-language-id="<?php echo $language['language_id']; ?>">
										<?php if (!empty($uploaded_images)) { $images = $uploaded_images;  ?>
											<?php require(DIR_APPLICATION.'view/template/module/labelmaker/images_loop.tpl'); ?>
										<?php } else { ?>
											<span> No uploaded images.<br /> Use the upload form below<br /> or put your images in this server directory<br /> <b>/vendors/labelmaker/uploaded_images</b> </span>
										<?php } ?>
									</div>
								</div>
								<div class="col-xs-6 form-group">
									<label>Built-in Images:</label>
									<div class="image_list well">
										<?php if (!empty($builtin_images)) { $images = $builtin_images; ?>
											<?php require(DIR_APPLICATION.'view/template/module/labelmaker/images_loop.tpl'); ?>
										<?php } else { ?>
											<span>No built-in images available.</span>
										<?php } ?>
									</div>
								</div>
							</div>
							
							<!-- HR --><hr />
							
							<div class="image-upload">
								<div id="<?php echo $_id; ?>_imageuploadprogress" class="progress progress-striped active"><div class="progress-bar"></div></div>
								<a class="btn btn-primary">Upload Image
									<input class="form-control" id="<?php echo $_id; ?>_imageupload" type="file" name="<?php echo $_id; ?>_imageupload" data-rel="#<?php echo $_id; ?>_imageuploadprogress" accept="image/*">
								</a>
								<span class="image-upload-info">Allowed file types: JPG, PNG, GIF</span>&nbsp;&nbsp;
								<span class="fileSizeInfo"><?php echo $text_max_size; ?> <?php echo $maxSizeReadable; ?></span>
								<a data-toggle="modal" class="needMoreSize" data-target="#help-modal"><?php echo $text_max_size_learn; ?></a>
							</div>
							
							<!-- HR --><hr />
						</div>
					</div>
					<div class="col-xs-6">
						<label><h3>Apply label only to specific size</h3></label>
						<div class="row">
							<div class="col-xs-6 preview_size">
								<div class="bfh-selectbox" data-rel="<?php echo $_id; ?>_imagepreview" data-name="<?php echo $_lnb; ?>[LimitSize]" data-value="<?php echo (!empty($_label['LimitSize'])) ? $_label['LimitSize'] : 'all'; ?>">
									<div data-value="all"><b>All Product Image Sizes</b></div>
									<div data-value="custom"><b>Custom Image Size</b></div>
									<div data-value="<?php echo $store['store_info']['config_image_category_width'].'x'.$store['store_info']['config_image_category_width'];?>">Category Image Size (<?php echo $store['store_info']['config_image_category_width'].'x'.$store['store_info']['config_image_category_width'];?>)</div>
									<div data-value="<?php echo $store['store_info']['config_image_thumb_width'].'x'.$store['store_info']['config_image_thumb_height'];?>">Product Image Thumb Size (<?php echo $store['store_info']['config_image_thumb_width'].'x'.$store['store_info']['config_image_thumb_height'];?>)</div>
									<div data-value="<?php echo $store['store_info']['config_image_popup_width'].'x'.$store['store_info']['config_image_popup_height'];?>">Product Image Popup Size (<?php echo $store['store_info']['config_image_popup_width'].'x'.$store['store_info']['config_image_popup_height'];?>)</div>
									<div data-value="<?php echo $store['store_info']['config_image_product_width'].'x'.$store['store_info']['config_image_product_height'];?>">Product Image List Size (<?php echo $store['store_info']['config_image_product_width'].'x'.$store['store_info']['config_image_product_height'];?>)</div>
									<div data-value="<?php echo $store['store_info']['config_image_additional_width'].'x'.$store['store_info']['config_image_additional_height'];?>">Additional Product Image Size (<?php echo $store['store_info']['config_image_additional_width'].'x'.$store['store_info']['config_image_additional_height'];?>)</div>
									<div data-value="<?php echo $store['store_info']['config_image_related_width'].'x'.$store['store_info']['config_image_related_height'];?>">Related Product Image Size (<?php echo $store['store_info']['config_image_related_width'].'x'.$store['store_info']['config_image_related_height'];?>)</div>
									<div data-value="<?php echo $store['store_info']['config_image_compare_width'].'x'.$store['store_info']['config_image_compare_height'];?>">Compare Image Size (<?php echo $store['store_info']['config_image_compare_width'].'x'.$store['store_info']['config_image_compare_height'];?>)</div>
									<div data-value="<?php echo $store['store_info']['config_image_wishlist_width'].'x'.$store['store_info']['config_image_wishlist_height'];?>">Wish List Image Size (<?php echo $store['store_info']['config_image_wishlist_width'].'x'.$store['store_info']['config_image_wishlist_height'];?>)</div>
									<div data-value="<?php echo $store['store_info']['config_image_cart_width'].'x'.$store['store_info']['config_image_cart_height'];?>">Cart Image Size (<?php echo $store['store_info']['config_image_cart_width'].'x'.$store['store_info']['config_image_cart_height'];?>)</div>
								</div>
							</div>
							<div class="col-xs-6 preview_size_custom" <?php echo (empty($_label['LimitSize']) || (!empty($_label['LimitSize']) && $_label['LimitSize'] != 'custom')) ? 'style="display:none;"' :''; ?>><div class="row">
								<div class="col-xs-6"><div class="input-group">
									<input data-rel="<?php echo $_id; ?>_imagepreview" type="text" class="form-control input_width" placeholder="Width" name="<?php echo $_lnb; ?>[LimitSizeWidth]" value="<?php echo (!empty($_label['LimitSizeWidth'])) ? (int)$_label['LimitSizeWidth'] : ''; ?>">
									<span class="input-group-addon">px</span>
								</div></div>
								<div class="col-xs-6"><div class="input-group">
									<input data-rel="<?php echo $_id; ?>_imagepreview" type="text" class="form-control input_height" placeholder="Height" name="<?php echo $_lnb; ?>[LimitSizeHeight]" value="<?php echo (!empty($_label['LimitSizeHeight'])) ? (int)$_label['LimitSizeHeight'] : ''; ?>">
									<span class="input-group-addon">px</span>
								</div></div>
							</div></div>
							<div class="col-xs-12 automatic_rescaling" <?php echo (!empty($_label['LimitSize']) && $_label['LimitSize'] != 'all') ? 'style="display:none;"' :''; ?>>
								<label class="checkbox">
									<input type="checkbox" name="<?php echo $_lnb; ?>[AutomaticRescaling]" value="1" <?php echo (!empty($_label['AutomaticRescaling']) && $_label['AutomaticRescaling'] == 1) ? 'checked="checked"' : ''; ?>/>
									Automatic re-scaling<br />
									<span class="help">When this is enabled the labels will be re-scaled automatically.<br/>Only available when <b>All Product Image Sizes</b> is selected</span>
								</label>
							</div>
						</div>
						<br />
						<label><h3>Advanced label settings</h3></label>
						<div class="form-group opacity_range_wrap">
							<div class="row">
								<div class="col-xs-4">
									<label for="<?php echo $_lnb; ?>[Opacity]"><?php echo $entry_opacity; ?></label>
									<div class="input-group">
										<input class="form-control opacity_range" type="number" name="<?php echo $_lnb; ?>[Opacity]" min="0" max="100" value="<?php echo !empty($_label['Opacity']) && ctype_digit($_label['Opacity']) ? $_label['Opacity'] : '100' ?>" data-rel="<?php echo $_id; ?>_imagepreview" id="<?php echo $_lnb; ?>[Opacity]"/>
										<span class="input-group-addon">%</span>
									</div>
								</div>
								<div class="col-xs-8 layer_positioning" data-rel="<?php echo $_id; ?>_imagepreview">
									<label>Offset the layers from: <i class="fa fa-info-sign" data-toggle="tooltip" data-placement="bottom" title="<b>The Offset setting defines the starting position for each layer.</b><br />This is useful if you want to always position your layers on the Right Top corner of the image or in the Middle. Each layer has a vertical and horizontal offset. This offset is the distance from its starting point.<br />When you hover over or drag a layer you will see its offset information changing."></i></label>
									<div class="bfh-selectbox" data-rel="<?php echo $_id; ?>_imagepreview" data-name="<?php echo $_lnb; ?>[Position]" data-value="<?php echo (!empty($_label['Position'])) ? $_label['Position']  : 'LT'; ?>">
										<div data-value="LT"><b>Left Top</b></div>
										<div data-value="MT">Middle Top</div>
										<div data-value="RT">Right Top</div>
										<div data-value="LM">Left Middle</div>
										<div data-value="MM">Middle Middle</div>
										<div data-value="RM">Right Middle</div>
										<div data-value="LB">Left Bottom</div>
										<div data-value="MB">Middle Bottom</div>
										<div data-value="RB">Right Bottom</div>
									</div>
								</div>
							</div>
						</div>
						<div class="image_preview_wrap">
							<div class="image_preview_info" id="<?php echo $_id; ?>_imagepreviewinfo"></div>
							<div class="image_preview <?php echo (empty($_label['LimitSize']) || (!empty($_label['LimitSize']) && $_label['LimitSize'] == 'all')) ? 'show_overlay' : ''; ?>" data-rel="<?php echo $_id; ?>_imagedata" id="<?php echo $_id; ?>_imagepreview" data-store-id="<?php echo $store['store_id']; ?>" data-label-id="<?php echo $label_id; ?>" data-language-id="<?php echo $language['language_id']; ?>">
								<!-- JS FILLS WITH ALREADY SAVED LABELS FROM .image_data -->
							</div>
							<div id="<?php echo $_id; ?>_imagedata" class="image_data" data-rel="<?php echo $_id; ?>_imagepreview">
							<?php if (!empty($_label['layers'])) { ?>
								<?php foreach ($_label['layers'] as $k => $layer) { ?>
									<div id="<?php echo $_id; ?>_layer_<?php echo $k; ?>" class="label_group" data-store-id="<?php echo $store['store_id']; ?>" data-label-id="<?php echo $label_id; ?>" data-language-id="<?php echo $language['language_id']; ?>">
										<input value="<?php echo $layer['image']; ?>" type="hidden" name="<?php echo $_lnb; ?>[layers][<?php echo $k; ?>][image]"/>
										<input value="<?php echo $layer['posx']; ?>" type="hidden" name="<?php echo $_lnb; ?>[layers][<?php echo $k; ?>][posx]"/>
										<input value="<?php echo $layer['posy']; ?>" type="hidden" name="<?php echo $_lnb; ?>[layers][<?php echo $k; ?>][posy]"/>
										<input value="<?php echo $layer['posx_bounding']; ?>" type="hidden" name="<?php echo $_lnb; ?>[layers][<?php echo $k; ?>][posx_bounding]"/>
										<input value="<?php echo $layer['posy_bounding']; ?>" type="hidden" name="<?php echo $_lnb; ?>[layers][<?php echo $k; ?>][posy_bounding]"/>
										<input value="<?php echo $layer['width']; ?>" type="hidden" name="<?php echo $_lnb; ?>[layers][<?php echo $k; ?>][width]"/>
										<input value="<?php echo $layer['height']; ?>" type="hidden" name="<?php echo $_lnb; ?>[layers][<?php echo $k; ?>][height]"/>
										<input value="<?php echo $layer['rotation']; ?>" type="hidden" name="<?php echo $_lnb; ?>[layers][<?php echo $k; ?>][rotation]"/>
										<input value="<?php echo $layer['type']; ?>" type="hidden" name="<?php echo $_lnb; ?>[layers][<?php echo $k; ?>][type]"/>
									</div>
								<?php } ?>
							<?php } ?>
							</div>
							<br />
							<p class="text-info">Hover over a layer, then drag the blue stripes to resize and the arrow to rotate</p>
							<p class="text-info">Hold <kbd>shift</kbd> while resizing to maintain aspect ratio</p>
							<p class="text-info">Hover over a layer to recieve more information about it</p>
							<p class="text-info">Double click on layers to move them on top of others.</p>
							<p class="text-info">Hold <kbd>alt</kbd> and double click to move the layer below the others.</p>
						</div>
					</div>
				</div>
				</div>
			</div>
		<?php $i++; endforeach; ?>
	</div>
</div>