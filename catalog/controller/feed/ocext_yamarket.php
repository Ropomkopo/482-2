<?php
class ControllerFeedOCextYaMarket extends Controller {
	private $shop = array();
	private $currencies = array();
	private $categories = array();
	private $offers = array();
        private $prices = array();
        private $delivery_option = array();
	private $eol = "\n";
        private $debug = 0;

        public function index() {
                if (!$this->config->get('ayeogs_status')) {
                    return;
                }
                if(!$this->config->get('ayeogs_path_token_export')
                        || !isset($this->request->get['token'])
                        || (isset($this->request->get['token']) && $this->request->get['token']!=$this->config->get('ayeogs_path_token_export'))){
                    exit('Ошибка создания файла. Неверный токен. Укажите код в Главных настройках модуля, нажмите Сохранить. Скопируйте ссылку и попробуйте снова<br>Error creating file. Invalid token. Enter the code in the Main module settings, click Save. Copy the link and try again');
                }
                //создаем список категорий
                $categories_end_offers = $this->getCategoriesAndOffers();
                if(!$categories_end_offers){
                    exit('Ошибка создания файла. Невозможно создать файл без категорий и / или продуктов. Категории и продукты - обязательные атрибуты YML. Проверьте настройки модуля. Возможно для экспорта выделены категории и производители, у которых не продуктов<br>Failed to create file. Unable to create a file with no categories and / or products. Categories and Products - required YML attributes. Check the module configuration. Perhaps for exports marked categories and manufacturers, whose products are not');
                }
                
                foreach ($categories_end_offers['categories'] as $category) {
                    $this->setCategoryAttrubite($category['name'], $category['category_id'], $category['parent_id']);
                }
                
                $this->load->model('feed/ocext_yamarket');
                $templates_setting = $this->model_feed_ocext_yamarket->getTemplateSetting(TRUE);
                
                $this->delivery_option = $this->getShopDeliveryOptionAttrubite($categories_end_offers['offers'],$templates_setting);
                
                $this->setShopAttributes('name', $this->config->get('ayeogs_name'));
                $this->setShopAttributes('company', $this->config->get('ayeogs_company'));
                $this->setShopAttributes('url', HTTP_SERVER);
                if($this->config->get('ayeogs_platform')){
                    $this->setShopAttributes('platform', $this->config->get('ayeogs_platform'));
                }
                if($this->config->get('ayeogs_version')){
                    $this->setShopAttributes('version', $this->config->get('ayeogs_version'));
                }
                
                $currencies = $this->setCurrencyAttributes($this->config->get('ayeogs_currencies'));
                if(!$currencies){
                    exit('Ошибка создания файла. Не указана валюта - обязательный параметр<br>Error creating file. the currency is not specified - required');
                }
                
                $composite_types = $this->getTemplateSettingNameComposite();
                
                foreach ($categories_end_offers['offers'] as $product) {
                    $this->getOfferAttrubite($product,$composite_types,$templates_setting);
                }
                
                if(!$this->debug){
                    $this->response->addHeader('Content-Type: application/xml');
                    $this->response->setOutput($this->getYml());
                }
	}
        
        public function getShopDeliveryOptionAttrubite($products,$templates_setting) {
            
            $data = array();
            if($products){
                foreach ($products as $product) {
                    $template_setting = array();
                    if(isset($product['template_setting_id']) && $product['template_setting_id']){
                        foreach ($product['template_setting_id'] as $template_setting_id) {
                            if(isset($templates_setting[$template_setting_id])){
                                $template_setting += $templates_setting[$template_setting_id];
                            }
                        }
                    }
                    if(isset($template_setting['delivery-options']['status']) && $template_setting['delivery-options']['status']){
                        $delivery_options = $this->getDeliveryOption($template_setting);
                        if($delivery_options){
                            $data['delivery-options'] = $delivery_options;
                        }
                    }
                }
            }
            return $data;
            
        }
        
