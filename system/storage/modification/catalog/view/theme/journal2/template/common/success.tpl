<?php echo $header; ?>
<div id="container" class="container j-container success-page">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo $breadcrumb['href']; ?>" itemprop="url"><span itemprop="title"><?php echo $breadcrumb['text']; ?></span></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?><?php echo $column_right; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1 class="heading-title"><?php echo $heading_title; ?></h1>
      <?php echo $text_message; ?>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn-primary button"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    </div>
</div>

				<?php if( (isset($order_id)) && ($order_id) && (isset($iAnalytics)) && ($iAnalytics['Enabled']=='yes') && ($iAnalytics['GoogleAnalytics']=='yes') && (isset($iAnalytics['GoogleAnalyticsIDNumber'])) ) { ?>
					<script type="text/javascript">
				        var _gaq = _gaq || [];
       					_gaq.push(['_setAccount', '<?php echo $iAnalytics['GoogleAnalyticsIDNumber']; ?>']);
       					_gaq.push(['_set', 'currencyCode', '<?php echo $order_info["currency_code"]; ?>']);
        				_gaq.push(['_trackPageview']);
        				_gaq.push(['_addTrans',
         					'<?php echo $order_id; ?>',					   // Transaction ID *
          					'<?php echo $store_name; ?>',					 // Store Name
							'<?php echo $order_info["total"]; ?>',          // Cart Total
							'<?php echo $tax; ?>',          				// Tax
							'<?php echo $order_info["shipping_city"]; ?>',	// City
							'<?php echo $order_info["shipping_zone"]; ?>',	// State/Province
							'<?php echo $order_info["shipping_country"]; ?>'// Country
        				]);
				<?php foreach ($order_products as $row) { ?>
         				_gaq.push(['_addItem',
							'<?php echo $order_id; ?>',					// Transanction ID *
            				'<?php echo $row["model"]; ?>',              // SKU/Code *
          					'<?php echo $row["name"]; ?>',               // Product Name
							'',          							     // Category
            				'<?php echo $row["price"]; ?>',				// Price *
            				'<?php echo $row["quantity"]; ?>'			 // Quantity *
         				 ]);
        		<?php } ?>
         				_gaq.push(['_trackTrans']); 

						(function() {
						  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
						  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
						  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
						})();
   		 		</script>
   			<?php } ?>
			
<?php echo $footer; ?>
