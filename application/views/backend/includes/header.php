<?php
// Get Theme data
$theme = getConfigItem('default_theme');
$lang_id = getConfigItem('default_language');

// Get favicon
$favicon = getConfigItem('default_favicon');
if (empty($favicon)) {
    $favicon_path = site_url('/uploads/logo/') . '/favicon.png';
} else {
    $favicon_path = site_url('/uploads/logo/') . '/' . $favicon;
}

// Get user avatar
$avatar = getSingledata('users', 'avatar', 'userId', $userid);
if (empty($avatar)) {
    $img_path = site_url('/uploads/users/') . '/avator.png';
} else {
    $img_path = site_url('/uploads/users/') . '/' . $avatar;
}

// Get site name
$site_name = getConfigItem('site_name');

// Get Site logo
$icon = getConfigItem('second_logo');
if (empty($logo)) {
    $logo_path = site_url('/uploads/logo/') . '/logo2.png';
} else {
    $logo_path = site_url('/uploads/logo/') . '/' . $logo;
}

// Get icon
$icon = getConfigItem('default_icon');
if (empty($icon)) {
    $icon_path = site_url('/uploads/logo/') . '/icon.png';
} else {
    $icon_path = site_url('/uploads/logo/') . '/' . $icon;
}

// Get total new students
$new_student = getNewStudent();

// Get total new parent
$new_parent = getNewParent();

// Get total new teacher
$new_teacher = getNewTeacher();

