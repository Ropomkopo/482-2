<?php
class ModelModuleIanalytics extends Model {
  	public function install() {
		$this->db->query("
		CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ianalytics_product_comparisons` (
		  `id` int(11) NOT NULL auto_increment COMMENT 'Primary index',
		  `date` date NOT NULL COMMENT 'Date when data is added',
		  `time` time NOT NULL COMMENT 'Time of day when data is added',
		  `from_ip` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'IP of client that generated the data',
		  `spoken_languages` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'Language of the client that generated the data',
		  `product_ids` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT 'The ids of the compared products, ordered ascending. Used to determine the count of the comparison',
		  `product_names` text collate utf8_unicode_ci NOT NULL COMMENT 'Product names according to the ids',
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");
		
		$this->db->query("
		CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ianalytics_product_opens` (
		  `id` int(11) NOT NULL auto_increment COMMENT 'Primary index',
		  `date` date NOT NULL COMMENT 'Date when data is added',
		  `time` time NOT NULL COMMENT 'Time of day when data is added',
		  `from_ip` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'IP of client that generated the data',
		  `spoken_languages` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'Language of the client that generated the data',
		  `product_id` int(11) NOT NULL COMMENT 'The id of the opened product',
		  `product_name` text collate utf8_unicode_ci NOT NULL COMMENT 'The name of the opened product',
		  `product_model` text collate utf8_unicode_ci NOT NULL COMMENT 'The model of the opened product',
		  `product_price` decimal(15,4) NOT NULL default '0.0000' COMMENT 'The price of the opened product',
		  `product_quantity` int(11) NOT NULL default '0' COMMENT 'The quantity of the opened product',
		  `product_stock_status` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'The stock status of the opened product',
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");
		
		$this->db->query("
		CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ianalytics_product_add_to_cart` (
		  `id` int(11) NOT NULL auto_increment COMMENT 'Primary index',
		  `date` date NOT NULL COMMENT 'Date when data is added',
		  `time` time NOT NULL COMMENT 'Time of day when data is added',
		  `from_ip` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'IP of client that generated the data',
		  `spoken_languages` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'Language of the client that generated the data',
		  `product_id` int(11) NOT NULL COMMENT 'The id of the opened product',
		  `product_name` text collate utf8_unicode_ci NOT NULL COMMENT 'The name of the added to cart product',
		  `product_model` text collate utf8_unicode_ci NOT NULL COMMENT 'The model of the added to cart product',
		  `product_price` decimal(15,4) NOT NULL default '0.0000' COMMENT 'The price of the added to cart product',
		  `product_quantity` int(11) NOT NULL default '0' COMMENT 'The quantity of the the added to cart product',
		  `product_stock_status` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'The stock status of the added to cart product',
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");
		
		$this->db->query("
		CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ianalytics_product_add_to_wishlist` (
		  `id` int(11) NOT NULL auto_increment COMMENT 'Primary index',
		  `date` date NOT NULL COMMENT 'Date when data is added',
		  `time` time NOT NULL COMMENT 'Time of day when data is added',
		  `from_ip` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'IP of client that generated the data',
		  `spoken_languages` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'Language of the client that generated the data',
		  `product_id` int(11) NOT NULL COMMENT 'The id of the opened product',
		  `product_name` text collate utf8_unicode_ci NOT NULL COMMENT 'The name of the added to cart product',
		  `product_model` text collate utf8_unicode_ci NOT NULL COMMENT 'The model of the added to cart product',
		  `product_price` decimal(15,4) NOT NULL default '0.0000' COMMENT 'The price of the added to cart product',
		  `product_quantity` int(11) NOT NULL default '0' COMMENT 'The quantity of the the added to cart product',
		  `product_stock_status` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'The stock status of the added to wishlist product',
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");
		
		$this->db->query("
		CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ianalytics_search_data` (
		  `id` int(11) NOT NULL auto_increment COMMENT 'Primary index',
		  `date` date NOT NULL COMMENT 'Date when data is added',
		  `time` time NOT NULL COMMENT 'Time of day when data is added',
		  `from_ip` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'IP of client that generated the data',
		  `spoken_languages` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'Language of the client that generated the data',
		  `search_value` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'The searched text',
		  `search_results` int(11) NOT NULL default '0' COMMENT 'The number of found search results',
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");
		
		$this->db->query("
		CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ianalytics_funnel_data` (
		  `id` int(11) NOT NULL auto_increment COMMENT 'Primary index',
		  `date` date NOT NULL COMMENT 'Date when data is added',
		  `time` time NOT NULL COMMENT 'Time of day when data is added',
		  `from_ip` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'IP of client that generated the data',
		  `spoken_languages` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'Language of the client that generated the data',
		  `stage` enum('0','1','2','3','4','5','6') not null default '0' COMMENT 'Stage of the cliend that generated the data',
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");
		
		$this->db->query("
		CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ianalytics_visits_data` (
		  `id` int(11) NOT NULL auto_increment COMMENT 'Primary index',
		  `date` date NOT NULL COMMENT 'Date when data is added',
		  `stage` enum('0','1','2','3') not null default '0' COMMENT 'Stage of the cliend that generated the data',
		  `unique_visits` int(11) NOT NULL default '0' COMMENT 'Unique visits',
		  `impressions` int(11) NOT NULL default '0' COMMENT 'Visited Pages',
		  `referers_direct` int(11) NOT NULL default '0' COMMENT 'Direct hits',
		  `referers_social` int(11) NOT NULL default '0' COMMENT 'Referers from social networks',
		  `referers_search` int(11) NOT NULL default '0' COMMENT 'Referers from search engines',
		  `referers_other` int(11) NOT NULL default '0' COMMENT 'Referers from other websites',
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;");
				 
		$this->db->query("UPDATE `" . DB_PREFIX . "modification` SET status=1 WHERE `name` LIKE'%iAnalytics by iSenseLabs%'");
		$modifications = $this->load->controller('extension/modification/refresh');
  	} 
  
  	public function uninstall() {
		$this->db->query("UPDATE `" . DB_PREFIX . "modification` SET status=0 WHERE `name` LIKE'%iAnalytics by iSenseLabs%'");
		$modifications = $this->load->controller('extension/modification/refresh');
  	}		
	
	public $data;
	
	public function getAnalyticsData(&$mydata) {
		$this->data =& $mydata;
			
		//GET DATA
		$this->data['iAnalyticsMinDate'] = $this->_findMinDate();
		
		//MANAGE DATES
		$fromDate = (empty($_GET['fromDate'])) ? '' : date_parse(preg_replace('/([^0-9-])/m', '', $_GET['fromDate']));
		$toDate = (empty($_GET['toDate'])) ? '' : date_parse(preg_replace('/([^0-9-])/m', '', $_GET['toDate']));
		$now = time();
		
		if (is_array($toDate) && $toDate['warning_count'] == 0 && $toDate['error_count'] == 0) {
			if (!checkdate($toDate['month'], $toDate['day'], $toDate['year'])) {
				$toDate = date('Y-m-d', $now);
			} else {
				$toDate = str_pad($toDate['year'], 4, '0', STR_PAD_LEFT) . '-' . str_pad($toDate['month'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($toDate['day'], 2, '0', STR_PAD_LEFT);
				
				if (strcmp($toDate, date('Y-m-d')) > 0) {
					$toDate = date('Y-m-d', $now);	
				}
			}
		} else {
			$toDate = date('Y-m-d', $now);	
		}
		
		if (is_array($fromDate) && $fromDate['warning_count'] == 0 && $fromDate['error_count'] == 0) {
			if (!checkdate($fromDate['month'], $fromDate['day'], $fromDate['year'])) {
				$fromDate = $this->data['iAnalyticsMinDate'];
			} else {
				$fromDate = str_pad($fromDate['year'], 4, '0', STR_PAD_LEFT) . '-' . str_pad($fromDate['month'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($fromDate['day'], 2, '0', STR_PAD_LEFT);
				
				if (strcmp($fromDate, $this->data['iAnalyticsMinDate']) < 0) {
					$fromDate = $this->data['iAnalyticsMinDate'];
				}
			}
		} else {
			$fromDate = $this->data['iAnalyticsMinDate']; 
		}
		
		$enable = array();
		$interval = NULL;
		
		$interval = abs(ceil((($now - strtotime($this->data['iAnalyticsMinDate']))/86400))) + 1;
		
		switch ($interval) {
			case ($interval < 7) : 						{ $enable = array(1,0,0,0); } break;
			case ($interval >= 7 && $interval < 30) : 	{ $enable = array(1,1,0,0); } break;
			case ($interval >= 30 && $interval < 365) : { $enable = array(1,1,1,0); } break;
			case ($interval >= 365) : 					{ $enable = array(1,1,1,1); } break;
		}
		
		$select = array(1,0,0,0);
		
		if ($toDate == date('Y-m-d', $now)) {
			$interval = abs(ceil(((strtotime($toDate) - strtotime($fromDate))/86400)));
			if (empty($_GET['fromDate']) && empty($_GET['toDate'])) {
				if ($interval > 30) {
					$fromDate = date('Y-m-d', $now - 29*86400);
					$interval = abs(ceil(((strtotime($toDate) - strtotime($fromDate))/86400)));
				}
			}
			
			switch ($interval) {
				case 6 :		{ $select = array(0,1,0,0); } break;
				case 29 : 		{ $select = array(0,0,1,0); } break;
				case 364 : 		{ $select = array(0,0,0,1); } break;
				default : 		{ $select = array(1,0,0,0); } break;
			}
		} 
		
		$this->data['iAnalyticsSelectData'] 					= array('enable' => $enable, 'select' => $select);
		
		$this->data['iAnalyticsFromDate'] 						= $fromDate;
		$this->data['iAnalyticsToDate'] 						= $toDate;
		
		$this->data['iAnalyticsMonthlySearchesGraph'] 		= $this->getMonthlySearchesGraph(); 
		$this->data['iAnalyticsMonthlySearchesTable'] 		= $this->getMonthlySearchesTable();
		$this->data['iAnalyticsKeywordSearchHistory'] 		= $this->getKeywordSearchHistory();
		$this->data['iAnalyticsMostSearchedKeywords'] 		= $this->getMostSearchedKeywords();
		$this->data['iAnalyticsMostFoundKeywords'] 			= $this->getMostFoundKeywords();
		$this->data['iAnalyticsMostOpenedProducts'] 			= $this->getMostOpenedProducts();
		$this->data['iAnalyticsMostAddedtoCartProducts'] 		= $this->getMostAddedtoCartProducts();
		$this->data['iAnalyticsMostAddedtoWishlistProducts'] 	= $this->getMostAddedtoWishlistProducts();
		$this->data['iAnalyticsMostComparedProducts'] 		= $this->getMostComparedProducts();
		$this->data['iAnalyticsMostSearchedKeywordsPie'] 		= $this->getMostSearchedKeywordsPie();
		$this->data['iAnalyticsMostFoundKeywordsPie'] 		= $this->getMostFoundKeywordsPie();
		$this->data['iAnalyticsMostOpenedProductsPie'] 		= $this->getMostOpenedProductsPie();
		$this->data['iAnalyticsMostComparedProductsPie'] 		= $this->getMostComparedProductsPie();
		$this->data['iAnalyticsFunnelData'] 					= $this->getFunnelData();
		$this->data['iAnalyticsVisitorsData'] 				= $this->getVisitorsData();
		$this->data['iAnalyticsVisitorsDataByDay'] 			= $this->getVisitorsDataByDay();
		$this->data['iAnalyticsVisitorsDataReferers'] 		= $this->getVisitorsDataReferers();
		$this->data['iAnalyticsVisitorsDataReferersPie'] 		= $this->getVisitorsDataReferersPie();
		
	}
	
	public function deleteSearchKeyword($id) {
		$this->db->query('DELETE FROM ' . DB_PREFIX . 'ianalytics_search_data WHERE id = "' . $id . '"');
	}
	
	public function deleteAllSearchKeyword($value) {
		$this->db->query('DELETE FROM ' . DB_PREFIX . 'ianalytics_search_data WHERE search_value = "' . $value . '"');
	}
	
	public function deleteAnalyticsData() {
		$this->db->query('DELETE FROM ' . DB_PREFIX . 'ianalytics_product_comparisons');
		$this->db->query('DELETE FROM ' . DB_PREFIX . 'ianalytics_product_opens');
		$this->db->query('DELETE FROM ' . DB_PREFIX . 'ianalytics_search_data');
		$this->db->query('DELETE FROM ' . DB_PREFIX . 'ianalytics_product_add_to_cart');
		$this->db->query('DELETE FROM ' . DB_PREFIX . 'ianalytics_product_add_to_wishlist');
		$this->db->query('DELETE FROM ' . DB_PREFIX . 'ianalytics_funnel_data');
		$this->db->query('DELETE FROM ' . DB_PREFIX . 'ianalytics_visits_data');
	}
	
	function excludedIPs() {
		$configValue = $this->config->get('iAnalytics');
		$ips = array();
		if (!empty($configValue['BlacklistedIPs'])) {
			$ips = $configValue['BlacklistedIPs'];
			$ips = str_replace("\n\r", "\n", $ips);
			$ips = explode("\n", $ips);
			foreach ($ips as $i => $val) {
				$ips[$i] = '"'.trim($val).'"';
			}
		}
		
		return $ips;
	}
	
	function getMonthlySearchesGraph() {
		if (empty($this->data['iAnalyticsVendorId'])) {
			$days = array(array('Day','Successful queries','Zero-results queries'));
			
			for ($i=$this->data['iAnalyticsFromDate']; strcmp($i, $this->data['iAnalyticsToDate']) <= 0; $i = date('Y-m-d', strtotime($i) + 86400 + 43201)) {
				$theday = date("j-n-Y",strtotime($i));
				$days[] = array(date("j-n-Y",strtotime($i)),$this->getNumberSearchesByDay($i,'success'),$this->getNumberSearchesByDay($i,'fail'));
			}
			return $days;
		} else {
			
		}
	}
	
	function getKeywordSearchHistory($limit=80) {
		$excludedIPs = $this->excludedIPs();
		$result = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'ianalytics_search_data WHERE' . (!empty($excludedIPs) ? ' `from_ip` NOT IN (' . implode(',', $excludedIPs) . ') AND' : '') . ' `date` >= "'.$this->data['iAnalyticsFromDate'].'" AND `date` <= "'.$this->data['iAnalyticsToDate'].'" ORDER BY `date` DESC, `time` DESC LIMIT 0, '.$limit);
		
		if ($result->num_rows == 0) {
			return array(0 => 'No Data Gathered Yet');	
		} else {
			$k = array(array('Keyword','Date','Time','Results Found','User Language','IP address','ID'));
			foreach($result->rows as $i => $search) {
				array_push($k, array($search['search_value'],$search['date'],$search['time'],$search['search_results'],$search['spoken_languages'],$search['from_ip'],$search['id']));
			}	
		}
		
		return $k;
	}
	
	function getMostSearchedKeywordsPie() {
		$keywords = $this->_getMostSearchedKeywordsRaw(7);
		$keys = array_keys($keywords);
		$values = array_values($keywords);
		$pattern = array();
		foreach (array_combine($keys, $values) as $key => $val) {
			$pattern[$key] = $val;
		}
		return $pattern;
	}
	
	function getMostFoundKeywordsPie() {
		$keywords = $this->_getMostSearchedKeywordsRaw(15,false);
		$keys = array_keys($keywords);
		$values = array_values($keywords);
		if (count($values) == 2) {
			return $keys[0].':'.$values[0].':#718b3b;'.$keys[1].':'.$values[1].':#a0c74e;';
		}
		
		if (count($values) == 1) {
			return $keys[0].':'.$values[0].':#718b3b;';
		}
		
		if (count($values) == 0) {
			return 'No Data Gathered Yet:100:#718b3b;';
		}
		$pattern = $keys[0].':'.$values[0].':#718b3b;'.$keys[1].':'.$values[1].':#a0c74e;'.$keys[2].':'.$values[2].':#CFE3A6;';
		return $pattern;
	}
	

	function getMostOpenedProductsPie() {
		$opens = $this->_getMostOpenedProductsRaw('product_name');
		$keys = array_keys($opens);
		$values = array_values($opens);
		if (count($values) == 2) {
			return $keys[0].':'.$values[0].':#003A88;'.$keys[1].':'.$values[1].':#005CD9;';
		}
		
		if (count($values) == 1) {
			return $keys[0].':'.$values[0].':#003A88;';
		}
		
		if (count($values) == 0) {
			return 'No Data Gathered Yet:100:#003A88;';
		}
		$pattern = $keys[0].':'.$values[0].':#003A88;'.$keys[1].':'.$values[1].':#005CD9;'.$keys[2].':'.$values[2].':#519BFF;';
		return $pattern;
	}
	
	function getMostComparedProductsPie() {
		$comparisons = $this->_getMostComparedProductsRaw();
		
		$keys = array_keys($comparisons);
		$values = array_values($comparisons);

		if (count($values) == 2) {
			return $keys[0].':'.$values[0].':#CE3CFF;'.$keys[1].':'.$values[1].':#DD77FF;';
		}
		
		if (count($values) == 1) {
			return $keys[0].':'.$values[0].':#CE3CFF;';
		}
		
		if (count($values) == 0) {
			return 'No Data Gathered Yet:100:#CE3CFF;';
		}
		
		$pattern = $keys[0].':'.$values[0].':#CE3CFF;'.$keys[1].':'.$values[1].':#DD77FF;'.$keys[2].':'.$values[2].':#EFBFFF;';
		return $pattern;
	}
	
	
	function _getMostOpenedProductsRaw($param='product_id') {
		$excludedIPs = $this->excludedIPs();
		$result = $this->db->query('SELECT '.$param.', COUNT(*) as count FROM ' . DB_PREFIX . 'ianalytics_product_opens WHERE' . (!empty($excludedIPs) ? ' `from_ip` NOT IN (' . implode(',', $excludedIPs) . ') AND' : '') . ' `date` >= "'.$this->data['iAnalyticsFromDate'].'" AND `date` <= "'.$this->data['iAnalyticsToDate'].'" GROUP BY `product_id` ORDER BY count DESC, `date` DESC, `time` DESC');
		
		if ($result->num_rows == 0) {
			return array('No Data Gathered Yet' => 0);
		} else {
			$k = array();
			foreach($result->rows as $i => $search) {
				$k[$search[$param]] = $search['count'];
			}
			arsort($k);
		}
		
		return $k;
	}
	
	function _getMostAddedtoCartProductsRaw($param='product_id') {
		$excludedIPs = $this->excludedIPs();
		$result = $this->db->query('SELECT '.$param.', COUNT(*) as count FROM ' . DB_PREFIX . 'ianalytics_product_add_to_cart
 WHERE' . (!empty($excludedIPs) ? ' `from_ip` NOT IN (' . implode(',', $excludedIPs) . ') AND' : '') . ' `date` >= "'.$this->data['iAnalyticsFromDate'].'" AND `date` <= "'.$this->data['iAnalyticsToDate'].'" GROUP BY `product_id` ORDER BY count DESC, `date` DESC, `time` DESC');
		
		if ($result->num_rows == 0) {
			return array('No Data Gathered Yet' => 0);
		} else {
			$k = array();
			foreach($result->rows as $i => $search) {
				$k[$search[$param]] = $search['count'];
			}
			arsort($k);
		}
		
		return $k;
	}
	
	function _getMostAddedtoWishlistProductsRaw($param='product_id') {
		$excludedIPs = $this->excludedIPs();
		$result = $this->db->query('SELECT '.$param.', COUNT(*) as count FROM ' . DB_PREFIX . 'ianalytics_product_add_to_wishlist
 WHERE' . (!empty($excludedIPs) ? ' `from_ip` NOT IN (' . implode(',', $excludedIPs) . ') AND' : '') . ' `date` >= "'.$this->data['iAnalyticsFromDate'].'" AND `date` <= "'.$this->data['iAnalyticsToDate'].'" GROUP BY `product_id` ORDER BY count DESC, `date` DESC, `time` DESC');
		
		if ($result->num_rows == 0) {
			return array('No Data Gathered Yet' => 0);
		} else {
			$k = array();
			foreach($result->rows as $i => $search) {
				$k[$search[$param]] = $search['count'];
			}
			arsort($k);
		}
		
		return $k;
	}
	
	function _getFunnelDataRaw($param='stage') {
		$excludedIPs = $this->excludedIPs();
		$result = $this->db->query('SELECT '.$param.', COUNT(*) as count FROM ' . DB_PREFIX . 'ianalytics_funnel_data
 WHERE' . (!empty($excludedIPs) ? ' `from_ip` NOT IN (' . implode(',', $excludedIPs) . ') AND' : '') . ' `date` >= "'.$this->data['iAnalyticsFromDate'].'" AND `date` <= "'.$this->data['iAnalyticsToDate'].'" GROUP BY `stage` ORDER BY `stage` ASC, `date` DESC, `time` DESC');

		if ($result->num_rows == 0) {
			return array('No Data Gathered Yet' => 0);
		} else {
			$k = array();
			foreach($result->rows as $i => $search) {
				$k[$search[$param]] = $search['count'];
			}
		}
		return $k;
	}
	
	function _getMostComparedProductsRaw() {
		$excludedIPs = $this->excludedIPs();
		$result = $this->db->query('SELECT product_ids as pids, (SELECT product_names FROM ' . DB_PREFIX . 'ianalytics_product_comparisons WHERE product_ids = pids ORDER BY `date` DESC, `time` DESC LIMIT 0,1) as comparison, COUNT(*) as count FROM ' . DB_PREFIX . 'ianalytics_product_comparisons WHERE' . (!empty($excludedIPs) ? ' `from_ip` NOT IN (' . implode(',', $excludedIPs) . ') AND' : '') . ' `date` >= "'.$this->data['iAnalyticsFromDate'].'" AND `date` <= "'.$this->data['iAnalyticsToDate'].'" GROUP BY pids ORDER BY count DESC');
		
		if ($result->num_rows == 0) {
			return array('No Data Gathered Yet' => 0);
		} else {
			$k = array();
			foreach($result->rows as $i => $search) {
				$k[$search['comparison']] = $search['count'];
			}
			arsort($k);	
		}
		
		return $k;
	}
	
	function _getMostSearchedKeywordsRaw($limit=80,$returnZeroResultsToo = true) {
		$temp = array();
		
		if ($returnZeroResultsToo == false) $condition = ' AND search_results != "0"'; else $condition = '';
		$excludedIPs = $this->excludedIPs();
		$result = $this->db->query('SELECT `search_value`, COUNT(*) as count FROM ' . DB_PREFIX . 'ianalytics_search_data WHERE' . (!empty($excludedIPs) ? ' `from_ip` NOT IN (' . implode(',', $excludedIPs) . ') AND' : '') . ' `date` >= "'.$this->data['iAnalyticsFromDate'].'" AND `date` <= "'.$this->data['iAnalyticsToDate'].'"'.$condition.' GROUP BY `search_value` ORDER BY count DESC LIMIT 0, '.$limit);
		if ($result->num_rows == 0) {
			return array('No Data Gathered Yet' => 'No Data Gathered Yet');
		} else {
			$res = array();
			foreach($result->rows as $row) {
				$res[$row['search_value']] = $row['count'];	
			}
			arsort($res);
			return $res;
		}
		return $results;
	}
	
	function getMostComparedProducts() {
		$k = array(array('Products','Comparisons'));
		$temp = $this->_getMostComparedProductsRaw();
		if($temp === array('No Data Gathered Yet' => 0)) {
			return array(0 => 'No Data Gathered Yet');
		}
		foreach ($temp as $key => $value) {
			array_push($k, array($key,$value));
		}
		
		
		
		return $k;
	}
	
	function getMostOpenedProducts() {
		$k = array(array('Product','Opens'));
		$temp = $this->_getMostOpenedProductsRaw('product_name');
		foreach ($temp as $key => $value) {
			array_push($k, array($key,$value));
		}
		
		return $k;
	}
	
	function getMostAddedtoCartProducts() {
		$k = array(array('Product','Added to Cart'));
		$temp = $this->_getMostAddedtoCartProductsRaw('product_name');
		foreach ($temp as $key => $value) {
			array_push($k, array($key,$value));
		}
		
		return $k;
	}
	
	function getMostAddedtoWishlistProducts() {
		$k = array(array('Product','Added to Wishlist'));
		$temp = $this->_getMostAddedtoWishlistProductsRaw('product_name');
		foreach ($temp as $key => $value) {
			array_push($k, array($key,$value));
		}
		
		return $k;
	}
	
	function getFunnelData() {
		$k = array(array('Stage','Actions'));
		$temp = $this->_getFunnelDataRaw('stage');
		foreach ($temp as $key => $value) {
			array_push($k, array($key,$value));
		}
		
		return $k;
	}
	
	function getVisitorsData($param='stage') {
		$excludedIPs = $this->excludedIPs();
		$result = $this->db->query('SELECT '.$param.', sum(`unique_visits`) as visits, sum(`impressions`) as page_impressions, sum(referers_social+referers_other+referers_search+referers_direct) as referers FROM ' . DB_PREFIX . 'ianalytics_visits_data
 WHERE `date` >= "'.$this->data['iAnalyticsFromDate'].'" AND `date` <= "'.$this->data['iAnalyticsToDate'].'" GROUP BY `stage` ORDER BY `stage` ASC, `date` DESC');

		if ($result->num_rows == 0) {
			return array(0 => 'No Data Gathered Yet');	
		} else {
			$k = array(array('Part of the Day','Unique Visits','Page Impressions','Referers'));
			foreach($result->rows as $i => $search) {
				array_push($k, array($search['stage'],$search['visits'],$search['page_impressions'],$search['referers']));
			}	
		}
		return $k;
	}
	
	function getVisitorsDataByDay($param='date') {
		$excludedIPs = $this->excludedIPs();
		$result = $this->db->query('SELECT '.$param.', sum(`unique_visits`) as visits, sum(`impressions`) as page_impressions, sum(referers_social+referers_other+referers_search+referers_direct) as referers FROM ' . DB_PREFIX . 'ianalytics_visits_data
 WHERE `date` >= "'.$this->data['iAnalyticsFromDate'].'" AND `date` <= "'.$this->data['iAnalyticsToDate'].'" GROUP BY `date` ORDER BY `date` ASC');

		if ($result->num_rows == 0) {
			return array(0 => 'No Data Gathered Yet');	
		} else {
			$k = array(array('Date','Unique Visits','Page Impressions','Referers'));
			foreach($result->rows as $i => $search) {
				array_push($k, array($search['date'],$search['visits'],$search['page_impressions'],$search['referers']));
			}	
		}
		return $k;
	}
	
	function getVisitorsDataReferers($param='date') {
		$excludedIPs = $this->excludedIPs();
		$result = $this->db->query('SELECT '.$param.', sum(`referers_direct`) as direct, sum(`referers_social`) as social, sum(`referers_other`) as other, sum(`referers_search`) as search FROM ' . DB_PREFIX . 'ianalytics_visits_data
 WHERE `date` >= "'.$this->data['iAnalyticsFromDate'].'" AND `date` <= "'.$this->data['iAnalyticsToDate'].'" GROUP BY `date` ORDER BY `date` DESC');

		if ($result->num_rows == 0) {
			return array(0 => 'No Data Gathered Yet');	
		} else {
			$k = array(array('Date','Direct','Social','Search','Other'));
			foreach($result->rows as $i => $search) {
				array_push($k, array($search['date'],$search['direct'],$search['social'],$search['search'],$search['other']));
			}	
		}
		return $k;
	}
	
	function getVisitorsDataReferersPie($param='') {
		$excludedIPs = $this->excludedIPs();
		$result = $this->db->query('SELECT '.$param.' sum(`referers_direct`) as direct, sum(`referers_social`) as social, sum(`referers_other`) as other, sum(`referers_search`) as search FROM ' . DB_PREFIX . 'ianalytics_visits_data
 WHERE `date` >= "'.$this->data['iAnalyticsFromDate'].'" AND `date` <= "'.$this->data['iAnalyticsToDate'].'" ORDER BY `date` DESC');

		if ($result->num_rows == 0) {
			return array(0 => 'No Data Gathered Yet');	
		} else {
			$k = array(array('Direct','Social','Search','Other'));
			foreach($result->rows as $i => $search) {
				array_push($k, array($search['direct'],$search['social'],$search['search'],$search['other']));
			}	
		}
		return $k;
	}

	function getMostFoundKeywords() {
		$k = array(array('Keyword','Queries'));
		$temp = $this->_getMostSearchedKeywordsRaw(80,false);
		foreach ($temp as $key => $value) {
			array_push($k, array($key,$value));
		}
		
		return $k;
	}
	
	function getMostSearchedKeywords() {
		$k = array(array('Keyword','Searches'));
		$temp = $this->_getMostSearchedKeywordsRaw();
		foreach ($temp as $key => $value) {
			array_push($k, array($key,$value));
		}
		
		return $k;
	}
	
	function getMonthlySearchesTable() {
		if (empty($this->data['iAnalyticsVendorId'])) {
			$days = array(array('Day','Total Search Queries','Successful Search Queries','Zero-Results Search Queries'));
			
			for ($i=$this->data['iAnalyticsToDate']; strcmp($i, $this->data['iAnalyticsFromDate']) >= 0; $i = date('Y-m-d', strtotime($i) - 43201)) {
				$succeeded = $this->getNumberSearchesByDay($i,'success');
				$failed = $this->getNumberSearchesByDay($i,'fail');
				$days[] = array(date("j-n-Y",strtotime($i)), $succeeded+$failed, $succeeded, $failed);
			}
			
			return $days;
		} else {
			
		}
	}
	
	function getNumberSearchesByDay(&$day, $type='success') {
		$success=0;
		$fail=0;
		if ($type == 'success') $condition = 'search_results != "0"';
		else $condition = 'search_results = "0"';
		$excludedIPs = $this->excludedIPs();
		$result = $this->db->query('SELECT COUNT(*) as count FROM ' . DB_PREFIX . 'ianalytics_search_data WHERE' . (!empty($excludedIPs) ? ' `from_ip` NOT IN (' . implode(',', $excludedIPs) . ') AND' : '') . ' `date` >= "'.$this->data['iAnalyticsFromDate'].'" AND `date` <= "'.$this->data['iAnalyticsToDate'].'" AND `date`="'.$day.'" AND '.$condition.' GROUP BY `date`');
		$count = empty($result->row['count']) ? 0 : (int)$result->row['count'];
		
		return $count;
	}


	function _findMinDate() {
		$excludedIPs = $this->excludedIPs();
		$result = $this->db->query('
		SELECT LEAST(
			(SELECT MIN(`date`) FROM '.DB_PREFIX.'ianalytics_product_comparisons' . (!empty($excludedIPs) ? ' WHERE `from_ip` NOT IN (' . implode(',', $excludedIPs) . ')' : '') . '),
			(SELECT MIN(`date`) FROM '.DB_PREFIX.'ianalytics_product_opens' . (!empty($excludedIPs) ? ' WHERE `from_ip` NOT IN (' . implode(',', $excludedIPs) . ')' : '') . '),
			(SELECT MIN(`date`) FROM '.DB_PREFIX.'ianalytics_search_data' . (!empty($excludedIPs) ? ' WHERE `from_ip` NOT IN (' . implode(',', $excludedIPs) . ')' : '') . ')
		) as min
		');
		
		if ($result->num_rows > 0) return $result->row['min'];
		else return '0000-00-00';
	}

	public function getOrders($data = array()) {
		$sql = "SELECT MIN(o.date_added) AS date_start, MAX(o.date_added) AS date_end, COUNT(*) AS `orders`, (SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'tax' GROUP BY ot.order_id) AS tax, SUM(o.total) AS `total` FROM `" . DB_PREFIX . "order` o";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added), DAY(o.date_added)";
				break;
			default:
			case 'week':
				$sql .= " GROUP BY YEAR(o.date_added), WEEK(o.date_added)";
				break;
			case 'month':
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added)";
				break;
			case 'year':
				$sql .= " GROUP BY YEAR(o.date_added)";
				break;
		}

		$sql .= " ORDER BY o.date_added DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getOrdersCustomer($data = array()) {
		$sql = "SELECT c.customer_id, CONCAT(c.firstname, ' ', c.lastname) AS customer, c.email, cgd.name AS customer_group, c.status, COUNT(o.order_id) AS orders, SUM(o.total) AS `total` FROM `" . DB_PREFIX . "order` o 
			LEFT JOIN `" . DB_PREFIX . "customer` c ON (o.customer_id = c.customer_id) 
			LEFT JOIN `" . DB_PREFIX . "customer_group_description` cgd ON (c.customer_group_id = cgd.customer_group_id AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "') 
			WHERE o.customer_id > 0 ";
	
		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$sql .= " GROUP BY o.customer_id ORDER BY total DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);
		return $query->rows;
	}

}
?>