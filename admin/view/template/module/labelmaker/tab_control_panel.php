<ul class="nav nav-pills storeTabs">
	<li class="disabled"><a>Your OpenCart Stores:</a></li>
<?php $i=0; foreach ($stores as $store) : ?>
	<li <?php echo ($i == 0) ? 'class="active"' : ''; ?>> <a href="#tab-store_<?php echo $store['store_id']; ?>" data-toggle="pill"><?php echo $store['name'] ?></a> </li>
<?php $i++; endforeach; ?>
</ul>
<div class="tab-content">
	<?php $i=0; foreach ($stores as $store) : ?>
	<div id="tab-store_<?php echo $store['store_id']; ?>" class="tab-pane store-pane <?php echo ($i == 0) ? 'active' : ''; ?>" data-store-id="<?php echo $store['store_id']; ?>" data-store-name="<?php echo $store['name']; ?>">
		<div class="general-content">
			<table class="form">
				<tr>
					<td><label><span class="required">*</span> <?php echo $entry_code; ?></label></td>
					<td>
						<select class="form-control store_settings_toggle" data-rel="store_<?php echo $store['store_id']; ?>_settings" name="LabelMaker[<?php echo $store['store_id']; ?>][Enabled]">
							<option value="true" <?php echo (!empty($data['LabelMaker'][$store['store_id']]['Enabled']) && $data['LabelMaker'][$store['store_id']]['Enabled'] == 'true') ? 'selected=selected' : ''?>><?php echo $text_enabled; ?></option>
							<option value="false" <?php echo (empty($data['LabelMaker'][$store['store_id']]['Enabled']) || $data['LabelMaker'][$store['store_id']]['Enabled'] == 'false') ? 'selected=selected' : ''?>><?php echo $text_disabled; ?></option>
						</select>
					</td>
				</tr>
			</table>
		</div>
		<div class="tabbable tabs-left" id="store_<?php echo $store['store_id']; ?>_settings" style="display:none;">
			<ul class="nav nav-tabs label-image-list">
				<li><a class="addNewLabel"><i class="fa fa-plus"></i> Add New Label</a></li>
				<?php if (!empty($data['LabelMaker']) && !empty($data['LabelMaker'][$store['store_id']]['Labels'])) { ?>
					<?php foreach ($data['LabelMaker'][$store['store_id']]['Labels'] as $label_id => $label) { ?>
					<li> <a href="#store_<?php echo $store['store_id']; ?>_label_<?php echo $label_id; ?>" data-toggle="tab" data-label-id="<?php echo $label_id; ?>"> Label <?php echo $label_id; ?> <i class="fa fa-minus removeLabel"></i>
					<input type="hidden" name="LabelMaker[<?php echo $store['store_id']; ?>][Labels][<?php echo $label_id; ?>]" value="<?php echo $label_id; ?>" />
					</a> </li>
					<?php } ?>
				<?php } ?>
			</ul>
			<div class="tab-content label-image-settings">
				<?php
					if (!empty($data['LabelMaker']) && !empty($data['LabelMaker'][$store['store_id']]['Labels'])) {
						foreach ($data['LabelMaker'][$store['store_id']]['Labels'] as $label_id => $label) {
							require(DIR_APPLICATION.'view/template/module/labelmaker/label_image_settings.tpl');
						}
					}
				?>
			</div>
		</div>
	</div>
	<?php $i++; endforeach; ?>
	<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxSize; ?>" /> 
</div>
<script type="text/javascript">
// $.fn getStyleObject
(function(e){e.fn.getStyleObject=function(){var e=this.get(0);var t;var n={};if(window.getComputedStyle){var r=function(e,t){return t.toUpperCase()};t=window.getComputedStyle(e,null);for(var i=0,s=t.length;i<s;i++){var o=t[i];var u=o.replace(/\-([a-z])/g,r);var a=t.getPropertyValue(o);n[u]=a}return n}if(t=e.currentStyle){for(var o in t){n[o]=t[o]}return n}return this.css()}})(jQuery)
    

function switchStoreSettings() {
	$('.store_settings_toggle').each(function(){
		if ($(this).val() == 'true') {
			$('#' + $(this).attr('data-rel')).fadeIn();
		} else {
			$('#' + $(this).attr('data-rel')).fadeOut();	
		}
		
		$('.store-pane.active .label-image-list > li:nth-child(2) a').tab('show');
	});
}