// Get directory
$default_lang = getConfigItem('default_language');
$active_lang_id = $this->session->userdata('site_lang');
if (!empty($active_lang_id)) {
    $lang_code      = getSingledata('languages', 'lang_code', 'id', $active_lang_id);
    $dir            = getSingledata('languages', 'direction', 'id', $active_lang_id);
} else {
    $lang_code      = getSingledata('languages', 'lang_code', 'id', $default_lang);
    $dir            = getSingledata('languages', 'direction', 'id', $default_lang);
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>" dir="<?php echo $dir; ?>">

<head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="<?php echo $favicon_path; ?>">
    <?php echo setAdminCSS('adminlte'); ?>

    <?php
    if ($dir == 'rtl') {
    ?>
        <link href="<?php echo base_url(); ?>assets/backend/adminlte/css/rtl.css" rel="stylesheet" />
    <?php
    }
    ?>

    <style>
        .error {
            color: red;
            font-weight: normal;
        }
    </style>

    <?php echo setAdminJS('adminlte'); ?>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>

<body class="<?php echo $theme; ?> sidebar-mini">


    <aside class="control-sidebar control-sidebar-dark ">
        <div class="tab-content">
            <div class="form-group">
                <label class="control-sidebar-subheading">Set Language</label>
                <select class="form-control" onchange="javascript:window.location.href='<?php echo base_url() . ADMIN_ALIAS; ?>/lang/'+this.value;">
                    <?php
                    $list = getLanguageObj();
                    foreach ($list as $key => $item) { ?>
                        <option value="<?php echo $item->id; ?>" <?php if ($this->session->userdata('site_lang') == $item->id) echo 'selected="selected"'; ?>><?php echo $item->title; ?></option>
                    <?php } ?>
                </select>
            </div>

        </div>
    </aside>


    <div class="wrapper">

        <header class="main-header">

            <!-- Logo -->
            <a href="<?php echo base_url(); ?>" class="logo">
                <span class="logo-mini">
                    <img src="<?php echo $icon_path; ?>" style="max-width: 80%;" alt="<?php echo $site_name; ?>">
                </span>

                <span class="logo-lg">
                    <img src="<?php echo $logo_path; ?>" style="max-width: 80%;" alt="<?php echo $site_name; ?>">
                </span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">

                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span></a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <li class="dropdown user user-menu">
                            <a href="<?php echo base_url(); ?>" class="" target="_blank">
                                <i class="fa fa-globe"></i>
                                <span class="">My Site</span>
                            </a>
                        </li>


                        <!-- Language -->
                        <li class="dropdown user user-menu">

                        </li>

                        <!-- User Account -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img style="width: 20px; height: 20px;" src="<?php echo $img_path; ?>" class="img-circle" alt="User Image" />
                                <span class="hidden-xs"><?php echo $name; ?></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="<?php echo $img_path; ?>" class="img-circle" alt="User Image" />
                                    <p><?php echo $name; ?><small><?php echo $role_text; ?></small></p>
                                </li>

                                <li class="user-footer">
                                    <div class="">
                                        <a style="width: 100%;margin-bottom: 10px;" href="<?php echo base_url() . ADMIN_ALIAS; ?>/user/profile/<?php echo $userid; ?>" class="btn btn-default btn-flat"><i class="fa fa-lock"></i> <?php echo getlang('btn_check_login_activity', 'sys_data'); ?></a>
                                        <a style="width: 100%;margin-bottom: 10px;" href="<?php echo base_url() . ADMIN_ALIAS; ?>/user/changeavatar" class="btn btn-default btn-flat"><i class="fa fa-user"></i> <?php echo getlang('btn_change_avatar', 'sys_data'); ?></a>
                                        <a style="width: 100%;margin-bottom: 10px;" href="<?php echo base_url() . ADMIN_ALIAS; ?>/user/changepassword" class="btn btn-default btn-flat"><i class="fa fa-key"></i> <?php echo getlang('btn_change_password', 'sys_data'); ?></a>
                                    </div>
                                    <div class="">
                                        <a style="width: 100%;margin-bottom: 10px;" href="<?php echo base_url() . ADMIN_ALIAS; ?>/logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> <?php echo getlang('btn_logout', 'sys_data'); ?></a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li>


                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">

                <ul class="sidebar-menu">
                    <li class="treeview">
                        <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/dashboard">
                            <i class="fa fa-dashboard"></i>
                            <span><?php echo getlang('menu_dashboard', 'sys_data'); ?></span>
                        </a>
                    </li>

                    <li class="treeview">
                        <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/academic">
                            <i class="fa fa-home"></i>
                            <span><?php echo getlang('menu_academics', 'sys_data'); ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>

                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/academic">
                                    <i class="fa fa-home"></i>
                                    <span><?php echo getlang('menu_academics', 'sys_data'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/academicyear">
                                    <i class="fa fa-clock-o"></i>
                                    <span><?php echo getlang('menu_year', 'sys_data'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/subjects">
                                    <i class="fa fa-book"></i>
                                    <span><?php echo getlang('menu_subjects', 'sys_data'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/departments">
                                    <i class="fa fa-sitemap"></i>
                                    <span><?php echo getlang('menu_department', 'sys_data'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/class">
                                    <i class="fa fa-th-large"></i>
                                    <span><?php echo getlang('menu_class', 'sys_data'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/courses">
                                    <i class="fa fa-certificate"></i>
                                    <span><?php echo getlang('menu_courses', 'sys_data'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/examcards">
                                    <i class="fa fa-book"></i>
                                    <span><?php echo getlang('menu_examcard', 'sys_data'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/exams">
                                    <i class="fa fa-graduation-cap"></i>
                                    <span><?php echo getlang('menu_exams', 'sys_data'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/exams/form_entries/list">
                                    <i class="fa fa-file-text-o"></i>
                                    <span>Exam Form Entries</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/grade">
                                    <i class="fa fa-bookmark"></i>
                                    <span><?php echo getlang('menu_grade', 'sys_data'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/gcategory">
                                    <i class="fa fa-bookmark"></i>
                                    <span><?php echo getlang('menu_grade_category', 'sys_data'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/mark">
                                    <i class="fa fa-star"></i>
                                    <span><?php echo getlang('menu_marks', 'sys_data'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="treeview">
                        <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/students">
                            <i class="fa fa-users"></i>
                            <span><?php echo getlang('menu_students', 'sys_data'); ?></span>

                            <?php if (!empty($new_student)) : ?>
                                <span class="pull-right-container">
                                    <small class="label pull-right bg-red"><?php echo $new_student; ?></small>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>

                    <li class="treeview">
                        <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/teachers">
                            <i class="fa fa-users"></i>
                            <span><?php echo getlang('menu_teachers', 'sys_data'); ?></span>
                            <?php if (!empty($new_teacher)) : ?>
                                <span class="pull-right-container">
                                    <small class="label pull-right bg-red"><?php echo $new_teacher; ?></small>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>

                    <li class="treeview">
                        <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/parents">
                            <i class="fa fa-users"></i>
                            <span><?php echo getlang('menu_parents', 'sys_data'); ?></span>
                            <?php if (!empty($new_parent)) : ?>
                                <span class="pull-right-container">
                                    <small class="label pull-right bg-red"><?php echo $new_parent; ?></small>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>







                    <li class="treeview">
                        <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/user">
                            <i class="fa fa-users"></i>
                            <span><?php echo getlang('menu_users', 'sys_data'); ?></span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/notice">
                            <i class="fa fa-bell"></i>
                            <span><?php echo getlang('menu_notices', 'sys_data'); ?></span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/course/inquiry">
                            <i class="fa fa-bell"></i>
                            <span><?php echo $result = (getlang('menu_course_inquiry', 'sys_data') != "") ? getlang('menu_course_inquiry', 'sys_data'):"Course Inquiry"; ?></span>
                        </a>
                    </li>
                    
                    <li class="treeview">
                        <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/setting">
                            <i class="fa fa-cog"></i>
                            <span><?php echo getlang('menu_setting', 'sys_data'); ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/fields">
                                    <i class="fa fa-cog"></i>
                                    <span><?php echo getlang('menu_field_builder', 'sys_data'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/languages">
                                    <i class="fa fa-language"></i>
                                    <span><?php echo getlang('menu_languages', 'sys_data'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/configuration">
                                    <i class="fa fa-cog"></i>
                                    <span><?php echo getlang('menu_configuration', 'sys_data'); ?></span>
                                </a>
                            </li>

                        </ul>
                    </li>
                </ul>
            </section>
        </aside>