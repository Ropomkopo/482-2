<?php

class AlphaSmsGateway
{

    private $_err = array();
    private $_login;
    private $_password;
    private $_key;
    private $_sign;

    public $mode = 'HTTPS'; //HTTP or HTTPS
    protected $_server = '://alphasms.com.ua/api/http.php';
    protected $_errors = array();
    protected $_last_response = array();

    const VERSION = '1.9';
    private $_version = '1.9';

    public function __construct($login = '', $password = '', $key = '')
    {
        $this->_login = $login;
        $this->_password = $password;
        $this->_key = $key;
    }

    public function setSign($sign_name)
    {
        $this->_sign = $sign_name;
    }

    public function testConnection()
    {
        if (!$this->_auth())
            return false;

        return true;
    }

    public function sendSms($dst_phone, $message, $send_dt = 0, $wap = '', $flash = 0)
    {

        if (!$this->_auth())
            return false;


        if (!$send_dt)
            $send_dt = date('Y-m-d H:i:s');
        $d = is_numeric($send_dt) ? $send_dt : strtotime($send_dt);
        $data = array('from' => $this->_sign,
            'to' => $dst_phone,
            'message' => $message,
            'ask_date' => date(DATE_ISO8601, $d),
            'wap' => $wap,
            'flash' => $flash,
            'class_version' => $this->_version);
        $result = $this->execute('send', $data);
        if (isset($result['errors']) and count(@$result['errors'])) {
            $this->_err = $result['errors'];
            return false;
        }
        return true;

    }

    protected function execute($command, $params = array())
    {
        $this->_errors = array();

        //HTTP GET
        if (strtolower($this->mode) == 'http') {
            $response = @file_get_contents($this->generateUrl($command, $params));
            return @unserialize($this->base64_url_decode($response));
        } else {
            $params['login'] = $this->_login;
            $params['password'] = $this->_password;
            $params['key'] = $this->_key;
            $params['command'] = $command;
            $params_url = '';
            foreach ($params as $key => $value)
                $params_url .= '&' . $key . '=' . $this->base64_url_encode($value);

            //cURL HTTPS POST
            $ch = curl_init(strtolower($this->mode) . $this->_server);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_POST, count($params));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params_url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $response = @curl_exec($ch);
            curl_close($ch);

            $this->_last_response = @unserialize($this->base64_url_decode($response));
            return $this->_last_response;
        }
    }

    protected function generateUrl($command, $params = array())
    {
        $params_url = '';
        if (count($params))
            foreach ($params as $key => $value)
                $params_url .= '&' . $key . '=' . $this->base64_url_encode($value);
        if (!$this->_key) {
            $auth = '?login=' . $this->base64_url_encode($this->_login) . '&password=' . $this->base64_url_encode($this->_password);
        } else {
            $auth = '?key=' . $this->base64_url_encode($this->_key);
        }
        $command = '&command=' . $this->base64_url_encode($command);
        return strtolower($this->mode) . $this->_server . $auth . $command . $params_url;
    }

    public function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_,');
    }

    public function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_,', '+/='));
    }

    public function getErrors($sep = "\n")
    {
        return join($sep, $this->_err);
    }

    private function _auth()
    {

        return true;
    }

    private function _explainSoapProblem($soap_res)
    {
        if ($soap_res->extend && is_array($soap_res->extend)) {
            $this->_err[] = var_export($soap_res->extend, true);
        }
        return;
    }

}