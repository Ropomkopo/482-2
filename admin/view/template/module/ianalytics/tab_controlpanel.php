<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <h5><span class="required">* </span><strong>Module status:</strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i> Enable or disable the module.</span>
        </div>
        <div class="col-md-4">
            <select id="Checker" name="<?php echo $moduleName; ?>[Enabled]" class="form-control">
                <option value="yes" <?php echo (!empty($moduleData['Enabled']) && $moduleData['Enabled'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
                <option value="no"  <?php echo (empty($moduleData['Enabled']) || $moduleData['Enabled']== 'no') ? 'selected=selected' : '' ?>>Disabled</option>
            </select>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-3">
            <h5><strong>Collect After-Sale data:</strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i> Collect after-sale data about the customers</span>
        </div>
        <div class="col-md-4">
            <select name="<?php echo $moduleName; ?>[AfterSaleData]" class="form-control">
                <option value="yes" <?php echo (!empty($moduleData['AfterSaleData']) && $moduleData['AfterSaleData'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
                <option value="no"  <?php echo (empty($moduleData['AfterSaleData']) || $moduleData['AfterSaleData']== 'no') ? 'selected=selected' : '' ?>>Disabled</option>
            </select>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-3">
            <h5><strong>Google Analytics e-commerce tracking:</strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i> Send information to Google Analytics for your order transactions. NOTE: You have to enable the e-commerce tracking in your account.</span>
        </div>
        <div class="col-md-4">
            <select name="<?php echo $moduleName; ?>[GoogleAnalytics]" id="GA_ecommerce" class="form-control">
                <option value="yes" <?php echo (!empty($moduleData['GoogleAnalytics']) && $moduleData['GoogleAnalytics'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
                <option value="no"  <?php echo (empty($moduleData['GoogleAnalytics']) || $moduleData['GoogleAnalytics']== 'no') ? 'selected=selected' : '' ?>>Disabled</option>
            </select>
        </div>
    </div>
    <div class="custom_settings">
   		<hr />
    </div>
    <div class="row custom_settings">
        <div class="col-md-3">
            <h5><strong>Google Account ID Number:</strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i> UA-XXXXXXX-XX variable from your Google Analytics account.</span>
        </div>
        <div class="col-md-4">
            <div class="form-group">
          	  <input type="text" class="form-control" placeholder="UA-XXXXXXX-XX" name="<?php echo $moduleName; ?>[GoogleAnalyticsIDNumber]"  id="moduleGA_id" value="<?php echo !empty($moduleData['GoogleAnalyticsIDNumber']) ? $moduleData['GoogleAnalyticsIDNumber'] : ''?>">
            </div>
        </div>
        <div class="col-md-4">
			<script language="javascript" type="text/javascript">
				function popitup(url) {
					newwindow=window.open(url,'name','height=750,width=950,toolbar=no,menubar=no,scrollbars=no,location=no,directories=no');
					if (window.focus) { newwindow.focus(); }
					return false;
				}
            </script>
            <a class="btn btn-primary" onclick="return popitup('https://www.google.com/analytics/web/#report/conversions-ecommerce-overview/')">Open Google eCommerce Tracking</a>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-3">
            <h5><strong>Clear analytics data:</strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i> Removes all recorded data from the module.</span>
        </div>
        <div class="col-md-4">
       		<a class="btn btn-default" onclick="return confirm('Are you sure you wish to delete all analytics data?');" href="index.php?route=module/ianalytics/deleteanalyticsdata&token=<?php echo $token; ?>"><span class="glyphicon glyphicon-trash"></span>&nbsp; Clear All Analytics Data</a>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-3">
            <h5><strong>Blacklisted IP's:</strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i> These are the IP addresses whose analytics data will not be listed. Keep in mind that data from these IP addresses will still be logged in the database. Type in one IP address per line.</span>
        </div>
        <div class="col-md-4">
        	<textarea style="width: 400px; height: 100px;" class="form-control" name="<?php echo $moduleName; ?>[BlacklistedIPs]"><?php echo !empty($moduleData['BlacklistedIPs']) ? $moduleData['BlacklistedIPs'] : ''; ?></textarea>
        </div>
    </div>
</div>