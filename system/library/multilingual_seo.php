<?php
/************************************
 - Sirius SEO Package - multilingual handler -
*************************************

 contact : sirius_box-dev@yahoo.fr
 
************************************/

final class multilingual_seo extends Controller {

	public function detect() {
    // prefix mode
    if ($this->config->get('mlseo_store_mode')) {
      $lang_to_store = $this->config->get('mlseo_lang_to_store');
      
      foreach ($lang_to_store as $lang => $store) {
        if (isset($store['config_url']) && strpos($store['config_url'], $this->request->server['HTTP_HOST']) !== false) {
          $this->session->data['language'] = $lang;
        }
      }
    
    // suffix mode
    } else if ($this->config->get('mlseo_flag') && !empty($this->request->get['_route_'])) {
      $parts = explode('/', $this->request->get['_route_']);
      $lgCode = array_shift($parts);
      $lgCodes = (array) $this->config->get('mlseo_lang_codes');
      
      if ($lgKey = array_search(strtolower($lgCode), array_map(array($this, 'langCode'), $lgCodes))) {
        $this->session->data['language'] = $lgCodes[$lgKey];
        $this->request->get['_route_'] = implode('/', $parts);
      } else {
				$this->session->data['language'] = $this->config->get('mlseo_default_lang');
			}
    // multilingual
    } else if($this->config->get('mlseo_ml_mode')) {
			$get = array();
			
			if (isset($this->request->get['_route_'])) {
				$parts = explode('/', $this->request->get['_route_']);
				
				foreach ($parts as $part) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");
					
					if ($query->num_rows) {
						$url = explode('=', $query->row['query']);
						
						if ($url[0] == 'product_id') {
							$get['product_id'] = $url[1];
						}
						
						if ($url[0] == 'category_id') {
							if (!isset($this->request->get['path'])) {
								$get['path'] = $url[1];
							} else {
								$get['path'] .= '_' . $url[1];
							}
						}	
						
						if ($url[0] == 'manufacturer_id') {
							$get['manufacturer_id'] = $url[1];
						}
						
						if ($url[0] == 'information_id') {
							$get['information_id'] = $url[1];
						}	
					} else {
						$get['route'] = 'error/not_found';	
					}
				}
				if (isset($get['product_id'])) {
					$get['route'] = 'product/product';
				} elseif (isset($get['path'])) {
					$get['route'] = 'product/category';
				} elseif (isset($get['manufacturer_id'])) {
					$get['route'] = 'product/manufacturer/product';
				} elseif (isset($get['information_id'])) {
					$get['route'] = 'information/information';
				}
				
				if (isset($get['route'])) {
					if (isset($query->row['language_id']) && ($query->row['language_id'] != 0) && (count($query->rows) === 1)) {
						$lgCodes = (array) $this->config->get('mlseo_lang_codes');
            
            if (isset($lgCodes[$query->row['language_id']])) {
							$this->session->data['language'] = $lgCodes[$query->row['language_id']];
            }
          }
        }
      }
    }
  }
  
  public function langCode($code) {
    if ($this->config->get('mlseo_flag_short') && strpos($code, '-')) {
      $code = strstr($code, '-', true);
    }
    
    return strtolower($code);
  }
}