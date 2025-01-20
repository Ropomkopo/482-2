<?php
class ModelToolSeoPackage extends Model {
 
  public function hreflang() {
    $this->load->model('localisation/language');
    $langs = $this->model_localisation_language->getLanguages();
    
    // save current language values
    $current_config_lang = $this->config->get('config_language');
    $current_lang_id = $this->config->get('config_language_id');
    $current_lang_code = $this->session->data['language'];
    
    // construct url
    $data = $this->request->get;
    
    unset($data['_route_']);
    unset($data['site_language']);
    unset($data['page'], $data['limit'], $data['order'], $data['sort']);
    
    if (isset($data['route']) && $data['route']) {
      $route = $data['route'];
    } else {
      $route = 'common/home';
    }
    
    unset($data['route']);

    $url = '';

    if (isset($data['path'])) {
      $url .= 'path=' . $data['path'] . '&';
      unset($data['path']);
    }
    
    if ($data) {
      $data = array_reverse($data);
      $url .=  urldecode(http_build_query($data, '', '&'));
    }
    
    $hreflangs = array();
    
    // handle sub-stores rewriting
    if ($this->config->get('mlseo_store_mode')) {
      $lang_to_store = $this->config->get('mlseo_lang_to_store');
    }
    
    // generate hreflangs
    foreach ($langs as $lang) {
      // set language to get each link
      $this->config->set('config_language', $lang['code']);
      $this->config->set('config_language_id', $lang['language_id']);
      $this->session->data['language'] = $lang['code'];
      
      $hreflangs[] = array(
        'href' => !empty($lang_to_store) ? str_replace(array($this->config->get('config_url'), $this->config->get('config_ssl')), $lang_to_store[$lang['code']], $this->url->link($route, $url)) : $this->url->link($route, $url),
        'hreflang' => $lang['code']
      );
      
      // add x-default if homepage
      if ($route == 'common/home' && $this->config->get('mlseo_default_lang') == $lang['code']) {
        $hreflangs[] = array(
          'href' => !empty($lang_to_store) ? str_replace(array($this->config->get('config_url'), $this->config->get('config_ssl')), $lang_to_store[$lang['code']], str_replace('/'.$lang['code'].'/', '/', $this->url->link($route, $url))) : str_replace('/'.$lang['code'].'/', '/', $this->url->link($route, $url)),
          'hreflang' => 'x-default'
        );
      }
      
    }
    
    // restore current language values
    $this->config->set('config_language', $current_config_lang);
    $this->config->set('config_language_id', $current_lang_id);
    $this->session->data['language'] = $current_lang_code;

    return $hreflangs;
  }

  public function richSnippets() {
    $page = !empty($this->request->get['route']) ? $this->request->get['route'] : 'common/home';
    $page = str_replace(array('common/home', 'product/product', 'product/category', 'information/information', 'information/contact'),
                        array('home', 'product', 'category', 'information', 'contact'), $page);
    $metas = '';
    
    switch ($page) {
      case 'home': $types = array('gpublisher', 'microdata', 'opengraph', 'tcard'); break;
      //case 'product': $types = array('microdata', 'opengraph', 'tcard'); break;
      default: $types = array(); break;
    }
    
    foreach ($types as $type) {
      if (!$this->config->get('mlseo_'.$type)) continue;
      
      $metas .= $this->rich_snippet($type, $page);
    }
    
    $this->document->addSeoMeta($metas);
  }
  
  public function rich_snippet($type, $page, $data = array()) {
    $config = $data['config'] = $this->config->get('mlseo_'.$type.'_data');
    
    if ($page == 'home' && $type == 'gpublisher') {
      $data['url'] = $config['url'];
    } else if ($page == 'product') {
      // currency
      if (isset($this->session->data['currency'])) {
        $data['currency'] = $this->session->data['currency'];
      } else {
        $data['currency'] = $this->currency->getCode();
      }
      
      // get unformatted price
      $data['price'] = $this->currency->format($this->tax->calculate($data['product_info']['price'], $data['product_info']['tax_class_id'], $this->config->get('config_tax')),$data['currency'], '', false);
      
      if ($data['special']) {
        $data['special'] = $this->currency->format($this->tax->calculate($data['product_info']['special'], $data['product_info']['tax_class_id'], $this->config->get('config_tax')),$data['currency'], '', false);
      }
      
      // category
      $category = array();
      
      foreach ($data['breadcrumbs'] as $breadcrumb) {
        if (strip_tags($breadcrumb['text'])) {
          $category[] = strip_tags($breadcrumb['text']);
        }
        $data['product_url'] = $breadcrumb['href'];
      }
      
      $data['category'] = implode(' &raquo; ', $category);
      
      // reviews
      $data['reviews'] = array();
      
      if (!empty($config['reviews']) && $type == 'microdata' && !empty($data['product_id'])) {
        $this->load->model('catalog/review');
        $data['reviews'] = $this->model_catalog_review->getReviewsByProductId($data['product_id']);
      }
      
      $data['microdata_desc'] = $this->config->get('mlseo_microdata_desc');
    } else if ($page == 'home') {
      $seo_meta = $this->config->get('mlseo_store');
      if (isset($seo_meta[$this->config->get('config_store_id').$this->config->get('config_language_id')])) {
        $seo_meta = $seo_meta[$this->config->get('config_store_id').$this->config->get('config_language_id')];
      }
      
      $data['url'] = $this->url->link('common/home');
      
      if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
        $data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');
      } else {
        $data['logo'] = '';
      }
      
      if (!empty($seo_meta['seo_title'])) {
        $data['title'] = $seo_meta['seo_title'];
      } else {
        $data['title'] = $this->config->get('config_title');
      }
      
      if (!empty($seo_meta['description'])) {
        $data['desc'] = $seo_meta['description'];
      } else {
        $data['desc'] = $this->config->get('config_meta_description');
      }
    } else if ($page == 'info') {
      if (!empty($this->request->get['information_id'])) {
        $information_id = (int)$this->request->get['information_id'];
      } else {
        $information_id = 0;
      }
      
      $data['url'] = $this->url->link('information/information', 'information_id='.$information_id);
    }
    
