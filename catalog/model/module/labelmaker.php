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

	// Initialize LabelMaker
	public function init($old_image, $new_image, $width, $height) {
		$info = pathinfo($old_image);
		$extension = $info['extension'];

		$LMS = $this->getSetting('labelmaker');

		$store_id = $this->config->get('config_store_id');
		$store_id = (empty($store_id)) ? 0 : $store_id;

		if (!empty($LMS)) {
			$LMS = $LMS['LabelMaker'];
			$LMS = $LMS[$store_id];
		}

		if (!empty($LMS) && $LMS['Enabled'] == 'true' && $LMS['cache_id']) {
			$cache_id = $LMS['cache_id'];
		} else { 
			$cache_id = '0';
		}

		$language_id = $this->model_module_labelmaker->getActiveLanguageID();

		$new_label_image  = $this->generate_name($old_image, $store_id, $language_id, $width, $height, $cache_id, $extension);
		
		$current_cache_id = utf8_substr(utf8_substr($new_label_image, 0, utf8_strrpos($new_label_image, '.')), -5);

		if (file_exists(DIR_IMAGE . $new_label_image) && $current_cache_id == $cache_id) {
			return $new_label_image;
		}
		

		// LabelMaker Enabled
		if (!empty($LMS) && $LMS['Enabled'] == 'true' && !empty($LMS['Labels'])) {
			$store_config = $this->getSetting('config', $this->config->get('config_store_id'));
			$active_labels = array();

			foreach ($LMS['Labels'] as $label_id => $label) {
				// Active Language Label Settings
				$label = $label[$language_id];

				// Size Limit
				$size_limits = array();
				
				if (!empty($label['LimitSize'])) {
					if ($label['LimitSize'] == 'all') {
						$no_size_limit = true;
					} else if ($label['LimitSize'] == 'custom') {
						$no_size_limit = false;
						$size_limits[0] = $label['LimitSizeWidth'];
						$size_limits[1] = $label['LimitSizeHeight'];

					} else {
						$no_size_limit	= false;
						$size_limits	= explode('x', $label['LimitSize']);
					}
				} else {
					$no_size_limit = true;
				}

				// Size Limit Check
				if ($no_size_limit || (!$no_size_limit && ((int)$size_limits[0] == (int)$width && (int)$size_limits[1] == (int)$height))) {

					$extra_conditions = false;

					// Categories
					if (!empty($label['LabelType']) && $label['LabelType'] == 'category') {
						if (!empty($label['LimitCategories']) && $label['LimitCategories'] == 'specific' && !empty($label['LimitCategoriesList'])) {
							$extra_conditions = 'p2c.category_id IN (' . implode(',', $label['LimitCategoriesList']) . ')';
						} else {
							$ondemand = true;
						}
					}
				
					// Specific Products
					if (!empty($label['LabelType']) && $label['LabelType'] == 'specific') {
						if (!empty($label['LimitProducts']) && $label['LimitProducts'] == 'specific' && !empty($label['LimitProductsList'])) {
							$extra_conditions = 'p.product_id IN (' . implode(',', $label['LimitProductsList']) . ')';
						} else {
							$ondemand = true;
						}
					}

					// Manufacturers
					if (!empty($label['LabelType']) && $label['LabelType'] == 'manufacturer') {
						if (!empty($label['LimitManufacturers']) && $label['LimitManufacturers'] == 'specific' && !empty($label['LimitManufacturersList'])) {
							$extra_conditions = 'p.manufacturer_id IN (' . implode(',', $label['LimitManufacturersList']) . ')';
						} else {
							$ondemand = true;
						}
					}

					// Product Types
					if (!empty($label['LabelType']) && $label['LabelType'] == 'product_module' && !empty($label['ProductModules'])) {
						$product_module_ids = array();

						foreach ($label['ProductModules'] as $key => $p) {
							if ($key == 'Bestseller') {
								$product_module_ids = array_merge($product_module_ids, $this->get_bestseller_products((int)$label['ProductModules']['BestsellerLimit']));
							}
							if ($key == 'Latest') {
								$product_module_ids = array_merge($product_module_ids, $this->get_latest_products((int)$label['ProductModules']['LatestLimit']));
							}
							if ($key == 'Special') {
								$product_module_ids = array_merge($product_module_ids, $this->get_special_products());
							}
							// Disabled In OC2
							// if ($key == 'Featured') {
							// 	$product_module_ids = array_merge($product_module_ids, explode(',', $this->config->get('featured_product')));
							// }
						}

						if (!empty($product_module_ids)) {
							$product_module_ids = array_unique($product_module_ids);
							$extra_conditions = 'p.product_id IN (' . implode(',', $product_module_ids) . ')';
						} else {
							$ondemand = true;
						}
					}

					// Special Conditions
					if (!empty($label['LabelType']) && $label['LabelType'] == 'special_condition') {
						$product_special_condition_ids = array();

						if (!empty($label['StockStatus']) && $label['StockStatus'] != 'no_limit') {
							if (empty($product_special_condition_ids)) { 
								$product_special_condition_ids = $this->get_products_by_stock_status($label['StockStatus']);
							}
						}

						if (!empty($label['QuantityType']) && $label['QuantityType'] != 'no_limit') {
							if (empty($product_special_condition_ids)) {
								$product_special_condition_ids = $this->get_products_by_quantity($label['QuantityType'], $label['QuantityLimit']);
							} else {
								$product_special_condition_ids = array_intersect($product_special_condition_ids, $this->get_products_by_quantity($label['QuantityType'], $label['QuantityLimit']));
							}
						}

						if (!empty($label['PriceType']) && $label['PriceType'] != 'no_limit') {
							if (empty($product_special_condition_ids)) {
								$product_special_condition_ids = $this->get_products_by_price($label['PriceType'], $label['PriceLimit']);
							} else {
								$product_special_condition_ids = array_intersect($product_special_condition_ids, $this->get_products_by_price($label['PriceType'], $label['PriceLimit']));
							}
						}

						if (!empty($product_special_condition_ids)) {
							$product_special_condition_ids = array_unique($product_special_condition_ids);
							$extra_conditions = 'p.product_id IN (' . implode(',', $product_special_condition_ids) . ')';
						} else {
							$ondemand = true;
						}
					}

					// DB Query
					if ($extra_conditions != false || !empty($ondemand)) {

						$query = '(SELECT p.image FROM ' . DB_PREFIX . 'product p LEFT JOIN ' . DB_PREFIX . 'product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p.image="' . $old_image . '"' . (!empty($extra_conditions) ? ' AND (' . $extra_conditions . ')' : '') . ')';

						// Additional Images Query
						if (!empty($label['AdditionalImages']) && $label['AdditionalImages'] == '1') {
							$query .= ' UNION (SELECT p.image FROM ' . DB_PREFIX . 'product_image pi LEFT JOIN ' . DB_PREFIX . 'product_to_category p2c ON (pi.product_id = p2c.product_id) LEFT JOIN ' . DB_PREFIX . 'product p ON (p.product_id = pi.product_id) WHERE pi.image="' . $old_image . '"' . (!empty($extra_conditions) ? ' AND (' . $extra_conditions . ')' : '') . ')';
						}

						// Thumbnail Images
						$apply_on_thumbs = true;

						if ((int)$width == (int)$store_config['config_image_additional_width'] && (int)$height == (int)$store_config['config_image_additional_height']) {
							if (empty($label['Thumbs'])) {
								$apply_on_thumbs = false;
							}
						}

						if ($apply_on_thumbs) {
							$inProducts = $this->db->query($query);
						} else {
							$inProducts = false;
						}

						// Active Label
						if ($inProducts && $inProducts->num_rows > 0) {
							$active_labels[] = $label;
						}
					}
				}
			}

			// Apply Labels
			if (!empty($active_labels)) {
				$this->load->library('LabelMaker');

				$LabelMaker = new LabelMaker($old_image);
				$LabelMaker->resize($width, $height);

				foreach ($active_labels as $label) {
					$LabelMaker->label($label);
				}

				$new_image  = $this->generate_name($old_image, $store_id, $language_id, $width, $height, $cache_id, $extension);
				$LabelMaker->save($new_image);
			}
		}

		return $new_image;
	}

	private function generate_name($old_image, $store_id, $language_id, $width, $height, $cache_id, $extension) {
		$new_image_name  = 'cache/' . utf8_substr($old_image, 0, utf8_strrpos($old_image, '.'));
		$new_image_name .= '_' . $store_id . '_' . $language_id . '_' . $width . 'x' . $height . '_' . $cache_id . '.' . $extension;

		return $new_image_name;
	}

	// Product Methods
	private function get_products_by_quantity($quantity_type, $quantity) {
		$quantity = (int)$quantity;

		if ($quantity_type == 'less_than') {
			$operator = '<';
		} else if ($quantity_type == 'more_than') {
			$operator = '>';
		}

		$product_data = $this->cache->get('labelmaker.quantity.' . $quantity_type . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $quantity);

		if (!$product_data) { 
			$product_data = array();

			$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p.quantity " . $operator . " " . (int)$quantity);

			foreach ($query->rows as $result) { 		
				$product_data[] = $result['product_id'];
			}

			$this->cache->set('labelmaker.quantity.' . $quantity_type . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'). '.' . $quantity, $product_data);
		}

		return $product_data;
	}

	private function get_products_by_stock_status($stock_status) {
		$stock_status = (int)$stock_status;

		$product_data = $this->cache->get('labelmaker.stock_status.' . $stock_status . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $stock_status);

		if (!$product_data) { 
			$product_data = array();

			$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p.stock_status_id = " . (int)$stock_status);

			foreach ($query->rows as $result) { 		
				$product_data[] = $result['product_id'];
			}

			$this->cache->set('labelmaker.stock_status.' . $stock_status . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'). '.' . $stock_status, $product_data);
		}

		return $product_data;
	}

	private function get_products_by_price($price_type, $price) {
		$price = (int)$price;

		if ($price_type == 'less_than') {
			$operator = '<';
		} else if ($price_type == 'more_than') {
			$operator = '>';
		}

		$product_data = $this->cache->get('labelmaker.price_' . $price_type . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $price);

		if (!$product_data) { 
			$product_data = array();

			$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p.price " . $operator . " " . (int)$price);

			foreach ($query->rows as $result) { 		
				$product_data[] = $result['product_id'];
			}

			$this->cache->set('labelmaker.price_' . $price_type . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'). '.' . $price, $product_data);
		}

		return $product_data;
	}

	private function get_bestseller_products($limit = 10) {
		$product_data = $this->cache->get('labelmaker.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$product_data) {
			$product_data = array();

			$query = $this->db->query("SELECT op.product_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$product_data[] = $result['product_id'];
			}

			$this->cache->set('labelmaker.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
		}

		return $product_data;
	}

	private function get_latest_products($limit = 10) {
		$product_data = $this->cache->get('labelmaker.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$product_data) {
			$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$product_data[] = $result['product_id'];
			}

			$this->cache->set('labelmaker.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
		}

		return $product_data;
	}

	private function get_special_products() {
		$data = array(
			'sort'  => 'pd.name',
			'order' => 'ASC'
		);

		$product_data = $this->cache->get('labelmaker.special.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id'));

		if (!$product_data) {

			$sql = "SELECT DISTINCT ps.product_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id";

			$sort_data = array(
				'pd.name',
				'p.model',
				'ps.price',
				'rating',
				'p.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
					$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
				} else {
					$sql .= " ORDER BY " . $data['sort'];
				}
			} else {
				$sql .= " ORDER BY p.sort_order";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC, LCASE(pd.name) DESC";
			} else {
				$sql .= " ASC, LCASE(pd.name) ASC";
			}

			$product_data = array();

			$query = $this->db->query($sql);

			foreach ($query->rows as $result) {
				$product_data[] = $result['product_id'];
			}

			$this->cache->set('labelmaker.special.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id'), $product_data);
		} 

		return $product_data;
	}

	public function getActiveLanguageID() {
		$language_code = $this->session->data['language'];

		$query = $this->db->query("SELECT language_id FROM " . DB_PREFIX . "language WHERE code = '" . $language_code . "'");

		if (isset($query->row['language_id'])) {
			return $query->row['language_id'];
		} else {
			return '';
		}
	}
}
?>