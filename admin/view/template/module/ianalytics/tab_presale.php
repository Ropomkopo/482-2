<?php $searchvar = 'search'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked" id="preSaleTabs">
				<li><a href="#search-queries1" data-toggle="tab" data-chart="search_queries"><i class="fa fa-search"></i>&nbsp;&nbsp;Search Queries</a></li>
                <li><a href="#search-keywords" data-toggle="tab"><i class="fa fa-font"></i>&nbsp;&nbsp;Search Keywords</a></li>
                <li><a href="#most-searched-products" data-toggle="tab"><i class="fa fa-tags"></i>&nbsp;&nbsp;Most Searched Products</a></li>
                <li><a href="#opened-products" data-toggle="tab"><i class="fa fa-eye"></i>&nbsp;&nbsp;Opened Products</a></li>
                <li><a href="#added-to-cart" data-toggle="tab"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;Added to Cart Products</a></li>
                <li><a href="#added-to-wishlist" data-toggle="tab"><i class="fa fa-heart"></i>&nbsp;&nbsp;Added to Wishlist Products</a></li>
				<li><a href="#compared-products" data-toggle="tab"><i class="fa fa-random"></i>&nbsp;&nbsp;Compared Products</a></li>            
            </ul>
        </div>
        <div class="col-md-9">
			<div style="float:right;overflow:hidden;"><?php require('element_filter.php'); ?></div>
			<div class="tab-content">
                <div id="search-queries1" class="tab-pane fade">
                    <h3>Search Queries Graph</h3>
                    <div class="help">This graph depicts what part of your users' search queries has derived results</div>
                    <div class="iModuleFields">
						<br />
                        <div style="position: relative; padding-bottom: 30%; height: 0; overflow: hidden; max-width: 100%; height: auto;">
                            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                <canvas id="search_queries_canvas" style="max-width:100%; max-height:100%;"></canvas>
                            </div>
                        </div>
                        <script type="text/javascript">
                            iAnalytics.charts.search_queries = {
                                instance: null,
								name: 'search_queries',
								canvas: 'search_queries_canvas',	
								type: 'Line',
								data: {
									labels : [<?php foreach($iAnalyticsMonthlySearchesTable as $index => $day) { if ($index<1) { } else { ?> '<?php echo $day[0]?>', <?php } } ?>],
									datasets : [{
										label: "Successful Search Queries",
										fillColor : "rgba(1,159,215,0.2)",
										strokeColor : "rgba(1,159,215,1)",
										pointColor : "rgba(1,159,215,1)",
										pointStrokeColor : "#fff",
										pointHighlightFill : "#fff",
										pointHighlightStroke : "rgba(1,159,215,1)",
										data : [<?php foreach($iAnalyticsMonthlySearchesTable as $index => $day) { if ($index<1) { } else { ?> '<?php echo $day[2]?>', <?php } } ?>]
									},
									{
										label: "Zero-Results Search Queries",
										fillColor: "rgba(157,157,157,0.2)",
										strokeColor: "rgba(157,157,157,1)",
										pointColor: "rgba(157,157,157,1)",
										pointStrokeColor : "#fff",
										pointHighlightFill : "#fff",
										pointHighlightStroke: "rgba(151,187,205,1)",
										data : [<?php foreach($iAnalyticsMonthlySearchesTable as $index => $day) { if ($index<1) { } else { ?> '<?php echo $day[3]?>', <?php } } ?>]
									}]
								}
                            }
                        </script>
                        <div id="search_queries_legend"></div>
                        <br />
                        <h3>Search Queries in Numbers</h3>
                        <table class="table-hover table table-striped">
                            <?php foreach($iAnalyticsMonthlySearchesTable as $index => $day): ?>
							<?php if ($index<1) { ?>
                                <thead>
                                    <tr>
                                      <th><?php echo $day[0]?></th>
                                      <th><?php echo $day[1]?></th>
                                      <th><?php echo $day[2]?></th>
                                      <th><?php echo $day[3]?></th>
                                    </tr>
                                </thead>
                            <?php } else { ?>
                                <tr><td><?php echo $day[0]?></td><td><?php echo $day[1]?></td><td><?php echo $day[2]?></td><td><?php echo $day[3]?></td></tr>
                            <?php } ?>
                            <?php endforeach; ?>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                </div>
                
                <div id="search-keywords" class="tab-pane fade">
                    <div class="iModuleFields">
                        <h3>Keywords in Search - History</h3>
                        <div class="help">This table shows the search queries of your website users starting from the most recent.</div><br />
                        <table class="table-hover table table-striped">
                        <?php foreach($iAnalyticsKeywordSearchHistory as $index => $k): ?>
						<?php if ($index<1) { ?>
                            <thead>
                                <tr>
                                  <th><?php echo $k[0]?></th>
                                  <th><?php echo $k[1]?></th>
								  <th><?php echo $k[2]?></th>
                                  <th><?php echo $k[3]?></th>
                                  <th><?php echo $k[4]?></th>
                                  <th><?php echo $k[5]?></th>
                                  <th></th>
                                </tr>
                            </thead>
                        <?php } else { ?>
                            <tr><td><?php echo strlen($k[0]) > 30 ? substr($k[0], 0, 30) . '...' : $k[0];?></td><td><?php echo $k[1]?></td><td><?php echo $k[2]?></td><td><?php echo $k[3]?></td><td><?php echo $k[4]?></td><td><?php echo $k[5]?></td>
                            <td style="text-align:right;"><?php if ($index > 0) : ?><a class="btn btn-default" onclick="return confirm('Are you sure you wish to delete the record?');" href="index.php?route=module/ianalytics/deletesearchkeyword&token=<?php echo $token; ?>&searchValue=<?php echo $k[6]; ?>"><span class="glyphicon glyphicon-minus-sign"></span>&nbsp;Delete record</a>&nbsp;&nbsp;<a class="btn btn-default" onclick="return confirm('Are you sure you wish to delete all of the searches of this keyword?');" href="index.php?route=module/ianalytics/deleteallsearchkeyword&token=<?php echo $token; ?>&searchValue=<?php echo $k[0]; ?>"><span class="glyphicon glyphicon-remove"></span>&nbsp;Delete keyword</a><?php endif; ?></td>
                            </tr>
                            <?php } ?>
                        <?php endforeach; ?>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                </div>
                
                <div id="most-searched-products" class="tab-pane fade">
                    <h3>Most Searched Keywords</h3>
                    <div class="help">This indicates what your visitors search the most on your site using the OpenCart search engine</div>
                    <br />
                    <table class="table-hover table table-striped">
                        <?php foreach($iAnalyticsMostSearchedKeywords as $j => $k): ?>
						<?php if ($j<1) { ?>
                            <thead>
                                <tr>
                                  <th><?php echo $k[0]?></th>
                                  <th><?php echo $k[1]?></th>
                                  <th></th>
                                </tr>
                            </thead>
                        <?php } else { ?>
                            <tr><td><?php echo strlen($k[0]) > 30 ? substr($k[0], 0, 30) . '...' : $k[0];?></td><td><?php echo $k[1]?></td><td align="right"><?php if ($j > 0) {  ?><div><a href="../index.php?route=product/search&<?php echo $searchvar; ?>=<?php echo $k[0]?>" target="_blank" class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span>&nbsp; Preview</a></div><?php } ?></td></tr>
						<?php } ?>
                        <?php endforeach; ?>
                    </table>
                    <div class="iModuleFields">
                        <div class="clearfix"></div>
                    </div>
                 </div>
                 
                 <div id="opened-products" class="tab-pane fade">
					<h3>Opened Products</h3>
					<div class="help">This table shows the products your visitors viewed starting from the most viewed.</div>
                    <br />
					<table class="table-hover table table-striped">
					<?php foreach($iAnalyticsMostOpenedProducts as $j => $k): ?>
						<?php if ($j<1) { ?>
                            <thead>
                                <tr>
                                  <th><?php echo $k[0]?></th>
                                  <th><?php echo $k[1]?></th>
                                </tr>
                            </thead>
                        <?php } else { ?>
						<tr><td><?php echo $k[0]?></td><td><?php echo $k[1]?></td></tr>
						<?php } ?>
					<?php endforeach; ?>
					</table>
					<div class="clearfix"></div>
				</div>
                
                <div id="added-to-cart" class="tab-pane fade">
					<h3>Most Added to Cart Products</h3>
					<div class="help">This table shows the most added to cart products from your customers.</div>
                    <br />
					<table class="table-hover table table-striped">
					<?php foreach($iAnalyticsMostAddedtoCartProducts as $j => $k): ?>
						<?php if ($j<1) { ?>
                            <thead>
                                <tr>
                                  <th><?php echo $k[0]?></th>
                                  <th><?php echo $k[1]?></th>
                                </tr>
                            </thead>
                        <?php } else { ?>
						<tr><td><?php echo $k[0]?></td><td><?php echo $k[1]?></td></tr>
						<?php } ?>
					<?php endforeach; ?>
					</table>
					<div class="clearfix"></div>
				</div>
                
				<div id="added-to-wishlist" class="tab-pane fade">
					<h3>Most Added to Wishlist Products</h3>
					<div class="help">This table shows the most added to wishlist products from your customers.</div>
                    <br />
					<table class="table-hover table table-striped">
					<?php foreach($iAnalyticsMostAddedtoWishlistProducts as $j => $k): ?>
						<?php if ($j<1) { ?>
                            <thead>
                                <tr>
                                  <th><?php echo $k[0]?></th>
                                  <th><?php echo $k[1]?></th>
                                </tr>
                            </thead>
                        <?php } else { ?>
						<tr><td><?php echo $k[0]?></td><td><?php echo $k[1]?></td></tr>
						<?php } ?>
					<?php endforeach; ?>
					</table>
					<div class="clearfix"></div>
				</div>
                
                <div id="compared-products" class="tab-pane fade">
                    <h3>Compared Products</h3>
                    <div class="help">This table shows the products your visitors compared starting from the most compared.</div>
                    <br />
                    <table class="table-hover table table-striped">
						<?php foreach($iAnalyticsMostComparedProducts as $j => $k): ?>
							<?php if ($j<1) { ?>
                                <thead>
                                    <tr>
                                      <th><?php echo $k[0]?></th>
                                      <th><?php echo $k[1]?></th>
                                    </tr>
                                </thead>
                    		<?php } else { ?>
                      			<tr><td><?php echo $k[0]?></td><td><?php echo $k[1]?></td></tr>
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