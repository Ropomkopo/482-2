<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title; ?></title>
<style media="print" type="text/css">.noprint {display: none;}</style>
</head>
<body style="font-family: Arial, Helvetica, sans-serif;font-size:13px;color:#000000;background:#FFFFFF;">
<div style="width:670px;margin:auto;padding:10px;box-sizing:border-box;border:1px solid #ddd;box-shadow:0px 1px 5px rgba(85, 85, 85, 0.5);">
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
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;" width="24%"><b><?php echo $text_order_id; ?></b></td>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><?php echo $order_id; ?></td>
	</tr>
	<tr>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;" width="24%"><b><?php echo $text_date_added; ?></b></td>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><?php echo $date_added; ?></td>
	</tr>
	<tr>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;" width="24%"><b><?php echo $text_date_modified; ?></b></td>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><?php echo $date_modified; ?></td>
	</tr>
<?php if ($order_status) { ?>
	<tr>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;" width="24%"><b><?php echo $text_order_status; ?></b></td>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><?php echo $order_status; ?></td>
	</tr>
<?php } ?>
</table>
<?php if ($link) { ?>
<table style="border-collapse:collapse;width:100%;margin-bottom:20px;border-top:1px solid #CDDDDD;border-right:1px solid #CDDDDD;">
	<tr>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;"><b><?php echo $text_link; ?></b></td>
	<tr>
	</tr>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><a href="<?php echo $link; ?>"><?php echo $text_account; ?></a></td>
	</tr>
</table>
<?php } ?>
<?php if ($comment) { ?>
<table style="border-collapse:collapse;width:100%;margin-bottom:20px;border-top:1px solid #CDDDDD;border-right:1px solid #CDDDDD;">
	<tr>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;background:#E7EFEF;"><b><?php echo $text_comment; ?></b></td>
	<tr>
	</tr>
		<td style="border-left:1px solid #CDDDDD;border-bottom:1px solid #CDDDDD;padding:10px;"><?php echo $comment; ?></td>
	</tr>
</table>
<?php } ?>
<p style="margin-top:0px;margin-bottom:20px;"><?php echo $text_footer; ?></p>
</div>
</body>
</html>