<?php
if (isset($_GET['fromDate'])) { $filter_date_start = $_GET['fromDate']; } else { $filter_date_start = ''; }
if (isset($_GET['toDate'])) {	$filter_date_end = $_GET['toDate']; } else { $filter_date_end = ''; }
if (isset($_GET['filterOrders'])) { $filter_order_status_id = $_GET['filterOrders']; } else { $filter_order_status_id = 0; }
if (isset($_GET['page'])) { $page = $_GET['page']; } else {	$page = 1; }
$filter_group = 'day';

$orders = array();
$data4 = array(
	'filter_date_start'	     => $filter_date_start, 
	'filter_date_end'	     => $filter_date_end, 
	'filter_group'           => $filter_group,
	'filter_order_status_id' => $filter_order_status_id,
	'start'                  => ($page - 1) * $limit,
	'limit'                  => $limit
);

$order_total = $model_sale_order->getTotalOrders($data4);
$order_results = $model_module_ianalitycs->getOrders($data4);

foreach ($order_results as $or_result) {
	$orders[] = array(
		'date_start' 			=> date($language->get('date_format_short'), strtotime($or_result['date_start'])),
		'date_end'   			=> date($language->get('date_format_short'), strtotime($or_result['date_end'])),
		'orders'     			=> $or_result['orders'],
		'tax'        			=> $currency_lib->format($or_result['tax'], $currency),
		'tax_nocurrency'        => isset($or_result['tax']) ? $or_result['tax'] : '0',
		'total'      			=> $currency_lib->format($or_result['total'], $currency),
		'total_nocurrency'      => $or_result['total']
	);
}

$url = '';
if (isset($_GET['fromDate'])) {	$url .= '&fromDate=' . $_GET['fromDate']; }
if (isset($_GET['toDate'])) {	$url .= '&toDate=' . $_GET['toDate']; }
if (isset($_GET['filterOrders'])) {	$url .= '&filterOrders=' . $_GET['filterOrders']; }

$pagination					= new Pagination();
$pagination->total			= $order_total;
$pagination->page			= $page;
$pagination->limit			= $limit; 
$pagination->url			= $pagination->url = $url_link->link('module/ianalytics', 'token=' . $token . $url . '&page={page}');
$pagination_sales			= $pagination->render();
$results_sales 				= sprintf($language->get('text_pagination'), ($pagination->total) ? (($page - 1) * $pagination->limit) + 1 : 0, ((($page - 1) * $pagination->limit) > ($pagination->total - $pagination->limit)) ? $pagination->total : ((($page - 1) * $pagination->limit) + $pagination->limit), $pagination->total, ceil($pagination->total / $pagination->limit));

if ($orders) { ?>
	<br />
    <div style="position: relative; padding-bottom: 30%; height: 0; overflow: hidden; max-width: 100%; height: auto;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
            <canvas id="sales_report_canvas" style="max-width:100%; max-height:100%;"></canvas>
        </div>
    </div>
    <script type="text/javascript">
        iAnalytics.charts.sales_report = {
            instance: null,
            name: 'sales_report',
            canvas: 'sales_report_canvas',	
            type: 'Line',
            data: {
				<?php $reversed = array_reverse($orders, true); ?>
				labels : [<?php foreach ($reversed as $order) { ?>'<?php echo $order['date_start']; ?>', <?php } ?>],
				datasets : [
				{
					label: "Total",
					fillColor: "rgba(180,180,180,0.2)",
					strokeColor: "rgba(180,180,180,1)",
					pointColor: "rgba(180,180,180,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke: "rgba(1,159,215,1)",
					data : [<?php foreach ($reversed as $order) { echo $order['total_nocurrency']; ?>, <?php } ?>]
				},
				{
					label: "Revenue",
					fillColor: "rgba(158,204,60,0.2)",
					strokeColor: "rgba(158,204,60,1)",
					pointColor: "rgba(158,204,60,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(151,187,205,1)",
					data : [<?php foreach ($reversed as $order) { echo $order['total_nocurrency']-$order['tax_nocurrency']; ?>, <?php } ?>]
				},
				{
					label: "Taxes",
					fillColor : "rgba(204,60,60,0.2)",
					strokeColor : "rgba(204,60,60,1)",
					pointColor : "rgba(204,60,60,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(204,60,60,1)",
					data : [<?php foreach ($reversed as $order) { echo $order['tax_nocurrency']; ?>, <?php } ?>]
				},]
				
            }
        }
    </script>
    <div id="sales_report_legend"></div>
<?php } else { echo "<br /><center><strong>There is no data yet for a chart.</strong></center><br />"; }?>
<br />
<table class="table-hover table table-striped">
    <thead>
      <tr>
        <th style="width:20%;">Date</th>
        <th style="width:20%;">Orders</th>
        <th style="width:20%;">Tax</th>
        <th style="width:20%;">Total</th>
      </tr>
    </thead>
<?php if ($orders) { ?>
     <?php foreach ($orders as $order) { ?>
          <tr>
            <td><?php echo $order['date_start']; ?></td>
            <td><?php echo $order['orders']; ?></td>
            <td><?php echo $order['tax']; ?></td>
            <td><?php echo $order['total']; ?></td>
          </tr>
     <?php } ?>
<?php } else { ?>
	<tr>
		<td class="center" colspan="4">There are no results yet!</td>
	</tr>
<?php } ?>
</table>
<div class="row">
  <div class="col-sm-6 text-left"><?php echo $pagination_sales; ?></div>
  <div class="col-sm-6 text-right"><?php echo $results_sales; ?></div>
</div>