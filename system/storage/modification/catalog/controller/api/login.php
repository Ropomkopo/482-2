<?php
class ControllerApiLogin extends Controller {

                /* iAnalytics - Begin */
				protected function register_iAnalytics() {
					$iAstage = (!empty($this->session->data['iAnalyticsStage'])) ? $this->session->data['iAnalyticsStage'] : '0';
					$iAtoday = date("Y-m-d"); 
					$iAtime = date("H:i:s"); 
					$iAFromIP = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '*HiddenIP*';
					$iASpokenLanguages = (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
					
					$iAdata = array(
						'ianalytics_funnel_data' => array (
							'date' => $iAtoday,
							'time' => $iAtime,
							'from_ip' => $iAFromIP,
							'spoken_languages' => $iASpokenLanguages,
							'stage' => '2'
						)
					);	
					
					if (isset($this->session->data['iAnalyticsStage']) && ((int)$this->session->data['iAnalyticsStage']<2)) {
						foreach ($iAdata as $table => $tableData) {
							$insertFields = array();
							$insertData = array();
							
							foreach ($tableData as $fieldName => $fieldValue) {
								$insertFields[] = $fieldName;
								$insertData[] = '"'.$this->db->escape($fieldValue).'"';
							}
							$this->db->query('INSERT INTO ' . DB_PREFIX . $table . ' ('. implode(',', $insertFields) .') VALUES ('.implode(',', $insertData).')');
						}
						$this->session->data['iAnalyticsStage'] = '2';
					}
				}
				/* iAnalytics - End */
			
	public function index() {
		$this->load->language('api/login');

		$json = array();

		$this->load->model('account/api');

		// Check if IP is allowed
		$ip_data = array();

		$results = $this->model_account_api->getApiIps($this->config->get('config_api_id'));

		foreach ($results as $result) {
			$ip_data[] = $result['ip'];
		}

		if (!in_array($this->request->server['REMOTE_ADDR'], $ip_data)) {
			$json['error']['ip'] = sprintf($this->language->get('error_ip'), $this->request->server['REMOTE_ADDR']);
		}

		if (!$json) {
			// Login with API Key
			$api_info = $this->model_account_api->getApiByKey($this->request->post['key']);

			if ($api_info) {

                /* iAnalytics - Begin */
				$iAnalyticsSettings = $this->config->get('ianalytics');
				if ($iAnalyticsSettings['Enabled']=='yes' && $iAnalyticsSettings['AfterSaleData']=='yes') {
					$this->register_iAnalytics();
				}
				/* iAnalytics - End */
			
				$json['success'] = $this->language->get('text_success');

				$sesion_name = 'temp_session_' . uniqid();

				$session = new Session($this->session->getId(), $sesion_name);

				// Set API ID
				$session->data['api_id'] = $api_info['api_id'];

				// Create Token
				$json['token'] = $this->model_account_api->addApiSession($api_info['api_id'], $sesion_name, $session->getId(), $this->request->server['REMOTE_ADDR']);
			} else {
				$json['error']['key'] = $this->language->get('error_key');
			}
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
