 <!--==================Clone===============-->
 <table class="table table-bordered table-hover" id="template_setting_name_composite_new_element<?php echo $tamplate_setting_id.$template_setting_name_composite_num_element ?>" style="margin-bottom: 5px;">
        <tbody>
        <tr>
            <td><?php if($template_setting_name_composite_num_element==1){ echo $text_template_setting_name_composite_num_element_first; }else{ echo $text_template_setting_name_composite_num_element_next; } ?></td>
            <td>
                <select name="template_setting[<?php echo $tamplate_setting_id ?>][offer_name][composite][<?php echo $template_setting_name_composite_num_element ?>][status]" onchange="templateSettingOfferComposite(this.value,'<?php echo $tamplate_setting_id ?>' ,'<?php echo $template_setting_name_composite_num_element ?>')">
                    
                    
                    <?php

                        $template_setting_fields_css['option_id'] = "display:none";
                        $template_setting_fields_css['attribute_id'] = "display:none";
                        $template_setting_fields_css['category_id'] = "display:none";

                    ?>
                    
                    
                    <?php foreach($template_setting_name_composite as $template_setting_name_composite_field){ ?>
                    
                        <?php if(isset($templates_setting[$tamplate_setting_id]['offer_name']['composite'][$template_setting_name_composite_num_element]['status']) && $templates_setting[$tamplate_setting_id]['offer_name']['composite'][$template_setting_name_composite_num_element]['status'] == $template_setting_name_composite_field){ ?>
                            <?php $template_setting_fields_css[$template_setting_name_composite_field] = ""; ?>
                            <option selected="" value="<?php echo $template_setting_name_composite_field; ?>"><?php if(isset(${'text_template_setting_name_composite_element_'.$template_setting_name_composite_field})){ echo ${'text_template_setting_name_composite_element_'.$template_setting_name_composite_field}; }else{ echo $template_setting_name_composite_field.' '.$text_template_setting_name_composite_element_self; } ?></option>
                        <?php }else{ ?>
                            <option value="<?php echo $template_setting_name_composite_field; ?>"><?php if(isset(${'text_template_setting_name_composite_element_'.$template_setting_name_composite_field})){ echo ${'text_template_setting_name_composite_element_'.$template_setting_name_composite_field}; }else{ echo $template_setting_name_composite_field.' '.$text_template_setting_name_composite_element_self; } ?></option>
                        <?php } ?>
                    
                    
                    <?php } ?>
                </select>
                <div class="template_setting_offer_composite<?php echo $tamplate_setting_id.$template_setting_name_composite_num_element ?>" id="template_setting_offer_composite_category_id<?php echo $tamplate_setting_id.$template_setting_name_composite_num_element ?>" style="border-left: 2px solid #cccccc; padding-left: 7px; background: cornsilk; margin-top: 10px; <?php echo $template_setting_fields_css['category_id']; ?>"><?php echo $text_template_setting_offer_composite_category_id; ?></div>
            </td>
            <td>
                <button type="button" onclick="$('#template_setting_name_composite_new_element<?php echo $tamplate_setting_id.$template_setting_name_composite_num_element ?>').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title=""><i class="fa fa-minus-circle"></i></button>
            </td>
        </tr>
        <tr class="template_setting_offer_composite<?php echo $tamplate_setting_id.$template_setting_name_composite_num_element ?>" id="template_setting_offer_composite_option_id<?php echo $tamplate_setting_id.$template_setting_name_composite_num_element ?>" style="<?php echo $template_setting_fields_css['option_id']; ?>">
            <td colspan="2">
                <?php if($options){ ?>
                <div class="scrollbox" style="height: 150px; overflow-y: auto">
                    
                    <?php foreach($options as $option_id=>$option){ ?>
                    
                        <div>
                            
                            
                            <?php if(isset($templates_setting[$tamplate_setting_id]['offer_name']['composite'][$template_setting_name_composite_num_element]['option_id']) && $templates_setting[$tamplate_setting_id]['offer_name']['composite'][$template_setting_name_composite_num_element]['option_id']==$option_id){ ?>
                                <input checked="" type="radio" name="template_setting[<?php echo $tamplate_setting_id ?>][offer_name][composite][<?php echo $template_setting_name_composite_num_element ?>][option_id]" value="<?php echo $option_id ?>" />
                                <?php echo $option['name']; ?>
                            <?php }else{ ?>
                                <input type="radio" name="template_setting[<?php echo $tamplate_setting_id ?>][offer_name][composite][<?php echo $template_setting_name_composite_num_element ?>][option_id]" value="<?php echo $option_id ?>" />
                                <?php echo $option['name']; ?>
                            <?php } ?>
                            
                        </div>

                    <?php } ?>
                </div>
                <?php }else{ ?>
                <div class="alert-info" align="center"><?php echo $text_template_setting_offer_composite_option_id_empty ?></div>
                <?php } ?>
            </td>
        </tr>
        <tr class="template_setting_offer_composite<?php echo $tamplate_setting_id.$template_setting_name_composite_num_element ?>" id="template_setting_offer_composite_attribute_id<?php echo $tamplate_setting_id.$template_setting_name_composite_num_element ?>" style="<?php echo $template_setting_fields_css['attribute_id']; ?>">
            <td colspan="2">
                <?php if($attributes){ ?>
                <div class="scrollbox" style="height: 150px; overflow-y: auto">
                    
                    <?php foreach($attributes as $attribute_group_id=>$attribute_group){ ?>

                        <?php if(isset($attribute_group_name)){ ?>
                            <?php unset($attribute_group_name); ?>
                        <?php } ?>

                        <?php foreach($attribute_group as $attribute_id=>$attribute){ ?>
                            
                            <?php if(!isset($attribute_group_name)){ ?>
                                <?php $attribute_group_name = $attribute['attribute_group']; ?>
                                <h4 style="margin-top: 15px; margin-bottom: 10px;"><?php echo $attribute_group_name ?></h4>
                            <?php } ?>

                            <div>
                                
                                
                                <?php if(isset($templates_setting[$tamplate_setting_id]['offer_name']['composite'][$template_setting_name_composite_num_element]['attribute_id']) && $templates_setting[$tamplate_setting_id]['offer_name']['composite'][$template_setting_name_composite_num_element]['attribute_id']==$attribute_group_id.'___'.$attribute_id){ ?>
                                <input checked="" type="radio" name="template_setting[<?php echo $tamplate_setting_id ?>][offer_name][composite][<?php echo $template_setting_name_composite_num_element ?>][attribute_id]" value="<?php echo $attribute_group_id.'___'.$attribute_id ?>" />
                                    <?php echo $attribute['name']; ?>
                                <?php }else{ ?>
                                    <input type="radio" name="template_setting[<?php echo $tamplate_setting_id ?>][offer_name][composite][<?php echo $template_setting_name_composite_num_element ?>][attribute_id]" value="<?php echo $attribute_group_id.'___'.$attribute_id ?>" />
                                    <?php echo $attribute['name']; ?>
                                <?php } ?>
                                
                            </div>

                        <?php } ?>

                    <?php } ?>
                    
                </div>
                <?php }else{ ?>
                <div class="alert-info" align="center"><?php echo $text_template_setting_offer_composite_attribute_id_empty ?></div>
                <?php } ?>
            </td>
        </tr>
        </tbody>
    </table>
                <!--==================CloneEnd===============-->