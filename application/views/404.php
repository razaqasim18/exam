
<?php 
    // Get Site Name
    $site_name = getConfigItem('site_name');

    $title = getConfigItem('404_title');
    $browser_title = getConfigItem('404_browser_title');
    $description = getConfigItem('404_description');

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
    $background = getConfigItem('404_background');
    if(empty($background)){
        $bg_path = site_url('/uploads/logo/').'/bsms.jpg';
    }else{
        $bg_path = site_url('/uploads/logo/').'/'.$background;
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $browser_title; ?></title>
        <link rel="shortcut icon" href="<?php echo $favicon_path; ?>">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <?php echo setAdminCSS('adminlte'); ?>
        <style type="text/css">
            .error-page{
                background: url(<?php echo $bg_path; ?>) no-repeat center center / 100% 100%;
                text-align: center;
            }
            h1.error_code{
                font-size: 200px;
                color: #fff;
                font-weight: bold;
                margin-top: 200px;
            }

            h3, p{color: #fff;}

            .content-wrapper{background: transparent;}
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="error-page">


<div class="content-wrapper-n">   
    

    <section class="error_code-area">
      <h1 class="error_code">404</h1>
    </section>

    <h3><?php echo $title; ?></h3>
    <p><?php echo $description; ?></p>
    
</div>

</body>
</html>