function addNewLabel() {
	label_count 		= $('.store-pane.active .label-image-list li:last-child > a').data('label-id') + 1 || 1;
	active_store_id 	= $('.store-pane.active').data('store-id');
	active_store_name 	= $('.store-pane.active').data('store-name');
	
	var ajax_data = {};
	
	ajax_data.token = '<?php echo $token; ?>';
	ajax_data.active_store_id = active_store_id;
	ajax_data.label_count = label_count;

	$.ajax({
		url: 'index.php?route=module/labelmaker/get_label_image_settings',
		data: ajax_data,
		dataType: 'html',
		beforeSend: function() {
			NProgress.start();
		},
		success: function(settings_html) {

			$('.store-pane.active .label-image-settings').append(settings_html);

			if (label_count == 1) { $('a[href="#store_' + active_store_id + '_label_' + label_count + '"]').tab('show'); }
			
			$('.bfh-colorpicker').each(function () {
				var $colorpicker;
				$colorpicker = $(this);
				$colorpicker.bfhcolorpicker($colorpicker.data());
			});
			
			$('.bfh-selectbox').each(function() {
				var $selectbox;
				$selectbox = $(this);
				$selectbox.bfhselectbox($selectbox.data());
			});

			NProgress.done();

			label_tpl 	= '<li>';
			label_tpl 	+= '<a href="#store_' + active_store_id + '_label_' + label_count + '" data-toggle="tab" data-store-name="' + active_store_name + '" data-label-id="' + label_count + '">';
			label_tpl 	+= 'Label ' + label_count;
			label_tpl 	+= '<i class="fa fa-minus removeLabel"></i>';
			label_tpl 	+= '<input type="hidden" name="LabelMaker[' + active_store_id + '][Labels][' + label_count + ']" value="' + label_count + '"/>';
			label_tpl 	+= '</a>';
			label_tpl	+= '</li>';

			$('.store-pane.active .label-image-list').append(label_tpl);
			$('.store-pane.active .label-image-list').children().last().children('a').trigger('click');
		}
	});
}

function removeLabel() {
	active_store_name = $('.store-pane.active').data('store-name');
	label_tab_link = $(event.target).parent();
	label_tab_pane_id = label_tab_link.attr('href');
	
	var confirmLabelRemove = confirm('Are you sure you want to remove ' + label_tab_link.text().trim() + ' from ' + active_store_name);
	
	if (confirmLabelRemove == true) {
		label_tab_link.parent().remove();
		$(label_tab_pane_id).remove();
		
		if ($('.store-pane.active .label-image-list').children().length > 1) {
			$('.store-pane.active .label-image-list > li:nth-child(2) a').tab('show');
		}
	}
}

function refreshUploadedImageLists() {
	$('.uploaded_images_list').each(function(index, element) {
		var store_id 	= $(this).attr('data-store-id');
		var label_id 	= $(this).attr('data-label-id');
		var language_id = $(this).attr('data-language-id');

		$(this).load('index.php?route=module/labelmaker/load_uploaded_images&store_id=' + store_id + '&label_id=' + label_id + '&language_id=' + language_id + '&token=<?php echo $token; ?>', function(){
			setTimeout(function(){
				$('.image_editor .btn-add-text .fa.fa-cog').removeClass('fa-spin');
			}, 1000);	
		});
	});

	NProgress.done();
}

function refreshFontsList() {
	$('.uploaded_fonts_list').each(function(index, element) {
		var store_id = $(this).attr('data-store-id');
		var label_id = $(this).attr('data-label-id');
		var language_id = $(this).attr('data-language-id');

		$(this).load('index.php?route=module/labelmaker/load_uploaded_fonts&store_id=' + store_id + '&label_id=' + label_id + '&language_id=' + language_id + '&token=<?php echo $token; ?>', function(){
			$('.uploaded_fonts_list .bfh-selectbox').each(function() {
				var $selectbox;
				$selectbox = $(this);
				$selectbox.bfhselectbox($selectbox.data());
			});
		});
	});
	
	$('#google-webfonts-modal .fa.fa-spinner').removeClass('active');
	
	$('#google-webfonts-modal .success').addClass('active');
	
	setTimeout(function(){
		$('#google-webfonts-modal .success').removeClass('active');
	}, 4000);

	NProgress.done();
}

