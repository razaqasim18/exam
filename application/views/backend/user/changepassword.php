
<?php

    $new_password = getlang('new_password', 'sys_data');
    $confirm_password = getlang('retype_password', 'sys_data');
    $old_password = getlang('old_password', 'sys_data');

?>


<div class="content-wrapper">
    <?php 
    $page_title = getlang('change_password', 'sys_data');
    echo sectionHeader($page_title, '', ''); 
    ?>
    <section class="content">

        <div class="row">
            <div class="col-xs-12 col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary">
                    

                    <!-- form start -->
                    <form role="form" class="form-horizontal" action="<?php echo base_url().ADMIN_ALIAS; ?>/user/changepassword" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <?php 
                                    $oldpass_field = '<input type="password" class="form-control" id="inputOldPassword" placeholder="'.getlang('old_password', 'sys_data').'" name="oldPassword" maxlength="20" required>';
                                    echo fieldBuilder('select', 'password', $oldpass_field, $old_password, ''); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-8">
                                    <?php 
                                    $pass1_field = '<input type="password" class="form-control" id="inputPassword1" placeholder="'.getlang('new_password', 'sys_data').'" name="newPassword" maxlength="20" required>';
                                    echo fieldBuilder('select', 'password1', $pass1_field, $new_password, ''); ?>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <?php 
                                    $pass2_field = '<input type="password" class="form-control" id="inputPassword2" placeholder="'.getlang('confirm_new_password', 'sys_data').'" name="cNewPassword" maxlength="20" required>';
                                    echo fieldBuilder('select', 'password2', $pass2_field, $confirm_password, ''); ?>
                                    
                                </div>
                            </div>

                           
                        </div>

                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-8 ">
                                    <div class="form-group">
                                        <div class="col-sm-4 control-label"></div>
                                        <div class="col-sm-8">
                                            <input type="submit" class="btn btn-primary" value="<?php echo getlang('btn_submit', 'sys_data'); ?>" />
                                            <a href="<?php echo base_url().ADMIN_ALIAS; ?>/user" class="btn btn-default"  ><?php echo getlang('cancel', 'sys_data'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="uid" value="<?php echo $userid; ?>" />
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    </form>
                </div>
            </div>
            
        </div>
    </section>
</div>