<?php 
    
    $token_name = $this->security->get_csrf_token_name();
    $token_hash = $this->security->get_csrf_hash();

    $id         = '';
    $status     = '';
    $conf_param = '';
    if(!empty($data))
    {
        foreach ($data as $item)
        {
            $id      = $item->id;
            $alias  = $item->alias;
            $status  = $item->published;
            $sys_data = $item->data;
            $conf_param = json_decode($sys_data,true);
        }
    }



    if($alias == 'paypal'){
        $config_mailtemplate = getConfigData('paypal');
    }else{
        $config_mailtemplate = getConfigData('offline');
    }
?>

<div class="content-wrapper">
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-6 title-bar">
                <h1><i class="fa fa-paypal"></i> <?php echo getlang('title_payment_configuration_method', 'sys_data'); ?> </h1>
            </div>

            <div class="col-xs-12 col-md-6 text-right">
                
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                
                <div class="box box-primary">
                    <p></p>
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form id="addUser" class="form-horizontal" action="<?php echo base_url().ADMIN_ALIAS; ?>/methods/save" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                <?php 
                                $mt_html = '';
                                foreach ($config_mailtemplate as $key => $config_template_item) {
                                    $config_name = $config_template_item[0];
                                    $config_text = $config_template_item[1];
                                    $config_type = $config_template_item[2];
                                    $field_name = 'param['.$config_name.'][]';

                                    if($config_type == 'select'){
                                        
                                    }elseif($config_type == 'hr'){
                                        $mt_html .='<div class="row"><div class="col-md-12">';                                
                                        $mt_html .= fieldBuilder($config_type, $field_name, pdchecker($conf_param, $config_name), $config_text, ''); 
                                        $mt_html .='</div></div>';
                                    }elseif($config_type == 'help'){
                                        $mt_html .='<div class="row"><div class="col-md-12">';                                
                                        $mt_html .= fieldBuilder($config_type, $field_name,'', $config_text, ''); 
                                        $mt_html .='</div></div>';
                                    }else{
                                        $mt_html .='<div class="row"><div class="col-md-12">';                                
                                        $mt_html .= fieldBuilder($config_type, $field_name, pdchecker($conf_param, $config_name), $config_text, ''); 
                                        $mt_html .='</div></div>';
                                    }
                                }
                                echo $mt_html;
                                ?>
                                </div>
                            </div>

                            
                           
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <div class="form-group">
                                        <label for="status" class="col-sm-4 control-label"><?php echo getlang('status', 'sys_data'); ?></label>
                                        <div class="col-sm-8">
                                        <select class="form-control required" id="status" name="status">
                                            <option value="1" <?php if($status == '1'){echo 'selected="selected"';} ?> ><?php echo getlang('published', 'sys_data'); ?></option>
                                            <option value="0" <?php if($status == '0'){echo 'selected="selected"';} ?> ><?php echo getlang('unpublished', 'sys_data'); ?></option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
    
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <div class="form-group">
                                        <div class="col-sm-4 control-label"></div>
                                        <div class="col-sm-8">
                                            <input type="submit" class="btn btn-primary" value="<?php echo getlang('btn_submit', 'sys_data'); ?>" />
                                            <a href="<?php echo base_url().ADMIN_ALIAS; ?>/methods" class="btn btn-default"  ><?php echo getlang('btn_cancel', 'sys_data'); ?></a>
                                               
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" value="<?php echo $id; ?>" name="id">
                        <input type="hidden" name="<?php echo $token_name; ?>" value="<?php echo $token_hash ; ?>" />
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
    
</div>



