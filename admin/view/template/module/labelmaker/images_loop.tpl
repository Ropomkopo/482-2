<?php 
	// ID Base = $_id;
	
	// Label Name Base = $_lnb;
	
	// Label = $_label;
?>

<?php foreach ($images as $image) { ?>
	<div class="image_wrap type-<?php echo $image['type']; ?>">
		<?php if (strpos($image['src'], 'uploaded_images') != false) { ?>
			<div class="btn-delete-image" data-image="<?php echo $image['name']; ?>">Delete this image&nbsp;&nbsp;<i class="fa fa-remove"></i></div>
		<?php } ?>
		<div class="btn-add-image" data-rel="<?php echo $_id; ?>_imagepreview">
			Add to label&nbsp;&nbsp;<i class="icon-arrow-right"></i>
		</div>
		<div class="img" data-image-path="<?php echo $image['path']; ?>" data-store-id="<?php echo $store['store_id']; ?>" data-label-id="<?php echo $label_id; ?>"  data-language-id="<?php echo $language['language_id']; ?>" data-rel="<?php echo $_id; ?>_imagedata" data-width="<?php echo $image['dimensions']['width']; ?>" data-height="<?php echo $image['dimensions']['height']; ?>">
			<div class="remove"></div>
			<img src="<?php echo $image['src']; ?>" title="<?php echo $image['name']; ?>" alt="<?php echo $image['name']; ?>" />
		</div>
	</div>
<?php } ?>