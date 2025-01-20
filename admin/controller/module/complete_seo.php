<?php
register_shutdown_function('gkd_fatal_handler');
set_error_handler('var_dump', 0);

function gkd_fatal_handler() {
  $error = error_get_last();
  
  if (!empty($error['type']) && $error['type'] == '1') {
    ob_end_clean();
    if ($error !== NULL) {
      echo 'Error: ' . $error['message'] . ' in ' . $error['file'] . ' on line '  . $error['line'];
    } else {
      echo 'Unknown fatal error';
    }
    
    if (!empty($_SESSION['seopackage_lastItem'])) {
      echo "\n".'Last item id: '.$_SESSION['seopackage_lastItem'];
    }
  }
}

class ControllerModuleCompleteSeo extends Controller {
  const MODULE = 'complete_seo';
  const PREFIX = 'mlseo';
  
  private $error = array();
  private $OC_VERSION;
  private $OC_V2;
  private $OC_V21X;
  private $OC_V22X;
  private $OC_V23X;
  private $EXT_23X = '';
  private $OC_V151;
  private $ml_mode = false;
  private $start;
  private $front_url;
  private $total_items;
  private $limit = 500;
  private $edit_action = 'edit';
  
  public function __construct($registry) {
    ini_set('memory_limit', -1);
      $this->OC_VERSION = (int) str_replace('.', '', substr(VERSION, 0, 5));
      $this->OC_V2 = (substr(VERSION, 0, 1) == 2);
      $this->OC_V151 = (substr(VERSION, 0, 5) == '1.5.1');
      $this->OC_V21X = version_compare(VERSION, '2.1', '>=');
      $this->OC_V22X = version_compare(VERSION, '2.2', '>=');
      $this->OC_V23X = version_compare(VERSION, '2.3', '>=');
      
      if ($this->OC_V23X) {
        $this->EXT_23X = 'extension/';
      }
      
      if (!$this->OC_V2) {
        $this->edit_action = 'update';
      }
    
    parent::__construct($registry);
      $this->load->language('module/complete_seo');
    
    if ($this->config->get('mlseo_ml_mode')) {
      $this->ml_mode = true;
    }
    
    // front url handler
    $this->front_url = new Url(HTTP_CATALOG, $this->config->get('config_secure') ? HTTP_CATALOG : HTTPS_CATALOG);
    
    if ($this->config->get('config_seo_url')) {
      if ($this->OC_V22X) {
        $seourl_file = DIR_SYSTEM.'../catalog/controller/startup/seo_url.php';
      } else {
        $seourl_file = DIR_SYSTEM.'../catalog/controller/common/seo_url.php';
      }
      
      if (isset($vqmod)) {
        require_once($vqmod->modCheck($seourl_file));
      } else if (class_exists('VQMod') && function_exists('modification')) {
        require_once(VQMod::modCheck(modification($seourl_file), $seourl_file));
      } else if (class_exists('VQMod')) {
        require_once(VQMod::modCheck($seourl_file));
      } else {
        require_once($seourl_file);
      }
      
      if ($this->OC_V22X) {
        $rewriter = new ControllerStartupSeoUrl($this->registry);
      } else {
        $rewriter = new ControllerCommonSeoUrl($this->registry);
      }
      
      $this->front_url->addRewrite($rewriter);
    }
  }

  public function index() {
    if (!empty($this->request->get['clear_cli_logs']) && file_exists(DIR_LOGS.'seo_package_cli.log')) {
      unlink(DIR_LOGS.'seo_package_cli.log');
      
      if ($this->OC_V2) {
        $this->response->redirect($this->url->link('module/complete_seo', 'token=' . $this->session->data['token'], 'SSL'));
      } else {
        $this->redirect($this->url->link('module/complete_seo', 'token=' . $this->session->data['token'], 'SSL'));
      }
    }
    
    // check tables
    if ($this->OC_V23X && !$this->config->has('mlseo_default_lang')) {
      $this->install('redir');
    } else {
     $this->db_tables();
    }
    
    $data['_language'] = &$this->language;
    $data['_config'] = &$this->config;
    $data['_url'] = &$this->url;
    $data['token'] = $this->session->data['token'];
    $data['OC_VERSION'] = $this->OC_VERSION;
    $data['OC_V2'] = $this->OC_V2;
    $data['OC_V151'] = $this->OC_V151;
    
    $asset_path = 'view/seo_package/';
    
    if (!$this->OC_V2) {
      $this->document->addScript($asset_path . 'jquery-migrate.js');
      $this->document->addStyle($asset_path . 'awesome/css/font-awesome.min.css');
      $this->document->addStyle($asset_path . 'bootstrap.min.css');
      $this->document->addStyle($asset_path . 'bootstrap-theme.min.css');
      $this->document->addScript($asset_path . 'bootstrap.min.js');
    }
    
    $this->document->addStyle($asset_path . 'prettyCheckable.css');
		$this->document->addScript($asset_path . 'prettyCheckable.js');
    $this->document->addScript($asset_path . 'itoggle.js');
    $this->document->addScript($asset_path . 'jquery-editable.min.js');
    $this->document->addScript($asset_path . 'select2.min.js');
    $this->document->addScript($asset_path . 'toggler.js');
    $this->document->addStyle($asset_path . 'jquery-editable.css');
    $this->document->addScript($asset_path . 'jquery.dataTables.min.js');
    $this->document->addStyle($asset_path . 'jquery.dataTables.min.css');
    $this->document->addStyle($asset_path . 'select2.min.css');
    $this->document->addStyle($asset_path . 'style.css');
    $this->document->setTitle(strip_tags($this->language->get('heading_title')));
    $this->load->model('setting/setting');
    
    // get languages 
    $this->load->model('localisation/language');
    $languages = $data['languages'] = $this->model_localisation_language->getLanguages();
    
    $current_lang_codes = array();
    
    foreach ($data['languages'] as &$language) {
      if ($this->OC_V22X) {
        $language['image'] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $language['image'] = 'view/image/flags/'. $language['image'];
      }
      
      if ($language['status']) {
        $current_lang_codes[$language['language_id']] = $language['code'];
      }
    }
    
    /*
    $langCodeToId = $langIdToCode = array();
    
    foreach ($languages as $lang) {
      $langCodeToId[$lang['code']] = $lang['language_id'];
      $langIdToCode[$lang['language_id']] = $lang['code'];
    }
    */
    
    // Store SEO tab
    $this->load->model('setting/store');
    
    $data['stores'] = array();
    $data['stores'][] = array(
      'store_id' => 0,
      'name'     => $this->config->get('config_name')
    );

    $stores = $this->model_setting_store->getStores();

    foreach ($stores as $store) {
      $action = array();

      $data['stores'][] = array(
        'store_id' => $store['store_id'],
        'name'     => $store['name']
      );
    }
    
    // prepare store binding for use with store rewriting
    $lang_to_store = array();
    
    foreach ($data['stores'] as $store) {
      $store_info = $this->model_setting_setting->getSetting('config', $store['store_id']);
      
      $lang_to_store[$store_info['config_language']] = array(
        'config_url' => !empty($store_info['config_url']) ? $store_info['config_url'] : HTTP_CATALOG,
        'config_ssl' => !empty($store_info['config_ssl']) ? $store_info['config_ssl'] : HTTPS_CATALOG,
      );
    }
    
    // module installation check
    if (is_file(DIR_CATALOG.'../vqmod/xml/multilingual_seo.xml')) {
      $this->session->data['error'] = 'Old version of the module detected, please remove this file :<b>/vqmod/xml/multilingual_seo.xml</b>';
    }
    
    $modification_active = false;
    
    if (!$modification_active) {
      $this->session->data['error'] = 'Module modification are not applied<br/>- if you installed ocmod version, go to extensions > modifications and push refresh button<br/>- if you installed vqmod version, make sure vqmod is correctly installed and working';
    }

    if (!is_file(DIR_CATALOG.'../.htaccess')) {
      $this->session->data['error'] = 'htaccess file not found : Please rename <b>.htaccess.txt</b> to <b>.htaccess</b> in order to enable url rewrinting';
    }

    /* not necessary anymore
    if ($this->config->get('mlseo_flag') || (isset($this->request->post['mlseo_flag']) && $this->request->post['mlseo_flag'])) {
      $htaccess = file_get_contents(DIR_CATALOG.'../.htaccess');
      if (strpos($htaccess, 'index.php?_route_=$2&site_language=$1') === false) {
        if (is_writable(DIR_CATALOG.'../.htaccess')) {
          $htaccess = str_replace('RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]', '#RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]'."\n".'RewriteRule ^(?:(?:(\\w{2})(?:/|\\z))?(?:/|\\z)?)?(?:([^?]*))? index.php?_route_=$2&site_language=$1 [L,QSA]', $htaccess);
          file_put_contents(DIR_CATALOG.'../.htaccess', $htaccess);
        } else {
          $this->session->data['error'] = 'htaccess file not writable : Please do the following procedure in order to use language prefix mode: <br/>- Open <b>.htaccess.txt</b><br/>- Find the line : <b>RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]</b> <br/>- add a "#" before this provious line, like this : <b>#RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]</b><br/>- And add this code just below the previous line : <b>RewriteRule ^(?:(?:(\\w{2})(?:/|\\z))?(?:/|\\z)?)?(?:([^?]*))? index.php?_route_=$2&site_language=$1 [L,QSA]</b>';
        }
      }
    }
    */
    
    // restore default htaccess
    if ($this->config->get('mlseo_flag') || (isset($this->request->post['mlseo_flag']) && $this->request->post['mlseo_flag'])) {
      $htaccess = file_get_contents(DIR_CATALOG.'../.htaccess');
      if (strpos($htaccess, 'index.php?_route_=$2&site_language=$1') !== false) {
        if (is_writable(DIR_CATALOG.'../.htaccess')) {
          $htaccess = str_replace('#RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]', 'RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]', $htaccess);
          $htaccess = str_replace('RewriteRule ^(?:(?:(\\w{2})(?:/|\\z))?(?:/|\\z)?)?(?:([^?]*))? index.php?_route_=$2&site_language=$1 [L,QSA]', '', $htaccess);
          file_put_contents(DIR_CATALOG.'../.htaccess', $htaccess);
        } else {
          $this->session->data['error'] = 'Upgrade from old version, please edit your htaccess file like this :<br/>Remove the entire line: <b>RewriteRule ^(?:(?:(\\w{2})(?:/|\\z))?(?:/|\\z)?)?(?:([^?]*))? index.php?_route_=$2&site_language=$1 [L,QSA]</b><br/>Remove the # before the line: <b>#RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]</b>';
        }
      }
    }
    
    if (!$this->OC_V22X) {
      $index = file_get_contents(DIR_CATALOG.'../index.php');
        if (strpos($index, 'new multilingual_seo') === false) {
        $this->session->data['error'] = 'Install not complete : multilingual_seo class declaration not found in index.php, maybe the file was not writeable, manual procedure : <br/>- open index.php<br />- find the text (without outter quotes): $languages = array();<br/>- add just below the previous line this text: $multilingual = new multilingual_seo($registry); $multilingual->detect();';
      }
    }
    
    // handle form submit
    if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
      // define multilingual handler
      $this->request->post['mlseo_enabled'] = true;
      $this->request->post['mlseo_ml_mode'] = (count($languages) > 1);
      $this->request->post['mlseo_lang_codes'] = $current_lang_codes;
      
      // save store bindings
      $this->request->post['mlseo_lang_to_store'] = $lang_to_store;
      
      unset($this->request->post['langs'], $this->request->post['simulate'], $this->request->post['empty_only'], $this->request->post['redirect_mode']);
      /*<complete*/
      /* now included in main xml
      // full product path 
      if (isset($this->request->post['full_product_path']) && is_file(DIR_CATALOG.'../vqmod/xml/full_product_path.xml.disabled')) {
        if (!rename(DIR_CATALOG.'../vqmod/xml/full_product_path.xml.disabled', DIR_CATALOG.'../vqmod/xml/full_product_path.xml'))
          $this->session->data['error'] = 'Error: /vqmod/xml/ is not writeable.';
      }
      elseif (!isset($this->request->post['full_product_path']) && is_file(DIR_CATALOG.'../vqmod/xml/full_product_path.xml')) {
        if (!rename(DIR_CATALOG.'../vqmod/xml/full_product_path.xml', DIR_CATALOG.'../vqmod/xml/full_product_path.xml.disabled'))
          $this->session->data['error'] = 'Error: /vqmod/xml/ is not writeable.';
      }
      */
      
      // urls management
      foreach($data['languages'] as $lang)
      {
        if (isset($this->request->post['mlseo_urls_'.$lang['code']]))
        $this->request->post['mlseo_urls_'.$lang['code']] =  array_combine($this->request->post['mlseo_urls_'.$lang['code']]['keys'], $this->request->post['mlseo_urls_'.$lang['code']]['values']);
      }
      
      /*complete>*/
      $this->request->post['mlseo_default_lang'] = !empty($this->request->post['mlseo_flag_short']) ? strstr($this->config->get('config_language'), '-', true) : $this->config->get('config_language');
      $this->model_setting_setting->editSetting('mlseo', $this->request->post);    
      $this->session->data['success'] = $this->language->get('text_success');
      
      if ($this->OC_V2) {
        $this->response->redirect($this->url->link('module/complete_seo', 'token=' . $this->session->data['token'], 'SSL'));
      } else {
        $this->redirect($this->url->link('module/complete_seo', 'token=' . $this->session->data['token'], 'SSL'));
      }
    }
    