        public function getOfferAttrubite($product,$composite_types,$templates_setting) {
            $data = array();
            
            
            $template_setting = array();
            if(isset($product['template_setting_id']) && $product['template_setting_id']){
                foreach ($product['template_setting_id'] as $template_setting_id) {
                    if(isset($templates_setting[$template_setting_id])){
                        $template_setting += $templates_setting[$template_setting_id];
                    }
                }
            }
            $data['id'] = $product['product_id'];
            
            $data['url'] = $this->url->link('product/product', 'path='.$this->getPathWhisCategories($product['category_id']).'&product_id='.$product['product_id']);
            //цены
            
            $product['price'] = $this->getPrice($product['price'],$product,$template_setting);
            if($product['special_price']>0){
                $product['special_price'] = $this->getPrice($product['special_price'],$product,$template_setting);
            }
            if($product['discount_special_price']>0){
                $product['discount_special_price'] = $this->getPrice($product['discount_special_price'],$product,$template_setting);
            }
            
            $data['price'] = round($product['price'],2);
            if(isset($template_setting['oldprice']) && ($product['special_price'] || $product['discount_special_price']) > 0){
                if($product['special_price']>0 && $product['special_price'] < $product['price'] ){
                    $data['price'] = $product['special_price'];
                    $data['oldprice'] = $product['price'];
                }elseif( $product['discount_special_price']>0 && $product['discount_special_price'] < $product['price']  ){
                    $data['price'] = $product['discount_special_price'];
                    $data['oldprice'] = $product['price'];
                }else{
                    $data['price'] = $product['price'];
                }
            }
            if(!$data['price'] || $data['price']==0.0){
                return;
            }else{
                //используется для составных заголовков
                $this->prices[$product['product_id']] = $data['price'];
            }
            //валюта
            $data['currencyId'] = $this->currencies[0]['id'];
            //категория
            $data['categoryId'] = $product['category_id'];
            
            if(isset($product['market_category']) && $product['market_category']){
                //категория market_category
                $data['market_category'] = $product['market_category'];
            }
            
            //изображения
            $data['picture'] = $this->getPictureAttributes($product,$template_setting);
            //var_dump($data['picture']);exit();
            //если без картинок не выгружать, и картинок нет, то это предложение не делаем
            if(isset($template_setting['no_pictures']) && !$template_setting['no_pictures'] && !$data['picture']){
                return;
            }
            if(isset($template_setting['store']) && $template_setting['store']){
                $data['store'] = 'true';
            }else{
                $data['store'] = 'false';
            }
            //
            if(isset($template_setting['pickup']) && $template_setting['pickup']){
                $data['pickup'] = 'true';
            }else{
                $data['pickup'] = 'false';
            }
            
            
            
            //
            if(isset($template_setting['delivery']) && $template_setting['delivery']){
                $data['delivery'] = 'true';
            }else{
                $data['delivery'] = 'false';
            }
            
            if(isset($product['template_setting_id']) && count($product['template_setting_id'])==1 && isset($product['template_setting_id'][0][0])){
                
                $data['delivery'] = 'true';
                
            }
            //delivery-options
            if(isset($template_setting['delivery-options']['status']) && $template_setting['delivery-options']['status']){
                $delivery_options = $this->getDeliveryOption($template_setting);
                if($delivery_options){
                    $data['delivery-options'] = $delivery_options;
                }
            }
            
            //название товара
            $data['name'] = $this->getNameAttribute($product,$template_setting,$composite_types);
            
            //вендор
            if(isset($template_setting['vendor']['field']['status']))
            $data['vendor'] = $this->getNameAttributeForType($product,$template_setting,$template_setting['vendor']['field']['status'],'vendor');
            if(isset($template_setting['vendorCode']['field']['status']))
            $data['vendorCode'] = $this->getNameAttributeForType($product,$template_setting,$template_setting['vendorCode']['field']['status'],'vendorCode');
            //если вендор модель, выход без вендора
            if(isset($template_setting['vendor.model']) && $template_setting['vendor.model'] && !$data['vendor']){
                //return;
                $data['type'] = 'vendor.model';
            }elseif(isset ($template_setting['vendor.model']) && $template_setting['vendor.model']){
                $data['type'] = 'vendor.model';
            }
            
            //описание
            if(isset($template_setting['offer_description']['field'])){
                $data['description'] = $this->getDescriptionAttribute($product, $template_setting);
            }else{
                $data['description'] = $this->prepareField($product['description']);
            }
            //sales_notes
            if(isset($template_setting['sales_notes']))
            $data['sales_notes'] = $this->prepareField($template_setting['sales_notes']);
            
            //manufacturer_warranty
            if(isset($template_setting['manufacturer_warranty']) && $template_setting['manufacturer_warranty']){
                $data['manufacturer_warranty'] = 'true';
            }
            
            //country_of_origin
            if(isset($template_setting['country_of_origin']))
            $data['country_of_origin'] = $this->getNameAttributeForType($product,$template_setting,$template_setting['country_of_origin']['field']['status'],'country_of_origin');
            
            //barcode
            if(isset($template_setting['barcode']))
            $data['barcode'] = $this->getNameAttributeForType($product,$template_setting,$template_setting['barcode']['field']['status'],'barcode');
            
            //expiry
            if(isset($template_setting['expiry']))
            $data['expiry'] = $this->getNameAttributeForType($product,$template_setting,$template_setting['expiry']['field']['status'],'expiry');
            
            //weight
            if(isset($template_setting['weight']))
            $data['weight'] = $this->getNameAttributeForType($product,$template_setting,$template_setting['weight']['field']['status'],'weight');
            
            //weight
            if(isset($template_setting['dimensions']))
            $data['dimensions'] = $this->getNameAttributeForType($product,$template_setting,$template_setting['dimensions']['field']['status'],'dimensions');
            
            //age
            if(isset($template_setting['age']['field']['status']) && $template_setting['age']['field']['status']){
                if($template_setting['age']['unit']){
                    $data['age']['value'] = $this->getNameAttributeForType($product,$template_setting,$template_setting['age']['field']['status'],'age');
                    $data['age']['unit'] = $template_setting['age']['unit'];
                }
            }
            
            //typePrefix
            if(isset($template_setting['typePrefix']) && $template_setting['typePrefix'])
            $data['typePrefix'] = $this->getNameAttributeForType($product,$template_setting,$template_setting['typePrefix']['field']['status'],'typePrefix');
        
            
            //cpa
            if(isset($template_setting['cpa']) && $template_setting['cpa']){
                $data['cpa'] = '1';
            }
            
            //rec
            if(isset($template_setting['rec']) && $template_setting['rec'] && $product['rec']){
                $data['rec'] = implode(',', $product['rec']);
            }
            
            //adult
            if(isset($template_setting['adult']) && $template_setting['adult']){
                $data['adult'] = 'true';
            }
            //available
            $stock_status_id = $product['stock_status_id'];
            $quantity = (int)$product['quantity'];
            $minimum = (int)$product['minimum'];
            $data['available'] = 'false';
            if(!$quantity || $quantity<$minimum){
                $data['available'] = 'false';
            }elseif($quantity || $quantity>=$minimum){
                $data['available'] = 'true';
            }elseif(isset ($template_setting['available_true']) && $template_setting['available_true']==$stock_status_id){
                $data['available'] = 'true';
            }elseif(isset ($template_setting['available_false'][$stock_status_id])){
                $data['available'] = 'false';
            }
            if(isset($template_setting['model'])){
                $data['model'] = $this->getNameAttributeForType($product,$template_setting,$template_setting['model']['field']['status'],'model');
            }
            
            if(isset($template_setting['dispublic']) && $template_setting['dispublic'] && ( !$quantity || $quantity<$minimum ) ){
                return;
            }
            
            //param
            $param_atributes = array();
            if($product['ym_attributes']){
                $param_atributes = $this->getParamAttribute($product['ym_attributes'],$template_setting);
            }
            $param_options = array();
            if($product['ym_options']){
                $param_options = $this->getParamOption($product['ym_options']);
            }
            if($param_options || $param_atributes){
                $data['param'] = array_merge($param_options,$param_atributes);
            }
            $this->setOffer($data);
            return;
        }
        
