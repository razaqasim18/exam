
<div class="container" >
    <div class="row">
        <div class="col-md-5 col-md-offset-4">
            

            <div class="login-box-body">
                <h3 class="login-box-msg">Enter your account email</h3>

                <!-- Message Section -->
                <?php echo getSystemMessage(); ?>

                <form action="<?php echo base_url(); ?>/resetPasswordUser" method="post">
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="<?php echo getlang('email', 'sys_data'); ?>" name="login_email" required />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
          
                    <div class="row">
                        <div class="col-xs-8"></div>
                        <div class="col-xs-4">
                        <input type="submit" class="btn btn-primary btn-block btn-flat" value="<?php echo getlang('btn_submit', 'sys_data'); ?>" />
                        </div>
                    </div>

                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                </form>

                <a href="<?php echo base_url(); ?>login"><?php echo getlang('btn_login','sys_data'); ?></a><br>
            </div>
       

</div>
</div>
</div>