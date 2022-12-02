
<?php 
    $new_password = getlang('new_password', 'sys_data');
    $confirm_password = getlang('retype_password', 'sys_data');
    $old_password = getlang('old_password', 'sys_data');

?>
   


<div class="container">

    <div class="row">
        <div class="col-md-12">
            <?php echo getSystemMessage(); ?>
        </div>
    </div>




    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 left-sidebar"> <?php echo getUserPanel($role, $uid); ?></div>

        <div class="col-xs-12 col-sm-9 col-md-9">
            <h1 class="user-page-title"><i class="fa fa-key"></i> Change Password</h1>
            <hr>
        
            <?php $this->load->helper("form"); ?>
            <form role="form" id="updatepassword" class="form-horizontal" action="<?php echo base_url(); ?>user/changepassword" method="post" role="form" >
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8">
                            <?php 
                            $oldpass_field = '<input type="password" class="form-control"  placeholder="Old password" name="oldPassword" maxlength="20" required>';
                            echo fieldBuilder('select', 'password', $oldpass_field, $old_password, ''); ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-8">
                            <?php 
                            $pass1_field = '<input type="password" class="form-control"  placeholder="New password" name="newPassword" maxlength="20" required>';
                            echo fieldBuilder('select', 'password1', $pass1_field, $new_password, ''); ?>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <?php 
                            $pass2_field = '<input type="password" class="form-control"  placeholder="Confirm new password" name="cNewPassword" maxlength="20" required>';
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
                                    <input type="submit" class="btn btn-primary" value="<?php echo getlang('submit', 'sys_data'); ?>" />
                                     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="uid" value="<?php echo $uid; ?>" />
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            </form>
        
        </div>
    </div>
</div>