function refreshImageData() {
	$('.image_data').each(function(){
		var image_data 		= $(this);
		var image_preview	= '#' + $(this).attr('data-rel');
		var sizes 			= [];

		var store_id 		= $(image_preview).attr('data-store-id');
		var label_id 		= $(image_preview).attr('data-label-id');
		var language_id 	= $(image_preview).attr('data-language-id');
		var $_label_nb		= 'LabelMaker[' + store_id + '][Labels][' + label_id + '][' + language_id + ']';

		if ($('[name="' + $_label_nb + '[LimitSize]"]').val() == 'all') {
			sizes[0] = 420;
			sizes[1] = 420;
		} else if ($('[name="' + $_label_nb + '[LimitSize]"]').val() == 'custom') {
			sizes[0] = $('[name="' + $_label_nb + '[LimitSizeWidth]"]').val();
			sizes[1] = $('[name="' + $_label_nb + '[LimitSizeHeight]"]').val();
		} else {
			sizes 	 = $('[name="' + $_label_nb + '[LimitSize]"]').val().split('x');
		}

		$(image_preview).css({
			width: 	parseInt(sizes[0]),
			height: parseInt(sizes[1])
		});

		$(image_preview).empty();

		$('.label_group', image_data).each(function(index){
			var store_id 		= $(this).attr('data-store-id');
			var label_id 		= $(this).attr('data-label-id');
			var language_id 	= $(this).attr('data-language-id');

			var $_label_nb		= 'LabelMaker[' + store_id + '][Labels][' + label_id + '][' + language_id + ']';
			var $_layer_nb 		= $_label_nb + '[layers][' + index + ']'; // Layer Name Base

			// Layer Data
			var image 				= $('[name="' + $_layer_nb + '[image]"]', this).val();
			var type				= $('[name="' + $_layer_nb + '[type]"]', this).val();
			var width 				= Math.ceil(parseInt($('[name="' + $_layer_nb + '[width]"]', this).val()));
			var height 				= Math.ceil(parseInt($('[name="' + $_layer_nb + '[height]"]', this).val()));
			var calculated_x		= Math.ceil(parseInt($('[name="' + $_layer_nb + '[posx_bounding]"]', this).val()));
			var calculated_y 		= Math.ceil(parseInt($('[name="' + $_layer_nb + '[posy_bounding]"]', this).val()));
			var rotation			= parseInt($('[name="' + $_layer_nb + '[rotation]"]', this).val());
			var layer_positioning 	= $('[name="' + $_label_nb + '[Position]"]').val();
			var opacity     		= $('[name="' + $_label_nb + '[Opacity]"]').val();

			var imagepreview 		= $('#store_' + store_id + '_label_' + label_id + '_language_' + language_id + '_imagepreview');
			var imagepreview_width 	= imagepreview.innerWidth();
			var imagepreview_height	= imagepreview.innerHeight();

			// Calculate positions based on offset
			switch (layer_positioning) {
				case "LT": // Left Top
					var posx = calculated_x;
					var posy = calculated_y;
					break;
				case "MT": // Middle Top
					var posx = (imagepreview_width/2) + calculated_x;
					var posy = calculated_y;
					break;
				case "RT": // Right Top
					var posx = imagepreview_width - (calculated_x + width);
					var posy = calculated_y;
					break;
				case "LM": // Left Middle
					var posx = calculated_x;
					var posy = (imagepreview_height/2) + calculated_y;
					break;
				case "MM": // Middle Middle
					var posx = (imagepreview_width/2) + calculated_x;
					var posy = (imagepreview_height/2) + calculated_y;
					break;
				case "RM": // Right Middle
					var posx = imagepreview_width - (calculated_x + width);
					var posy = (imagepreview_height/2) + calculated_y;
					break;
				case "LB": // Left Bottom
					var posx = calculated_x;
					var posy = imagepreview_height - (calculated_y + height);
					break;
				case "MB": // Middle Bottom
					var posx = (imagepreview_width/2) + calculated_x;
					var posy = imagepreview_height - (calculated_y + height);
					break;
				case "RB": // Right Bottom
					var posx = imagepreview_width - (calculated_x + width);
					var posy = imagepreview_height - (calculated_y + height);
					break;
			}

			// Img Layer Tpl
			var img_tpl  = '<div class="img" data-image-path="' + image + '" data-posx="' + posx + '" data-posy="' + posy + '" data-rotate="' + rotation + '"';
				img_tpl += ' data-store-id="' + store_id + '" data-label-id="' + label_id + '" data-language-id="' + language_id + '"';
				img_tpl += ' data-rel="store_' + store_id + '_label_' + label_id + '_language_' + language_id + '_imagedata"';
				img_tpl += ' data-width="' + width + '" data-height="' + height + '" data-type="' + type + '">';
				img_tpl += ' <div class="remove"></div>';
				img_tpl += ' <img src="<?php echo $CATALOG_URL; ?>' + image + '" title="' + image + '" alt="' + image + '" />';
				img_tpl += '</div>';

			$(img_tpl).appendTo(image_preview).draggable({
				containment: "document",
	   			cursor: "move",
				grid: [ 1, 1 ],
				drag:function(){
					updatePositionInfo($(this), true);
				},
				stop:function(){
					updatePositionInfo($(this), true);
				}
			}).css({
				'left': posx,
				'top': posy,
				'width': width,
				'height': height,
				'-ms-filter': 'progid:DXImageTransform.Microsoft.Alpha(Opacity=' + opacity + ')',
				'filter': 'alpha(opacity=' + opacity + ')',
				'-moz-opacity':opacity/100,
				'-webkit-opacity':opacity/100,
				'-khtml-opacity':opacity/100,
				'opacity':opacity/100
			}).resizable({
				containment: "document",
				grid: [ 1, 1 ],
				resize: function(event, ui) {
					updatePositionInfo($(this), true);
				},
				stop:function(){
					updatePositionInfo($(this), true);
				}
			}).rotatable({
				handle: $(document.createElement('div')).attr('class', 'rotate-handle')
			}).css({
				'-webkit-transform' : 'rotate(' + rotation + 'deg)',
				'-moz-transform' : 'rotate(' + rotation + 'deg)',
				'-ms-transform' : 'rotate(' + rotation + 'deg)',
				'transform' : 'rotate(' + rotation + 'deg)'
			}).data('angle', rotation * (Math.PI / 180)).attr('data-rotate', rotation);
		});
	});

	NProgress.done();
}

