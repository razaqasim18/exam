<?php 

    $token_name = $this->security->get_csrf_token_name();
    $csrf_hash  = $this->security->get_csrf_hash();
    $required = 'required';

    

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/adminlte/plugins/datepicker/datepicker3.css" />
<section class="sign-up-page">
    
    <div class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?php
                $this->load->helper('form');
                $error = $this->session->flashdata('error');
                if($error){
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                $success = $this->session->flashdata('success');
                if($success)
                {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                    
                <!-- form start -->
                <?php $this->load->helper("form"); ?>
                <h3 class="text-center" style="margin-bottom: 30px;"><?php echo getlang('site_sign_up_title_2','data'); ?></h3>
                <hr>
                <form class="form-horizontal" action="<?php echo base_url(); ?>signup/saveparent" method="post" >
                    <input type="hidden" name="role" value="<?php echo $role_id; ?>" />
                    <input type="hidden" name="name" value="<?php echo $name; ?>" />
                    <input type="hidden" name="email" value="<?php echo $email; ?>" />
                    <input type="hidden" name="password" value="<?php echo $password; ?>" />
                    <input type="hidden" name="mobile" value="<?php echo $mobile; ?>" />
                    <input type="hidden" name="<?php echo $token_name; ?>" value="<?php echo $csrf_hash; ?>" />

                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-center"><b><?php echo getlang('site_profile_info', 'data'); ?></b></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <?php
                                $sid = getFieldSectionID('parent');
                                $fields_list = getFieldList($sid);

                                foreach($fields_list as $field){
                                    $fid = $field->id;
                                    $sid = $sid;
                                    $panel_id = '';
                                    echo fieldshow($fid, $sid, $panel_id, $field->field_name, $field->type, $field->required);
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="form-group">
                                    <div class="col-sm-4 control-label"></div>
                                    <div class="col-sm-8">
                                        <input type="submit" class="btn btn-primary" value="<?php echo getlang('site_btn_submit', 'data'); ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 

                
                </form>
            </div>
        </div>
            
    </div>  
    
</section>

<script src="<?php echo base_url(); ?>assets/backend/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.datepicker').datepicker({
          autoclose: true,
          format : "dd-mm-yyyy"
        });
    });
</script>
