<?php if ($error) { ?>
<div class="warning"><?php echo $error; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<table class="list table-history">
  <thead>
    <tr>
      <td class="order-date-added left"><b><?php echo $column_date; ?></b></td>
      <td class="order-status left"><b><?php echo $column_status; ?></b></td>
      <td class="order-comment left"><b><?php echo $column_comment; ?></b></td>
      <td class="order-notify left"><b><?php echo $column_notify; ?></b></td>
    </tr>
  </thead>
  <tbody>
    <?php if ($histories) { ?>
    <?php foreach ($histories as $history) { ?>
    <tr>
      <td class="center" nowrap><?php echo $history['date_added']; ?></td>
      <td class="left"><?php echo $history['status']; ?></td>
      <td class="left"><?php echo $history['comment']; ?></td>
      <td class="center"><?php echo $history['notify']; ?></td>
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<div class="pagination-block">
	<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
	<div class="col-sm-6 text-right pagination-results"><?php if($pagination) { ?><?php echo $results; ?><?php } ?></div>
</div>
