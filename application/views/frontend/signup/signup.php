<?php 

$required = 'required';

?>
<section class="sign-up-page">
    
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 ms">
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
                <h3 class="text-center"><?php echo getlang('site_sign_up_title', 'data'); ?></h3>
                <hr>
                <form  class="form-horizontal" action="<?php echo base_url(); ?>signup/add" method="post" >
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2"><?php echo fieldBuilder('input', 'name', $name, getlang('site_form_user_name', 'data'), 'required'); ?></div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2"><?php echo fieldBuilder('input', 'email', $email, getlang('site_form_email', 'data'), 'required'); ?></div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <?php 
                                $pass_field = '<input type="password" class="form-control '.$required.'" id="password" name="password" maxlength="20">';
                                echo fieldBuilder('select', 'password', $pass_field, getlang('site_form_passowrd', 'data'), $required); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <?php 
                                $pass_field = '<input type="password" class="form-control '.$required.' equalTo" id="cpassword" name="cpassword" maxlength="20">';
                                echo fieldBuilder('select', 'cpassword',$pass_field,  getlang('site_form_retype_password', 'data'), $required); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2"> <?php echo fieldBuilder('input', 'mobile', $mobile,  getlang('site_form_phone', 'data'), 'required'); ?></div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="form-group">
                                    <label for="role" class="col-sm-4 control-label"><?php echo getlang('site_signup_request', 'data'); ?></label>
                                    <div class="col-sm-8">
                                    <select class="form-control required" id="role" name="role">
                                        <option value="0"><?php echo getlang('site_form_select_group', 'data'); ?></option>
                                        <?php

                                        if(!empty($roles))
                                        {
                                            foreach ($roles as $rl)
                                            {
                                                ?>
                                                <option value="<?php echo $rl->roleId; ?>" <?php if($rl->roleId == $role_id) {echo "selected=selected";} ?> ><?php echo $rl->role ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    </div>
                                </div>
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

                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                </form>
            </div>
        </div>
            
    </div>  
    
</section>
