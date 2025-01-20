<?php echo $header; ?>
<script>var iAnalyticsMinDate = '<?php echo $iAnalyticsMinDate; ?>'; var token = '<?php echo $token; ?>';</script>
<script>
var iAnalyticsColors = ['019FD7','9ECC3C','FFDB1A','CC3C3C','9D9D9D','FF9900','242858'];
iAnalytics = {
	charts: new Object()	
};
Chart.defaults.global.responsive = true;
Chart.defaults.global.animationSteps = 30;
</script>
<script type="text/javascript" src="view/javascript/ianalytics/ianalytics.js"></script>
<?php echo $column_left; ?>
<div id="content" class="iAnalytics">
 <div class="page-header">
    <div class="container-fluid">
      <h1><i class="fa fa-bar-chart-o"></i>&nbsp;<?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
	<?php echo (empty($moduleData['LicensedOn'])) ? base64_decode('ICAgIDxkaXYgY2xhc3M9ImFsZXJ0IGFsZXJ0LWRhbmdlciBmYWRlIGluIj4NCiAgICAgICAgPGJ1dHRvbiB0eXBlPSJidXR0b24iIGNsYXNzPSJjbG9zZSIgZGF0YS1kaXNtaXNzPSJhbGVydCIgYXJpYS1oaWRkZW49InRydWUiPsOXPC9idXR0b24+DQogICAgICAgIDxoND5XYXJuaW5nISBVbmxpY2Vuc2VkIHZlcnNpb24gb2YgdGhlIG1vZHVsZSE8L2g0Pg0KICAgICAgICA8cD5Zb3UgYXJlIHJ1bm5pbmcgYW4gdW5saWNlbnNlZCB2ZXJzaW9uIG9mIHRoaXMgbW9kdWxlISBZb3UgbmVlZCB0byBlbnRlciB5b3VyIGxpY2Vuc2UgY29kZSB0byBlbnN1cmUgcHJvcGVyIGZ1bmN0aW9uaW5nLCBhY2Nlc3MgdG8gc3VwcG9ydCBhbmQgdXBkYXRlcy48L3A+PGRpdiBzdHlsZT0iaGVpZ2h0OjVweDsiPjwvZGl2Pg0KICAgICAgICA8YSBjbGFzcz0iYnRuIGJ0bi1kYW5nZXIiIGhyZWY9ImphdmFzY3JpcHQ6dm9pZCgwKSIgb25jbGljaz0iJCgnYVtocmVmPSNpc2Vuc2Vfc3VwcG9ydF0nKS50cmlnZ2VyKCdjbGljaycpIj5FbnRlciB5b3VyIGxpY2Vuc2UgY29kZTwvYT4NCiAgICA8L2Rpdj4=') : '' ?>
	<?php if ($error_warning) { ?>
		<div class="alert alert-danger autoSlideUp"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	<?php } ?>
    <?php if ($success) { ?>
        <div class="alert alert-success autoSlideUp"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <script>$('.autoSlideUp').delay(3000).fadeOut(600, function(){ $(this).show().css({'visibility':'hidden'}); }).slideUp(600);</script>
    <?php } ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>&nbsp;<span style="vertical-align:middle;font-weight:bold;">Module settings</span></h3>
        </div>
        <div class="panel-body">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form"> 
				<input type="hidden" name="<?php echo $moduleNameSmall; ?>_status" value="1" />
                <div class="tabbable">
                    <div class="tab-navigation form-inline">
                        <ul class="nav nav-tabs mainMenuTabs" id="mainTabs">
                            <li><a href="#dashboard1" data-toggle="tab"><i class="fa fa-tachometer"></i>&nbsp;Dashboard</a></li>
                            <li><a href="#presale" data-toggle="tab" data-chart="search_queries"><i class="fa fa-inbox"></i>&nbsp;Pre-Sale</a></li>
                            <li><a href="#aftersale" data-toggle="tab"><i class="fa fa-sort-amount-desc"></i>&nbsp;After-Sale</a></li>
                            <li><a href="#visitors" data-toggle="tab"><i class="fa fa-users"></i>&nbsp;Visitors</a></li>
                            <li><a href="#controlpanel" data-toggle="tab"><i class="fa fa-power-off"></i>&nbsp;Settings</a></li>
                            <li><a href="#isense_support" data-toggle="tab"><i class="fa fa-external-link"></i>&nbsp;Support</a></li> 
                        </ul>
                        <div class="tab-buttons">
                            <div class="btn-group">
                                <button type="button" onClick="javascript:void(0)" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                    <span class="glyphicon glyphicon-th-list"></span>&nbsp;&nbsp;Data&nbsp; <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <?php if ((isset($ianalyticsStatus["ianalyticsStatus"]) && $ianalyticsStatus["ianalyticsStatus"] == 'run')){ ?>
                                    <li><a href="javascript:void(0)" onclick="document.location='index.php?route=module/ianalytics/pausegatheringdata&token=<?php echo $_GET['token']; ?>'"><span class="glyphicon glyphicon-pause"></span>&nbsp;Pause Gathering Data</a></li>
                                    <?php } else { ?>
                                    <li><a href="javascript:void(0)" onclick="document.location='index.php?route=module/ianalytics/resumegatheringdata&token=<?php echo $_GET['token']; ?>'"><span class="glyphicon glyphicon-play"></span>&nbsp;Resume Gathering Data</a></li>
                                    <?php } ?>
                                    <li class="divider"></li>
                                    <li><a onclick="return confirm('Are you sure you wish to delete all analytics data?');" href="index.php?route=module/ianalytics/deleteanalyticsdata&token=<?php echo $token; ?>"><span class="glyphicon glyphicon-trash"></span>&nbsp;Clear All Analytics Data</a></li>
                                </ul>
                            </div>
                            <button type="submit" class="btn btn-success save-changes"><i class="fa fa-check"></i>&nbsp;Save Changes</button>
                            <a onclick="location = '<?php echo $cancel; ?>'" class="btn btn-warning"><i class="fa fa-times"></i>&nbsp;Cancel</a>
                        </div> 
                    </div><!-- /.tab-navigation --> 
                    <div class="tab-content">
                    	<?php
                        if (!function_exists('modification_vqmod')) {
                        	function modification_vqmod($file) {
                        		if (class_exists('VQMod')) {
                       				return VQMod::modCheck(modification($file), $file);
                        		} else {
                        			return modification($file);
                       			}
                        	}
                        }
						?>
                        <div id="dashboard1" class="tab-pane fade">
                          <?php require_once modification_vqmod(DIR_APPLICATION.'view/template/module/'.$moduleNameSmall.'/tab_dashboard.php'); ?>                        
                        </div>
                        <div id="presale" class="tab-pane fade">
                          <?php require_once modification_vqmod(DIR_APPLICATION.'view/template/module/'.$moduleNameSmall.'/tab_presale.php'); ?>                        
                        </div>
                        <div id="aftersale" class="tab-pane fade">
                          <?php require_once modification_vqmod(DIR_APPLICATION.'view/template/module/'.$moduleNameSmall.'/tab_aftersale.php'); ?>                        
                        </div>
                        <div id="visitors" class="tab-pane fade">
                          <?php require_once modification_vqmod(DIR_APPLICATION.'view/template/module/'.$moduleNameSmall.'/tab_visitors.php'); ?>                        
                        </div>
                        <div id="controlpanel" class="tab-pane fade">
                          <?php require_once modification_vqmod(DIR_APPLICATION.'view/template/module/'.$moduleNameSmall.'/tab_controlpanel.php'); ?>                        
                        </div>
                        <div id="isense_support" class="tab-pane fade">
                          <?php require_once modification_vqmod(DIR_APPLICATION.'view/template/module/'.$moduleNameSmall.'/tab_support.php'); ?>                        
                        </div>
                    </div> <!-- /.tab-content --> 
                </div><!-- /.tabbable -->
            </form>
        </div> 
    </div>
  </div>
</div>
<script type="text/javascript">
function showHideStuff($typeSelector, $toggleArea, $selectStatus) {
	if ($typeSelector.val() === $selectStatus) {
		$toggleArea.show(); 
	} else {
		$toggleArea.hide(); 
	}
    $typeSelector.change(function(){
        if ($typeSelector.val() === $selectStatus) {
            $toggleArea.show(300); 
        }
        else {
            $toggleArea.hide(300); 
        }
    });
}

$(function() {
	showHideStuff($('#GA_ecommerce'), $('.custom_settings'), 'yes');
});
</script>
<?php echo $footer; ?>