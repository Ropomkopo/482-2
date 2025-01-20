<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked" id="visitsTabs">
            	<li><a href="#daily-total-stats_unique" data-toggle="tab" data-chart="daily_visitors"><i class="fa fa-users"></i>&nbsp;&nbsp;Daily Unique Visitors</a></li>
           		<li><a href="#visitors-by-part-of-a-day" data-toggle="tab" data-chart="part_of_the_day"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;Visitors by Part of the day</a></li>
                <li><a href="#referer-stats" data-toggle="tab" data-chart="referer_stats"><i class="fa fa-external-link"></i>&nbsp;&nbsp;Referer Stats</a></li>
            </ul>
        </div>
        <div class="col-md-9">
			<div style="float:right;overflow:hidden;"><?php require('element_filter.php'); ?></div>
			<div class="tab-content">
          		<div id="daily-total-stats_unique" class="tab-pane fade">
                    <h3>Daily Unique Visitors</h3>
                    <div class="help">This graph shows the total statistics day by day.</div>
                    <?php if (!($iAnalyticsVisitorsDataByDay[0]=="No Data Gathered Yet")) { ?>
                    	<br />
                        <div style="position: relative; padding-bottom: 30%; height: 0; overflow: hidden; max-width: 100%; height: auto;">
                            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                <canvas id="daily_visitors_canvas" style="max-width:100%; max-height:100%;"></canvas>
                            </div>
                        </div>
                        <script type="text/javascript">
                            iAnalytics.charts.daily_visitors = {
                                instance: null,
								name: 'daily_visitors',
								canvas: 'daily_visitors_canvas',	
								type: 'Line',
								data: {
									labels : [<?php foreach($iAnalyticsVisitorsDataByDay as $j => $k) { if ($j<1) { } else { ?> '<?php echo $k[0]?>', <?php } } ?>],
									datasets : [{
										label: "Daily Unique Visitors",
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
                    	<br />
                        <table class="table-hover table table-striped">
                        <?php $iAnalyticsVisitorsDataByDay = array_reverse($iAnalyticsVisitorsDataByDay); foreach($iAnalyticsVisitorsDataByDay as $j => $k): ?>
                            <?php if ($j<sizeof($iAnalyticsVisitorsDataByDay)-1) { ?>
                                <tr>
                                     <td><?php echo $k[0]?></td>
                                     <td><?php echo $k[1]?></td>
                                     <td><?php echo $k[2]?></td>
                                     <td><?php echo $k[3]?></td>
                           		</tr> 
                            <?php } else { ?>
                            	<thead>
                                    <tr>
                                      <th><?php echo $k[0]?></th>
                                      <th><?php echo $k[1]?></th>
                                      <th><?php echo $k[2]?></th>
                                      <th><?php echo $k[3]?></th>
                                    </tr>
                                </thead>
                            <?php } ?>
                        <?php endforeach;?>
                        </table>
					<div class="clearfix"></div>
				</div>
                
				<div id="visitors-by-part-of-a-day" class="tab-pane fade">
                    <h3>Visitors by Parts of the Day</h3>
                    <div class="help">This graph shows the total statistics by the parts of the day.</div>                 
                   	<?php if (!($iAnalyticsVisitorsData[0] == "No Data Gathered Yet")) { ?>
						<br />
                        <div style="position: relative; padding-bottom: 30%; height: 0; overflow: hidden; max-width: 100%; height: auto;">
                            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                <canvas id="part_of_the_day_canvas" style="max-width:100%; max-height:100%;"></canvas>
                            </div>
                        </div>
                        <script type="text/javascript">
                            iAnalytics.charts.part_of_the_day = {
								instance: null,
								name: 'part_of_the_day',
								canvas: 'part_of_the_day_canvas',	
								type: 'Line',
								data: {
									labels : [<?php foreach($iAnalyticsVisitorsData as $j => $k) { if ($j<1) { } else { ?> '<?php if ($k[0]==0) echo "Midnight"; else if ($k[0]==1) echo "Morning"; else if ($k[0]==2) echo "Noon"; else if ($k[0]==3) echo "Evening"; ?>', <?php } } ?>],
									datasets : [{
										label: "Visitors by Part of the Day",
										fillColor : "rgba(1,159,215,0.2)",
										strokeColor : "rgba(1,159,215,1)",
										pointColor : "rgba(1,159,215,1)",
										pointStrokeColor : "#fff",
										pointHighlightFill : "#fff",
										pointHighlightStroke : "rgba(1,159,215,1)",
										data : [<?php foreach($iAnalyticsVisitorsData as $j => $k) { if ($j<1) { } else { ?> '<?php echo $k[1]?>', <?php } } ?>]
									}]
								}
							}
                        </script>
                    <?php } else { echo "<center>There is no data yet for a chart.</center>"; }?>
                    	<br />
                        <table class="table-hover table table-striped">
                        <?php foreach($iAnalyticsVisitorsData as $j => $k): ?>
                            <?php if ($j<1) { ?>
                                <thead>
                                    <tr>
                                      <th><?php echo $k[0]?></th>
                                      <th><?php echo $k[1]?></th>
                                      <th><?php echo $k[2]?></th>
                                      <th><?php echo $k[3]?></th>
                                    </tr>
                                </thead>
                            <?php } else { ?>
                            <tr>
                                <td><?php
                                  if ($k[0]==0) echo "Midnight";
                                  else if ($k[0]==1) echo "Morning"; 
                                  else if ($k[0]==2) echo "Noon"; 
                                  else if ($k[0]==3) echo "Evening"; 
                                  ?></td>
                                 <td><?php echo $k[1]?></td>
                                 <td><?php echo $k[2]?></td>
                                 <td><?php echo $k[3]?></td>
                            </tr>
                            <?php } ?>
                        <?php endforeach; ?>
                        </table>
					<div class="clearfix"></div>
				</div>
                
                <div id="referer-stats" class="tab-pane fade">
                    <h3>Referer statistics</h3>
                    <div class="help">This graph shows from where the customers come to your store.</div>
                    <?php if (!($iAnalyticsVisitorsDataReferers[0]=="No Data Gathered Yet")) { ?>
                    	<br />
                        <div style="position: relative; padding-bottom: 30%; height: 0; overflow: hidden; max-width: 100%; height: auto;">
                            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                <canvas id="referer_stats_canvas" style="max-width:100%; max-height:100%;"></canvas>
                            </div>
                        </div>
                        <script type="text/javascript">
                            iAnalytics.charts.referer_stats = {
								instance: null,
								name: 'referer_stats',
								canvas: 'referer_stats_canvas',	
								type: 'Pie',
								data: [
								<?php foreach($iAnalyticsVisitorsDataReferersPie as $j => $k) { if ($j<1) {  } else { ?>
									{
										value: <?php echo $k[0]?>,
										color:"#019FD7",
										highlight: "#017FD5",
										label: "Direct hits"
									},
									{
										value: <?php echo $k[1]?>,
										color:"#9ECC3C",
										highlight: "#9ECC3A",
										label: "Social networks"
									},
									{
										value: <?php echo $k[2]?>,
										color:"#FFDB1A",
										highlight: "#FFCB18",
										label: "Search engines"
									},
									{
										value: <?php echo $k[3]?>,
										color:"#9D9D9D",
										highlight: "#9D7D9D",
										label: "Other"
									}
								<?php } } ?>
								]
							}
                        </script>
                        <div id="referer_stats_legend"></div>
                    <?php } else { echo "<center>There is no data yet for a chart.</center>"; }?>
                    	<br />
                        <table class="table-hover table table-striped">
                        <?php foreach($iAnalyticsVisitorsDataReferers as $j => $k): ?>
                            <?php if ($j<1) { ?>
                                <thead>
                                    <tr>
                                      <th><?php echo $k[0]?></th>
                                      <th><?php echo $k[1]?></th>
                                      <th><?php echo $k[2]?></th>
                                      <th><?php echo $k[3]?></th>
                                      <th><?php echo $k[4]?></th>
                                    </tr>
                                </thead>
                            <?php } else { ?>
                            <tr>
                                 <td><?php echo $k[0]?></td>
                                 <td><?php echo $k[1]?></td>
                                 <td><?php echo $k[2]?></td>
                                 <td><?php echo $k[3]?></td>
                                 <td><?php echo $k[4]?></td>
                            </tr>
                            <?php } ?>
                        <?php endforeach; ?>
                        </table>
					<div class="clearfix"></div>
				</div>
			</div>
        </div>
    </div>
    <hr />
</div>