<?php
class ControllerModuleOcLoaderTorgsoft20160705 extends Controller {
	private $error = array(); 

	public function index() {

		$this->load->language('module/oc_loader_torgsoft_20160705');
		$this->load->model('tool/image');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		
		$data['oc_loader_torgsoft_version'] = '2016-07-05';
		$version = str_replace('-','', $data['oc_loader_torgsoft_version']);
		$data['LS'] = 'http://license-server.in.ua'; // URL официального сайта модуля и сервера лицензий
		
		$language_all = $this->language->all();
		
		foreach ($language_all as $key => $value){
			if (strpos($key, 'oc_loader_torgsoft') === 0){
				$data[$key] = $value;
			}
		}
		
		$data['oc_loader_torgsoft_version_text'] = $this->language->get('oc_loader_torgsoft_version_version').$data['oc_loader_torgsoft_version'];
		
		$data['heading_title'] = $this->language->get('heading_title');
			
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator'	=> false
		);

		$data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('oc_loader_torgsoft_text_module'),
			'href'		=> $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator'	=> ' :: '
		);
		
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link("module/oc_loader_torgsoft_$version", 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);


		$data['token'] = $this->session->data['token'];
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		//$data['action'] = HTTPS_SERVER . 'index.php?route=module/oc_loader_torgsoft&token=' . $this->session->data['token'];
		$data['action'] = $this->url->link("module/oc_loader_torgsoft_$version", 'token=' . $this->session->data['token'], 'SSL');

		//$data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/oc_loader_torgsoft&token=' . $this->session->data['token'];
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['error_warning'] = '';
		$data['error'] = array();;
		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['oc_loader_torgsoft_attention'] = $this->language->get('oc_loader_torgsoft_attention');
		
		// tab-general
		$data['oc_loader_torgsoft_status'] = $this->config->get('oc_loader_torgsoft_status');
		if ($this->user->hasPermission('modify', "module/oc_loader_torgsoft_$version")) {
			if (isset($this->request->post['oc_loader_torgsoft_status'])) {
				$data['oc_loader_torgsoft_status'] = $this->request->post['oc_loader_torgsoft_status'];
			}
		}
		
		if ($data['oc_loader_torgsoft_status'] == 0){
			$oc_loader_torgsoft_enabled = false;
		}else{
			$oc_loader_torgsoft_enabled = true;
		}
		
		if ($oc_loader_torgsoft_enabled){
			// проверка версии движка 
			if (VERSION != '2.1.0.2'){
				$data['error_warning'] = str_replace('{VERSION}', VERSION, $this->language->get('oc_loader_torgsoft_wrong_version'));
				$oc_loader_torgsoft_enabled = false;
			}else{
				// проверка наличия модуля обмена
				if (!is_file("../$version/oc_loader_torgsoft.php")){
					$data['error_warning'] = $this->language->get('oc_loader_torgsoft_file_missing').' '.$version.'/oc_loader_torgsoft.php';
					$oc_loader_torgsoft_enabled = false;
				}else{
					// проверка лицензии
					$data['oc_loader_torgsoft_licese_msg'] = '';
//					$string = file_get_contents($data['LS']."/test-license.php?version=".$data['oc_loader_torgsoft_version']);
					$string = $this->curl_get_contents($data['LS']."/test-license.php?version=".$data['oc_loader_torgsoft_version']);
					if (isset($string[0]) AND $string[0] == '{'){
						$settings = json_decode($string, true);
						if (is_array($settings)){
							if (isset($settings['status'])){
								if ($settings['status'] == 'BAD'){
									$data['error_warning'] = str_replace('{LS}', $data['LS'], $this->language->get('oc_loader_torgsoft_LS_answer')).$settings['msg'];
									$oc_loader_torgsoft_enabled = false;
								}else if ($settings['status'] == 'OK'){
									$data['oc_loader_torgsoft_licese_msg'] = $settings['msg'];
								}else{
									$data['error_warning'] = str_replace('{LS}', $data['LS'], $this->language->get('oc_loader_torgsoft_LS_bad_answer')).$string;
									$oc_loader_torgsoft_enabled = false;
								}
							}else{
								$data['error_warning'] = str_replace('{LS}', $data['LS'], $this->language->get('oc_loader_torgsoft_LS_bad_answer')).$string;
								$oc_loader_torgsoft_enabled = false;
							}
						}else{
							$data['error_warning'] = str_replace('{LS}', $data['LS'], $this->language->get('oc_loader_torgsoft_LS_bad_answer')).$string;
							$oc_loader_torgsoft_enabled = false;
						}
					}else{
						$data['error_warning'] = str_replace('{LS}', $data['LS'], $this->language->get('oc_loader_torgsoft_LS_no_answer')).$string;
						$oc_loader_torgsoft_enabled = false;
					}
				}
			}
		}
		
		$data['oc_loader_torgsoft_enabled'] = $oc_loader_torgsoft_enabled;
		
		// tab-product
		// основные поля 
		$main_columns 		= array(	// имя поля в базе => 1-обязательно, имя поля в файле 
		'GoodID' 			=> array(1, 'ID товара', 'GoodID'),
		'name' 				=> array(1, 'Название', 'GoodName'),
		'model' 			=> array(1, 'Артикул', 'Articul'),
		'sku' 				=> array(0, 'Артикул', 'Articul'),
		'description' 		=> array(0, 'Описание', 'Description'),
		'price' 			=> array(1, 'Цена розничная', 'RetailPrice'),
		'quantity' 			=> array(0, 'Количество на складе', 'WarehouseQuantity'),
		'display' 			=> array(0, 'Отображение', 'Display'),
		'manufacturer'		=> array(0, 'Производитель товара полностью', 'ProducerCollectionFull'),
		'category' 			=> array(0, 'Вид товара полностью', 'GoodTypeFull'),
		);
		
		$keys				= array(	// поля, по которым можно идентифицировать товар
		'GoodID',
		'name',
		'model',
		);
		$data['keys'] = $keys;
		
		// характеристики
		$attributes_columns_r	= array(	// имя в базе => 1-обязательно, имя поля в файле
		'Размер' 			=> array(0, 'Размер', 'TheSize'),
		'Цвет' 				=> array(0, 'Цвет', 'Color'),
		'Материал' 			=> array(0, 'Материал', 'Material'),
		'Страна' 			=> array(0, 'Страна', 'Country'),
		'Пол' 				=> array(0, 'Пол', 'Sex'),
		'Высота' 			=> array(0, 'Высота', 'Height'),
		'Ширина' 			=> array(0, 'Ширина', 'Width'),
		'Сезон' 			=> array(0, 'Сезон', 'Season'),
		'Штрих-код' 		=> array(0, 'Штрих-код', 'Barcode'),
		'Упаковка' 			=> array(0, 'Упаковка', 'Pack'),
		'Питание' 			=> array(0, 'Питание', 'PowerSupply'),
		'Возраст' 			=> array(0, 'Возраст', 'Age'),
		);
		
		// значения по-умолчанию
		$default_values				= array(	// имя поля в базе => имя поля, по умолчанию, возможные значения - расчет далее
		'default_location'			=> array($this->language->get('oc_loader_torgsoft_text_location'), ''),
		'default_quantity'			=> array($this->language->get('oc_loader_torgsoft_text_quantity'), 1000),
		'default_minimum'			=> array($this->language->get('oc_loader_torgsoft_text_mimimum'), 1),
		'default_display' 			=> array($this->language->get('oc_loader_torgsoft_text_display'), 0),
		'default_subtract'			=> array($this->language->get('oc_loader_torgsoft_text_subtract'), 1),
		'default_stock_status_id'	=> array($this->language->get('oc_loader_torgsoft_text_stock_status_id'), 5),
		'default_shipping'			=> array($this->language->get('oc_loader_torgsoft_text_shipping'), 1),
		'default_length'			=> array($this->language->get('oc_loader_torgsoft_text_length'), 0),
		'default_width'				=> array($this->language->get('oc_loader_torgsoft_text_width'), 0),
		'default_height'			=> array($this->language->get('oc_loader_torgsoft_text_height'), 0),
		'default_length_class_id'	=> array($this->language->get('oc_loader_torgsoft_text_length_class_id'), 0),
		'default_weight'			=> array($this->language->get('oc_loader_torgsoft_text_weight'), 0),
		'default_weight_class_id'	=> array($this->language->get('oc_loader_torgsoft_text_weight_class_id'), 0),
		'default_sort_order'		=> array($this->language->get('oc_loader_torgsoft_text_sort_order'), 0),
		'default_category'			=> array($this->language->get('oc_loader_torgsoft_text_new_category'), 1),
		'default_fill_parent_cats'	=> array($this->language->get('oc_loader_torgsoft_text_fill_parent_cats'), 1),
		);
		
		$spec_settings 						= array(	// специальные настройки	
		'hide_missing_products'				=> array($this->language->get('oc_loader_torgsoft_text_hide_missing_products'), 0),
		'hide_products_with_zero_quantity' 	=> array($this->language->get('oc_loader_torgsoft_text_hide_products_with_zero_quantity'), 0),
		'show_not_changed'					=> array($this->language->get('oc_loader_torgsoft_text_show_not_changed'), 0),

		);
		
		// TODO: опции 
