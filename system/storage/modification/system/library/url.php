<?php
class Url {
    private $url;

	private $domain;
			
    private $ssl;
    private $rewrite = array();

    public function __construct($url, $ssl = '') {
        if (is_bool($url)) { // opencart 2.2
            $this->url = '';
            $this->ssl = $url;
        } else {
            $this->url = $url;
            $this->ssl = $ssl;
        }
    }

    public function addRewrite($rewrite) {
        $this->rewrite[] = $rewrite;
    }


	public function setDomain($domain) {
		$this->domain = $domain;
	}			
    public function link($route, $args = '', $connection = '') {
        // SIMPLE START
        global $config;
        
        $get_route = isset($_GET['route']) ? $_GET['route'] : (isset($_GET['_route_']) ? $_GET['_route_'] : '');
        $debug = isset($_GET['debug']) ? true : false;

        if (!$debug && !empty($config) && method_exists($config, 'get') && $config->get('simple_settings')) {
            if ($config->get('simple_replace_cart') && $route == 'checkout/cart' && $get_route != 'checkout/cart') {
                $connection = 'SSL';
                $route = 'checkout/simplecheckout';

                if ($config->get('simple_popup_checkout')) {
                    $args .= '&popup=1';
                }
            }

            if ($config->get('simple_replace_checkout')) {
                foreach (array('checkout/checkout', 'checkout/unicheckout', 'checkout/uni_checkout', 'checkout/oct_fastorder', 'checkout/buy', 'revolution/revcheckout', 'checkout/pixelshopcheckout') as $page) {
                    if ($route == $page && $get_route != $page) {
                        $route = 'checkout/simplecheckout';

                        if ($config->get('simple_popup_checkout')) {
                            $args .= '&popup=1';
                        }

                        break;
                    }
                }
            }

            if ($config->get('simple_replace_register') && $route == 'account/register' && $get_route != 'account/register') {
                $route = 'account/simpleregister';

                if ($config->get('simple_popup_register')) {
                    $args .= '&popup=1';
                }
            }

            if ($config->get('simple_replace_edit') && $route == 'account/edit' && $get_route != 'account/edit') {
                $route = 'account/simpleedit';
            }

            if ($config->get('simple_replace_address') && $route == 'account/address/update' && $get_route != 'account/address/update') {
                $route = 'account/simpleaddress/update';
            }

            if ($config->get('simple_replace_address') && $route == 'account/address/insert' && $get_route != 'account/address/insert') {
                $route = 'account/simpleaddress/insert';
            }

            if ($config->get('simple_replace_address') && $route == 'account/address/edit' && $get_route != 'account/address/edit') {
                $route = 'account/simpleaddress/update';
            }

            if ($config->get('simple_replace_address') && $route == 'account/address/add' && $get_route != 'account/address/add') {
                $route = 'account/simpleaddress/insert';
            }
        }
        // SIMPLE END

        if (empty($this->url)) {
            if ($this->ssl && $connection) {
                $url = 'https://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/.\\') . '/index.php?route=' . $route;
            } else {
                $url = 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/.\\') . '/index.php?route=' . $route;
            }
        } else {
            if ($this->ssl && $connection) {
                $url = $this->ssl;
            } else {
                $url = $this->url;
            }

            $url .= 'index.php?route=' . $route;
        }

        if ($args) {
            if (is_array($args)) {
                $url .= '&amp;' . http_build_query($args);
            } else {
                $url .= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
            }
        }

        foreach ($this->rewrite as $rewrite) {
          $url = $rewrite->rewrite($url);
        }

        return $url;
    }
}
?>