        public function getParamOption($ym_options) {
            $result = array();
            foreach ($ym_options as $key => $value) {
                $name = $this->prepareField($value['name']);
                $value['unit'] = $this->prepareField($value['unit']);
                $unit = '';
                if($value['unit']){
                    $unit = $value['unit'];
                }
                if(isset($value['product_option_value']) && $value['product_option_value']){
                    foreach ($value['product_option_value'] as $key => $product_option_value) {
                        if(!$unit){
                            $result[] = array('name'=>  $name,'value'=>  $this->prepareField($product_option_value['name']));
                        }else{
                            $result[] = array('name'=>  $name,'value'=>  $this->prepareField($product_option_value['name']),'unit'=>$unit);
                        }
                    }
                }
            }
            return $result;
        }
        
        public function getParamAttribute($ym_attributes,$template_setting=array()) {
            $result = array();
            foreach ($ym_attributes as $key => $value) {
                $value['unit'] = $this->prepareField($value['unit']);
                $unit = '';
                if($value['unit']){
                    $unit = $value['unit'];
                }
                if(isset($value['attribute']) && $value['attribute']){
                    foreach ($value['attribute'] as $key => $attribute) {
                        
                        
                         if(isset($template_setting['attribute_sintaxis']) && $template_setting['attribute_sintaxis']){
                    
                            $name_attribute = $this->prepareField($attribute['name']);
                            $value_attribute = $this->prepareField($attribute['text']);

                        }else{

                            $name_attribute = $this->prepareField($value['name']);
                            $value_attribute = $this->prepareField($attribute['name'].' '.$attribute['text']);

                        }
                        
                        
                        if(!$unit){
                            $result[] = array('name'=>  $name_attribute,'value'=>  $value_attribute);
                        }else{
                            $result[] = array('name'=>  $name_attribute,'value'=>  $value_attribute,'unit'=>$unit);
                        }
                    }
                }
            }
            return $result;
        }
        
