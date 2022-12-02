
<div class="container" >
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-box-body">
                <h3 class="login-box-msg text-center">Sign In</h3>
                
                <!-- Message Section -->
                <?php echo getSystemMessage(); ?>
        
                <form action="<?php echo base_url(); ?>getlogin" method="post">
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="<?php echo getlang('email', 'sys_data'); ?>" name="email" required />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="<?php echo getlang('passowrd', 'sys_data'); ?>" name="password" required />
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="row">
                        <div class="col-xs-8">    
                            <div class="checkbox icheck">
                                <label>
                                <input type="checkbox"> <?php echo getlang('remembar_me', 'sys_data'); ?>
                                </label>
                            </div>                       
                        </div>

                        <div class="col-xs-4">
                            <input type="submit" class="btn btn-primary btn-block btn-flat" value="Sign In" />
                        </div>
                    </div>

                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                </form>

                <a href="<?php echo base_url(); ?>forgotpassword"><?php echo getlang('forget_password', 'sys_data'); ?></a><br>
        
            </div>
        </div>
    </div>
</div>

    
    