<?php 
class ModelModuleLabelMaker extends Model {
	private $db_column = 'group';

	public function __construct($register) {

		if (!defined('IMODULE_ROOT')) define('IMODULE_ROOT', substr(DIR_APPLICATION, 0, strrpos(DIR_APPLICATION, '/', -2)) . '/');
		if (!defined('IMODULE_SERVER_NAME')) define('IMODULE_SERVER_NAME', substr((defined('HTTP_CATALOG') ? HTTP_CATALOG : HTTP_SERVER), 7, strlen((defined('HTTP_CATALOG') ? HTTP_CATALOG : HTTP_SERVER)) - 8));
		parent::__construct($register);

		$db_column_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting");

		if (isset($db_column_query->row['code'])) {
			$this->db_column = 'code';
		}
	}
	
	public function getSetting($group, $store_id = 0) {
		$data = array(); 
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `" . $this->db_column . "` = '" . $this->db->escape($group) . "'");
		
		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$data[$result['key']] = $result['value'];
			} else {
				$data[$result['key']] = unserialize($result['value']);
			}
		}

		return $data;
	}
	
	public function editSetting($group, $data, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `" . $this->db_column . "` = '" . $this->db->escape($group) . "'");

		foreach ($data as $key => $value) {
			if (!is_array($value)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `" . $this->db_column . "` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `" . $this->db_column . "` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
			}
		}
	}
	
	public function deleteSetting($group, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `" . $this->db_column . "` = '" . $this->db->escape($group) . "'");
	}
	
	public function returnMaxUploadSize($readable = false) {
		$upload = $this->return_bytes(ini_get('upload_max_filesize'));
		$post = $this->return_bytes(ini_get('post_max_size'));
		
		if ($upload >= $post) return $readable ? $this->sizeToString($post - 524288) : $post - 524288;
		else return $readable ? $this->sizeToString($upload) : $upload;
	}
	
	private function return_bytes($val) { //from http://php.net/manual/en/function.ini-get.php
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			// The 'G' modifier is available since PHP 5.1.0
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}
	
		return $val;
	}
	
	private function sizeToString($size) {
		$count = 0;
		for ($i = $size; $i >= 1024; $i /= 1024) $count++;
		switch ($count) {
			case 0 : $suffix = ' B'; break;
			case 1 : $suffix = ' KB'; break;
			case 2 : $suffix = ' MB'; break;
			case 3 : $suffix = ' GB'; break;
			case ($count >= 4) : $suffix = ' TB'; break;
		}
		return round($i, 2).$suffix;
	}
	
	public function cleanFolder($tempDir) {
		if (empty($tempDir)) return false;
		$files = scandir($tempDir);
		foreach ($files as $file) {
			if (!in_array($file, array('.', '..', 'index.html'))) {
				if (is_file($tempDir.'/'.$file)) unlink ($tempDir.'/'.$file);
				if (is_dir($tempDir.'/'.$file)) {
					$this->cleanFolder($tempDir.'/'.$file);	
					rmdir($tempDir.'/'.$file);
				}
			}
		}
	}
	
	public function hex2rgb($hex) { // from http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
		$hex = str_replace("#", "", $hex);
		
		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array('r' => $r, 'g' => $g, 'b' => $b);
		return $rgb; // returns an array with the rgb values
	}

	public function getContrastYIQ($hexcolor){
		$r = hexdec(substr($hexcolor,0,2));
		$g = hexdec(substr($hexcolor,2,2));
		$b = hexdec(substr($hexcolor,4,2));
		$yiq = (($r*299)+($g*587)+($b*114))/1000;
		return ($yiq >= 128) ? 'dark' : 'light';
	}
	
	public function get_label_settings($label_id, $store_id) {
		if (isset($label_id) && isset($store_id)) {
			$label_id = (int)$label_id;
			$store_id = (int)$store_id;
			
			$db_settings = $this->getSetting('labelmaker');
			
			if (!empty($db_settings['LabelMaker'][$store_id]['Labels'][$label_id])) {
				return $db_settings['LabelMaker'][$store_id]['Labels'][$label_id];
			} else {
				return false;
			}
		} else {
			return false;	
		}
	}

	// Clear Cache Per Product
	public function clear_product_image_cache($product_id = 0) {
		$this->cache->delete('labelmaker');

		if (!empty($product_id)) {
			$product_id = (int)$product_id;
			$query  = '(SELECT image FROM ' . DB_PREFIX . 'product p LEFT JOIN ' . DB_PREFIX . 'product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p.product_id = "' . $product_id . '")';
			$query .= 'UNION (SELECT image FROM ' . DB_PREFIX . 'product_image p LEFT JOIN ' . DB_PREFIX . 'product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p.product_id="' . $product_id . '")';

			$images = $this->db->query($query);

			foreach ($images->rows as $result) {
				$image = $result['image'];
				$parts = array_filter(explode('/', $image));
				if (!empty($parts)) {
					$current = DIR_IMAGE . 'cache/';
					while (count($parts) > 1) {
						$folder = array_shift($parts);
						$current .= $folder . '/';
					}
					if (is_dir($current)) {
						$files = scandir($current);
						$current_image = pathinfo(strtolower(array_pop($parts)), PATHINFO_FILENAME);
						foreach ($files as $file) {
							$file = strtolower($file);
							if (in_array($file, array('.', '..'))) continue;
							if (stripos($file, $current_image) !== FALSE && file_exists($current . $file)) {
								@unlink($current . $file);
							}
						}
					}
				}
			}
		}
	}
}
?>