<?php
class ModelFeedAllYMLExportOcext extends Model {

    protected $registry;

    public function __construct($registry) {
        $this->registry = $registry;
        $this->install();
    }
    
    public function getTemplateSettingNames($descriptions=FALSE) {
        $columns = $this->db->query('SHOW COLUMNS FROM '.DB_PREFIX.'product_description');
        if(!$descriptions){
            $template_setting_names['name'] = 'name';
            if($columns->rows){
                foreach($columns->rows as $column){
                    if($column['Field']=='meta_title'){
                        $template_setting_names['meta_title'] = 'meta_title';
                    }
                }
            }
            $template_setting_names['composite'] = 'composite';
        }else{
            $template_setting_names['description'] = 'description';
            if($columns->rows){
                foreach($columns->rows as $column){
                    if($column['Field']=='meta_title'){
                        $template_setting_names['meta_title'] = 'meta_title';
                    }
                    if($column['Field']=='meta_description'){
                        $template_setting_names['meta_description'] = 'meta_description';
                    }
                    if($column['Field']=='meta_keyword'){
                        $template_setting_names['meta_keyword'] = 'meta_keyword';
                    }
                    $template_setting_names['option_id'] = 'option_id';
                    $template_setting_names['attribute_id'] = 'attribute_id';
                }
            }
        }
        return $template_setting_names;
    }
    
    public function getTemplateSettingNameComposite() {
        $columns_product_description = $this->db->query('SHOW COLUMNS FROM '.DB_PREFIX.'product_description');
        $columns_product = $this->db->query('SHOW COLUMNS FROM '.DB_PREFIX.'product');
        
        $template_setting_name_composite['name'] = 'name';
        if($columns_product_description->rows){
            foreach($columns_product_description->rows as $column){
                if($column['Field']=='meta_title'){
                    $template_setting_name_composite['meta_title'] = 'meta_title';
                }
            }
        }
        $unset_product_fileds = array_flip(array('quantity','stock_status_id','image','shipping','points','tax_class_id','date_available','weight_class_id','length_class_id','subtract','minimum','sort_order','status','viewed','date_added','date_modified'));
        $product_fileds = array();
        if($columns_product->rows){
            foreach($columns_product->rows as $key=>$column){
                if(!isset($unset_product_fileds[$column['Field']])){
                    $product_fileds[$column['Field']] = $column['Field'];
                }
            }
        }
        if(isset($product_fileds['length']) && isset($product_fileds['width']) && isset($product_fileds['height'])){
            unset($product_fileds['length']);
            unset($product_fileds['width']);
            unset($product_fileds['height']);
            $product_fileds['length_width_height'] = 'length_width_height';
        }
        $template_setting_name_composite += $product_fileds;
        $template_setting_name_composite['category_id'] = 'category_id';
        $template_setting_name_composite['option_id'] = 'option_id';
        $template_setting_name_composite['attribute_id'] = 'attribute_id';
        return $template_setting_name_composite;
    }
    
    public function getTemplateSettingFields($template_setting_fields) {
        
        if(isset($template_setting_fields['name'])){
            unset($template_setting_fields['name']);
        }
        if(isset($template_setting_fields['meta_title'])){
            unset($template_setting_fields['meta_title']);
        }
        if(isset($template_setting_fields['length_width_height'])){
            unset($template_setting_fields['length_width_height']);
        }
        
        return $template_setting_fields;
    }
    
    public function getAttributes() {
            $sql = "SELECT *, (SELECT agd.name FROM " . DB_PREFIX . "attribute_group_description agd WHERE agd.attribute_group_id = a.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute_group FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";
            $query = $this->db->query($sql);
            $result = array();
            if($query->rows){
                foreach ($query->rows as $attribute) {
                    $result[$attribute['attribute_group_id']][$attribute['attribute_id']]['name'] = $attribute['name'];
                    $result[$attribute['attribute_group_id']][$attribute['attribute_id']]['attribute_group'] = $attribute['attribute_group'];
                }
            }
            return $result;
    }
    
    public function getStockStatuses(){
        $sql = "SELECT * FROM `" . DB_PREFIX . "stock_status` WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";
        $query = $this->db->query($sql);
        $result = array();
        if($query->rows){
            foreach ($query->rows as $stock_status) {
                $result[$stock_status['stock_status_id']]['stock_status_id'] = $stock_status['stock_status_id'];
                $result[$stock_status['stock_status_id']]['name'] = $stock_status['name'];
            }
        }
        return $result;
    }
    