function saveLabelLayerSettings() {
	$('.image_preview').each(function() {
		var image_data 		= '#' + $(this).attr('data-rel');
		var image_preview	= $(this);
		
		// Erase Current Data
		$(image_data).empty();

		// Build Input Data From Layers
		$('.img', image_preview).each(function(index, element) {
			updatePositionInfo($(this), false);

			var image_data			= '#' + $(this).attr('data-rel');
			var store_id 			= $(this).attr('data-store-id');
			var label_id 			= $(this).attr('data-label-id');
			var language_id 		= $(this).attr('data-language-id');
			var $_label_nb			= 'LabelMaker[' + store_id + '][Labels][' + label_id + '][' + language_id + ']';

			var layer_positioning 	= $('[name="' + $_label_nb + '[Position]"]').val();
			var imagepreview 		= $('#store_' + store_id + '_label_' + label_id + '_language_' + language_id + '_imagepreview');

			var imagepreview_width 	= imagepreview.innerWidth();
			var imagepreview_height	= imagepreview.innerHeight();

			// Layer Data
			var layer = $(this);
			var $_layer_nb = '' + $_label_nb + '[layers][' + index + ']'; // Layer Name Base

			var image				= layer.attr('data-image-path');
			var posx 				= layer.attr('data-posx');
			var posy 				= layer.attr('data-posy');
			var posx_bounding 		= null;
			var posy_bounding 		= null;
			var calculated_x		= Math.ceil(parseInt(layer.getStyleObject().left.replace('px','')));
			var calculated_y		= Math.ceil(parseInt(layer.getStyleObject().top.replace('px','')));
			var calculated_width 	= Math.ceil(parseInt(layer.getStyleObject().width.replace('px','')));
			var calculated_height 	= Math.ceil(parseInt(layer.getStyleObject().height.replace('px','')));
			var type   				= layer.attr('data-type');

			// Calculate positions based on offset
			switch (layer_positioning) {
				case "LT": // Left Top
					posx_bounding = calculated_x;
					posy_bounding = calculated_y;
					break;
				case "MT": // Middle Top
					posx_bounding = calculated_x - (imagepreview_width/2);
					posy_bounding = calculated_y;
					break;
				case "RT": // Right Top
					posx_bounding = imagepreview_width - (calculated_x + calculated_width);
					posy_bounding = calculated_y;
					break;
				case "LM": // Left Middle
					posx_bounding = calculated_x;
					posy_bounding = calculated_y - (imagepreview_height/2);
					break;
				case "MM": // Middle Middle
					posx_bounding = calculated_x - (imagepreview_width/2);
					posy_bounding = calculated_y - (imagepreview_height/2);
					break;
				case "RM": // Right Middle
					posx_bounding = imagepreview_width - (calculated_x + calculated_width);
					posy_bounding = calculated_y - (imagepreview_height/2);
					break;
				case "LB": // Left Bottom
					posx_bounding = calculated_x;
					posy_bounding = imagepreview_height - (calculated_y + calculated_height);
					break;
				case "MB": // Middle Bottom
					posx_bounding = calculated_x - (imagepreview_width/2);
					posy_bounding = imagepreview_height - (calculated_y + calculated_height);
					break;
				case "RB": // Right Bottom
					posx_bounding = imagepreview_width - (calculated_x + calculated_width);
					posy_bounding = imagepreview_height - (calculated_y + calculated_height);
					break;
			}

			var width				= calculated_width;
			var height				= calculated_height;
			var rotation			= layer.attr('data-rotate');

			// HTML Inputs
			var html  = '<div id="store_' + store_id + '_label_' + label_id + '_language_' + language_id + '_layer_' + index + '"';
				html += ' class="label_group" data-store-id="' + store_id + '" data-label-id="' + label_id + '" data-language-id="' + language_id + '">';
					html += '<input value="' + image + '" type="hidden" name="' + $_layer_nb + '[image]"/>';
					html += '<input value="' + posx + '" type="hidden" name="' + $_layer_nb + '[posx]"/>';
					html += '<input value="' + posy + '" type="hidden" name="' + $_layer_nb + '[posy]"/>';
					html += '<input value="' + posx_bounding + '" type="hidden" name="' + $_layer_nb + '[posx_bounding]"/>';
					html += '<input value="' + posy_bounding + '" type="hidden" name="' + $_layer_nb + '[posy_bounding]"/>';
					html += '<input value="' + width + '" type="hidden" name="' + $_layer_nb + '[width]"/>';
					html += '<input value="' + height + '" type="hidden" name="' + $_layer_nb + '[height]"/>';
					html += '<input value="' + rotation + '" type="hidden" name="' + $_layer_nb + '[rotation]" />';
					html += '<input value="' + type + '" type="hidden" name="' + $_layer_nb + '[type]" />';
				html += '</div>';
			
			$(html).appendTo($(image_data));
		});
	});
}

