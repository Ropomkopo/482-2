<?php
class ControllerCommonLanguage extends Controller {
	public function index() {
		$this->load->language('common/language');

		$data['text_language'] = $this->language->get('text_language');

		$data['action'] = $this->url->link('common/language/language', '', $this->request->server['HTTPS']);

		$data['code'] = $this->session->data['language'];

		$this->load->model('localisation/language');

		$data['languages'] = array();

		$results = $this->model_localisation_language->getLanguages();

		foreach ($results as $result) {
			if ($result['status']) {
				$data['languages'][] = array(
					'name'  => $result['name'],
					'code'  => $result['code'],
					'image' => $result['image']
				);
			}
		}

		if (!isset($this->request->get['route'])) {
			$data['redirect'] = 'common/home';
		} else {
			$url_data = $this->request->get;

			unset($url_data['_route_']);

			$route = $url_data['route'];

			unset($url_data['route']);

      unset($url_data['site_language']);
      unset($url_data['_route_']);
    

			$url = '';

			if ($url_data) {
				$url = '&' . urldecode(http_build_query($url_data, '', '&'));
			}

			$data['redirect'] = $route . $url;
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/language.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/language.tpl', $data);
		} else {
			return $this->load->view('default/template/common/language.tpl', $data);
		}
	}

	public function language() {
		if (isset($this->request->post['code']) && !$this->config->get('mlseo_store_mode')) {
			$this->session->data['language'] = $this->request->post['code'];
		}

		if (isset($this->request->post['redirect'])) {
			
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
          $connection = 'SSL';
            } else {
          $connection = 'NONSSL';
        }
      
        $redir_route = $this->request->post['redirect'];
      
      if ($redir_params = strstr($redir_route, '&')) {
          $redir_route = str_replace($redir_params, '', $redir_route);
      } else {
        $redir_params = '';
      }
      
      // handle sub-stores rewriting
      if ($this->config->get('mlseo_store_mode')) {
        $lang_to_store = $this->config->get('mlseo_lang_to_store');
      }
      
      if (!empty($lang_to_store)) {
        $this->response->redirect(str_replace(array($this->config->get('config_url'), $this->config->get('config_ssl')), $lang_to_store[$this->request->post['code']], $this->url->link($redir_route, str_replace('&amp;', '&', $redir_params), $connection)));
      }
      
      $this->response->redirect($this->url->link($redir_route, str_replace('&amp;', '&', $redir_params), $connection));
      
		} else {
			$this->response->redirect($this->url->link('common/home'));
		}
	}
}