<?php 
    // Get Site Name
    $site_name = getConfigItem('site_name');

    // Get icon
    $icon = getConfigItem('default_icon');
    if(empty($icon)){
        $icon_path = site_url('/uploads/logo/').'/icon.png';
    }else{
        $icon_path = site_url('/uploads/logo/').'/'.$icon;
    }

    // Get favicon
    $favicon = getConfigItem('default_favicon');
    if(empty($favicon)){
        $favicon_path = site_url('/uploads/logo/').'/favicon.png';
    }else{
        $favicon_path = site_url('/uploads/logo/').'/'.$favicon;
    }

    // Get background image
    $login_background = getConfigItem('login_background');
    if(empty($login_background)){
        $bg_path = site_url('/uploads/logo/').'/login.png';
    }else{
        $bg_path = site_url('/uploads/logo/').'/'.$login_background;
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo getlang('login_page_title', 'sys_data'); ?></title>
        <link rel="shortcut icon" href="<?php echo $favicon_path; ?>">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <?php echo setAdminCSS('adminlte'); ?>
        <style type="text/css">
            .login-page{
                background: url(<?php echo $bg_path; ?>) repeat-x -99% center / auto 100%;
            }
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="<?php echo base_url(); ?>">
          <img src="<?php echo $icon_path; ?>" style="max-width: 80%;"  alt="<?php echo $site_name; ?>"  >
        </a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <h3 class="login-box-msg">Reset Password</h3>
        
        <!-- Message Section -->
        <?php echo getSystemMessage(); ?>
        
        <form action="<?php echo base_url().ADMIN_ALIAS; ?>/createPasswordUser" method="post">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="<?php echo getlang('email', 'sys_data'); ?>" name="email" value="<?php echo $email; ?>" readonly required />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <input type="hidden" name="activation_code"  value="<?php echo $activation_code; ?>" required />
          </div>
          <hr>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="<?php echo getlang('passowrd', 'sys_data'); ?>" name="password" required />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="<?php echo getlang('retype_password', 'sys_data'); ?>" name="cpassword" required />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <!-- <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>  -->                       
            </div><!-- /.col -->
            <div class="col-xs-4">
              <input type="submit" class="btn btn-primary btn-block btn-flat" value="<?php echo getlang('btn_submit', 'sys_data'); ?>" />
            </div><!-- /.col -->
          </div>

          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        </form>
        
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  </body>
</html>