<?php
class ModelDesignBanner extends Model {
	public function getBanner($banner_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banner_image bi LEFT JOIN " . DB_PREFIX . "banner_image_description bid ON (bi.banner_image_id  = bid.banner_image_id) WHERE bi.banner_id = '" . (int)$banner_id . "' AND bid.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bi.sort_order ASC");


        if ($this->config->get('mlseo_banners')) {
          foreach($query->rows as &$row) {
            if ($row['link'] && strstr($row['link'], 'http') === false) {
              $route = $row['link'];
              
              if ($params = strstr($row['link'], '&')) {
                $route = str_replace(array($params, 'index.php?route='), '', $row['link']);
              } else {
                $params = '';
              }
              
              $row['link'] = $this->url->link($route, str_replace('&amp;', '&', $params));
            }
          }
        }
       
		return $query->rows;
	}
}