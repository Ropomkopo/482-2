<?php
if (isset($_GET['fromDate'])) { $filter_date_start = $_GET['fromDate']; } else { $filter_date_start = ''; }
if (isset($_GET['toDate'])) {	$filter_date_end = $_GET['toDate']; } else { $filter_date_end = ''; }
if (isset($_GET['filterOrders'])) { $filter_order_status_id = $_GET['filterOrders']; } else { $filter_order_status_id = 0; }
if (isset($_GET['page'])) { $page = $_GET['page']; } else {	$page = 1; }

$products = array();
$data2 = array(
	'filter_date_start'	  		=> $filter_date_start, 
	'filter_date_end'			=> $filter_date_end, 
	'filter_order_status_id' 	=> $filter_order_status_id,
	'start'                  	=> ($page - 1) * $limit,
	'limit'                  	=> $limit
);

$product_total = $model_report_product->getTotalPurchased($data2);
$product_results = $model_report_product->getPurchased($data2);

foreach ($product_results as $pr_result) {
	$products[] = array(
		'name'       => $pr_result['name'],
		'model'      => $pr_result['model'],
		'quantity'   => $pr_result['quantity'],
		'total'      => $currency_lib->format($pr_result['total'], $currency)
	);
}

$url = '';
if (isset($_GET['fromDate'])) {	$url .= '&fromDate=' . $_GET['fromDate']; }
if (isset($_GET['toDate'])) {	$url .= '&toDate=' . $_GET['toDate']; }
if (isset($_GET['filterOrders'])) {	$url .= '&filterOrders=' . $_GET['filterOrders']; }

$pagination					= new Pagination();
$pagination->total			= $product_total;
$pagination->page			= $page;
$pagination->limit			= $limit; 
$pagination->url			= $pagination->url = $url_link->link('module/ianalytics', 'token=' . $token . $url . '&page={page}');
$pagination_products		= $pagination->render();
$results_products			= sprintf($language->get('text_pagination'), ($pagination->total) ? (($page - 1) * $pagination->limit) + 1 : 0, ((($page - 1) * $pagination->limit) > ($pagination->total - $pagination->limit)) ? $pagination->total : ((($page - 1) * $pagination->limit) + $pagination->limit), $pagination->total, ceil($pagination->total / $pagination->limit));

if ($products) { ?>
	<br />
    <div style="position: relative; padding-bottom: 30%; height: 0; overflow: hidden; max-width: 100%; height: auto;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
            <canvas id="products_report_canvas" style="max-width:100%; max-height:100%;"></canvas>
        </div>
    </div>
    <script type="text/javascript">
        iAnalytics.charts.products_report = {
            instance: null,
            name: 'products_report',
            canvas: 'products_report_canvas',	
            type: 'Bar',
            data: {
				labels : [<?php foreach ($products as $product) { ?>'<?php echo (strlen($product['name']) > 13) ? (substr($product['name'], 0, 13).'...') : $product['name']; ?>', <?php } ?>],
                datasets : [{
                    label: "Products",
					fillColor: "rgba(1,159,215,0.5)",
					strokeColor: "rgba(1,159,215,0.8)",
					highlightFill: "rgba(1,159,215,0.75)",
					highlightStroke: "rgba(1,159,215,1)",
                    data : [<?php foreach ($products as $product) { echo $product['quantity']; ?>, <?php } ?>]
                }]
            }
        }
    </script>
<?php } else { echo "<center>There is no data yet for a chart.</center>"; }?>
<br />
<table class="table-hover table table-striped">
    <thead>
      <tr>
        <th style="width:25%;">Product Name</th>
        <th style="width:25%;">Model</th>
        <th style="width:25%;">Quantity</th>
        <th style="width:25%;">Total</th>
      </tr>
    </thead>
<?php if ($products) { ?>
     <?php foreach ($products as $product) { ?>
          <tr>
            <td><?php echo $product['name']; ?></td>
            <td><?php echo $product['model']; ?></td>
            <td><?php echo $product['quantity']; ?></td>
            <td><?php echo $product['total']; ?></td>
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
  <div class="col-sm-6 text-right"><?php echo $results_products; ?></div>
</div>