    public function getOptions() {
        $sql = "SELECT * FROM `" . DB_PREFIX . "option` o LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE od.language_id = '" . (int)$this->config->get('config_language_id') . "'";
        $query = $this->db->query($sql);
        $result = array();
        if($query->rows){
            foreach ($query->rows as $option) {
                $result[$option['option_id']]['option_id'] = $option['option_id'];
                $result[$option['option_id']]['name'] = $option['name'];
            }
        }
        return $result;
    }
    
    public function updateTemplateSetting($data,$template_setting_id) {
        $sql = '';
        if($template_setting_id==0){
            $status = $data['template_setting'][$template_setting_id]['status'];
            if(!$data['template_setting'][$template_setting_id]['title']){
                $this->load->language('feed/all_yml_export_ocext');
                $data['template_setting'][$template_setting_id]['title'] = $this->language->get('text_template_setting_no_title');
            }
            $template_setting = json_encode($data['template_setting'][$template_setting_id]);
            if($status!=2){
                $sql = "INSERT INTO  " . DB_PREFIX . "ocext_all_yml_export_template_setting SET `template_setting` = '".$this->db->escape($template_setting)."', `status` = '".$status."', date_modified = NOW() ";
            }
        }else{
            $status = $data['template_setting'][$template_setting_id]['status'];
            if(!$data['template_setting'][$template_setting_id]['title']){
                $this->load->language('feed/all_yml_export_ocext');
                $data['template_setting'][$template_setting_id]['title'] = $this->language->get('text_template_setting_no_title');
            }
            $template_setting = json_encode($data['template_setting'][$template_setting_id]);
            if($status!=2){
                $sql = "UPDATE " . DB_PREFIX . "ocext_all_yml_export_template_setting SET `template_setting` = '".$this->db->escape($template_setting)."', `status` = '".$status."', date_modified = NOW() WHERE  template_setting_id = '" . (int)$template_setting_id . "' ";
            }else{
                $sql = "DELETE FROM " . DB_PREFIX . "ocext_all_yml_export_template_setting  WHERE  template_setting_id = '" . (int)$template_setting_id . "' ";
            }
        }
        if(!empty($sql)){
            $this->db->query($sql);
        }
    }
    
    public function updateYmCategories($data=array()) {
        $set = array();
        if($data){
            if(isset($data['ym_status']) && $data['ym_status']){
                foreach ($data['ym_status'] as $ym_category_id => $status) {
                    $set = array();
                    $set[] = " `status` = '".(int)$status."' ";
                    
                    if(isset($data['category_id'][$ym_category_id])){
                        $category_id = json_encode($data['category_id'][$ym_category_id]);
                        $set[] = " `category_id` = '".$this->db->escape($category_id)."' ";
                    }else{
                        $category_id = 0;
                        $set[] = " `category_id` = '".$this->db->escape($category_id)."' ";
                    }
                    
                    $sql = "UPDATE " . DB_PREFIX . "ocext_all_yml_export_ym_categories SET ".  implode(', ', $set)." WHERE  ym_category_id = '" . (int)$ym_category_id . "' ";
                    $this->db->query($sql);
                }
            }
        }
    }
    
    public function getTemplateSetting($status=FALSE) {
        $sql = '';
        $result = array();
        if($status){
            
            $sql = "SELECT * FROM `" . DB_PREFIX . "ocext_all_yml_export_template_setting` WHERE status = 1";
            
        }else{
            
            $sql = "SELECT * FROM `" . DB_PREFIX . "ocext_all_yml_export_template_setting`";
            
        }
        if(!empty($sql)){
            $query = $this->db->query($sql);
            if($query->rows){
                foreach ($query->rows as $template_setting) {
                    $result[$template_setting['template_setting_id']] = json_decode($template_setting['template_setting'],TRUE);
                    $result[$template_setting['template_setting_id']]['template_setting_id'] = $template_setting['template_setting_id'];
                }
            }
        }
        return $result;
    }
    
