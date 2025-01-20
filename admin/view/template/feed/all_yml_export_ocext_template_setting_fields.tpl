 <!--==================Clone===============-->
<select name="template_setting[<?php echo $tamplate_setting_id ?>][<?php echo $name_field ?>][field][status]" onchange="templateSettingFields(this.value,'<?php echo $tamplate_setting_id ?>' ,'<?php echo $name_field ?>')" >
    <option value="0"><?php echo $text_disable ?></option>
    <?php
        
        $template_setting_fields_css['option_id'] = "display:none";
        $template_setting_fields_css['attribute_id'] = "display:none";
        $template_setting_fields_css['category_id'] = "display:none";

    ?>
    <?php foreach($template_setting_fields as $template_setting_field){ ?>
        <?php if(isset($templates_setting[$tamplate_setting_id][$name_field]['field']['status']) && $templates_setting[$tamplate_setting_id][$name_field]['field']['status'] == $template_setting_field){ ?>
            <?php $template_setting_fields_css[$template_setting_field] = ""; ?>
            <option selected="" value="<?php echo $template_setting_field; ?>"><?php if(isset(${'text_template_setting_name_composite_element_'.$template_setting_field})){ echo ${'text_template_setting_name_composite_element_'.$template_setting_field}; }else{ echo $template_setting_field.' '.$text_template_setting_name_composite_element_self; } ?></option>
        <?php }else{ ?>
            <option value="<?php echo $template_setting_field; ?>"><?php if(isset(${'text_template_setting_name_composite_element_'.$template_setting_field})){ echo ${'text_template_setting_name_composite_element_'.$template_setting_field}; }else{ echo $template_setting_field.' '.$text_template_setting_name_composite_element_self; } ?></option>
        <?php } ?>
        
    <?php } ?>
</select>
    
<div class="template_setting_fields<?php echo $tamplate_setting_id.$name_field ?>" id="template_setting_fields_category_id<?php echo $tamplate_setting_id.$name_field ?>" style="border-left: 2px solid #cccccc; padding-left: 7px; background: cornsilk; margin-top: 10px; <?php echo $template_setting_fields_css['category_id'] ?>"><?php echo $text_template_setting_offer_composite_category_id; ?></div>
<table class="table table-bordered table-hover" style="margin-top: 5px; margin-bottom: 0px;">
        <tbody>
        <tr class="template_setting_fields<?php echo $tamplate_setting_id.$name_field ?>" id="template_setting_fields_option_id<?php echo $tamplate_setting_id.$name_field ?>" ddd='<?php var_dump($template_setting_fields_css); ?>' style="<?php echo $template_setting_fields_css['option_id']; ?>">
            <td colspan="2">
                <?php if($options){ ?>
                <div class="scrollbox" style="height: 70px; overflow-y: auto">
                    <?php foreach($options as $option_id=>$option){ ?>

                        <div>
                            
                            
                            <?php if(isset($templates_setting[$tamplate_setting_id][$name_field]['field']['option_id']) && $templates_setting[$tamplate_setting_id][$name_field]['field']['option_id']==$option_id){ ?>
                                <input type="radio" checked="" name="template_setting[<?php echo $tamplate_setting_id ?>][<?php echo $name_field ?>][field][option_id]" value="<?php echo $option_id ?>" />
                                <?php echo $option['name']; ?>
                            <?php }else{ ?>
                                <input type="radio" name="template_setting[<?php echo $tamplate_setting_id ?>][<?php echo $name_field ?>][field][option_id]" value="<?php echo $option_id ?>" />
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
        <tr class="template_setting_fields<?php echo $tamplate_setting_id.$name_field ?>" id="template_setting_fields_attribute_id<?php echo $tamplate_setting_id.$name_field ?>" style="<?php echo $template_setting_fields_css['attribute_id']; ?>">
            <td colspan="2">
                <?php if($attributes){ ?>
                <div class="scrollbox" style="height: 150px; overflow-y: auto; width: 100%">
                    
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
                                
                                <?php if(isset($templates_setting[$tamplate_setting_id][$name_field]['field']['attribute_id']) && $templates_setting[$tamplate_setting_id][$name_field]['field']['attribute_id']==$attribute_group_id.'___'.$attribute_id){ ?>
                                    <input checked="" type="radio" name="template_setting[<?php echo $tamplate_setting_id ?>][<?php echo $name_field ?>][field][attribute_id]" value="<?php echo $attribute_group_id.'___'.$attribute_id ?>" />
                                    <?php echo $attribute['name']; ?>
                                <?php }else{ ?>
                                    <input type="radio" name="template_setting[<?php echo $tamplate_setting_id ?>][<?php echo $name_field ?>][field][attribute_id]" value="<?php echo $attribute_group_id.'___'.$attribute_id ?>" />
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