    // module checks
    if ($current_lang_codes !== $this->config->get('mlseo_lang_codes')) {
      $this->session->data['error'] = 'It seems you have modified your languages configuration, please save module options to activate multilingual handling';
    }
    
    if (!$this->config->get('mlseo_ml_mode') && (count($languages) > 1)) {
      $this->session->data['error'] = 'It seems you have installed another language, please save module options to activate multilingual handling';
    }
    
    if (!$this->config->get('mlseo_enabled')) {
      $this->session->data['error'] = 'Module not enabled, save settings to enable it.';
    }
    //$data['products'] = $this->db->query("SELECT product_id, name FROM " . DB_PREFIX . "product_description WHERE language_id=" . $this->config->get('config_language_id') . " ORDER BY name")->rows;
    
    $this->load->model('setting/friendlyurls');
    $data['friendly_urls_langs'] = $this->model_setting_friendlyurls->getAvailableLangs();
    
    // version check
    $module_xml = 'seo_package';
    
		if (is_file(DIR_SYSTEM.'../vqmod/xml/'.$module_xml.'.xml')) {
			$data['module_version'] = simplexml_load_file(DIR_SYSTEM.'../vqmod/xml/'.$module_xml.'.xml')->version;
      $data['module_type'] = 'vqmod';
		} else if (is_file(DIR_SYSTEM.'../system/'.$module_xml.'.ocmod.xml')) {
      $data['module_version'] = simplexml_load_file(DIR_SYSTEM.'../system/'.$module_xml.'.ocmod.xml')->version;
      $data['module_type'] = 'ocmod';
    } else {
      $data['module_version'] = 'not found';
      $data['module_type'] = '';
		}
    
    if (is_file(DIR_SYSTEM.'../vqmod/xml/'.$module_xml.'.xml') && is_file(DIR_SYSTEM.'../system/'.$module_xml.'.ocmod.xml')) {
      $this->error['warning'] = 'Warning : both vqmod and ocmod version are installed<br/>- delete /vqmod/xml/'.$module_xml.'.xml if you want to use ocmod version<br/>- or delete /system/'.$module_xml.'.ocmod.xml if you want to use vqmod version';
    }
    
    if (isset($this->session->data['success'])) {
      $data['success'] = $this->session->data['success'];
      unset($this->session->data['success']);
    } else $data['success'] = '';
    
    if (isset($this->session->data['error'])) {
      $data['error'] = $this->session->data['error'];
      unset($this->session->data['error']);
    } elseif (!empty($this->error['error'])) {
      $data['error'] = $this->error['error'];
    } else {
      $data['error'] = '';
    }
    
    $data['heading_title'] = $this->language->get('module_title');
    
