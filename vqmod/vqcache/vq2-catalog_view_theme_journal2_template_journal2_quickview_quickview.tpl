<!DOCTYPE html>
<?php global $registry; $url = $registry->get('url'); ?>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="product-page quickview <?php echo $this->journal2->html_classes->getAll(); ?>" style="overflow-y: auto">
<head>
<title><?php echo $heading_title; ?></title>
<meta name="robots" content="noindex">
<base href="<?php echo $base; ?>" />
<?php foreach ($this->journal2->google_fonts->getFonts() as $font): ?>
<link rel="stylesheet" href="<?php echo $font; ?>"/>
<?php endforeach; ?>
<?php $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/j-strap.css'); ?>
<?php $this->journal2->minifier->addStyle('catalog/view/javascript/font-awesome/css/font-awesome.min.css'); ?>
<?php $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/icons.css'); ?>
<?php $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/hint.min.css'); ?>
<?php $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/journal.css'); ?>
<?php $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/module.css'); ?>
<?php $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/features.css'); ?>
<?php $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/product.css'); ?>
<?php $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/flex.css'); ?>
<?php $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/rtl.css'); ?>
<?php $this->journal2->minifier->addScript('catalog/view/theme/journal2/js/journal.js', 'header'); ?>
<?php echo $this->journal2->minifier->css(); ?>
<?php if ($this->journal2->cache->getDeveloperMode() || !$this->journal2->minifier->getMinifyCss()): ?>
<link rel="stylesheet" href="index.php?route=journal2/assets/css&amp;j2v=<?php echo JOURNAL_VERSION; ?>" />
<?php endif; ?>
<?php echo $this->journal2->minifier->js('header'); ?>
</head>
<body>
<div id="container">
    <div id="content" class="product-page-content">
    <h1 class="heading-title"><?php echo $heading_title; ?></h1>
    <div class="product-info">
    <div class="left">
        <?php if ($thumb) { ?>
        <div class="image">
            <?php if (isset($labels) && is_array($labels)): ?>
            <?php foreach ($labels as $label => $name): ?>
            <span class="label-<?php echo $label; ?>"><b><?php echo $name; ?></b></span>
            <?php endforeach; ?>
            <?php endif; ?>
            <a href="<?php echo $url->link('product/product&product_id=' . $product_id); ?>" target="_top" title="<?php echo $heading_title; ?>"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" data-largeimg="<?php echo $popup; ?>" /></a>
        </div>
        <?php } ?>
        <?php if ($images) { ?>
        <div id="product-gallery" class="image-additional <?php echo $this->journal2->settings->get('product_page_gallery_carousel') ? 'journal-carousel' : 'image-additional-grid'; ?>">
            <?php if ($this->journal2->settings->get('product_page_gallery_carousel')): ?>
            <div class="swiper">
            <div class="swiper-container" <?php echo $this->journal2->settings->get('rtl') ? 'dir="rtl"' : ''; ?>>
            <div class="swiper-wrapper">
            <?php endif; ?>
                <?php if ($thumb) { ?>
                    <a class="swiper-slide" href="<?php echo isset($popup_fixed) ? $popup_fixed : $popup; ?>" title="<?php echo $heading_title; ?>"><img src="<?php echo isset($thumb_fixed) ? $thumb_fixed : $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>"/></a>
                <?php } ?>
                <?php foreach ($images as $image) { ?>
                    <a class="swiper-slide" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" itemprop="image"/></a>
                <?php } ?>
            <?php if ($this->journal2->settings->get('product_page_gallery_carousel')): ?>
            </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            </div>
            <?php endif; ?>
        </div>
        <?php if ($this->journal2->settings->get('product_page_gallery_carousel')): ?>
        <script>
            (function () {
                var opts = {
                    slidesPerView: parseInt('<?php echo $this->journal2->settings->get('product_page_additional_width', 5) ?>', 10),
                    slidesPerGroup: parseInt('<?php echo $this->journal2->settings->get('product_page_additional_width', 5) ?>', 10),
                    spaceBetween: parseInt('<?php echo $this->journal2->settings->get('product_page_additional_spacing', 10) ?>', 10),
                    nextButton: $('#product-gallery .swiper-button-next'),
                    prevButton: $('#product-gallery .swiper-button-prev'),
                    autoplay: <?php echo $this->journal2->settings->get('product_page_gallery_carousel_autoplay') > 0 ? 4000 : 'false'; ?>,
                    autoplayStopOnHover: <?php echo $this->journal2->settings->get('related_products_carousel_pause_on_hover') ? 'true' : 'false'; ?>,
                    speed: 400,
                    touchEventsTarget: <?php echo $this->journal2->settings->get('product_page_gallery_carousel_touchdrag')  ? '\'container\'' : 'false'; ?>,
                };

                $('#product-gallery .swiper-container').swiper(opts);
            })();
        </script>
        <?php endif; ?>
        <?php } ?>
        <div class="image-gallery" style="display: none !important;">
            <?php if ($thumb) { ?>
            <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="swipebox"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
            <?php } ?>
            <?php if ($images) { ?>
            <?php foreach ($images as $image) { ?>
            <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="swipebox"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
            <?php } ?>
            <?php } ?>
        </div>
        <?php if ($this->journal2->settings->get('quickview_description_position') == 'image'): ?>
        <div id="tab-description" class="tab-content"><?php echo $description; ?></div>
        <?php endif; ?>
    </div>
    <div class="right">
    <div id="product" class="product-options">
    <ul class="list-unstyled description">
        <?php if($this->journal2->settings->get('product_views')): ?>
        <li class="product-views-count"><?php echo $this->journal2->settings->get('product_page_options_views_text'); ?>: <?php echo $this->journal2->settings->get('product_views'); ?></li>
        <?php endif; ?>
        <?php if($this->journal2->settings->get('manufacturer_image') == 'on'): ?>
        <li class="brand-logo">
            <a href="<?php echo $manufacturers; ?>" target="_top" class="brand-image">
                <img src="<?php echo $manufacturer_image; ?>" width="<?php echo $manufacturer_image_width; ?>" height="<?php echo $manufacturer_image_height; ?>" alt="<?php echo $manufacturer; ?>" />
            </a>
            <?php if(isset($manufacturer_image_name) && $manufacturer_image_name): ?>
            <a href="<?php echo $manufacturers; ?>" target="_top" class="brand-logo-text">
                <?php echo $manufacturer_image_name; ?>
            </a>
            <?php endif; ?>
            </li>
        <?php else: ?>
        <?php if ($manufacturer) { ?>
        <li class="p-brand"><?php echo $text_manufacturer; ?> <a href="<?php echo $manufacturers; ?>" target="_top"><?php echo $manufacturer; ?></a></li>
        <?php } ?>
        <?php endif; ?>
        <li class="p-model"><?php echo $text_model; ?></span> <span class="p-model" itemprop="model"><?php	echo "<font id='product_model'>".$model."</font>"; // <- Related Options / Связанные опции ?>
      </li>
        <?php if ($reward) { ?>
        <li class="p-rewards"><?php echo $text_reward; ?></span> <span class="p-rewards"><?php echo $reward; ?></li>
        <?php } ?>
        <li class="p-stock"><?php echo $text_stock; ?></span> <span class="journal-stock <?php echo isset($stock_status) ? $stock_status : ''; ?>"><?php	echo "<font id='product_stock'>".$stock."</font>"; // <- Related Options / Связанные опции  ?>
      </li>
    </ul>
    <?php if($this->journal2->settings->get('product_sold')): ?>
    <div class="product-sold-count-text"><?php echo $this->journal2->settings->get('product_sold'); ?></div>
    <?php endif; ?>
    <?php if ($price) { ?>
    <ul class="list-unstyled price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
        <?php if (!$special) { ?>
        <li class="product-price" itemprop="price"><?php echo $price; ?></li>
        <?php } else { ?>
        <li class="price-old"><?php echo $price; ?></li>
        <li class="price-new" itemprop="price"><?php echo $special; ?></li>
        <?php } ?>
        <?php if ($tax) { ?>
        <li class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></li>
        <?php } ?>
        <?php if ($points) { ?>
        <li class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></li>
        <?php } ?>
        <?php if ($discounts) { ?>
            <?php foreach ($discounts as $discount) { ?>
            <li><?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?></li>
            <?php } ?>
        <?php } ?>
          </ul>
    <?php } ?>
    <?php if ($options && $this->journal2->settings->get('quickview_product_options') === '1') { ?>
    <div class="options <?php echo $this->journal2->settings->get('product_page_options_push_classes'); ?>">
        <h3><?php echo $text_option; ?></h3>
        <?php foreach ($options as $option) { ?>
            <?php if ($option['type'] == 'select') { ?>
            <div class="option form-group<?php echo ($option['required'] ? ' required' : ''); ?> option-<?php echo $option['type']; ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                <?php if ($option_value['price']) { ?>
                (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                <?php } ?>
                </option>
                <?php } ?>
              </select>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'radio') { ?>
            <div class="option form-group<?php echo ($option['required'] ? ' required' : ''); ?> option-<?php echo $option['type']; ?>">
              <label class="control-label"><?php echo $option['name']; ?></label>
              <div id="input-option<?php echo $option['product_option_id']; ?>">
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <div class="radio">
                  <label>
                    <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                    <?php if (version_compare(VERSION, '2.2', '>=') && $option_value['image']) { ?>
                    <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" />
                    <?php } ?>
                    <?php echo $option_value['name']; ?>
                    <?php if ($option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'checkbox') { ?>
            <div class="option form-group<?php echo ($option['required'] ? ' required' : ''); ?> option-<?php echo $option['type']; ?>">
              <label class="control-label"><?php echo $option['name']; ?></label>
              <div id="input-option<?php echo $option['product_option_id']; ?>">
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                    <?php if (version_compare(VERSION, '2.2', '>=') && $option_value['image']) { ?>
                    <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" />
                    <?php } ?>
                    <?php echo $option_value['name']; ?>
                    <?php if ($option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if (version_compare(VERSION, '2.3', '<')): ?>
            <?php if ($option['type'] == 'image') { ?>
            <div class="option form-group<?php echo ($option['required'] ? ' required' : ''); ?> option-<?php echo $option['type']; ?>">
              <label class="control-label"><?php echo $option['name']; ?></label>
              <div id="input-option<?php echo $option['product_option_id']; ?>">
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <div class="radio">
                  <label>
                    <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                    <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> <?php echo $option_value['name']; ?>
                    <?php if ($option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php endif; ?>
            <?php if ($option['type'] == 'text') { ?>
            <div class="option form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'textarea') { ?>
            <div class="option form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'file') { ?>
            <div class="option form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label"><?php echo $option['name']; ?></label>
              <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
              <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'date') { ?>
            <div class="option form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <div class="input-group date">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'datetime') { ?>
            <div class="option form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <div class="input-group datetime">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'time') { ?>
            <div class="option form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <div class="input-group time">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
            <?php } ?>
    </div>
    <script>Journal.enableSelectOptionAsButtonsList();</script>
    <?php } ?>
    <?php if ($recurrings) { ?>
    <hr>
    <h3><?php echo $text_payment_recurring ?></h3>
    <div class="form-group required">
      <select name="recurring_id" class="form-control">
        <option value=""><?php echo $text_select; ?></option>
        <?php foreach ($recurrings as $recurring) { ?>
        <option value="<?php echo $recurring['recurring_id'] ?>"><?php echo $recurring['name'] ?></option>
        <?php } ?>
      </select>
      <div class="help-block" id="recurring-description"></div>
    </div>
    <?php } ?>
    <div class="form-group cart <?php echo isset($labels) && is_array($labels) && isset($labels['outofstock']) ? 'outofstock' : ''; ?>">
      <div>
          <?php if(!$this->journal2->settings->get('hide_add_to_cart_button')): ?>
        <span class="qty">
      <label class="control-label text-qty" for="input-quantity"><?php echo $entry_qty; ?></label>
      <input type="text" name="quantity" value="<?php echo $minimum; ?>" size="2" data-min-value="<?php echo $minimum; ?>" id="input-quantity" class="form-control" />
      <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
        </span>
        <button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="button"><span class="button-cart-text"><?php echo $button_cart; ?></span></button>
        <a id="more-details" class="button hint--top" data-hint="<?php echo ($this->journal2->settings->get('quickview_more_details_text')); ?>" target="_top" href="<?php echo $url->link('product/product&product_id=' . $product_id); ?>"><i></i></a>
        <?php else: ?>
        <a id="more-details" class="button enquiry-button" target="_top" href="<?php echo $url->link('product/product&product_id=' . $product_id); ?>"><?php echo ($this->journal2->settings->get('quickview_more_details_text')); ?></a>
        <?php endif; ?>
      <script>
        /* quantity buttons */
        var $input = $('.cart input[name="quantity"]');
        function up() {
          var val = parseInt($input.val(), 10) + 1 || parseInt($input.attr('data-min-value'), 10);
          $input.val(val);
        }
        function down() {
          var val = parseInt($input.val(), 10) - 1 || 0;
          var min = parseInt($input.attr('data-min-value'), 10) || 1;
          $input.val(Math.max(val, min));
        }
        $('<a href="javascript:;" class="journal-stepper">-</a>').insertBefore($input).click(down);
        $('<a href="javascript:;" class="journal-stepper">+</a>').insertAfter($input).click(up);
        $input.keydown(function (e) {
          if (e.which === 38) {
            up();
            return false;
          }
          if (e.which === 40) {
            down();
            return false;
          }
        });
      </script>
      </div>
    </div>
    <?php if ($minimum > 1) { ?>
    <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
    <?php } ?>
    <div class="wishlist-compare">
      <span class="links">
          <a onclick="parent.addToWishList('<?php echo $product_id; ?>');"><?php echo $button_wishlist; ?></a>
          <a onclick="parent.addToCompare('<?php echo $product_id; ?>');"><?php echo $button_compare; ?></a>
      </span>
    </div>
  <?php if ($this->journal2->settings->get('quickview_description_position') == 'options'): ?>
  <div id="tab-description" class="tab-content"><?php echo $description; ?></div>
  <?php endif; ?>
  </div>
    </div>
    </div>
    <?php if ($this->journal2->settings->get('quickview_description_position') == 'bottom'): ?>
    <div id="tab-description" class="tab-content"><?php echo $description; ?></div>
    <?php endif; ?>
    </div>
</div>
<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
// << Related Options / Связанные опции 
	<?php
		
		if ( !empty($ro_installed) ) {
			if (isset($ro_settings['stock_control']) && $ro_settings['stock_control'] && isset($ro_data) && $ro_data ) {
	?>
	
		if (!$('#button-cart').attr('allow_add_to_cart')) {
			if ( window.liveopencart && window.liveopencart.related_options_instances && window.liveopencart.related_options_instances.length ) {
				var ro_instances = window.liveopencart.related_options_instances;
				for ( var i_ro_instances in ro_instances ) {
					if ( !ro_instances.hasOwnProperty(i_ro_instances) ) continue;
					
					var ro_instance = ro_instances[i_ro_instances];
					if ( ro_instance.spec_fn && typeof(ro_instance.spec_fn.stockControl) == 'function' ) {
						// currently this function should exist only for one instance (product page)
						ro_instance.spec_fn.stockControl(1);
						return;
					}
					
				}
			}
			//ro_stock_control(1);
			//return;
		}
		$('#button-cart').attr('allow_add_to_cart','');
		
	<?php
			}
		}
	?>
			
// >> Related Options / Связанные опции  
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
                <?php if ($this->journal2->settings->get('quickview_product_options') !== '1'): ?>
                top.location = '<?php echo str_replace('&amp;', '&', $url->link('product/product', 'product_id=' . $product_id)); ?>';
                return;
                <?php endif; ?>
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) {
                if (!parent.Journal.showNotification(json['success'], json['image'], true)) {
                    $('.breadcrumb').after('<div class="alert alert-success success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

				parent.$('#cart-total').html(json['total']);

				$('html, body').animate({ scrollTop: 0 }, 'slow');

                parent.$('#cart ul').load('index.php?route=common/cart/info ul li');
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script>
    Journal.productPage();
    <?php if($this->journal2->settings->get('product_page_auto_update_price', '1') === '1'): ?>
    Journal.enableProductOptions();
    Journal.updatePrice = true;
    <?php endif; ?>
    <?php if ($this->journal2->settings->get('quickview_cloud_zoom') === '1'): ?>
    Journal.enableCloudZoom('inner');
    <?php endif; ?>
    $('.image > a').live('click', function () {
        top.location.href = "<?php echo $url->link('product/product&product_id=' . $product_id); ?>";
        return false;
    });
    <?php echo $this->journal2->settings->get('custom_js'); ?>
</script>
<!-- << Related Options / Связанные опции  -->
			
			<?php if ( !empty($ro_installed) ) { ?>
			
				<?php if ( !empty($ro_data) || !empty($ro_settings['show_clear_options']) ) { // the common part and the part for option reset ?> 
					<style>
						.ro_option_disabled { color: #e1e1e1!important; }
					</style>
				
					<?php if ( empty($ro_custom_selectbox_script_included) ) { ?>
						<?php if ( $ro_theme_name == 'theme625' || $ro_theme_name == 'theme628' || $ro_theme_name == 'theme638' || $ro_theme_name == 'theme649' || $ro_theme_name == 'theme707' || $ro_theme_name == 'theme725' || $ro_theme_name == 'themeXXX' ) { ?>
							<script src="catalog/view/theme/<?php echo $ro_theme_name; ?>/js/jquery.selectbox-0.2.min.js" type="text/javascript"></script>
							<style>
								<?php if ( $ro_theme_name == 'theme725' ) { ?>
									.sbDisabled { padding-left:10px; padding-top:8px; padding-bottom:8px; opacity:0.4; line-height:32px; }
								<?php } else { ?>
									.sbDisabled { padding-left:10px; padding-top:8px; padding-bottom:8px; opacity:0.4; line-height:37px; }
								<?php } ?>
							</style>
							<?php
								$ro_custom_selectbox_script_included = true;
							?>
						<?php } ?>
					<?php } ?>	
	
					<?php
						$ro_tpl_common_js = 'catalog/view/extension/related_options/tpl/product_page_common.tpl';
						if (class_exists('VQMod')) {
							include( VQMod::modCheck( modification($ro_tpl_common_js) ) );
						} else {
							include( modification($ro_tpl_common_js) );
						}	
					?>
				
				<?php } // the common part and the part for option reset ?>
				
				
				<?php if ( !empty($ro_data) ) { // the part when the product has related options ?>
					
					<?php
						$ro_tpl_ro_js = 'catalog/view/extension/related_options/tpl/product_page_related_options.tpl';
						if (class_exists('VQMod')) {
							include( VQMod::modCheck( modification($ro_tpl_ro_js) ) );
						} else {
							include( modification($ro_tpl_ro_js) );
						}	
					?>
					
				<?php } // the part for related options ?>	
				
				<?php if ( !empty($ro_data) || !empty($ro_settings['show_clear_options']) ) {	?>
					<script type="text/javascript">
					
					(function(){	
						var ro_params = {};
						ro_params['ro_settings'] = <?php echo json_encode($ro_settings); ?>;
						ro_params['ro_data'] = <?php echo json_encode($ro_data); ?>;
						ro_params['ro_theme_name'] = '<?php echo $ro_theme_name; ?>';
						<?php if ( isset($ros_to_select) && $ros_to_select ) { ?>
							ro_params['ros_to_select'] = <?php echo json_encode($ros_to_select); ?>;
						<?php } elseif (isset($_GET['filter_name'])) { ?>
							ro_params['filter_name'] = '<?php echo $_GET['filter_name']; ?>';
						<?php } elseif (isset($_GET['search'])) { ?>
							ro_params['filter_name'] = '<?php echo $_GET['search']; ?>';
						<?php } ?>
						<?php if ( isset($poip_ov) ) { ?>
							ro_params['poip_ov'] = '<?php echo $poip_ov; ?>';
						<?php } ?>
						
						var $container_of_options = $('body');
						<?php if ( $ro_theme_name == 'themeXXX' || $ro_theme_name == 'theme725' ) { ?>
							if ( $('.ajax-quickview').length ) {
								var $container_of_options = $('.ajax-quickview');
							}
						<?php } elseif ( $ro_theme_name == 'revolution') { ?>
							if ( $('#purchase-form').length ) { // quickorder
								var $container_of_options = $('#purchase-form');
							} else if ( $('#popup-view-wrapper').length ) { // quickview	
								var $container_of_options = $('#popup-view-wrapper');
							}	else if ( $('.product-info').length ) { // product page
								var $container_of_options = $('.product-info');
							}
						<?php } ?>
						
						var ro_instance = $container_of_options.liveopencart_RelatedOptions(ro_params);
						
						ro_instance.common_fn = ro_getCommonFunctions(ro_instance);
						ro_instance.common_fn.initBasic();
							
						<?php if ( !empty($ro_data) ) { // the part when the product has related options ?>
						
							var spec_fn = ro_getSpecificFunctions(ro_instance);
						
							// to custom
							ro_instance.use_block_options = ($('a[id^=block-option][option-value]').length || $('a[id^=block-image-option][option-value]').length || $('a[id^=color-][optval]').length);
							
							ro_instance.bind('setOptionValue_after.ro', spec_fn.event_setOptionValue_after);
							ro_instance.bind('init_after.ro', spec_fn.event_init_after);
							ro_instance.bind('setAccessibleOptionValues_select_after.ro', spec_fn.event_setAccessibleOptionValues_select_after);
							ro_instance.bind('setAccessibleOptionValues_radioUncheck_after.ro', spec_fn.event_setAccessibleOptionValues_radioUncheck_after);
							ro_instance.bind('setAccessibleOptionValues_radioToggle_after.ro', spec_fn.event_setAccessibleOptionValues_radioToggle_after);
							ro_instance.bind('setAccessibleOptionValues_radioEnableDisable_after.ro', spec_fn.event_setAccessibleOptionValues_radioEnableDisable_after);
							ro_instance.bind('setSelectedCombination_withAccessControl_after.ro', spec_fn.event_setSelectedCombination_withAccessControl_after);
							ro_instance.bind('controlAccessToValuesOfAllOptions_after.ro', spec_fn.event_controlAccessToValuesOfAllOptions_after);
							
							ro_instance.custom_radioToggle = spec_fn.custom_radioToggle;
							ro_instance.custom_radioEnableDisable = spec_fn.custom_radioEnableDisable;
							
							ro_instance.sstore_setOptionsStyles = spec_fn.sstore_setOptionsStyles;
							
							ro_instance.spec_fn = spec_fn;
							
						<?php } ?>
						
						ro_instance.initRO();
					
					})();
					
					</script>
				
				<?php } ?>
				
			<?php } ?>

<!-- >> Related Options / Связанные опции  -->
<?php /* <?php echo $footer; ?> */ ?>
</body>
</html>
