<div id="similar_modal" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header similar-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title"><?php echo $text_similar_order; ?></h4>
			</div>

			<div class="modal-body similar-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<td class="text-center"><?php echo $column_order_id; ?></td>
								<td class="text-center"><?php echo $column_customer; ?></td>
								<td class="text-center"><?php echo $column_status; ?></td>
								<td class="text-center"><?php echo $column_total; ?></td>
								<td class="text-center"><?php echo $column_date_added; ?></td>
								<td class="text-center"><?php echo $column_date_modified; ?></td>
								<td class="text-center"><?php echo $column_action; ?></td>
							</tr>
						</thead>
						<tbody>
						<?php if ($orders) { ?>
							<?php foreach ($orders as $order) { ?>
							<tr>
								<td class="text-center"><?php echo $order['order_id']; ?></td>
								<td class="text-left"><?php echo $order['customer']; ?></td>
								<td class="text-left"><?php echo $order['status']; ?></td>
								<td class="text-right" nowrap><?php echo $order['total']; ?></td>
								<td class="text-center" nowrap><?php echo $order['date_added']; ?></td>
								<td class="text-center" nowrap><?php echo $order['date_modified']; ?></td>
								<td class="text-right">
									<a href="<?php echo $order['view']; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
									<a href="<?php echo $order['edit']; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
								</td>
							</tr>
							<?php } ?>
						<?php } else { ?>
							<tr>
								<td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="modal-footer" style="text-align:center;"></div>
		</div>
	</div>
</div>