<?php

class ControllerModuleAlphaSms extends Controller
{
    private $_gate;
    private $_err;
    private $_log;
    private $data;

    private $message_keys = array(
        'alphasms_message_connection_error' => 'При отправке оповещения по SMS возникли неполадки со шлюзом AlphaSms.ua.
<br />Время отправки: %s<br />Ответ сервера: %s',
        'alphasms_message_customer_new_register' => 'Поздравляем с успешной регистрацией в интернет-магазине "%s"',
        'alphasms_message_customer_new_order' => 'Спасибо за покупку. Ваш номер заказа #%s',
        'alphasms_message_admin_new_customer' => 'Зарегистрирован новый покупатель',
        'alphasms_message_admin_new_order' => 'Новый заказ',
        'alphasms_message_admin_new_email' => 'Отправлено новое письмо со страницы контактов',
        'alphasms_message_customer_new_order_status' => 'Статус заказа #%s изменился на "%s".'
    );
    private $l; // language code (e.g. `ru`)

    public function index()
    {
        $this->l = $this->language->get('code');

        $this->_init();

        $this->data['tab_sel'] = null;
        if ($this->request->server['REQUEST_METHOD'] !== 'POST') {
            $this->_view();
            return;
        }

        if ($this->_validate()) {
            if (((isset($this->request->post['alphasms_login']) && isset($this->request->post['alphasms_password'])) ||
                isset($this->request->post['alphasms_key'])) && empty($this->request->post['is_sms'])
            ){
                unset($this->request->post['alphasms_frmsms_message']);
                unset($this->request->post['alphasms_frmsms_phone']);

                /*
                 * Replace in $_POST array messages templates with language code;
                 */
                foreach ($this->message_keys as $k => $v) {
                    if (!empty($this->request->post[$k])) {
                        $this->request->post[$k . '_' . $this->l] = $this->request->post[$k];
                        unset($this->request->post[$k]);
                    }
                }

                $this->model_setting_setting->editSetting('alphasms', $this->request->post);

                $this->session->data['success'] = $this->language->get('alphasms_saved_success');
                $this->_log->write('['.substr(__FILE__, strlen(DIR_SYSTEM)-1).'] Save settings form form success');
                $this->response->redirect($this->url->link('extension/module', 'token='.$this->session->data['token']));

            } else if(!empty($this->request->post['is_sms'])) {
                if (!$this->_gate){
                    $this->_err = $this->language->get('alphasms_error_auth_info');
                } else {
                    $this->_gate->setSign($this->config->get('alphasms_sign'));
                    $this->_gate->sendSms($this->request->post['alphasms_frmsms_phone'],
                        $this->request->post['alphasms_frmsms_message']
                    );

                    $errs = '';
                    if ($errs=$this->_gate->getErrors()) {
                        $this->_err = $errs;
                    } else {
                        $this->session->data['success'] = $this->language->get('alphasms_smssend_success');
                        $this->session->data['success_sms'] = $this->language->get('alphasms_smssend_success');
                        $this->session->data['tab_sel'] = 'tab_sendsms';
                        $this->data['success_sms'] = $this->language->get('alphasms_smssend_success');
                        $this->_log->write('['.substr(__FILE__, strlen(DIR_SYSTEM)-1).'] Send sms from form success');
                        $this->response->redirect(
                            $this->url->link('module/alphasms', 'token='.$this->session->data['token'], 'SSL')
                        );
                    }
                }
            }
        }

        $this->_view();
    }

    private function _breadcrumbs()
    {
        $breadcrumbs[] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token='.$this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $breadcrumbs[] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        $breadcrumbs[] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('module/alphasms', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        return $breadcrumbs;
    }

