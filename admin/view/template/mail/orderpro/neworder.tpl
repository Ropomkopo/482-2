<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title; ?></title>
<style media="print" type="text/css">.noprint {display: none;}</style>
</head>
<?php 
$voucher_colspan = 1;
$total_colspan = 3;
if ($show_pid) {$voucher_colspan += 1;$total_colspan += 1;}
if ($show_image) {$voucher_colspan += 1;$total_colspan += 1;}
if ($show_model) {$voucher_colspan += 1;$total_colspan += 1;}
if ($show_sku) {$voucher_colspan += 1;$total_colspan += 1;}
if ($show_upc) {$voucher_colspan += 1;$total_colspan += 1;}
if ($show_ean) {$voucher_colspan += 1;$total_colspan += 1;}
if ($show_jan) {$voucher_colspan += 1;$total_colspan += 1;}
if ($show_isbn) {$voucher_colspan += 1;$total_colspan += 1;}
if ($show_mpn) {$voucher_colspan += 1;$total_colspan += 1;}
if ($show_location) {$voucher_colspan += 1;$total_colspan += 1;}
if ($show_weight) {$voucher_colspan += 1;$total_colspan += 1;}
?>
<body style="font-family: Arial, Helvetica, sans-serif;font-size:12px;color:#000000;background:#FFFFFF;">
<div style="width:670px;margin:auto;padding:10px;box-sizing:border-box;border:1px solid #ddd;box-shadow:0px 1px 5px rgba(85, 85, 85, 0.5);">
<p class="noprint" style="margin-top:0px;margin-bottom:20px;"><?php echo $text_greeting; ?></p>
<?php if ($customer_id) { ?>
<p class="noprint" style="margin-top: 0px; margin-bottom:20px;"><?php echo $text_link; ?></p>
<p class="noprint" style="margin-top: 0px; margin-bottom:20px;"><a href="<?php echo $link; ?>"><?php echo $link; ?></a></p>
<?php } ?>
<?php if ($download) { ?>
<p class="noprint" style="margin-top:0px; margin-bottom:20px;"><?php echo $text_download; ?></p>
<p class="noprint" style="margin-top:0px; margin-bottom:20px;"><a href="<?php echo $download; ?>"><?php echo $download; ?></a></p>
<?php } ?>
<div style="height:20px;border-top:1px solid #CDDDDD;"></div>
<table style="width:100%;margin-bottom:20px;">
	<tr>
		<td valign="middle" width="50%">
			<a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>"><img style="border:none;" src="<?php echo $logo; ?>" alt="<?php echo $store_name; ?>" /></a>
		</td>
		<td valign="middle" width="50%" style="padding-left:30px;">
			<b><?php echo $store_name; ?></b><br />
			<b><?php echo $text_address; ?></b><?php echo $store_address; ?><br />
			<b><?php echo $text_telephone; ?></b><?php echo $store_telephone; ?><br />
			<?php if ($store_fax) { ?>
				<b><?php echo $text_fax; ?></b><?php echo $store_fax; ?><br />
			<?php } ?>
			<b><?php echo $text_email; ?></b><?php echo $store_email; ?><br />
			<b><?php echo $text_url; ?></b><?php echo $store_url; ?>
		</td>
	</tr>
</table>
<table style="border-collapse:collapse;width:100%;margin-bottom:20px;border-top:1px solid #CDDDDD;border-right:1px solid #CDDDDD;">
	<tr>
		<td style="background:#E7EFEF;border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;" align="center" valign="middle" width="24%"><b><?php echo $text_order; ?></b></td>
		<td style="background:#E7EFEF;border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;" align="center" valign="middle" width="38%"><b><?php echo $text_to; ?></b></td>
		<td style="background:#E7EFEF;border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;" align="center" valign="middle" width="38%"><b><?php echo $text_ship_to; ?></b></td>
	</tr>
	<tr>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;" valign="top">
			<b><?php echo $text_order_id; ?></b><?php echo $order_id; ?>			
			<br /><b><?php echo $text_date_added; ?></b><?php echo $date_added; ?>
		</td>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;" valign="top">
			<?php echo $payment_address; ?><br/>
			<?php echo $email; ?><br/>
			<?php echo $telephone; ?><br/>
			<?php if ($company) { ?>
			<br/>
			<?php echo $text_company; ?> <?php echo $company; ?>
			<?php } ?>
		</td>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;" valign="top">
			<?php echo $shipping_address; ?>
		</td>
	</tr>
	<tr>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;"><b><?php echo $text_payment_method; ?></b></td>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;" colspan="2"><?php echo $payment_method; ?></td>
	</tr>
	<?php if ($shipping_method) { ?>
	<tr>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;"><b><?php echo $text_shipping_method; ?></b></td>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;" colspan="2"><?php echo $shipping_method; ?></td>
	</tr>
	<?php } ?>
