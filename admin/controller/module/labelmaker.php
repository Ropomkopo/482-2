<?php
class ControllerModuleLabelMaker extends Controller {
	private $data = array();
	private $error = array();

	private $mime_types = array("image/bmp","image/cis-cod","image/gif","image/png","image/ief","image/jpeg","image/pipeg","image/svg+xml","image/tiff","image/x-cmu-raster","image/x-cmx","image/x-icon","image/x-portable-anymap","image/x-portable-bitmap","image/x-portable-graymap","image/x-portable-pixmap","image/x-rgb","image/x-xbitmap","image/x-xpixmap","image/x-xwindowdump");

	// Such Events
	private $module_events = array(
		'post.admin.add.product' 	=> 'module/labelmaker/clear_product_image_cache',
		'post.admin.edit.product' 	=> 'module/labelmaker/clear_product_image_cache',
		'pre.admin.delete.product' 	=> 'module/labelmaker/clear_product_image_cache',
		'post.admin.delete.product' => 'module/labelmaker/clear_product_image_cache'
	);

	public function install() {
		// Register Events
		if (file_exists(DIR_APPLICATION . 'model/tool/event.php')) {
			$this->load->model('tool/event');
			// Event codes are numbered because the 'code' field is limited to 32 chars, which is so insufficient
			$i = 0; foreach ($this->module_events as $event => $event_trigger) {
				$this->model_tool_event->addEvent('labelmaker_' . $i, $event, $event_trigger);
			$i++; }

		} else if (file_exists(DIR_APPLICATION . 'model/extension/event.php')) {
			$this->load->model('extension/event');

			$i = 0; foreach ($this->module_events as $event => $event_trigger) {
				$this->model_extension_event->addEvent('labelmaker_' . $i, $event, $event_trigger);
			$i++; }
		}
	}

	public function uninstall() {
		// Remove Events
		if (file_exists(DIR_APPLICATION . 'model/tool/event.php')) {
			$this->load->model('tool/event');

			$i = 0; foreach ($this->module_events as $event => $event_trigger) {
				$this->model_tool_event->deleteEvent('labelmaker_' . $i);
			$i++; }
		} else if (file_exists(DIR_APPLICATION . 'model/extension/event.php')) {
			$this->load->model('extension/event');

			$i = 0; foreach ($this->module_events as $event => $event_trigger) {
				$this->model_extension_event->deleteEvent('labelmaker_' . $i);
			$i++; }
		}
	}

