<?php 

    // Get site name
    $site_name = getConfigItem('site_name');

    // Get preloader
    $preloader = getConfigItem('preloader');
    $preloader_style = getConfigItem('preloader_style');

    // Get scroll_to_top
    $scroll_to_top = getConfigItem('scroll_to_top');

    // Get check user id
    $isLoggedIn = $this->session->userdata ( 'isLoggedIn' );
    if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
        $user_id = '';
    }else{
        $user_id = $this->session->userdata ( 'userId' );
    }

	
    // Set Template path
    $template_path = base_url().'assets/frontend/rocky/';

    // Get favicon
   $favicon = getConfigItem('default_favicon');
   if(empty($favicon)){
      $favicon_path = site_url('/uploads/logo/').'/favicon.png';
   }else{
      $favicon_path = site_url('/uploads/logo/').'/'.$favicon;
   }

   // Get Site logo
   $logo = getConfigItem('default_logo');
   if(empty($logo)){
      $logo_path = site_url('/uploads/logo/').'/logo2.png';
   }else{
      $logo_path = site_url('/uploads/logo/').'/'.$logo;
   }

   // Header style data
   $header = getConfigItem('header');
   $header_bg = getConfigItem('header_bg');
   if(empty($header_bg)){$header_bg = '#663399';}
   $nav_bg = hex2rgba($header_bg, 0.8);
   $header_text = getConfigItem('header_text');
   if(empty($header_text)){$header_text = '#fff';}

   // Body style data
   $body_bg = getConfigItem('body_bg');
   if(empty($body_bg)){$body_bg = '#fff';}
   $body_text = getConfigItem('body_text');
   if(empty($body_text)){$body_text = '#666';}

   // Get directory
   $default_lang = getConfigItem('default_language');
   $active_lang_id = $this->session->userdata('site_lang');
   if(!empty($active_lang_id)){
       $lang_code      = getSingledata('languages', 'lang_code', 'id', $active_lang_id);
       $dir            = getSingledata('languages', 'direction', 'id', $active_lang_id);
   }else{
       $lang_code      = getSingledata('languages', 'lang_code', 'id', $default_lang);
       $dir            = getSingledata('languages', 'direction', 'id', $default_lang);
   }
   

   
?>

