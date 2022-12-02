<?php 

$userId = '';
$name = '';
$avatar = '';
$email = '';
$mobile = '';
$roleId = '';
$required = 'required';
$active = '';
$is_verified ='';

if(!empty($user_data))
{
    foreach ($user_data as $item)
    {
        $userId = $item->userId;
        $name = $item->name;
        $avatar = $item->avatar;
        $email = $item->email;
        $mobile = $item->mobile;
        $roleId = $item->roleId;
        $active = $item->active;
        $is_verified = $item->is_verified;
    }

    $required = '';
}

if(empty($avatar)){
    $img_path = site_url('/uploads/users/').'/avator.png';
}else{
    $img_path = site_url('/uploads/users/').'/'.$avatar;
}



?>

   

<div class="content-wrapper">
    <?php 
    $page_title = $name.' '.getlang('profile', 'sys_data').'';
    $page_sub_title = '';
    $page_icon = 'fa-user';
    echo sectionHeader($page_title, $page_sub_title, $page_icon); 
    ?>
    
    <section class="content">
        <div class="row">
            <div class="col-md-3">

                <div class="box box-primary">
                <!-- Profile Image -->
                <div class="card card-primary card-outline" style="margin-top: 30px;padding-bottom: 30px;">
                    <div class="card-body box-profile">
                        <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                           src="<?php echo $img_path; ?>"
                           alt="<?php echo $name; ?>" style="width: 80%;" >

                        </div>

                        <h3 class="profile-username text-center"><?php echo $name; ?></h3>
                        <p class="text-muted text-center"><?php echo getlang('email', 'sys_data'); ?>: <b><?php echo $email; ?></b> 
                            <?php 
                            if(!empty($is_verified)){
                                echo '<span class=" label-success img-circle" title="'.getlang('verified', 'sys_data').'" style="width: 20px;height: 20px;display: inline-block;margin-left: 10px;" ><i class="fa fa-check"></i></span>';
                            }else{
                                echo '<span class="img-circle" style="background: #ccc;width: 20px;height: 20px;display: inline-block;margin-left: 10px;" title="'.getlang('unverified', 'sys_data').'"><i class="fa fa-check"></i></span>';
                            }
                            ?>
                        </p>
                        <p class="text-muted text-center">Phone: <b><?php echo $mobile; ?></b></p>
                        <p class="text-muted text-center"><?php echo getlang('status', 'sys_data'); ?>: 
                            <?php 
                            if(!empty($active)){
                                echo '<span class="label label-success">'.getlang('active', 'sys_data').'</span>';
                            }else{
                                echo '<span class="label label-danger">'.getlang('inactive', 'sys_data').'</span>';
                            }
                            ?>
                        </p>
                    </div>
                </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header">
                        
                        <h3 class="box-title"><?php echo getlang('admin_login_activity', 'sys_data'); ?></h3>
                    </div>

                    <div class="box-body">
                        
                        <?php 
                        
                        $user_login_datas = getLoginData($userId);

                        $output ='<ul class="products-list product-list-in-box">';

                        if(!empty($user_login_datas)){
                            foreach ($user_login_datas as $key => $login) {
                                
                                $session_uid = $login->userId;
                                $sessionData = $login->sessionData;
                                $machineIp = $login->machineIp;
                                $userAgent = $login->userAgent;
                                $agentString = $login->agentString;
                                $platform = $login->platform;
                                $createdDtm = $login->createdDtm;
                                $login_time = date( 'd M Y (g:i A)', strtotime($createdDtm));

                                if($platform =='Windows 10' || $platform =='Windows 8.1' || $platform =='Windows 8' || $platform =='Windows 7' || $platform =='Windows Vista' || $platform =='Windows 2003' || $platform =='Windows XP' || $platform =='Windows 2000' || $platform =='Windows NT 4.0' || $platform =='Windows NT' || $platform =='Windows 98' || $platform =='Windows 95' || $platform =='Windows Phone' || $platform =='Unknown Windows OS'){

                                    $p_image = 'windows.png';

                                }elseif ($platform =='Android') 
                                {
                                    $p_image = 'android.png';

                                }elseif ($platform =='BlackBerry') 
                                {
                                    $p_image = 'blackberry.png';

                                }elseif ($platform =='iOS' || $platform =='Mac OS X' || $platform =='Power PC Mac' || $platform =='Macintosh') 
                                {
                                    $p_image = 'mac.png';

                                }elseif ($platform =='FreeBSD') 
                                {
                                    $p_image = 'freebsd.png';

                                }elseif ($platform =='Linux' || $platform =='GNU/Linux') 
                                {
                                    $p_image = 'linux.png';

                                }elseif ($platform =='Debian') 
                                {
                                    $p_image = 'debian.png';

                                }elseif ($platform =='Sun Solaris') 
                                {
                                    $p_image = 'sunsolaris.png';

                                }elseif ($platform =='BeOS') 
                                {
                                    $p_image = 'beos.png';

                                }elseif ($platform =='ApacheBench') 
                                {
                                    $p_image = 'apachebench.png';

                                }elseif ($platform =='AIX') 
                                {
                                    $p_image = 'aix.png';

                                }elseif ($platform =='Irix') 
                                {
                                    $p_image = 'irix.png';

                                }elseif ($platform =='HP-UX') 
                                {
                                    $p_image = 'hpux.png';

                                }elseif ($platform =='NetBSD' || $platform =='BSDi' || $platform =='OpenBSD') 
                                {
                                    $p_image = 'netbsd.png';

                                }elseif ($platform =='Unknown Unix OS') 
                                {
                                    $p_image = 'unix.png';

                                }elseif ($platform =='Symbian OS') 
                                {
                                    $p_image = 'symbian.png';

                                }else{
                                    $p_image ='';
                                }


                                if(empty($p_image)){
                                    $platform_img = site_url('/uploads/users/').'/avator.png';
                                }else{
                                    $platform_img = site_url('/uploads/platform/').'/'.$p_image;
                                }

                               
                            $output .='<li class="item">
                                    <div class="product-img">
                                    <img src="'.$platform_img.'" alt="'.$platform.'" class="avatar img-circle" />
                                    </div>
                                    <div class="product-info">
                                    <span class="product-title"> '.$userAgent.' <span class="label label-success pull-right">'.$login_time.'</span></span>
                                    
                                    <span class="product-description">'.$platform.' (<b>IP: </b>'.$machineIp.')</span>
                                    </div>
                                    </li>
                                ';

                            }
                        }

                    $output .='</ul>';
                    echo $output;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    
    </section>
    
</div>


