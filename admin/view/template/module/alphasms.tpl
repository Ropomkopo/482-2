<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-alpha" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title;?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if (!empty($error_warning)) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo (!empty($text_edit)) ? $text_edit : '';?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo (!empty($action)) ? $action : ''; ?>" method="post" id="form-alpha" class="form-horizontal">
                    <div class="tab-pane">
                        <ul class="nav nav-tabs" id="alpha_tabs">
                            <li><a href="#tab-connection" data-toggle="tab"><?php echo $alphasms_tab_connection?></a></li>
                            <li><a href="#tab-events" data-toggle="tab"><?php echo $alphasms_tab_events?></a></li>
                            <li><a href="#tab-sendsms" data-toggle="tab"><?php echo $alphasms_tab_sendsms?></a></li>
                            <li><a href="#tab-templates" data-toggle="tab"><?php echo $alphasms_tab_templates?></a></li>
                            <li><a href="#tab-about" data-toggle="tab"><?php echo $alphasms_tab_about?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="tab-connection">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-10">
                                            <?php echo $alphasms_text_connection_tab_description?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="alpha_login"><?php echo $alphasms_text_login;?> *</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="<?php echo $alphasms_text_login_placeholder;?>" id="alpha_login" name="alphasms_login" value="<?php echo (isset($frm_alphasms_login) ? $frm_alphasms_login : '') ?>" class="form-control" />
                                            <?php if (empty($frm_alphasms_login) || !preg_match("!\+[0-9]{10,14}!si", $frm_alphasms_login)) { $err=$alphasms_error_login;?>
                                            <div class="text-danger"><?php echo $alphasms_error_login; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="alpha_password"><?php echo $alphasms_text_password;?> *</label>
                                        <div class="col-sm-10">
                                            <input type="password" placeholder="<?php echo $alphasms_text_password;?>" id="alpha_password" name="alphasms_password" value="<?php echo (isset($frm_alphasms_password) ? $frm_alphasms_password : '') ?>" class="form-control" />
                                            <?php if (empty($frm_alphasms_password)) { $err.='<br>'.$alphasms_error_password?>
                                            <div class="text-danger"><?php echo $alphasms_error_password; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="alpha_key"><?php echo $alphasms_text_key;?> *</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="<?php echo $alphasms_text_key;?>" id="alpha_key" name="alphasms_key" value="<?php echo (isset($frm_alphasms_key) ? $frm_alphasms_key : '') ?>" class="form-control" />
                                            <?php if (empty($frm_alphasms_key)) { $err.='<br>'.$alphasms_error_key?>
                                            <div class="text-danger"><?php echo $alphasms_error_key; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-10">
                                            <?php if (empty($err)) { ?>
                                                <div class="text-success"><?php echo $alphasms_text_connection_established; ?></div>
                                            <?php } else { ?>
                                                <div class="text-danger"><?php echo $err; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                            </div>
                            <div class="tab-pane" id="tab-events">
                                <form action="<?php echo (!empty($action)) ? $action : ''; ?>" method="post" id="form-alpha" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="alpha_sign"><?php echo $alphasms_text_sign;?> *</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="<?php echo $alphasms_text_sign;?>" id="alpha_sign" maxlength="11" name="alphasms_sign"  value="<?php echo (isset($frm_alphasms_sign) ? $frm_alphasms_sign : '') ?>" class="form-control" />
                                            <?php if (empty($frm_alphasms_sign) || !preg_match("![a-zA-Z0-9-_\/\.\,]{1,11}!si", $frm_alphasms_sign)) { ?>
                                            <div class="text-danger"><?php echo $alphasms_error_sign; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="alpha_admphone"><?php echo $alphasms_text_admphone;?> *</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="<?php echo $alphasms_text_admphone;?>" id="alpha_admphone" maxlength="15" name="alphasms_admphone"  value="<?php echo (isset($frm_alphasms_admphone) ? $frm_alphasms_admphone : '') ?>" class="form-control" />
                                            <?php if (empty($frm_alphasms_admphone) || !preg_match("!\+[0-9]{10,14}!si", $frm_alphasms_admphone)) { ?>
                                            <div class="text-danger"><?php echo $alphasms_error_admphone; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"><?php echo $alphasms_text_notify_sms_to_admin;?></label>
                                        <div class="col-sm-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="alphasms_events_admin_new_customer" value="1" <?php echo (isset($frm_alphasms_events_admin_new_customer) ? 'checked' : '');?>>
                                                    <?php echo $alphasms_events_admin_new_customer;?>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="alphasms_events_admin_new_order" value="1" <?php echo (isset($frm_alphasms_events_admin_new_order) ? 'checked="checked"' : '') ?> />
                                                    <?php echo $alphasms_events_admin_new_order ?>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="alphasms_events_admin_new_email" value="1" <?php echo (isset($frm_alphasms_events_admin_new_email) ? 'checked="checked"' : '') ?> />
                                                    <?php echo $alphasms_events_admin_new_email ?>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="alphasms_events_admin_gateway_connection_error" value="1" <?php echo (isset($frm_alphasms_events_admin_gateway_connection_error) ? 'checked="checked"' : '') ?> />
                                                    <?php echo $alphasms_events_admin_gateway_connection_error ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"><?php echo $alphasms_text_notify_sms_to_customer;?></label>
                                        <div class="col-sm-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="alphasms_events_customer_new_order" value="1" <?php echo (isset($frm_alphasms_events_customer_new_order) ? 'checked="checked"' : '') ?> />
                                                    <?php echo $alphasms_events_customer_new_order ?>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="alphasms_events_customer_new_order_status" value="1" <?php echo (isset($frm_alphasms_events_customer_new_order_status) ? 'checked="checked"' : '') ?> />
                                                    <?php echo $alphasms_events_customer_new_order_status ?>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="alphasms_events_customer_new_register" value="1" <?php echo (isset($frm_alphasms_events_customer_new_register) ? 'checked="checked"' : '') ?> />
                                                    <?php echo $alphasms_events_customer_new_register ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-10">
                                            <?php if (!empty($err) && !is_array($err) && trim($err)!=='1') { ?>
                                            <div class="text-danger"><?php echo $err; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="tab-sendsms">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <?php if (!empty($success_sms)) { ?>
                                        <div class="text-success"><?php echo $success_sms;?></div>
                                        <?php }  elseif(!empty($err) && trim($err)!=='1') { ?>
                                        <div class="text-danger"><?php echo $err; ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="alpha_phone"><?php echo $alphasms_text_phone;?> *</label>
                                    <div class="col-sm-10">
                                        <input maxlength="15" type="text" placeholder="<?php echo $alphasms_text_phone;?>" id="alpha_phone" name="alphasms_frmsms_phone" value="<?php echo (isset($frm_alphasms_frmsms_phone) ? $frm_alphasms_frmsms_phone : '') ?>" class="form-control" />
                                        <?php if ((empty($frm_alphasms_frmsms_phone) || !preg_match("!\+[0-9]{10,14}!si", $frm_alphasms_frmsms_phone)) && empty($success_sms)) { ?>
                                        <div class="text-danger"><?php echo $alphasms_error_phone; ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="alpha_message"><?php echo $alphasms_text_frmsms_message;?> *</label>
                                    <div class="col-sm-10">
                                        <textarea name="alphasms_frmsms_message" placeholder="<?php echo $alphasms_text_frmsms_message;?>" rows="5" id="alpha_message" class="form-control"><?php echo (isset($frm_alphasms_frmsms_message) ? $frm_alphasms_frmsms_message : '') ?></textarea>
                                        <?php if (empty($frm_alphasms_frmsms_message) && empty($success_sms)) { ?>
                                        <div class="text-danger"><?php echo $alphasms_error_message; ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="alpha_message"> </label>
                                    <div class="col-sm-10">
                                        <button data-original-title="<?php echo $alphasms_text_button_send_sms;?>" type="submit" form="form-setting" data-toggle="tooltip" title="" class="btn btn-primary"><i class="fa fa-send"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-templates">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <?php if(!empty($err) && trim($err)!=='1') { ?>
                                        <div class="text-danger"><?php echo $err; ?></div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        <?php echo $alphasms_customer_new_register_title;?>:
                                    </label>
                                    <div class="col-sm-10">
                                        <textarea name="alphasms_message_customer_new_register"
                                                  placeholder="<?php echo $alphasms_customer_new_register_title;?>"
                                                  rows="2" id="alpha_message" class="form-control"
                                                ><?php echo (!empty($alphasms_message_customer_new_register) ?
                                                $alphasms_message_customer_new_register : '') ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        <?php echo $alphasms_customer_new_order_title;?>:
                                    </label>
                                    <div class="col-sm-10">
                                        <textarea name="alphasms_message_customer_new_order"
                                                  placeholder="<?php echo $alphasms_customer_new_order_title;?>"
                                                  rows="2" id="alpha_message" class="form-control"
                                                ><?php echo (!empty($alphasms_message_customer_new_order) ?
                                                $alphasms_message_customer_new_order : '') ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        <?php echo $alphasms_admin_new_customer_title;?>:
                                    </label>
                                    <div class="col-sm-10">
                                        <textarea name="alphasms_message_admin_new_customer"
                                                  placeholder="<?php echo $alphasms_admin_new_customer_title;?>"
                                                  rows="2" id="alpha_message" class="form-control"
                                                ><?php echo (!empty($alphasms_message_admin_new_customer) ?
                                                $alphasms_message_admin_new_customer : '') ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        <?php echo $alphasms_admin_new_order_title;?>:
                                    </label>
                                    <div class="col-sm-10">
                                        <textarea name="alphasms_message_admin_new_order"
                                                  placeholder="<?php echo $alphasms_admin_new_order_title;?>"
                                                  rows="2" id="alpha_message" class="form-control"
                                                ><?php echo (!empty($alphasms_message_admin_new_order) ?
                                                $alphasms_message_admin_new_order : '') ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        <?php echo $alphasms_admin_new_email_title;?>:
                                    </label>
                                    <div class="col-sm-10">
                                        <textarea name="alphasms_message_admin_new_email"
                                                  placeholder="<?php echo $alphasms_admin_new_email_title;?>"
                                                  rows="2" id="alpha_message" class="form-control"
                                                ><?php echo (!empty($alphasms_message_admin_new_email) ?
                                                $alphasms_message_admin_new_email : '') ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        <?php echo $alphasms_customer_new_order_status_title;?>:
                                    </label>
                                    <div class="col-sm-10">
                                        <textarea name="alphasms_message_customer_new_order_status"
                                                  placeholder="<?php echo $alphasms_customer_new_order_status_title;?>"
                                                  rows="2" id="alpha_message" class="form-control"
                                                ><?php echo (!empty($alphasms_message_customer_new_order_status) ?
                                                $alphasms_message_customer_new_order_status : '') ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <button data-original-title="<?php echo $alphasms_text_button_save_templates;?>"
                                                type="submit" form="form-setting" data-toggle="tooltip" title=""
                                                class="btn btn-primary" onClick="$('form#form-alpha').submit();">
                                            <i class="fa fa-save"></i>
                                            <?php echo $alphasms_text_button_save_templates;?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-about">
                                <label class="col-sm-2 control-label" for="alpha_message"> </label>
                                <div class="col-sm-10">
                                    <?php echo sprintf($alphasms_text_about_tab_description, $heading_title, date('Y'), $module_version)?>
                                </div>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){

            var is_sms = '<input type="hidden" name="is_sms" id="is_sms" value="true">';

            <?php if(!empty($tab_sel)){echo '$("#alpha_tabs a[href=#tab-sendsms]").tab("show"); $("#tab-sendsms").append(is_sms);'; } else { ?>

                $('#alpha_tabs a:first').tab('show');

            <?php } ?>

            $("#alpha_tabs a").click(function(){

                if($(this).attr('href')=='#tab-sendsms' && !$('#tab-sendsms #is_sms').is('*')){
                    $('#tab-sendsms').append(is_sms);
                }
                else if($('#tab-sendsms #is_sms').is('*')){
                    $('#tab-sendsms #is_sms').remove();
                }
            });

            $('button[form="form-alpha"]').click(function(){
                if($('#tab-sendsms #is_sms').is('*')){
                    $('#tab-sendsms #is_sms').remove();
                }
            });
        });
    </script>
</div>
<?php echo $footer; ?>