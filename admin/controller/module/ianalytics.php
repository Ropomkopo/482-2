<?php
class ControllerModuleIanalytics extends Controller {
	private $error = array(); 
	
	private $moduleName = 'ianalytics';
	private $moduleModel = 'model_module_ianalytics';
	
	public function index() {   
		$data['moduleName'] = $this->moduleName;
		$data['moduleNameSmall'] = $this->moduleName;
		$data['moduleData_module'] = $this->moduleData_module;
		$data['moduleModel'] = $this->moduleModel;
		
		$this->load->language('module/'.$this->moduleName);

		$this->load->model('module/'.$this->moduleName);
		$this->load->model('setting/setting');
		$this->load->model('localisation/order_status');
		$this->load->model('report/sale');
		$this->load->model('report/product');
		$this->load->model('report/customer');

        $this->document->addStyle('view/stylesheet/'.$this->moduleName.'/'.$this->moduleName.'.css');
		$this->document->addStyle('view/javascript/'.$this->moduleName.'/jquery/css/ui-lightness/jquery-ui-1.9.2.custom.min.css');
		$this->document->addScript('view/javascript/'.$this->moduleName.'/jquery/js/jquery-ui-1.9.2.custom.min.js');
		$this->document->addScript('view/javascript/'.$this->moduleName.'/charts/Chart.js');
		$this->document->addScript('view/javascript/'.$this->moduleName.'/d3.v2.min.js');
		$this->document->addScript('view/javascript/'.$this->moduleName.'/d3-funnel-charts.min.js');
		
		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) { 	
            if (!empty($_POST['OaXRyb1BhY2sgLSBDb21'])) {
                $this->request->post[$this->moduleName]['LicensedOn'] = $_POST['OaXRyb1BhY2sgLSBDb21'];
            }
            if (!empty($_POST['cHRpbWl6YXRpb24ef4fe'])) {
                $this->request->post[$this->moduleName]['License'] = json_decode(base64_decode($_POST['cHRpbWl6YXRpb24ef4fe']), true);
            }

        	$this->model_setting_setting->editSetting($this->moduleName, $this->request->post, 0);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('module/'.$this->moduleName, '&token=' . $this->session->data['token'], 'SSL'));
        }
		
		$data['breadcrumbs']				= array();
   		$data['breadcrumbs'][] 				= array(
								'text' => $this->language->get('text_home'),
								'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
							);
   		$data['breadcrumbs'][] 				= array(
								'text' => $this->language->get('text_module'),
								'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
							);
   		$data['breadcrumbs'][] 				= array(
								'text' => $this->language->get('heading_title'),
								'href' => $this->url->link('module/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL')
									);
	
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
	
		$languageVariables 					= array('heading_title', 'error_permission', 'text_success', 'text_module');
       
        foreach ($languageVariables as $languageVariable) {
            $data[$languageVariable] 		= $this->language->get($languageVariable);
        }
		
		$data['token']                  	= $this->session->data['token'];
        $data['action']                 	= $this->url->link('module/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel']                 	= $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$data['moduleSettings']				= $this->model_setting_setting->getSetting($this->moduleName);
        $data['moduleData']					= (isset($data['moduleSettings'][$this->moduleName])) ? $data['moduleSettings'][$this->moduleName] : array();
		$data[$this->moduleName.'Status']	= $this->model_setting_setting->getSetting($this->moduleName.'Status');
		$data['limit']						= 20; // $this->config->get('config_limit_admin');
		$data['order_statuses']				= $this->model_localisation_order_status->getOrderStatuses();
		$data['currency']					= $this->config->get('config_currency');
		
		$data['model_sale_order']			= $this->model_report_sale;
		$data['model_report_product']		= $this->model_report_product;
		$data['model_report_customer']		= $this->model_report_customer;
		$data['model_module_ianalitycs']	= $this->model_module_ianalytics;
		$data['url_link']					= $this->url;
		$data['language']					= $this->language;
		$data['currency_lib']				= $this->currency;
		
		$this->{$this->moduleModel}->getAnalyticsData($data);
		
		
		if ($this->config->get($this->moduleName.'_status')) {
			$data[$this->moduleName.'_status'] = $this->config->get($this->moduleName.'_status');
		} else {
			$data[$this->moduleName.'_status'] = '0';
		}

		$data['header']						= $this->load->controller('common/header');
		$data['column_left']				= $this->load->controller('common/column_left');
		$data['footer']						= $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('module/'.$this->moduleName.'.tpl', $data));
	}
	
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'module/'.$this->moduleName)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	
	public function pausegatheringdata() {
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting($this->moduleName.'Status', array($this->moduleName.'Status' => 'pause'), 0);
		$this->session->data['success'] = 'iAnalytics data gathering is now <strong>paused</strong>.';
		$this->response->redirect($this->url->link('module/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function resumegatheringdata() {
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting($this->moduleName.'Status', array($this->moduleName.'Status' => 'run'), 0);
		$this->session->data['success'] = 'iAnalytics data gathering is now <strong>resumed</strong>.';
		$this->response->redirect($this->url->link('module/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL'));
	}
	
	public function deletesearchkeyword() {
		if (!$this->validateForm()) { 
			$this->response->redirect($this->url->link('extension/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->load->language('module/'.$this->moduleName);
		
		if (!empty($_GET['searchValue'])) {
			$this->load->model('module/'.$this->moduleName);
			$this->{$this->moduleModel}->deleteSearchKeyword($_GET['searchValue']);
			
			$this->session->data['success'] = $this->language->get('deleted_keyword');
		}
		
		$this->response->redirect($this->url->link('module/'.$this->moduleName, 'token=' . $this->session->data['token'] . '&tab=1&searchTab=1', 'SSL'));
	}
	
	public function deleteallsearchkeyword() {
		if (!$this->validateForm()) { 
			$this->redirect($this->url->link('extension/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->load->language('module/'.$this->moduleName);
		
		if (!empty($_GET['searchValue'])) {
			$this->load->model('module/'.$this->moduleName);
			$this->{$this->moduleModel}->deleteAllSearchKeyword($_GET['searchValue']);
			
			$this->session->data['success'] = $this->language->get('deleted_keyword');
		}
		
		$this->response->redirect($this->url->link('module/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL'));
	}
	
	public function deleteanalyticsdata() {
		if (!$this->validateForm()) { 
			$this->response->redirect($this->url->link('extension/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->load->language('module/'.$this->moduleName);
		$this->load->model('module/'.$this->moduleName);
		
		$this->{$this->moduleModel}->deleteAnalyticsData();
		
		$this->session->data['success'] = $this->language->get('deleted_analytics_data');
		
		$this->response->redirect($this->url->link('module/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL'));
	}
	
	public function install() {
		$this->load->model('setting/setting');
	    $this->load->model('module/'.$this->moduleName);
		$this->model_setting_setting->editSetting($this->moduleName.'Status', array($this->moduleName.'Status' => 'run'), 0);
	    $this->{$this->moduleModel}->install();
    }
    
    public function uninstall() {
		$this->load->model('setting/setting');
        $this->load->model('module/'.$this->moduleName);
		$this->model_setting_setting->deleteSetting($this->moduleData_module,0);
		$this->model_setting_setting->deleteSetting($this->moduleName.'Status', 0);
        $this->{$this->moduleModel}->uninstall();
	}
}
?>