function updatePreviewInfo(el) {
	var store_id 		= el.attr('data-store-id');
	var label_id 		= el.attr('data-label-id');
	var language_id 	= el.attr('data-language-id');

	var preview_info 	= $('#store_' + store_id + '_label_' + label_id + '_language_' + language_id + '_imagepreviewinfo');

	// Layer Data
	var layer 				= el;
	var posx 				= layer.attr('data-posx');
	var posy 				= layer.attr('data-posy');
	var width				= Math.ceil(parseInt(layer.getStyleObject().width.replace('px','')));
	var height				= Math.ceil(parseInt(layer.getStyleObject().height.replace('px','')));
	var rotation			= layer.attr('data-rotate');

	var preview_info_text  	= 'Horizontal Offset: <b>' + posx + 'px</b>';
		preview_info_text 	+= '&nbsp;&nbsp;&nbsp;Vertical Offset: <b>' + posy + 'px</b>';
		preview_info_text 	+= '&nbsp;&nbsp;&nbsp;Width: <b>' + width + 'px</b>';
		preview_info_text 	+= '&nbsp;&nbsp;&nbsp;Height: <b>' + height + 'px</b>';
		preview_info_text 	+= '&nbsp;&nbsp;&nbsp;Rotation: <b>' + rotation + 'deg</b>';

	preview_info.html(preview_info_text);
}

