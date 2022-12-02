

   
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 left-sidebar"> <?php echo getUserPanel($role, $uid); ?></div>
        <div class="col-xs-12 col-sm-9 col-md-9">
            <h1 class="user-page-title"><i class="fa fa-user-circle"></i> <?php echo getlang('site_my_login_activity_title', 'data'); ?></h1>
            <hr>
            
                    <?php 

                       
                        $output ='<ul class="products-list product-list-in-box">';

                        if(!empty($user_data)){
                            foreach ($user_data as $key => $login) {
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
                                    <p  class="product-title"> '.$userAgent.' <span class=" pull-right">'.$login_time.'</span></p>
                                    <span class="product-description">'.$platform.' (<b>IP: </b>'.$machineIp.')</span>
                                    </div>
                                    </li>
                                ';

                            }
                        }

                        $output .='</ul>';
                        echo $output;
                    ?>

                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
        
        </div>
    </div>
</div>
