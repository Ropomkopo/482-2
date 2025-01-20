<?php
class ControllerInformationInformation extends Controller {
	public function index() {
		$this->load->language('information/information');

		$this->load->model('catalog/information');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {

			if ($information_info['meta_title']) {
				$this->document->setTitle(!empty($information_info['meta_title']) && $this->config->get('mlseo_enabled') ? $information_info['meta_title'] : $information_info['title']);
			} else {
				
      if ($this->config->get('mlseo_enabled')) {
        $this->document->setTitle(($information_info['meta_title'] ? $information_info['meta_title'] : $information_info['title']));
        $this->document->setKeywords($information_info['meta_keyword']);
        $this->document->setDescription($information_info['meta_description']);
      } else {
        $this->document->setTitle($information_info['title']);
      }
      
			}

			$this->document->setDescription($information_info['meta_description']);
			$this->document->setKeywords($information_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $information_info['title'],
				'href' => $this->url->link('information/information', 'information_id=' .  $information_id)
			);

			if ($information_info['meta_h1']) {
				$data['heading_title'] = $information_info['meta_h1'];
			} else {
				$data['heading_title'] = !empty($information_info['seo_h1']) && $this->config->get('mlseo_enabled') ? $information_info['seo_h1'] : $information_info['title'];
        
        if (substr(VERSION, 0, 1) == 2) {
          $data['seo_h1'] = !empty($information_info['seo_h1']) ? $information_info['seo_h1'] : '';
          $data['seo_h2'] = !empty($information_info['seo_h2']) ? $information_info['seo_h2'] : '';
          $data['seo_h3'] = !empty($information_info['seo_h3']) ? $information_info['seo_h3'] : '';
        } else {
          $this->data['seo_h1'] = !empty($information_info['seo_h1']) ? $information_info['seo_h1'] : '';
          $this->data['seo_h2'] = !empty($information_info['seo_h2']) ? $information_info['seo_h2'] : '';
          $this->data['seo_h3'] = !empty($information_info['seo_h3']) ? $information_info['seo_h3'] : '';
        }
        
        $this->load->model('tool/seo_package');
  
        if ($this->config->get('mlseo_opengraph')) {
          if (substr(VERSION, 0, 1) == 2) {
            $this->document->addSeoMeta($this->model_tool_seo_package->rich_snippet('opengraph', 'info', $data));
          } else {
            $this->document->addSeoMeta($this->model_tool_seo_package->rich_snippet('opengraph', 'info', $this->data));
          }
          
          if ($this->config->get('mlseo_microdata')) {
            if (substr(VERSION, 0, 1) == 2) {
              $this->document->addSeoMeta($this->model_tool_seo_package->rich_snippet('microdata', 'information', $data));
            } else {
              $this->document->addSeoMeta($this->model_tool_seo_package->rich_snippet('microdata', 'information', $this->data));
            }
          }
        }
      
			}

			$data['button_continue'] = $this->language->get('button_continue');

			$data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/information.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/information.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/information/information.tpl', $data));
			}
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('information/information', 'information_id=' . $information_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}

	public function agree() {
		$this->load->model('catalog/information');

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$output = '';

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {
			$output .= html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
		}

		$this->response->setOutput($output);
	}
}