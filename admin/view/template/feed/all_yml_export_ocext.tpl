<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
              <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
              <?php foreach ($breadcrumbs as $breadcrumb) { ?>
              <li><a  href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
              <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
    <style>
        .small_text{
            font-size: 9px;
            color: darkgray;
        }
        .small_text:hover{
            font-size: 9px;
            color: black;
        }
        .scrollbox div:nth-child(2n+1){
           background: lemonchiffon;
        }
        .scrollbox table tbody tr td div:nth-child(2n+1){
           background: none;
        }
        .
        
    </style>
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
        <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        
    <div class="panel panel-default">
    
    <div class="panel-body">
        
        <ul  class="nav nav-tabs" >
            <li class="active"><a  data-toggle="tab"  href="#tab-template-setting" ><?php echo $tab_template_setting; ?></a></li>
            <li><a  data-toggle="tab"  href="#tab-ym-categories" ><?php echo $tab_ym_categories; ?></a></li>
            <li><a  data-toggle="tab"  href="#tab-ym-filter-data" onclick="openYmFilterData();"><?php echo $tab_ym_filter_data; ?></a></li>
            <li><a  data-toggle="tab" href="#tab-setting"  ><?php echo $tab_general; ?></a></li>
        </ul>
        
        <div class="tab-content">
            
        <div id="tab-ym-categories" class="tab-pane" >
            <div align="right">
                <a onclick="$('#form-ym-categories').submit();" type="submit" form="form-ups" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>  <?php echo $button_save; ?></a>
                <br><br>
            </div>
            
            <!--=============filter=================-->
            <form action="<?php echo $action_ym_categories_filter; ?>" method="post" enctype="multipart/form-data" id="form-ym-categories-filter">
            <div class="well">
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="ym_category_last_child"><?php echo $text_ym_categories_filter_ym_category_last_child; ?></label>
                  <input type="text" name="ym_category_last_child" value="<?php echo $ym_category_last_child; ?>" placeholder="<?php echo $text_ym_categories_filter_ym_category_last_child; ?>" id="ym_category_last_child" class="form-control" />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="filter_category_id"><?php echo $text_ym_categories_filter_category_id; ?></label>
                  <select name="filter_category_id" id="category_id" class="form-control">
                    <option value=""><?php echo $text_ym_categories_filter_category_id_; ?></option>
                    <?php if ($filter_category_id) { ?>
                        <option value="1" selected="selected"><?php echo $text_ym_categories_filter_category_id_1; ?></option>
                    <?php }else{ ?>
                        <option value="1" ><?php echo $text_ym_categories_filter_category_id_1; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="filter_ym_status"><?php echo $text_ym_categories_filter_status; ?></label>
                  <select name="filter_ym_status" id="ym_status" class="form-control">
                    <option value=""><?php echo $text_ym_categories_filter_status_; ?></option>
                    <?php if ($filter_ym_status==='0') { ?>
                        <option value="0" selected="selected"><?php echo $text_ym_categories_filter_status_1; ?></option>
                        <option value="1" ><?php echo $text_ym_categories_filter_status_2; ?></option>
                    <?php }elseif ($filter_ym_status==1){ ?>
                        <option value="0" ><?php echo $text_ym_categories_filter_status_1; ?></option>
                        <option value="1" selected="selected"><?php echo $text_ym_categories_filter_status_2; ?></option>
                    <?php }else{ ?>
                        <option value="0" ><?php echo $text_ym_categories_filter_status_1; ?></option>
                        <option value="1" ><?php echo $text_ym_categories_filter_status_2; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <a onclick="$('#form-ym-categories-filter').submit();" title="<?php echo $button_filter; ?>" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></a>
              </div>
            </div>
          </div>
        </form>
            <!--=============endFilter=================-->
            
            <form action="<?php echo $action_ym_categories; ?>" method="post" enctype="multipart/form-data" id="form-ym-categories">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                            <td class="text-left">
                                <?php echo $column_ym_category_path; ?>
                            </td>
                            <td class="text-left">
                                <?php echo $column_ym_category_last_child; ?>
                            </td>
                            <td class="text-left">
                                <?php echo $column_category_id; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $column_ym_status; ?> <input type="checkbox" onclick="if(this.checked==true){ $('input[value=\'1\']').prop('checked', this.checked); }else{ $('input[value=\'0\']').prop('checked', true); }" />
                            </td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if ($ym_categories) { ?>
                        <?php foreach ($ym_categories as $ym_category) { ?>
                        <tr>
                          <td class="text-left"><?php echo $ym_category['ym_category_path']; ?></td>
                          <td class="text-left"><?php echo $ym_category['ym_category_last_child']; ?></td>
                          <td class="text-left">
                                <input onkeyup="getCategories(<?php echo $ym_category['ym_category_id'] ?>,this.value)" />
                                <div id="ym_categories_categories_place_<?php echo $ym_category['ym_category_id'] ?>"></div>
                                <div class="form-control" id="ym_categories_categories_place_checked_<?php echo $ym_category['ym_category_id'] ?>" style="border-top:1px solid #ccc; min-height: 20px; margin-top: 7px; height: auto; max-height: 150px; overflow-y: auto"></div>
                                <a style="margin-top: 5px; display: none;" id="ym_categories_save_<?php echo $ym_category['ym_category_id'] ?>" onclick="$('#form-ym-categories').submit();" type="submit" form="form-ups" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>  <?php echo $button_save; ?></a>
                                <script type="text/javascript"><!--

                                    $(document).ready(function() {
                                        getCategories(<?php echo $ym_category['ym_category_id'] ?>,'');
                                    });

                                //--></script>
                          </td>
                          <td class="text-left"><?php if ($ym_category['status']) { ?>
                            <input type="radio" name="ym_status[<?php echo $ym_category['ym_category_id']; ?>]" value="1" checked="checked" /> <?php echo $text_ym_status_1; ?>
                            <br><input type="radio" name="ym_status[<?php echo $ym_category['ym_category_id']; ?>]" value="0" /> <?php echo $text_ym_status_0; ?>
                            <?php } else { ?>
                            <input type="radio" name="ym_status[<?php echo $ym_category['ym_category_id']; ?>]" value="1"  /> <?php echo $text_ym_status_1; ?>
                            <br><input type="radio" name="ym_status[<?php echo $ym_category['ym_category_id']; ?>]" value="0" checked="checked" /> <?php echo $text_ym_status_0; ?>
                            <?php } ?>
                          </td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                          <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
            </form>
            <div class="row">
                <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                <div class="col-sm-6 text-right"><?php echo $results; ?></div>
            </div>
        </div>
            
        <div id="tab-ym-filter-data" class="tab-pane" >
            <div align="right">
                <a onclick="$('#form-ym-filter-data').submit();" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>  <?php echo $button_save; ?></a>
                <br><br>
            </div>
            <form action="<?php echo $action_ym_filter_data; ?>" method="post" enctype="multipart/form-data" id="form-ym-filter-data">
                
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <tbody>
                            <tr>
                                <td class="text-left">
                                    <?php echo $text_ym_filter_data_categories; ?>
                                </td>
                                <td class="text-left" width='65%'>
                                    <div id="ym_filter_data_place_categories"></div>
                                    <script type="text/javascript"><!--

                                        $(document).ready(function() {
                                            
                                        });

                                    //--></script>
                                </td>
                            </tr>
                          </tbody>
                        </table>
                    </div> 
                <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <tbody>
                            <tr>
                                <td class="text-left">
                                    <?php echo $text_ym_filter_data_manufacturers; ?>
                                </td>
                                <td class="text-left" width='65%'>
                                    <div id="ym_filter_data_place_manufacturers"></div>
                                    <script type="text/javascript"><!--

                                        $(document).ready(function() {
                                            
                                        });

                                    //--></script>
                                </td>
                            </tr>
                          </tbody>
                        </table>
                    </div>  
                <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <tbody>
                            <tr>
                                <td class="text-left">
                                    <?php echo $text_ym_filter_data_attributes; ?>
                                </td>
                                <td class="text-left" width='65%'>
                                    <div id="ym_filter_data_place_attributes"></div>
                                    <script type="text/javascript"><!--

                                        $(document).ready(function() {
                                            
                                        });

                                    //--></script>
                                </td>
                            </tr>
                          </tbody>
                        </table>
                    </div>  
                <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <tbody>
                            <tr>
                                <td class="text-left">
                                    <?php echo $text_ym_filter_data_options; ?>
                                </td>
                                <td class="text-left" width='65%'>
                                    <div id="ym_filter_data_place_options"></div>
                                    <script type="text/javascript"><!--

                                        $(document).ready(function() {
                                            
                                        });

                                    //--></script>
                                </td>
                            </tr>
                          </tbody>
                        </table>
                    </div>  
                
            </form>
        </div>
            
            
            
            
        <div id="tab-template-setting" class="tab-pane active" >
            <form id="form-template-setting" action="<?php echo $action_template_setting; ?>" method="post" enctype="multipart/form-data">
            <div align="right">
                <a onclick="$('#form-template-setting').submit();" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>  <?php echo $button_save; ?></a>
            <br><br>
            </div>
                <div class="small_text" style="margin-bottom: 10px;"><?php echo $tab_template_setting_help ?></div>
            
            
            <div class="row">
                <div class="col-sm-2">
                    <ul class="nav nav-pills nav-stacked" id="tab-pvz-rows-tabs">
                        <li onclick="$('#form-template-setting').attr('action','<?php echo $action_template_setting; ?>'+'&template_setting_id=0')" class="active"><a data-toggle="tab" id='tab-template_setting_nav0' href="#tab-template_setting0"> <?php echo $tab_new_template_setting; ?></a></li>
                        <?php if($templates_setting){ ?>
                        
                            <?php foreach($templates_setting as $template_setting_id => $template_setting_tab){ ?>
                            
                            <?php
                                $css_template_setting = '';
                                if($template_setting_tab['status']){
                                    $css_template_setting = 'border-left:3px solid #1eff00;';
                                }else{
                                    $css_template_setting = 'border-left:3px solid #cccccc;';
                                }
                            ?>
                            <li onclick="$('#form-template-setting').attr('action','<?php echo $action_template_setting; ?>'+'&template_setting_id=<?php echo $template_setting_id;?>')"><a data-toggle="tab" id='tab-template_setting_nav<?php echo $template_setting_id;?>' style="<?php echo $css_template_setting; ?>" href="#tab-template_setting<?php echo $template_setting_id;?>"> <?php echo $template_setting_tab['title']; ?></a></li>
                            
                            <?php } ?>
                            
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-sm-10">				
                    <div class="tab-content">
                        <?php $template_setting_id = 0; ?>
                        <?php $template_setting = array(); ?>
                        <!--==============form==============-->
                        <?php include DIR_APPLICATION.'/view/template/feed/all_yml_export_ocext_template_setting_form.tpl'; ?>
                        <!--==============formEnd==============-->
                        <?php if($templates_setting){ ?>
                            <?php foreach($templates_setting as $template_setting_id => $template_setting){ ?>
                                <!--==============form==============-->
                                <?php include DIR_APPLICATION.'/view/template/feed/all_yml_export_ocext_template_setting_form.tpl'; ?>
                                <!--==============formEnd==============-->
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            </form>
        </div>
         
            
            <div id="tab-setting" class="tab-pane" >
                <div align="right">
                    <a onclick="$('#form-general-setting').submit();" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>  <?php echo $button_save; ?></a>
                    <br><br>
                </div>

                <form action="<?php echo $action_general_setting; ?>" method="post" enctype="multipart/form-data" id="form-general-setting">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td><?php echo $text_general_setting_status; ?></td>
                            <td>
                                <select name="ayeogs_status">
                                    <?php if ($ayeogs_status) { ?>
                                        <option value="1" selected="selected"><?php echo $text_general_setting_enable; ?></option>
                                        <option value="0"><?php echo $text_general_setting_disable; ?></option>
                                    <?php } else { ?>
                                        <option value="1"><?php echo $text_general_setting_enable; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_general_setting_disable; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $text_general_setting_name; ?></td>
                            <td>
                                <input name="ayeogs_name" value='<?php echo $ayeogs_name ?>'/>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $text_general_setting_company; ?></td>
                            <td>
                                <input name="ayeogs_company" value='<?php echo $ayeogs_company ?>'/>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $text_general_setting_currencies; ?></td>
                            <td>
                                <select name="ayeogs_currencies">
                                    <option <?php if(!$ayeogs_currencies){ ?> selected="" <?php } ?> value="0"><?php echo $text_need_select ?></option>
                                    <option <?php if($ayeogs_currencies && $ayeogs_currencies=='EUR'){ ?> selected="" <?php } ?> value="EUR">EUR</option>
                                    <option <?php if($ayeogs_currencies && $ayeogs_currencies=='KZT'){ ?> selected="" <?php } ?> value="KZT">KZT</option>
                                    <option <?php if($ayeogs_currencies && $ayeogs_currencies=='RUB'){ ?> selected="" <?php } ?> value="RUB">RUB</option>
                                    <option <?php if($ayeogs_currencies && $ayeogs_currencies=='UAH'){ ?> selected="" <?php } ?> value="UAH">UAH</option>
                                    <option <?php if($ayeogs_currencies && $ayeogs_currencies=='USD'){ ?> selected="" <?php } ?> value="USD">USD</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $text_general_setting_filename_export; ?>
                                <br><?php echo $text_general_setting_copy  ?>: <input style="width:60%"  readonly="" class="form-control" onclick="$(this).select()" value="<?php echo HTTP_CATALOG.''.$ayeogs_filename_export.'.xml' ?>"/>
                            </td>
                            <td>
                                <?php echo HTTP_CATALOG.''; ?><input name="ayeogs_filename_export" value='<?php echo $ayeogs_filename_export ?>'/>.xml
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $text_general_setting_path_token_export; ?>
                                <br><?php echo $text_general_setting_copy  ?>: <input style="width:60%"  class="form-control"  readonly="" onclick="$(this).select()" value="<?php echo HTTP_CATALOG.'index.php?route=feed/ocext_yamarket&token='.$ayeogs_path_token_export ?>"/>
                            </td>
                            <td>
                                <?php echo HTTP_CATALOG.'index.php?route=feed/ocext_yamarket&token='; ?><input name="ayeogs_path_token_export" value='<?php echo $ayeogs_path_token_export ?>'/>
                                <?php if($ayeogs_path_token_export_link){ ?>
                                    <br><b style="color:red"><?php echo $ayeogs_path_token_export_link ?></b>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $text_general_setting_platform; ?></td>
                            <td>
                                <input name="ayeogs_platform" value='<?php echo $ayeogs_platform ?>'/>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $text_general_setting_version; ?></td>
                            <td>
                                <input name="ayeogs_version" value='<?php echo $ayeogs_version ?>'/>
                            </td>
                        </tr>
                        
                    </table>
                </form>
                
                <hr>
                <?php if ((!$error_warning) && (!$success)) { ?>
                <div id="ocext_notification" class="alert alert-info"><i class="fa fa-info-circle"></i>
                        <div id="ocext_loading"><img src="<?php echo HTTP_SERVER; ?>/view/image/ocext/loading.gif" /></div>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                <?php } ?>
                
            </div>        
        
        </div>
        
    </div>        
    </div>
</div>
</div>
<script type="text/javascript"><!--
    



$(document).ready(function() {
    $("a[href=\'#<?php echo $open_tab ?>\']").click();
    
    if('<?php echo $open_tab ?>'=='tab-ym-filter-data'){
        //openYmFilterData();
    }
    
});
var openYmFilterDataLoad = false;
function openYmFilterData(){
    if(openYmFilterDataLoad==false){
        getYmFilterData('categories');
        getYmFilterData('manufacturers');
        getYmFilterData('options');
        getYmFilterData('attributes');
    }
    openYmFilterDataLoad = true;
} 

function  templateSettingOfferComposite(value_selected,tamplate_setting_id,num_element){
    $('.template_setting_offer_composite'+tamplate_setting_id+num_element).hide();
    if(value_selected=='attribute_id' || value_selected=='category_id' || value_selected=='option_id'){
        $('#template_setting_offer_composite_'+value_selected+tamplate_setting_id+num_element).show();
    }
}
function  templateSettingFields(value_selected,tamplate_setting_id,name_field){
    $('.template_setting_fields'+tamplate_setting_id+name_field).hide();
    if(value_selected=='attribute_id' || value_selected=='category_id' || value_selected=='option_id'){
        $('#template_setting_fields_'+value_selected+tamplate_setting_id+name_field).show();
    }
}


var template_setting_name_composite_num_elements = [];

function addNewCompositeElement(tamplate_setting_id,get_num_element){
    if(typeof template_setting_name_composite_num_elements[tamplate_setting_id] == 'undefined'){
        template_setting_name_composite_num_elements[tamplate_setting_id] = 1;   
    }
    if(get_num_element==0){
        template_setting_name_composite_num_element = template_setting_name_composite_num_elements[tamplate_setting_id];
    }else{
        template_setting_name_composite_num_elements[tamplate_setting_id] = get_num_element;
        template_setting_name_composite_num_element = template_setting_name_composite_num_elements[tamplate_setting_id];
    }
    $('.template_setting_name_composite_new_element_place'+tamplate_setting_id).before('<div id="ocext_loading'+tamplate_setting_id+'"><img src="<?php echo HTTP_SERVER; ?>/view/image/ocext/loading.gif" /></div>');
    $.ajax({
            type: 'GET',
            url: 'index.php?route=feed/all_yml_export_ocext/getNewCompositeElement&template_setting_name_composite_num_element='+template_setting_name_composite_num_element+'&tamplate_setting_id='+tamplate_setting_id+'&token=<?php echo $token; ?>',
            dataType: 'html',
            success: function(response) {
                $('.template_setting_name_composite_new_element_place'+tamplate_setting_id).before(response);
                template_setting_name_composite_num_elements[tamplate_setting_id] += 1;
                $('#ocext_loading'+tamplate_setting_id).remove();
            },
            failure: function(){
                    
            },
            error: function() {
                    
            }
    });
}

function getYmFilterData(type_data){
    $('#ym_filter_data_place_'+type_data).empty();
    $('#ym_filter_data_place_'+type_data).before('<div id="ocext_loading_ym_filter_data_'+type_data+'"><img src="<?php echo HTTP_SERVER; ?>/view/image/ocext/loading.gif" /></div>');
    $.ajax({
            type: 'GET',
            url: 'index.php?route=feed/all_yml_export_ocext/getYmFilterData&'+type_data+'=1&token=<?php echo $token; ?>',
            dataType: 'html',
            success: function(response) {
                $('#ocext_loading_ym_filter_data_'+type_data).remove();
                $('#ym_filter_data_place_'+type_data).html(response);
                
            },
            failure: function(response){
                    //alert(response);
            },
            error: function(response) {
                    //alert(response);
            }
    });
}

function getCategories(ym_category_id,filter_name){
    $('#ym_categories_categories_place_'+ym_category_id).empty();
    $('#ym_categories_categories_place_'+ym_category_id).before('<div id="ocext_loading_ym_categories_categories'+ym_category_id+'"><img src="<?php echo HTTP_SERVER; ?>/view/image/ocext/loading.gif" /></div>');
    $.ajax({
            type: 'GET',
            url: 'index.php?route=feed/all_yml_export_ocext/getCategories&filter_name='+filter_name+'&ym_category_id='+ym_category_id+'&token=<?php echo $token; ?>',
            dataType: 'html',
            success: function(response) {
                $('#ocext_loading_ym_categories_categories'+ym_category_id).remove();
                $('#ym_categories_categories_place_'+ym_category_id).html(response);
                
            },
            failure: function(response){
                    //alert(response);
            },
            error: function(response) {
                    //alert(response);
            }
    });
}

function getTemplateSettingFields(tamplate_setting_id,name_field){
    
    $('.template_setting_'+name_field+tamplate_setting_id).before('<div id="ocext_loading'+name_field+tamplate_setting_id+'"><img src="<?php echo HTTP_SERVER; ?>/view/image/ocext/loading.gif" /></div>');
    $.ajax({
            type: 'GET',
            url: 'index.php?route=feed/all_yml_export_ocext/getTemplateSettingFields&name_field='+name_field+'&tamplate_setting_id='+tamplate_setting_id+'&token=<?php echo $token; ?>',
            dataType: 'html',
            success: function(response) {
                
                $('#ocext_loading'+name_field+tamplate_setting_id).remove();
                $('.template_setting_'+name_field+tamplate_setting_id).before(response);
            },
            failure: function(response){
                    //alert(response);
            },
            error: function(response) {
                    //alert(response);
            }
    });
}

function moveElementTo(elementFrom,elementTo,elementFromDIV,ym_category_id){
    if($(elementFrom).prop("checked")==true){
        $('.'+elementFromDIV).remove();
        $('#'+elementFromDIV).addClass(elementFromDIV);
        $('#'+elementFromDIV).appendTo(elementTo);
        if(ym_category_id!=0){
            $('#ym_categories_save_'+ym_category_id).show();
        }
        
    }else{
        $(elementFromDIV).remove();
        if(ym_category_id!=0){
            $('#ym_categories_save_'+ym_category_id).show();
        }
    }
}

function getNotifications() {
	$.ajax({
            type: 'GET',
            url: 'index.php?route=feed/all_yml_export_ocext/getNotifications&token=<?php echo $token; ?>',
            dataType: 'json',
            success: function(json) {
                    if (json['error']) {
                            $('#ocext_notification').html('<i class="fa fa-info-circle"></i><button type="button" class="close" data-dismiss="alert">&times;</button> '+json['error']);
                    } else if (json['message'] && json['message']!='' ) {
                            $('#ocext_notification').html('<i class="fa fa-info-circle"></i><button type="button" class="close" data-dismiss="alert">&times;</button> '+json['message']);
                    }else{
                        $('#ocext_notification').remove();
                    }
            },
            failure: function(){
                    $('#ocext_notification').remove();
            },
            error: function() {
                    $('#ocext_notification').remove();
            }
    });
}
getNotifications();

//--></script> 
<?php echo $footer; ?>