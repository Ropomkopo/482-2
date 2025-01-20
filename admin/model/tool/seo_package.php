<?php
class ModelToolSeoPackage extends Model {
  
  public function getFriendlyUrls($lang) {

  }
  
	public function getProductCategoryName($product_id, $lang, $parent = false) {
    if ($parent) {
      $query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "product_to_category pc LEFT JOIN " . DB_PREFIX . "category c ON c.category_id = pc.category_id LEFT JOIN " . DB_PREFIX . "category_description cd ON cd.category_id = c.parent_id WHERE pc.product_id = '" . (int)$product_id . "' AND cd.language_id=".$lang." LIMIT 1")->row;
    } else {
		$query = $this->db->query("SELECT c.name FROM " . DB_PREFIX . "product_to_category pc LEFT JOIN " . DB_PREFIX . "category_description c ON c.category_id = pc.category_id WHERE pc.product_id = '" . (int)$product_id . "' AND c.language_id=".$lang." LIMIT 1")->row;
    }
		
		if (isset($query['name']))
			return $query['name'];
		return'';
	}
  
  public function getCategoryName($category_id, $lang, $parent = false) {
    if ($parent) {
      $query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON cd.category_id = c.parent_id WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id=".$lang." LIMIT 1")->row;
    } else {
      $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "' AND language_id=".$lang." LIMIT 1")->row;
    }
		
		if (isset($query['name']))
			return $query['name'];
		return'';
	}
  
  public function getParentCategoryName($category_id, $lang) {
		//$query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "category_description cd LEFT JOIN " . DB_PREFIX . "category c ON c.category_id = cd.category_id WHERE cd.category_id = '" . (int)$category_id . "' AND language_id=".$lang." LIMIT 1")->row;
		$query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON c.parent_id = cd.category_id WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id=".$lang." LIMIT 1")->row;
		
		if (isset($query['name']))
			return $query['name'];
		return'';
	}
	
	public function getProductCategoryId($product_id) {
		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "' LIMIT 1")->row;
		
		if (isset($query['category_id']))
			return $query['category_id'];
		return'';
	}
	
	public function getManufacturerName($manufacturer_id) {
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "' LIMIT 1")->row;
		
		if (isset($query['name']))
			return $query['name'];
		return'';
	}
	
	public function commonTransform($pattern, $lang, $row, $get_value = false) {
    preg_match('#\{(.+\|.+)\}#', $pattern, $res);
    
    if ($res) {
      $rand = explode('|', $res[1]);
      
      if (is_array($rand)) {
        if ($get_value) {
          if (isset($this->session->data['gkd_seorand']) && $this->session->data['gkd_seorand']+1 <= count($rand)-1) {
            $this->session->data['gkd_seorand']++;
          } else {
            $this->session->data['gkd_seorand'] = 0;
          }
          
          $pattern = str_replace($res[0], $rand[$this->session->data['gkd_seorand']], $pattern);
        } else {
          $pattern = str_replace($res[0], $rand[array_rand($rand)], $pattern);
        }
      }
    }
    
    $replace  = array();
    
    if ($this->config->get('mlseo_current_lang')) {
      $lang_code = $this->config->get('mlseo_current_lang');
    } else {
      $lang_code = $this->getLangCode($lang);
    }
    
    $replace['{'.$lang_code.'}'] = '';
    $replace['{/'.$lang_code.'}'] = '';   
    
    if (strpos($pattern, '[lang_id]') !== false)
			$replace['[lang_id]'] = $lang;
		if (strpos($pattern, '[lang]') !== false)
			$replace['[lang]'] = $lang_code;
    
    $pattern = str_replace(array_keys($replace), array_values($replace), $pattern);

    if ($this->config->get('mlseo_lang_codes')) {
      $lgCodes = implode('|', $this->config->get('mlseo_lang_codes'));
      $pattern = preg_replace('/\{('.$lgCodes.')\}(.*)\{\/('.$lgCodes.')\}/isU', '', $pattern);
    }
    
    return $pattern;
  }
  
	public function transformProduct($pattern, $lang, $row, $get_value = false) {
    $pattern = $this->commonTransform($pattern, $lang, $row, $get_value);
    
		if (!isset($row['name'])) {
			$row['name'] = $row['product_description'][$lang]['name'];
			$row['description'] = $row['product_description'][$lang]['description'];
		}
		
    //$this->load->model('catalog/product');
    //$product_attributes = $this->model_catalog_product->getProductAttributes($row['product_id']);
    
    // $product_attributes = $this->db->query("SELECT ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$row['product_id'] . "' AND ad.language_id = '" . (int)$lang . "' AND pa.language_id = '" . (int)$lang . "' ORDER BY a.sort_order, ad.name")->rows;
		// var_dump($product_attributes);die;
    // preg_match('#\[attribute_name:(\d)\]#', $pattern, $res);
    
		$replace  = array();
		if (strpos($pattern, '[name]') !== false)
			$replace['[name]'] = trim($row['name']);
		if (strpos($pattern, '[model]') !== false)
			$replace['[model]'] = trim($row['model']);
		if (strpos($pattern, '[upc]') !== false)
			$replace['[upc]'] = trim($row['upc']);
		if (strpos($pattern, '[sku]') !== false)
			$replace['[sku]'] = trim($row['sku']);
		if (strpos($pattern, '[ean]') !== false)
			$replace['[ean]'] = trim($row['ean']);
		if (strpos($pattern, '[jan]') !== false)
			$replace['[jan]'] = trim($row['jan']);
		if (strpos($pattern, '[isbn]') !== false)
			$replace['[isbn]'] = trim($row['isbn']);
		if (strpos($pattern, '[mpn]') !== false)
			$replace['[mpn]'] = trim($row['mpn']);
		if (strpos($pattern, '[location]') !== false)
			$replace['[location]'] = trim($row['location']);
    if (strpos($pattern, '[price]') !== false)
			$replace['[price]'] = (float)$row['price'] ? $this->currency->format($row['price'], $this->config->get('config_currency')) : '';
		if (strpos($pattern, '[prod_id]') !== false)
			$replace['[prod_id]'] = isset($row['product_id']) ? trim($row['product_id']) : '';
		if (strpos($pattern, '[cat_id]') !== false)
			$replace['[cat_id]'] = isset($row['product_id']) ? trim($this->getProductCategoryId($row['product_id'], $lang)) : '';
		if (strpos($pattern, '[category]') !== false) {
      if (!empty($this->request->post['product_category'])) {
        $replace['[category]'] = trim($this->getCategoryName($this->request->post['product_category'][0], $lang));
      } else if (isset($row['product_id'])) {
        $replace['[category]'] = trim($this->getProductCategoryName($row['product_id'], $lang));
      } else {
        $replace['[category]'] = '';
      }
    }
		if (strpos($pattern, '[parent_category]') !== false) {
      if (!empty($this->request->post['product_category'])) {
        $replace['[parent_category]'] = trim($this->getCategoryName($this->request->post['product_category'][0], $lang, true));
      } else if (isset($row['product_id'])) {
        $replace['[parent_category]'] = trim($this->getProductCategoryName($row['product_id'], $lang, true));
      } else {
        $replace['[parent_category]'] = '';
      }
    }
		if (strpos($pattern, '[brand]') !== false)
			$replace['[brand]'] = (isset($row['product_id']) && $row['manufacturer_id']) ? trim($this->getManufacturerName($row['manufacturer_id'])) : '';
		if (strpos($pattern, '[desc]') !== false)
			$replace['[desc]'] = trim(preg_replace('/\s\s+/', ' ', substr(strip_tags(html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8')), 0, 150)));
		// categories ?
			
		$value = str_replace(array_keys($replace), array_values($replace), $pattern);
		$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
		
		return trim($value);
	}
	
	public function transformCategory($pattern, $lang, $row, $get_value = false) {
    $pattern = $this->commonTransform($pattern, $lang, $row, $get_value);
    
		if (!isset($row['name'])) {
			$row['name'] = $row['category_description'][$lang]['name'];
			$row['description'] = $row['category_description'][$lang]['description'];
		}
		
		$replace  = array();
    
		if (strpos($pattern, '[name]') !== false)
			$replace['[name]'] = trim($row['name']);
		if (strpos($pattern, '[desc]') !== false)
			$replace['[desc]'] = trim(preg_replace('/\s\s+/', ' ', substr(strip_tags(html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8')), 0, 150)));
		if (strpos($pattern, '[cat_id]') !== false)
			$replace['[cat_id]'] = trim($row['category_id']);
    if (strpos($pattern, '[parent]') !== false)
			$replace['[parent]'] = !empty($row['category_id']) ? trim($this->getParentCategoryName($row['category_id'], $lang)) : '';

			/*
		if (strpos($pattern, '[parent]') !== false)
			$replace['[parent]'] = $this->model_tool_seo_package->getParentCategoryName($row['category_id'], $lang);
			*/
			
		$value = str_replace(array_keys($replace), array_values($replace), $pattern);
		$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
		
		return trim($value);
	}
	
	public function transformInformation($pattern, $lang, $row, $get_value = false) {
    $pattern = $this->commonTransform($pattern, $lang, $row, $get_value);
    
		if (!isset($row['title'])) {
			$row['title'] = $row['information_description'][$lang]['title'];
			$row['description'] = $row['information_description'][$lang]['description'];
		}
		
		$replace  = array();
		if (strpos($pattern, '[name]') !== false)
			$replace['[name]'] = trim($row['title']);
		if (strpos($pattern, '[title]') !== false)
			$replace['[title]'] = trim($row['title']);
		if (strpos($pattern, '[desc]') !== false)
			$replace['[desc]'] = trim(preg_replace('/\s\s+/', ' ', substr(strip_tags(html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8')), 0, 150)));
			
		$value = str_replace(array_keys($replace), array_values($replace), $pattern);
		$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
		
		return trim($value);
	}
	
	public function transformManufacturer($pattern, $lang, $row, $get_value = false) {
    $pattern = $this->commonTransform($pattern, $lang, $row, $get_value);
    
		$replace  = array();
		if (strpos($pattern, '[name]') !== false)
			$replace['[name]'] = trim($row['name']);
				
		$value = str_replace(array_keys($replace), array_values($replace), $pattern);
		$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
		
		return $value;
	}
	
	public function filter_seo($seo_kw, $type, $id, $lang = '') {
		$whitespace = $this->config->get('mlseo_whitespace');
    
		if ($this->config->get('mlseo_lowercase')) {
      $seo_kw = mb_convert_case($seo_kw, MB_CASE_LOWER, 'UTF-8');
    }
    
		$seo_kw = str_replace(' ', $whitespace, $seo_kw);
    
    if ($lang) {
      $translit = $this->config->get('mlseo_ascii_'.$lang);
    } else {
      $translit = $this->config->get('mlseo_ascii_'.$this->config->get('config_language_id'));
    }
    
		if ($translit) {
			// language specific tr
			$seo_kw = $this->mb_strtr($seo_kw, 'ÁáČčĎďĚěŇňŘřŠšŤťÚúŮůÝýŽžĐđ', 'AaCcDdEeNnRrSsTtUuUuYyZzDd'); // czech, croatian, slovenian
			$seo_kw = $this->mb_strtr($seo_kw, 'ĄČĘĖĮYŠŲŪŽąčęėįyšųūž', 'ACEEIYSUUZaceeiysuuz'); // lithunanian
			$seo_kw = $this->mb_strtr($seo_kw, 'ĀČĒĢĪĶĻŅŠŪŽāčēģīķļņšūž', 'ACEGIKLNSUZacegiklnsuz'); // latvian
			$seo_kw = $this->mb_strtr($seo_kw, 'ÇçĞğİıÖöŞşÜü', 'CcGgIiOoSsUu'); // turkish
			$seo_kw = $this->mb_strtr($seo_kw, 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ', 'AAAAAAACEEEEIIIIDNOOOOOOUUUUYBSaaaaaaaceeeeiiiidnoooooouuuyybyRr'); // russian
			$seo_kw = $this->mb_strtr($seo_kw, array('А','а','Б','б','В','в','Г','г','Д','д','Е','е','Ё' ,'ё' ,'Ж' ,'ж' ,'З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н','О','о','П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц' ,'ц' ,'Ч' ,'ч' ,'Ш' ,'ш' ,'Щ'   ,'щ'   ,'Ы','ы','Э','э','Ю' ,'ю' ,'Я' ,'я' ),
																   array('A','a','B','b','V','v','G','g','D','d','E','e','Yo','yo','Zh','zh','Z','z','I','i','J','j','K','k','L','l','M','m','N','n','O','o','P','p','R','r','S','s','T','t','U','u','F','f','H','h','Ts','ts','Ch','ch','Sh','Sh','Shch','shch','Y','y','E','e','Yu','yu','Ya','ya')); // russian
			$seo_kw = $this->mb_strtr($seo_kw, array('І', 'і', 'Ї', 'ї', 'Є', 'є', 'Ґ', 'ґ'), array('I','i','Yi','yi', 'Ye', 'ye', 'G', 'g')); // ukrainian
			
			// entities autodetect method (works for western europe languages)
			$seo_kw = preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml|caron);~i', '$1', htmlentities($seo_kw, ENT_QUOTES, 'UTF-8'));
			$seo_kw = html_entity_decode($seo_kw, ENT_QUOTES);
			$seo_kw = preg_replace(array('~[^0-9a-z]~i', '~[ -]+~'), $whitespace, $seo_kw);
			
			$seo_kw = trim($seo_kw, '_'.$whitespace);
		}
    
		//$seo_kw = str_replace(array('"',"'",'&','(',')','.','+',',','*',':',';','=','?','@','$','/','%','#'), '', $seo_kw);
		$seo_kw = str_replace(array('"','&','&amp;','+','?','/','%','#', ',','&gt;','&lt;','<','>'), '', $seo_kw);
    
    if ($whitespace) {
      $seo_kw = mb_ereg_replace($whitespace.$whitespace.'+', $whitespace, $seo_kw);
      $seo_kw = trim($seo_kw, $whitespace);
    }
		
		$exists = array(1);
    
    if ($type != 'image') {
      while(count($exists)) {
        if ($this->config->get('mlseo_absolute') && $this->config->get('mlseo_duplicate') && $type == 'category') break;
        elseif ($this->config->get('mlseo_absolute') && $type == 'category')
             $sql = "SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = '".$type."_id=" . (int)$id . "' AND keyword='".$this->db->escape($seo_kw)."'";
        elseif ($this->config->get('mlseo_duplicate'))
             $sql = "SELECT * FROM " . DB_PREFIX . "url_alias WHERE query != '".$type."_id=" . (int)$id . "' AND keyword='".$this->db->escape($seo_kw)."'";
        else $sql = "SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword='".$this->db->escape($seo_kw)."'";
        $exists = $this->db->query($sql)->row;
        if (count($exists)) $seo_kw .= '_';
      }
    }
		
	  // config here the max chars (will cut after the current word) ; 0 = unlimited
		$this->config->set('multilingual_seo_wordlimit', 0);
	    
    if ($this->config->get('mlseo_wordlimit')) {
      $pos = strpos($seo_kw, $whitespace, $this->config->get('mlseo_wordlimit'));
      if ($pos > $this->config->get('mlseo_wordlimit'))
        $seo_kw = substr($seo_kw, 0, $pos);
    }
    
		return $seo_kw;
	}
	
	public function getFullProductPaths($product_id) {
		$path = array();
		$categories = $this->db->query("SELECT c.category_id, c.parent_id FROM " . DB_PREFIX . "product_to_category p2c LEFT JOIN " . DB_PREFIX . "category c ON (p2c.category_id = c.category_id) WHERE product_id = '" . (int)$product_id . "'")->rows;
		
		foreach($categories as $key => $category) {
			$path[$key] = '';
			if (!$category) continue;
			$path[$key] = $category['category_id'];
			
			while ($category['parent_id']) {
				$path[$key] = $category['parent_id'] . '_' . $path[$key];
				$category = $this->db->query("SELECT category_id, parent_id FROM " . DB_PREFIX . "category WHERE category_id = '" . $category['parent_id']. "'")->row;
			}
			
			$path[$key] = $path[$key];
		}
		
		if (!count($path)) return array();
		
		return $path;
	}
	
	public function getLangCode($lang_id) {
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    
    foreach($languages as $language) {
      if ($language['language_id'] == $lang_id) {
        return  $language['code'];
      }
    }
    
    return '';
  }
  
	private function mb_strtr($str, $from, $to = null) {
		if (is_array($from) && is_array($to))
			return str_replace($from, $to, $str);
		elseif (is_array($from))
			return str_replace(array_keys($from), array_values($from), $str);
		return str_replace(preg_split('~~u', $from, null, PREG_SPLIT_NO_EMPTY), preg_split('~~u', $to, null, PREG_SPLIT_NO_EMPTY), $str);
	}
	
}