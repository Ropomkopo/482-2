<?php
class ModelSaleNewfastorder extends Model {

	public function editNewfastorder($newfastorder_id,$data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "newfastorder SET 
		name = '" . $this->db->escape($data['name']) . "',
		telephone = '" . $this->db->escape($data['telephone']) . "',
		email_buyer = '" . $this->db->escape($data['email_buyer']) . "',
		comment = '" . $this->db->escape($data['comment']) . "',
		username = '" . $this->db->escape($data['username']) . "',
		status_id = '" . (int)$data['status_id'] . "',
		date_modified = NOW() WHERE fast_id = '" . (int)$newfastorder_id . "'");	
	}

	
	public function editNewfastorders($newfastorder_id) {
      	$this->db->query("UPDATE " . DB_PREFIX . "newfastorder SET status_id = '1', date_modified = NOW() WHERE fast_id = '" . (int)$newfastorder_id . "'");


	}
	
	public function deleteNewfastorder($newfastorder_id) {
	$del_prod_fast = $this->db->query("SELECT order_id FROM ". DB_PREFIX ."newfastorder WHERE fast_id = '". $newfastorder_id ."'");
			foreach($del_prod_fast->rows as $del_prod){
				$this->db->query("DELETE FROM " . DB_PREFIX . "newfastorder_product WHERE order_id = '" . $del_prod['order_id'] . "'");
			}
		$this->db->query("DELETE FROM " . DB_PREFIX . "newfastorder WHERE fast_id = '" . (int)$newfastorder_id . "'");
		
			
		$this->cache->delete('newfastorder');
	}	
	
	public function getNewfastorder($newfastorder_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "newfastorder WHERE fast_id = '" . (int)$newfastorder_id . "'");
		
		return $query->row;
	}
	public function getCustomers($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "newfastorder` nfo";
		$sql .= " WHERE nfo.fast_id > '0'";

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(nfo.name, ' ', nfo.telephone, ' ', nfo.email_buyer) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'fast_id',			
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

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
	public function getNewfastorders($data = array()) {

		if ($data) {
			$sql = "SELECT * FROM `" . DB_PREFIX . "newfastorder` nfo";
			$sql .= " WHERE nfo.fast_id > '0'";
			
			if (!empty($data['searh_info_user'])) {
				$sql .= " AND CONCAT(nfo.name, ' ', nfo.telephone, ' ', nfo.email_buyer) LIKE '%" . $this->db->escape($data['searh_info_user']) . "%'";
			}
			if (!empty($data['filter_url'])) {
				$sql .= " AND CONCAT(nfo.newfastorder_url) LIKE '%" . $this->db->escape($data['filter_url']) . "%'";
			}
			if (!empty($data['filter_manager'])) {
				$sql .= " AND CONCAT(nfo.username) LIKE '%" . $this->db->escape($data['filter_manager']) . "%'";
			}
			if (!empty($data['filter_date_added'])) {
				$sql .= " AND CONCAT(nfo.date_added) LIKE '%" . $this->db->escape($data['filter_date_added']) . "%'";
			}
			if (!empty($data['filter_date_modified'])) {
				$sql .= " AND CONCAT(nfo.date_modified) LIKE '%" . $this->db->escape($data['filter_date_modified']) . "%'";
			}
			if (!empty($data['filter_status']) || ($data['filter_status'] =='0')) {
				$sql .= " AND nfo.status_id = " . (float)$data['filter_status'] . "";
			}
					
			
			$sort_data = array(
				'fast_id',
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY fast_id";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
			
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
		} else {
			$newfastorder_data = $this->cache->get('newfastorder');
		
			if (!$newfastorder_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "newfastorder ORDER BY fast_id");
	
				$newfastorder_data = $query->rows;
			
				$this->cache->set('newfastorder', $newfastorder_data);
			}
		 
			return $newfastorder_data;
		}
	}
	
	public function getFastOrderProducts($order_id) {		
		$query = $this->db->query("SELECT * FROM ". DB_PREFIX ."newfastorder_product WHERE order_id = ". $order_id ."");		
		return $query->rows;
	}
	
	public function getFastOrderProductOptions($data) {		
		$query = $this->db->query("SELECT * FROM ". DB_PREFIX ."newfastorder_product_option WHERE order_id = ". $data['order_id'] ." AND order_product_id = ". $data['product_id'] ."");		
		return $query->rows;
	}
	public function countTotalNewFastorder() {
		$query = $this->db->query("SELECT COUNT(status_id) AS countfastorder FROM `".DB_PREFIX."newfastorder` WHERE status_id = '0'");		
		return $query->row['countfastorder'];
	}

	public function getTotalNewfastorders() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "newfastorder"); 		
		return $query->row['total'];
	}
	public function addDbQuickorder() {							
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS  " . DB_PREFIX . "newfastorder (fast_id int(11) NOT NULL primary key AUTO_INCREMENT,
		name varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		order_id text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		total text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		telephone varchar(30) NOT NULL,
		email_buyer varchar(90) NOT NULL,
		date_added datetime NOT NULL,
		date_modified datetime NOT NULL,
		status_id int(11) NOT NULL,
		comment text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		newfastorder_url text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		comment_buyer text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		username text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL)");		
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS  " . DB_PREFIX . "newfastorder_product (id int(11) NOT NULL primary key AUTO_INCREMENT,
		order_id text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		product_id text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		product_name text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		product_image text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		model text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		quantity text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		total text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		currency_code varchar(90) NOT NULL,
		currency_value decimal(15,8) NOT NULL,
		price text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL)");
	
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS  ". DB_PREFIX ."key_newfastorder (`key` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, license_key text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL)");
		$license_key = $this->db->query("SELECT `key` FROM ". DB_PREFIX ."key_newfastorder WHERE `key`='local_key' LIMIT 1");
		if ($license_key->num_rows <= 0) { $this->db->query("INSERT INTO ". DB_PREFIX ."key_newfastorder (`key`, `license_key`) VALUES('local_key', '');"); }
		 
		$query = $this->db->query("DESC `".DB_PREFIX."newfastorder` email_buyer");
		if (!$query->num_rows) { 
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "newfastorder` ADD `email_buyer` varchar(90) NOT NULL");
		}
		$query = $this->db->query("DESC `".DB_PREFIX."newfastorder_product` currency_code");
		if (!$query->num_rows) { 
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "newfastorder_product` ADD `currency_code` varchar(90) NOT NULL");
		}  
		$query = $this->db->query("DESC `".DB_PREFIX."newfastorder_product` currency_value");
		if (!$query->num_rows) { 
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "newfastorder_product` ADD `currency_value` decimal(15,8) NOT NULL");
		}
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "newfastorder_product_option` (
		`order_option_id` int(11) NOT NULL AUTO_INCREMENT,
		`order_id` int(11) NOT NULL,
		`order_product_id` int(11) NOT NULL,
		`product_option_id` int(11) NOT NULL,
		`product_option_value_id` int(11) NOT NULL DEFAULT '0',
		`name` varchar(255) NOT NULL,
		`value` text NOT NULL,
		`type` varchar(32) NOT NULL,
		PRIMARY KEY (`order_option_id`))ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
	}	
	public function saveSettingNewFastOrder($data) {
		$store_id = 0;			
		$code = 'fastorder';					
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '". $store_id ."' AND `code` = '". $code ."'");
		
		foreach ($this->request->post as $key => $value) {
			if (!is_array($value)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '0', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '0', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(json_encode($value)) . "', serialized = '1'");
			}	
		}	
	}
}
?>
