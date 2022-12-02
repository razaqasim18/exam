<?php

$id = '';
$param_data = '';
$param = '';

if(!empty($con_data))
{
    foreach ($con_data as $item)
    {
        $id = $item->id;
        $param_data = $item->param_data;
        $param = json_decode($param_data,true);
    }
}

?>

<style type="text/css">
    #mailtemplate textarea,
    #theme textarea {height: 300px;}
</style>

<div class="content-wrapper">

    <section class="content-header">
        <h1><i class="fa fa-cog"></i> <?php echo getlang('title_configuration', 'sys_data'); ?> </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="configuration_form" class="form-horizontal"  action="<?php echo base_url() ?>configuration/edit" method="post" role="form" enctype="multipart/form-data">
                    <div class="box-body">

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#general"><?php echo getlang('tab_general', 'sys_data'); ?></a></li>
                            <li><a data-toggle="tab" href="#logo"><?php echo getlang('tab_media', 'sys_data'); ?></a></li>
                            <li><a data-toggle="tab" href="#mail"><?php echo getlang('tab_mail_configuration', 'sys_data'); ?></a></li>
                            <li><a data-toggle="tab" href="#error_page"><?php echo getlang('tab_404_page', 'sys_data'); ?></a></li>
                            <li><a data-toggle="tab" href="#theme"><?php echo getlang('tab_theme', 'sys_data'); ?></a></li>
                            <li><a data-toggle="tab" href="#mailtemplate"><?php echo getlang('tab_email_template', 'sys_data'); ?></a></li>
                            <li><a data-toggle="tab" href="#account"><?php echo getlang('tab_account', 'sys_data'); ?></a></li>
                            <li><a data-toggle="tab" href="#payment"><?php echo getlang('tab_payment', 'sys_data'); ?></a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="general" class="tab-pane fade in active">
                                <p></p>
                                <?php 
                                $config_data = getConfigData('general');
                                $general_html = '';
                                foreach ($config_data as $key => $config_item) {
                                    $config_name = $config_item[0];
                                    $config_text = $config_item[1];
                                    $config_type = $config_item[2];
                                    $field_name = 'param['.$config_name.'][]';

                                    if($config_type == 'select'){
                                        // Get selected value or default value
                                        $selected_value = pdchecker($param, $config_name);
                                        
                                        // Set language field
                                        if($config_name == 'default_language'){
                                            // Get language list
                                            $language_list = getLanguageList($field_name, $selected_value);
                                            $general_html .='<div class="row"><div class="col-md-8">';                                
                                            $general_html .= fieldBuilder($config_type,'', $language_list, $config_text, ''); 
                                            $general_html .='</div></div>';
                                        }

                                        // Set default admin theme field
                                        if($config_name == 'default_theme'){
                                            // Get theme list
                                            $themelist = gettheme($field_name, $selected_value);
                                            $general_html .='<div class="row"><div class="col-md-8">';                                
                                            $general_html .= fieldBuilder($config_type,'', $themelist, $config_text, ''); 
                                            $general_html .='</div></div>';
                                        }

                                        // Set default preloader field
                                        if($config_name == 'preloader'){
                                            // Get yes no list
                                            $yesnolist = getYesNo($field_name, $selected_value);
                                            $general_html .='<div class="row"><div class="col-md-8">';                                
                                            $general_html .= fieldBuilder($config_type,'', $yesnolist, $config_text, ''); 
                                            $general_html .='</div></div>';
                                        }
                                        
                                    }else{
                                        $general_html .='<div class="row"><div class="col-md-8">';                                
                                        $general_html .= fieldBuilder($config_type, $field_name, pdchecker($param, $config_name), $config_text, ''); 
                                        $general_html .='</div></div>';
                                    }
                                }
                                echo $general_html;
                                ?>
                            </div>

                            <div id="logo" class="tab-pane fade">
                                <p></p>

                                <?php 
                                $config_file = getConfigData('file');
                                $file_html = '';
                                foreach ($config_file as $key => $config_file_item) {
                                    
                                    $config_field     = $config_file_item[0];
                                    $config_old_field = $config_file_item[1];
                                    $config_label     = $config_file_item[2];
                                    $config_path      = $config_file_item[3];
                                    $config_default   = $config_file_item[4];

                                    //$field_name = 'param['.$config_field.'][]';
                                    //$field_old_name = 'param['.$config_old_field.'][]';

                                    $old_file = getConfigItem($config_field);

                                    if($config_type == 'select'){
                                        
                                    }else{

                                        $file_html .='<div class="row">';
                                        $file_html .='<div class="col-md-8 rms-profile-image">';
                                       
                                        if(empty($old_file)){
                                            $file_path = site_url($config_path).'/'.$config_default;
                                        }else{
                                            $file_path = site_url($config_path).'/'.$old_file;
                                        }

                                        $image_type = getConfigItem('image_supported_type');
                                        $max_size = getConfigItem('image_supported_size');

                                        $file_field = '<input type="file" name="'.$config_field.'" onchange="readURL(this, '.$key.', '.$max_size.', \''.$image_type.'\');" />';
                                        $file_html .= fieldBuilder('select', $config_field, $file_field, $config_label, '');
                                        
                                        $file_html .='<div class="form-group">';
                                        $file_html .='<div class="col-sm-4 control-label"></div>';
                                        $file_html .='<div class="col-sm-8" >';
                                        $file_html .='<img src="'.$file_path.'" id="preview_'.$key.'" alt=""  >';
                                        $file_html .='<input type="hidden" value="'.$old_file.'" name="'.$config_old_field.'">';
                                        $file_html .='</div>';
                                        $file_html .='</div>';
                                        $file_html .='</div>';
                                        $file_html .='</div>';

                                    }
                                }
                                echo $file_html;
                                ?>
                            </div>

                            <div id="mail" class="tab-pane fade">
                                <p></p>
                                <?php 
                                $config_mail = getConfigData('mail');
                                $mail_html = '';
                                foreach ($config_mail as $key => $config_mail_item) {
                                    $config_name = $config_mail_item[0];
                                    $config_text = $config_mail_item[1];
                                    $config_type = $config_mail_item[2];
                                    $field_name = 'param['.$config_name.'][]';

                                    if($config_type == 'select'){
                                        
                                    }else{
                                        $mail_html .='<div class="row"><div class="col-md-8">';                                
                                        $mail_html .= fieldBuilder($config_type, $field_name, pdchecker($param, $config_name), $config_text, ''); 
                                        $mail_html .='</div></div>';
                                    }
                                }
                                echo $mail_html;
                                ?>
                            </div>

                            <div id="error_page" class="tab-pane fade">
                                <p></p>
                                <?php 
                                $config_mail = getConfigData('404');
                                $mail_html = '';
                                foreach ($config_mail as $key => $config_mail_item) {
                                    $config_name = $config_mail_item[0];
                                    $config_text = $config_mail_item[1];
                                    $config_type = $config_mail_item[2];
                                    $field_name = 'param['.$config_name.'][]';

                                    if($config_type == 'select'){
                                        
                                    }else{
                                        $mail_html .='<div class="row"><div class="col-md-8">';                                
                                        $mail_html .= fieldBuilder($config_type, $field_name, pdchecker($param, $config_name), $config_text, ''); 
                                        $mail_html .='</div></div>';
                                    }
                                }
                                echo $mail_html;
                                ?>
                            </div>

                            <div id="theme" class="tab-pane fade">
                                <p></p>
                                <?php 
                                $config_theme = getConfigData('theme');
                                $theme_html = '';
                                foreach ($config_theme as $key => $config_theme_item) {
                                    $config_name = $config_theme_item[0];
                                    $config_text = $config_theme_item[1];
                                    $config_type = $config_theme_item[2];
                                    $field_name = 'param['.$config_name.'][]';

                                    if($config_type == 'select'){

                                        // Get selected value or default value
                                        $selected_value = pdchecker($param, $config_name);

                                        // Set default preloader field
                                        if($config_name == 'preloader'){
                                            // Get yes no list
                                            $yesnolist = getYesNo($field_name, $selected_value);
                                            $theme_html .='<div class="row"><div class="col-md-8">';                                
                                            $theme_html .= fieldBuilder($config_type,'', $yesnolist, $config_text, ''); 
                                            $theme_html .='</div></div>';
                                        }

                                        // Set default preloader style field
                                        if($config_name == 'preloader_style'){
                                            // Get yes no list
                                            $preloader_style = getPreloaderStyle($field_name, $selected_value);
                                            $theme_html .='<div class="row"><div class="col-md-8">';                                
                                            $theme_html .= fieldBuilder($config_type,'', $preloader_style, $config_text, ''); 
                                            $theme_html .='</div></div>';
                                        }

                                        // Set default scroll to top field
                                        if($config_name == 'scroll_to_top'){
                                            // Get yes no list
                                            $yesnolist = getYesNo($field_name, $selected_value);
                                            $theme_html .='<div class="row"><div class="col-md-8">';                                
                                            $theme_html .= fieldBuilder($config_type,'', $yesnolist, $config_text, ''); 
                                            $theme_html .='</div></div>';
                                        }
                                        
                                    }elseif($config_type == 'hr'){
                                        $theme_html .='<div class="row"><div class="col-md-12">';                                
                                        $theme_html .= fieldBuilder($config_type, $field_name, pdchecker($param, $config_name), $config_text, ''); 
                                        $theme_html .='</div></div>';
                                    }
                                    else{
                                        $theme_html .='<div class="row"><div class="col-md-8">';                                
                                        $theme_html .= fieldBuilder($config_type, $field_name, pdchecker($param, $config_name), $config_text, ''); 
                                        $theme_html .='</div></div>';
                                    }
                                }
                                echo $theme_html;
                                ?>
                            </div>

                            <div id="mailtemplate" class="tab-pane fade">
                                <p></p>
                                <?php 
                                $config_mailtemplate = getConfigData('mailtemplate');
                                $mt_html = '';
                                foreach ($config_mailtemplate as $key => $config_template_item) {
                                    $config_name = $config_template_item[0];
                                    $config_text = $config_template_item[1];
                                    $config_type = $config_template_item[2];
                                    $field_name = 'param['.$config_name.'][]';

                                    if($config_type == 'select'){
                                        
                                    }elseif($config_type == 'hr'){
                                        $mt_html .='<div class="row"><div class="col-md-12">';                                
                                        $mt_html .= fieldBuilder($config_type, $field_name, pdchecker($param, $config_name), $config_text, ''); 
                                        $mt_html .='</div></div>';
                                    }elseif($config_type == 'help'){
                                        $mt_html .='<div class="row"><div class="col-md-8">';                                
                                        $mt_html .= fieldBuilder($config_type, $field_name,'', $config_text, ''); 
                                        $mt_html .='</div></div>';
                                    }else{
                                        $mt_html .='<div class="row"><div class="col-md-8">';                                
                                        $mt_html .= fieldBuilder($config_type, $field_name, pdchecker($param, $config_name), $config_text, ''); 
                                        $mt_html .='</div></div>';
                                    }
                                }
                                echo $mt_html;
                                ?>
                            </div>

                            <div id="account" class="tab-pane fade">
                                <p></p>
                                <?php 
                                $config_account = getConfigData('account');
                                $acc_html = '';
                                foreach ($config_account as $key => $config_acc_item) {
                                    $config_name = $config_acc_item[0];
                                    $config_text = $config_acc_item[1];
                                    $config_type = $config_acc_item[2];
                                    $field_name = 'param['.$config_name.'][]';

                                    if($config_type == 'select'){
                                        
                                    }else{
                                        $acc_html .='<div class="row"><div class="col-md-8">';                                
                                        $acc_html .= fieldBuilder($config_type, $field_name, pdchecker($param, $config_name), $config_text, ''); 
                                        $acc_html .='</div></div>';
                                    }
                                }
                                echo $acc_html;
                                ?>
                            </div>

                            <div id="payment" class="tab-pane fade">
                                <p></p>
                                <?php 
                                $config_data = getConfigData('payment');
                                $general_html = '';
                                foreach ($config_data as $key => $config_item) {
                                    $config_name = $config_item[0];
                                    $config_text = $config_item[1];
                                    $config_type = $config_item[2];
                                    $field_name = 'param['.$config_name.'][]';

                                    if($config_type == 'select'){
                                        // Get selected value or default value
                                        $selected_value = pdchecker($param, $config_name);
                                        
                                        // Set language field
                                        if($config_name == 'default_payment'){
                                            // Get language list
                                            $method_list = getMethodList($field_name, $selected_value);
                                            $general_html .='<div class="row"><div class="col-md-8">';                                
                                            $general_html .= fieldBuilder($config_type,'', $method_list, $config_text, ''); 
                                            $general_html .='</div></div>';
                                        }

                                        // Set default admin theme field
                                        if($config_name == 'currency_position'){
                                            // Get theme list
                                            $currency_p_list = getCurrencyPositionList($field_name, $selected_value);
                                            $general_html .='<div class="row"><div class="col-md-8">';                                
                                            $general_html .= fieldBuilder($config_type,'', $currency_p_list, $config_text, ''); 
                                            $general_html .='</div></div>';
                                        }

                                        
                                        
                                    }else{
                                        $general_html .='<div class="row"><div class="col-md-8">';                                
                                        $general_html .= fieldBuilder($config_type, $field_name, pdchecker($param, $config_name), $config_text, ''); 
                                        $general_html .='</div></div>';
                                    }
                                }
                                echo $general_html;
                                ?>
                            </div>

                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-8 ">
                                <div class="form-group">
                                    <div class="col-sm-4 control-label"></div>
                                    <div class="col-sm-8">
                                        <input type="hidden" value="<?php echo $id; ?>" name="id">
                                        <input type="submit" class="btn btn-primary" value="<?php echo getlang('btn_submit', 'sys_data'); ?>" /> 
                                        <a class="btn  btn-default" href="<?php echo base_url().'configuration'; ?>" title="<?php echo getlang('btn_cancel', 'sys_data'); ?>"> <?php echo getlang('btn_cancel', 'sys_data'); ?> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>







