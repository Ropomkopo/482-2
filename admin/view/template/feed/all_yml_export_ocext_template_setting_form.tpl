<input type="hidden" name="template_setting[<?php echo $template_setting_id ?>][template_setting_id]" value="<?php echo $template_setting_id ?>" />
<div id="tab-template_setting<?php echo $template_setting_id ?>" class="tab-pane <?php if(!$template_setting_id){ ?>active<?php } /*активная только новый таб*/ ?>" >
    <table class="table table-bordered table-hover">
            <tbody>
            <tr>
                <td width="60%"><?php echo $text_template_setting_title; ?></td>
                <td>
                    <?php
                    
                        $template_setting_title = '';
                        if($template_setting_id){
                            $template_setting_title = $template_setting['title'];
                        }
                    
                    ?>
                    <input value="<?php echo $template_setting_title ?>" type="text" onchange="if(this.value==''){ $('#tab-template_setting_nav<?php echo $template_setting_id ?>').html('<?php echo $tab_new_template_setting; ?>'); }else{ $('#tab-template_setting_nav<?php echo $template_setting_id ?>').html(this.value); }" name="template_setting[<?php echo $template_setting_id ?>][title]" />
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_name; ?></td>
                <td>
                    <select  name="template_setting[<?php echo $template_setting_id ?>][offer_name][field]" onchange="if(this.value=='composite'){ $('#template_setting_name_composite<?php echo $template_setting_id ?>').show(); }else{ $('#template_setting_name_composite<?php echo $template_setting_id ?>').hide(); }">
                        <?php foreach($template_setting_names as $template_setting_name){ ?>
                            <option  <?php if(isset($template_setting['offer_name']['field']) && $template_setting['offer_name']['field'] == $template_setting_name){ ?> selected="" <?php } ?>  value="<?php echo $template_setting_name; ?>"><?php echo ${'text_template_setting_name_'.$template_setting_name}; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr id="template_setting_name_composite<?php echo $template_setting_id ?>" style="<?php if(!isset($template_setting['offer_name']['field']) || $template_setting['offer_name']['field'] != 'composite'){ ?> display: none <?php } ?>">
                <td colspan="2">
                    <div style="border-left: 2px solid #cccccc; padding-left: 7px; margin-bottom: 10px; background: cornsilk"><?php echo $text_template_setting_name_composite_help; ?></div>

                    <div class="template_setting_name_composite_new_element_place<?php echo $template_setting_id ?>"></div>
                    <a data-toggle="tooltip" title="" onclick="addNewCompositeElement(<?php echo $template_setting_id ?>,0)" class="btn btn-primary" data-original-title="<?php echo $text_template_setting_name_composite_new_element ?>"><i class="fa fa-plus"></i> <?php echo $text_template_setting_name_composite_new_element ?></a><br><br>
                    <script type="text/javascript"><!--
                        <?php
                
                        if(isset($template_setting['offer_name']['field']) && $template_setting['offer_name']['field']=='composite' && isset($template_setting['offer_name']['composite']) && $template_setting['offer_name']['composite']){
                        foreach($template_setting['offer_name']['composite'] as $num_composite=>$composite){
                                    
                        ?>

                            $(document).ready(function() {
                                addNewCompositeElement(<?php echo $template_setting_id ?>,<?php echo $num_composite; ?>);
                            });

                        <?php }} ?>
                    //--></script>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_description; ?></td>
                <td>
                    <select  name="template_setting[<?php echo $template_setting_id ?>][offer_description][field]">
                        <?php foreach($template_setting_descriptions as $template_setting_description){ ?>
                            <option  <?php if(isset($template_setting['offer_description']['field']) && $template_setting['offer_description']['field'] == $template_setting_description){ ?> selected="" <?php } ?> value="<?php echo $template_setting_description; ?>"><?php echo ${'text_template_setting_description_'.$template_setting_description}; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_vendor_model; ?></td>
                <td>
                    <select  name="template_setting[<?php echo $template_setting_id ?>][vendor.model]">
                        <?php if(isset($template_setting['vendor.model']) && $template_setting['vendor.model'] == 'vendor.model'){ ?>
                            <option selected="" value="vendor.model"><?php echo $text_enable; ?></option>
                            <option value="0"><?php echo $text_disable; ?></option>
                        <?php }else{ ?>
                            <option value="vendor.model"><?php echo $text_enable; ?></option>
                            <option selected="" value="0"><?php echo $text_disable; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_vendor; ?></td>
                <td>
                    <div class="template_setting_vendor<?php echo $template_setting_id ?>"></div>
                    <script type="text/javascript"><!--

                    $(document).ready(function() {
                        getTemplateSettingFields(<?php echo $template_setting_id ?>,'vendor');
                    });

                    //--></script>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_vendorCode; ?></td>
                <td>
                    <div class="template_setting_vendorCode<?php echo $template_setting_id ?>"></div>
                    <script type="text/javascript"><!--

                    $(document).ready(function() {
                        getTemplateSettingFields(<?php echo $template_setting_id ?>,'vendorCode');
                    });

                    //--></script>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_model; ?></td>
                <td>
                    <div class="template_setting_model<?php echo $template_setting_id ?>"></div>
                    <script type="text/javascript"><!--

                    $(document).ready(function() {
                        getTemplateSettingFields(<?php echo $template_setting_id ?>,'model');
                    });

                    //--></script>
                </td>
            </tr>
            
            
            
            <tr>
                <td><?php echo $text_template_setting_pickup; ?></td>
                <td>
                    <select  name="template_setting[<?php echo $template_setting_id ?>][pickup]">
                        <?php if(isset($template_setting['pickup']) && $template_setting['pickup'] == 'pickup'){ ?>
                            <option selected="" value="pickup"><?php echo $text_enable; ?></option>
                            <option value="0"><?php echo $text_disable; ?></option>
                        <?php }else{ ?>
                            <option value="pickup"><?php echo $text_enable; ?></option>
                            <option selected="" value="0"><?php echo $text_disable; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_store; ?></td>
                <td>
                    <select  name="template_setting[<?php echo $template_setting_id ?>][store]">
                        <?php if(isset($template_setting['store']) && $template_setting['store'] == 'store'){ ?>
                            <option selected="" value="store"><?php echo $text_enable; ?></option>
                            <option value="0"><?php echo $text_disable; ?></option>
                        <?php }else{ ?>
                            <option value="store"><?php echo $text_enable; ?></option>
                            <option selected="" value="0"><?php echo $text_disable; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_delivery; ?></td>
                <td>
                    <select  name="template_setting[<?php echo $template_setting_id ?>][delivery]">
                        <?php if(isset($template_setting['delivery']) && $template_setting['delivery'] == 'delivery'){ ?>
                            <option selected="" value="delivery"><?php echo $text_enable; ?></option>
                            <option value="0"><?php echo $text_disable; ?></option>
                        <?php }else{ ?>
                            <option value="delivery"><?php echo $text_enable; ?></option>
                            <option selected="" value="0"><?php echo $text_disable; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_offer_available_true; ?></td>
                <td>
                    <?php if($stock_statuses){ ?>
                        <div class="scrollbox" style="height: 70px; overflow-y: auto">
                            <?php foreach($stock_statuses as $stock_status_id=>$stock_status){ ?>
                                <div>
                                    <?php if(isset($template_setting['available_true']) && $template_setting['available_true'] == $stock_status_id){ ?>
                                        <input type="radio" checked="" name="template_setting[<?php echo $template_setting_id ?>][available_true]" value="<?php echo $stock_status_id ?>" />
                                        <?php echo $stock_status['name']; ?>
                                    <?php }else{ ?>
                                        <input type="radio" name="template_setting[<?php echo $template_setting_id ?>][available_true]" value="<?php echo $stock_status_id ?>" />
                                        <?php echo $stock_status['name']; ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php }else{ ?>
                        <div class="alert-info" align="center"><?php echo $text_template_setting_offer_stock_statuses_empty ?></div>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_offer_available_false; ?></td>
                <td>
                    <?php if($stock_statuses){ ?>
                        <div class="scrollbox" style="height: 70px; overflow-y: auto">
                            <?php foreach($stock_statuses as $stock_status_id=>$stock_status){ ?>
                                <div>
                                    <?php if(isset($template_setting['available_false'][$stock_status_id])){ ?>
                                        <input checked="" type="checkbox" name="template_setting[<?php echo $template_setting_id ?>][available_false][<?php echo $stock_status_id ?>]" value="<?php echo $stock_status_id ?>" />
                                        <?php echo $stock_status['name']; ?>
                                    <?php }else{ ?>
                                        <input type="checkbox" name="template_setting[<?php echo $template_setting_id ?>][available_false][<?php echo $stock_status_id ?>]" value="<?php echo $stock_status_id ?>" />
                                        <?php echo $stock_status['name']; ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php }else{ ?>
                        <div class="alert-info" align="center"><?php echo $text_template_setting_offer_stock_statuses_empty ?></div>
                    <?php } ?>
                </td>
            </tr>
            
            
            <tr>
                <td><?php echo $text_template_setting_dispublic_quantity; ?></td>
                <td>
                    <select name="template_setting[<?php echo $template_setting_id ?>][dispublic]" >
                        
                        <?php if((isset($template_setting['dispublic']) && !$template_setting['dispublic']) || !isset($template_setting['dispublic'])){ ?>
                            <option selected=""  value="0"><?php echo $text_enable; ?></option>
                            <option value="1"><?php echo $text_disable; ?></option>
                        <?php }else{ ?>
                            <option value="0"><?php echo $text_enable; ?></option>
                            <option selected="" value="1"><?php echo $text_disable; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            
            
            <tr>
                <td><?php echo $text_template_setting_delivery_options; ?></td>
                <td>
                    <select name="template_setting[<?php echo $template_setting_id ?>][delivery-options][status]" onchange="if(this.value!=0){ $('#template_setting_delivery-options<?php echo $template_setting_id ?>').show() }else{ $('#template_setting_delivery-options<?php echo $template_setting_id ?>').hide() }" >
                        <?php $template_setting_delivery_options_css = "display:none"; ?>
                        <?php if(isset($template_setting['delivery-options']['status']) && $template_setting['delivery-options']['status'] == 'delivery-options'){ ?>
                            <?php $template_setting_delivery_options_css = "display:block"; ?>
                            <option selected=""  value="delivery-options"><?php echo $text_enable; ?></option>
                            <option value="0"><?php echo $text_disable; ?></option>
                        <?php }else{ ?>
                            <option value="delivery-options"><?php echo $text_enable; ?></option>
                            <option selected="" value="0"><?php echo $text_disable; ?></option>
                        <?php } ?>
                    </select>
                    <div id="template_setting_delivery-options<?php echo $template_setting_id ?>" style="margin-top: 5px; <?php echo $template_setting_delivery_options_css ?>">
                    <div style="border-left: 2px solid #cccccc; padding-left: 7px; margin-bottom: 10px; background: cornsilk"><?php echo $text_template_setting_delivery_options_help; ?></div>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <td>cost</td>
                            <td>days</td>
                            <td>order-before</td>
                        </thead>
                        <?php for($i=0;$i<5;$i++){ ?>
                        <?php
                        $cost = '';
                        $days = '';
                        $order_before = '';
                        if( isset($template_setting['delivery-options'][$i]['cost']) ){
                            $cost = $template_setting['delivery-options'][$i]['cost'];
                        }
                        if( isset($template_setting['delivery-options'][$i]['order-before']) ){
                            $order_before = $template_setting['delivery-options'][$i]['order-before'];
                        }
                        if( isset($template_setting['delivery-options'][$i]['days']) ){
                            $days = $template_setting['delivery-options'][$i]['days'];
                        }
                        ?>
                        <tr>
                            <td><input value="<?php echo $cost ?>" name="template_setting[<?php echo $template_setting_id ?>][delivery-options][<?php echo $i ?>][cost]" /></td>
                            <td><input value="<?php echo $days ?>" name="template_setting[<?php echo $template_setting_id ?>][delivery-options][<?php echo $i ?>][days]" /></td>
                            <td><input value="<?php echo $order_before ?>" name="template_setting[<?php echo $template_setting_id ?>][delivery-options][<?php echo $i ?>][order-before]" /></td>
                        </tr>
                        <?php } ?> 
                    </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_country_of_origin; ?></td>
                <td>
                    <div class="template_setting_country_of_origin<?php echo $template_setting_id ?>"></div>
                    <script type="text/javascript"><!--

                    $(document).ready(function() {
                        getTemplateSettingFields(<?php echo $template_setting_id ?>,'country_of_origin');
                    });

                    //--></script>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_barcode; ?></td>
                <td>
                    <div class="template_setting_barcode<?php echo $template_setting_id ?>"></div>
                    <script type="text/javascript"><!--

                    $(document).ready(function() {
                        getTemplateSettingFields(<?php echo $template_setting_id ?>,'barcode');
                    });

                    //--></script>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_expiry; ?></td>
                <td>
                    <div class="template_setting_expiry<?php echo $template_setting_id ?>"></div>
                    <script type="text/javascript"><!--

                    $(document).ready(function() {
                        getTemplateSettingFields(<?php echo $template_setting_id ?>,'expiry');
                    });

                    //--></script>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_weight; ?></td>
                <td>
                    <div class="template_setting_weight<?php echo $template_setting_id ?>"></div>
                    <script type="text/javascript"><!--

                    $(document).ready(function() {
                        getTemplateSettingFields(<?php echo $template_setting_id ?>,'weight');
                    });

                    //--></script>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_dimensions; ?></td>
                <td>
                    <div class="template_setting_dimensions<?php echo $template_setting_id ?>"></div>
                    <script type="text/javascript"><!--

                    $(document).ready(function() {
                        getTemplateSettingFields(<?php echo $template_setting_id ?>,'dimensions');
                    });

                    //--></script>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_typePrefix; ?></td>
                <td>
                    <div class="template_setting_typePrefix<?php echo $template_setting_id ?>"></div>
                    <script type="text/javascript"><!--

                    $(document).ready(function() {
                        getTemplateSettingFields(<?php echo $template_setting_id ?>,'typePrefix');
                    });

                    //--></script>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_age; ?></td>
                <td>
                    <div class="template_setting_age<?php echo $template_setting_id ?>"></div>
                    <script type="text/javascript"><!--

                    $(document).ready(function() {
                        getTemplateSettingFields(<?php echo $template_setting_id ?>,'age');
                    });

                    //--></script>
                    <select name="template_setting[<?php echo $template_setting_id ?>][age][unit]">
                        <?php if(isset($template_setting['age']['unit']) && $template_setting['age']['unit'] == 'month'){ ?>
                            <option value="0"><?php echo $text_need_select; ?></option>
                            <option selected="" value="month"><?php echo $text_template_setting_age_unit_month; ?></option>
                            <option value="year"><?php echo $text_template_setting_age_unit_year; ?></option>
                        <?php }elseif(isset($template_setting['age']['unit']) && $template_setting['age']['unit'] == 'year'){ ?>
                            <option value="0"><?php echo $text_need_select; ?></option>
                            <option value="month"><?php echo $text_template_setting_age_unit_month; ?></option>
                            <option selected="" value="year"><?php echo $text_template_setting_age_unit_year; ?></option>
                        <?php }else{ ?>
                            <option value="0"><?php echo $text_need_select; ?></option>
                            <option value="month"><?php echo $text_template_setting_age_unit_month; ?></option>
                            <option value="year"><?php echo $text_template_setting_age_unit_year; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_cpa; ?></td>
                <td>
                    <select  name="template_setting[<?php echo $template_setting_id ?>][cpa]">
                        <?php if(isset($template_setting['cpa']) && $template_setting['cpa'] == 'cpa'){ ?>
                            <option selected=""  value="cpa"><?php echo $text_enable; ?></option>
                            <option value="0"><?php echo $text_disable; ?></option>
                        <?php }else{ ?>
                            <option value="cpa"><?php echo $text_enable; ?></option>
                            <option selected="" value="0"><?php echo $text_disable; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_rec; ?></td>
                <td>
                    <select  name="template_setting[<?php echo $template_setting_id ?>][rec]">
                        <?php if(isset($template_setting['rec']) && $template_setting['rec'] == 'rec'){ ?>
                            <option selected=""  value="rec"><?php echo $text_enable; ?></option>
                            <option value="0"><?php echo $text_disable; ?></option>
                        <?php }else{ ?>
                            <option value="rec"><?php echo $text_enable; ?></option>
                            <option selected="" value="0"><?php echo $text_disable; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_manufacturer_warranty; ?></td>
                <td>
                    <select  name="template_setting[<?php echo $template_setting_id ?>][manufacturer_warranty]">
                        <?php if(isset($template_setting['manufacturer_warranty']) && $template_setting['manufacturer_warranty'] == 'manufacturer_warranty'){ ?>
                            <option selected=""  value="manufacturer_warranty"><?php echo $text_enable; ?></option>
                            <option value="0"><?php echo $text_disable; ?></option>
                        <?php }else{ ?>
                            <option value="manufacturer_warranty"><?php echo $text_enable; ?></option>
                            <option selected="" value="0"><?php echo $text_disable; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            
            
            <tr>
                <td><?php echo $text_template_setting_adult; ?></td>
                <td>
                    <select  name="template_setting[<?php echo $template_setting_id ?>][adult]">
                        <?php if(isset($template_setting['adult']) && $template_setting['adult'] == 'adult'){ ?>
                            <option selected="" value="adult"><?php echo $text_enable; ?></option>
                            <option  value="0"><?php echo $text_disable; ?></option>
                        <?php }else{ ?>
                            <option value="adult"><?php echo $text_enable; ?></option>
                            <option selected="" value="0"><?php echo $text_disable; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_no_pictures; ?></td>
                <td>
                    <select  name="template_setting[<?php echo $template_setting_id ?>][no_pictures]">
                        <?php if(isset($template_setting['no_pictures']) && $template_setting['no_pictures'] == 'no_pictures'){ ?>
                            <option selected="" value="no_pictures"><?php echo $text_enable; ?></option>
                            <option  value="0"><?php echo $text_disable; ?></option>
                        <?php }else{ ?>
                            <option value="no_pictures"><?php echo $text_enable; ?></option>
                            <option selected="" value="0"><?php echo $text_disable; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_pictures_sizes; ?></td>
                <td>
                    <input value="<?php if(isset($template_setting['pictures_sizes'])){ echo $template_setting['pictures_sizes']; } ?>" name="template_setting[<?php echo $template_setting_id ?>][pictures_sizes]" /> px
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_count_pictures; ?></td>
                <td>
                    <select  name="template_setting[<?php echo $template_setting_id ?>][count_pictures]">
                        <?php for($i=1;$i<10;$i++){ ?>
                            <?php if(isset($template_setting['count_pictures']) && $template_setting['count_pictures'] == $i){ ?>
                                <option selected="" value="<?php echo $i ?>"><?php echo $i ?></option>
                            <?php }else{ ?>
                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                            <?php } ?>
                        <?php } ?>
                        <option value="0">0</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_oldprice; ?></td>
                <td>
                    <select  name="template_setting[<?php echo $template_setting_id ?>][oldprice]">
                        <?php if(isset($template_setting['oldprice']) && $template_setting['oldprice'] == 'oldprice'){ ?>
                            <option selected="" value="oldprice"><?php echo $text_enable; ?></option>
                            <option value="0"><?php echo $text_disable; ?></option>
                        <?php }else{ ?>
                            <option value="oldprice"><?php echo $text_enable; ?></option>
                            <option selected="" value="0"><?php echo $text_disable; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td><?php echo $text_template_setting_attribute_sintaxis; ?></td>
                <td>
                    <select  name="template_setting[<?php echo $template_setting_id ?>][attribute_sintaxis]">
                        <?php if(isset($template_setting['attribute_sintaxis']) && $template_setting['attribute_sintaxis'] == 'attribute_sintaxis'){ ?>
                            <option selected="" value="attribute_sintaxis"><?php echo $entry_template_setting_attribute_sintaxis_1; ?></option>
                            <option value="0"><?php echo $entry_template_setting_attribute_sintaxis_0; ?></option>
                        <?php }else{ ?>
                            <option value="attribute_sintaxis"><?php echo $entry_template_setting_attribute_sintaxis_1; ?></option>
                            <option selected="" value="0"><?php echo $entry_template_setting_attribute_sintaxis_0; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td><?php echo $text_template_setting_ymlprice; ?></td>
                <td>
                    <input value="<?php if(isset($template_setting['ymlprice'])){ echo $template_setting['ymlprice']; } ?>" name="template_setting[<?php echo $template_setting_id ?>][ymlprice]" /> %
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_sales_notes; ?></td>
                <td>
                    <input value="<?php if(isset($template_setting['sales_notes'])){ echo $template_setting['sales_notes']; } ?>" name="template_setting[<?php echo $template_setting_id ?>][sales_notes]" />
                </td>
            </tr>
            <tr>
                <td><?php echo $text_template_setting_status; ?></td>
                <td>
                    <select  name="template_setting[<?php echo $template_setting_id ?>][status]">
                        <?php if(isset($template_setting['status']) && $template_setting['status'] == '1'){ ?>
                            <option selected="" value="1"><?php echo $text_enable; ?></option>
                            <option value="0"><?php echo $text_disable; ?></option>
                            <option value="2"><?php echo $text_delete; ?></option>
                        <?php }else{ ?>
                            <option value="1"><?php echo $text_enable; ?></option>
                            <option selected="" value="0"><?php echo $text_disable; ?></option>
                            <option value="2"><?php echo $text_delete; ?></option>
                        <?php } ?> ?>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
</div>