        public function getNameAttributeForType($product,$template_setting,$composite_types,$field_name) {
            $result = '';
            switch ($composite_types){
                case 'attribute_id':
                    $attributes_parts = explode('___', $template_setting[$field_name]['field'][$composite_types]);
                    $attribute_group_id = $attributes_parts[0];
                    $attribute_id = $attributes_parts[1];
                    if($product['all_attributes']){
                        foreach ($product['all_attributes'] as $group_attributes) {
                            if($group_attributes['attribute_group_id'] == $attribute_group_id && $group_attributes['attribute']){
                                foreach ($group_attributes['attribute'] as $attribute_group_value) {
                                    if($attribute_group_value['attribute_id']==$attribute_id){
                                        $result = trim($this->prepareField($attribute_group_value['text']));
                                    }
                                }

                            }
                        }
                    }
                    break;
                case 'option_id':
                    $option_id = $template_setting[$field_name]['field'][$composite_types];
                    if($product['all_options']){
                        foreach ($product['all_options'] as $option) {
                            if($option['option_id'] == $option_id){

                                $name_option = trim($this->prepareField($option['name']));
                                $name_option_vields = array();
                                foreach ($option['product_option_value'] as $product_option_value) {
                                    $name_option_vields[] = trim($this->prepareField($product_option_value['name']));
                                }
                                $result = implode(' ', $name_option_vields);
                            }
                        }
                    }
                    break;
                case 'manufacturer_id':
                    $product['manufacturer'] = $this->prepareField($product['manufacturer']);
                    if($product['manufacturer']){
                        $result = $product['manufacturer'];
                    }
                    break;

                case 'price':
                    $result = $this->prices[$product['product_id']];
                    break;

                case 'weight':
                    if((float)$product['weight']>0){
                        $result = (float)$this->weight->format($product['weight'],$product['weight_class_id']);
                    }
                    break;

                case 'length_width_height':
                    $length_width_height = array();
                    if((float)$product['length']>0){
                        $length_width_height[] = (float)$this->length->format($product['length'],$product['length_class_id']);
                    }
                    if((float)$product['width']>0){
                        $length_width_height[] = (float)$this->length->format($product['width'],$product['length_class_id']);
                    }
                    if((float)$product['height']>0){
                        $length_width_height[] = (float)$this->length->format($product['height'],$product['length_class_id']);
                    }
                    if($length_width_height){
                        $result = implode('/', $length_width_height);
                    }
                    break;
                case 'category_id':
                    $result = $this->categories[$product['category_id']]['name'];
                    break;
                default:
                if(isset($product[$composite_types])){
                    $product[$composite_types] = $this->prepareField($product[$composite_types]);
                    if($product[$composite_types]){
                        $result = $product[$composite_types];
                    }
                }
                break;
            }
            return $result;
        }

        public function getDescriptionAttribute($product,$template_setting){
            
            if(!isset($template_setting['offer_description']['field']) || !$template_setting['offer_description']['field']){
                $description = $this->prepareField($product['description']);
                return $description;
            }
            else{
                
                $key = $template_setting['offer_description']['field'];
                switch ($key){
                    case 'option_id':
                    $description = '';
                    $option = $this->getParamOption($product['ym_options']);
                    if($option){
                        foreach ($option as $value) {
                            $description .= ' '.implode(' ', $value);
                        }
                    }
                    break;

                    case 'attribute_id':
                    $description = '';
                    $attributes = $this->getParamAttribute($product['ym_attributes']);
                    if($attributes){
                        foreach ($attributes as $value) {
                            $description .= ' '.implode(' ', $value);
                        }
                    }
                    break;

                    case 'meta_title':
                        if(isset($product['meta_title']))
                        $description = $this->prepareField($product['meta_title']);
                    break;
                
                    case 'meta_keyword':
                        if(isset($product['meta_keyword']))
                        $description = $this->prepareField($product['meta_keyword']);
                    break;

                    case 'meta_description':
                        if(isset($product['meta_description']))
                        $description = $this->prepareField($product['meta_description']);
                    break;
                    
                    case 'description':
                        if(isset($product['description']))
                        $description = $this->prepareField($product['description']);
                    break;
                    
                    default:
                        $description = '';
                    break;
                }
                return $description;
            }
            
            $result = $this->prepareField($product['name']);
            if(isset($template_setting['offer_name']['field']) && $template_setting['offer_name']['field']=='name'){
                return $result;
            }
            if(isset($template_setting['offer_name']['field']) && $template_setting['offer_name']['field']=='meta_title' && isset($product['meta_title'])){
                $result = $this->prepareField($product['meta_title']);
                return $result;
            }
            if(isset($template_setting['offer_name']['field']) && $template_setting['offer_name']['field']=='composite' && $template_setting['offer_name']['composite']){
                ksort($template_setting['offer_name']['composite']);
                $name = array();
                foreach ($template_setting['offer_name']['composite'] as $composite) {
                    //атрибут
                    if($composite['status']=='attribute_id'){
                        $attributes_parts = explode('___', $composite['attribute_id']);
                        $attribute_group_id = $attributes_parts[0];
                        $attribute_id = $attributes_parts[1];
                        if($product['all_attributes']){
                            foreach ($product['all_attributes'] as $group_attributes) {
                                if($group_attributes['attribute_group_id'] == $attribute_group_id && $group_attributes['attribute']){
                                    foreach ($group_attributes['attribute'] as $attribute_group_value) {
                                        if($attribute_group_value['attribute_id']==$attribute_id){
                                            $name[] = trim($this->prepareField($attribute_group_value['name'])).': '.trim($this->prepareField($attribute_group_value['text']));
                                        }
                                    }
                                    
                                }
                            }
                        }
                    }
                    //опция
                    elseif($composite['status']=='option_id'){
                        $option_id = $composite['option_id'];
                        if($product['all_options']){
                            foreach ($product['all_options'] as $option) {
                                if($option['option_id'] == $option_id){
                                    
                                    $name_option = trim($this->prepareField($option['name']));
                                    $name_option_vields = array();
                                    foreach ($option['product_option_value'] as $product_option_value) {
                                        $name_option_vields[] = trim($this->prepareField($product_option_value['name']));
                                    }
                                    if($name_option_vields){
                                        $name[] = $name_option.': '.  implode(', ', $name_option_vields);
                                    }else{
                                        $name[] = $name_option;
                                    }
                                }
                            }
                        }
                    }
                    //цена
                    elseif($composite['status']=='price'){
                        $name[] = $this->prices[$product['product_id']];
                    }
                    //вес
                    elseif($composite['status']=='weight'){
                        if((float)$product['weight']>0){
                            $name[] = $this->weight->format($product['weight'],$product['weight_class_id']);
                        }
                    }
                    //производитель
                    elseif($composite['status']=='manufacturer_id'){
                        $product['manufacturer'] = $this->prepareField($product['manufacturer']);
                        if($product['manufacturer']){
                            $name[] = $product['manufacturer'];
                        }
                    }
                    //категория
                    elseif($composite['status']=='category_id'){
                        $name[] = $this->categories[$product['category_id']]['name'];
                    }
                    //габариты
                    elseif($composite['status']=='length_width_height'){
                        $length_width_height = array();
                        if((float)$product['length']>0){
                            $length_width_height[] = $this->length->format($product['length'],$product['length_class_id']);
                        }
                        if((float)$product['width']>0){
                            $length_width_height[] = $this->length->format($product['width'],$product['length_class_id']);
                        }
                        if((float)$product['height']>0){
                            $length_width_height[] = $this->length->format($product['height'],$product['length_class_id']);
                        }
                        if($length_width_height){
                            $name[] = implode('/', $length_width_height);
                        }
                    }
                    //остальные
                    elseif (isset ($product[$composite['status']])) {
                        $product[$composite['status']] = $this->prepareField($product[$composite['status']]);
                        if($product[$composite['status']]){
                            $name[] = $product[$composite['status']];
                        }
                    }
                }
                $result = trim($this->prepareField(implode(' ', $name)));
                return $result;
            }
        }
        
