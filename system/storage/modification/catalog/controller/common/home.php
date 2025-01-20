<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

  // seo meta (overwrites the previously defined)
  if ($this->config->get('mlseo_enabled')) {
    $seo_meta = $this->config->get('mlseo_store');
    if (isset($seo_meta[$this->config->get('config_store_id').$this->config->get('config_language_id')])) {
      $seo_meta = $seo_meta[$this->config->get('config_store_id').$this->config->get('config_language_id')];
    }
    
    if (!empty($seo_meta['seo_title'])) {
      ${'this'}->document->setTitle($seo_meta['seo_title']);
    } else {
      ${'this'}->document->setTitle($this->config->get('config_title'));
    }
    
    if (!empty($seo_meta['description'])) {
      ${'this'}->document->setDescription($seo_meta['description']);
    } else {
      ${'this'}->document->setDescription($this->config->get('config_meta_description'));
    }
    
    if (!empty($seo_meta['keywords'])) {
      ${'this'}->document->setKeywords($seo_meta['keywords']);
    }
    
    if (substr(VERSION, 0, 1) == 2) {
      $data['heading_title'] = $data['seo_h1'] = !empty($seo_meta['title']) ? $seo_meta['title'] : $this->config->get('config_title');
      $data['seo_h2'] = !empty($seo_meta['h2']) ? $seo_meta['h2'] : '';
      $data['seo_h3'] = !empty($seo_meta['h3']) ? $seo_meta['h3'] : '';
    } else {
      $this->data['heading_title'] = $this->data['seo_h1'] = !empty($seo_meta['title']) ? $seo_meta['title'] : $this->config->get('config_title');
      $this->data['seo_h2'] = !empty($seo_meta['h2']) ? $seo_meta['h2'] : '';
      $this->data['seo_h3'] = !empty($seo_meta['h3']) ? $seo_meta['h3'] : '';
    }
  }
  /* now defined in header ctrl
  $this->load->model('tool/seo_package');
  
  if ($this->config->get('mlseo_opengraph')) {
    if (substr(VERSION, 0, 1) == 2) {
      $this->document->addSeoMeta($this->model_tool_seo_package->rich_snippet('opengraph', 'home'));
    } else {
      $this->document->addSeoMeta($this->model_tool_seo_package->rich_snippet('opengraph', 'home'));
    }
  }
  
  if ($this->config->get('mlseo_tcard')) {
    if (substr(VERSION, 0, 1) == 2) {
      $this->document->addSeoMeta($this->model_tool_seo_package->rich_snippet('tcard', 'home'));
    } else {
      $this->document->addSeoMeta($this->model_tool_seo_package->rich_snippet('tcard', 'home'));
    }
  }
  
  if ($this->config->get('mlseo_gpublisher')) {
    if (substr(VERSION, 0, 1) == 2) {
      $this->document->addSeoMeta($this->model_tool_seo_package->rich_snippet('gpublisher', 'home'));
    } else {
      $this->document->addSeoMeta($this->model_tool_seo_package->rich_snippet('gpublisher', 'home'));
    }
  }
  */
  // end - seo meta
      

		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/home.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/home.tpl', $data));
		}
	}
}