

    <?php
    $id = '';
    $userId = '';
    $name = '';
    $avatar = '';
    $email = '';
    $mobile = '';
    $section = '';
    if(!empty($user_data))
    {

        foreach ($user_data as $item)
        {
            $userId = $item->userId;
            $name = $item->name;
            $avatar = $item->avatar;
            $email = $item->email;
            $mobile = $item->mobile;

        }

    }
   
	

    // if(empty($avatar)){
    //     $img_path = site_url('/uploads/teachers').'/avator.png';
    // }else{
    //     $img_path = site_url('/uploads/teachers').'/'.$avatar;
    // }

    $new_password = getlang('site_form_new_password', 'data');
    $confirm_password = getlang('site_form_retype_password', 'data');
    $old_password = getlang('site_form_old_password', 'data');

    // if($roleId == ROLE_TEACHER){
    //     $folder_name = 'teachers';
    // }elseif ($roleId == ROLE_PARENT) {
    //     $folder_name = 'parents';
    // }elseif ($roleId == ROLE_STUDENT) {
    //     $folder_name = 'students';
    // }else{
    //     $folder_name = 'users';
    // }		

    if ($role = ROLE_STUDENT) {
   		$sid = 1;
   		$folder_name = 'students';
   		$id = getSingledata('students', 'id', 'userid', $userId);
   	}elseif ($role = ROLE_TEACHER) {
   		$sid = 2;
   		$folder_name = 'teachers';
   		$id = getSingledata('teachers', 'id', 'userid', $userId);
   	}elseif ($role = ROLE_PARENT) {
   		echo "ok";
   		return false;
   		$sid = 3;
   		$folder_name = 'parents';
   		$id = getSingledata('parents', 'id', 'userid', $userId);
   	}else{

   	}
    
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
        	<!-- <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8 pl-0">
                        <h1 class="user-page-title"><i class="fa fa-cog"></i> <?php echo getlang('site_my_account_title', 'data'); ?> </h1>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 text-right pr-0">
                        <a href="<?php echo base_url().'user/logs'; ?>" class="btn  btn-primary "><?php echo getlang('site_btn_login_activity', 'data'); ?></a>
                    </div>
                </div>
            </div> -->
         </div>
            <hr>
            <?php $this->load->helper("form"); ?>
            <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url(); ?>user/account" method="post" role="form" enctype="multipart/form-data">
                <div class="box-body">
                	<ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#profile"> <?php echo getlang('site_tab_profile', 'data'); ?></a></li>
                        <li class=""><a data-toggle="tab" href="#account"> <?php echo getlang('site_tab_account', 'data'); ?></a></li>
                        <li><a data-toggle="tab" href="#changepass"> <?php echo getlang('site_tab_change_password', 'data'); ?></a></li>
                        <li><a data-toggle="tab" href="#photo"> <?php echo getlang('site_tab_change_photo', 'data'); ?></a></li>
                     </ul>


	                <div class="tab-content">


	                	  <div id="profile" class="tab-pane fade in active">
	                    	<p></p>
		                    <div class="row">
		                        <div class="col-md-8">
		                       <?php
		                       	
                                    //$sid = getFieldSectionID('student');
                                    $fields_list = getFieldList($sid);

                                    foreach($fields_list as $field){
                                        $fid = $field->id;
                                        $sid = $sid;
                                        $panel_id = $id;
                                        echo fieldshow($fid, $sid, $panel_id, $field->field_name, $field->type, $field->required);
                                    }

                                ?>			
		                        </div>
		                    </div>
		                </div>

	                    <div id="account" class="tab-pane fade in">
	                    	<p></p>
		                    <div class="row">
		                        <div class="col-md-8">
		                        	<?php echo fieldBuilder('input', 'name', $name, getlang('user_name', 'sys_data'), 'required'); ?>
		                        </div>
		                    </div>
		                    <div class="row">
		                        <div class="col-md-8">
		                            <div class="form-group">
		                                <label class="col-sm-4 control-label"><?php echo getlang('email', 'sys_data'); ?></label>
		                                <div class="col-sm-8">
		                                    <input type="text" disabled="disabled" value="<?php echo $email; ?> " name="">
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    
		                    <div class="row">
		                        <div class="col-md-8"> 
		                        	<?php echo fieldBuilder('input', 'mobile', $mobile,  getlang('phone', 'sys_data'), 'required'); ?>
		                        </div>
		                    </div>

		                </div>
		                <p></p>
		                <div id="changepass" class="tab-pane fade">
		                	
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

		                <div id="photo" class="tab-pane fade">
		                	<p></p>

		                	<div class="row">
		                        <div class="col-md-8">
		                            <?php 
		                           $image_type = getConfigItem('image_supported_type');
                                    $max_size = getConfigItem('image_supported_size');
                                    if(empty($avatar)){
                                        $img_path = site_url('/uploads/user/').'/avator.png';
                                    }else{
                                        $img_path = site_url('/uploads/'.$folder_name.'/').'/'.$avatar;
                                    }
		                            $avatar_field = '<input type="file" id="avatar" name="avatar" onchange="readURL(this, 1, '.$max_size.', \''.$image_type.'\');" />';
		                            echo fieldBuilder('select', 'avatar', $avatar_field, getlang('photo', 'sys_data'), '');

		                            ?>
		                        </div>
		                    </div>
		                    <div class="row">
		                        <div class="col-md-8">
		                            <div class="form-group">
		                                <div class="col-sm-4 control-label"></div>
		                                <div class="col-sm-8">
		                                    <img height="180" width="180" id="preview_1" src="<?php echo $img_path; ?>" alt="avator" >
		                                    <input type="hidden"  value="<?php echo $avatar; ?> " name="old_avatar">
		                                </div>
		                            </div>
		                        </div> 
		                    </div>

		                </div>

		                <div id="activity" class="tab-pane fade">
		                	 <?php 

		                        $user_login_datas = getLoginData($userId);

		                        $output ='<ul class="products-list product-list-in-box">';

		                        if(!empty($user_login_datas)){
		                            foreach ($user_login_datas as $key => $login) {
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
		                </div>
		            </div>

                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-8 ">
                            <div class="form-group">
                                <div class="col-sm-4 control-label"></div>
                                <div class="col-sm-8">
                                    <input type="hidden" value="<?php echo $userId; ?>" name="id">
                                    <input type="submit" class="btn btn-primary" value="<?php echo getlang('submit', 'sys_data'); ?>" />
                                     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            </form>
        
        </div>
    </div>
</div>
