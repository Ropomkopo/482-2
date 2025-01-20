<?php  
class ControllerModuleIanalytics extends Controller {
	public function index() {
		$this->language->load('module/ianalytics');

      	$data['heading_title'] = $this->language->get('heading_title');
		$this->load->model('setting/setting');
		$ianalyticsStatus = $this->config->get('ianalyticsStatus');
		$ianalytics = $this->config->get('ianalytics');
		
		if (isset($ianalytics['Enabled']) && isset($ianalyticsStatus) && $ianalyticsStatus == 'run' && $ianalytics['Enabled'] == 'yes') {
			$this->trackSearch();
			$this->trackProducts();
			$this->trackComparedProducts();
		}
	}
	
	function trackSearch() {
		$flag=0;

		if(!empty($this->request->get['route'])) {
			if (strpos($this->request->get['route'],'product/search')!==false) {
				$flag = 1;
			}
		}
		
		if ($flag==1) {
			if(empty($this->request->get['search'])) {
				return;
			}
			
			$searchVal = $this->request->get['search'];
			
			$today = date("Y-m-d"); 
			$time = date("H:i:s"); 
			$FromIP = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '';
			$SpokenLanguages = (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
			$ResultsFound = $this->getSearchTotalResults($searchVal);
			
			$data = array(
				'ianalytics_search_data' => array (
					'date' => $today,
					'time' => $time,
					'from_ip' => $FromIP,
					'spoken_languages' => $SpokenLanguages,
					'search_value' => $searchVal,
					'search_results' => $ResultsFound
				)
			);
			
			$this->addData($data);
		}
	}
	
	function trackProducts() {
		if(!empty($this->request->get['route'])) {
			if (stripos($this->request->get['route'], 'product/product') !== 0) {
				return;
			}
		} else {
			return;	
		}
		$productID = $this->request->get['product_id'];
		$productInfo = $this->getProductInfo($productID);
		$today = date("Y-m-d"); 
		$time = date("H:i:s"); 
		$FromIP = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '';
		$SpokenLanguages = (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
		
		$data = array(
			'ianalytics_product_opens' => array (
				'date' => $today,
				'time' => $time,
				'from_ip' => $FromIP,
				'spoken_languages' => $SpokenLanguages,
				'product_id' => $productID,
				'product_name' => $productInfo['name'],
				'product_model' => $productInfo['model'],
				'product_price' => $productInfo['price'],
				'product_quantity' => $productInfo['quantity'],
				'product_stock_status' => $productInfo['stock_status']
			)
		);			

		$this->addData($data);

	}
	
	function trackComparedProducts() {
		if(!empty($this->request->get['route'])) {
			if ($this->request->get['route'] != 'product/compare') {
				return;
			}
		} else {
			return;	
		}
		$productsCompared = $this->session->data['compare'];
		if (count($productsCompared) < 2) return;
		
		$namedProductsCompared = array();
		$idsProductsCompared = array();
		foreach($productsCompared as $key => $value) {
			$productInfo = $this->getProductInfo($value);
			$namedProductsCompared[] = $productInfo['name'];
			$idsProductsCompared[] = $value;
		}

		sort($idsProductsCompared);

		$today = date("Y-m-d"); 
		$time = date("H:i:s"); 
		$FromIP = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '';
		$SpokenLanguages = (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
		
		$data = array(
			'ianalytics_product_comparisons' => array (
				'date' => $today,
				'time' => $time,
				'from_ip' => $FromIP,
				'spoken_languages' => $SpokenLanguages,
				'product_ids' => implode(',',$idsProductsCompared),
				'product_names' => implode(' vs. ', $namedProductsCompared)
			)
		);
		
		$this->addData($data);
	}
	
	function addData($data) {
		foreach ($data as $table => $tableData) {
			$insertFields = array();
			$insertData = array();
			
			foreach ($tableData as $fieldName => $fieldValue) {
				$insertFields[] = $fieldName;
				$insertData[] = '"'.$this->db->escape($fieldValue).'"';
			}
			
			$this->db->query('INSERT INTO ' . DB_PREFIX . $table . ' ('. implode(',', $insertFields) .') VALUES ('.implode(',', $insertData).')');
		}
	}
	
	function getSearchTotalResults($filter_name) {
		$data = array(
			'filter_name' => $filter_name
		);
		$this->load->model('catalog/product');
		return $this->model_catalog_product->getTotalProducts($data);
	}
	
	function getProductInfo($product_id) {
		$this->load->model('catalog/product');
		$product_info = $this->model_catalog_product->getProduct($product_id);
		return $product_info;
	}
	
	/* iAnalytics COUNTER - Begin */
	protected function timeOfTheDay_iAnalyticsVisits($time) {
		$stage00 = strtotime('00:00:00');
			$stage0 = strtotime('06:00:00');
			$stage1 = strtotime('12:00:00');
			$stage2 = strtotime('18:00:00');
			$stage3 = strtotime('24:00:00');
			$result = 0;
			if ($time > $stage00 && $time < $stage0) {
				$result = '0';
			} else if ($time > $stage0 && $time < $stage1) {
				$result = '1';
			} else if ($time > $stage1 && $time < $stage2) {
				$result = '2';
			} else if ($time > $stage2 && $time < $stage3) {
				$result = '3';
			}
		return $result;
	}
	
	protected function referer_iAnalyticsVisits($ref) {
	// Referer DATA
		$referers = array();
		$referers['social'] = array(
			"facebook.com",
			"t.co", 
			"twitter.com", 
			"plus.url.googl"
		);
		$referers['search_engines'] = array(
			"google.",
			"bing.com",
			"yandex.com",
			"baidu.com"
		);
		$origin=0; // 0 - Direct, 1 - Social, 2 - Search, 3 - Other
		if (isset($ref)) {
			foreach ($referers['social'] as $letter)
			{
				if (strpos($ref, $letter) !== false)
				{
					$origin = 1;
				}
			}
			if ($origin!=1) {
				foreach ($referers['search_engines'] as $letter)
					{
						if (strpos($ref, $letter) !== false)
						{
							$origin = 2;
						}
					}
			}
			if ( ($origin!=1) && ($origin!=2) && (strpos($ref,HTTP_SERVER)!==false) )
				$origin = 0;
			else if (($origin!=1) && ($origin!=2)) 
				$origin = 3;
		} else if (!isset($ref)) {
			$origin = 0;
		}
		// Referer DATA
		return $origin;
	}
	
	function register_iAnalyticsVisits() {
		if (isset($_POST['ref'])) { $ref=$_POST['ref']; } else { $ref=""; }
		
		$iAtoday = date("Y-m-d"); 
		$iAtimeChecker = strtotime(date("H:i:s"));
		$stage = $this->timeOfTheDay_iAnalyticsVisits($iAtimeChecker);

		$exists = $this->db->query("SELECT * FROM `" . DB_PREFIX . "ianalytics_visits_data` WHERE `date` = '$iAtoday' AND `stage` = '$stage'");
		if (empty($exists->row)) {
			if (!isset($this->session->data['iAnalyticsUniqueID'])) {
				$unique = 1;
				$referer = $this->referer_iAnalyticsVisits($ref);
				$this->session->data['iAnalyticsUniqueID'] = session_id();
			} else {
				$unique = 1;
				$referer = -1;
			}
			$iAdata = array(
			'ianalytics_visits_data' => array (
				'date' => $iAtoday,
				'stage' => $stage,
				'unique_visits' => $unique,
				'impressions' => 1,
				'referers_direct' => (($referer==0) ? 1 : 0),
				'referers_social' => (($referer==1) ? 1 : 0),
				'referers_search' => (($referer==2) ? 1 : 0),
				'referers_other' => (($referer==3) ? 1 : 0)
			));	
			foreach ($iAdata as $table => $tableData) {
					$insertFields = array();
					$insertData = array();
					foreach ($tableData as $fieldName => $fieldValue) {
						$insertFields[] = $fieldName;
						$insertData[] = '"'.$this->db->escape($fieldValue).'"';
					}
				$this->db->query('INSERT INTO ' . DB_PREFIX . $table . ' ('. implode(',', $insertFields) .') VALUES ('.implode(',', $insertData).')');
			}
		} else {
			$impressions = 1;
			$db_referer = "";
			if (!isset($this->session->data['iAnalyticsUniqueID'])) {
				$unique = 1;
				$referer = $this->referer_iAnalyticsVisits($ref);
				if ($referer==0) $db_referer=", `referers_direct`=referers_direct+1";
				else if ($referer==1) $db_referer=", `referers_social`=referers_social+1";
				else if ($referer==2) $db_referer=", `referers_search`=referers_search+1";
				else if ($referer==3) $db_referer=", `referers_other`=referers_other+1";
				$this->session->data['iAnalyticsUniqueID'] = session_id();
				// Funnel Data start
				$iAnalyticsSettings = $this->config->get('ianalytics');
				if ($iAnalyticsSettings['Enabled']=='yes' && $iAnalyticsSettings['AfterSaleData']=='yes') {
					$iAtoday2 = date("Y-m-d"); 
					$iAtime2 = date("H:i:s"); 
					$iAFromIP = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '*HiddenIP*';
					$iASpokenLanguages2 = (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
					$iAdata2 = array(
							'ianalytics_funnel_data' => array (
								'date' => $iAtoday2,
								'time' => $iAtime2,
								'from_ip' => $iAFromIP,
								'spoken_languages' => $iASpokenLanguages2,
								'stage' => '0'
							)
						);	
					foreach ($iAdata2 as $table => $tableData) {
						$insertFields = array();
						$insertData = array();
						foreach ($tableData as $fieldName => $fieldValue) {
							$insertFields[] = $fieldName;
							$insertData[] = '"'.$this->db->escape($fieldValue).'"';
						}
						$this->db->query('INSERT INTO ' . DB_PREFIX . $table . ' ('. implode(',', $insertFields) .') VALUES ('.implode(',', $insertData).')');
					}
					$this->session->data['iAnalyticsStage'] = '0';
				}
				// Funnel Data end
			} else {
				$unique = 0;
			}
			$this->db->query("UPDATE `".DB_PREFIX."ianalytics_visits_data` SET `unique_visits`=unique_visits+$unique, `impressions`=impressions+$impressions $db_referer WHERE `date`='$iAtoday' AND `stage` = '$stage'");
		}
	}
	/* iAnalytics COUNTER - End */

}
?>