    // display
    $data['config_name'] = $this->config->get('config_name');
    $data['type'] = $type;
    $data['page'] = $page;
    
    if ($type == 'microdata') {
      return $this->microdataJson($page, $data);
    }
    
    if (version_compare(VERSION, '2.2', '>=')) {
      $template = new Template('basic');
      foreach ($data as $key => $value) {
        $template->set($key, $value);
      }
      return $template->render('default/template/module/seopackage_rich_snippet.tpl');
    } elseif (method_exists($this->load, 'view')) {
      return $this->load->view('default/template/module/seopackage_rich_snippet.tpl', $data);
    } else {
      $template = new Template();
      $template->data = &$data;
      return $template->fetch('default/template/module/seopackage_rich_snippet.tpl');
    }
  }
  
  public function microdataJson($page, $data) {
    $config = !empty($data['config']) ? $data['config'] : '';
    $output = '';
    
    if (empty($data['url'])) {
      if ($this->request->server['HTTPS']) {
        $data['url'] = $this->config->get('config_ssl');
      } else {
        $data['url'] = $this->config->get('config_url');
      }
    }
    
    if (empty($data['logo'])) {
      $data['logo'] = $data['url'] . 'image/' . $this->config->get('config_logo');
    }
    
    // Breadcrumbs
    if (in_array($page, array('product', 'category', 'manufacturer', 'information', 'contact')) && !empty($config['breadcrumbs'])) {
      $json = array();
      $json['@context'] = 'http://schema.org';
      $json['@type'] = 'BreadcrumbList';
      
      if (!empty($data['breadcrumbs'])) {
        $pos = 1;
        foreach ($data['breadcrumbs'] as $breadcrumb) {
          $json['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => $pos++,
            'item' => array(
              '@id' => urldecode($breadcrumb['href']),
              'name' => strip_tags($breadcrumb['text']) ? strip_tags($breadcrumb['text']) : $data['config_name'],
            ),
          );
        }
      }
      
      $output .= '<script type="application/ld+json">'.json_encode($json).'</script>'."\n";
    }
    
    // Product
    if ($page == 'product' && !empty($config['product'])) {
      $json = array();
      $json['@context'] = 'http://schema.org';
      $json['@type'] = 'Product';
      $json['url'] = $data['product_url'];
      $json['name'] = $data['heading_title'];
      $json['category'] = $data['category'];
      $json['image'] = $data['thumb'];
      
      if (!empty($config['model'])) {
        $json['model'] = $data['model'];
      }
      
      if (!empty($config['desc'])) {
        $json['description'] = strip_tags($data['product_info']['meta_description']);
      }
      
      if (!empty($config['brand'])) {
        $json['manufacturer'] = strip_tags($data['product_info']['manufacturer']);
      }
      
      $json['offers'] = array(
        'name' => $data['heading_title'],
        'category' => $data['category'],
        'price' => $data['special'] ? $data['special'] : $data['price'],
        'priceCurrency' => $data['currency'],
        'itemCondition' => 'http://schema.org/NewCondition',
        'seller' => array(
          '@type' => 'Organization',
          'name' => $data['config_name'],
        ),
      );
      
      if ($data['product_info']['quantity'] > 0) {
        $json['offers']['availability'] = 'http://schema.org/InStock';
      }
      
      if (!empty($config['reviews']) && count($data['reviews'])) {
        $best_rating = $review_total = 0;
        
        foreach ($data['reviews'] as $review) {
          $json['review'][] = array(
            '@type' => 'Review',
            'name' => $data['heading_title'],
            'itemReviewed' => $data['heading_title'],
            'author' => array(
              '@type' => 'Person',
              'name' => $review['author'],
            ),
            'reviewBody' => $review['text'],
            'datePublished' => date('Y-m-d', strtotime($review['date_added'])),
            'reviewRating' => array(
              '@type' => 'Rating',
              'ratingValue' => $review['rating'],
            ),
          );
            
          $review_total += $review['rating'];
          $best_rating = ($review['rating'] > $best_rating) ? $review['rating'] : $best_rating;
        }
        
        $json['aggregateRating'] = array(
          '@type' => 'AggregateRating',
          'ratingValue' => round($review_total / count($data['reviews']), 1),
          'bestRating' => $best_rating,
          'reviewCount' => count($data['reviews']),
        );
      }
      
      $output .= '<script type="application/ld+json">'.json_encode($json).'</script>'."\n";
    }
    
    // Organization
    if (in_array($page, array('home', 'contact')) && !empty($config['organization'])) {
      $json = array();
      $json['@context'] = 'http://schema.org';
      $json['@type'] = 'Organization';
      $json['url'] = $data['url'];
      $json['logo'] = $data['logo'];
      
      if (!empty($config['organization_search'])) {
        $json['potentialAction'][] = array(
          '@type' => 'SearchAction',
          'target' => urldecode($this->url->link('product/search', 'search={search_term_string}')),
          'query-input' => 'required name=search_term_string',
        );
      }
      
      if (!empty($config['contact'])) {
        foreach ($config['contact'] as $contact) {
          if (empty($contact['phone'])) continue;
          
          $json['contactPoint'][] = array(
            '@type' => 'ContactPoint',
            'telephone' => $contact['phone'],
            'contactType' => $contact['type'],
          );
        }
      }
      
      $output .= '<script type="application/ld+json">'.json_encode($json).'</script>'."\n";
    }
    
    // Store
    if (in_array($page, array('home', 'contact')) && !empty($config['store'])) {
      $json = array();
      $json['@context'] = 'http://schema.org';
      $json['@type'] = 'Store';
      $json['url'] = $data['url'];
      $json['name'] = $data['config_name'];
      
      if (!empty($config['store_logo'])) {
        $json['logo'] = $data['logo'];
      }
      
      if (!empty($config['store_mail'])) {
        $json['email'] = $this->config->get('config_email');
      }
      
      if (!empty($config['store_phone'])) {
        $json['telephone'] = $this->config->get('config_telephone');
      }
      
      if (!empty($config['address'])) {
        if (!empty($config['address_street'])) $json['address']['streetAddress'] = $config['address_street'];
        if (!empty($config['address_city'])) $json['address']['addressLocality'] = $config['address_city'];
        if (!empty($config['address_region'])) $json['address']['addressRegion'] = $config['address_region'];
        if (!empty($config['address_code'])) $json['address']['postalCode'] = $config['address_code'];
        if (!empty($config['address_country'])) $json['address']['addressCountry'] = $config['address_country'];
      }
      
      foreach ($config['same_as'] as $same_as) {
        if (empty($same_as)) continue;
        
        $json['sameAs'][] = $same_as;
      }
      
      $output .= '<script type="application/ld+json">'.json_encode($json).'</script>'."\n";
    }
    
    // Website
    if (in_array($page, array('home', 'contact')) && !empty($config['website'])) {
      $json = array();
      $json['@context'] = 'http://schema.org';
      $json['@type'] = 'WebSite';
      $json['url'] = $data['url'];
      
      if (!empty($config['website_search'])) {
        $json['potentialAction'][] = array(
          '@type' => 'SearchAction',
          'target' => urldecode($this->url->link('product/search', 'search={search_term_string}')),
          'query-input' => 'required name=search_term_string',
        );
      }
      
      $output .= '<script type="application/ld+json">'.json_encode($json).'</script>'."\n";
    }
    
    // Place
    if (in_array($page, array('home', 'contact')) && !empty($config['place'])) {
      $json = array();
      $json['@context'] = 'http://schema.org';
      $json['@type'] = 'Place';
      $json['name'] = $data['config_name'];
      
      if (!empty($config['gps_lat']) && !empty($config['gps_long'])) {
        $json['geo'] = array(
          '@type' => 'GeoCoordinates',
          'latitude' => $config['gps_lat'],
          'longitude' => $config['gps_long'],
        );
      }
      
      $output .= '<script type="application/ld+json">'.json_encode($json).'</script>'."\n";
    }
    
    if ($output) {
      $output = "<!-- Microdata -->\n".$output;
    }
    
    return $output;
  }
  
  public function checkCanonical() {
    if (!$this->config->get('mlseo_canonical')) {
      return;
    }
    
    $canonical = false;
    
    foreach ($this->document->getLinks() as $link) {
      if ($link['rel'] == 'canonical') {
        $canonical = true;
      }
    }
    
    if (!$canonical && isset($this->request->get['route'])) {
      list($ctrl) = explode('/', $this->request->get['route']);
      
      if (in_array($ctrl, array('account', 'information', 'affiliate', 'checkout'))) {
        $data = $this->request->get;
        
        unset($data['_route_']);
        
        $route = $data['route'];
        $params = '';
        
        if ($data) {
          $params = urldecode(http_build_query($data, '', '&'));
        }  
        
        $this->document->addLink($this->url->link($route, $params), 'canonical');
      }
    }
  }
}