</table>
<?php if ($comment) { ?>
<table style="border-collapse:collapse;width:100%;margin-bottom:20px;border-top:1px solid #CDDDDD;border-right:1px solid #CDDDDD;">
	<tr>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;" width="24%"><b><?php echo $text_comment_customer; ?></b></td>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><?php echo $comment; ?></td>
	</tr>
</table>
<?php } ?>
<table style="border-collapse:collapse;width:100%;margin-bottom:20px;border-top:1px solid #CDDDDD;border-right:1px solid #CDDDDD;">
	<tr>
		<?php if ($show_pid) { ?><td valign="middle" align="center" style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;width:50px;"><b><?php echo $column_pid; ?></b></td><?php } ?>
		<?php if ($show_image) { ?><td valign="middle" align="center" style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;width:65px;"><b><?php echo $column_image; ?></b></td><?php } ?>
		<td valign="middle" align="center" style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;"><b><?php echo $column_product; ?></b></td>
		<?php if ($show_model) { ?><td valign="middle" align="center" style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;width:100px;"><b><?php echo $column_model; ?></b></td><?php } ?>
		<?php if ($show_sku) { ?><td valign="middle" align="center" style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;width:100px;"><b><?php echo $column_sku; ?></b></td><?php } ?>
		<?php if ($show_upc) { ?><td valign="middle" align="center" style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;width:100px;"><b><?php echo $column_upc; ?></b></td><?php } ?>
		<?php if ($show_ean) { ?><td valign="middle" align="center" style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;width:100px;"><b><?php echo $column_ean; ?></b></td><?php } ?>
		<?php if ($show_jan) { ?><td valign="middle" align="center" style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;width:100px;"><b><?php echo $column_jan; ?></b></td><?php } ?>
		<?php if ($show_isbn) { ?><td valign="middle" align="center" style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;width:100px;"><b><?php echo $column_isbn; ?></b></td><?php } ?>
		<?php if ($show_mpn) { ?><td valign="middle" align="center" style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;width:100px;"><b><?php echo $column_mpn; ?></b></td><?php } ?>
		<?php if ($show_location) { ?><td valign="middle" align="center" style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;width:100px;"><b><?php echo $column_location; ?></b></td><?php } ?>
		<?php if ($show_weight) { ?><td valign="middle" align="center" style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;width:60px;white-space:nowrap;"><b><?php echo $column_weight; ?></b></td><?php } ?>
		<td valign="middle" align="center" style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;width:45px;"><b><?php echo $column_quantity; ?></b></td>
		<td valign="middle" align="center" style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;width:70px;"><b><?php echo $column_price; ?></b></td>
		<td valign="middle" align="center" style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;width:80px;"><b><?php echo $column_total; ?></b></td>
	</tr>
	<?php foreach ($products as $product) { ?>
	<tr>
		<?php if ($show_pid) { ?><td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;" align="center"><?php echo $product['product_id']; ?></td><?php } ?>
		<?php if ($show_image) { ?><td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;" align="center"><img src="<?php echo $product['img']; ?>" alt="" /></td><?php } ?>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><?php echo $product['name']; ?>
			<?php foreach ($product['option'] as $option) { ?>
				<br />&nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
			<?php } ?></td>
		<?php if ($show_model) { ?><td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><?php echo $product['model']; ?></td><?php } ?>
		<?php if ($show_sku) { ?><td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><?php echo $product['sku']; ?></td><?php } ?>
		<?php if ($show_upc) { ?><td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><?php echo $product['upc']; ?></td><?php } ?>
		<?php if ($show_ean) { ?><td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><?php echo $product['ean']; ?></td><?php } ?>
		<?php if ($show_jan) { ?><td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><?php echo $product['jan']; ?></td><?php } ?>
		<?php if ($show_isbn) { ?><td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><?php echo $product['isbn']; ?></td><?php } ?>
		<?php if ($show_mpn) { ?><td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><?php echo $product['mpn']; ?></td><?php } ?>
		<?php if ($show_location) { ?><td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><?php echo $product['location']; ?></td><?php } ?>
		<?php if ($show_weight) { ?><td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;white-space:nowrap;" align="right"><?php echo $product['weight']; ?></td><?php } ?>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;" align="center"><?php echo $product['quantity']; ?></td>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;white-space:nowrap;" align="right"><?php echo $product['price']; ?></td>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;white-space:nowrap;" align="right"><?php echo $product['total']; ?></td>
	</tr>
	<?php } ?>
	<?php foreach ($vouchers as $voucher) { ?>
	<tr>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;" align="left" colspan="<?php echo $voucher_colspan; ?>"><?php echo $voucher['description']; ?></td>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;" align="right">1</td>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;white-space:nowrap;" align="right"><?php echo $voucher['amount']; ?></td>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;white-space:nowrap;" align="right"><?php echo $voucher['amount']; ?></td>
	</tr>
	<?php } ?>
	<?php foreach ($totals as $total) { ?>
	<tr>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;" align="right" colspan="<?php echo $total_colspan; ?>"><b><?php echo $total['title']; ?>:</b></td>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;white-space:nowrap;" align="right"><?php echo $total['text']; ?></td>
	</tr>
	<?php } ?>
</table>
<p class="noprint" style="margin-top:0px;margin-bottom:20px;"><?php echo $text_footer; ?></p>
</div>
</body>
</html>