        public function getNameAttribute($product,$template_setting,$composite_types){
            $result = $this->prepareField($product['name']);
            if(isset($template_setting['offer_name']['field']) && $template_setting['offer_name']['field']=='name'){
                return $result;
            }
            if(isset($template_setting['offer_name']['field']) && $template_setting['offer_name']['field']=='meta_title' && isset($product['meta_title'])){
                $result = $this->prepareField($product['meta_title']);
                return $result;
            }
            if(isset($template_setting['offer_name']['field']) && $template_setting['offer_name']['field']=='composite' && $template_setting['offer_name']['composite']){
                ksort($template_setting['offer_name']['composite']);
                $name = array();
                foreach ($template_setting['offer_name']['composite'] as $composite) {
                    //атрибут
                    if($composite['status']=='attribute_id'){
                        $attributes_parts = explode('___', $composite['attribute_id']);
                        $attribute_group_id = $attributes_parts[0];
                        $attribute_id = $attributes_parts[1];
                        if($product['all_attributes']){
                            foreach ($product['all_attributes'] as $group_attributes) {
                                if($group_attributes['attribute_group_id'] == $attribute_group_id && $group_attributes['attribute']){
                                    foreach ($group_attributes['attribute'] as $attribute_group_value) {
                                        if($attribute_group_value['attribute_id']==$attribute_id){
                                            $name[] = trim($this->prepareField($attribute_group_value['name'])).': '.trim($this->prepareField($attribute_group_value['text']));
                                        }
                                    }
                                    
                                }
                            }
                        }
                    }
                    //опция
                    elseif($composite['status']=='option_id'){
                        $option_id = $composite['option_id'];
                        if($product['all_options']){
                            foreach ($product['all_options'] as $option) {
                                if($option['option_id'] == $option_id){
                                    
                                    $name_option = trim($this->prepareField($option['name']));
                                    $name_option_vields = array();
                                    foreach ($option['product_option_value'] as $product_option_value) {
                                        $name_option_vields[] = trim($this->prepareField($product_option_value['name']));
                                    }
                                    if($name_option_vields){
                                        $name[] = $name_option.': '.  implode(', ', $name_option_vields);
                                    }else{
                                        $name[] = $name_option;
                                    }
                                }
                            }
                        }
                    }
                    //цена
                    elseif($composite['status']=='price'){
                        $name[] = $this->prices[$product['product_id']];
                    }
                    //вес
                    elseif($composite['status']=='weight'){
                        if((float)$product['weight']>0){
                            $name[] = $this->weight->format($product['weight'],$product['weight_class_id']);
                        }
                    }
                    //производитель
                    elseif($composite['status']=='manufacturer_id'){
                        $product['manufacturer'] = $this->prepareField($product['manufacturer']);
                        if($product['manufacturer']){
                            $name[] = $product['manufacturer'];
                        }
                    }
                    //категория
                    elseif($composite['status']=='category_id'){
                        $name[] = $this->categories[$product['category_id']]['name'];
                    }
                    //габариты
                    elseif($composite['status']=='length_width_height'){
                        $length_width_height = array();
                        if((float)$product['length']>0){
                            $length_width_height[] = $this->length->format($product['length'],$product['length_class_id']);
                        }
                        if((float)$product['width']>0){
                            $length_width_height[] = $this->length->format($product['width'],$product['length_class_id']);
                        }
                        if((float)$product['height']>0){
                            $length_width_height[] = $this->length->format($product['height'],$product['length_class_id']);
                        }
                        if($length_width_height){
                            $name[] = implode('/', $length_width_height);
                        }
                    }
                    //остальные
                    elseif (isset ($product[$composite['status']])) {
                        $product[$composite['status']] = $this->prepareField($product[$composite['status']]);
                        if($product[$composite['status']]){
                            $name[] = $product[$composite['status']];
                        }
                    }
                }
                $result = trim($this->prepareField(implode(' ', $name)));
                return $result;
            }
            return $result;
        }
        
