<?php
class ControllerFeedAllYMLExportOcext extends Controller {
	private $error = array(); 
	private $this_version = '2.2.0.0';
        private $this_extension = 'ocext_all_yml_export';
        private $this_ocext_host = 'oc2101.ocext';
        
	public function index() { 
                
		$this->load->language('feed/all_yml_export_ocext');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
                $this->load->model('feed/all_yml_export_ocext');
                
                
                $data['tab_template_setting'] = $this->language->get('tab_template_setting');
                $data['tab_template_setting_help'] = $this->language->get('tab_template_setting_help');
                
                
                $data['tab_general'] = $this->language->get('tab_general');
                $data['tab_ym_categories'] = $this->language->get('tab_ym_categories');
                $data['tab_ym_filter_data'] = $this->language->get('tab_ym_filter_data');
                $data['tab_new_template_setting'] = $this->language->get('tab_new_template_setting');
                
                $data['text_template_setting_name'] = $this->language->get('text_template_setting_name');
                $data['text_template_setting_title'] = $this->language->get('text_template_setting_title');
                $data['text_template_setting_name_name'] = $this->language->get('text_template_setting_name_name');
                $data['text_template_setting_name_meta_title'] = $this->language->get('text_template_setting_name_meta_title');
                $data['text_template_setting_name_composite'] = $this->language->get('text_template_setting_name_composite');
                $data['text_template_setting_name_composite_help'] = $this->language->get('text_template_setting_name_composite_help');
                $data['text_template_setting_name_composite_new_element'] = $this->language->get('text_template_setting_name_composite_new_element');
                $data['text_template_setting_name_composite_num_element'] = $this->language->get('text_template_setting_name_composite_num_element');
                $data['text_template_setting_name_composite_element_meta_title'] = $this->language->get('text_template_setting_name_composite_element_meta_title');
                $data['text_template_setting_name_composite_element_product_id'] = $this->language->get('text_template_setting_name_composite_element_product_id');
                $data['text_template_setting_name_composite_element_model'] = $this->language->get('text_template_setting_name_composite_element_model');
                $data['text_template_setting_name_composite_element_sku'] = $this->language->get('text_template_setting_name_composite_element_sku');
                $data['text_template_setting_name_composite_element_upc'] = $this->language->get('text_template_setting_name_composite_element_upc');
                $data['text_template_setting_name_composite_element_ean'] = $this->language->get('text_template_setting_name_composite_element_ean');
                $data['text_template_setting_name_composite_element_jan'] = $this->language->get('text_template_setting_name_composite_element_jan');
                $data['text_template_setting_name_composite_element_isbn'] = $this->language->get('text_template_setting_name_composite_element_isbn');
                $data['text_template_setting_name_composite_element_mpn'] = $this->language->get('text_template_setting_name_composite_element_mpn');
                $data['text_template_setting_name_composite_element_location'] = $this->language->get('text_template_setting_name_composite_element_location');
                $data['text_template_setting_name_composite_element_manufacturer_id'] = $this->language->get('text_template_setting_name_composite_element_manufacturer_id');
                $data['text_template_setting_name_composite_element_price'] = $this->language->get('text_template_setting_name_composite_element_price');
                $data['text_template_setting_name_composite_element_weight'] = $this->language->get('text_template_setting_name_composite_element_weight');
                $data['text_template_setting_name_composite_element_length_width_height'] = $this->language->get('text_template_setting_name_composite_element_length_width_height');
                $data['text_template_setting_name_composite_element_category_id'] = $this->language->get('text_template_setting_name_composite_element_category_id');
                $data['text_template_setting_name_composite_element_option_id'] = $this->language->get('text_template_setting_name_composite_element_option_id');
                $data['text_template_setting_name_composite_element_attribute_id'] = $this->language->get('text_template_setting_name_composite_element_attribute_id');
                $data['text_template_setting_name_composite_element_self'] = $this->language->get('text_template_setting_name_composite_element_self');
                $data['text_template_setting_name_composite_element_name'] = $this->language->get('text_template_setting_name_composite_element_name');
                $data['text_template_setting_offer_composite_category_id'] = $this->language->get('text_template_setting_offer_composite_category_id');
                $data['text_template_setting_offer_composite_attribute_id_empty'] = $this->language->get('text_template_setting_offer_composite_attribute_id_empty');
                $data['text_template_setting_offer_composite_option_id_empty'] = $this->language->get('text_template_setting_offer_composite_option_id_empty');
                $data['text_template_setting_name_composite_num_element_first'] = $this->language->get('text_template_setting_name_composite_num_element_first');
                $data['text_template_setting_name_composite_num_element_next'] = $this->language->get('text_template_setting_name_composite_num_element_next');
                $data['text_template_setting_vendor_model'] = $this->language->get('text_template_setting_vendor_model');
                $data['text_template_setting_vendor'] = $this->language->get('text_template_setting_vendor');
                $data['text_template_setting_vendorCode'] = $this->language->get('text_template_setting_vendorCode');
                $data['text_template_setting_model'] = $this->language->get('text_template_setting_model');
                
                $data['text_disable'] = $this->language->get('text_disable');
                $data['text_enable'] = $this->language->get('text_enable');
                $data['text_need_select'] = $this->language->get('text_need_select');
                $data['text_all_data'] = $this->language->get('text_all_data');
                
                $data['text_template_setting_pickup'] = $this->language->get('text_template_setting_pickup');
                $data['text_template_setting_delivery_options'] = $this->language->get('text_template_setting_delivery_options');
                $data['text_template_setting_delivery_options_help'] = $this->language->get('text_template_setting_delivery_options_help');
                $data['text_template_setting_sales_notes'] = $this->language->get('text_template_setting_sales_notes');
                $data['text_template_setting_store'] = $this->language->get('text_template_setting_store');
                $data['text_template_setting_delivery'] = $this->language->get('text_template_setting_delivery');
                $data['text_template_setting_offer_available_true'] = $this->language->get('text_template_setting_offer_available_true');
                $data['text_template_setting_offer_available_false'] = $this->language->get('text_template_setting_offer_available_false');
                $data['text_template_setting_offer_stock_statuses_empty'] = $this->language->get('text_template_setting_offer_stock_statuses_empty');
                $data['text_template_setting_offer_stock_statuses_all_out_of_stock'] = $this->language->get('text_template_setting_offer_stock_statuses_all_out_of_stock');
                $data['text_template_setting_country_of_origin'] = $this->language->get('text_template_setting_country_of_origin');
                $data['text_template_setting_barcode'] = $this->language->get('text_template_setting_barcode');
                $data['text_template_setting_description'] = $this->language->get('text_template_setting_description');
                $data['text_template_setting_description_description']    = $this->language->get('text_template_setting_description_description');
                $data['text_template_setting_description_meta_keyword']    = $this->language->get('text_template_setting_description_meta_keyword');
                $data['text_template_setting_description_meta_title']    = $this->language->get('text_template_setting_description_meta_title');
                $data['text_template_setting_description_meta_description']    = $this->language->get('text_template_setting_description_meta_description');
                $data['text_template_setting_description_option_id']    = $this->language->get('text_template_setting_description_option_id');
                $data['text_template_setting_description_attribute_id']    = $this->language->get('text_template_setting_description_attribute_id');
                $data['text_template_setting_expiry'] = $this->language->get('text_template_setting_expiry');
                $data['text_template_setting_weight'] = $this->language->get('text_template_setting_weight');
                $data['text_template_setting_dimensions'] = $this->language->get('text_template_setting_dimensions');
                $data['text_template_setting_typePrefix'] = $this->language->get('text_template_setting_typePrefix');
                $data['text_template_setting_cpa'] = $this->language->get('text_template_setting_cpa');
                $data['text_template_setting_rec'] = $this->language->get('text_template_setting_rec');
                $data['text_template_setting_manufacturer_warranty'] = $this->language->get('text_template_setting_manufacturer_warranty');
                $data['text_template_setting_adult'] = $this->language->get('text_template_setting_adult');
                $data['text_template_setting_age'] = $this->language->get('text_template_setting_age');
                $data['text_template_setting_age_unit_year'] = $this->language->get('text_template_setting_age_unit_year');
                $data['text_template_setting_age_unit_month'] = $this->language->get('text_template_setting_age_unit_month');
                $data['text_template_setting_oldprice'] = $this->language->get('text_template_setting_oldprice');
                $data['text_template_setting_ymlprice'] = $this->language->get('text_template_setting_ymlprice');
                $data['text_template_setting_count_pictures'] = $this->language->get('text_template_setting_count_pictures');
                $data['text_template_setting_no_pictures'] = $this->language->get('text_template_setting_no_pictures');
                $data['text_template_setting_pictures_sizes'] = $this->language->get('text_template_setting_pictures_sizes');
                
                $data['text_template_setting_status'] = $this->language->get('text_template_setting_status');
                $data['text_template_setting_dispublic_quantity'] = $this->language->get('text_template_setting_dispublic_quantity');
                
                $data['text_template_setting_attribute_sintaxis'] = $this->language->get('text_template_setting_attribute_sintaxis');
                $data['entry_template_setting_attribute_sintaxis_0'] = $this->language->get('entry_template_setting_attribute_sintaxis_0');
                $data['entry_template_setting_attribute_sintaxis_1'] = $this->language->get('entry_template_setting_attribute_sintaxis_1');
                
                $data['text_delete'] = $this->language->get('text_delete');
                $data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
                $data['button_filter'] = $this->language->get('button_filter');
                $data['text_ym_categories_filter_ym_category_last_child'] = $this->language->get('text_ym_categories_filter_ym_category_last_child');
                $data['text_ym_categories_filter_status'] = $this->language->get('text_ym_categories_filter_status');
                $data['text_ym_categories_filter_status_'] = $this->language->get('text_ym_categories_filter_status_');
                $data['text_ym_categories_filter_status_1'] = $this->language->get('text_ym_categories_filter_status_1');
                $data['text_ym_categories_filter_status_2'] = $this->language->get('text_ym_categories_filter_status_2');
                $data['text_ym_categories_filter_category_id'] = $this->language->get('text_ym_categories_filter_category_id');
                $data['text_ym_categories_filter_category_id_'] = $this->language->get('text_ym_categories_filter_category_id_');
                $data['text_ym_categories_filter_category_id_1'] = $this->language->get('text_ym_categories_filter_category_id_1');
                $data['text_ym_status_1'] = $this->language->get('text_ym_status_1');
                $data['text_ym_status_0'] = $this->language->get('text_ym_status_0');
                $data['text_ym_filter_data_categories'] = $this->language->get('text_ym_filter_data_categories');
                $data['text_ym_filter_data_manufacturers'] = $this->language->get('text_ym_filter_data_manufacturers');
                $data['text_ym_filter_data_attributes'] = $this->language->get('text_ym_filter_data_attributes');
                $data['text_ym_filter_data_options'] = $this->language->get('text_ym_filter_data_options');
                $data['text_general_setting_status'] = $this->language->get('text_general_setting_status');
                $data['text_general_setting_enable'] = $this->language->get('text_general_setting_enable');
                $data['text_general_setting_disable'] = $this->language->get('text_general_setting_disable');
                $data['text_general_setting_name'] = $this->language->get('text_general_setting_name');
                $data['text_general_setting_company'] = $this->language->get('text_general_setting_company');
                $data['text_general_setting_currencies'] = $this->language->get('text_general_setting_currencies');
                $data['text_general_setting_platform'] = $this->language->get('text_general_setting_platform');
                $data['text_general_setting_version'] = $this->language->get('text_general_setting_version');
                $data['text_general_setting_filename_export'] = $this->language->get('text_general_setting_filename_export');
                $data['text_general_setting_path_token_export'] = $this->language->get('text_general_setting_path_token_export');
                $data['text_ym_categories_categories_empty'] = $this->language->get('text_ym_categories_categories_empty');
                $data['text_general_setting_copy'] = $this->language->get('text_general_setting_copy');
                
                $data['text_no_results'] = $this->language->get('text_no_results');
                $data['column_ym_category_path'] = $this->language->get('column_ym_category_path');
                $data['column_ym_category_last_child'] = $this->language->get('column_ym_category_last_child');
                $data['column_category_id'] = $this->language->get('column_category_id');
                $data['column_ym_status'] = $this->language->get('column_ym_status');
                $data['templates_setting'] = $this->model_feed_all_yml_export_ocext->getTemplateSetting();
                $data['template_setting_names'] = $this->model_feed_all_yml_export_ocext->getTemplateSettingNames();
                $data['template_setting_name_composite'] = $this->model_feed_all_yml_export_ocext->getTemplateSettingNameComposite();
                $data['template_setting_fields'] = $this->model_feed_all_yml_export_ocext->getTemplateSettingFields($data['template_setting_name_composite']);
                $data['template_setting_descriptions'] = $this->model_feed_all_yml_export_ocext->getTemplateSettingNames(TRUE);
                $data['attributes'] = $this->model_feed_all_yml_export_ocext->getAttributes();
                $data['options'] = $this->model_feed_all_yml_export_ocext->getOptions();
                $data['stock_statuses'] = $this->model_feed_all_yml_export_ocext->getStockStatuses();
                $warning = '';
                $url = '';
                $data['open_tab'] = 'tab-template-setting';
                $ym_categories_page = 1;
                if (isset($this->request->get['ym_categories_page'])) {
                    $ym_categories_page = $this->request->get['ym_categories_page'];
                    $url .= '&ym_categories_page='.$this->request->get['ym_categories_page'];
                }
                $filter_category_id = NULL;
                $data['filter_category_id'] = '';
                if (isset($this->request->post['filter_category_id']) && $this->request->post['filter_category_id']!='') {
                    $url .= '&filter_category_id='.$this->request->post['filter_category_id'];
                    $filter_category_id = $this->request->post['filter_category_id'];
                    $data['filter_category_id'] = $this->request->post['filter_category_id'];
                }
                
                $ym_category_last_child = NULL;
                $data['ym_category_last_child'] = '';
                if (isset($this->request->post['ym_category_last_child']) && $this->request->post['ym_category_last_child']) {
                    $url .= '&ym_category_last_child='.$this->request->post['ym_category_last_child'];
                    $ym_category_last_child = $this->request->post['ym_category_last_child'];
                    $data['ym_category_last_child'] = $this->request->post['ym_category_last_child'];
                }
                
                $filter_ym_status = '0';
                $data['filter_ym_status'] = '0';
                if (isset($this->request->post['filter_ym_status'])) {
                    $url .= '&filter_ym_status='.$this->request->post['filter_ym_status'];
                    $filter_ym_status = $this->request->post['filter_ym_status'];
                    $data['filter_ym_status'] = $this->request->post['filter_ym_status'];
                }
                if( isset($this->request->get['ym_categories_page']) || isset($this->request->get['ym_categories_filter']) || isset($this->request->get['ym_categories']) || $filter_ym_status || $ym_category_last_child || $filter_category_id){
                    $data['open_tab']='tab-ym-categories';
                }
                
                if( isset($this->request->get['ym_filter_data'])){
                    $data['open_tab']='tab-ym-filter-data';
                }
                
                if( isset($this->request->get['general_setting'])){
                    $data['open_tab']='tab-setting';
                }
                
                $config_limit_admin_pagination = $this->config->get('config_limit_admin');
                if($this->config->get('config_limit_admin')>5){
                    $config_limit_admin_pagination = 5;
                }
                
                $filter = array(
			'category_id'      => $filter_category_id,
			'ym_category_last_child'	   => $ym_category_last_child,
			'status'  => $filter_ym_status,
			'start'                => ($ym_categories_page - 1) * $config_limit_admin_pagination,
			'limit'                => $config_limit_admin_pagination
		);
                
                $data['ym_categories'] = $this->model_feed_all_yml_export_ocext->getYmCategoriesFromDb($filter);
		$ym_categories_total = $this->model_feed_all_yml_export_ocext->getYmCategoriesFromDbTotal($filter);
                $pagination = new Pagination();
                $pagination->total = $ym_categories_total;
                $pagination->page = $ym_categories_page;
                $pagination->limit = $config_limit_admin_pagination;
                $pagination->text = $this->language->get('text_pagination');
                $pagination->url = $this->url->link('feed/all_yml_export_ocext', 'token=' . $this->session->data['token'] . $url . '&ym_categories_page={page}', 'SSL');
                $data['pagination'] = $pagination->render();
                $data['results'] = sprintf($this->language->get('text_pagination'), ($ym_categories_total) ? (($ym_categories_page - 1) * $config_limit_admin_pagination) + 1 : 0, ((($ym_categories_page - 1) * $config_limit_admin_pagination) > ($ym_categories_total - $config_limit_admin_pagination)) ? $ym_categories_total : ((($ym_categories_page - 1) * $config_limit_admin_pagination) + $config_limit_admin_pagination), $ym_categories_total, ceil($ym_categories_total / $config_limit_admin_pagination));
                $data['heading_title'] = $this->language->get('heading_title');
                $data['token'] = $this->session->data['token'];
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
                    if(isset($this->request->get['template_setting'])){
                        if(!isset($this->request->get['template_setting_id'])){
                            $template_setting_id = 0;
                        }else{
                            $template_setting_id = (int)$this->request->get['template_setting_id'];
                        }
                        $this->model_feed_all_yml_export_ocext->updateTemplateSetting($this->request->post,$template_setting_id);
                        $this->session->data['success'] = $this->language->get('text_success');
                        $this->response->redirect($this->url->link('feed/all_yml_export_ocext', '&template_setting=1&token=' . $this->session->data['token'], 'SSL'));
                    }elseif(isset($this->request->get['ym_categories'])){
                        $this->model_feed_all_yml_export_ocext->updateYmCategories($this->request->post);
                        $this->session->data['success'] = $this->language->get('text_success');
                        $this->response->redirect($this->url->link('feed/all_yml_export_ocext', $url.'&ym_categories=1&token=' . $this->session->data['token'], 'SSL'));
                    }elseif(isset($this->request->get['ym_filter_data'])){
                        $this->load->model('setting/setting');
                        //Если ничего не отмечено, сохраняем пусто массив
                        if(!isset($this->request->post['all_yml_export_ocext_ym_filter_data_attributes'])){
                            $this->request->post['all_yml_export_ocext_ym_filter_data_attributes'] = array();
                        }
                        //Если ничего не отмечено, сохраняем пусто массив
                        if(!isset($this->request->post['all_yml_export_ocext_ym_filter_data_options'])){
                            $this->request->post['all_yml_export_ocext_ym_filter_data_options'] = array();
                        }
                        
                        $all_yml_export_ocext_ym_filter_data_attributes = $this->request->post['all_yml_export_ocext_ym_filter_data_attributes'];
                        $this->model_feed_all_yml_export_ocext->setFilterData('all_yml_export_ocext_ym_filter_data_attributes',$all_yml_export_ocext_ym_filter_data_attributes);
                        
                        $all_yml_export_ocext_ym_filter_data_options = $this->request->post['all_yml_export_ocext_ym_filter_data_options'];
                        $this->model_feed_all_yml_export_ocext->setFilterData('all_yml_export_ocext_ym_filter_data_options',$all_yml_export_ocext_ym_filter_data_options);
                        
                        $all_yml_export_ocext_ym_filter_data_manufacturers = $this->request->post['all_yml_export_ocext_ym_filter_data_manufacturers'];
                        $this->model_feed_all_yml_export_ocext->setFilterData('all_yml_export_ocext_ym_filter_data_manufacturers',$all_yml_export_ocext_ym_filter_data_manufacturers);
                        
                        $all_yml_export_ocext_ym_filter_data_categories = $this->request->post['all_yml_export_ocext_ym_filter_data_categories'];
                        $this->model_feed_all_yml_export_ocext->setFilterData('all_yml_export_ocext_ym_filter_data_categories',$all_yml_export_ocext_ym_filter_data_categories);
                        
                        $this->session->data['success'] = $this->language->get('text_success');
                        $this->response->redirect($this->url->link('feed/all_yml_export_ocext', $url.'&ym_filter_data=1&token=' . $this->session->data['token'], 'SSL'));
                    }elseif(isset($this->request->get['general_setting'])){
                        $this->load->model('setting/setting');
                        if ($this->request->post['ayeogs_status']) {
                            $this->model_setting_setting->editSetting('all_yml_export_ocext', array('all_yml_export_ocext_status'=>1));
                        }else{
                            $this->model_setting_setting->editSetting('all_yml_export_ocext', array('all_yml_export_ocext_status'=>0));
                        }
                        $this->model_setting_setting->editSetting('ayeogs', $this->request->post);
                        $this->session->data['success'] = $this->language->get('text_success');
                        $this->response->redirect($this->url->link('feed/all_yml_export_ocext', $url.'&general_setting=1&token=' . $this->session->data['token'], 'SSL'));
                    }
		}

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
                }elseif($warning){
                        $data['error_warning'] = $warning;
                } else {
			$data['error_warning'] = '';
		}
                if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_feed'),
			'href'      => $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('feed/all_yml_export_ocext', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action_general_setting'] = $this->url->link('feed/all_yml_export_ocext', $url.'&general_setting=1&token=' . $this->session->data['token'], 'SSL');
                $data['action_template_setting'] = $this->url->link('feed/all_yml_export_ocext', $url.'&template_setting=1&token=' . $this->session->data['token'], 'SSL');
                $data['action_ym_filter_data'] = $this->url->link('feed/all_yml_export_ocext', $url.'&ym_filter_data=1&token=' . $this->session->data['token'], 'SSL');
                $data['action_ym_categories'] = $this->url->link('feed/all_yml_export_ocext', $url.'&ym_categories=1&token=' . $this->session->data['token'], 'SSL');
                $data['action_ym_categories_filter'] = $this->url->link('feed/all_yml_export_ocext', $url.'&ym_categories_filter=1&token=' . $this->session->data['token'], 'SSL');
                $data['cancel'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');
                
                $data['ayeogs_status'] = 0;
                if ($this->config->get('ayeogs_status')) {
                    $data['ayeogs_status'] = $this->config->get('ayeogs_status');
                }
                
                $data['ayeogs_platform'] = $this->config->get('ayeogs_platform');
                if (is_null($data['ayeogs_platform'])) {
                    $data['ayeogs_platform'] = 'OpenCart';
                }
                
                $data['ayeogs_version'] = $this->config->get('ayeogs_version');
                if (is_null($data['ayeogs_version'])) {
                    $data['ayeogs_version'] = VERSION;
                }
                
                $data['ayeogs_currencies'] = 0;
                if ($this->config->get('ayeogs_currencies')) {
                    $data['ayeogs_currencies'] = $this->config->get('ayeogs_currencies');
                }
                
                $data['ayeogs_filename_export'] = 'ocext_yamarket';
                if ($this->config->get('ayeogs_filename_export')) {
                    $data['ayeogs_filename_export'] = $this->config->get('ayeogs_filename_export');
                }
                
                if ($this->config->get('ayeogs_path_token_export')) {
                    $data['ayeogs_path_token_export'] = $this->config->get('ayeogs_path_token_export');
                    $data['ayeogs_path_token_export_link'] ='';
                }else{
                    $data['ayeogs_path_token_export'] = time();
                    $data['ayeogs_path_token_export_link'] = 'Ссылка еще не сохранялась. Нажмите сохранить';
                }
                
                if ($this->config->get('ayeogs_name')) {
                    $data['ayeogs_name'] = $this->config->get('ayeogs_name');
                }elseif($this->config->get('config_name')){
                    $data['ayeogs_name'] = $this->config->get('config_name');
                }else{
                    $data['ayeogs_name'] = '';
                }
                
                if ($this->config->get('ayeogs_company')) {
                    $data['ayeogs_company'] = $this->config->get('ayeogs_company');
                }elseif($this->config->get('config_owner')){
                    $data['ayeogs_company'] = $this->config->get('config_owner');
                }else{
                    $data['ayeogs_company'] = '';
                }
                
                $data['back'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');
		$data['button_back'] = $this->language->get( 'button_back' );
                $data['header'] = $this->load->controller('common/header');
                $data['column_left'] = $this->load->controller('common/column_left');
                $data['footer'] = $this->load->controller('common/footer');
                $this->response->setOutput($this->load->view('feed/all_yml_export_ocext.tpl', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'feed/all_yml_export_ocext')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
        
        public function getCategories() {
            $this->load->language('feed/all_yml_export_ocext');
            $this->load->model('feed/all_yml_export_ocext');
            $data['text_ym_categories_categories_empty'] = $this->language->get('text_ym_categories_categories_empty');
            $data['entry_set_template_all_data'] = $this->language->get('entry_set_template_all_data');
            
            
            $filter = array();
            $category_not_empty = 1;
            $data['filter_name'] = '';
            if($this->request->get['filter_name']){
                $filter['filter_name'] = $this->request->get['filter_name'];
                $category_not_empty = '';
                $data['filter_name'] = 1;
            }
            $this->load->model('catalog/category');
            $data['categories'] = $this->model_catalog_category->getCategories($filter);
            $filter_ym_categories = array(
                    'category_id'      => $category_not_empty,
                    'ym_category_last_child'	   => '',
                    'status'  => '',
                    'start'                => 0,
                    'limit'                => 10000
            );
            $ym_categories = $this->model_feed_all_yml_export_ocext->getYmCategoriesFromDb($filter_ym_categories);
            
            if($ym_categories){
                foreach ($ym_categories as $ym_category) {
                    if($ym_category['category_id']){
                        $ym_category['category_id'] = json_decode($ym_category['category_id'],TRUE);
                        foreach ($ym_category['category_id'] as $category_id) {
                            $data['ym_categories'][$category_id][$ym_category['ym_category_id']] = $category_id;
                        }
                    }
                }
            }
            
            $data['ym_category_id'] = (int)$this->request->get['ym_category_id'];
            $this->response->setOutput($this->load->view('feed/all_yml_export_ocext_ym_categories_categories.tpl', $data));
        }
        
        public function getYmFilterData() {
            
            $this->load->model('feed/all_yml_export_ocext');
            
            $data['ym_categories'] = array();
            $ym_categories_last = $this->model_feed_all_yml_export_ocext->getLastFilterData('all_yml_export_ocext_ym_filter_data_categories');
            $ym_categories = $this->model_feed_all_yml_export_ocext->getFilterData('all_yml_export_ocext_ym_filter_data_categories');
            //миграция на 2.1.7
            if($ym_categories_last && !$ym_categories){
                $this->model_feed_all_yml_export_ocext->setFilterData('all_yml_export_ocext_ym_filter_data_categories',$ym_categories_last);
                $ym_categories = $this->model_feed_all_yml_export_ocext->getFilterData('all_yml_export_ocext_ym_filter_data_categories');
            }
            if($ym_categories && isset($this->request->get['categories'])){
                $data['ym_categories'] = $ym_categories;
            }
            
            $data['ym_manufacturers'] = array();
            $ym_manufacturers_last = $this->model_feed_all_yml_export_ocext->getLastFilterData('all_yml_export_ocext_ym_filter_data_manufacturers');
            $ym_manufacturers = $this->model_feed_all_yml_export_ocext->getFilterData('all_yml_export_ocext_ym_filter_data_manufacturers');
            //миграция на 2.1.7
            if($ym_manufacturers_last && !$ym_manufacturers){
                $this->model_feed_all_yml_export_ocext->setFilterData('all_yml_export_ocext_ym_filter_data_manufacturers',$ym_manufacturers_last);
                $ym_manufacturers = $this->model_feed_all_yml_export_ocext->getFilterData('all_yml_export_ocext_ym_filter_data_manufacturers');
            }
            if($ym_manufacturers && isset($this->request->get['manufacturers'])){
                $data['ym_manufacturers'] = $ym_manufacturers;
            }
            
            $data['ym_attributes'] = array();
            $ym_attributes_last = $this->model_feed_all_yml_export_ocext->getLastFilterData('all_yml_export_ocext_ym_filter_data_attributes');
            $ym_attributes = $this->model_feed_all_yml_export_ocext->getFilterData('all_yml_export_ocext_ym_filter_data_attributes');
            //миграция на 2.1.7
            if($ym_attributes_last && !$ym_attributes){
                $this->model_feed_all_yml_export_ocext->setFilterData('all_yml_export_ocext_ym_filter_data_attributes',$ym_attributes_last);
                $ym_attributes = $this->model_feed_all_yml_export_ocext->getFilterData('all_yml_export_ocext_ym_filter_data_attributes');
            }
            if($ym_attributes && isset($this->request->get['attributes'])){
                $data['ym_attributes'] = $ym_attributes;
            }
            
            $data['ym_options'] = array();
            $ym_options_last = $this->model_feed_all_yml_export_ocext->getLastFilterData('all_yml_export_ocext_ym_filter_data_options');
            $ym_options = $this->model_feed_all_yml_export_ocext->getFilterData('all_yml_export_ocext_ym_filter_data_options');
            //миграция на 2.1.7
            if($ym_options_last && !$ym_options){
                $this->model_feed_all_yml_export_ocext->setFilterData('all_yml_export_ocext_ym_filter_data_options',$ym_options_last);
                $ym_options = $this->model_feed_all_yml_export_ocext->getFilterData('all_yml_export_ocext_ym_filter_data_options');
            }
            if($ym_options && isset($this->request->get['options'])){
                $data['ym_options'] = $ym_options;
            }
            /*
            if ($this->config->get('all_yml_export_ocext_ym_filter_data_categories') && isset($this->request->get['categories'])) {
                $data['ym_categories'] = $this->config->get('all_yml_export_ocext_ym_filter_data_categories');
            }
             * 
             */
            /*
            $data['ym_manufacturers'] = array();
            if ($this->config->get('all_yml_export_ocext_ym_filter_data_manufacturers') && isset($this->request->get['manufacturers'])) {
                $data['ym_manufacturers'] = $this->config->get('all_yml_export_ocext_ym_filter_data_manufacturers');
            }
             * 
             */
            /*
            $data['ym_attributes'] = array();
            if ($this->config->get('all_yml_export_ocext_ym_filter_data_attributes') && isset($this->request->get['attributes'])) {
                $data['ym_attributes'] = $this->config->get('all_yml_export_ocext_ym_filter_data_attributes');
            }
             * 
             */
            /*
            $data['ym_options'] = array();
            if ($this->config->get('all_yml_export_ocext_ym_filter_data_options') && isset($this->request->get['options'])) {
                $data['ym_options'] = $this->config->get('all_yml_export_ocext_ym_filter_data_options');
            }
             * 
             */
            $this->load->model('feed/all_yml_export_ocext');
            if(isset($this->request->get['categories'])){
                $this->load->model('catalog/category');
                $data['categories'] = $this->model_catalog_category->getCategories(0);
            }elseif(isset($this->request->get['manufacturers'])){
                $this->load->model('catalog/manufacturer');
                $data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();
            }elseif(isset($this->request->get['options'])){
                $data['options'] = $this->model_feed_all_yml_export_ocext->getOptions();
            }elseif(isset($this->request->get['attributes'])){
                $data['attributes'] = $this->model_feed_all_yml_export_ocext->getAttributes();
            }
            $this->load->language('feed/all_yml_export_ocext');
            $data['tab_template_setting'] = $this->language->get('tab_template_setting');
            $data['text_ym_categories_categories_empty'] = $this->language->get('text_ym_categories_categories_empty');
            $data['text_ym_filter_data_manufacturers_empty'] = $this->language->get('text_ym_filter_data_manufacturers_empty');
            $data['text_ym_filter_data_options_empty'] = $this->language->get('text_ym_filter_data_options_empty');
            $data['text_ym_filter_data_attributes_empty'] = $this->language->get('text_ym_filter_data_attributes_empty');
            $data['text_ym_filter_data_templates_setting_empty'] = $this->language->get('text_ym_filter_data_templates_setting_empty');
            $data['text_ym_filter_data_templates_setting_0'] = $this->language->get('text_ym_filter_data_templates_setting_0');
            $data['text_ym_categories_categories_name'] = $this->language->get('text_ym_categories_categories_name');
            $data['text_ym_categories_manufacturers_name'] = $this->language->get('text_ym_categories_manufacturers_name');
            $data['text_template_setting_offer_composite_attribute_id_empty'] = $this->language->get('text_template_setting_offer_composite_attribute_id_empty');
            $data['text_template_setting_offer_composite_option_id_empty'] = $this->language->get('text_template_setting_offer_composite_option_id_empty');
            $data['entry_set_template_all_data'] = $this->language->get('entry_set_template_all_data');
            
            $data['templates_setting'] = $this->model_feed_all_yml_export_ocext->getTemplateSetting(TRUE);
            $this->response->setOutput($this->load->view('feed/all_yml_export_ocext_ym_filter_data.tpl', $data));
        }
        
        public function getNewCompositeElement() {
            $this->load->language('feed/all_yml_export_ocext');
            $this->load->model('feed/all_yml_export_ocext');
            $data['text_template_setting_name'] = $this->language->get('text_template_setting_name');
            $data['text_template_setting_title'] = $this->language->get('text_template_setting_title');
            $data['text_template_setting_name_name'] = $this->language->get('text_template_setting_name_name');
            $data['text_template_setting_name_meta_title'] = $this->language->get('text_template_setting_name_meta_title');
            $data['text_template_setting_name_composite'] = $this->language->get('text_template_setting_name_composite');
            $data['text_template_setting_name_composite_help'] = $this->language->get('text_template_setting_name_composite_help');
            $data['text_template_setting_name_composite_new_element'] = $this->language->get('text_template_setting_name_composite_new_element');
            $data['text_template_setting_name_composite_num_element'] = $this->language->get('text_template_setting_name_composite_num_element');
            $data['text_template_setting_name_composite_element_meta_title'] = $this->language->get('text_template_setting_name_composite_element_meta_title');
            $data['text_template_setting_name_composite_element_product_id'] = $this->language->get('text_template_setting_name_composite_element_product_id');
            $data['text_template_setting_name_composite_element_model'] = $this->language->get('text_template_setting_name_composite_element_model');
            $data['text_template_setting_name_composite_element_sku'] = $this->language->get('text_template_setting_name_composite_element_sku');
            $data['text_template_setting_name_composite_element_upc'] = $this->language->get('text_template_setting_name_composite_element_upc');
            $data['text_template_setting_name_composite_element_ean'] = $this->language->get('text_template_setting_name_composite_element_ean');
            $data['text_template_setting_name_composite_element_jan'] = $this->language->get('text_template_setting_name_composite_element_jan');
            $data['text_template_setting_name_composite_element_isbn'] = $this->language->get('text_template_setting_name_composite_element_isbn');
            $data['text_template_setting_name_composite_element_mpn'] = $this->language->get('text_template_setting_name_composite_element_mpn');
            $data['text_template_setting_name_composite_element_location'] = $this->language->get('text_template_setting_name_composite_element_location');
            $data['text_template_setting_name_composite_element_manufacturer_id'] = $this->language->get('text_template_setting_name_composite_element_manufacturer_id');
            $data['text_template_setting_name_composite_element_price'] = $this->language->get('text_template_setting_name_composite_element_price');
            $data['text_template_setting_name_composite_element_weight'] = $this->language->get('text_template_setting_name_composite_element_weight');
            $data['text_template_setting_name_composite_element_length_width_height'] = $this->language->get('text_template_setting_name_composite_element_length_width_height');
            $data['text_template_setting_name_composite_element_category_id'] = $this->language->get('text_template_setting_name_composite_element_category_id');
            $data['text_template_setting_name_composite_element_option_id'] = $this->language->get('text_template_setting_name_composite_element_option_id');
            $data['text_template_setting_name_composite_element_attribute_id'] = $this->language->get('text_template_setting_name_composite_element_attribute_id');
            $data['text_template_setting_name_composite_element_self'] = $this->language->get('text_template_setting_name_composite_element_self');
            $data['text_template_setting_name_composite_element_name'] = $this->language->get('text_template_setting_name_composite_element_name');
            $data['text_template_setting_offer_composite_category_id'] = $this->language->get('text_template_setting_offer_composite_category_id');
            $data['text_template_setting_offer_composite_attribute_id_empty'] = $this->language->get('text_template_setting_offer_composite_attribute_id_empty');
            $data['text_template_setting_offer_composite_option_id_empty'] = $this->language->get('text_template_setting_offer_composite_option_id_empty');
            $data['text_template_setting_name_composite_num_element_first'] = $this->language->get('text_template_setting_name_composite_num_element_first');
            $data['text_template_setting_name_composite_num_element_next'] = $this->language->get('text_template_setting_name_composite_num_element_next');
            $data['text_template_setting_vendor'] = $this->language->get('text_template_setting_vendor');
            $data['text_template_setting_vendorCode'] = $this->language->get('text_template_setting_vendorCode');
            $data['text_disable'] = $this->language->get('text_disable');
            $data['text_enable'] = $this->language->get('text_enable');
            $data['templates_setting'] = $this->model_feed_all_yml_export_ocext->getTemplateSetting();
            $data['template_setting_names'] = $this->model_feed_all_yml_export_ocext->getTemplateSettingNames();
            $data['template_setting_name_composite'] = $this->model_feed_all_yml_export_ocext->getTemplateSettingNameComposite();
            $data['attributes'] = $this->model_feed_all_yml_export_ocext->getAttributes();
            $data['options'] = $this->model_feed_all_yml_export_ocext->getOptions();
            $data['tamplate_setting_id'] = $this->request->get['tamplate_setting_id'];
            $data['template_setting_name_composite_num_element'] = $this->request->get['template_setting_name_composite_num_element'];
            
            
            $this->response->setOutput($this->load->view('feed/all_yml_export_ocext_template_setting_offer_composite.tpl', $data));
        }
         public function getTemplateSettingFields() {
            $this->load->language('feed/all_yml_export_ocext');
            $this->load->model('feed/all_yml_export_ocext');
            $data['text_template_setting_name'] = $this->language->get('text_template_setting_name');
            $data['text_template_setting_title'] = $this->language->get('text_template_setting_title');
            $data['text_template_setting_name_name'] = $this->language->get('text_template_setting_name_name');
            $data['text_template_setting_name_meta_title'] = $this->language->get('text_template_setting_name_meta_title');
            $data['text_template_setting_name_composite'] = $this->language->get('text_template_setting_name_composite');
            $data['text_template_setting_name_composite_help'] = $this->language->get('text_template_setting_name_composite_help');
            $data['text_template_setting_name_composite_new_element'] = $this->language->get('text_template_setting_name_composite_new_element');
            $data['text_template_setting_name_composite_num_element'] = $this->language->get('text_template_setting_name_composite_num_element');
            $data['text_template_setting_name_composite_element_meta_title'] = $this->language->get('text_template_setting_name_composite_element_meta_title');
            $data['text_template_setting_name_composite_element_product_id'] = $this->language->get('text_template_setting_name_composite_element_product_id');
            $data['text_template_setting_name_composite_element_model'] = $this->language->get('text_template_setting_name_composite_element_model');
            $data['text_template_setting_name_composite_element_sku'] = $this->language->get('text_template_setting_name_composite_element_sku');
            $data['text_template_setting_name_composite_element_upc'] = $this->language->get('text_template_setting_name_composite_element_upc');
            $data['text_template_setting_name_composite_element_ean'] = $this->language->get('text_template_setting_name_composite_element_ean');
            $data['text_template_setting_name_composite_element_jan'] = $this->language->get('text_template_setting_name_composite_element_jan');
            $data['text_template_setting_name_composite_element_isbn'] = $this->language->get('text_template_setting_name_composite_element_isbn');
            $data['text_template_setting_name_composite_element_mpn'] = $this->language->get('text_template_setting_name_composite_element_mpn');
            $data['text_template_setting_name_composite_element_location'] = $this->language->get('text_template_setting_name_composite_element_location');
            $data['text_template_setting_name_composite_element_manufacturer_id'] = $this->language->get('text_template_setting_name_composite_element_manufacturer_id');
            $data['text_template_setting_name_composite_element_price'] = $this->language->get('text_template_setting_name_composite_element_price');
            $data['text_template_setting_name_composite_element_weight'] = $this->language->get('text_template_setting_name_composite_element_weight');
            $data['text_template_setting_name_composite_element_length_width_height'] = $this->language->get('text_template_setting_name_composite_element_length_width_height');
            $data['text_template_setting_name_composite_element_category_id'] = $this->language->get('text_template_setting_name_composite_element_category_id');
            $data['text_template_setting_name_composite_element_option_id'] = $this->language->get('text_template_setting_name_composite_element_option_id');
            $data['text_template_setting_name_composite_element_attribute_id'] = $this->language->get('text_template_setting_name_composite_element_attribute_id');
            $data['text_template_setting_name_composite_element_self'] = $this->language->get('text_template_setting_name_composite_element_self');
            $data['text_template_setting_name_composite_element_name'] = $this->language->get('text_template_setting_name_composite_element_name');
            $data['text_template_setting_offer_composite_category_id'] = $this->language->get('text_template_setting_offer_composite_category_id');
            $data['text_template_setting_offer_composite_attribute_id_empty'] = $this->language->get('text_template_setting_offer_composite_attribute_id_empty');
            $data['text_template_setting_offer_composite_option_id_empty'] = $this->language->get('text_template_setting_offer_composite_option_id_empty');
            $data['text_template_setting_name_composite_num_element_first'] = $this->language->get('text_template_setting_name_composite_num_element_first');
            $data['text_template_setting_name_composite_num_element_next'] = $this->language->get('text_template_setting_name_composite_num_element_next');
            $data['text_template_setting_vendor'] = $this->language->get('text_template_setting_vendor');
            $data['text_template_setting_vendorCode'] = $this->language->get('text_template_setting_vendorCode');
            $data['text_disable'] = $this->language->get('text_disable');
            $data['text_enable'] = $this->language->get('text_enable');
            $data['templates_setting'] = $this->model_feed_all_yml_export_ocext->getTemplateSetting();
            $data['template_setting_names'] = $this->model_feed_all_yml_export_ocext->getTemplateSettingNames();
            $data['template_setting_name_composite'] = $this->model_feed_all_yml_export_ocext->getTemplateSettingNameComposite();
            $data['template_setting_fields'] = $this->model_feed_all_yml_export_ocext->getTemplateSettingFields($data['template_setting_name_composite']);
            $data['attributes'] = $this->model_feed_all_yml_export_ocext->getAttributes();
            $data['options'] = $this->model_feed_all_yml_export_ocext->getOptions();
            $data['tamplate_setting_id'] = $this->request->get['tamplate_setting_id'];
            $data['name_field'] = $this->request->get['name_field'];
            
            $this->response->setOutput($this->load->view('feed/all_yml_export_ocext_template_setting_fields.tpl', $data));
        }
        


        public function getNotifications() {
		sleep(1);
		$this->load->language('feed/all_yml_export_ocext');
		$response = $this->getNotificationsCurl();
		$json = array();
		if ($response===false) {
			$json['message'] = '';
			$json['error'] = $this->language->get( 'error_notifications' );
		} else {
			$json['message'] = $response;
			$json['error'] = '';
		}
		$this->response->setOutput(json_encode($json));
	}
        
        protected function curl_get_contents($url) {
            if(function_exists('curl_version')){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                $output = curl_exec($ch);
                curl_close($ch);
                return $output;
            }else{
                $output['ru'] = 'Проверка версии недоступна. Включите php расширение - CURL на Вашем хостинге';
                $output['en'] = 'You can not check the version. Enable php extension - CURL on your hosting';
                $language_code = $this->config->get( 'config_admin_language' );
                if(isset($output[$language_code])){
                    return $output[$language_code];
                }else{
                    return $output['en'];
                }
            }
	}
        
	public function getNotificationsCurl() {
		$language_code = $this->config->get( 'config_admin_language' );
		$result = $this->curl_get_contents("http://www.".$this->this_ocext_host.".com/index.php?route=information/check_update_version&license=".HTTP_SERVER."&version_opencart=".VERSION."&version_ocext=".$this->this_version."&extension=".$this->this_extension."&language_code=$language_code");
		if (stripos($result,'<html') !== false) {
			return '';
		}
		return $result;
	}
}
?>