<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>" dir="<?php echo $dir; ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Favicons-->
    <link rel="shortcut icon" href="<?php echo $favicon_path; ?>">

    <!--==== CSS ====-->
    <link href="<?php echo $template_path; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $template_path; ?>css/font-awesome.min.css" rel="stylesheet">
    <!--    <link href="css/magnific-popup.css" rel="stylesheet">-->
    <link href="<?php echo $template_path; ?>css/animate.min.css" rel="stylesheet">
    <link href="<?php echo $template_path; ?>css/lightbox.css" rel="stylesheet">
    <!--==== OWL CAROSEL  CSS ====-->
    <link rel="stylesheet" href="<?php echo $template_path; ?>css/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo $template_path; ?>css/owl.theme.css">
    <!--==== CUSTOM CSS ====-->
    <link href="<?php echo $template_path; ?>style.css" rel="stylesheet">
    <link href="<?php echo $template_path; ?>css/responsive.css" rel="stylesheet">
    <link href="<?php echo $template_path; ?>css/sumoselect.css" rel="stylesheet">

    <?php 
    if($dir == 'rtl'){
    ?>
    <link href="<?php echo $template_path; ?>style_rtl.css" rel="stylesheet">
    <?php
    }
    ?>

    <style type="text/css">
        header,
        #scroll-top-area {
            background: <?php echo $header_bg; ?>;
            color: <?php echo $header_text; ?>;
        }
        header a,
        .main-menu ul.navbar-nav li a{
            color: <?php echo $header_text; ?>;
        }
        .main-menu ul.dropdown,
        .top-nav-user ul.dropdown {background: <?php echo $nav_bg; ?>;}
        .main-menu ul.dropdown li a:hover,
        .top-nav-user ul.dropdown li a:hover{background: <?php echo $header_bg; ?>;}

        .btn-primary {
            color: <?php echo $header_text; ?>;
            background-color: <?php echo $header_bg; ?>;
            border-color: <?php echo $header_bg; ?>;
        }

        body {
            background: <?php echo $body_bg; ?>;
            color: <?php echo $body_text; ?>;
        }
        p {color: <?php echo $body_text; ?>;}

        /** Preloader 1 **/
        h1.preloader1{color: <?php echo $header_bg; ?>;}

        /** Preloader 2 **/
        .preloader2 {border: 5px solid #ecf0f1;}
        .preloader2 .book_page {
            border-top: 5px solid #ecf0f1;
            border-bottom: 5px solid #ecf0f1;
            border-right: 5px solid #ecf0f1;
            background: <?php echo $header_bg; ?>;
        }

        @-webkit-keyframes flip {
          20% {background: <?php echo $nav_bg; ?>;}
          29.9% {background: <?php echo $nav_bg; ?>;}
          30% {background: <?php echo $header_bg; ?>;}
          60% {background: <?php echo $header_bg; ?>;}
          100% {background: <?php echo $header_bg; ?>;}
        }

        @keyframes flip {
          0% {-webkit-transform: perspective(600px) rotateY(0deg);transform: perspective(600px) rotateY(0deg);}
          20% { background: <?php echo $nav_bg; ?>;}
          29.9% { background: <?php echo $nav_bg; ?>;}
          30% {
            -webkit-transform: perspective(200px) rotateY(-90deg);
                    transform: perspective(200px) rotateY(-90deg);
            background: <?php echo $header_bg; ?>;
          }
          60% {
            -webkit-transform: perspective(200px) rotateY(-180deg);
                    transform: perspective(200px) rotateY(-180deg);
            background: <?php echo $header_bg; ?>;
          }
          100% {
            -webkit-transform: perspective(200px) rotateY(-180deg);
                    transform: perspective(200px) rotateY(-180deg);
            background: <?php echo $header_bg; ?>;
          }
        }

        /** Preloader 3 **/
        .preloader3 ul li{background: <?php echo $header_bg; ?>;}

        /** Preloader 4 **/
        .preloader4 span{background: <?php echo $header_bg; ?>;}
        @keyframes loaderBlock {55% { background-color: <?php echo $header_bg; ?>;}}
        @keyframes loaderBlockInverse {55% { background-color: <?php echo $header_bg; ?>;}}

        /** Sticky **/
        .sticky{
            position: fixed;
            z-index: 1040;
            width: 100%;
            -webkit-transition: all 0.4s ease-in-out;
            transition: all 0.4s ease-in-out;
        }
        .is_sticky .logo a{ margin-top: 10px;}
        .is_sticky .main-menu ul.navbar-nav li a{padding: 19px 13px;}
        .is_sticky .main-menu ul.navbar-nav li a.img{padding: 9px 0px;}
        .is_sticky .top-nav-user:hover ul.dropdown,
        .is_sticky .main-menu li:hover ul.dropdown {top: 58px;}
        .is_sticky .main-menu ul.dropdown li a{padding: 0 10px;}
        .is_sticky .top-nav-user li{line-height: 55px;}
    </style>
    <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- JAVASCRIPT FILES -->
        <script src="<?php echo $template_path; ?>js/jquery-2.1.4.min.js"></script>
        <script src="<?php echo $template_path; ?>js/jquery.sumoselect.js"></script>

        
        
</head>


<body class="">
      
        
<?php 
    
    // Preloader
    $preloader_1 ='
    <h1 class="preloader1">
        <span class="let1">l</span>  
        <span class="let2">o</span>  
        <span class="let3">a</span>  
        <span class="let4">d</span>  
        <span class="let5">i</span>  
        <span class="let6">n</span>  
        <span class="let7">g</span>  
    </h1>
    ';

    $preloader_2 ='
    <div class="preloader2">
        <div class="book_page"></div>
        <div class="book_page"></div>
        <div class="book_page"></div>
    </div>
    ';

    $preloader_3 ='
    <div class="preloader3">
      <ul>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
      </ul>
    </div>
    ';

    $preloader_4 ='
    <div class="preloader4">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    ';

    if(empty($preloader)){
        if ($preloader_style == 1) {
            $preloader_style = $preloader_1;
        }elseif ($preloader_style == 2) {
            $preloader_style = $preloader_2;
        }elseif ($preloader_style == 3) {
            $preloader_style = $preloader_3;
        }elseif ($preloader_style == 4) {
            $preloader_style = $preloader_4;
        }
        echo '<div class="preloader">'.$preloader_style.'</div>';
    }

    // Scroll to Top
    if(empty($scroll_to_top)){
        echo '<div id="scroll-top-area"> <i class="fa fa-angle-double-up" aria-hidden="true"></i> </div>';
    }

   

    // Get user Menu
    $user_menu = getTopNav($user_id, $isLoggedIn);

    // Get lang switch
    $lang_switch = getLangSwitch();

    // Get Default header file
    $header = '
    <header class="custom-navbar sticky navbar-fixed-top">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <div class="logo">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                        </div> 
                        <a href="'.base_url().'">
                            <span class="logo-lg">
                            <img src="'.$logo_path.'" style="max-width: 80%;"  alt="'.$site_name.'"  >
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-md-10 col-sm-10 col-xs-12">
                    <nav class="main-menu">
                        <div class="navbar-collapse collapse">
                            '.$user_menu.'
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    ';

    // Get Header template from configuration
    $headerTemplate = getConfigItem('header');
    
    // Set Placeholder
    $placeHolders = [
        '[OFFCANVAS]',
        '[LOGO]',
        '[USER_MENU]',
        '[LANG_SWITCH]',
    ];

    // Set Values
    $values = [
        '<div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> 
                <span class="sr-only">Toggle navigation</span> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> 
            </button>
        </div> ',

        '<a href="'.base_url().'">
            <span class="logo-lg">
                <img src="'.$logo_path.'" style="max-width: 80%;"  alt="'.$site_name.'"  >
            </span>
        </a>',
        $user_menu,
        $lang_switch,
    ];
    $rendered = str_replace($placeHolders, $values, $headerTemplate);
    //$rendered = nl2br($rendered);

    // if configuration for header is empty
    if(empty($headerTemplate)){
        $display_header = $header;
    }else{
        $display_header = $rendered;
    }

    echo $display_header;
?>

<div class="breadcrumbs">
    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-12"></div>
    </div>
</div>

<div class="content-area">
            