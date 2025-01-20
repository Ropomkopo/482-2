<?php
class ControllerCheckoutSuccess extends Controller {

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
							'stage' => '6'
						)
					);	
					
					if (isset($this->session->data['iAnalyticsStage']) && ((int)$this->session->data['iAnalyticsStage']<6)) {
						foreach ($iAdata as $table => $tableData) {
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
				}
				/* iAnalytics - End */
			
	public function index() {
		$this->load->language('checkout/success');

		if (isset($this->session->data['order_id'])) {

				$data['iAnalytics'] = $this->config->get('ianalytics');
				if (isset($data['iAnalytics']['Enabled']) && ($data['iAnalytics']['Enabled']=='yes') && isset($data['iAnalytics']['GoogleAnalytics']) && ($data['iAnalytics']['GoogleAnalytics']=='yes') && isset($data['iAnalytics']['GoogleAnalyticsIDNumber'])) 	
				{
					$data['order_id'] = $this->session->data['order_id'];
					$data['store_name'] = $this->config->get('config_name');
					$this->load->model('account/order');
					$data['order_info'] = $this->model_account_order->getOrder($this->session->data['order_id']);
					$data['order_products'] = $this->model_account_order->getOrderProducts($this->session->data['order_id']);
					$tax = 0;
					foreach($data['order_products'] as $row){
						$tax = $tax + $row['tax'];
					}
					$data['tax'] = $tax;
				}
			

				/* iAnalytics - Begin */
				$iAnalyticsSettings = $this->config->get('ianalytics');
				if ($iAnalyticsSettings['Enabled']=='yes' && $iAnalyticsSettings['AfterSaleData']=='yes') {
					$this->register_iAnalytics();
				}
				/* iAnalytics - End */
			
			$this->cart->clear();

			// Add to activity log
			$this->load->model('account/activity');

			if ($this->customer->isLogged()) {
				$activity_data = array(
					'customer_id' => $this->customer->getId(),
					'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
					'order_id'    => $this->session->data['order_id']
				);

				$this->model_account_activity->addActivity('order_account', $activity_data);
			} else {
				$activity_data = array(
					'name'     => $this->session->data['guest']['firstname'] . ' ' . $this->session->data['guest']['lastname'],
					'order_id' => $this->session->data['order_id']
				);

				$this->model_account_activity->addActivity('order_guest', $activity_data);
			}

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
			unset($this->session->data['totals']);
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_basket'),
			'href' => $this->url->link('checkout/cart')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_checkout'),
			'href' => $this->url->link('checkout/checkout', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_success'),
			'href' => $this->url->link('checkout/success')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		if ($this->customer->isLogged()) {
			$data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));
		} else {
			$data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
		}

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/success.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/success.tpl', $data));
		}
	}
}