    public function getFilterData($key,$update=FALSE) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "ocext_all_yml_export_filter_data` WHERE `key` = '".$key."' ";
        $query = $this->db->query($sql);
        $result = array();
        if($query->row && !$update){
            $result = json_decode($query->row['filter_data'], true);
        }
        if($update){
            if(isset($query->row['filter_data_id'])){
                return TRUE;
            }else{
                return FALSE;
            }
        }
        return $result;
    }
    
    public function getLastFilterData($key) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = '".$key."' ORDER BY `setting_id` DESC ";
        $query = $this->db->query($sql);
        $result = array();
        if($query->row){
            $result = json_decode($query->row['value'], true);
        }
        return $result;
    }
    
    public function setFilterData($key,$value) {
        $update_data = $this->getFilterData($key,TRUE);
        if(!$update_data){
            $sql = "INSERT INTO `" . DB_PREFIX . "ocext_all_yml_export_filter_data` SET `filter_data` = '".$this->db->escape(json_encode($value))."', `key` = '".$key."' ";
        }else{
            $sql = "UPDATE `" . DB_PREFIX . "ocext_all_yml_export_filter_data` SET `filter_data` = '".$this->db->escape(json_encode($value))."' WHERE `key` = '".$key."' ";
        }
        $this->db->query($sql);
        return;
    }
    
    public function getYmCategoriesFromDb($data) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "ocext_all_yml_export_ym_categories` ";
        $where = array();
        if ($data['category_id']==1) {
            $where[] = " category_id != '0' ";
        }
        
        if (!empty($data['ym_category_last_child'])) {
            $where[] = " ym_category_last_child LIKE '" . $this->db->escape($data['ym_category_last_child']) . "%' ";
        }
        
        if ($data['status']!='') {
            $where[] = " status = '" . (int)$data['status'] . "' ";
        }
        
        if($where){
            $where = ' WHERE '.implode(' AND ', $where);
        }else{
            $where = '';
        }
        
        $sql .= $where;
        
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                    $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                    $data['limit'] = 20;
            }
            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }
    
    public function getYmCategoriesFromDbTotal($data) {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "ocext_all_yml_export_ym_categories` ";
        $where = array();
        if ($data['category_id']==1) {
            $where[] = " category_id != '' AND category_id != 0 AND category_id != '0' ";
        }
        
        if (!empty($data['ym_category_last_child'])) {
            $where[] = " ym_category_last_child LIKE '" . $this->db->escape($data['ym_category_last_child']) . "%' ";
        }
        
        if ($data['status']!='') {
            $where[] = " status = '" . (int)$data['status'] . "' ";
        }
        
        if($where){
            $where = ' WHERE '.implode(' AND ', $where);
        }else{
            $where = '';
        }
        
        $sql .= $where;
        //var_dump($sql);
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function install() {
        $tables[] = 'ocext_all_yml_export_ym_categories';
        $tables[] = 'ocext_all_yml_export_template_setting';
        $tables[] = 'ocext_all_yml_export_filter_data';
        
        foreach ($tables as $table) {
            $check = $query = $this->db->query('SHOW TABLES from `'.DB_DATABASE.'` like "'.DB_PREFIX.$table.'" ');
            if(!$check->num_rows){
                $this->creatTables($table);
            }
        } 
        
        $result = FALSE;
        if(is_string($table)){
            $check = $query = $this->db->query('SHOW TABLES from `'.DB_DATABASE.'` like "'.DB_PREFIX.$table.'" ');
            if($check->num_rows){
                $result = TRUE;
            }
        }elseif (is_array($table)) {
            $result = TRUE;
            foreach ($table as $t) {
                $check = $query = $this->db->query('SHOW TABLES from `'.DB_DATABASE.'` like "'.DB_PREFIX.$t.'" ');
                if(!$check->num_rows){
                    $result = FALSE;
                }
            }
        }
        return $result;
    }
    
    private function creatTables($table) {
        if($table=='ocext_all_yml_export_ym_categories'){
            $this->db->query(
                "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "ocext_all_yml_export_ym_categories (
                  `ym_category_id` int(11) NOT NULL AUTO_INCREMENT,
                  `category_id` text NOT NULL,
                  `ym_category_path` text NOT NULL,
                  `ym_category_last_child` text NOT NULL,
                  `status` int(11) NOT NULL,
                  PRIMARY KEY (`ym_category_id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;"
            );
            $file_and_path = DIR_APPLICATION.'/model/feed/all_yml_export_ocext-utf8.csv';
            $ym_categories = $this->getYMCategories($file_and_path);
            if($ym_categories){
                foreach ($ym_categories as $ym_category) {
                    $this->db->query("INSERT INTO  " . DB_PREFIX .$table. " SET `ym_category_path`='".$ym_category['ym_category_path']."', `ym_category_last_child`='".$ym_category['ym_category_last_child']."' ");
                }
            }
        }
        if($table=='ocext_all_yml_export_template_setting'){
            $this->db->query(
                "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "ocext_all_yml_export_template_setting (
                  `template_setting_id` int(11) NOT NULL AUTO_INCREMENT,
                  `template_setting` text NOT NULL,
                  `status` int(11) NOT NULL,
                  `date_modified` datetime NOT NULL,
                  PRIMARY KEY (`template_setting_id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;"
            );
        }
        if($table=='ocext_all_yml_export_filter_data'){
            $this->db->query(
                "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "ocext_all_yml_export_filter_data (
                  `filter_data_id` int(11) NOT NULL AUTO_INCREMENT,
                  `key` text NOT NULL,
                  `filter_data` longtext NOT NULL,
                  PRIMARY KEY (`filter_data_id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;"
            );
        }
    }
    
    private function getYMCategories($file_and_path='', $delimiter=',',$onlyCountRow=FALSE){
        if(!file_exists($file_and_path) || !is_readable($file_and_path)){
            return FALSE;
        }
        $header = NULL;
        $data = array();
        if (($handle = fopen($file_and_path, 'r')) !== FALSE){   
            while ( ($row = $this->fgetcsv_club($handle, 1000000, $delimiter)) !== FALSE){
                $row = $row[0];
                $childs = explode(' / ', $row);
                if($childs){
                    $ym_category_last_child = end($childs);
                }else{
                    $ym_category_last_child = $row;
                }
                $data[] = array('ym_category_path'=>trim($row),'ym_category_last_child'=>trim($ym_category_last_child));
            }
            fclose($handle);
        }
        if($onlyCountRow){
            return count($data);
        }
        return $data;
    }
    
    private function fgetcsv_club($f_handle, $length, $delimiter=',', $enclosure='"'){
        if (!strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            return fgetcsv($f_handle, $length, $delimiter, $enclosure);
        if (!$f_handle || feof($f_handle))
            return false;

        if (strlen($delimiter) > 1)
            $delimiter = substr($delimiter, 0, 1);
        elseif (!strlen($delimiter))          
            return false;

        if (strlen($enclosure) > 1)         
            $enclosure = substr($enclosure, 0, 1);

        $line = fgets($f_handle, $length);
        if (!$line)
            return false;
        $result = array();
        $csv_fields = explode($delimiter, trim($line));
        $csv_field_count = count($csv_fields);
        $encl_len = strlen($enclosure);
        for ($i=0; $i<$csv_field_count; $i++)
        {

            if (isset($csv_fields[$i]{0}) && $encl_len && $csv_fields[$i]{0} == $enclosure)
                $csv_fields[$i] = substr($csv_fields[$i], 1);
            if (isset($csv_fields[$i]{strlen($csv_fields[$i])-1}) && $encl_len && $csv_fields[$i]{strlen($csv_fields[$i])-1} == $enclosure)
                $csv_fields[$i] = substr($csv_fields[$i], 0, strlen($csv_fields[$i])-1);

            $csv_fields[$i] = str_replace($enclosure.$enclosure, $enclosure, $csv_fields[$i]);
            $result[] = $csv_fields[$i];
        }
        return $result;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //////////////////////////////////////////////////////////////////////////////////
        
    public function getOrders($content_new=array()){
        $content =array(
            'Test' => '', // для тестового режима, иначе не указывайте
            'CustomerOrder' => '',                 // номер заказа
            'BarCode' => '',          // штрих код
            'DeliveryDateStart' => '',   // с указанной даты и позднее
            'DeliveryDateEnd' => '',     // до указанной даты
            'State' => '',                           // из справочника
            'OrderStatus' => '',                    // из справочника
            'Job' => 'С24КО', // из справочника услуг
            'RegionFrom' => '',              // из справочника регионов
            'RegionTo' => '',                // из справочника регионов
            'CreationDateStart' => '', // с указанной даты и позднее
            'CreationDateEnd' => ''      // до указанной даты
        );
        foreach ($content_new as $key => $value) {
            if( $key && $value && isset($content[$key]) ){
                $content[ $key ] = $value;
            }
        }
        if($this->config->get('iml_test_mode')){
            $content[ 'Test' ] = 'True';
        }
        $curl = curl_init($this->iml_host.'Json/GetOrders');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($content));
        curl_setopt($curl, CURLOPT_USERPWD, $this->login.":".$this->password);
        curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        $result = json_decode($response, true); // результат запроса
        $fin['all'] = array();
        if($result){
            foreach ($result as $key => $value) {
                /*
                if(isset($fin['all'][$value['CustomerOrder']])){
                    $fin['all'][$value['CustomerOrder']]['dublicate'] += $fin['all'][$value['CustomerOrder']]['dublicate']; 
                }else{
                    $fin['all'][$value['CustomerOrder']] = $value;
                    $fin['all'][$value['CustomerOrder']]['dublicate'] = 1;
                }
                 * 
                 */
                $fin['all'][$value['CustomerOrder']] = $value;
            }
        }
        unset($key);unset($value);
        if(isset($content_new['TextInOrder']) && $content_new['TextInOrder'] && $result){
            $find = mb_strtolower($content_new['TextInOrder'],'utf-8');
            foreach ($result as $key => $value) {
                $unset = TRUE;
                foreach ($value as $field) {
                    if(is_string($field)){
                        $field = mb_strtolower($field,'utf-8');
                        if(substr_count($field, $find)){
                            $unset = FALSE;
                        }
                    }
                }
                if($unset){
                    unset($result[$key]);
                }
            }
        }
        unset($key);unset($value);
        if($result){
            foreach ($result as $key => $value) {
                $result[$key]['field_for_sort'] = $this->addSortField(array('00',':',' '), array('','',''), $value['DeliveryDate'],TRUE);
            }
            usort($result, array('ModelModuleIml','cmp_obj'));
            $res = $result;
            $result = array();
            foreach ($res as $key => $value) {
                $result[] = $value;
            }
        }
        $fin['filtr'] = $result;
        return $fin;
    }
    
    function cmp_obj($a, $b){
        /*
         * 
        if ($a["sales_limitation"] == $b["sales_limitation"]) {
        return 0;
        }
         * 
         */
        return strcmp($b["field_for_sort"],$a["field_for_sort"]);
        //return ($a["sales_limitation"] < $b["sales_limitation"]) ? -1 : 1;
    }
    
    private function addSortField($find,$replace,$string,$date = FALSE){
        $result = str_replace($find, $replace, $string);
        if($date){
            $result = strtotime($result);
        }
        return $result;
    }

        public function getDeliveryStatusesList(){
        $curl = curl_init($this->iml_host.'list/deliverystatus');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERPWD, $this->login.":".$this->password);
        curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        if($result && is_array($result)){
            foreach ($result as $el){
                if(isset($el['Code']) && isset($el['Description'])){
                    $result[$el['Code']] = $el['Description'];
                }
            }
        }
        return $result;
    }
    
    public function getServicesList(){
        $curl = curl_init($this->iml_host.'list/service');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERPWD, $this->login.":".$this->password);
        curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        if($result && is_array($result)){
            $result2 = $result;
            $result = array();
            foreach ($result2 as $el){
                if(isset($el['Description']) && is_array($el)){
                    $result[$el['Code']] = $el;
                }
            }
        }
        return $result;
    }
    
    public function getOrderStatusesList(){
        $curl = curl_init($this->iml_host.'list/orderstatus');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERPWD, $this->login.":".$this->password);
        curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        if($result && is_array($result)){
            foreach ($result as $el){
                if(isset($el['Code']) && isset($el['Description'])){
                    $result[$el['Code']] = $el['Description'];
                }
            }
        }
        return $result;
    }
    
    public function sengImlOrderForm($content){
        if($this->config->get('iml_test_mode')){
            $content[ 'Test' ] = 'True';
        }
        $curl = curl_init($this->iml_host.'Json/CreateOrder');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($content));
        curl_setopt($curl, CURLOPT_USERPWD, $this->login.":".$this->password);
        curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        return $result;
    }

    public function getDeliveryPointsList(){
        $curl = curl_init($this->iml_host.'list/sd');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERPWD, $this->login.":".$this->password);
        curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        $deliveryPoints = array();
        if($result && is_array($result)){
            $time = time();
            foreach ($result as $el){
                if(isset($el['RegionCode']) && $time>$this->getTimeStampDateDeliveryPoints($el['OpeningDate']) && $time>$this->getTimeStampDateDeliveryPoints($el['ClosingDate']) ){
                    $deliveryPoints[ $el['RegionCode'] ][ $el['RequestCode'] ] = $el;
                }
            }
        }
        return $deliveryPoints;
    }
    //$date 2016-12-31T21:00:00
    private function getTimeStampDateDeliveryPoints($date){
        $date_array = explode('T', $date);
        $result = 0;
        if(isset($date_array[0])){
            $date_parts = explode('-', $date_array[0]);
            if(isset($date_parts[2])){
                $result = mktime(0, 0, 0, $date_parts[1], $date_parts[2], $date_parts[0]);
            }
        }
        return $result;
    }
}
?>