    private function _init()
    {
        require_once(DIR_SYSTEM.'library/alphasms_gateway.php');

        $this->load->model('setting/setting');

        $this->load->model('localisation/language');

        $this->_log = new Log('alphasms.log');

        foreach ($this->load->language('module/alphasms') as $key => $val) {
            $this->data[$key] = $val;
        }

        $settings = $this->model_setting_setting->getSetting('alphasms');

        foreach ($settings as $key => $val) {
            $this->data['frm_'.$key] = $val;
        }

        if (array_key_exists('alphasms_admphone', $settings) && !$settings['alphasms_admphone']){
            $this->data['frm_alphasms_admphone'] = $this->config->get('config_telephone');
        }

        if (!empty($settings)) {
            $this->_gate = new AlphaSmsGateway(
                $this->data['frm_alphasms_login'],
                $this->data['frm_alphasms_password'],
                $this->data['frm_alphasms_key']
            );
        }

        /*
         * Set templates tab title
         */
        $this->data['alphasms_tab_templates'] = $this->language->get('alphasms_tab_templates');

        /*
         * Set button text into template
         */
        $this->data['alphasms_text_button_save_templates']=$this->language->get('alphasms_text_button_save_templates');

        /*
         * Set template titles to template
         */
        $this->data['alphasms_connection_error_title'] = $this->language->get('alphasms_connection_error_title');
        $this->data['alphasms_customer_new_register_title'] = $this->language
            ->get('alphasms_customer_new_register_title');
        $this->data['alphasms_customer_new_order_title'] = $this->language->get('alphasms_customer_new_order_title');
        $this->data['alphasms_admin_new_customer_title'] = $this->language->get('alphasms_admin_new_customer_title');
        $this->data['alphasms_admin_new_order_title'] = $this->language->get('alphasms_admin_new_order_title');
        $this->data['alphasms_admin_new_email_title'] = $this->language->get('alphasms_admin_new_email_title');
        $this->data['alphasms_customer_new_order_status_title'] = $this->language
            ->get('alphasms_customer_new_order_status_title');

        /*
         * Set templates values into template textareas
         */
        foreach ($this->message_keys as $k => $v) {
            $this->data[$k] = strlen($this->config->get($k . '_' . $this->l)) > 0 ?
                $this->config->get($k . '_' . $this->l) : $v;
        }
    }

    protected function _view()
    {
        $this->document->setTitle($this->language->get('heading_title'));

        # Set variables for view file
        $this->data['module_version'] = AlphaSmsGateway::VERSION;
        $this->data['err']            = $this->_err;
        $this->data['breadcrumbs']    = $this->_breadcrumbs();

        $this->data['languages']      = $this->model_localisation_language->getLanguages();

        $this->data['action'] = $this->url->link('module/alphasms', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        # Save a new form values from request
        foreach ($this->request->post as $key => $value) {
            $this->data['frm_' . $key] = $value;
        }

        if (isset($this->session->data['success'])){
            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        }

        if (isset($this->session->data['success_sms'])){
            $this->data['success_sms'] = $this->session->data['success_sms'];
            unset($this->session->data['success_sms']);
        }

        if (isset($this->session->data['tab_sel'])){
            $this->data['tab_sel'] = $this->session->data['tab_sel'];
            unset($this->session->data['tab_sel']);
        }

        # Template rendering
//    $this->children = array('common/header', 'common/footer');

        $this->data['header'] = $this->load->controller('common/header');
        $this->data['column_left'] = $this->load->controller('common/column_left');
        $this->data['footer'] = $this->load->controller('common/footer');

        $this->template = 'module/alphasms.tpl';


        $this->response->setOutput($this->load->view('module/alphasms.tpl', $this->data));

    }

    private function _validate()
    {
        if (!$this->user->hasPermission('modify', 'module/alphasms')) {
            $this->_err = $this->language->get('alphasms_error_permission');
            return false;
        }

        if (empty($this->request->post['alphasms_login']) and empty($this->request->post['alphasms_key'])) {
            $this->_err = $this->language->get('alphasms_error_login_field');
            return false;
        }

        if (empty($this->request->post['alphasms_password'])  and empty($this->request->post['alphasms_key'])) {
            $this->_err = $this->language->get('alphasms_error_password_field');
            return false;
        }

        if (!empty($this->request->post['is_sms'])){

            $this->data['tab_sel'] = 'tab_sendsms';
            if (empty($this->request->post['alphasms_frmsms_message'])
                || !preg_match("!\+[0-9]{10,14}!si", $this->request->post['alphasms_frmsms_phone'])
            ) {
                //$this->_err = $this->language->get('alphasms_error_phone');
                $this->_err = ' ';
                return false;
            }
        }

        if (empty($this->request->post['alphasms_sign'])) {
            $this->_err = $this->language->get('alphasms_error_sign_field');
            return false;
        } else if (strlen($this->request->post['alphasms_sign'])>11) {
            $this->_err = $this->language->get('alphasms_error_sign_to_large');
            return false;
        }

        if (empty($this->request->post['alphasms_admphone'])) {
            $this->_err = $this->language->get('alphasms_error_admphone_field');
            return false;
        }


        try{
            // Test connection
            $gateway = new AlphaSmsGateway(
                $this->request->post['alphasms_login'],
                $this->request->post['alphasms_password'],
                $this->request->post['alphasms_key']
            );

            if (!$gateway->testConnection()){
                $this->_err = 'Connection test failed';
                $this->_err .= '<br/>HTTP/HTTPS errors:<br/>'.$gateway->getErrors('<br/>');
                return false;
            }
        } catch(Exception $ax) {
            return false;
        }


        return true;
    }

}