    $data['button_save'] = $this->language->get('button_save');
    $data['button_cancel'] = $this->language->get('button_cancel');
    $data['button_add_module'] = $this->language->get('button_add_module');
    $data['button_remove'] = $this->language->get('button_remove');
    
    
    if (isset($this->error['warning'])) {
      $data['error_warning'] = $this->error['warning'];
    } else {
      $data['error_warning'] = '';
    }

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_home'),
      'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      'separator' => false
     );

     $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_module'),
      'href'      => $this->url->link(($this->OC_V23X) ? 'extension/extension' : 'extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      'separator' => ' :: '
     );
  
     $data['breadcrumbs'][] = array(
      'text'      => strip_tags($this->language->get('heading_title')),
      'href'      => $this->url->link($this->EXT_23X.'module/complete_seo', 'token=' . $this->session->data['token'], 'SSL'),
      'separator' => ' :: '
     );
    
    $data['action'] = $this->url->link('module/complete_seo', 'token=' . $this->session->data['token'], 'SSL');
    $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
    
    /*complete>*/

    /*<complete*/
    
    // CLI logs
    $data['cli_log'] = $data['cli_log_link'] = '';
    
    $file = DIR_LOGS.'seo_package_cli.log';
    
		if (file_exists($file)) {
      $data['cli_log_link'] = $this->url->link('module/complete_seo/save_cli_log', 'token=' . $this->session->data['token'], 'SSL');
			$size = filesize($file);

			if ($size >= 5242880) {
				$suffix = array(
					'B',
					'KB',
					'MB',
					'GB',
					'TB',
					'PB',
					'EB',
					'ZB',
					'YB'
				);

				$i = 0;

				while (($size / 1024) > 1) {
					$size = $size / 1024;
					$i++;
				}

				$data['cli_log'] = sprintf($this->language->get('text_cli_log_too_big'), round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]);
			} else {
				$data['cli_log'] = file_get_contents($file);
			}
		}
    
    $prefix = 'mlseo_';
    
    $params_array = array(
      // main options
      'mlseo_friendly',
      'mlseo_absolute',
      'mlseo_redirect_dynamic',
      'mlseo_cat_slash',
      'mlseo_cache',
      'mlseo_banners',
      
      // language prefix
      'mlseo_flag',
      'mlseo_flag_short',
      'mlseo_flag_upper',
      'mlseo_flag_default',
      
      // language prefix
      'mlseo_store_mode',
      
      // pagination
      'mlseo_pagination',
      'mlseo_pagination_fix',
      
      // reviews
      'mlseo_reviews',
      
      // canonical
      'mlseo_canonical',
      
      // hreflang
      'mlseo_hreflang',
      
      // store seo
      'mlseo_store',
      
      // Keyword options
      'mlseo_whitespace',
      'mlseo_extension',
      'mlseo_lowercase',
      'mlseo_duplicate',
      
      // auto-update
      'mlseo_insertautotitle',
      'mlseo_editautotitle',
      'mlseo_insertautourl',
      'mlseo_editautourl',
      'mlseo_insertautoseotitle',
      'mlseo_editautoseotitle',
      'mlseo_insertautometakeyword',
      'mlseo_editautometakeyword',
      'mlseo_insertautometadesc',
      'mlseo_editautometadesc',
      
      // mass update
      'mlseo_product_url_pattern',
      'mlseo_product_title_pattern',
      'mlseo_product_h1_pattern',
      'mlseo_product_h2_pattern',
      'mlseo_product_h3_pattern',
      'mlseo_product_keyword_pattern',
      'mlseo_product_description_pattern',
      'mlseo_product_full_desc_pattern',
      'mlseo_product_image_name_pattern',
      'mlseo_product_image_alt_pattern',
      'mlseo_product_image_title_pattern',
      'mlseo_product_tag_pattern',
      'mlseo_product_related_no',
      'mlseo_product_related_relevance',
      'mlseo_category_url_pattern',
      'mlseo_category_h1_pattern',
      'mlseo_category_h2_pattern',
      'mlseo_category_h3_pattern',
      'mlseo_category_title_pattern',
      'mlseo_category_keyword_pattern',
      'mlseo_category_description_pattern',
      'mlseo_category_full_desc_pattern',
      'mlseo_information_url_pattern',
      'mlseo_information_h1_pattern',
      'mlseo_information_h2_pattern',
      'mlseo_information_h3_pattern',
      'mlseo_information_title_pattern',
      'mlseo_information_keyword_pattern',
      'mlseo_information_description_pattern',
      'mlseo_information_full_desc_pattern',
      'mlseo_manufacturer_url_pattern',
      
      // rich snippets
      'mlseo_microdata',
      'mlseo_microdata_data',
      'mlseo_opengraph',
      'mlseo_opengraph_data',
      'mlseo_tcard',
      'mlseo_tcard_data',
      'mlseo_gpublisher',
      'mlseo_gpublisher_data',
      
      // cron
      'mlseo_cron',
    );
    
    // $data['full_product_path'] = (is_file(DIR_CATALOG.'../vqmod/xml/full_product_path.xml'));
      
    // full product path - start
    $pm_prefix = 'mlseo_fpp_';
    
    $params_array[] = $pm_prefix . 'mode';
    $params_array[] = $pm_prefix . 'depth';
    $params_array[] = $pm_prefix . 'breadcrumbs';
    $params_array[] = $pm_prefix . 'cat_canonical';
    $params_array[] = $pm_prefix . 'bc_mode';
    $params_array[] = $pm_prefix . 'bypasscat';
    $params_array[] = $pm_prefix . 'directcat';
    $params_array[] = $pm_prefix . 'homelink';
    $params_array[] = $pm_prefix . 'brand_parent';
    $params_array[] = $pm_prefix . 'remove_search';
    $params_array[] = $pm_prefix . 'categories';
    
    // categories management
    $this->load->model('catalog/category');
    $data['categories'] = $this->model_catalog_category->getCategories(0);
    
    // full product path - end
    
    /*complete>*/
    
    foreach ($params_array as $param_name) {
      if (isset($this->request->post[$param_name])) {
        $data[$param_name] = $this->request->post[$param_name];
      } else {
        $data[$param_name] = $this->config->get($param_name);
      }
    }
    
    if ($this->OC_V2) {
      $data['header'] = $this->load->controller('common/header');
      $data['column_left'] = $this->load->controller('common/column_left');
      $data['footer'] = $this->load->controller('common/footer');
      
      $this->response->setOutput($this->load->view('module/complete_seo.tpl', $data));
    } else {
      $data['column_left'] = '';
      $this->data = &$data;
      $this->template = 'module/complete_seo.tpl';
      $this->children = array(
        'common/header',
        'common/footer'
      );

      $this->response->setOutput(str_replace(array('view/javascript/jquery/jquery-1.6.1.min.js', 'view/javascript/jquery/jquery-1.7.1.min.js'), $asset_path . 'jquery.min.js', $this->render()));
    }
  }
  
  public function save_cli_log() {
    $file = DIR_LOGS.'seo_package_cli.log';
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename=seo_package_cron.log');
    header('Content-Type: text/plain');
    header('Cache-Control: must-revalidate');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
  }
  
  public function generator_related_product($mode, $simulate, $empty_only, $redirect) {
    $this->load->model('tool/seo_package');
    
    $values = $data = array();
    $data['langs'][0]['lang_img'] = '';
      
    $rows = $this->db->query("SELECT pd.*, p.* FROM " . DB_PREFIX . "product_description pd LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = pd.product_id WHERE language_id=" . $this->config->get('config_language_id') . " ORDER BY pd.product_id,pd.language_id LIMIT ".$this->start.",".$this->limit)->rows;
    
    foreach ($rows as $row) {
      $related = $this->db->query("SELECT pr.related_id, pd.name FROM " . DB_PREFIX . "product_related pr LEFT JOIN " . DB_PREFIX . "product_description pd ON pd.product_id = pr.related_id WHERE pr.product_id=" . $row['product_id'] . " AND pd.language_id=" . $this->config->get('config_language_id'))->rows;
      
      $old_related = array();
      foreach ($related as $rel) {
        $old_related[] = '- ' . $rel['name'];
      }
      
      if ($empty_only) {
        if (count($related)) {
          continue;
        }
      } else {
        if (!$simulate) {
          $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $row['product_id'] . "'" );
        }
      }
      
      $prod_name = str_replace(array('%', '#', "'", '"'), '', $row['name']);
      $prod_desc = str_replace(array('\n', '\r', '%', '#', "'", '"'), '', $row['description']);
      
      if (isset($this->request->get['mlseo_product_related_relevance']) && $this->request->get['mlseo_product_related_relevance'] != '') {
        $relevance = $this->request->get['mlseo_product_related_relevance'];
      } else if ($this->config->get('mlseo_product_related_relevance') != '') {
        $relevance = $this->config->get('mlseo_product_related_relevance');
      } else {
        $relevance = 2;
      }
      
      if (isset($this->request->get['mlseo_product_related_no']) && $this->request->get['mlseo_product_related_no']) {
        $max_items = $this->request->get['mlseo_product_related_no'];
      } else if ($this->config->get('mlseo_product_related_no')) {
        $max_items = $this->config->get('mlseo_product_related_no');
      } else {
        $max_items = 5;
      }
      
      $results = $this->db->query("SELECT DISTINCT ROUND(MATCH (pd.name, pd.description) AGAINST ('" . $prod_name . " " . $prod_desc . "'), 0) / 5 as relevance,  p.product_id, pd.name FROM " . DB_PREFIX . "product_description pd LEFT JOIN " . DB_PREFIX . "product p on pd.product_id = p.product_id INNER JOIN " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id WHERE p.product_id <> " . $row['product_id'] . "  AND p.status = 1 GROUP BY p.product_id HAVING relevance >= " . (int) $relevance . " ORDER BY relevance DESC LIMIT 0, " . (int) $max_items)->rows;
      
      $new_related = array();
      foreach ($results as $res) {
        if (!$simulate) {
          $this->db->query("INSERT INTO " . DB_PREFIX . "product_related (product_id, related_id) VALUES (" . $row['product_id'] . ", " . $res['product_id'] . ")");
        }
        $new_item = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_description WHERE product_id=" . $res['product_id'] . " AND language_id=" . $this->config->get('config_language_id'))->row;
        $new_related[] = '- ' . $new_item['name'];
      }
      sort($old_related);
      sort($new_related);
      $values[] = array(
        'link' =>  $this->url->link('catalog/product/'.$this->edit_action, 'token=' . $this->session->data['token'] . '&product_id=' . $row['product_id'], 'SSL'),
        'name' =>  $row['name'],
        'old_value' =>  implode('<br/> ', $old_related),
        'value' =>  implode("<br/> ", $new_related),
        'changed' =>  $old_related != $new_related,
      );
    }
    
    $data['langs'][0]['rows'] = &$values;
    return $data;
  }
  
  public function generator_product($mode, $simulate, $empty_only, $redirect) {
    if ($mode == 'related') return $this->generator_related_product($mode, $simulate, $empty_only, $redirect);
    
    if (!isset($this->request->post['langs'])) { $data['langs'] = array(); die('No language selected');}
    
    // get languages 
    $this->load->model('tool/seo_package');
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    foreach($languages as $language)
    {
      $lang_code[$language['language_id']] = $language['code'];
      if ($this->OC_V22X) {
        $lang_img[$language['language_id']] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $lang_img[$language['language_id']] = 'view/image/flags/'. $language['image'];
      }
    }
    unset($languages);
    
    $image_simulate = array();
    if ($mode == 'image_name' && count($this->request->post['langs']) > 1) {
      die('<div class="alert alert-warning"><i class="fa fa-warning"> ' . $this->language->get('text_image_name_lang') . '</i></div>');
    }
    
    switch ($mode) {
      case 'url': $field = 'seo_keyword'; break;
      case 'h1': $field = 'seo_h1'; break;
      case 'h2': $field = 'seo_h2'; break;
      case 'h3': $field = 'seo_h3'; break;
      case 'title': $field = 'meta_title'; break;
      case 'keyword': $field = 'meta_keyword'; break;
      case 'description': $field = 'meta_description'; break;
      case 'full_desc': $field = 'description'; break;
      case 'image_name': $field = 'image'; break;
      case 'image_title': $field = 'image_title'; break;
      case 'image_alt': $field = 'image_alt'; break;
      case 'tag': $field = 'tag'; break;
    }
      
    $values = $data = array();
    foreach($this->request->post['langs'] as $lang)
    {
      $this->config->set('mlseo_current_lang', $lang_code[$lang]);
      $values[$lang]['lang_img'] = $lang_img[$lang];
      $values[$lang]['rows'] = array();
      $change_count = 0;
      
      if (isset($this->request->post['mlseo_product_'.$mode.'_pattern'])) {
        $pattern = $this->request->post['mlseo_product_'.$mode.'_pattern'];
      } else {
        $pattern = $this->config->get('mlseo_product_'.$mode.'_pattern');
      }
      
      $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "product_description pd LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = pd.product_id WHERE language_id=".$lang." ORDER BY pd.product_id,pd.language_id")->row;
      $this->total_items = $total['total'];
      
      $rows = $this->db->query("SELECT pd.*, p.* FROM " . DB_PREFIX . "product_description pd LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = pd.product_id WHERE language_id=".$lang." ORDER BY pd.product_id,pd.language_id LIMIT ".$this->start.",".$this->limit)->rows;
      foreach ($rows as $row)
      {
        $_SESSION['seopackage_lastItem'] = $row['product_id'];
        
        $pattern = str_replace('[current]', $row[$field], $pattern);
        $value = $this->model_tool_seo_package->transformProduct($pattern, $lang, $row);
        
        // urls
        if ($mode == 'url')
        {
          if ($empty_only && $row['seo_keyword']) continue;
          
          if (!$simulate) {
            if ($this->ml_mode) {
              $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . $row['product_id'] . "' AND language_id IN (".$lang.", 0)");
            } else {
              $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . $row['product_id'] . "'");
            }
          }
          
          $value = $this->model_tool_seo_package->filter_seo($value, 'product', $row['product_id'], $lang);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_description SET seo_keyword = '". $this->db->escape($value) ."' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
            if ($this->ml_mode) {
              $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . $row['product_id'] . "', language_id = '" . $row['language_id'] . "', keyword = '" . $this->db->escape($value) . "'");
            } else {
              $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . $row['product_id'] . "', keyword = '" . $this->db->escape($value) . "'");
            }
          }
          //$field = 'seo_keyword';
        }
        // Meta title
        elseif ($mode == 'h1')
        {
          if ($empty_only && $row['seo_h1']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_description SET seo_h1 = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'seo_h1';
        }
        elseif ($mode == 'h2')
        {
          if ($empty_only && $row['seo_h2']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_description SET seo_h2 = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'seo_h2';
        }
        elseif ($mode == 'h3')
        {
          if ($empty_only && $row['seo_h3']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_description SET seo_h3 = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'seo_h3';
        }
        // Meta title
        elseif ($mode == 'title')
        {
          if ($empty_only && $row['meta_title']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_title = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'meta_title';
        }
        // Meta keywords
        elseif ($mode == 'keyword')
        {
          if ($empty_only && $row['meta_keyword']) continue;
          
          $value = mb_strtolower(htmlentities($value, ENT_QUOTES));
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_keyword = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'meta_keyword';
        }
        // Meta description
        elseif ($mode == 'description')
        {
          if ($empty_only && $row['meta_description']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_description = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'meta_description';
        }
        // Description
        elseif ($mode == 'full_desc')
        {
          if ($empty_only && $row['description']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_description SET description = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'description';
        }
        // image name
        if ($mode == 'image_name')
        {
          if (!$row['image']) continue;
          
          $img_count = $this->db->query("SELECT COUNT(image) as count FROM " . DB_PREFIX . "product WHERE image='" . $row['image'] . "'")->row;
          if ($img_count['count'] > 1) continue;
          
          $path = pathinfo($row['image']);
          $filename = $this->model_tool_seo_package->filter_seo($value, 'image', '', $lang);
          $value = $path['dirname'] . '/' . $filename . '.' . $path['extension'];
          
          if ($row['image'] != $value) {
            
            $x = 1;
            
            if ($simulate) {
              while (file_exists(DIR_IMAGE . $value) || in_array(DIR_IMAGE . $value, $image_simulate)) {
                $value = $path['dirname'] . '/' . $filename . '-' . $x . '.' . $path['extension'];
                $x++;
              }
              $image_simulate[] = DIR_IMAGE . $value;
            } else {
              while (file_exists(DIR_IMAGE . $value)) {
                $value = $path['dirname'] . '/' . $filename . '-' . $x . '.' . $path['extension'];
                $x++;
              }
              if (rename(DIR_IMAGE . $row['image'], DIR_IMAGE . $value)) {
                $this->db->query("UPDATE " . DB_PREFIX . "product SET image = '". $this->db->escape($value) ."' WHERE product_id = '" . $row['product_id'] . "'");
              }
            }
          }
          // $field = 'image';
        }
         // Image title
        elseif ($mode == 'image_title')
        {
          if ($empty_only && $row['image_title']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_description SET image_title = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'image_title';
        }
         // Image alt
        elseif ($mode == 'image_alt')
        {
          if ($empty_only && $row['image_alt']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_description SET image_alt = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'image_alt';
        }
        // Tags
        elseif ($mode == 'tag')
        {
          if ($empty_only && $row['tag']) continue;
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_description SET tag = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'tag';
        }
        
        $changed = !($value === $row[$field]);
        
        if (!defined('SEO_PACKAGE_CLI')) {
          $values[$lang]['rows'][] = array(
            'link' =>  $this->url->link('catalog/product/'.$this->edit_action, 'token=' . $this->session->data['token'] . '&product_id=' . $row['product_id'], 'SSL'),
            'name' =>  $row['name'],
            'old_value' =>  $row[$field],
            'value' =>  $value,
            'changed' =>  $changed,
          );
        }
        
        if ($changed) {
          if (defined('SEO_PACKAGE_CLI')) {
            $this->log('product.' . $mode . ': [' . $lang_code[$lang] . '] ' . $row['name'] . ' => ' . $value);
          }
          $change_count++;
          //Powercache::remove('seo_rewrite', 'product_id=' . $row['product_id']);
        }
      } // end foreach $rows
      $values[$lang]['count'] = $change_count;
    }
    $data['langs'] = &$values;
    return $data;
  }
  
  public function generator_category($mode, $simulate, $empty_only, $redirect) {
    if (!isset($this->request->post['langs'])) { $data['langs'] = array(); return;}
    
    // get languages 
    $this->load->model('tool/seo_package');
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    foreach($languages as $language)
    {
      $lang_code[$language['language_id']] = $language['code'];
      if ($this->OC_V22X) {
        $lang_img[$language['language_id']] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $lang_img[$language['language_id']] = 'view/image/flags/'. $language['image'];
      }
    }
    unset($languages);
    
    switch ($mode) {
      case 'url': $field = 'seo_keyword'; break;
      case 'h1': $field = 'seo_h1'; break;
      case 'h2': $field = 'seo_h2'; break;
      case 'h3': $field = 'seo_h3'; break;
      case 'title': $field = 'meta_title'; break;
      case 'keyword': $field = 'meta_keyword'; break;
      case 'description': $field = 'meta_description'; break;
      case 'full_desc': $field = 'description'; break;
    }
    
    $values = $data = array();
    foreach($this->request->post['langs'] as $lang)
    {
      $this->config->set('mlseo_current_lang', $lang_code[$lang]);
      $values[$lang]['lang_img'] = $lang_img[$lang];
      $values[$lang]['rows'] = array();
      $change_count = 0;
      
      if (isset($this->request->post['mlseo_category_'.$mode.'_pattern'])) {
        $pattern = $this->request->post['mlseo_category_'.$mode.'_pattern'];
      } else {
        $pattern = $this->config->get('mlseo_category_'.$mode.'_pattern');
      }
      
      $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "category_description WHERE language_id=".$lang)->row;
      $this->total_items = $total['total'];
      
      $rows = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE language_id=".$lang." ORDER BY category_id LIMIT ".$this->start.",".$this->limit)->rows;
      foreach ($rows as $row)
      {
        $pattern = str_replace('[current]', $row[$field], $pattern);
        $value = $this->model_tool_seo_package->transformCategory($pattern, $lang, $row);
            
        // urls
        if ($mode == 'url')
        {
          if ($empty_only && $row['seo_keyword']) continue;
          
          if (!$simulate) {
            if ($this->ml_mode) {
              $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . $row['category_id'] . "' AND language_id IN (".$lang.", 0)");
            } else {
              $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . $row['category_id'] . "'");
            }
          }
          
          $value = $this->model_tool_seo_package->filter_seo($value, 'category', $row['category_id'], $lang);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "category_description SET seo_keyword = '". $this->db->escape($value) ."' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
            if ($this->ml_mode) {
              $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . $row['category_id'] . "', language_id = '" . $row['language_id'] . "', keyword = '" . $this->db->escape($value) . "'");
            } else {
              $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . $row['category_id'] . "', keyword = '" . $this->db->escape($value) . "'");
            }
          }
          // $field = 'seo_keyword';
        }
        // Meta title
        elseif ($mode == 'h1')
        {
          if ($empty_only && $row['seo_h1']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "category_description SET seo_h1 = '" . $this->db->escape($value) . "' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'seo_h1';
        }
        elseif ($mode == 'h2')
        {
          if ($empty_only && $row['seo_h2']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "category_description SET seo_h2 = '" . $this->db->escape($value) . "' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'seo_h1';
        }
        elseif ($mode == 'h3')
        {
          if ($empty_only && $row['seo_h3']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "category_description SET seo_h3 = '" . $this->db->escape($value) . "' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'seo_h1';
        }
        // Meta title
        elseif ($mode == 'title')
        {
          if ($empty_only && $row['meta_title']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "category_description SET meta_title = '" . $this->db->escape($value) . "' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'meta_title';
        }
        // Meta keywords
        elseif ($mode == 'keyword')
        {
          if ($empty_only && $row['meta_keyword']) continue;
          
          $value = mb_strtolower(htmlentities($value, ENT_QUOTES));
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "category_description SET meta_keyword = '" . $this->db->escape($value) . "' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'meta_keyword';
        }
        // Meta description
        elseif ($mode == 'description')
        {
          if ($empty_only && $row['meta_description']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "category_description SET meta_description = '" . $this->db->escape($value) . "' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'meta_description';
        }
        // Description
        elseif ($mode == 'full_desc')
        {
          if ($empty_only && $row['description']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "category_description SET description = '" . $this->db->escape($value) . "' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'description';
        }
        
        $changed = !($value === $row[$field]);
        
        if (!defined('SEO_PACKAGE_CLI')) {
          $values[$lang]['rows'][] = array(
            'link' =>  $this->url->link('catalog/category/'.$this->edit_action, 'token=' . $this->session->data['token'] . '&category_id=' . $row['category_id'], 'SSL'),
            'name' =>  $row['name'],
            'old_value' =>  $row[$field],
            'value' =>  $value,
            'changed' =>  $changed,
          );
        }
        
        if ($changed) {
          if (defined('SEO_PACKAGE_CLI')) {
            $this->log('category.' . $mode . ': [' . $lang_code[$lang] . '] ' . $row['name'] . ' => ' . $value);
          }
          $change_count++;
          //Powercache::remove('seo_rewrite', 'path=', $row['category_id']);
        }
      } // end foreach $rows
      $values[$lang]['count'] = $change_count;
    }
    $data['langs'] = &$values;
    return $data;
  }
  
  public function generator_information($mode, $simulate, $empty_only, $redirect) {
    if (!isset($this->request->post['langs'])) { $data['langs'] = array(); return;}
    
    // get languages 
    $this->load->model('tool/seo_package');
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    foreach($languages as $language)
    {
      $lang_code[$language['language_id']] = $language['code'];
      if ($this->OC_V22X) {
        $lang_img[$language['language_id']] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $lang_img[$language['language_id']] = 'view/image/flags/'. $language['image'];
      }
    }
    unset($languages);
    
    switch ($mode) {
      case 'url': $field = 'seo_keyword'; break;
      case 'h1': $field = 'seo_h1'; break;
      case 'h2': $field = 'seo_h2'; break;
      case 'h3': $field = 'seo_h3'; break;
      case 'title': $field = 'meta_title'; break;
      case 'keyword': $field = 'meta_keyword'; break;
      case 'description': $field = 'meta_description'; break;
      case 'full_desc': $field = 'description'; break;
    }
    
    $values = $data = array();
    foreach($this->request->post['langs'] as $lang)
    {
      $this->config->set('mlseo_current_lang', $lang_code[$lang]);
      $values[$lang]['lang_img'] = $lang_img[$lang];
      $values[$lang]['rows'] = array();
      $change_count = 0;
      
      if (isset($this->request->post['mlseo_information_'.$mode.'_pattern'])) {
        $pattern = $this->request->post['mlseo_information_'.$mode.'_pattern'];
      } else {
        $pattern = $this->config->get('mlseo_information_'.$mode.'_pattern');
      }
      
      $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "information_description WHERE language_id=".$lang)->row;
      $this->total_items = $total['total'];
      
      $rows = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_description WHERE language_id=".$lang." ORDER BY information_id LIMIT ".$this->start.",".$this->limit)->rows;
      foreach ($rows as $row)
      {
        $pattern = str_replace('[current]', $row[$field], $pattern);
        $value = $this->model_tool_seo_package->transformInformation($pattern, $lang, $row);
            
        // urls
        if ($mode == 'url')
        {
          if ($empty_only && $row['seo_keyword']) continue;
          
          if (!$simulate) {
            if ($this->ml_mode) {
              $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information_id=" . $row['information_id'] . "' AND language_id IN (".$lang.", 0)");
            } else {
              $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information_id=" . $row['information_id'] . "'");
            }
          }
          
          $value = $this->model_tool_seo_package->filter_seo($value, 'information', $row['information_id'], $lang);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "information_description SET seo_keyword = '". $this->db->escape($value) ."' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
            if ($this->ml_mode) {
              $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_id=" . $row['information_id'] . "', language_id = '" . $row['language_id'] . "', keyword = '" . $this->db->escape($value) . "'");
            } else {
              $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_id=" . $row['information_id'] . "', keyword = '" . $this->db->escape($value) . "'");
            }
          }
          // $field = 'seo_keyword';
        }
        // h1
        elseif ($mode == 'h1')
        {
          if ($empty_only && $row['seo_h1']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "information_description SET seo_h1 = '" . $this->db->escape($value) . "' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'seo_h1';
        }
        elseif ($mode == 'h2')
        {
          if ($empty_only && $row['seo_h2']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "information_description SET seo_h2 = '" . $this->db->escape($value) . "' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'seo_h1';
        }
        elseif ($mode == 'h3')
        {
          if ($empty_only && $row['seo_h3']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "information_description SET seo_h3 = '" . $this->db->escape($value) . "' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'seo_h1';
        }
        // Meta title
        elseif ($mode == 'title')
        {
          if ($empty_only && $row['meta_title']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "information_description SET meta_title = '" . $this->db->escape($value) . "' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'meta_title';
        }
        // Meta keywords
        elseif ($mode == 'keyword')
        {
          if ($empty_only && $row['meta_keyword']) continue;
          
          $value = mb_strtolower(htmlentities($value, ENT_QUOTES));
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "information_description SET meta_keyword = '" . $this->db->escape($value) . "' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'meta_keyword';
        }
        // Meta description
        elseif ($mode == 'description')
        {
          if ($empty_only && $row['meta_description']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "information_description SET meta_description = '" . $this->db->escape($value) . "' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'meta_description';
        }
        // Description
        elseif ($mode == 'full_desc')
        {
          if ($empty_only && $row['description']) continue;
          
          $value = htmlentities($value, ENT_QUOTES);
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "information_description SET description = '" . $this->db->escape($value) . "' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
          }
          // $field = 'description';
        }
        
        $changed = !($value === $row[$field]);
        
        if (!defined('SEO_PACKAGE_CLI')) {
          $values[$lang]['rows'][] = array(
            'link' =>  $this->url->link('catalog/information/'.$this->edit_action, 'token=' . $this->session->data['token'] . '&information_id=' . $row['information_id'], 'SSL'),
            'name' =>  $row['title'],
            'old_value' =>  $row[$field],
            'value' =>  $value,
            'changed' =>  $changed,
          );
        }
        
        if ($changed) {
          if (defined('SEO_PACKAGE_CLI')) {
            $this->log('information.' . $mode . ': [' . $lang_code[$lang] . '] ' . $row['title'] . ' => ' . $value);
          }
          $change_count++;
          //Powercache::remove('seo_rewrite', 'information_id=' . $row['information_id']);
        }
      } // end foreach $rows
      $values[$lang]['count'] = $change_count;
    }
    $data['langs'] = &$values;
    
    return $data;
  }
  
  public function generator_manufacturer($mode, $simulate, $empty_only, $redirect) {
    $this->load->model('tool/seo_package');
    
    $values = $data = array();
    $values['lang_img'] = '';
    $values['no_old'] = true;
    $values['rows'] = array();
    
    if (isset($this->request->post['mlseo_manufacturer_'.$mode.'_pattern'])) {
      $pattern = $this->request->post['mlseo_manufacturer_'.$mode.'_pattern'];
    } else {
      $pattern = $this->config->get('mlseo_manufacturer_'.$mode.'_pattern');
    }
    
    $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "manufacturer")->row;
    $this->total_items = $total['total'];
    
    $rows = $this->db->query("SELECT name, manufacturer_id, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('manufacturer_id=',manufacturer_id) LIMIT 1) AS seo_keyword FROM " . DB_PREFIX . "manufacturer ORDER BY manufacturer_id LIMIT ".$this->start.",".$this->limit)->rows;
    
    foreach ($rows as $row)
    {
      //Powercache::remove('seo_rewrite', 'manufacturer_id=' . $row['manufacturer_id']);
      $pattern = str_replace('[current]', $row['seo_keyword'], $pattern);
      $value = $this->model_tool_seo_package->transformManufacturer($pattern, false, $row);
      
      if ($mode == 'url')
      {
        if ($empty_only && $row['seo_keyword']) continue;
        
        $value = $this->model_tool_seo_package->filter_seo($value, 'manufacturer', $row['manufacturer_id']);

        if (!$simulate) {
          $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query =  'manufacturer_id=" . $row['manufacturer_id'] . "'");
          
          if ($this->ml_mode) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . $row['manufacturer_id'] . "', language_id = 0, keyword = '" . $this->db->escape($value) . "'");
          } else {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . $row['manufacturer_id'] . "', keyword = '" . $this->db->escape($value) . "'");
          }
        }
      }
      
      if (!defined('SEO_PACKAGE_CLI')) {
        $values['rows'][] = array(
          'link' =>  $this->url->link('catalog/manufacturer/'.$this->edit_action, 'token=' . $this->session->data['token'] . '&manufacturer_id=' . $row['manufacturer_id'], 'SSL'),
          'name' =>  $row['name'],
          'old_value' =>  $row['seo_keyword'],
          'value' =>  $value,
          'changed' =>  $row['seo_keyword'] != $value,
        );
      }
      
      if (defined('SEO_PACKAGE_CLI')) {
        $this->log('manufacturer.' . $mode . ': ' . $row['name'] . ' => ' . $value);
      }
    }
    $data['langs'][0] = &$values;
    
    return $data;
    }
  
  public function generator_redirect($mode, $simulate, $empty_only, $redirect) {
    $data = array();
    
    $this->load->model('tool/seo_package');
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    
    foreach($languages as $language)
    {
      $lang_code[$language['language_id']] = $language['code'];
      if ($this->OC_V22X) {
        $lang_img[$language['language_id']] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $lang_img[$language['language_id']] = 'view/image/flags/'. $language['image'];
      }
    }
    
    // define('FRONT_MODEL_LOADER', true);
    
    // require_once(VQMod::modCheck(DIR_CATALOG . 'controller/common/seo_url.php')); 
    // $this->seo_url = new ControllerCommonSeoUrl($this->registry);
    //$this->seo_url->index();
    
    foreach($this->request->post['langs'] as $lang)
    {
      $values = array();
      $values['lang_img'] = $lang_img[$lang];
      $values['no_old'] = true;
      $values['rows'] = array();
      
      $this->config->set('mlseo_cache', false);
      
      $this->config->set('config_language_id', (int) $lang);
      $this->config->set('config_language', $lang_code[$lang]);
      $this->session->data['language'] = $lang_code[$lang];
      
      $type = $mode;
      
      switch($type) {
        case 'information':
          $route = 'information/information';
          $field = $param = 'information_id';
          break;
        case 'product':
          $route = 'product/product';
          $field = $param = 'product_id';
          break;
        case 'category':
          $route = 'product/category';
          $field = 'category_id';
          $param = 'path';
          break;
        case 'manufacturer':
          $route = 'product/manufacturer/info';
          $field = $param = 'manufacturer_id';
          break;
      }
        
      if ($type == 'category') {
        $rows = $this->getCategories(0);
      } else {
        $rows = $this->db->query("SELECT " . $field . " FROM " . DB_PREFIX . $type . " ORDER BY " . $field)->rows;
      }
      
      foreach ($rows as $row) {
        $url = $this->front_url->link($route, $param . '=' . $row[$param]);
        $redir = $route . '&' . $param . '=' . $row[$param];
        
        // do not redirect default links
        if (strpos($url, 'index.php?route=') !== false) continue;
        
        //if ($empty_only && $row['seo_keyword']) continue;
        
        $count = $this->db->query("SELECT COUNT(*) as count FROM " . DB_PREFIX . "url_redirect WHERE query = '" . $this->db->escape($url) . "' AND redirect = '" . $this->db->escape($redir) . "' AND language_id = '" . (int) $lang . "'")->row;
        
        if ($count['count']) {
          $changed = 0;
        } else {
          if (!$simulate) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_redirect SET query = '" . $this->db->escape($url) . "', redirect = '" . $this->db->escape($redir) . "', language_id = '" . (int) $lang . "'");
          }
          $changed = 1;
        }
        
        $values['rows'][] = array(
          'link' =>  str_replace(HTTP_SERVER, '../', $url),
          'name' =>  str_replace(array(HTTP_SERVER, HTTP_CATALOG), '/', $url),
          'old_value' =>  '',
          'value' => $redir,
          'changed' =>  $changed,
        );
      
      }
      
      $data['langs'][$lang] = $values;
      $data['langs'][$lang]['count'] = count($values['rows']);
      
      if ($type == 'manufacturer') {
        $data['langs'][$lang]['lang_img'] = false;
        break;
      }
    }
    
    return $data;
  }
  
  public function generator_report($mode, $simulate, $empty_only, $redirect) {
    $values = $data = array();
    $values['lang_img'] = '';
    $values['no_old'] = true;
    $values['rows'] = array();
    $data['nohidecol'] = true;
    $data['hidesim'] = true;
    $data['col1'] = $this->language->get('text_query');
    $data['col2'] = $this->language->get('text_keyword');
    $data['col3'] = $this->language->get('text_status');
    
    $urls = $this->db->query("SELECT query, keyword FROM " . DB_PREFIX . "url_alias WHERE keyword = ''")->rows;
    
    foreach($urls as $url) {
      $values['rows'][] = array(
        'name' =>  $url['query'],
        'old_value' =>  $url['keyword'],
        'value' =>  '<span style="color:#C94644">'.$this->language->get('text_empty').'</span>',
        'changed' =>  0,
      );
    }
    
    //$urls = $this->db->query("SELECT count(*) AS count, query, keyword FROM " . DB_PREFIX . "url_alias GROUP BY keyword")->rows;
    if ($this->ml_mode && $this->config->get('mlseo_duplicate')) {
      $urls = $this->db->query("SELECT count(*) AS count, query, keyword, language_id  FROM " . DB_PREFIX . "url_alias GROUP BY query, keyword, language_id")->rows;
    } else {
      $urls = $this->db->query("SELECT count(*) AS count, query, keyword  FROM " . DB_PREFIX . "url_alias GROUP BY query, keyword")->rows;
    }
    
    foreach($urls as $url) {
      if ($url['keyword'] && $url['count']> 1) {
        $duplicates = $this->db->query("SELECT query, keyword FROM " . DB_PREFIX . "url_alias WHERE keyword = '".$url['keyword']."'")->rows;
        foreach($duplicates as $duplicate) {
          $values['rows'][] = array(
            'name' =>  $duplicate['query'],
            'old_value' =>  $duplicate['keyword'],
            'value' =>  '<span style="color:#82669B">'.$this->language->get('text_duplicate').'</span>',
            'changed' =>  0,
          );
        }
      }
    }
    
    $data['langs'][0] = &$values;
    //$data['langs'][0]['count'] = count($urls);
    
    return $data;
  }
  
  protected function getCategories($parent_id, $current_path = '') {
    $route = 'product/category';
    $field = 'category_id';
    $param = 'path';
    
    $categories = array();

    $results = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE parent_id = " . (int) $parent_id . " ORDER BY " . $field)->rows;;
    
    foreach ($results as $result) {
      if (!$current_path) {
        $new_path = $result['category_id'];
      } else {
        $new_path = $current_path . '_' . $result['category_id'];
      }

      $categories[] = array(
        'category_id' => $result['category_id'],
        'path' => $new_path,
      );

      $categories += $this->getCategories($result['category_id'], $new_path);
    }

    return $categories;
  }
  
  public function generator_cache($mode, $simulate, $empty_only, $redirect) {
    $data = array();
    
    $this->load->model('tool/seo_package');
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    foreach($languages as $language)
    {
      $lang_code[$language['language_id']] = $language['code'];
      if ($this->OC_V22X) {
        $lang_img[$language['language_id']] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $lang_img[$language['language_id']] = 'view/image/flags/'. $language['image'];
      }
    }
    
    if ($mode == 'delete') {
      $values = array();
      $values['lang_img'] = '';
      $values['no_old'] = true;
      $values['rows'] = array();
      foreach($this->request->post['langs'] as $lang)
      {
        $res = Powercache::delete('seo_rewrite.' . (int) $lang);
        if ($res) {
          $values['rows'][] = array(
            'link' =>  0,
            'name' =>  '/system/cache/pcache.seo_rewrite.'.$lang,
            'old_value' =>  '',
            'value' => $this->language->get('text_deleted'),
            'changed' =>  0,
          );
        }
      }
      $data['langs'][$lang] = $values;
      $data['langs'][$lang]['count'] = count($values['rows']);
      return $data;
    }
    
    $data['simulate'] = false;

    //define('FRONT_MODEL_LOADER', true);
    
    //require_once(VQMod::modCheck(DIR_CATALOG . 'controller/common/seo_url.php')); 
    //$this->seo_url = new ControllerCommonSeoUrl($this->registry);

    foreach($this->request->post['langs'] as $lang)
    {
      $values = array();
      $values['lang_img'] = $lang_img[$lang];
      $values['no_old'] = true;
      $values['rows'] = array();
    
      Powercache::delete('seo_rewrite.' . (int) $lang);
      
      $this->config->set('config_language_id', (int) $lang);
      $this->config->set('config_language', $lang_code[$lang]);
      $this->session->data['language'] = $lang_code[$lang];
      
      $types = array('product', 'information');
      $this->total_items = 0;
      foreach ($types as $type)
      {
        switch($type) {
          case 'information':
            $route = 'information/information';
            $field = $param = 'information_id';
            break;
          case 'product':
            $route = 'product/product';
            $field = $param = 'product_id';
            break;
          case 'category':
            $route = 'product/category';
            $field = 'category_id';
            $param = 'path';
            break;
          }
        
        $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . $type."_description WHERE language_id=".(int)$lang)->row;
        $this->total_items += $total['total'];
        
        $rows = $this->db->query("SELECT ".$field.", seo_keyword, language_id FROM " . DB_PREFIX . $type."_description WHERE language_id=".(int)$lang . " ORDER BY ".$field." LIMIT ".$this->start.",".$this->limit)->rows;
        foreach ($rows as $row)
        {
          
          //$url = $this->front_link($route, $param . '=' . $row[$field]);
          $url = $this->front_url->link($route, $param . '=' . $row[$field]);
          
          $values['rows'][] = array(
            'link' =>  str_replace(HTTP_SERVER, '../', $url),
            'name' =>  'index.php?route=' . $route . '&' . $param . '=' . $row[$field],
            'old_value' =>  '',
            'value' =>  str_replace(array(HTTP_SERVER, HTTP_CATALOG), '/', $url),
            'changed' =>  0,
          );

          // product link from categories
          if ($type == 'product')
          {
            $paths = $this->model_tool_seo_package->getFullProductPaths($row['product_id']);
            foreach ($paths as $path)
            {
              //$url = $this->url->link('product/product', 'path=' . $path . '&product_id=' . $row['product_id']);
              $url = $this->front_url->link('product/product', 'path=' . $path . '&product_id=' . $row['product_id']);
              
              $values['rows'][] = array(
                'link' =>  str_replace(HTTP_SERVER, '../', $url),
                'name' =>  'index.php?route=product/product&path=' . $path . '&product_id=' . $row['product_id'],
                'old_value' =>  '',
                'value' =>  str_replace(array(HTTP_SERVER, HTTP_CATALOG), '/', $url),
                'changed' =>  0,
              );
            }
          }
          
          //Powercache::add('seo_rewrite', $row['language_id'] . '-route=product/product&product_id=' . $row['product_id'], $url);
          
        }
      }
      
      $data['langs'][$lang] = $values;
      $data['langs'][$lang]['count'] = count($values['rows']);
    }
    
    return $data;
  }
  
  public function generator_cleanup($mode, $simulate, $empty_only, $redirect) {
    $values = $data = array();
    $values['lang_img'] = '';
    $values['no_old'] = true;
    $values['rows'] = array();
    
    if ($mode == 'url') {
      if ($this->ml_mode) {
        $urls = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE (query LIKE 'category_id=%' OR query LIKE 'product_id=%' OR query LIKE 'route=%') AND language_id=0")->rows;
      } else {
        //$urls = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE (query LIKE 'category_id=%' OR query LIKE 'product_id=%' OR query LIKE 'route=%')")->rows;
        $urls = array();
      }
      
      foreach ($urls as $url)
      {
        $values['rows'][] = array(
          'name' =>  $url['query'] . ' ('.$url['keyword'].')',
          'old_value' =>  '',
          'value' =>  $this->language->get('text_deleted'),
          'changed' =>  0,
        );
      }
      if (!$simulate) {
        if ($this->ml_mode) {
          $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE (query LIKE 'category_id=%' OR query LIKE 'product_id=%' OR query LIKE 'route=%') AND language_id=0");
        } else {
          //$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE (query LIKE 'category_id=%' OR query LIKE 'product_id=%' OR query LIKE 'route=%')");
        }
      }
        
      $data['langs'][0] = &$values;
      $data['langs'][0]['count'] = count($urls);
    } else if ($mode == 'duplicate') {
      $data['nohidecol'] = true;
      $data['col1'] = $this->language->get('text_query');
      $data['col2'] = $this->language->get('text_keyword');
      $data['col3'] = $this->language->get('text_status');
    
      $deleted = 0;
      
      if ($this->ml_mode) {
        $urls = $this->db->query("SELECT count(*) AS count, query, keyword, language_id  FROM " . DB_PREFIX . "url_alias GROUP BY query, keyword, language_id")->rows;
      } else {
        $urls = $this->db->query("SELECT count(*) AS count, query, keyword  FROM " . DB_PREFIX . "url_alias GROUP BY query, keyword")->rows;
      }
      
      foreach($urls as $url) {
        if ($url['count'] > 1) {
          if (!$simulate) {
            if ($this->ml_mode) {
              $total_deleted = $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = '".$url['query']."' AND keyword = '".$url['keyword']."' AND language_id = '".$url['language_id']."' LIMIT " . ($url['count']-1));
            } else {
              $total_deleted = $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = '".$url['query']."' AND keyword = '".$url['keyword']."' LIMIT " . ($url['count']-1));
            }
          }

          $values['rows'][] = array(
            'name' =>  $url['query'],
            'old_value' =>  $url['keyword'],
            'value' =>  $this->language->get('text_deleted'),
            'changed' =>  0,
          );
          $deleted++;
        }
      }
      
      $data['langs'][0] = &$values;
      $data['langs'][0]['count'] = $deleted;
    }
      
      return $data;
  }
  
  public function get_value() {
    $type = $this->request->get['type'];
    $fields = $this->request->get['field'];
    $lang = $this->request->get['lang'];
    $item_id = $this->request->get['id'];
    
    $lgCodes = $this->config->get('mlseo_lang_codes');
      
    if (!empty($lgCodes[$lang])) {
      $this->config->set('mlseo_current_lang', $lgCodes[$lang]);
    }

    if (!in_array($type, array('product', 'category', 'information'))) {
      return '';
    }
    
    
    if ($fields == 'all') {
      if ($type == 'product') {
        $fields = array('seo_keyword', 'seo_h1', 'seo_h2', 'seo_h3', 'image_alt', 'image_title', 'meta_title', 'meta_keyword', 'meta_description', 'tag');
      } else if ($type == 'information' || $type == 'category') {
        $fields = array('seo_keyword', 'seo_h1', 'seo_h2', 'seo_h3', 'meta_title', 'meta_keyword', 'meta_description');
      }
    }
    
    if (empty($fields)) {
      return '';
    }
    
    $values = array();
    
    foreach ((array) $fields as $field) {
      
      switch ($field) {
        case 'seo_keyword': $mode = 'url'; break;
        case 'seo_h1': $mode = 'h1'; break;
        case 'seo_h2': $mode = 'h2'; break;
        case 'seo_h3': $mode = 'h3'; break;
        case 'meta_title': $mode = 'title'; break;
        case 'meta_keyword': $mode = 'keyword'; break;
        case 'meta_description': $mode = 'description'; break;
        case 'description': $mode = 'full_desc'; break;
        case 'image': $mode = 'image_name'; break;
        case 'image_title': $mode = 'image_title'; break;
        case 'image_alt': $mode = 'image_alt'; break;
        case 'tag': $mode = 'tag'; break;
      }

      //$row = $this->db->query("SELECT * FROM " . DB_PREFIX . $type . "_description WHERE " . $type . "_id = " . (int) $item_id . " AND language_id=" . (int) $lang)->row;

      //$row = $this->request->post[$type.'_description'][$lang];
      $row = $this->request->post;
      $row[$type.'_id'] = $item_id;
    
      $pattern = $this->config->get('mlseo_'.$type.'_'.$mode.'_pattern');
      $pattern = str_replace('[current]', $row[$type.'_description'][$lang][$field], $pattern);
      
      $this->load->model('tool/seo_package');
      
      $value = $this->model_tool_seo_package->{'transform'.ucfirst($type)}($pattern, $lang, $row, true);
      
      if ($field == 'seo_keyword') {
        $value = $this->model_tool_seo_package->filter_seo($value, $type, $row[$type.'_id'], $lang);
      }
      
      if ($mode == 'full_desc') {
        $value = nl2br($value);
      }
      
      if ($mode == 'keyword') {
        $value = mb_strtolower($value);
      }
      
      $values[$type.'_description['.$lang.']['.$field.']'] = $value;
    }
    
    echo json_encode($values);
    exit;
  }
  
  public function generator($type = '', $mode = '', $redirect = '') {
  //sleep (2);
    $benchmark = false;
    if ($benchmark) {
      ini_set('memory_limit', -1);
      set_time_limit(3600);
    }
    $this->start_time = microtime(true)*1000;
    
    $data['OC_V2'] = $this->OC_V2;
    
    $this->load->language('module/complete_seo');
    
    if (defined('SEO_PACKAGE_CLI')) {
      $this->start = 0;
      $this->limit = 9999999999;
    } else {
      $this->start = (int) $this->request->get['start'];
    }
      
    if (!$type && !isset($this->request->get['type'])) return;
    if (!$mode && !isset($this->request->get['mode'])) return;
    
    if (!$type) $type = $this->request->get['type'];
    if (!$mode) $mode = $this->request->get['mode'];
    if (!$redirect) $redirect = !empty($this->request->get['redirect']) ? $this->request->get['redirect'] : false;
    
    $data['type'] = $type;
    $data['mode'] = $mode;
    $data['simulate'] = $simulate = !empty($this->request->post['simulate']);
    if (!$this->user->hasPermission('modify', 'module/complete_seo')) {
      $data['simulate'] = $simulate = true;
    }
    $data['empty_only'] = $empty_only = !empty($this->request->post['empty_only']);
    
    $res = $this->{'generator_'.$type}($mode, $simulate, $empty_only, $redirect);
    
    $data['_language'] = $this->language;
    $data['_config'] = $this->config;
    $data['_url'] = $this->url;
    $data['token'] = $this->session->data['token'];
    
    if ($benchmark) {
      $end_time = microtime(true)*1000;
      var_dump('time: '. ((int)($end_time - $this->start_time) /1000). 's');
      var_dump('mem peak: ' . memory_get_peak_usage()/1000000);
      die;
    }
    
    $processed = $this->start + $this->limit;
    
    if ($processed > $this->total_items) {
      $processed = $this->total_items;
    }
    
    if (!$this->total_items) {
     $progress = 100;
    } else {
      $progress = round(($processed / $this->total_items) * 100);
    }
    
    echo json_encode(array(
      'success'=> 1,
      'processed' => $processed,
      'progress' => $progress,
      'finished' => $processed >= $this->total_items,
      'log' => $res,
    ));
    /*
    if ($this->OC_V2) {
      $this->response->setOutput($this->load->view('module/seo_generator.tpl', $data));
    } else {
      $this->data = &$data;
      $this->template = 'module/seo_generator.tpl';
      echo $this->render();
    }
    */
  }
  
  /*<complete*/

  public function cli($params = '') {
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    
    foreach($languages as $language) {
      $this->request->post['langs'][] = $language['language_id'];
    }

    $this->start = 0;
    $this->limit = 9999999999;
      
    $params = $this->config->get('mlseo_cron');
    if (!is_array($params)) return;
    
    $simulation = isset($params['simulation']) && $params['simulation'];
    $empty_only = isset($params['empty_only']) && $params['empty_only'];
    
    $simu = $simulation ? 'SIMULATION MODE - ' : '';
    $this->log(PHP_EOL . '----------------------------- CLI Request - ' . $simu . date('d/m/Y H:i:s') . ' -----------------------------');
    
    if (count($params['update'])) {
    foreach ($params['update'] as $type => $modes) {
      foreach ($modes as $mode) {
          $this->{'generator_'.$type}($mode, $simulation, $empty_only, '');
        }
      }
    }
  }
  
  public function editor_data() {
    // DataTables PHP library
    $this->load->model('tool/seo_package_editor');
    $this->load->model('tool/image');
    
    if (!isset($this->request->get['type'])) return;
    if (!isset($this->request->get['lang'])) return;
    
    $type =  $this->request->get['type'];
    $lang =  $this->request->get['lang'];
    
    // php 5.2 doesn't support anonymous functions
    if (!function_exists('inlineeditor_image')) {
      function inlineeditor_image($d, $row, $type, $_this) { 
        if ($d && file_exists(DIR_IMAGE . $d)) {
            $img = $_this->model_tool_image->resize($d, 40, 40);
          } else {
          $no_image = (substr(VERSION, 0, 1) == 2) ? 'no_image.png' : 'no_image.jpg';
          $img = $_this->model_tool_image->resize($no_image, 40, 40);
        }
        return '<img src="' . $img . '" alt=""/>';
      }
    }
    if (!function_exists('inlineeditor_text')) {
      function inlineeditor_text($d, $row, $type) {
        return '<a data-type="text" data-pk="' . $row[$type.'_id'] . '">' . $d . '</a>';
      }
    }
    if (!function_exists('inlineeditor_keyword')) {
      function inlineeditor_keyword($d, $row, $type) {
        return '<a data-type="text" data-pk="' . $row[$type.'_id'] . '">' . str_replace('route=', '', $d) . '</a>';
      }
    }
    if (!function_exists('inlineeditor_image_name')) {
      function inlineeditor_image_name($d, $row, $type) {
        $file = pathinfo($d);
        return '<a data-type="text" data-pk="' . $row[$type.'_id'] . '">' . $file['basename'] . '</a>';
      }
    }
    if (!function_exists('inlineeditor_related')) {
      function inlineeditor_related($d, $row, $type) {
        $rel_names = array();
        
        $output = '<div class="select2-input"><div class="editable-input"><select multiple="multiple" data-pk="' . $row[$type.'_id'] . '" data-col="related">';
        
        foreach ($d['rows'] as $rel) {
          $rel_names[] = $rel['name'];
          $output .= '<option value="' . $rel['related_id'] . '" selected="selected">' . $rel['name'] . '</option>';
        }
  
        $output .= '</select></div>';
        $output .= '<div class="editable-buttons"><button type="submit" class="select2-submit"><i class="fa fa-check"></i></button></div></div>';
        $output .= '<a class="select2" pk="' . $row[$type.'_id'] . '">' . implode(', ', $rel_names) . '</a>';
        
        return $output;
      }
    }
    if (!function_exists('inlineeditor_textarea')) {
      function inlineeditor_textarea($d, $row, $type) {
        return '<a data-type="textarea" data-pk="' . $row[$type.'_id'] . '">' . $d . '</a>';
      }
    }
    if (!function_exists('editor_deletebtn')) {
      function editor_deletebtn($d, $row, $type) {
        return '<i class="deleteAlias fa fa-minus-circle" data-pk="' . $d . '"></i>';
      }
    }
      
    $columns = array();
    // image column
    $dt = 0;
    if ($type == 'image') {
      $columns[] = array( 'db' => 'image',  'dt' => $dt++, 'formatter' => 'inlineeditor_image');
      $columns[] = array( 'db' => 'name', 'dt' => $dt++);
      $columns[] = array( 'db' => 'image', 'dt' => $dt++, 'formatter' => 'inlineeditor_image_name');
      $columns[] = array( 'db' => 'image_alt', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      $columns[] = array( 'db' => 'image_title', 'dt' => $dt++, 'formatter' => 'inlineeditor_text' );
      $type = 'product';
      $columns[] = array( 'db' => $type.'_id', 'dt' => $dt++ );
    } else if (in_array($type, array('common', 'special'))) {
      $columns[] = array( 'db' => 'query', 'dt' => $dt++, 'formatter' => 'inlineeditor_keyword');
      $columns[] = array( 'db' => 'keyword', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      $columns[] = array( 'db' => 'url_alias_id', 'dt' => $dt++, 'formatter' => 'editor_deletebtn' );
    } else if ($type == 'redirect') {
      $columns[] = array( 'db' => 'query', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      $columns[] = array( 'db' => 'redirect', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      $columns[] = array( 'db' => 'url_redirect_id', 'dt' => $dt++, 'formatter' => 'editor_deletebtn' );
    } else {
      if (in_array($type, array('product', 'category', 'manufacturer'))) {
        $columns[] = array( 'db' => 'image',  'dt' => $dt++, 'formatter' => 'inlineeditor_image');
        $columns[] = array( 'db' => 'name', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      }
      if (in_array($type, array('information'))) {
        $columns[] = array( 'db' => 'title', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      }
      if (in_array($type, array('manufacturer'))) {
        $columns[] = array( 'db' => 'keyword', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      }
      if (!in_array($type, array('manufacturer'))) {
        $columns[] = array( 'db' => 'seo_keyword', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
        $columns[] = array( 'db' => 'meta_title', 'dt' => $dt++, 'formatter' => 'inlineeditor_textarea');
        $columns[] = array( 'db' => 'meta_keyword', 'dt' => $dt++, 'formatter' => 'inlineeditor_textarea');
        $columns[] = array( 'db' => 'meta_description', 'dt' => $dt++, 'formatter' => 'inlineeditor_textarea');
        if (in_array($type, array('product')) && $this->OC_VERSION > 153) {
          $columns[] = array( 'db' => 'tag', 'dt' => $dt++, 'formatter' => 'inlineeditor_textarea');
        }
        if (in_array($type, array('product'))) {
          $columns[] = array( 'db' => 'related', 'dt' => $dt++, 'formatter' => 'inlineeditor_related');
        }
      }
      $columns[] = array( 'db' => $type.'_id', 'dt' => $dt++ );
    }
    
    echo json_encode(
      $this->model_tool_seo_package_editor->simple( $_GET, $type, $lang, $columns )
    );
    die;
  }
  
  public function editor_update() {
    if (!$this->user->hasPermission('modify', 'module/complete_seo')) {
      echo json_encode(array('status' => 'error', 'msg' => $this->language->get('error_permission')));
      die;
    }
    
    $pk = $this->request->post['pk'];
    
    if (is_string($this->request->post['value'])) {
      $value = html_entity_decode($this->request->post['value'], ENT_QUOTES, 'UTF-8');
    } else {
      $value = $this->request->post['value'];
    }
    
    $col = $this->request->post['col'];
    $type =  isset($this->request->post['type']) ? $this->request->post['type'] : '';
    $lang = isset($this->request->post['lang']) ? $this->request->post['lang'] : '';
    
    if ($type == 'image') {
      $type = 'product';
    }
    
    // return if something is empty
    if (empty($pk) || empty($col)) return;
    
    // allowed values
    if (!in_array($col, array('title', 'name', 'seo_keyword', 'seo_h1', 'meta_title', 'meta_keyword', 'meta_description', 'tag', 'query', 'keyword', 'redirect', 'related', 'image', 'image_alt', 'image_title'))) return;
    
    if ($col == 'image') {
      $this->load->model('tool/seo_package');
      
      $prod = $this->db->query("SELECT image FROM " . DB_PREFIX . "product WHERE product_id = '" . (int) $pk . "'")->row;
      
      $path = pathinfo($prod['image']);
      $new_path = pathinfo($value);
      
      if (empty($prod['image']) || empty($new_path['filename'])) {
        echo json_encode(
          array('status' => 'error', 'pk' => $pk, 'msg' => 'Empty value not allowed')
        );
        die;
      }
      
      $filename = $this->model_tool_seo_package->filter_seo($new_path['filename'], 'image', '');
      $value = $path['dirname'] . '/' . $filename . '.' . $path['extension'];
      
      $x = 1;
      
      while (file_exists(DIR_IMAGE . $value)) {
        $value = $path['dirname'] . '/' . $filename . '-' . $x . '.' . $path['extension'];
        $x++;
      }
      
      if (rename(DIR_IMAGE . $prod['image'], DIR_IMAGE . $value)) {
        $this->db->query("UPDATE " . DB_PREFIX . "product SET image = '". $this->db->escape($value) ."' WHERE product_id = '" . (int) $pk . "'");
      }
      
      $value = pathinfo($value);
      echo json_encode(
        array('status' => 'success', 'pk' => $pk, 'msg' => $value['basename'])
      );
      
      die;
    }
    
    if ($col == 'related') {
       $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $pk . "'" );
       $res_ids = $res_names = array();
       foreach ($value as $rel_id) {
          $rel_id = (int) $rel_id;
          if ((int) $rel_id) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_related (product_id, related_id) VALUES (" . (int) $pk . ", " . (int) $rel_id . ")");
            $prod = $this->db->query("SELECT product_id, name FROM " . DB_PREFIX . "product_description WHERE language_id=" . $this->config->get('config_language_id') . " AND product_id = '" . (int) $rel_id . "'")->row;
            $res_ids[] = $prod['product_id'];
            $res_names[] = $prod['name'];
          }
      }
      
      echo json_encode(
        //array('status' => 'success-related', 'val' => implode(',', $res_ids), 'msg' => implode(', ', $res_names), 'pk' => $pk)
        array('status' => 'success', 'pk' => $pk, 'msg' => implode(', ', $res_names))
      );
      
      die;
    }
    
    $primaryKey = $type . '_id';
    if (in_array($type, array('common', 'special'))) {
      $primaryKey = 'url_alias_id';
    } else if ($type == 'redirect') {
      $primaryKey = 'url_redirect_id';
    }
    
    // update products, categories or informations
    if (in_array($type, array('product', 'category', 'information', 'manufacturer', 'common', 'special', 'redirect'))) {
      if (in_array($type, array('common', 'special'))) {
        // delete route if set by user
        str_replace('route=', '', $value);
        // insert it if necessary
        $route = ($type == 'common' && $col == 'query') ? 'route=' : '';
        
        $this->db->query("UPDATE " . DB_PREFIX . "url_alias SET " . $col . " = '" . $this->db->escape($route.$value) . "' WHERE " . $primaryKey . " = '" . (int)$pk . "'");
      } else if ($type == 'redirect') {
        $this->db->query("UPDATE " . DB_PREFIX . "url_redirect SET " . $col . " = '" . $this->db->escape($value) . "' WHERE " . $primaryKey . " = '" . (int)$pk . "'");
      }
      
      if ($col == 'seo_keyword') {
        $this->load->model('tool/seo_package');
        $value = $this->model_tool_seo_package->filter_seo($value, $type, $pk, $lang);
        
        if (in_array($type, array('manufacturer'))) $lang = 0;
        
        if ($this->ml_mode) {
          $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query =  '". $primaryKey . "=" . (int)$pk . "' AND language_id = '" . (int)$lang . "'");
          $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = '". $primaryKey . "=" . (int)$pk . "', keyword = '" . $this->db->escape($value) . "', language_id = '" . (int)$lang . "'");
        } else {
          $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query =  '". $primaryKey . "=" . (int)$pk . "'");
          $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = '". $primaryKey . "=" . (int)$pk . "', keyword = '" . $this->db->escape($value) . "'");
        }
        //$this->db->query("UPDATE " . DB_PREFIX ."url_alias SET keyword = '" . $this->db->escape($value) . "' WHERE query = '". $primaryKey . "=" . (int)$pk . "' AND language_id = '" . (int)$lang . "'");
      }
      
      if (in_array($type, array('product', 'category', 'information'))) {
        $this->db->query("UPDATE " . DB_PREFIX . $type . "_description SET " . $col . " = '" . $this->db->escape($value) . "' WHERE " . $primaryKey . " = '" . (int)$pk . "' AND language_id = '" . (int)$lang . "'");
      }
      
      echo json_encode(
        array('status' => 'success', 'msg' => $value)
      );
    }
    
  }
  
  public function editor_add_alias() {
    if (!$this->user->hasPermission('modify', 'module/complete_seo')) return;
    
    $lang = $this->request->get['lang'];
    $type = $this->request->get['type'];
    $query = $_GET['query'];
    $keyword = $_GET['keyword'];
    
    $table = 'url_alias';
    
    if ($type == 'common') {
      $query = 'route=' . str_replace('route=', '', $query);
    }
    
    if ($type == 'redirect') {
      $this->db->query("INSERT INTO " . DB_PREFIX . "url_redirect SET query = '" . $this->db->escape($query) . "', redirect = '" . $this->db->escape($keyword) . "', language_id = '" . (int) $lang . "'");
    } else {
      if ($this->ml_mode) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = '" . $this->db->escape($query) . "', keyword = '" . $this->db->escape($keyword) . "', language_id = '" . (int) $lang . "'");
      } else {
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = '" . $this->db->escape($query) . "', keyword = '" . $this->db->escape($keyword) . "'");
      }
    }
    
  }
  
  public function editor_delete_alias() {
    if (!$this->user->hasPermission('modify', 'module/complete_seo')) return;
    
    $type = $this->request->get['type'];
    $alias_id = $this->request->get['pk'];
    if ($type == 'redirect') {
      $this->db->query("DELETE FROM " . DB_PREFIX . "url_redirect WHERE url_redirect_id =  '". (int) $alias_id . "'");
    } else {
      $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE url_alias_id =  '". (int) $alias_id . "'");
    }
  }
  
  public function editor_delete_aliases() {
    if (!$this->user->hasPermission('modify', 'module/complete_seo')) return;
    
    $lang = $this->request->get['lang'];
    $type = $this->request->get['type'];
    if ($type == 'common') {
      $extra_where = "query LIKE 'route=%'";
    } elseif ($type == 'special') {
      $extra_where = "query NOT LIKE 'route=%'
                   AND query NOT LIKE 'product_id=%'
                   AND query NOT LIKE 'category_id=%'
                   AND query NOT LIKE 'information_id=%'
                   AND query NOT LIKE 'manufacturer_id=%'";
    }
    
    if ($type == 'redirect') {
      $this->db->query("DELETE FROM " . DB_PREFIX . "url_redirect");
    } else {
      if ($this->ml_mode) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE " . $extra_where . " AND language_id = '" . (int) $lang . "'");
      } else {
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE " . $extra_where);
      }
    }
  }

  public function editor_restore_aliases() {
    if (!$this->user->hasPermission('modify', 'module/complete_seo')) return;
    
    $this->load->model('setting/friendlyurls');
    $this->load->model('localisation/language');
    
    $lang = $this->request->get['lang'];
    $lang_code = $this->request->get['lang_code'];
    
    $languages = $this->model_localisation_language->getLanguages();
    
    $langs = array();
    foreach ($languages as $language) {
      $langs[$language['language_id']] = $language['code'];
    }
    
    $this->editor_delete_aliases();
    
    $default_urls = $this->model_setting_friendlyurls->getFriendlyUrls($lang_code);
    
    foreach ($default_urls as $query => $keyword) {
      if ($this->ml_mode) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'route=" . $query . "', keyword = '" . $keyword . "', language_id = '" . (int) $lang . "'");
      } else {
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'route=" . $query . "', keyword = '" . $keyword . "'");
      }
    }
  }
  
  public function editor_export_aliases() {
    $type = $this->request->get['type'];
    $lang = $this->request->get['lang'];
    $lang_code = $this->request->get['lang_code'];
    
    header("Content-type: text/plain");
    header("Content-Disposition: attachment; filename=friendly_export.txt");

    echo "You translated friendly urls, and want to integrate them in official package ?" . PHP_EOL . "Please send this file to sirius_box-dev@yahoo.fr" . PHP_EOL . PHP_EOL;
    echo "Language : " . $lang_code . PHP_EOL . PHP_EOL;
     
    if ($type == 'common') {
      $extra_where = "query LIKE 'route=%'";
    } elseif ($type == 'special') {
      $extra_where = "query NOT LIKE 'route=%'
                   AND query NOT LIKE 'product_id=%'
                   AND query NOT LIKE 'category_id=%'
                   AND query NOT LIKE 'information_id=%'
                   AND query NOT LIKE 'manufacturer_id=%'";
    } else {
      exit();
    }
    
    if ($this->ml_mode) {
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE " . $extra_where . " AND language_id = '" . (int) $lang . "'");
    } else {
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE " . $extra_where);
    }
    
    foreach($query->rows as $row) {
      echo "'".$row['query']."' => '".$row['keyword']."',". PHP_EOL;
    }
    
    exit();
  }
  
  /*complete>*/
  
   public function modal_related() {
    $this->load->language('module/complete_seo');
    
    $id = $this->request->post['id'];
       
    $related = $this->db->query("SELECT pr.related_id, pd.name FROM " . DB_PREFIX . "product_related pr LEFT JOIN " . DB_PREFIX . "product_description pd ON pd.product_id = pr.related_id WHERE pr.product_id=" . (int) $id . " AND pd.language_id=" . $this->config->get('config_language_id'))->rows;
       
    echo '<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">' . $this->language->get('text_seo_mode_related') . '</h4>
        </div>
        <div class="modal-body">
          <select class="related-select" multiple="multiple">';
    
    foreach ($related as $rel) {
      echo '<option value="' . $rel['related_id'] . '">' . $rel['name'] . '</option>';
    }
    
    echo '</select>
<script type="text/javascript">
  $("select.related-select").select2({
    
  });
</script>
        </div>
      </div>
    </div>';
    
    die;
  }
  
  public function product_search() {
    if (!isset($this->request->get['q'])) {
      echo json_encode(array('results'));
      die;
    }
    
    $q = $this->request->get['q'];
     
    $json = array('results');
    
    $products = $this->db->query("SELECT product_id, name FROM " . DB_PREFIX . "product_description WHERE name LIKE '" . $this->db->escape($q) . "%' AND language_id=" . $this->config->get('config_language_id') . " LIMIT 30")->rows; 
    
    if (!$products) {
      $products = $this->db->query("SELECT product_id, name FROM " . DB_PREFIX . "product_description WHERE name LIKE '%" . $this->db->escape($q) . "%' AND language_id=" . $this->config->get('config_language_id') . " LIMIT 30")->rows;
    }
    
    foreach ($products as $product) {
      $json['results'][] = array(
        'id' => $product['product_id'],
        'text' => htmlspecialchars_decode($product['name']),
      );
    }
    
    echo json_encode($json);
    
    die;
   }
   
   public function modal_info() {
    $this->load->language('module/complete_seo');
    
    $item = $this->request->post['info'];
    
    $extra_class = $this->language->get('info_css_' . $item) != 'info_css_' . $item ? $this->language->get('info_css_' . $item) : 'modal-lg';
    $title = $this->language->get('info_title_' . $item) != 'info_title_' . $item ? $this->language->get('info_title_' . $item) : $this->language->get('info_title_default');
    $message = $this->language->get('info_msg_' . $item) != 'info_msg_' . $item? $this->language->get('info_msg_' . $item) : $this->language->get('info_msg_default');
    
    echo '<div class="modal-dialog ' . $extra_class . '">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-info-circle"></i> ' . $title . '</h4>
        </div>
        <div class="modal-body">' . $message . '</div>
      </div>
    </div>';
    
    die;
  }
  
  public function install($redir = false) {
    // rights
    $this->load->model('user/user_group');

    $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'module/' . self::MODULE);
    $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'module/' . self::MODULE);
    
    // check tables
    $this->db_tables();
    
    $this->load->model('localisation/language');
    $languages = array();
    $results = $this->model_localisation_language->getLanguages();
    
    foreach ($results as $result) {
      $languages[$result['code']] = $result;
    }

    // set old keywords to all languages
    if (count($languages) > 1) {
      $keywords = $this->db->query("SELECT * FROM `" . DB_PREFIX . "url_alias`")->rows;
      foreach ($languages as $language) {
        foreach ($keywords as $row) {
          if (strpos($row['query'], '=') !== false) {
            list($type, $id) = explode('=', $row['query']);
            $type = str_replace('_id', '', $type);
            if (in_array($type, array('product', 'category', 'information'))) {
              $this->db->query("UPDATE " . DB_PREFIX . $type . "_description SET seo_keyword = '" . $row['keyword'] . "' WHERE  " . $type . "_id = '" . $id . "' AND language_id = '" . $language['language_id'] . "'");
              $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = '" . $row['query'] . "', keyword = '" . $row['keyword'] . "', language_id = '" . $language['language_id'] . "'");
            }
          }
        }
      }

      $this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE language_id = 0 AND (query LIKE 'product_id=%' OR query LIKE 'category_id=%' OR query LIKE 'information_id=%')");
    }

    // Friendly urls
    /* @todo
    $this->load->model('localisation/language');
    $this->load->model('setting/friendlyurls');
    $languages = $this->model_localisation_language->getLanguages();
    $friendly_urls = array();
    foreach($languages as $language)
    {
      $friendly_urls['mlseo_urls_'.$language['code']] = $this->model_setting_friendlyurls->getFriendlyUrls($language['code']);
    }
    */
    
    $this->load->model('setting/setting');
    $this->model_setting_setting->editSetting('mlseo', array(
        'mlseo_whitespace' => '-',
        'mlseo_extension' => '',
        'mlseo_hreflang' => true,
        'mlseo_friendly' => true,
        'mlseo_absolute' => true,
        'mlseo_lowercase' => true,
        'mlseo_duplicate' => true,
        'mlseo_canonical' => true,
        'mlseo_pagination_fix' => true,
        'mlseo_default_lang' => $this->config->get('config_language'),
        'mlseo_insertautotitle' => true,
        'mlseo_insertautourl' => true,
        'mlseo_editautourl' => true,
        'mlseo_insertautometakeyword' => true,
        'mlseo_editautometakeyword' => true,
        'mlseo_insertautoseotitle' => true,
        'mlseo_editautoseotitle' => true,
        'mlseo_insertautometadesc' => true,
        'mlseo_editautometadesc' => true,
        'mlseo_banners' => true,
        'mlseo_product_url_pattern' => '[name]',
        'mlseo_product_h1_pattern' => '[name]',
        'mlseo_product_h2_pattern' => '[name]',
        'mlseo_product_h3_pattern' => '[name]',
        'mlseo_product_image_alt_pattern' => '[name]',
        'mlseo_product_image_title_pattern' => '[name]',
        'mlseo_product_image_name_pattern' => '[name]',
        'mlseo_product_title_pattern' => '[name] - [model]',
        'mlseo_product_keyword_pattern' => '[name], [model], [category]',
        'mlseo_product_description_pattern' => '[name] - [model] - [category] - [desc]',
        'mlseo_product_full_desc_pattern' => '[name] - [model] - [category]',
        'mlseo_product_tag_pattern' => '[name], [model], [category]',
        'mlseo_category_url_pattern' => '[name]',
        'mlseo_category_h1_pattern' => '[name]',
        'mlseo_category_h2_pattern' => '[name]',
        'mlseo_category_h3_pattern' => '[name]',
        'mlseo_category_title_pattern' => '[name]',
        'mlseo_category_keyword_pattern' => '[name], [desc]',
        'mlseo_category_description_pattern' => '[name] - [desc]',
        'mlseo_category_full_desc_pattern' => '[name]',
        'mlseo_information_url_pattern' => '[name]',
        'mlseo_information_h1_pattern' => '[name]',
        'mlseo_information_h2_pattern' => '[name]',
        'mlseo_information_h3_pattern' => '[name]',
        'mlseo_information_title_pattern' => '[name]',
        'mlseo_information_keyword_pattern' => '[name] [desc]',
        'mlseo_information_description_pattern' => '[name] - [desc]',
        'mlseo_information_full_desc_pattern' => '[name]',
        'mlseo_manufacturer_url_pattern' => '[name]',
        'mlseo_product_related_relevance' => 5,
        'mlseo_product_related_no' => 5,
        'mlseo_microdata_data' => array('model' => 1, 'desc' => 1, 'brand' => 1, 'reviews' => 1, 'product' => 1, 'organization' => 1, 'store' => 1, 'website' => 1, 'breadcrumbs' => 1, 'organization_search' => 1, 'store_logo' => 1, 'store_mail' => 1, 'website_search' => 1),
        'mlseo_tcard_data' => array('desc' => 1),
        'mlseo_opengraph_data' => array('desc' => 1),
      ));
      
    if (is_writable(DIR_CATALOG.'../index.php')) {
      $index = file_get_contents(DIR_CATALOG.'../index.php');
      if (strpos($index, 'new multilingual_seo') === false && strpos($index, '$languages = array();') !== false) {
        $index = str_replace('$languages = array();', '$languages = array();'."\n".'$multilingual = new multilingual_seo($registry); $multilingual->detect();', $index);
        file_put_contents(DIR_CATALOG.'../index.php', $index);
      }
    }
    
    if ($redir || !empty($this->request->get['redir'])) {
      if ($this->OC_V2) {
				$this->response->redirect($this->url->link('module/'.self::MODULE, 'token=' . $this->session->data['token'] . $redirect_store, 'SSL'));
			} else {
				$this->redirect($this->url->link('module/'.self::MODULE, 'token=' . $this->session->data['token'] . $redirect_store, 'SSL'));
			}
    }
  }
  
  private function log($msg = '') {
    $log = DIR_LOGS.'seo_package_cli.log';
    $txt = $msg . PHP_EOL;
    file_put_contents($log, $txt, FILE_APPEND | LOCK_EX);
  }
  
  public function uninstall() {
  /*
    if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'seo_keyword'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` DROP `seo_keyword`");
    if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'seo_keyword'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` DROP `seo_keyword`");
    if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'seo_keyword'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` DROP `seo_keyword`");
    if (!$this->OC_V2) {
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` DROP `meta_title`");
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` DROP `meta_title`");
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'meta_description'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` DROP `meta_description`");
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'meta_keyword'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` DROP `meta_keyword`");
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` DROP `meta_title`");
    }
    */
    //$default_lang = $this->db->query("SELECT language_id FROM " . DB_PREFIX . "language WHERE code = '" . $this->config->get('config_language') . "'")->row['language_id'];
    $default_lang = $this->config->get('config_language_id');
    
    if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "url_alias` LIKE 'language_id'")->row) {
      $this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE language_id <> " . $default_lang . " AND language_id <> 0");
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "url_alias` DROP `language_id`");
    }
    
    $index = file_get_contents(DIR_CATALOG.'../index.php');
    $index = str_replace('$multilingual = new multilingual_seo($registry); $multilingual->detect();', '', $index);
    file_put_contents(DIR_CATALOG.'../index.php', $index);
  }
  
  private function validate() {
    if (!$this->user->hasPermission('modify', 'module/complete_seo')) {
      $this->error['error'] = $this->language->get('error_permission');
    }
    
    if (!$this->error)
      return true;
    return false;
  }
  
  private function db_tables() {
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
      
    // check DB columns
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'seo_keyword'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` ADD `seo_keyword` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'seo_h1'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` ADD `seo_h1` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'seo_h2'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` ADD `seo_h2` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'seo_h3'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` ADD `seo_h3` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'image_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` ADD `image_title` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'image_alt'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` ADD `image_alt` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'seo_keyword'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` ADD `seo_keyword` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'seo_keyword'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` ADD `seo_keyword` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'seo_h1'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` ADD `seo_h1` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'seo_h2'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` ADD `seo_h2` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'seo_h3'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` ADD `seo_h3` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'seo_h1'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` ADD `seo_h1` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'seo_h2'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` ADD `seo_h2` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'seo_h3'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` ADD `seo_h3` VARCHAR(255) NOT NULL");
    if (!$this->OC_V2) {
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'seo_title'")->row && !$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` CHANGE `seo_title` `meta_title` VARCHAR(255) NOT NULL");
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'seo_title'")->row && !$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` CHANGE `seo_title` `meta_title` VARCHAR(255) NOT NULL");
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'seo_title'")->row && !$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` CHANGE `seo_title` `meta_title` VARCHAR(255) NOT NULL");
      if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` ADD `meta_title` VARCHAR(255) NOT NULL");
      if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` ADD `meta_title` VARCHAR(255) NOT NULL");
      if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'meta_description'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` ADD `meta_description` VARCHAR(255) NOT NULL");
      if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'meta_keyword'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` ADD `meta_keyword` VARCHAR(255) NOT NULL");
      if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` ADD `meta_title` VARCHAR(255) NOT NULL");
    }
    if (count($languages) > 1) {
      if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "url_alias` LIKE 'language_id'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "url_alias` ADD `language_id` INT(11) NOT NULL DEFAULT '0'");
    }
    if (!$this->db->query("SHOW INDEX FROM " . DB_PREFIX . "product_description WHERE Key_name='related_generator'")->row)
      $this->db->query("CREATE FULLTEXT INDEX related_generator ON " . DB_PREFIX . "product_description (name, description)");
    
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "url_redirect` (
        `url_redirect_id` int(11) NOT NULL AUTO_INCREMENT,
        `query` varchar(1000) NOT NULL,
        `redirect` varchar(1000) NOT NULL,
        `language_id` int(11) NOT NULL DEFAULT '0',
        `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
        PRIMARY KEY (`url_redirect_id`),
        KEY `query` (`query`),
        KEY `redirect` (`redirect`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
     
    foreach (array('product', 'category', 'information') as $type) {
    $varchar = $this->db->query("SELECT CHARACTER_MAXIMUM_LENGTH AS length FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = '" . DB_PREFIX . $type . "_description' AND COLUMN_NAME = 'seo_keyword'")->row;
    if ($varchar['length'] < 255)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . $type . "_description` MODIFY COLUMN `seo_keyword` VARCHAR(255) NOT NULL");
    }
  }
  
  public function report() {
    set_time_limit(600);
    
    echo '<h3>URL ALIAS report</h3>';
    echo '<table border="1" cellpadding="10" style="border-collapse:collapse;"><tr style="font-weight:bold">';
    echo '<td>query</td>
          <td>keyword</td>
          <td>Issue</td>';

    
    $urls = $this->db->query("SELECT query, keyword FROM " . DB_PREFIX . "url_alias WHERE keyword = '' ")->rows;
    
    foreach($urls as $url) {
       echo '<tr>
          <td>'.$url['query'].'</td>
          <td>'.$url['keyword'].'</td>
          <td><span style="color:red">empty</span></td>
          </tr>';
    }
    
    $urls = $this->db->query("SELECT count(*) AS count, query, keyword FROM " . DB_PREFIX . "url_alias GROUP BY keyword ")->rows;
    
    foreach($urls as $url) {
      if ($url['keyword'] && $url['count']> 1) {
        $duplicates = $this->db->query("SELECT query, keyword FROM " . DB_PREFIX . "url_alias WHERE keyword = '".$url['keyword']."' ")->rows;
        foreach($duplicates as $duplicate) {
        echo '<tr>
          <td>'.$duplicate['query'].'</td>
          <td>'.$duplicate['keyword'].'</td>
          <td>'.(!$duplicate['keyword'] ? '<span style="color:red">empty</span>' : '<span style="color:orange">duplicate</span>').'</td>
          </tr>';
        }
      }
    }
    die;
  }
}
?>