//		$options_columns 	= array(	// имя в базе => 1-обязательно, имя поля в файле
//		'Размер' 			=> array(0, 'Размер', 'TheSize'),
//		'Цвет' 				=> array(0, 'Цвет', 'Color'),
//		);
		// ------------------
	
		// сохранение
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			if (!isset($this->request->post['return'])) {
				
				if (count($this->request->post) > 1){
				
					foreach ($this->request->post as $key => $value){
						if ($value == $this->language->get('oc_loader_torgsoft_select_column')){
							$this->request->post[$key] = '0'; 
						}
					}
//					foreach ($main_columns as $pole => $array){
//						if (isset($this->request->post["oc_loader_torgsoft_$pole"])){
//							$value = $this->request->post["oc_loader_torgsoft_$pole"];
//							if ($value == $this->language->get('oc_loader_torgsoft_select_column')){
//								$this->request->post["oc_loader_torgsoft_$pole"] = 0; 
//							}
//						}
//					}
	//echo '<pre>';
	//print_r($this->request->post);
	//die;
					
					if ($this->validate($version)){
						$this->model_setting_setting->editSetting('oc_loader_torgsoft', $this->request->post);
						$this->session->data['success'] = $this->language->get('text_success');
						$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
					}
				}
			}else{
//				if ($this->validate($version)){
//					$this->model_setting_setting->editSetting('oc_loader_torgsoft', $this->request->post);
//					$this->session->data['success'] = $this->language->get('text_success');
//				}
			}
			
			$data['error'] = $this->error;
			
			// Settings
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '0'");
			
			foreach ($query->rows as $setting) {
				if (!$setting['serialized']) {
					$this->config->set($setting['key'], $setting['value']);
				} else {
					$this->config->set($setting['key'], json_decode($setting['value'], true));
				}
			}

		}
		
		if ($oc_loader_torgsoft_enabled){
			
			// проверка наличия файла trs
			if (isset($this->request->post['oc_loader_torgsoft_trs_file'])) {
				$data['oc_loader_torgsoft_trs_file'] = $this->request->post['oc_loader_torgsoft_trs_file'];
			}
			else {
				if ($this->config->get('oc_loader_torgsoft_trs_file')){
					$data['oc_loader_torgsoft_trs_file'] = $this->config->get('oc_loader_torgsoft_trs_file');
				}else{
					$data['oc_loader_torgsoft_trs_file'] = 'trs/TSGoods.trs';
				}
			}
			$input_file = $data['oc_loader_torgsoft_trs_file'];
			if (is_file('../'.$input_file)){
				$oc_loader_torgsoft_file_exist = true;
			}else{
				$oc_loader_torgsoft_file_exist = false;
				$data['error_warning'] = $this->language->get('oc_loader_torgsoft_file_not_exist');
			}
			
			$data['oc_loader_torgsoft_file_exist'] = $oc_loader_torgsoft_file_exist;
			$data['oc_loader_torgsoft_save_trs_file'] = $this->language->get('oc_loader_torgsoft_save_trs_file');
			
			if ($oc_loader_torgsoft_file_exist){
				// settings
				
				// кодировка
				if (isset($this->request->post['oc_loader_torgsoft_file_code'])) {
					$data['oc_loader_torgsoft_file_code'] = $this->request->post['oc_loader_torgsoft_file_code'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_file_code')){
						$data['oc_loader_torgsoft_file_code'] = $this->config->get('oc_loader_torgsoft_file_code');
					}else{
						$data['oc_loader_torgsoft_file_code'] = 'windows';
					}
				}
				$file_code = $data['oc_loader_torgsoft_file_code'];
				
				$handle = fopen('../'.$input_file, 'r');
				if ($handle){
					
					$string = fgets($handle);
					// обработка BOM
					if ($string[0] == chr(239)){
						$string = substr($string, 3);
					}
					if ($file_code == 'windows'){
						$string = iconv('CP1251', 'UTF-8', $string);
					}
					$data['two_strings'] = 'Строка 1:'.$string;
					$data['two_strings'] .= '<br/>';
					
					$string = fgets($handle);
					if ($file_code == 'windows'){
						$string = iconv('CP1251', 'UTF-8', $string);
					}
					$data['two_strings'] .= 'Строка 2:'.$string;
					
					fclose($handle);
				}else{
					$data['two_strings'] = $this->language->get('oc_loader_torgsoft_file_is_blocked');
				}
				
				// считывание первой строки
				if ($file_code == 'windows'){
					setlocale(LC_ALL, 'ru_RU.CP1251');
				}else{
					setlocale(LC_ALL, 'ru_RU.UTF-8');
				}
				
				// загрузка прайса
				$handle = fopen('../'.$input_file, 'r');
				
				// анализ заголовочной строки
				$line = fgetcsv($handle, 100000, ';');
				
//				if ($file_code == 'windows'){
//					
//				}else{
					// обработка BOM
					if (strpos($line[0], '"') !== false){
						$l = explode('"', $line[0]);
						$line[0] = $l[1];
					}
//				}
				
				// считывание второй строки и построение таблицы
				$line2 = fgetcsv($handle, 100000, ';');
				
				$table12 = '<table width=100% border=1 bordercolor="#416e98" style="border-collapse : collapse; margin:5px;"><tr>';
				foreach ($line as $s1){
					$table12 .= '<th>'.$s1.'</th>';
				}
				$table12 .= '</tr><tr>';
				foreach ($line2 as $s1){
					$table12 .= '<td align=center>'.$s1.'</td>';
				}
				$table12 .= '</tr></table>';
				$data['table12'] = $table12;
				
				fclose($handle);
				
				// добавлять новые товары ?
				$selected = 1;
				$oc_loader_torgsoft_add_new_products = array();
				if (isset($this->request->post['oc_loader_torgsoft_add_new_products'])) {
					$selected = $this->request->post['oc_loader_torgsoft_add_new_products'];
				}else {
					if ($this->config->get('oc_loader_torgsoft_add_new_products')){
						$selected = $this->config->get('oc_loader_torgsoft_add_new_products');
					}
				}
				$values = array( array(1,$this->language->get('text_yes')), array(0,$this->language->get('text_no')));
				foreach ($values as $i => $value){
					$oc_loader_torgsoft_add_new_products[$i]['name'] = $value[1];
					$oc_loader_torgsoft_add_new_products[$i]['value'] = $value[0];
					$oc_loader_torgsoft_add_new_products[$i]['selected'] = 0;
					if ($value[0] == $selected){
						$oc_loader_torgsoft_add_new_products[$i]['selected'] = 1;
					}
				}
				$data['oc_loader_torgsoft_add_new_products'] = $oc_loader_torgsoft_add_new_products;
				
				// добавлять новые товары с нулевым остатком
				$selected = 0;
				$oc_loader_torgsoft_add_new_products_zero = array();
				if (isset($this->request->post['oc_loader_torgsoft_add_new_products_zero'])) {
					$selected = $this->request->post['oc_loader_torgsoft_add_new_products_zero'];
				}else {
					if ($this->config->get('oc_loader_torgsoft_add_new_products_zero')){
						$selected = $this->config->get('oc_loader_torgsoft_add_new_products_zero');
					}
				}
				$values = array( array(1,$this->language->get('text_yes')), array(0,$this->language->get('text_no')));
				foreach ($values as $i => $value){
					$oc_loader_torgsoft_add_new_products_zero[$i]['name'] = $value[1];
					$oc_loader_torgsoft_add_new_products_zero[$i]['value'] = $value[0];
					$oc_loader_torgsoft_add_new_products_zero[$i]['selected'] = 0;
					if ($value[0] == $selected){
						$oc_loader_torgsoft_add_new_products_zero[$i]['selected'] = 1;
					}
				}
				$data['oc_loader_torgsoft_add_new_products_zero'] = $oc_loader_torgsoft_add_new_products_zero;
				
				array_unshift($line, $this->language->get('oc_loader_torgsoft_select_column'));

				$update = array();
				// основные поля
				foreach ($main_columns as $pole => $param){
					$main = array();
					$main['star'] = $param[0]==1?'* ':'';
					$main['title'] = $this->language->get('oc_loader_torgsoft_text_'.$pole);
					$main['comment'] = '('.$param[1].', '.$param[2].')';
					$main['name'] = 'oc_loader_torgsoft_'.$pole;
					
					$selected = array($param[1], $param[2]);
					if (isset($this->request->post['oc_loader_torgsoft_'.$pole])) {
						if ($this->request->post['oc_loader_torgsoft_'.$pole] == '0'){
							$selected = $this->language->get('oc_loader_torgsoft_select_column');
						}else{
							$selected = $this->request->post['oc_loader_torgsoft_'.$pole];
						}
					}else {
						if (!is_null($this->config->get('oc_loader_torgsoft_'.$pole))){
							$selected = $this->config->get('oc_loader_torgsoft_'.$pole);
						}
					}
//echo '<pre>';
//print_r($selected);
//print_r($line);	
//die;				
					foreach ($line as $i => $column_name){
						$main['option'][$i]['name'] = $column_name;
						$main['option'][$i]['selected'] = 0;
						if (is_array($selected)){
							foreach ($selected as $selected1){
								if ($selected1 == $column_name){
									$main['option'][$i]['selected'] = 1;
								}
							}
						}else{
							if ($selected == $column_name){
								$main['option'][$i]['selected'] = 1;
							}
						}
					}
					
					$main['checked'] = '';
					if (isset($this->request->post['oc_loader_torgsoft_update_'.$pole])) {
						$main['checked'] = $this->request->post['oc_loader_torgsoft_update_'.$pole]==1?'checked':'';
					}else {
						if ($this->config->get('oc_loader_torgsoft_update_'.$pole)){
							$main['checked'] = 'checked';
						}
					}
				
					$main['key_checked'] = '';
					if (isset($this->request->post['oc_loader_torgsoft_key']) AND $this->request->post['oc_loader_torgsoft_key'] == $pole) {
						$main['key_checked'] = $this->request->post['oc_loader_torgsoft_key']==$pole?'checked':'';
					}else {
						if ($this->config->get('oc_loader_torgsoft_key') == $pole){
							$main['key_checked'] = 'checked';
						}
					}
					
					$main['strip_name'] = '';
					if ($pole == 'name'){
						if (isset($this->request->post['oc_loader_torgsoft_strip_name'])) {
							$main['strip_name'] = $this->request->post['oc_loader_torgsoft_strip_name']==1?'checked':'';
						}else {
							if ($this->config->get('oc_loader_torgsoft_strip_name')){
								$main['strip_name'] = 'checked';
							}
						}
					}
					
					$data['oc_loader_torgsoft_main'][$pole] = $main;
				}
				
				$attributes_groups = array();
				
				$selected = 0;
				if (isset($this->request->post['oc_loader_torgsoft_attributes_group'])) {
					$selected = $this->request->post['oc_loader_torgsoft_attributes_group'];
				}else {
					if ($this->config->get('oc_loader_torgsoft_attributes_group')){
						$selected = $this->config->get('oc_loader_torgsoft_attributes_group');
					}
				}
					
				$this->load->model('catalog/attribute_group');
				$values = $this->model_catalog_attribute_group->getAttributeGroups();
//echo '<pre>'; print_r ($values);	die;
				foreach ($values as $i => $value){
					$attributes_groups[$i]['name'] = $value['name'];
					$attributes_groups[$i]['value'] = $value['attribute_group_id'];
					$attributes_groups[$i]['selected'] = 0;
					if ($value['attribute_group_id'] == $selected){
						$attributes_groups[$i]['selected'] = 1;
					}
				}
				$first_option['name'] = $this->language->get('oc_loader_torgsoft_text_select_attributes_group');
				$first_option['value'] = 0;
				$first_option['selected'] = 0;
				array_unshift($attributes_groups, $first_option);
				$data['attributes_groups'] = $attributes_groups;
				
				$group_attributes = array();
				$attributes_columns = array();
				$data['oc_loader_torgsoft_attributes'] = array();
				if ($selected > 0){
					
					// получение наименований характеристик
					$this->load->model('catalog/attribute');
					$filter = array('filter_attribute_group_id' => $selected);
					$values = $this->model_catalog_attribute->getAttributesByAttributeGroupId($filter);
//echo '<pre>'; print_r ($values);	die;
					foreach ($values as $i => $value){
						$group_attributes[$i] = $value['name'];
						if (isset($attributes_columns_r[$value['name']])){
							$attributes_columns[$value['name']] = $attributes_columns_r[$value['name']];
						}else{
							$attributes_columns[$value['name']] = array(0);
						}
					}
				
				
					// характеристики
					foreach ($attributes_columns as $pole => $param){
						$attributes = array();
						$attributes['star'] = $param[0]==1?'* ':'';
						$attributes['title'] = $pole;
						if (isset($param[1])){
							$attributes['comment'] = '('.$param[1].', '.$param[2].')';
							$selected = array($param[1], $param[2]);
						}else{
							$attributes['comment'] = '';
							$selected = '0';
						}
						$attributes['name'] = 'oc_loader_torgsoft_'.$pole;
						
						if (!in_array($pole, $group_attributes)){
							$attributes['alert'] = 1;
						}
						
						
						if (isset($this->request->post['oc_loader_torgsoft_'.$pole])) {
							$selected = $this->request->post['oc_loader_torgsoft_'.$pole];
						}else {
							if (!is_null($this->config->get('oc_loader_torgsoft_'.$pole))){
								$selected = $this->config->get('oc_loader_torgsoft_'.$pole);
							}
						}
	//var_dump($pole, $selected);	echo '<br/>';			
						foreach ($line as $i => $column_name){
							$attributes['option'][$i]['name'] = $column_name;
							$attributes['option'][$i]['selected'] = 0;
							if (is_array($selected)){
								foreach ($selected as $selected1){
									if ($selected1 == $column_name){
										$attributes['option'][$i]['selected'] = 1;
									}
								}
							}else{
								if ($selected != '0' AND $selected == $column_name){
									$attributes['option'][$i]['selected'] = 1;
								}
							}
						}
	
						$attributes['checked'] = '';
						if (isset($this->request->post['oc_loader_torgsoft_update_'.$pole])) {
							$attributes['checked'] = $this->request->post['oc_loader_torgsoft_update_'.$pole]==1?'checked':'';
						}else {
							if ($this->config->get('oc_loader_torgsoft_update_'.$pole)){
								$attributes['checked'] = 'checked';
							}
						}
						
						$data['oc_loader_torgsoft_attributes'][$pole] = $attributes;
					}
				}
//echo '<pre>';
//print_r($data['oc_loader_torgsoft_attributes']);
//die;
				// значения по-умолчанию
				foreach ($default_values as $pole => $param){
					$defailt_value = array();
					$defailt_value['title'] = $param[0];
					$defailt_value['name'] = 'oc_loader_torgsoft_'.$pole;
					
					$selected = $param[1];
					if (isset($this->request->post['oc_loader_torgsoft_'.$pole])) {
						$selected = $this->request->post['oc_loader_torgsoft_'.$pole];
					}else {
						if (!is_null($this->config->get('oc_loader_torgsoft_'.$pole))){
							$selected = $this->config->get('oc_loader_torgsoft_'.$pole);
						}
					}
					
					switch ($pole){
					
						case 'default_display':
							$values = array( array(0,$this->language->get('text_disabled')), array(1,$this->language->get('text_enabled')));
							foreach ($values as $i => $value){
								$defailt_value['option'][$i]['name'] = $value[1];
								$defailt_value['option'][$i]['value'] = $value[0];
								$defailt_value['option'][$i]['selected'] = 0;
								if ($value[0] == $selected){
									$defailt_value['option'][$i]['selected'] = 1;
								}
							}
							break;
							
						case 'default_subtract':
						case 'default_shipping':
						case 'default_fill_parent_cats':
							$values = array( array(0,$this->language->get('text_no')), array(1,$this->language->get('text_yes')));
							foreach ($values as $i => $value){
								$defailt_value['option'][$i]['name'] = $value[1];
								$defailt_value['option'][$i]['value'] = $value[0];
								$defailt_value['option'][$i]['selected'] = 0;
								if ($value[0] == $selected){
									$defailt_value['option'][$i]['selected'] = 1;
								}
							}
							break;
							
						case 'default_stock_status_id':
							$this->load->model('localisation/stock_status');
							$values = $this->model_localisation_stock_status->getStockStatuses();
//echo '<pre>'; print_r ($values);	die;
							foreach ($values as $i => $value){
								$defailt_value['option'][$i]['name'] = $value['name'];
								$defailt_value['option'][$i]['value'] = $value['stock_status_id'];
								$defailt_value['option'][$i]['selected'] = 0;
								if ($value['stock_status_id'] == $selected){
									$defailt_value['option'][$i]['selected'] = 1;
								}
							}
							break;
							
						case 'default_length_class_id':
							$this->load->model('localisation/length_class');
							$values = $this->model_localisation_length_class->getLengthClasses();
//echo '<pre>'; print_r ($values);	die;						
							foreach ($values as $i => $value){
								$defailt_value['option'][$i]['name'] = $value['title'];
								$defailt_value['option'][$i]['value'] = $value['length_class_id'];
								$defailt_value['option'][$i]['selected'] = 0;
								if ($value['length_class_id'] == $selected){
									$defailt_value['option'][$i]['selected'] = 1;
								}
							}
							break;
							
						case 'default_weight_class_id':
							$this->load->model('localisation/weight_class');
							$values = $this->model_localisation_weight_class->getWeightClasses();
//echo '<pre>'; print_r ($values);	die;						
							foreach ($values as $i => $value){
								$defailt_value['option'][$i]['name'] = $value['title'];
								$defailt_value['option'][$i]['value'] = $value['weight_class_id'];
								$defailt_value['option'][$i]['selected'] = 0;
								if ($value['weight_class_id'] == $selected){
									$defailt_value['option'][$i]['selected'] = 1;
								}
							}
							break;
							
						case 'default_category':
//							$this->load->model('catalog/category');
							$values = $this->getCategoriesByParentId(0);
//echo '<pre>'; print_r ($values);	die;						
							foreach ($values as $i => $value){
								$defailt_value['option'][$i]['name'] = $value['name'];
								$defailt_value['option'][$i]['value'] = $value['category_id'];
								$defailt_value['option'][$i]['selected'] = 0;
								if ($value['category_id'] == $selected){
									$defailt_value['option'][$i]['selected'] = 1;
								}
							}
							break;
							
						default:
							$defailt_value['value'] = $selected;
							break;
						
					}
					
					$data['oc_loader_torgsoft_defailt_values'][$pole] = $defailt_value;
				}
				
				// мета-теги
				// category
				if (isset($this->request->post['oc_loader_torgsoft_meta_title_category'])) {
					$data['oc_loader_torgsoft_meta_title_category'] = $this->request->post['oc_loader_torgsoft_meta_title_category'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_meta_title_category')){
						$data['oc_loader_torgsoft_meta_title_category'] = $this->config->get('oc_loader_torgsoft_meta_title_category');
					}else{
						$data['oc_loader_torgsoft_meta_title_category'] = '{category-name}';
					}
				}
				
				if (isset($this->request->post['oc_loader_torgsoft_meta_h1_category'])) {
					$data['oc_loader_torgsoft_meta_h1_category'] = $this->request->post['oc_loader_torgsoft_meta_h1_category'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_meta_h1_category')){
						$data['oc_loader_torgsoft_meta_h1_category'] = $this->config->get('oc_loader_torgsoft_meta_h1_category');
					}else{
						$data['oc_loader_torgsoft_meta_h1_category'] = '{category-name}';
					}
				}
				
				if (isset($this->request->post['oc_loader_torgsoft_meta_description_category'])) {
					$data['oc_loader_torgsoft_meta_description_category'] = $this->request->post['oc_loader_torgsoft_meta_description_category'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_meta_description_category')){
						$data['oc_loader_torgsoft_meta_description_category'] = $this->config->get('oc_loader_torgsoft_meta_description_category');
					}else{
						$data['oc_loader_torgsoft_meta_description_category'] = '{category-name}';
					}
				}

				if (isset($this->request->post['oc_loader_torgsoft_meta_keywords_category'])) {
					$data['oc_loader_torgsoft_meta_keywords_category'] = $this->request->post['oc_loader_torgsoft_meta_keywords_category'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_meta_keywords_category')){
						$data['oc_loader_torgsoft_meta_keywords_category'] = $this->config->get('oc_loader_torgsoft_meta_keywords_category');
					}else{
						$data['oc_loader_torgsoft_meta_keywords_category'] = '{category-name}';
					}
				}
				// product
				if (isset($this->request->post['oc_loader_torgsoft_meta_title'])) {
					$data['oc_loader_torgsoft_meta_title'] = $this->request->post['oc_loader_torgsoft_meta_title'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_meta_title')){
						$data['oc_loader_torgsoft_meta_title'] = $this->config->get('oc_loader_torgsoft_meta_title');
					}else{
						$data['oc_loader_torgsoft_meta_title'] = '{name}';
					}
				}
				if (isset($this->request->post['oc_loader_torgsoft_update_meta_title'])) {
					$data['oc_loader_torgsoft_update_meta_title'] = $this->request->post['oc_loader_torgsoft_update_meta_title']==1?'checked':'';
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_update_meta_title')){
						$data['oc_loader_torgsoft_update_meta_title'] = $this->config->get('oc_loader_torgsoft_update_meta_title')==1?'checked':'';
					}else{
						$data['oc_loader_torgsoft_update_meta_title'] = '';
					}
				}
				
				if (isset($this->request->post['oc_loader_torgsoft_meta_h1'])) {
					$data['oc_loader_torgsoft_meta_h1'] = $this->request->post['oc_loader_torgsoft_meta_h1'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_meta_h1')){
						$data['oc_loader_torgsoft_meta_h1'] = $this->config->get('oc_loader_torgsoft_meta_h1');
					}else{
						$data['oc_loader_torgsoft_meta_h1'] = '{name}';
					}
				}
				if (isset($this->request->post['oc_loader_torgsoft_update_meta_h1'])) {
					$data['oc_loader_torgsoft_update_meta_h1'] = $this->request->post['oc_loader_torgsoft_update_meta_h1']==1?'checked':'';
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_update_meta_h1')){
						$data['oc_loader_torgsoft_update_meta_h1'] = $this->config->get('oc_loader_torgsoft_update_meta_h1')==1?'checked':'';
					}else{
						$data['oc_loader_torgsoft_update_meta_h1'] = '';
					}
				}
				
				if (isset($this->request->post['oc_loader_torgsoft_meta_description'])) {
					$data['oc_loader_torgsoft_meta_description'] = $this->request->post['oc_loader_torgsoft_meta_description'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_meta_description')){
						$data['oc_loader_torgsoft_meta_description'] = $this->config->get('oc_loader_torgsoft_meta_description');
					}else{
						$data['oc_loader_torgsoft_meta_description'] = '{name}';
					}
				}
				if (isset($this->request->post['oc_loader_torgsoft_update_meta_description'])) {
					$data['oc_loader_torgsoft_update_meta_description'] = $this->request->post['oc_loader_torgsoft_update_meta_description']==1?'checked':'';
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_update_meta_description')){
						$data['oc_loader_torgsoft_update_meta_description'] = $this->config->get('oc_loader_torgsoft_update_meta_description')==1?'checked':'';
					}else{
						$data['oc_loader_torgsoft_update_meta_description'] = '';
					}
				}
				
				if (isset($this->request->post['oc_loader_torgsoft_meta_keywords'])) {
					$data['oc_loader_torgsoft_meta_keywords'] = $this->request->post['oc_loader_torgsoft_meta_keywords'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_meta_keywords')){
						$data['oc_loader_torgsoft_meta_keywords'] = $this->config->get('oc_loader_torgsoft_meta_keywords');
					}else{
						$data['oc_loader_torgsoft_meta_keywords'] = '{name}';
					}
				}
				if (isset($this->request->post['oc_loader_torgsoft_update_meta_keywords'])) {
					$data['oc_loader_torgsoft_update_meta_keywords'] = $this->request->post['oc_loader_torgsoft_update_meta_keywords']==1?'checked':'';
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_update_meta_keywords')){
						$data['oc_loader_torgsoft_update_meta_keywords'] = $this->config->get('oc_loader_torgsoft_update_meta_keywords')==1?'checked':'';
					}else{
						$data['oc_loader_torgsoft_update_meta_keywords'] = '';
					}
				}
				
				if (isset($this->request->post['oc_loader_torgsoft_seourl'])) {
					$data['oc_loader_torgsoft_seourl'] = $this->request->post['oc_loader_torgsoft_seourl'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_seourl')){
						$data['oc_loader_torgsoft_seourl'] = $this->config->get('oc_loader_torgsoft_seourl');
					}else{
						$data['oc_loader_torgsoft_seourl'] = '{product-id}-{name}';
					}
				}
				if (isset($this->request->post['oc_loader_torgsoft_update_seourl'])) {
					$data['oc_loader_torgsoft_update_seourl'] = $this->request->post['oc_loader_torgsoft_update_seourl']==1?'checked':'';
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_update_seourl')){
						$data['oc_loader_torgsoft_update_seourl'] = $this->config->get('oc_loader_torgsoft_update_seourl')==1?'checked':'';
					}else{
						$data['oc_loader_torgsoft_update_seourl'] = '';
					}
				}
				
				if (isset($this->request->post['oc_loader_torgsoft_words_deleted_from_tag'])) {
					$data['oc_loader_torgsoft_words_deleted_from_tag'] = $this->request->post['oc_loader_torgsoft_words_deleted_from_tag'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_words_deleted_from_tag')){
						$data['oc_loader_torgsoft_words_deleted_from_tag'] = $this->config->get('oc_loader_torgsoft_words_deleted_from_tag');
					}else{
						$data['oc_loader_torgsoft_words_deleted_from_tag'] = 'в,без,до,из,к,на,по,о,от,перед,при,через,с,у,за,над,об,под,про,для';
					}
				}
				if (isset($this->request->post['oc_loader_torgsoft_update_words_deleted_from_tag'])) {
					$data['oc_loader_torgsoft_update_words_deleted_from_tag'] = $this->request->post['oc_loader_torgsoft_update_words_deleted_from_tag']==1?'checked':'';
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_update_words_deleted_from_tag')){
						$data['oc_loader_torgsoft_update_words_deleted_from_tag'] = $this->config->get('oc_loader_torgsoft_update_words_deleted_from_tag')==1?'checked':'';
					}else{
						$data['oc_loader_torgsoft_update_words_deleted_from_tag'] = '';
					}
				}
				
				// папка с фото + контроль
				if (isset($this->request->post['oc_loader_torgsoft_image_ext'])) {
					$data['oc_loader_torgsoft_image_ext'] = $this->request->post['oc_loader_torgsoft_image_ext'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_image_ext')){
						$data['oc_loader_torgsoft_image_ext'] = $this->config->get('oc_loader_torgsoft_image_ext');
					}else{
						$data['oc_loader_torgsoft_image_ext'] = 'jpg,png,jpeg';
					}
				}
				if (isset($this->request->post['oc_loader_torgsoft_image_output'])) {
					$data['oc_loader_torgsoft_image_output'] = $this->request->post['oc_loader_torgsoft_image_output'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_image_output')){
						$data['oc_loader_torgsoft_image_output'] = $this->config->get('oc_loader_torgsoft_image_output');
					}else{
						$data['oc_loader_torgsoft_image_output'] = 'jpg';
					}
				}
				if (isset($this->request->post['oc_loader_torgsoft_image_quality'])) {
					$data['oc_loader_torgsoft_image_quality'] = $this->request->post['oc_loader_torgsoft_image_quality'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_image_quality')){
						$data['oc_loader_torgsoft_image_quality'] = $this->config->get('oc_loader_torgsoft_image_quality');
					}else{
						$data['oc_loader_torgsoft_image_quality'] = '90';
					}
				}
				if (isset($this->request->post['oc_loader_torgsoft_image_dir'])) {
					$data['oc_loader_torgsoft_image_dir'] = $this->request->post['oc_loader_torgsoft_image_dir'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_image_dir')){
						$data['oc_loader_torgsoft_image_dir'] = $this->config->get('oc_loader_torgsoft_image_dir');
					}else{
						$data['oc_loader_torgsoft_image_dir'] = 'products';
					}
				}
				
				// специальные настройки
				$selected = 0;
				$oc_loader_torgsoft_hide_missing_products = array();
				if (isset($this->request->post['oc_loader_torgsoft_hide_missing_products'])) {
					$selected = $this->request->post['oc_loader_torgsoft_hide_missing_products'];
				}else {
					if ($this->config->get('oc_loader_torgsoft_hide_missing_products')){
						$selected = $this->config->get('oc_loader_torgsoft_hide_missing_products');
					}
				}
				$values = array( array(1,$this->language->get('text_yes')), array(0,$this->language->get('text_no')));
				foreach ($values as $i => $value){
					$oc_loader_torgsoft_hide_missing_products[$i]['name'] = $value[1];
					$oc_loader_torgsoft_hide_missing_products[$i]['value'] = $value[0];
					$oc_loader_torgsoft_hide_missing_products[$i]['selected'] = 0;
					if ($value[0] == $selected){
						$oc_loader_torgsoft_hide_missing_products[$i]['selected'] = 1;
					}
				}
				$data['oc_loader_torgsoft_hide_missing_products'] = $oc_loader_torgsoft_hide_missing_products;
				
				$selected = 0;
				$oc_loader_torgsoft_hide_products_with_zero_quantity = array();
				if (isset($this->request->post['oc_loader_torgsoft_hide_products_with_zero_quantity'])) {
					$selected = $this->request->post['oc_loader_torgsoft_hide_products_with_zero_quantity'];
				}else {
					if ($this->config->get('oc_loader_torgsoft_hide_products_with_zero_quantity')){
						$selected = $this->config->get('oc_loader_torgsoft_hide_products_with_zero_quantity');
					}
				}
				$values = array( array(1,$this->language->get('text_yes')), array(0,$this->language->get('text_no')));
				foreach ($values as $i => $value){
					$oc_loader_torgsoft_hide_products_with_zero_quantity[$i]['name'] = $value[1];
					$oc_loader_torgsoft_hide_products_with_zero_quantity[$i]['value'] = $value[0];
					$oc_loader_torgsoft_hide_products_with_zero_quantity[$i]['selected'] = 0;
					if ($value[0] == $selected){
						$oc_loader_torgsoft_hide_products_with_zero_quantity[$i]['selected'] = 1;
					}
				}
				$data['oc_loader_torgsoft_hide_products_with_zero_quantity'] = $oc_loader_torgsoft_hide_products_with_zero_quantity;
				
				$selected = 0;
				$oc_loader_torgsoft_show_not_changed = array();
				if (isset($this->request->post['oc_loader_torgsoft_show_not_changed'])) {
					$selected = $this->request->post['oc_loader_torgsoft_show_not_changed'];
				}else {
					if ($this->config->get('oc_loader_torgsoft_show_not_changed')){
						$selected = $this->config->get('oc_loader_torgsoft_show_not_changed');
					}
				}
				$values = array( array(1,$this->language->get('text_yes')), array(0,$this->language->get('text_no')));
				foreach ($values as $i => $value){
					$oc_loader_torgsoft_show_not_changed[$i]['name'] = $value[1];
					$oc_loader_torgsoft_show_not_changed[$i]['value'] = $value[0];
					$oc_loader_torgsoft_show_not_changed[$i]['selected'] = 0;
					if ($value[0] == $selected){
						$oc_loader_torgsoft_show_not_changed[$i]['selected'] = 1;
					}
				}
				$data['oc_loader_torgsoft_show_not_changed'] = $oc_loader_torgsoft_show_not_changed;
				
				// папки с кэшем для очистки
				if (isset($this->request->post['oc_loader_torgsoft_cache'])) {
					$data['oc_loader_torgsoft_cache'] = $this->request->post['oc_loader_torgsoft_cache'];
				}
				else {
					if ($this->config->get('oc_loader_torgsoft_cache')){
						$data['oc_loader_torgsoft_cache'] = $this->config->get('oc_loader_torgsoft_cache');
					}else{
						$data['oc_loader_torgsoft_cache'] = '';
					}
				}
				
				// заказы
				if (isset($this->request->post['oc_loader_torgsoft_order_status_to_exchange'])) {
					$data['oc_loader_torgsoft_order_status_to_exchange'] = $this->request->post['oc_loader_torgsoft_order_status_to_exchange'];
				} else {
					$data['oc_loader_torgsoft_order_status_to_exchange'] = $this->config->get('oc_loader_torgsoft_order_status_to_exchange');
				}
		
				if (isset($this->request->post['oc_loader_torgsoft_order_status'])) {
					$data['oc_loader_torgsoft_order_status'] = $this->request->post['oc_loader_torgsoft_order_status'];
				}
				else {
					$data['oc_loader_torgsoft_order_status'] = $this->config->get('oc_loader_torgsoft_order_status');
				}

				$this->load->model('localisation/order_status');
		
				$order_statuses = $this->model_localisation_order_status->getOrderStatuses();
		
				foreach ($order_statuses as $order_status) {
					$data['order_statuses'][] = array(
						'order_status_id' => $order_status['order_status_id'],
						'name'			  => $order_status['name']
					);
				}
			}
			
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view("module/oc_loader_torgsoft_$version.tpl", $data));
	}

	private function validate($version) {

		if (!$this->user->hasPermission('modify', "module/oc_loader_torgsoft_$version")) {
			$this->error['warning'] = $this->language->get('oc_loader_torgsoft_error_permission');
		}else{
		
			if (isset($this->request->post['oc_loader_torgsoft_trs_file'])){
				if (trim($this->request->post['oc_loader_torgsoft_trs_file']) == '') {
					$this->error['file'] = $this->language->get('oc_loader_torgsoft_file_not_exist');
				}else{
					$input_file = trim($this->request->post['oc_loader_torgsoft_trs_file']);
					if (!is_file('../'.$input_file)){
						$this->error['file'] = $this->language->get('oc_loader_torgsoft_file_not_exist');
					}else{
						
						// папка для SAL - проверка на запись
						$trs_dir = '../'.dirname($input_file).'/';
						if (is_dir($trs_dir)){
	
							$handle = fopen($trs_dir.'test_sal.tmp', "w");
							if ($handle === false){
								$this->error['output'] = $this->language->get('oc_loader_torgsoft_error_file_sal_create');
							}else{
								$bytes = fwrite($handle, "writing to tempfile");
								if ($bytes == strlen("writing to tempfile")){
									
								}else{
									$this->error['output'] = $this->language->get('oc_loader_torgsoft_error_file_sal_write');
								}
								fclose($handle);
								unlink($trs_dir.'test_sal.tmp');
							}
							
						}else{
							$this->error['dir'] = $this->language->get('oc_loader_torgsoft_error_sal_dir');
						}
						
						// отметка ключа
						if (!isset($this->request->post['oc_loader_torgsoft_key'])){
							$this->error['key'] = $this->language->get('oc_loader_torgsoft_error_key');
						}else{
							
							// выбор обязательных колонок
							$cols = array('GoodID', 'name', 'model', 'price', 'meta_title');
							foreach ($cols as $col){
								if ($this->request->post["oc_loader_torgsoft_$col"] == '0'){ //$this->language->get('oc_loader_torgsoft_select_column')){
									$this->error['cols'] = $this->language->get('oc_loader_torgsoft_error_cols');
								}
							}
							
							// заполнение обязательных полей
							$cols = array('meta_title_category', 'meta_title');
							foreach ($cols as $col){
								if (trim($this->request->post["oc_loader_torgsoft_$col"]) == ''){
									$this->error['fields'] = $this->language->get('oc_loader_torgsoft_error_fields');
								}
							}
							
							// допустимые расширения входных файлов изображений
							$exts = array('jpg', 'jpeg', 'png', 'gif');
							$image_exts = explode(',' ,trim($this->request->post['oc_loader_torgsoft_image_ext']));
							$found = false;
							foreach ($image_exts as $ext){
								if (in_array($ext, $exts)){
									$found = true;
									break;
								}
							}
							if (!$found){
								$this->error['exts'] = $this->language->get('oc_loader_torgsoft_error_exts').' '.implode(',', $exts);
							}
							
							// допустимые расширения выходных файлов изображений
							$exts = array('jpg', 'png');
							$output_ext = trim($this->request->post['oc_loader_torgsoft_image_output']);
							$found = false;
							if (!in_array($output_ext, $exts)){
								$this->error['output'] = $this->language->get('oc_loader_torgsoft_error_output').' '.implode(',', $exts);
							}
							
							// допустимое качество изображения в зависимости от типа
							$value = (int)trim($this->request->post['oc_loader_torgsoft_image_quality']);
							switch ($output_ext){
								case 'jpg':
									if (50 <= $value AND $value <= 100){
										// ок
									}else{
										$this->error['quality'] = $this->language->get('oc_loader_torgsoft_error_quality').' 50 - 100';
									}
									break;
								case 'png':
									if (0 <= $value AND $value <= 9){
										// ок
									}else{
										$this->error['quality'] = $this->language->get('oc_loader_torgsoft_error_quality').' 0 - 9';
									}
									break;
							}
							
							// папка для фото - проверка на запись
							if (!is_dir('../image/'.trim($this->request->post['oc_loader_torgsoft_image_dir']))){
								$mk = mkdir('../image/'.trim($this->request->post['oc_loader_torgsoft_image_dir']));
								if ($mk === false){
									$this->error['create_output'] = $this->language->get('oc_loader_torgsoft_error_dir_create');
								}else{
									chmod('../image/'.trim($this->request->post['oc_loader_torgsoft_image_dir']), 0775);
								}
							}
							if (is_dir('../image/'.trim($this->request->post['oc_loader_torgsoft_image_dir']))){
								$dir = '../image/'.trim($this->request->post['oc_loader_torgsoft_image_dir']);
								$handle = fopen($dir.'/test_img.tmp', "w");
								if ($handle === false){
									$this->error['output'] = $this->language->get('oc_loader_torgsoft_error_file_create');
								}else{
									$bytes = fwrite($handle, "writing to tempfile");
									if ($bytes == strlen("writing to tempfile")){
										
									}else{
										$this->error['output'] = $this->language->get('oc_loader_torgsoft_error_file_write');
									}
									fclose($handle);
									unlink($dir.'/test_img.tmp');
								}
								
							}else{
								$this->error['dir'] = $this->language->get('oc_loader_torgsoft_error_dir');
							}
							
							// не совпадение статусов заказов
							if ($this->request->post['oc_loader_torgsoft_order_status_to_exchange'] == $this->request->post['oc_loader_torgsoft_order_status']){
								$this->error['order'] = $this->language->get('oc_loader_torgsoft_error_order');
							}
						}
						
					}
				}
			}
		
//		if (isset($this->request->post['oc_loader_torgsoft_trs_file'])) {
//				$data['oc_loader_torgsoft_trs_file'] = $this->request->post['oc_loader_torgsoft_trs_file'];
//			}else {
//				if ($this->config->get('oc_loader_torgsoft_trs_file')){
//					$data['oc_loader_torgsoft_trs_file'] = $this->config->get('oc_loader_torgsoft_trs_file');
//				}else{
//					$data['oc_loader_torgsoft_trs_file'] = 'trs/TSGoods.trs';
//				}
//			}
//			
//			if (is_file('../'.$input_file)){
//				$oc_loader_torgsoft_file_exist = true;
//			}else{
//				$oc_loader_torgsoft_file_exist = false;
//				$data['error_warning'] = $this->language->get('oc_loader_torgsoft_file_not_exist');
//			}

		}

		if (!$this->error){
			return true;
		}else {
			return false;
		}
	}

	public function install() {}

	public function uninstall() {
		// удаление всех настроек
		$this->model_setting_setting->deleteSetting('oc_loader_torgsoft');
	}
	
	private function curl_get_contents($url, array $get = array(), array $options = array())
{    
	
//	usleep(50000);
	
    $defaults = array(
       CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($get),
       CURLOPT_HEADER => 0,
       CURLOPT_RETURNTRANSFER => TRUE,
       CURLOPT_FOLLOWLOCATION => 1,
       CURLOPT_TIMEOUT => 60,
//       CURLOPT_HTTPHEADER => array('Accept: application/json'),
       CURLOPT_SSL_VERIFYPEER => false
    );
   
    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
    if(!$result = curl_exec($ch)) {
       	trigger_error(curl_error($ch));
		$result = 'error: '.curl_error($ch);
    }else{
    	//echo 'OK';
    }
    curl_close($ch);
   
    return $result;
}

	private function getCategoriesByParentId($parent_id = 0) {
		$query = $this->db->query("SELECT *, (SELECT COUNT(parent_id) FROM " . DB_PREFIX . "category WHERE parent_id = c.category_id) AS children FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name");

		return $query->rows;
	}

}


