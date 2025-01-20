<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked" id="afterSaleTabs">               
				<li><a href="#customer-funnel" data-toggle="tab"><i class="fa fa-filter"></i>&nbsp;&nbsp;Customers Funnel</a></li>
                <li><a href="#sales-report" data-toggle="tab" data-chart="sales_report"><i class="fa fa-money"></i>&nbsp;&nbsp;Sales Report</a></li>
                <li><a href="#ordered-products" data-toggle="tab" data-chart="products_report"><i class="fa fa-download"></i>&nbsp;&nbsp;Most Ordered Products</a></li>
                <li><a href="#customer-orders" data-toggle="tab" data-chart="customers_report"><i class="fa fa-users"></i>&nbsp;&nbsp;Customer Orders</a></li>           
            </ul>
        </div>
        <div class="col-md-9">
			<div class="tab-content">
                <div id="customer-funnel" class="tab-pane fade">
					<div style="float:right;overflow:hidden;"><?php require('element_filter.php'); ?></div>
					<h3>Customers Funnel</h3>
					<div class="help">This chart shows the flow of your customers in the process of placing an order.</div>
                    <br />
                    <div class="row">
                      <div class="col-md-8">
                      	<center><div id="funnel"></div></center>
                        <?php if (isset($iAnalyticsFunnelData[2][0])) { ?>
							<?php $stage[0]=0; $stage[1]=0; $stage[2]=0; $stage[3]=0; $stage[4]=0; $stage[5]=0; $stage[6]=0; ?>
                            <?php foreach($iAnalyticsFunnelData as $j => $k): 
                                    if ($j<1) { 
                                    } else { 
                                          if ($k[0]==0) $stage[0]=$k[1];
                                          else if ($k[0]==1) $stage[1]=$k[1];
                                          else if ($k[0]==2) $stage[2]=$k[1];
                                          else if ($k[0]==3) $stage[3]=$k[1];
                                          else if ($k[0]==4) $stage[4]=$k[1]; 
                                          else if ($k[0]==5) $stage[5]=$k[1]; 
                                          else if ($k[0]==6) $stage[6]=$k[1];
                                    } 
                                endforeach; ?>
                            <script type="text/javascript">
                                var funnelData = [
                                    ['First Visit', <?php echo $stage[0]; ?>],
                                    ['Add to Cart', <?php echo $stage[1] ?>], 
                                    ['Login/Register', <?php echo $stage[2] ?>], 
                                    ['Delivery Method', <?php echo $stage[3] ?>], 
                                    ['Payment method', <?php echo $stage[4] ?>], 
                                    ['Confirm order', <?php echo $stage[5] ?>],  
                                    ['Successful order', <?php echo $stage[6] ?>]];
                                var chart = new FunnelChart(funnelData, 480, 500, 1/3);
                                chart.draw('#funnel', 2.5);
                            </script>
                         <?php } else {
							echo '<center>There is no data yet for a chart.</center>'; } ?>
                      	</div>
                      <div class="col-md-4">
                      	<div class="panel panel-info">
                        	<div class="panel-heading">
                            	<?php $var = 0; $min = 0; $max = 0;
								if (isset($iAnalyticsFunnelData) && sizeof($iAnalyticsFunnelData)>1) 									
								{
									foreach ($iAnalyticsFunnelData as $fData) {
										if ($fData[0] == 0)	$min = $fData[1];
										else if ($fData[0] == 6) $max = $fData[1];							
									}
									if ($min>0 && $max>0) {
										$var = ($max/$min)*(100); $var = number_format($var, 2);
									}
								}
								?>
                            	<h3 style="margin-top:10px;"><i class="fa fa-retweet"></i>&nbsp;<strong>Conversion rate: <span id="rate"><?php echo ($var>0) ? $var.'%' : 'N/A'; ?></span></strong></h3>
                                
                            </div>
                    		<div class="panel-body">
								<h6>Conversion rate based on:</h6>
                              	<div class="row">
                                    <div class="col-xs-5">
                                        <select id="firstConversion" class="form-control">
                                          <option value="0">First Visit</option>
                                          <option value="1">Add to Cart</option>
                                          <option value="2">Login/Register</option>
                                          <option value="3">Delivery Method</option>
                                          <option value="4">Payment method</option>
                                          <option value="5">Confirm order</option>
                                          <option value="6">Successful order</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-2" style="text-align:center;">
                                    	<p style="font-weight:700;padding-top:6px;font-size:15px;">vs.</p>
                                    </div>
                                    <div class="col-xs-5" style="padding-left:0">
                                        <select id="secondConversion" class="form-control">
                                          <option value="0">First Visit</option>
                                          <option value="1">Add to Cart</option>
                                          <option value="2">Login/Register</option>
                                          <option value="3">Delivery Method</option>
                                          <option value="4">Payment method</option>
                                          <option value="5">Confirm order</option>
                                          <option value="6" selected='selected'>Successful order</option>
                                        </select>
                                    </div>
								</div>
                            </div>
                        </div>
							<script>
							$(function() {
							  $("#firstConversion, #secondConversion").change(function() {
	var result = parseFloat(parseInt($('#'+$('#secondConversion').val()).text()) * 100) / parseInt($('#'+$('#firstConversion').val()).text()).toFixed(2);
								$('#rate').text(result.toFixed(2) + '%');
							  })
							});
                            </script>
                      	<table class="table-hover table table-striped">
						<?php foreach($iAnalyticsFunnelData as $j => $k): ?>
                            <?php if ($j<1) { ?>
                                <thead>
                                    <tr>
                                      <th><?php echo $k[0]?></th>
                                      <th><?php echo $k[1]?></th>
                                    </tr>
                                </thead>
                            <?php } else { ?>
                            <tr>
                                <td><?php
                                  if ($k[0]==0) echo "First Visit";
                                  else if ($k[0]==1) echo "Add to Cart"; 
                                  else if ($k[0]==2) echo "Login/Register"; 
                                  else if ($k[0]==3) echo "Delivery Method"; 
                                  else if ($k[0]==4) echo "Payment method"; 
                                  else if ($k[0]==5) echo "Confirm order"; 
                                  else if ($k[0]==6) echo "Successful order"; 
                                  ?></td>
                                 <td><?php
                                  	   if ($k[0]==0) echo "<div id='".$k[0]."'>".$k[1]."</div>";
                                  else if ($k[0]==1) echo "<span id='".$k[0]."'>".$k[1]."</span>";
                                  else if ($k[0]==2) echo "<span id='".$k[0]."'>".$k[1]."</span>";
                                  else if ($k[0]==3) echo "<span id='".$k[0]."'>".$k[1]."</span>"; 
                                  else if ($k[0]==4) echo "<span id='".$k[0]."'>".$k[1]."</span>";
                                  else if ($k[0]==5) echo "<span id='".$k[0]."'>".$k[1]."</span>";
                                  else if ($k[0]==6) echo "<span id='".$k[0]."'>".$k[1]."</span>";
                                  ?></td>
                            </tr>
                            <?php } ?>
                        <?php endforeach; ?>
                        </table>
                        
                      </div>
                    </div>					
					<div class="clearfix"></div>
				</div>
				<div id="sales-report" class="tab-pane fade">
					<div style="float:right;overflow:hidden;"><?php require('report_product_purchased_filter.php'); ?></div>
					<h3>Sales</h3>
                    <div class="help">This table shows the sales day by day.</div>
                    <br />
                  	<?php require_once(DIR_APPLICATION.'view/template/module/ianalytics/report_sales.php'); ?>   
					<div class="clearfix"></div>
				</div>
				<div id="ordered-products" class="tab-pane fade">
					<div style="float:right;overflow:hidden;"><?php require('report_product_purchased_filter.php'); ?></div>
					<h3>Products</h3>
                    <div class="help">This table shows the most ordered products and the revenue from them.</div>
                    <br />
                  	<?php require_once(DIR_APPLICATION.'view/template/module/ianalytics/report_product_purchased.php'); ?>   
					<div class="clearfix"></div>
				</div>
                <div id="customer-orders" class="tab-pane fade">
					<div style="float:right;overflow:hidden;"><?php require('report_product_purchased_filter.php'); ?></div>
					<h3>Customers</h3>
                    <div class="help">This table shows the customers with orders.</div>
                    <br />
                  	<?php require_once(DIR_APPLICATION.'view/template/module/ianalytics/report_customer_orders.php'); ?>   
					<div class="clearfix"></div>
				</div>
			</div>
        </div>
    </div>
</div>