function updatePositionInfo(el, update_info) {
	var layer 	 				= el;
	var store_id 				= layer.attr('data-store-id');
	var label_id 				= layer.attr('data-label-id');
	var language_id 			= layer.attr('data-language-id');
	var $_label_nb				= 'LabelMaker[' + store_id + '][Labels][' + label_id + '][' + language_id + ']';

	var layer_positioning 		= $('[name="' + $_label_nb + '[Position]"]').val();
	var imagepreview 			= $('#store_' + store_id + '_label_' + label_id + '_language_' + language_id + '_imagepreview');
	var imagepreview_width 		= imagepreview.innerWidth();
	var imagepreview_height 	= imagepreview.innerHeight();
	var calculated_x 			= Math.ceil(parseInt(layer.getStyleObject().left.replace('px','')));
	var calculated_y 			= Math.ceil(parseInt(layer.getStyleObject().top.replace('px','')));
	var calculated_width 		= Math.ceil(parseInt(layer.getStyleObject().width.replace('px','')));
	var calculated_height 		= Math.ceil(parseInt(layer.getStyleObject().height.replace('px','')));

	// Calculate positions based on offset
	switch (layer_positioning) {
		case "LT": // Left Top
			var posx = calculated_x;
			var posy = calculated_y;
			break;
		case "MT": // Middle Top
			var posx = calculated_x - (imagepreview_width/2);
			var posy = calculated_y;
			break;
		case "RT": // Right Top
			var posx = imagepreview_width - (calculated_x + calculated_width);
			var posy = calculated_y;
			break;
		case "LM": // Left Middle
			var posx = calculated_x;
			var posy = calculated_y - (imagepreview_height/2);
			break;
		case "MM": // Middle Middle
			var posx = calculated_x - (imagepreview_width/2);
			var posy = calculated_y - (imagepreview_height/2);
			break;
		case "RM": // Right Middle
			var posx = imagepreview_width - (calculated_x + calculated_width);
			var posy = calculated_y - (imagepreview_height/2);
			break;
		case "LB": // Left Bottom
			var posx = calculated_x;
			var posy = imagepreview_height - (calculated_y + calculated_height);
			break;
		case "MB": // Middle Bottom
			var posx = calculated_x - (imagepreview_width/2);
			var posy = imagepreview_height - (calculated_y + calculated_height);
			break;
		case "RB": // Right Bottom
			var posx = imagepreview_width - (calculated_x + calculated_width);
			var posy = imagepreview_height - (calculated_y + calculated_height);
			break;
	}

	el.attr('data-posx', posx);
	el.attr('data-posy', posy);

	update_info = typeof update_info !== 'undefined' ? update_info : false;

	if (update_info) {
		updatePreviewInfo(el);
	}
}
(function($) {
	$(document).ready(function() {
		switchStoreSettings();
		
		$('.store_settings_toggle').change(function(){ switchStoreSettings(); });

		// Add New Label
		$(document).on('click', '.addNewLabel', function(event) {
			event.preventDefault();
			addNewLabel();
		});

		// Remove Label
		$(document).on('click', '.removeLabel', function(event) {
			event.preventDefault();
			removeLabel();
		});

		$(document).on('click', '.colorSelector', function(){
			$('#' + $(this).attr('data-rel')).show();
		});

		// Settings Fade
		$(document).on('change', '.toggle-fade-next', function(){
			if ($(this).val() == 'all') {
				$(this).next().fadeOut();
			} else {
				$(this).next().fadeIn();	
			}
		});

		// Category Autocomplete
		$(document).on('focus', '.category-autocomplete', function() {
			$(this).autocomplete({
				delay: 500,
				source: function(request, response) {
					$.ajax({
						url: 'index.php?route=module/labelmaker/autocomplete_category&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
						dataType: 'json',
						success: function(json) {		
							response($.map(json, function(item) {
								return {
									label: item.name,
									value: item.category_id
								}
							}));
						}
					});
				}, 
				select: function(event, ui) {
					store_id 	= $(this).attr('data-store-id');
					label_id 	= $(this).attr('data-label-id');
					language_id = $(this).attr('data-language-id');
					$_label_nb		= 'LabelMaker[' + store_id + '][Labels][' + label_id + '][' + language_id + ']';

					$('#product-category_store_' + store_id + '_label_' + label_id + '_language_' + language_id + '_' + ui.item.value).remove();
					
					$('#product-category_store_' + store_id + '_label_' + label_id + '_language_' + language_id).append(
						'<div id="product-category_store_' + store_id + '_label_' + label_id + '_language_' + language_id + '_' + ui.item.value + '">' +
							ui.item.label + '<i class="fa fa-minus removeIcon"></i>' +
							'<input type="hidden" name="' + $_label_nb + '[LimitCategoriesList][]" value="' + ui.item.value + '" />' +
						'</div>');
					return false;
				},
				focus: function(event, ui) {
					return false;
				}
			});
		});
		
		// Products
		$(document).on('focus', '.products-autocomplete', function() {
			$(this).autocomplete({
				delay: 500,
				source: function(request, response) {
					$.ajax({
						url: 'index.php?route=module/labelmaker/autocomplete_product&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
						dataType: 'json',
						success: function(json) {		
							response($.map(json, function(item) {
								return {
									label: item.name,
									value: item.product_id
								}
							}));
						}
					});
				}, 
				select: function(event, ui) {
					store_id 	= $(this).attr('data-store-id');
					label_id 	= $(this).attr('data-label-id');
					language_id = $(this).attr('data-language-id');
					$_label_nb		= 'LabelMaker[' + store_id + '][Labels][' + label_id + '][' + language_id + ']';

					$('#product-store_' + store_id + '_label_' + label_id + '_language_' + language_id + '_' + ui.item.value).remove();
					
					$('#product-store_' + store_id + '_label_' + label_id + '_language_' + language_id + '_' + ui.item.value).remove();
					
					$('#product-store_' + store_id + '_label_' + label_id + '_language_' + language_id).append(
						'<div id="product-store_' + store_id + '_label_' + label_id + '_language_' + language_id + '_' + ui.item.value + '">' +
							ui.item.label + '<i class="fa fa-minus removeIcon"></i>' +
							'<input type="hidden" name="' + $_label_nb + '[LimitProductsList][]" value="' + ui.item.value + '" />' +
						'</div>');
							
					return false;
				},
				focus: function(event, ui) {
					return false;
				}
			});
		});

		// Manufacturer Autocomplete
		$(document).on('focus', '.manufacturer-autocomplete', function() {
			$(this).autocomplete({
				delay: 500,
				source: function(request, response) {
					$.ajax({
						url: 'index.php?route=module/labelmaker/autocomplete_manufacturer&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
						dataType: 'json',
						success: function(json) {		
							response($.map(json, function(item) {
								return {
									label: item.name,
									value: item.manufacturer_id
								}
							}));
						}
					});
				}, 
				select: function(event, ui) {
					store_id 	= $(this).attr('data-store-id');
					label_id 	= $(this).attr('data-label-id');
					language_id = $(this).attr('data-language-id');
					$_label_nb		= 'LabelMaker[' + store_id + '][Labels][' + label_id + '][' + language_id + ']';

					$('#product-manufacturer_store_' + store_id + '_label_' + label_id + '_language_' + language_id + '_' + ui.item.value).remove();
					
					$('#product-manufacturer_store_' + store_id + '_label_' + label_id + '_language_' + language_id).append(
						'<div id="product-manufacturer_store_' + store_id + '_label_' + label_id + '_language_' + language_id + '_' + ui.item.value + '">' +
							ui.item.label + '<i class="fa fa-minus removeIcon"></i>' +
							'<input type="hidden" name="' + $_label_nb + '[LimitManufacturersList][]" value="' + ui.item.value + '" />' +
						'</div>');
					return false;
				},
				focus: function(event, ui) {
					return false;
				}
			});
		});
		
		// Scrollbox
		$(document).on('click', '.scrollbox .removeIcon', function() {
			$(this).parent().remove();
		});
		
		// File Upload Handler
		$(document).on('click', '.image-upload input[type="file"]', function(e) {
			upload_param = $(this).attr('name');
			upload_progress_wrapper = $(this).attr('data-rel');
			
			$(this).fileupload({
				dropZone: $(this),
				url:'index.php?route=module/labelmaker/upload_image' +
					'&token=<?php echo $token; ?>' + 
					'&upload_param=' + upload_param,
				dataType: 'json',
				submit: function (e, data) {
					$(upload_progress_wrapper).addClass('file-added');
				},
				done: function (e, data) {
					if (data.response().result.error) {
						$(upload_progress_wrapper).removeClass('file-added');
						$(upload_progress_wrapper).removeClass('file-uploaded');
						$('.progress-bar', upload_progress_wrapper).css('width','0');
						alert(data.response().result.error);
					} else {
						$(upload_progress_wrapper).attr('data-status', data.textStatus);
						$(upload_progress_wrapper).addClass('file-uploaded');
						
						setTimeout(function(){
							$(upload_progress_wrapper).removeClass('file-added');
							$(upload_progress_wrapper).removeClass('file-uploaded');
							$('.progress-bar', upload_progress_wrapper).css('width','0');
						}, 3000);
					}
					
					refreshUploadedImageLists();
				},
				progress: function (e, data) {
					var progress = parseInt(data.loaded / data.total * 100, 10);
					$('.progress-bar', upload_progress_wrapper).css('width', progress + '%');
				}
			});
		});
		
	//	
	// Image Editor
	//
		
		// Delete Image File
		$(document).on('click', '.image_editor .btn-delete-image', function(){
			var ajax_data = {};
		
			ajax_data.token = '<?php echo $token; ?>';
			ajax_data.image = $(this).attr('data-image');
			
			var confirm_delete = confirm('Are you sure that you want to permanently delete the image: ' + ajax_data.image);
			
			if (confirm_delete == true) {
				$.ajax({
					url: 'index.php?route=module/labelmaker/delete_image',
					data: ajax_data,
					dataType: 'json',
					success: function(json) {
						if (json != null && json.error) { alert(json.error); }
						refreshUploadedImageLists();
					}
				});
			}
		});
		
		// Add Image
		$(document).on('click', '.image_editor .btn-add-image', function(){
			var image_preview 	= '#' + $(this).attr('data-rel');
			var store_id 		= $(image_preview).attr('data-store-id');
			var label_id 		= $(image_preview).attr('data-label-id');
			var language_id 	= $(image_preview).attr('data-language-id');
			var $_label_nb		= 'LabelMaker[' + store_id + '][Labels][' + label_id + '][' + language_id + ']';

			var opacity 		= $('[name="' + $_label_nb + '[Opacity]"]').val();

			if ($(this).parent().hasClass('type-dark')) {
				var type = 'dark';
			} else {
				var type = 'light';
			}

			$(this).next().clone().appendTo(image_preview).attr({
				'data-posx': '0',
				'data-posy': '0',
				'data-type': type
			}).draggable({
				containment: "document",
	   			cursor: "move",
				grid: [ 1, 1 ],
				drag:function(){
					updatePositionInfo($(this), true);
				},
				stop:function(){
					updatePositionInfo($(this), true);
				}
			}).css({
				left:0,
				top:0,
				width: $(this).next().attr('data-width'),
				height: $(this).next().attr('data-height'),
			}).resizable({
				containment: "document",
				grid: [ 1, 1 ],
				resize: function(event, ui) {
					updatePositionInfo($(this), true);
				},
				stop:function(){
					updatePositionInfo($(this), true);
				}
			}).rotatable({
				handle: $(document.createElement('div')).attr('class', 'rotate-handle')
			}).css({
				'-webkit-transform' : 'rotate(0deg)',
				'-moz-transform' : 'rotate(0deg)',
				'-ms-transform' : 'rotate(0deg)',
				'transform' : 'rotate(0deg)',
				'-ms-filter': 'progid:DXImageTransform.Microsoft.Alpha(Opacity=' + opacity + ')',
				'filter': 'alpha(opacity=' + opacity + ')',
				'-moz-opacity':opacity/100,
				'-webkit-opacity':opacity/100,
				'-khtml-opacity':opacity/100,
				'opacity':opacity/100
			}).data('angle', 0);
		});
		
		// Add Text
		$(document).on('click', '.image_editor .btn-add-text', function(){
			var image_preview 	= '#' + $(this).attr('data-rel');
			var store_id 		= $(this).attr('data-store-id');
			var label_id 		= $(this).attr('data-label-id');
			var language_id 	= $(this).attr('data-language-id');
			var $_label_nb		= 'LabelMaker[' + store_id + '][Labels][' + label_id + '][' + language_id + ']';

			var ajax_data = {};
			ajax_data.token = '<?php echo $token; ?>';

			// Text data
			ajax_data.text			= $('[name="' + $_label_nb + '[Text]"]').val();
			ajax_data.font_size		= $('[name="' + $_label_nb + '[FontSize]"]').val();
			ajax_data.color			= $('[name="' + $_label_nb + '[Color]"]').val();
			ajax_data.font_family	= $('[name="' + $_label_nb + '[Font]"]').val();
			
			$.ajax({
				url: 'index.php?route=module/labelmaker/generate_font_image',
				data: ajax_data,
				dataType: 'json',
				beforeSend: function() {
					$('.image_editor .btn-add-text .fa.fa-cog').addClass('fa-spin icon-spin');
				},
				success: function(json) {
					if (json != null && json.error) { alert(json.error); } else { NProgress.start(); }
					refreshUploadedImageLists();
				}
			});
		});
		
		// Stack Image
		$(document).on('dblclick', '.image_preview .img', function(event) {
			if (event.altKey == 1) {
				$(this).prependTo($(this).parent());
			} else {
				$(this).appendTo($(this).parent());
			}
		});
		
		// Remove Image
		$(document).on('click', '.image_preview .img .remove', function(){
			$(this).parent().remove();
		});
		
		// Download Web Font
		$(document).on('click', '#download-font', function() {
			var ajax_data = {};
		
			ajax_data.token = '<?php echo $token; ?>';
			ajax_data.key_entry = $('#google_webfonts_select').val()
			
			$.ajax({
				url: 'index.php?route=module/labelmaker/download_webfont',
				data: ajax_data,
				dataType: 'json',
				beforeSend: function() {
					$('#google-webfonts-modal .fa.fa-spinner').addClass('active');
				},
				success: function(json) {
					if (json != null && json.error) {
						alert(json.error);
						$('#google-webfonts-modal .fa.fa-spinner').removeClass('active');
					} else {
						refreshFontsList();
					}
				}
			});
		});
		
		// Opacity
		$(document).on('change', '.opacity_range', function(){
			var image_preview = '#' + $(this).attr('data-rel');
			var opacity = $(this).val()/100;
			
			$(image_preview + '> *').css('opacity', opacity);
		});

		$(document).on('change.bfhselectbox', '.preview_size .bfh-selectbox', function(event) {
			var image_preview = '#' + $(this).attr('data-rel');
			var sizes = $('input', $(this)).val().split('x');

			if ($('input', $(this)).val() == 'all') {
				$(image_preview).addClass('show_overlay');
				sizes[0] = 420;
				sizes[1] = 420;
			} else {
				$(image_preview).removeClass('show_overlay');
			}

			if ($('input', $(this)).val() == 'custom') {
				$(this).parents('.preview_size').next().fadeIn(400);
				sizes[0] = $('input.input_width', $(this).parents('.preview_size').next()).val();
				sizes[1] = $('input.input_height', $(this).parents('.preview_size').next()).val();
			} else {
				$(this).parents('.preview_size').next().fadeOut(400);
			}

			$(image_preview).css({
				width: 	parseInt(sizes[0]),
				height: parseInt(sizes[1])
			});
		});

		$(document).on('change', '.preview_size_custom input', function(event) {
			var sizes = [];
			var image_preview = '#' + $(this).attr('data-rel');
			sizes[0] = $('input.input_width', $(this).parents('.preview_size_custom')).val();
			sizes[1] = $('input.input_height', $(this).parents('.preview_size_custom')).val();

			$(image_preview).css({
				width: 	parseInt(sizes[0]),
				height: parseInt(sizes[1])
			});
		});

		$(document).on('keyup', '.bfh-colorpicker input', function(){
			$(this).parents('.bfh-colorpicker').data().bfhcolorpicker.$element.val($(this).val());
		});

		$(document).on('change.bfhselectbox', '.quantity_limit .bfh-selectbox', function(event) {
			if ($('input', $(this)).val() == 'no_limit') {
				$(this).parents('.quantity_limit').next().fadeOut(400);
			} else {
				$(this).parents('.quantity_limit').next().fadeIn(400);
			}
		});

		$(document).on('change.bfhselectbox', '.price_limit .bfh-selectbox', function(event) {
			if ($('input', $(this)).val() == 'no_limit') {
				$(this).parents('.price_limit').next().fadeOut(400);
			} else {
				$(this).parents('.price_limit').next().fadeIn(400);
			}
		});

		$('[data-toggle="tooltip"]').tooltip({
			html:true
		});



		// Image Preview Information 
		$(document).on('mouseenter', '.image_preview .img', function(event) {
			updatePositionInfo($(this), true);
		});

		$(document).on('mouseleave', '.image_preview .img', function(event) {
			$('.image_preview_info').empty();
		});

		$('#form').submit(function(){
			saveLabelLayerSettings();
		});

		refreshImageData();
	});
})(jQuery);
</script>