        public function getTemplateSettingDataComposite($product,$template_setting,$compositeType){
            
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

        public function getDeliveryOption($tamplate_setting){
            //var_dump($tamplate_setting['delivery-options']);exit();
            $result = array();
            if(isset($tamplate_setting['delivery-options']['status'])){
                unset($tamplate_setting['delivery-options']['status']);
            }
            foreach ($tamplate_setting['delivery-options'] as $delivery_options) {
                $delivery_options['days'] = trim($delivery_options['days']);
                $delivery_options['order-before'] = trim($delivery_options['order-before']);
                $delivery_options['cost'] = trim($delivery_options['cost']);
                if($delivery_options['cost']!='' || $delivery_options['days']!='' || $delivery_options['order-before']!=''){
                    if($delivery_options['cost']!=''){
                        $option['cost'] = (int)$delivery_options['cost'];
                    }
                    if($delivery_options['days']!=''){
                        $option['days'] = $delivery_options['days'];
                    }
                    if($delivery_options['order-before']!=''){
                        $option['order-before'] = $delivery_options['order-before'];
                    }
                    $result[] = $option;
                    unset($option);
                }
            }
            return $result;
        }
        
        public function getPrice($price,$product,$tamplate_setting){
            $price = $this->tax->calculate($price, $product['tax_class_id']);
            $new_price = (float)$price;
            if(isset($tamplate_setting['ymlprice']) && $tamplate_setting['ymlprice']){
                $tamplate_setting['ymlprice'] = (float)$tamplate_setting['ymlprice'];
                $new_price = $new_price - $tamplate_setting['ymlprice']/100*$price;
                $new_price = round($new_price,2);
            }
            
            if($new_price==0.0){
                return $price;
            }else{
                return $new_price;
            }
        }
        
        public function getPictureAttributes($product,$tamplate_setting) {
            if(isset($tamplate_setting['count_pictures']) && !$tamplate_setting['count_pictures']){
                return array();
            }elseif(isset($tamplate_setting['count_pictures'])){
                $count_pictures = (int)$tamplate_setting['count_pictures'];
            }else{
                $count_pictures = 1;
            }
            
            $pictures_sizes = 500;
            
            if(isset($tamplate_setting['pictures_sizes'])){
                $tamplate_setting['pictures_sizes'] = (int)$tamplate_setting['pictures_sizes'];
                if($tamplate_setting['pictures_sizes']>0){
                    $pictures_sizes = $tamplate_setting['pictures_sizes'];
                }
            }
            $result = array();
            if ($product['image'] && $product['image']!='no_image.jpg' && $product['image']!='no_image.png' && $product['image']!='no-image.jpg' && $product['image']!='no-image.png') {
                $this->load->model('tool/image');
                $result[] = $this->model_tool_image->resize($product['image'], $pictures_sizes, $pictures_sizes);
                if($product['images']){
                    for($i=1;($i<$count_pictures && isset($product['images'][$i]));$i++){
                        // чтобы не было дублежа картинок
                        if($product['images'][$i]['image']!=$product['image']){
                            $result[] = $this->model_tool_image->resize($product['images'][$i]['image'], $pictures_sizes, $pictures_sizes);
                        }
                    }
                }
            }
            return $result;
        }

        public function getCategoriesAndOffers() {
            $ym_categories = array();
            $this->load->model('feed/ocext_yamarket');
            $all_yml_export_ocext_ym_filter_data_categories = $this->model_feed_ocext_yamarket->getFilterData('all_yml_export_ocext_ym_filter_data_categories');
            if($all_yml_export_ocext_ym_filter_data_categories){
                $ym_categories = $all_yml_export_ocext_ym_filter_data_categories;
                if($ym_categories){
                    foreach ($ym_categories as $category_id=>$ym_category){
                        if(!isset($ym_category['category_id'])){
                            unset($ym_categories[$category_id]);
                        }
                    }
                    
                    //если стал пустой, то категории не отмечены, по логике - это все
                    //возвращаем туда всё, что там лежало
                    if(!$ym_categories){
                        $ym_categories = $all_yml_export_ocext_ym_filter_data_categories;
                    }
                }
            }
            $ym_manufacturers = array();
            $all_yml_export_ocext_ym_filter_data_manufacturers = $this->model_feed_ocext_yamarket->getFilterData('all_yml_export_ocext_ym_filter_data_manufacturers');
            if($all_yml_export_ocext_ym_filter_data_manufacturers){
                $ym_manufacturers = $all_yml_export_ocext_ym_filter_data_manufacturers;
                if($ym_manufacturers){
                    foreach ($ym_manufacturers as $manufacturer_id=>$ym_manufacturer){
                        if(!isset($ym_manufacturer['manufacturer_id'])){
                            unset($ym_manufacturers[$manufacturer_id]);
                        }
                    }
                    //если стал пустой, то производители не отмечены, по логике - это все
                    //возвращаем туда всё, что там лежало
                    if(!$ym_manufacturers){
                        $ym_manufacturers = $all_yml_export_ocext_ym_filter_data_manufacturers;
                        $ym_manufacturers[''] = array("template_setting_id"=>"0");
                        $ym_manufacturers[0] = array("template_setting_id"=>"0");
                    }
                }
            }
            //Получаем список товаров для выгрузки и список категорий
            $this->load->model('feed/ocext_yamarket');
            $categories_and_products = $this->model_feed_ocext_yamarket->getCategoriesAndProducts($ym_categories,$ym_manufacturers);
            if(!$categories_and_products['offers'] || !$categories_and_products['categories']){
                return FALSE;
            }else{
                return $categories_and_products;
            }
        }
        
        private function prepareField($field) {
            if(is_string($field)){
                $field = strip_tags(htmlspecialchars_decode($field));
                $from = array('"', '&', '>', '<', '\'','`','&acute;');
                $to = array('&quot;', '&amp;', '&gt;', '&lt;', '&apos;','','');
                $field = str_replace($from, $to, $field);
                $field = trim($field);
            }
            return $field;
	}
        
        private function setShopAttributes($name, $value) {
            $attributes = array('name', 'company', 'url', 'platform', 'version');
            if (in_array($name, $attributes)) {
                    $this->shop[$name] = $this->prepareField($value);
            }
	}
        
        private function setCurrencyAttributes($currency, $rate = 'CBRF') {
            if($currency){
                if(!isset($this->currencies[0])){
                    $this->currencies[] = array(
                        'id'=>$currency,
                        'rate'=>1
                    );
                }else{
                    $this->currencies[] = array(
                        'id'=>$currency,
                        'rate'=>$rate
                    );
                }
                return TRUE;
            }else{
                return FALSE;
            }
	}
        
        private function setCategoryAttrubite($name, $category_id, $parent_id = 0) {
            $name = $this->prepareField($name);
            if(!$category_id || !$name) {
                return;
            }
            if((int)$parent_id > 0) {
                $this->categories[$category_id] = array(
                        'id'=>$category_id,
                        'parentId'=>(int)$parent_id,
                        'name'=>$this->prepareField($name)
                );
            }else{
                $this->categories[$category_id] = array(
                    'id'=>$category_id,
                    'name'=>$this->prepareField($name)
                );
            }
	}
        
        protected function getPathWhisCategories($category_id,$old_path = '') {
            if (isset($this->categories[$category_id])) {
                if (!$old_path) {
                    $new_path = $this->categories[$category_id]['id'];
                } else {
                    $new_path = $this->categories[$category_id]['id'].'_' .$old_path;
                }	
                if (isset($this->categories[$category_id]['parentId'])) {
                    return $this->getPathWhisCategories($this->categories[$category_id]['parentId'], $new_path);
                } else {
                    return $new_path;
                }
            }
	}
        
        
        private function setOffer($data) {
            $offer = array();
            $attributes = array('id', 'type', 'available', 'bid', 'cbid', 'param');
            $attributes = array_intersect_key($data, array_flip($attributes));
            foreach ($attributes as $key => $value) {
                switch ($key){
                    case 'id':
                    $value = (int)$value;
                    if ($value > 0) {
                            $offer[$key] = $value;
                    }
                    break;

                    case 'type':
                    if (in_array($value, array('vendor.model'))) {
                            $offer['type'] = $value;
                    }
                    break;

                    case 'available':
                    $offer['available'] = (($value=='true') ? 'true' : 'false');
                    break;

                    case 'param':
                    if (is_array($value)) {
                        $offer['param'] = $value;
                    }
                    break;
                    default:
                    break;
                }
            }
            $type = isset($offer['type']) ? $offer['type'] : '';
            $finded_tags = array('url'=>0, 'price'=>1);
            
            if(isset($data['oldprice']) && $data['oldprice']>0){
                $finded_tags['oldprice'] = 1;
            }
            
            $finded_tags = array_merge($finded_tags,array('currencyId'=>1, 'categoryId'=>1,'market_category'=>0, 'picture'=>0, 'store'=>0, 'pickup'=>0, 'delivery'=>0,'delivery-options'=>0));
            
            
            
            switch ($type) {
                case 'vendor.model':
                    $finded_tags = array_merge($finded_tags, array('name'=>1,'vendor'=>1, 'vendorCode'=>0, 'model'=>1));
                    break;
                default:
                    $finded_tags = array_merge($finded_tags, array('name'=>1, 'vendor'=>0, 'vendorCode'=>0, 'model'=>0));
                    break;
            }
            $finded_tags = array_merge($finded_tags, array('description'=>0, 'typePrefix'=>0, 'sales_notes'=>0, 'manufacturer_warranty'=>0, 'country_of_origin'=>0, 'adult'=>0, 'barcode'=>0, 'weight'=>0,'description'=>0, 'dimensions'=>0, 'age'=>0, 'cpa'=>0, 'rec'=>0));
            $requiredes = array_filter($finded_tags);
            if (sizeof(array_intersect_key($data, $requiredes)) != sizeof($requiredes)) {
                    return;
            }
            $data = array_intersect_key($data, $finded_tags);
            $finded_tags = array_intersect_key($finded_tags, $data);
            $offer['data'] = array();
            foreach ($finded_tags as $key => $value) {
                    $offer['data'][$key] = $this->prepareField($data[$key]);
            }
            $this->offers[] = $offer;
	}
        
        
        private function getYml() {
		$yml  = '<?xml version="1.0" encoding="UTF-8"?>' . $this->eol;
		$yml .= '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . $this->eol;
		$yml .= '<yml_catalog date="' . date('Y-m-d H:i') . '">' . $this->eol;
		$yml .= '<shop>' . $this->eol;
		$yml .= $this->createTag($this->shop);
		$yml .= '<currencies>' . $this->eol;
		foreach ($this->currencies as $currency) {
			$yml .= $this->getElement($currency, 'currency');
		}
		$yml .= '</currencies>' . $this->eol;
		$yml .= '<categories>' . $this->eol;
		foreach ($this->categories as $category) {
			$category_name = $category['name'];
			unset($category['name'], $category['export']);
			$yml .= $this->getElement($category, 'category', $category_name);
		}
		$yml .= '</categories>' . $this->eol;
                if($this->delivery_option){
                    $yml .= $this->createTag($this->delivery_option);
                }
		$yml .= '<offers>' . $this->eol;
		foreach ($this->offers as $offer) {
			$rows = $this->createTag($offer['data']);
			unset($offer['data']);
			if (isset($offer['param'])) {
                            $rows .= $this->createParam($offer['param']);
                            unset($offer['param']);
			}
			$yml .= $this->getElement($offer, 'offer', $rows);
		}
		$yml .= '</offers>' . $this->eol;
		$yml .= '</shop>';
		$yml .= '</yml_catalog>';
                //пишем файл
                $rootPath = realpath(DIR_APPLICATION . '..'); 
                if($this->config->get('ayeogs_filename_export')){
                    $filename = $this->config->get('ayeogs_filename_export');
                    $handle = fopen($rootPath.'/'.$filename.'.xml', 'w');
                    
                }else{
                    $handle = fopen($rootPath.'/yamarket.xml', 'w');
                }
                if(isset($handle) && $handle){
                    fwrite($handle, $yml);
                    fclose($handle);
                }
		return $yml;
	}

	private function getElement($attributes, $element_name, $element_value = '') {
            $retval = '<'.$element_name.' ';
            foreach ($attributes as $key => $value) {
                $retval .= $key .'="'.$value.'" ';
            }
            $retval .= $element_value ? '>' .$this->eol. $element_value.'</'.$element_name.'>' : '/>';
            $retval .= $this->eol;
            return $retval;
	}
        
	private function createTag($tags) {
            $retval = '';
            foreach ($tags as $key => $value) {
                if(!is_array($value) && $value){
                    $retval .= '<'.$key.'>'.$value.'</'.$key .'>'.$this->eol;
                }elseif (is_array($value) && $key == 'delivery-options') {
                    $retval .= $this->createDeliveryOptions($value); 
                }elseif (is_array($value) && $key == 'age') {
                    $retval .= '<'.$key.' unit="'.$value['unit'].'">'.$value['value'].'</'.$key.'>' . $this->eol;
                }elseif (is_array($value)) {
                    foreach ($value as $key_two=>$value_two) {
                        $retval .= '<'.$key.'>'.$value_two.'</'.$key.'>' . $this->eol;
                    }
                }
            }
            return $retval;
	}
        
	private function createParam($params) {
            $retval = '';
            foreach ($params as $param) {
                $retval .= '<param name="'.$this->prepareField($param['name']);
                if (isset($param['unit'])) {
                        $retval .= '" unit="'.$this->prepareField($param['unit']);
                }
                $retval .= '">'.$this->prepareField($param['value']) . '</param>'.$this->eol;
            }
            return $retval;
	}
        
        private function createDeliveryOptions($delivery_options) {
            $retval = '';
            if($delivery_options){
                foreach ($delivery_options as $option) {
                    $retval .= '<option cost="' . trim($option['cost']).'" days="'.trim($option['days']).'';
                    if (isset($option['order-before']) && $option['order-before']) {
                            $retval .= '" order-before="' . trim($option['order-before']);
                            unset($option['order-before']);
                    }
                    $retval .= '"/>'.$this->eol;
                }
            }
            if($retval){
                $retval = '<delivery-options>'.$this->eol.$retval.'</delivery-options>'.$this->eol;
            }
            
            return $retval;
	}
}
?>