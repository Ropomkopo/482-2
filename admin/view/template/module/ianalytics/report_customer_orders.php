<?php
if (isset($_GET['fromDate'])) { $filter_date_start = $_GET['fromDate']; } else { $filter_date_start = ''; }
if (isset($_GET['toDate'])) {	$filter_date_end = $_GET['toDate']; } else { $filter_date_end = ''; }
if (isset($_GET['filterOrders'])) { $filter_order_status_id = $_GET['filterOrders']; } else { $filter_order_status_id = 0; }
if (isset($_GET['page'])) { $page = $_GET['page']; } else {	$page = 1; }

$customers = array();

$data3 = array(
	'filter_date_start'	  		=> $filter_date_start, 
	'filter_date_end'			=> $filter_date_end, 
	'filter_order_status_id' 	=> $filter_order_status_id,
	'start'                  	=> ($page - 1) * $limit,
	'limit'                  	=> $limit
);

$customer_results = $model_module_ianalitycs->getOrdersCustomer($data3);
$customer_total = $model_report_customer->getTotalOrders($data3); 

foreach ($customer_results as $cu_result) {
	$action = array();
	$action[] = array(
		'text' => $language->get('text_edit'),
		'href' => $url_link->link('sale/customer/edit', 'token=' . $token . '&customer_id=' . $cu_result['customer_id'] . $url, 'SSL')
	);

	$customers[] = array(
		'customer'       => $cu_result['customer'],
		'email'          => $cu_result['email'],
		'customer_group' => $cu_result['customer_group'],
		'status'         => ($cu_result['status'] ? $language->get('text_enabled') : $language->get('text_disabled')),
		'orders'         => $cu_result['orders'],
		'total'          => $currency_lib->format($cu_result['total'], $currency),
		'action'         => $action
	);
}

$url = '';
if (isset($_GET['fromDate'])) {	$url .= '&fromDate=' . $_GET['fromDate']; }
if (isset($_GET['toDate'])) {	$url .= '&toDate=' . $_GET['toDate']; }
if (isset($_GET['filterOrders'])) {	$url .= '&filterOrders=' . $_GET['filterOrders']; }

$pagination					= new Pagination();
$pagination->total			= $customer_total;
$pagination->page			= $page;
$pagination->limit			= $limit; 
$pagination->url			= $pagination->url = $url_link->link('module/ianalytics', 'token=' . $token . $url . '&page={page}');
$pagination_customers		= $pagination->render();
$results_customers			= sprintf($language->get('text_pagination'), ($pagination->total) ? (($page - 1) * $pagination->limit) + 1 : 0, ((($page - 1) * $pagination->limit) > ($pagination->total - $pagination->limit)) ? $pagination->total : ((($page - 1) * $pagination->limit) + $pagination->limit), $pagination->total, ceil($pagination->total / $pagination->limit));

if ($customers) { ?>
	<br />
    <div style="position: relative; padding-bottom: 30%; height: 0; overflow: hidden; max-width: 100%; height: auto;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
            <canvas id="customers_report_canvas" style="max-width:100%; max-height:100%;"></canvas>
        </div>
    </div>
    <script type="text/javascript">
        iAnalytics.charts.customers_report = {
            instance: null,
            name: 'customers_report',
            canvas: 'customers_report_canvas',	
            type: 'Bar',
            data: {
				labels : [<?php foreach ($customers as $customer) { ?>'<?php echo $customer['customer']; ?>', <?php } ?>],
                datasets : [{
                    label: "Customers",
					fillColor: "rgba(1,159,215,0.5)",
					strokeColor: "rgba(1,159,215,0.8)",
					highlightFill: "rgba(1,159,215,0.75)",
					highlightStroke: "rgba(1,159,215,1)",
                    data : [<?php foreach ($customers as $customer) { echo $customer['orders']; ?>, <?php } ?>]
                }]
            }
        }
    </script>
<?php } else { echo "<center>There is no data yet for a chart.</center>"; }?>
<br />
<table class="table-hover table table-striped">
    <thead>
      <tr>
        <th style="width:12%;">Customer Name</th>
        <th style="width:12%;">Email</th>
        <th style="width:12%;">Group</th>
        <th style="width:12%;">Status</th>
        <th style="width:12%;">Orders</th>
        <th style="width:12%;">Total</th>
        <th style="width:12%;">Action</th>
      </tr>
    </thead>
<?php if ($customers) { ?>
	<?php foreach ($customers as $customer) { ?>
        <tr>
            <td><?php echo $customer['customer']; ?></td>
            <td><?php echo $customer['email']; ?></td>
            <td><?php echo $customer['customer_group']; ?></td>
            <td><?php echo $customer['status']; ?></td>
            <td><?php echo $customer['orders']; ?></td>
            <td><?php echo $customer['total']; ?></td>
            <td><?php foreach ($customer['action'] as $action) { ?>
            	<a class="btn btn-default btn-sm" target="_blank" href="<?php echo $action['href']; ?>"><i class="fa fa-pencil"></i>&nbsp;<?php echo $action['text']; ?></a>
            <?php } ?></td>
        </tr>
        <?php } ?>
<?php } else { ?>
	<tr>
		<td class="center" colspan="4">There are no results yet!</td>
	</tr>
<?php } ?>
</table>
<div class="row">
  <div class="col-sm-6 text-left"><?php echo $pagination_products; ?></div>
  <div class="col-sm-6 text-right"><?php echo $results_customers; ?></div>
</div>