<div id="merge_modal" class="modal fade">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header merge-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title"><?php echo $text_merge_order; ?></h4>
			</div>

			<div class="modal-body merge-body">
				<form id="merge_form">
					<div class="form-group">
						<label for="merge_mode"><?php echo $entry_merge_mode; ?></label>
						<select name="merge_mode" id="merge_mode" class="form-control">
							<option value="1" selected="selected"><?php echo $text_merge_addnew; ?></option>
							<option value="2"><?php echo $text_merge_inold; ?></option>
						</select>
					</div>
					
					<div class="form-group main-merge">
						<label for="main_order"><?php echo $entry_main_order; ?></label>
						<a tabindex="0" class="btn-popover" role="button" data-toggle="popover" data-placement="top" title="" data-content="<?php echo $help_main_order; ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
						<select name="main_order" id="main_order" class="form-control">
							<?php $i = 1; ?>
							<?php foreach ($orders as $order_id) { ?>
							<?php if ($i == 1) { ?>
							<option value="<?php echo $order_id; ?>" selected="selected"><?php echo $order_id; ?></option>
							<?php } else { ?>
							<option value="<?php echo $order_id; ?>"><?php echo $order_id; ?></option>
							<?php } ?>
							<?php $i++; ?>
							<?php } ?>
						</select>
						<?php foreach ($orders as $order_id) { ?>
						<input type="hidden" name="orders[]" value="<?php echo $order_id; ?>" />
						<?php } ?>
					</div>
					
					<div class="form-group">
						<label for="old_order"><?php echo $entry_old_order; ?></label>
						<select name="old_order" id="old_order" class="form-control">
							<option value="0" selected="selected"><?php echo $text_old_nothing; ?></option>
							<option value="1"><?php echo $text_old_status; ?></option>
							<option value="2"><?php echo $text_old_delete; ?></option>
						</select>
					</div>
					
					<div class="form-group old-status" style="display:none;">
						<label for="old_status_id"><?php echo $entry_order_status; ?></label>
						<select name="old_status_id" id="old_status_id" class="form-control">
							<?php $i = 1; ?>
							<?php foreach ($order_statuses as $order_status) { ?>
							<?php if ($i == 1) { ?>
							<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
							<?php } else { ?>
							<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
							<?php } ?>
							<?php $i++; ?>
							<?php } ?>
						</select>
					</div>
				</form>
			</div>

			<div class="modal-footer" style="text-align:center;">
				<a class="btn btn-success" onclick="merge_order();"><?php echo $button_merge; ?></a>
			</div>
		</div>
	</div>
<script type="text/javascript"><!--
$('.btn-popover').popover({	trigger: "hover"});
//--></script>
</div>