	private function load_static_template_data() {
		$this->load->language('module/labelmaker');
		
		$this->data['token'] = $this->session->data['token'];

		// Set language data
		$variables = array(
			'heading_title',
			'text_enabled',
			'text_disabled',
			'text_content_top',
			'text_content_bottom',
			'text_column_left',
			'text_column_right',
			'text_activate',
			'text_not_activated',
			'text_click_activate',
			'entry_code',
			'button_save',
			'button_cancel',
			'entry_type',
			'text_type_image',
			'text_type_text',
			'entry_image',
			'text_max_size',
			'text_max_size_learn',
			'text_top_left',
			'text_top_right',
			'text_center',
			'text_bottom_left',
			'text_bottom_right',
			'entry_position',
			'entry_opacity',
			'entry_text',
			'entry_current_image',
			'text_cache_delete_warning',
			'entry_image_opacity',
			'entry_text_color',
			'text_default',
			'entry_label_image_limit',
			'entry_all_images',
			'entry_bigger_than',
			'entry_smaller_than',
			'entry_font',
			'entry_font_size',
			'entry_label_image_limit_categories',
			'entry_all_categories',
			'entry_following_categories',
			'entry_label_image_limit_products',
			'entry_all_products',
			'entry_following_products',
			'entry_rotation'
		);
		
		foreach ($variables as $variable) $this->data[$variable] = $this->language->get($variable);

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = false;
		}

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = false;
		}

		$this->load->model('module/labelmaker');
		
		$this->data['maxSize'] = $this->model_module_labelmaker->returnMaxUploadSize();
		$this->data['maxSizeReadable'] = $this->model_module_labelmaker->returnMaxUploadSize(true);
		
		$this->data['error_code'] = isset($this->error['code']) ? $this->error['code'] : '';
		
		$this->data['fonts'] = array();
		
		$fontsFolder = IMODULE_ROOT.'vendors/labelmaker/font/';
		
		if (is_dir($fontsFolder)) {
			$fontsFolderFiles = $this->scan_dir($fontsFolder);
			foreach ($fontsFolderFiles as $font) {
				if (substr($font, strripos($font, '.ttf')) == '.ttf') {
					$this->data['fonts'][] = $font;	
				}
			}
		}
		
		// Uploaded and built-in images.
		$this->data['uploaded_images'] = array();
		$this->data['builtin_images'] = array();
		
		$uploadedImagesFolder = IMODULE_ROOT.'vendors/labelmaker/uploaded_images/';
		$builtInImagesFolder = IMODULE_ROOT.'vendors/labelmaker/builtin_images/';

		$this->load->library('labelmaker/colorsofimage');

		// Uploaded 
		if (is_dir($uploadedImagesFolder)) {
			$uploaded_images = $this->scan_dir($uploadedImagesFolder);
			foreach ($uploaded_images as $uploaded_image) {
				if ($this->is_image(IMODULE_ROOT.'vendors/labelmaker/uploaded_images/' . $uploaded_image)) {
					list($width, $height) = getimagesize(IMODULE_ROOT.'vendors/labelmaker/uploaded_images/'.$uploaded_image);

					// Check Overall Color Contrast
					$src = ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) ? HTTPS_CATALOG : HTTP_CATALOG) .'vendors/labelmaker/uploaded_images/' . $uploaded_image;
					$image = new ColorsOfImage(IMODULE_ROOT . 'vendors/labelmaker/uploaded_images/'.$uploaded_image, 5, 1);

					$color = $image->getProminentColors();
					$color = is_array($color) && !empty($color) ? $color[0] : $color;
					$color = empty($color) ? 'ffffff' : str_replace('#', '', $color);
					$type  = $this->model_module_labelmaker->getContrastYIQ($color);

					$this->data['uploaded_images'][] = array(
						'path'			=>	'vendors/labelmaker/uploaded_images/' . $uploaded_image,
						'src'			=>	$src,
						'name'			=>  $uploaded_image,
						'dimensions'	=>	array('width' => $width, 'height' => $height),
						'type'			=>	$type
					);
				}
			}
		}
		
		// Built-in
		if (is_dir($builtInImagesFolder)) {
			$builtin_images = $this->scan_dir($builtInImagesFolder);
			foreach ($builtin_images as $builtin_image) {
				if ($this->is_image(IMODULE_ROOT.'vendors/labelmaker/builtin_images/' . $builtin_image)) {
					list($width, $height) = getimagesize(IMODULE_ROOT.'vendors/labelmaker/builtin_images/'.$builtin_image);
					
					// Check Overall Color Contrast
					$src = ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) ? HTTPS_CATALOG : HTTP_CATALOG) .'vendors/labelmaker/builtin_images/' . $builtin_image;
					$image = new ColorsOfImage(IMODULE_ROOT . 'vendors/labelmaker/builtin_images/'.$builtin_image, 5, 1);
					$color = $image->getProminentColors();
					$color = is_array($color) && !empty($color) ? $color[0] : $color;
					$color = empty($color) ? 'ffffff' : str_replace('#', '', $color);
					$type  = $this->model_module_labelmaker->getContrastYIQ($color);

					$this->data['builtin_images'][] = array(
						'path'			=>	'vendors/labelmaker/builtin_images/' . $builtin_image,
						'src'			=>	$src,
						'name'			=>  $builtin_image,
						'dimensions'	=>	array('width' => $width, 'height' => $height),
						'type'			=>	$type
					);
				}
			}
		}

		// Languages
		$this->load->model('localisation/language');

		$this->data['languages'] = array();

		$results = $this->model_localisation_language->getLanguages();
		
		foreach ($results as $result) {
			if ((int)$result['status'] == 1) {

				if (file_exists(DIR_APPLICATION . 'view/image/flags/' . $result['image'])) {
					if ($this->is_image(DIR_APPLICATION . 'view/image/flags/' . $result['image'])) {
						$flag = ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) ? HTTPS_SERVER : HTTP_SERVER) . 'view/image/flags/' . $result['image'];
					} else {
						$flag = false;
					}
				} else {
					$flag = false;
				}

				$this->data['languages'][] = array(
					'language_id'	=> $result['language_id'],
					'name'			=> $result['name'],
					'flag'			=> $flag	
				);
			}
		}

		// Stock Statuses
		$this->load->model('localisation/stock_status');

		$this->data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		$this->data['CATALOG_URL'] = (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) ? HTTPS_CATALOG : HTTP_CATALOG;
	}
	
	public function get_label_image_settings() {
		/* Load static template data */
		$this->load_static_template_data();
		
		/* Get current IDs */
		$store_id		= 	$this->request->get['active_store_id'];
		$label_count	= 	$this->request->get['label_count'];

		// Store Image sizes
		$this->load->model('setting/setting');
		
		$this->data['store']['store_info'] = $this->model_setting_setting->getSetting('config', $store_id);

		$this->data['store']['store_id'] = $store_id;
		$this->data['label_id'] 		 = $label_count;
	
		$this->response->setOutput($this->load->view('module/labelmaker/label_image_settings.tpl', $this->data));
	}
	
	public function index() {
		/* Load static template data */
		$this->load_static_template_data();
		
		/* Generate default index */
		$this->document->setTitle($this->language->get('heading_title'));
		
		/* jQuery UI */
		$this->document->addScript('view/javascript/labelmaker/jquery-ui/jquery-ui.min.js');
		$this->document->addStyle('view/javascript/labelmaker/jquery-ui/jquery-ui.min.css');
		
		/* Bootstrap Form Helpers */
		$this->document->addScript('view/javascript/labelmaker/bootstrap/js/bootstrap-formhelpers-colorpicker.js');
		$this->document->addScript('view/javascript/labelmaker/bootstrap/js/bootstrap-formhelpers-selectbox.js');
		
		/* jQuery Rotate */
		$this->document->addScript('view/javascript/labelmaker/jquery.ui.rotatable.min.js');
		
		/* jQuery File Upload Plugin */
		$this->document->addScript('view/javascript/labelmaker/jquery-fileupload/jquery.ui.widget.js');
		$this->document->addScript('view/javascript/labelmaker/jquery-fileupload/jquery.iframe-transport.js');
		$this->document->addScript('view/javascript/labelmaker/jquery-fileupload/jquery.postmessage-transport.js');
		$this->document->addScript('view/javascript/labelmaker/jquery-fileupload/jquery.xdr-transport.js');
		$this->document->addScript('view/javascript/labelmaker/jquery-fileupload/jquery.fileupload.js');

		/* NProgress */
		$this->document->addScript('view/javascript/labelmaker/nprogress/nprogress.js');

		/* LabelMaker */
		$this->document->addStyle('view/stylesheet/labelmaker.css');
		
		/* Permissions and compatibility checks */
		$this->warning_check();
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->user->hasPermission('modify', 'module/labelmaker')) {
				$this->session->data['flash_error'][] = $this->language->get('error_permission');
				$this->response->redirect($this->url->link('module/labelmaker', 'token=' . $this->session->data['token'], 'SSL'));
			}

			if (!empty($_POST['OaXRyb1BhY2sgLSBDb21'])) {
                $this->request->post['labelmaker']['LicensedOn'] = $_POST['OaXRyb1BhY2sgLSBDb21'];
            }

            if (!empty($_POST['cHRpbWl6YXRpb24ef4fe'])) {
                $this->request->post['labelmaker']['License'] = json_decode(base64_decode($_POST['cHRpbWl6YXRpb24ef4fe']), true);
            } 
			
			// Clear cache
			$this->model_module_labelmaker->cleanFolder(DIR_IMAGE . 'cache');
			$this->cache->delete('labelmaker');

			if (file_exists(DIR_SYSTEM . 'nitro/config.php')) { // Clear NitroPack Cache
				$this->load->model('tool/nitro');
				$this->model_tool_nitro->clearPageCache();
			}

			if (!empty($this->request->post['LabelMaker'])) {
				foreach ($this->request->post['LabelMaker'] as $k => $store_id) {
					$this->request->post['LabelMaker'][$k]['cache_id'] = substr(md5(uniqid(rand(), true)), 0, 5);
				}
			}

			// Data validation
			$this->validate();

			if ($this->user->hasPermission('modify', 'module/labelmaker')) {
				$this->model_module_labelmaker->editSetting('labelmaker', $this->request->post);
				$this->session->data['flash_success'][] = $this->language->get('text_success');
				$this->response->redirect($this->url->link('module/labelmaker', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

  		$this->data['breadcrumbs'] = array(
			array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			),
			array(
				'text'      => $this->language->get('text_module'),
				'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			),
			array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('module/labelmaker', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			)
		);
		
		$this->data['action'] = $this->url->link('module/labelmaker', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['LabelMaker'])) {
			foreach ($this->request->post['LabelMaker'] as $key => $value) {
				$this->data['data']['LabelMaker'][$key] = $this->request->post['LabelMaker'][$key];
			}
		} else {
			$configValue = $this->model_module_labelmaker->getSetting('labelmaker');
			$this->data['data'] = $configValue;
		}
		
		// Stores 
		$this->load->model('setting/store');
		
		$stores = array_merge(array
			(0 => array(
				'store_id' => '0',
				'name' => $this->config->get('config_name') . ' (' .$this->data['text_default'] . ')',
				'url' => NULL, 'ssl' => NULL)
			),
			$this->model_setting_store->getStores()
		);
		
		$this->data['stores'] = $stores;

		// Languages
		$this->load->model('localisation/language');

		$languages = array();
		$this->data['store_languages'] = array();

		$results = $this->model_localisation_language->getLanguages();
		
		foreach ($results as $result) {
			if ((int)$result['status'] == 1) {

				if (file_exists(DIR_APPLICATION . 'view/image/flags/' . $result['image'])) {
					if ($this->is_image(DIR_APPLICATION . 'view/image/flags/' . $result['image'])) {
						$flag = ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) ? HTTPS_SERVER : HTTP_SERVER) . 'view/image/flags/' . $result['image'];
					} else {
						$flag = false;
					}
				} else {
					$flag = false;
				}

				$languages[] = array(
					'language_id'	=> $result['language_id'],
					'name'			=> $result['name'],
					'flag'			=> $flag	
				);
			}
		}

		$this->data['store_languages'] = $languages;

		// Categories
		$this->load->model('catalog/category');
		$categories = array();
		
		$this->data['product_categories'] = array();
		
		foreach ($stores as $store) {
			if (!empty($this->data['data']['LabelMaker']) && !empty($this->data['data']['LabelMaker'][$store['store_id']]['Labels'])) {
				foreach ($this->data['data']['LabelMaker'][$store['store_id']]['Labels'] as $label_id => $label) {
					foreach ($languages as $language) {
						if (!empty($this->data['data']['LabelMaker'][$store['store_id']]['Labels'][$label_id][$language['language_id']]['LimitCategoriesList'])) {
							$categories = $this->data['data']['LabelMaker'][$store['store_id']]['Labels'][$label_id][$language['language_id']]['LimitCategoriesList'];
						} else {
							$categories = array();
						}
						
						$this->data['product_categories'][$store['store_id']]['Labels'][$label_id][$language['language_id']] = array();
						
						foreach ($categories as $category_id) {
							
							$category_info = $this->model_catalog_category->getCategory($category_id);
							
							if ($category_info) {
								$this->data['product_categories'][$store['store_id']]['Labels'][$label_id][$language['language_id']][] = array(
									'category_id' 	=> $category_info['category_id'],
									'name'        	=> version_compare(VERSION, '1.5.4.1', '<=') ? ($this->model_catalog_category->getPath($category_id)) : (($category_info['path'] ? $category_info['path'] . ' &gt; ' : '') . $category_info['name'])
								);
							}
						}
					}
				}
			}
		}
		
		// Products
		$this->load->model('catalog/product');
		$products = array();
		
		$this->data['products'] = array();
		
		foreach ($stores as $store) {
			if (!empty($this->data['data']['LabelMaker']) && !empty($this->data['data']['LabelMaker'][$store['store_id']]['Labels'])) {
				foreach ($this->data['data']['LabelMaker'][$store['store_id']]['Labels'] as $label_id => $label) {
					foreach ($languages as $language) {
						if (!empty($this->data['data']['LabelMaker'][$store['store_id']]['Labels'][$label_id][$language['language_id']]['LimitProductsList'])) {
							$products = $this->data['data']['LabelMaker'][$store['store_id']]['Labels'][$label_id][$language['language_id']]['LimitProductsList'];
						} else {
							$products = array();
						}
						
						$this->data['products'][$store['store_id']]['Labels'][$label_id][$language['language_id']] = array();
						
						foreach ($products as $product_id) {
		
							$product_info = $this->model_catalog_product->getProduct($product_id);
							
							if ($product_info) {
								$this->data['products'][$store['store_id']]['Labels'][$label_id][$language['language_id']][] = array(
									'product_id' 	=> $product_info['product_id'],
									'name'        	=> $product_info['name']
								);
							}
						}
					}
				}
			}
		}

		// Manufacturers
		$this->load->model('catalog/manufacturer');
		$manufacturers = array();
		
		$this->data['product_manufacturers'] = array();
		
		foreach ($stores as $store) {
			if (!empty($this->data['data']['LabelMaker']) && !empty($this->data['data']['LabelMaker'][$store['store_id']]['Labels'])) {
				foreach ($this->data['data']['LabelMaker'][$store['store_id']]['Labels'] as $label_id => $label) {
					foreach ($languages as $language) {
						if (!empty($this->data['data']['LabelMaker'][$store['store_id']]['Labels'][$label_id][$language['language_id']]['LimitManufacturersList'])) {
							$manufacturers = $this->data['data']['LabelMaker'][$store['store_id']]['Labels'][$label_id][$language['language_id']]['LimitManufacturersList'];
						} else {
							$manufacturers = array();
						}
						
						$this->data['product_manufacturers'][$store['store_id']]['Labels'][$label_id][$language['language_id']] = array();
						
						foreach ($manufacturers as $manufacturer_id) {
							
							$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);
							
							if ($manufacturer_info) {
								$this->data['product_manufacturers'][$store['store_id']]['Labels'][$label_id][$language['language_id']][] = array(
									'manufacturer_id' 	=> $manufacturer_info['manufacturer_id'],
									'name'        		=> $manufacturer_info['name']
								);
							}
						}
					}
				}
			}
		}

		// Store Image sizes
		$this->load->model('setting/setting');
		
		foreach ($this->data['stores'] as $k => $store) {
			$this->data['stores'][$k]['store_info'] = $this->model_setting_setting->getSetting('config', $store['store_id']);
		}

		// Google Web Fonts
		if (ini_get('allow_url_fopen')) {
			$this->data['allow_url_fopen'] = true;
			$google_webfonts = $this->fetch_remote_content('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDhgTJGW8vHgey8J3FtHr1TV6c-_OipNRk');
			$this->data['google_webfonts'] = json_decode($google_webfonts, true);
		} else {
			$this->data['allow_url_fopen'] = false;
			$this->data['google_webfonts'] = false;
		}
		
		$this->data['header'] 		= $this->load->controller('common/header');
		$this->data['column_left'] 	= $this->load->controller('common/column_left');
		$this->data['footer'] 		= $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/labelmaker.tpl', $this->data));
	}

	private function warning_check() {
		$default_dirs = array('uploaded_images','builtin_images','font');

		foreach ($default_dirs as $dir) {
			if (!file_exists(IMODULE_ROOT . 'vendors/labelmaker/' . $dir)) {
				mkdir(IMODULE_ROOT . 'vendors/labelmaker/' . $dir, 0777, true);
			}
		}
		
		$this->data['warning_modal'] = false;
		$labelmaker_dirs = $this->scan_dir(IMODULE_ROOT . 'vendors/labelmaker');

		foreach ($labelmaker_dirs as $dir) {
			if (!is_readable(IMODULE_ROOT . 'vendors/labelmaker/' . $dir)) {
				$this->data['warning_modal']['errors'][] = 'No read permissions for <b>' . '/vendors/labelmaker/' . $dir . '</b>';
			}
			if (!is_writable(IMODULE_ROOT . 'vendors/labelmaker/' . $dir)) {
				$this->data['warning_modal']['errors'][] = 'No write permissions for <b>' . '/vendors/labelmaker/' . $dir . '</b>';
			}
		}
	}

	private function validate() {
		foreach ($this->request->post['LabelMaker'] as $store_id => $store) {
			if (!empty($store['Enabled']) && $store['Enabled'] == 'true' && !empty($store['Labels'])) {
				foreach ($store['Labels'] as $label_id => $label) {
					// Check if layer images exist
					if (!empty($label['layers'])) {
						foreach ($label['layers'] as $layer) {
							if (!file_exists(IMODULE_ROOT . $layer['image'])) {
								$this->session->data['flash_error'][] = 'Warning: Image layer <b>' . $layer['image'] . '</b> no longer exists!';
							}
						}

						// Check opacity
						if (!isset($label['Opacity']) || !ctype_digit($label['Opacity']) || (int)$label['Opacity'] < 0 || (int)$label['Opacity'] > 100) {
							$this->session->data['flash_error']['Opacity'] = $this->language->get('error_invalid_opacity');
						}
					}
				}
			}
		}

		if (!empty($this->session->data['flash_error'])) {
			$this->response->redirect($this->url->link('module/labelmaker', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	
	public function autocomplete_category() {
		$json = array();
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/category');
			
			if (version_compare(VERSION, '1.5.2.1', '>')) {
				$data = array(
					'filter_name' => $this->request->get['filter_name'],
					'start'       => 0,
					'limit'       => 20
				);
			} else {
				$data = 0;
			}
			
			$results = $this->model_catalog_category->getCategories($data);
				
			foreach ($results as $result) {
				if (version_compare(VERSION, '1.5.2.1', '<=')) {
					if (stripos($result['name'], $this->request->get['filter_name']) === false) continue;
				}
				
				$json[] = array(
					'category_id' => $result['category_id'], 
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}		
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function autocomplete_product() {
		$json = array();
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])) {
			$this->load->model('catalog/product');
			$this->load->model('catalog/option');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
			
			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);
			
			$results = $this->model_catalog_product->getProducts($data);
			
			foreach ($results as $result) {
				
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),	
					'model'      => $result['model'],
					'price'      => $result['price']
				);	
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete_manufacturer() {
		$json = array();
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/manufacturer');
			
			if (version_compare(VERSION, '1.5.2.1', '>')) {
				$data = array(
					'filter_name' => $this->request->get['filter_name'],
					'start'       => 0,
					'limit'       => 20
				);
			} else {
				$data = 0;
			}
			
			$results = $this->model_catalog_manufacturer->getManufacturers($data);
				
			foreach ($results as $result) {
				if (version_compare(VERSION, '1.5.2.1', '<=')) {
					if (stripos($result['name'], $this->request->get['filter_name']) === false) continue;
				}

				$json[] = array(
					'manufacturer_id' => $result['manufacturer_id'], 
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}		
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function upload_image() {
		$json = array();
		$this->load->language('module/labelmaker');

		if (!$this->user->hasPermission('modify', 'module/labelmaker')) {
			$json['error'] = $this->language->get('error_permission');

			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		} else {
			$this->load->model('module/labelmaker');
			$this->load->library('LabelMakerUploadHandler');
			
			$file_upload_options = array(
				'upload_dir'	=> IMODULE_ROOT . 'vendors/labelmaker/uploaded_images/',
				'upload_url'	=> ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) ? HTTPS_CATALOG : HTTP_CATALOG)  . 'vendors/labelmaker/uploaded_images/',
				'param_name'	=> $this->request->get['upload_param'],
				'max_file_size'	=> $this->model_module_labelmaker->returnMaxUploadSize()
			);

			$upload_handler = new UploadHandler($file_upload_options);
		}
	}
	
	public function download_webfont() {
		$json = array();
		$this->load->language('module/labelmaker');

		if (!$this->user->hasPermission('modify', 'module/labelmaker')) {
			$json['error'] = $this->language->get('error_permission');
		}	
		
		if (!isset($json['error'])) {

			$this->load->model('module/labelmaker');
			
			if (isset($this->request->get['key_entry'])) {
				$key_entry = $this->request->get['key_entry'];
			} else {
				exit;
			}

			$fontsFolder = IMODULE_ROOT.'vendors/labelmaker/font/';
		
			if (ini_get('allow_url_fopen')) {
				$json['allow_url_fopen'] = true;
				$google_webfonts = $this->fetch_remote_content('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDhgTJGW8vHgey8J3FtHr1TV6c-_OipNRk');
				$google_webfonts = json_decode($google_webfonts, true);
				
				$google_webfont = $google_webfonts['items'][$key_entry];
				
				foreach ($google_webfont['files'] as $k => $google_webfont_file) {
					$new_font_file_name	= $google_webfont['family'] . ' ' . ucfirst($k) . '.ttf';
					$new_font_file		= file_get_contents($google_webfont_file);
					
					file_put_contents($fontsFolder . $new_font_file_name, $new_font_file);
				}
				
				// Refresh font list
				if (is_dir($fontsFolder)) {
					$fontsFolderFiles = $this->scan_dir($fontsFolder);
					foreach ($fontsFolderFiles as $font) {
						if (substr($font, strripos($font, '.ttf')) == '.ttf') {
							$json['fonts'][] = $font;	
						}
					}
				}
			} else {
				$json['allow_url_fopen'] = false;
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function delete_image($image = false) {
		$json = array();
		$this->load->language('module/labelmaker');

		if (!$this->user->hasPermission('modify', 'module/labelmaker')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['image'])) {
				$image = $this->request->get['image'];
			} else {
				exit;	
			}
			
			$this->load->model('module/labelmaker');
			if (file_exists(IMODULE_ROOT . 'vendors/labelmaker/uploaded_images/' . $image)) {
				@unlink(IMODULE_ROOT . 'vendors/labelmaker/uploaded_images/' . $image);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function load_uploaded_images() {

		$this->load->model('module/labelmaker');
		$this->load->library('labelmaker/colorsofimage');
		
		if (isset($this->request->get['store_id'])) {
			$this->data['store']['store_id'] = $this->request->get['store_id'];
		} else {
			exit;	
		}
		
		if (isset($this->request->get['label_id'])) {
			$this->data['label_id'] = $this->request->get['label_id'];	
		} else {
			exit;	
		}

		if (isset($this->request->get['language_id'])) {
			$this->data['language']['language_id'] = $this->request->get['language_id'];	
		} else {
			exit;	
		}

		$this->data['_id'] = 'store_' . $this->request->get['store_id'] . '_label_' . $this->request->get['label_id'] . '_language_' . $this->request->get['language_id'];
		
		$uploadedImagesFolder = IMODULE_ROOT . 'vendors/labelmaker/uploaded_images/';
		$uploaded_images = $this->scan_dir($uploadedImagesFolder);
		
		foreach ($uploaded_images as $uploaded_image) {
			if ($this->is_image(IMODULE_ROOT.'vendors/labelmaker/uploaded_images/' . $uploaded_image)) {
				list($width, $height) = getimagesize(IMODULE_ROOT.'vendors/labelmaker/uploaded_images/' . $uploaded_image);

				// Check Overall Color Contrast
				$src = ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) ? HTTPS_CATALOG : HTTP_CATALOG)  . 'vendors/labelmaker/uploaded_images/' . $uploaded_image;
				$image = new ColorsOfImage(IMODULE_ROOT . 'vendors/labelmaker/uploaded_images/' . $uploaded_image, 5, 1);
				$color = $image->getProminentColors();
				$color = is_array($color) && !empty($color) ? $color[0] : $color;
				$color = empty($color) ? 'ffffff' : str_replace('#', '', $color);
				$type  = $this->model_module_labelmaker->getContrastYIQ($color);

				$this->data['images'][] = array(
					'path'			=>	'vendors/labelmaker/uploaded_images/' . $uploaded_image,
					'src'			=>	$src,
					'name'			=>  $uploaded_image,
					'dimensions'	=>	array('width' => $width, 'height' => $height),
					'type'			=>	$type
				);
			}
		}
		
		if (!empty($this->data['images'])) {
			$this->response->setOutput($this->load->view('module/labelmaker/images_loop.tpl', $this->data));
		} else {
			$this->response->setOutput('<span> No uploaded images.<br /> Use the upload form below<br /> or put your images in this server directory<br /> <b>/vendors/labelmaker/uploaded_images</b> </span>');
		}
	}
	
	
	public function load_uploaded_fonts() {
		$this->load->model('module/labelmaker');
		
		if (isset($this->request->get['store_id'])) {
			$this->data['store']['store_id'] = $this->request->get['store_id'];
		} else {
			exit;	
		}
		
		if (isset($this->request->get['label_id'])) {
			$this->data['label_id'] = $this->request->get['label_id'];	
		} else {
			exit;	
		}

		if (isset($this->request->get['language_id'])) {
			$this->data['language']['language_id'] = $this->request->get['language_id'];	
		} else {
			exit;	
		}
		
		$fontsFolder = IMODULE_ROOT.'vendors/labelmaker/font/';
		
		$this->data['fonts'] = array();
		
		// Refresh font list
		if (is_dir($fontsFolder)) {
			$fontsFolderFiles = scandir($fontsFolder);
			foreach ($fontsFolderFiles as $font) {
				if (substr($font, strripos($font, '.ttf')) == '.ttf') {
					$this->data['fonts'][] = $font;	
				}
			}
		}
			
		if (!empty($this->data['fonts'])) {
			$this->response->setOutput($this->load->view('module/labelmaker/fonts_loop.tpl', $this->data));
		} else {
			$this->response->setOutput('<span class="info-text">No font files found in <b>/vendors/labelmaker/font/</b></span>');
		}
	}
	
	public function generate_font_image() {
		$json = array();

		$this->load->language('module/labelmaker');
		$this->load->model('module/labelmaker');
		
		
		if (!$this->user->hasPermission('modify', 'module/labelmaker')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (!empty($this->request->get['text'])) {
				$text = $this->request->get['text'];
				if (strlen($text) > 50) {
					$json['error']	=	"Error: Text limit is 50 characters";	
				}
			} else {
				$json['error']	=	"Error: Please enter text";
			}
			
			if (!empty($this->request->get['font_size'])) {
				$font_size = (int)$this->request->get['font_size'];
				if ($font_size < 8 || $font_size > 100) {
					$json['error']	=	"Error: Font size must be between 8px and 100px";
				}
			} else {
				$json['error']	=	"Error: Font size is required";
			}
			
			if (!empty($this->request->get['color'])) {
				$color = $this->request->get['color'];
			} else {
				$json['error']	=	"Error: Color is required";
			}
			
			if (!empty($this->request->get['font_family'])) {
				$font_family = $this->request->get['font_family'];
				
				$fontsFolder = IMODULE_ROOT.'vendors/labelmaker/font/';
				$font = $fontsFolder . $font_family;
				
				if (!file_exists($font)) {
					$json['error']	=	"Error: Font family does not exist";
				}
			} else {
				$json['error']	=	"Error: Font family is required";
			}
		}

		if (file_exists($font) && !isset($json['error'])) {
			// Get required size
			$size = imagettfbbox($font_size, 0, $font, $text);
			$xsize = abs($size[0]) + abs($size[2]);
			$ysize = abs($size[5]) + abs($size[1]);
		
			// Generate text image
			$image = imagecreatetruecolor($xsize+6, $ysize+6);
			imagesavealpha($image, true);
			imagealphablending($image, true);
			$white = imagecolorallocatealpha($image, 255, 255, 255, 127);
			imagefill($image, 0, 0, $white);
		
			$rgb_color = $this->model_module_labelmaker->hex2rgb($color);
			$color	= imagecolorallocate($image, $rgb_color['r'], $rgb_color['g'], $rgb_color['b']);
			
			imagettftext($image, $font_size, 0, abs($size[0]), abs($size[5]), $color, $font, $text);
			
			$text  	   = $this->clean_filename($text);
			$filename  = IMODULE_ROOT . 'vendors/labelmaker/uploaded_images/' . $text . '_';
			$filename .= $font_size . '_';
			$filename .= strtolower(substr($font_family,0,-4)) . '_';
			$filename .= str_replace('#', '', $this->request->get['color']);
			$filename  = str_replace(' ', '_', $filename);
			$filename .= '.png';

			// Output
			$this->response->addHeader('Content-type: image/png');
			$this->response->setOutput(imagepng($image, $filename, 9, PNG_ALL_FILTERS));
			imagedestroy($image);
		} else {
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}
	
	private function scan_dir($dir) {
		$ignored = array('.', '..');
	
		$files = array();
		
		foreach (scandir($dir) as $file) {
			if (!in_array($file, $ignored)) {
				$files[$file] = filemtime($dir . '/' . $file);
			}
		}
	
		arsort($files);
		$files = array_keys($files);

		return ($files) ? $files : array();
	}
	
	private function clean_filename($name) {
		$filename = preg_replace("([^\w\s\d\-_~,;:\[\]\(\].]|[\.]{2,})", '', $name);

		if (function_exists('mb_convert_encoding')) { 
			$filename = mb_convert_encoding($filename, 'UTF-8');
		} else {
			$filename = urlencode($filename);
		}

		$filename = preg_replace("([^\w\s\d\-_~,;:\[\]\(\].]|[\.]{2,})", '', $filename);
		
		return $filename;	
	}
	
	private	function fetch_remote_content($url) {
		if (strpos($url, '//') === 0) {
			if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
				$url = 'https:'.$url;
			} else {
				$url = 'http:'.$url;
			}
		}
		
		if (ini_get('allow_url_fopen')) {
			$content = file_get_contents($url);
			return $content;
		} else {
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_ENCODING, "");
			$content = curl_exec($ch);
			curl_close($ch);
			return $content;
		}
		return false;
	}

	private function is_image($path) {
	    $a = getimagesize($path);

		if ($a !== false && !empty($a['mime']) && in_array($a['mime'] , $this->mime_types)) {
			return true;
		}

	    return false;
	}

	public function clear_product_image_cache($product_id = 0) {
		$this->load->model('module/labelmaker');
		$this->model_module_labelmaker->clear_product_image_cache($product_id);
	}
}
?>