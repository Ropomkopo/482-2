<div class="container-fluid">
    <div class="row">
       	<div class="col-md-12">
        	<div style="float:right;overflow:hidden;"><?php require('element_filter.php'); ?></div>
            <h3>Dashboard</h3>
        </div>
    </div>
    <br />
    <div class="row">
    	<div class="col-md-8">
            <div class="row">
                <div class="col-md-8">
                    <h4>Daily Visitors<div style="float:right;"><a href="#daily-total-stats-more" data-toggle="tab" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-th-list"></span>&nbsp; More</a></div></h4>
                    <br />
                    <div class="thumbnail">
                        <?php if (!($iAnalyticsVisitorsDataByDay[0]=="No Data Gathered Yet")) { ?>
                            <br />
                            <div style="position: relative; padding-bottom: 38.5%; height: 0; overflow: hidden; max-width: 100%; height: auto;">
                                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                    <canvas id="dashboard_visitors_canvas" style="max-width:100%; max-height:100%;"></canvas>
                                </div>
                            </div>
                            <script type="text/javascript">
                                iAnalytics.charts.dashboard_visitors = {
                                    instance: null,
                                    name: 'dashboard_visitors',
                                    canvas: 'dashboard_visitors_canvas',	
                                    type: 'Line',
                                    data: {
                                        labels : [<?php foreach($iAnalyticsVisitorsDataByDay as $j => $k) { if ($j<1) { } else { ?> '<?php echo $k[0]?>', <?php } } ?>],
                                        datasets : [{
                                            label: "Daily Visitors",
                                            fillColor : "rgba(1,159,215,0.2)",
                                            strokeColor : "rgba(1,159,215,1)",
                                            pointColor : "rgba(1,159,215,1)",
                                            pointStrokeColor : "#fff",
                                            pointHighlightFill : "#fff",
                                            pointHighlightStroke : "rgba(1,159,215,1)",
                                            data : [<?php foreach($iAnalyticsVisitorsDataByDay as $j => $k) { if ($j<1) { } else { ?> '<?php echo $k[1]?>', <?php } } ?>]
                                        }]
                                    }
                                }
                            </script>
                        <?php } else { echo "<center>There is no data yet for a chart.</center>"; } ?>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <h4>Traffic Sources<div style="float:right;"><a href="#traffic-sources-more" data-toggle="tab" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-th-list"></span>&nbsp; More</a></div></h4>
                    <br />
                    <div class="thumbnail">
						<?php if (!($iAnalyticsVisitorsDataReferers[0]=="No Data Gathered Yet")) { ?>
                            <br />
                            <div style="position: relative; padding-bottom: 64%; height: 0; overflow: hidden; max-width: 100%; height: auto;">
                                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                    <canvas id="dashboard_referers_canvas" style="max-width:100%; max-height:100%;"></canvas>
                                </div>
                            </div>
                            <script type="text/javascript">
                                iAnalytics.charts.dashboard_referers = {
                                    instance: null,
                                    name: 'dashboard_referers',
                                    canvas: 'dashboard_referers_canvas',	
                                    type: 'Pie',
                                    data: [
                                    <?php foreach($iAnalyticsVisitorsDataReferersPie as $j => $k) { if ($j<1) {  } else { ?>
                                        {
                                            value: <?php echo $k[0]?>,
                                            color:"#019FD7",
                                            highlight: "#019FD7",
                                            label: "Direct hits"
                                        },
                                        {
                                            value: <?php echo $k[1]?>,
                                            color:"#9ECC3C",
                                            highlight: "#9ECC3C",
                                            label: "Social networks"
                                        },
                                        {
                                            value: <?php echo $k[2]?>,
                                            color:"#FFDB1A",
                                            highlight: "#FFDB1A",
                                            label: "Search engines"
                                        },
                                        {
                                            value: <?php echo $k[3]?>,
                                            color:"#9D9D9D",
                                            highlight: "#9D9D9D",
                                            label: "Other"
                                        }
                                    <?php } } ?>
                                    ]
                                }
                            </script>
                            <div id="dashboard_referers_legend"></div>
                        <?php } else { echo "<center>There is no data yet for a chart.</center>"; }?>
                    </div>
                </div>
            </div>
           	<div class="row">
            	<div class="col-md-6">
                	<h4>Sales<div style="float:right;"><a href="#sales-report-more" data-toggle="tab" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-th-list"></span>&nbsp; More</a></div></h4>
                    <br />
                    <div class="thumbnail">
						<?php 
						if (isset($_GET['fromDate'])) { $filter_d_start = $_GET['fromDate']; } else { $filter_d_start = ''; }
						if (isset($_GET['toDate'])) { $filter_d_end = $_GET['toDate']; } else { $filter_d_end = ''; }
						if (isset($_GET['filterOrders'])) { $filter_order_st_id = $_GET['filterOrders']; } else { $filter_order_st_id = 0; }
						$filter_gr = 'day';
						$pag = 1;
						$ordersDashboard = array();
						
						$ordersDashboardfilter = array(
							'filter_date_start'	     => $filter_d_start, 
							'filter_date_end'	     => $filter_d_end, 
							'filter_group'           => $filter_gr,
							'filter_order_status_id' => $filter_order_st_id,
							'start'                  => ($pag - 1) * $limit,
							'limit'                  => $limit
						);
						
						$resultsOrders = $model_module_ianalitycs->getOrders($ordersDashboardfilter);
						foreach ($resultsOrders as $result) {
							$ordersDashboard[] = array(
								'date_start' 		=> date($language->get('date_format_short'), strtotime($result['date_start'])),
								'date_end'   		=> date($language->get('date_format_short'), strtotime($result['date_end'])),
								'orders'     		=> $result['orders'],
								'tax'       		=> $currency_lib->format($result['tax'], $currency),
								'tax_nocurrency'    => isset($result['tax']) ? $result['tax'] : '0',
								'total'      		=> $currency_lib->format($result['total'], $currency),
								'total_nocurrency'	=> $result['total']
							);
						} 
						if (isset($ordersDashboard) && (!empty($ordersDashboard))) { ?>
                            <br />
                            <div style="position: relative; padding-bottom: 50%; height: 0; overflow: hidden; max-width: 100%; height: auto;">
                                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                    <canvas id="dashboard_sales_canvas" style="max-width:100%; max-height:100%;"></canvas>
                                </div>
                            </div>
                            <script type="text/javascript">
                                iAnalytics.charts.dashboard_sales = {
                                    instance: null,
                                    name: 'dashboard_sales',
                                    canvas: 'dashboard_sales_canvas',	
                                    type: 'Line',
                                    data: {
                                        <?php $reversedOrders = array_reverse($ordersDashboard, true); ?>
                                        labels : [<?php foreach ($reversedOrders as $order) { ?>'<?php echo $order['date_start']; ?>', <?php } ?>],
                                        datasets : [
										{
                                            label: "Total",
                                            fillColor: "rgba(180,180,180,0.2)",
                                            strokeColor: "rgba(180,180,180,1)",
                                            pointColor: "rgba(180,180,180,1)",
                                            pointStrokeColor : "#fff",
                                            pointHighlightFill : "#fff",
                                            pointHighlightStroke: "rgba(1,159,215,1)",
                                            data : [<?php foreach ($reversedOrders as $order) { echo $order['total_nocurrency']; ?>, <?php } ?>]
                                        },
                                        {
                                            label: "Revenue",
                                            fillColor: "rgba(158,204,60,0.2)",
                                            strokeColor: "rgba(158,204,60,1)",
                                            pointColor: "rgba(158,204,60,1)",
                                            pointStrokeColor: "#fff",
                                            pointHighlightFill: "#fff",
                                            pointHighlightStroke: "rgba(151,187,205,1)",
                                            data : [<?php foreach ($reversedOrders as $order) { echo $order['total_nocurrency']-$order['tax_nocurrency']; ?>, <?php } ?>]
                                        },
										{
                                            label: "Taxes",
                                            fillColor : "rgba(204,60,60,0.2)",
                                            strokeColor : "rgba(204,60,60,1)",
                                            pointColor : "rgba(204,60,60,1)",
                                            pointStrokeColor : "#fff",
                                            pointHighlightFill : "#fff",
                                            pointHighlightStroke : "rgba(204,60,60,1)",
                                            data : [<?php foreach ($reversedOrders as $order) { echo $order['tax_nocurrency']; ?>, <?php } ?>]
                                        },]
                                    }
                                }
                            </script>
                            <div id="dashboard_sales_legend"></div>
                        <?php } else { echo "<center>There is no data yet for a chart.</center>"; }?>
                    </div>                
                </div>
                <div class="col-md-6">
					<h4>Most Searched Keywords<div style="float:right;"><a href="#searched-keywords-more" data-toggle="tab" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-th-list"></span>&nbsp; More</a></div></h4>
                    <br />
                    <div class="thumbnail">
                    <?php if (!(isset($iAnalyticsMostSearchedKeywordsPie['No Data Gathered Yet']) && $iAnalyticsMostSearchedKeywordsPie['No Data Gathered Yet']=="No Data Gathered Yet")) { ?>
                    	<br />
                        <div style="position: relative; padding-bottom: 45%; height: 0; overflow: hidden; max-width: 100%; height: auto;">
                            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                <canvas id="dashboard_keywords_canvas" style="max-width:100%; max-height:100%;"></canvas>
                            </div>
                        </div>
                        <script type="text/javascript">
                            iAnalytics.charts.dashboard_keywords = {
                                instance: null,
                                name: 'dashboard_keywords',
                                canvas: 'dashboard_keywords_canvas',	
                                type: 'Pie',
                                data: [
								<?php $colorCount=0; foreach($iAnalyticsMostSearchedKeywordsPie as $j => $k) { ?>
									{
                                        value: <?php echo $k?>,
										color: "#"+iAnalyticsColors[<?php echo $colorCount; ?>],
										highlight: "#"+iAnalyticsColors[<?php echo $colorCount; ?>],
                                        label: "<?php echo $j?>"
                                    },
								<?php $colorCount++; } ?>
                                ]
                            }
                        </script>
                        <div id="dashboard_keywords_legend"></div>
                    <?php } else { echo "<center>There is no data yet for a chart.</center>"; }?>
                    </div>
                </div>            
            </div>
        </div>
        <div class="col-md-4">          
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
            <h4>Conversion Rate: <?php echo ($var>0) ? $var.'%' : 'N/A'; ?><div style="float:right;"><a href="#conversion-rate-more" data-toggle="tab" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-th-list"></span>&nbsp; More</a></div></h4>
            <br />
			<div class="thumbnail">
                <center><div id="funnelDashboard"></div></center>
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
                        	var chart = new FunnelChart(funnelData, 350, 585, 1/3);
                        	chart.draw('#funnelDashboard', 2);
                        </script>
                <?php } else {
                	echo '<center>There is no data yet for a chart.</center>';
				} ?>
        	</div>
        </div>
    </div>
</div>