

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
            $name   = $item->name;
            $avatar = $item->avatar;
            $email  = $item->email;
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

    if($role == ROLE_TEACHER){
    	$section = 'teacher';
    	$id = getSingledata('teachers', 'id', 'userid', $userId);
        $folder_name = 'teachers';
    }elseif ($role == ROLE_PARENT) {
    	$section = 'parent';
    	$id = getSingledata('parents', 'id', 'userid', $userId);
        $folder_name = 'parents';
    }elseif ($role == ROLE_STUDENT) {
    	$section = 'student';
    	$id = getSingledata('students', 'id', 'userid', $userId);
        $folder_name = 'students';
    }else{
        $folder_name = 'users';
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

        	<div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8 pl-0">
                        <h1 class="user-page-title"><i class="fa fa-cog"></i> <?php echo getlang('site_my_account_title', 'data'); ?> </h1>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 text-right pr-0">
                        <a href="<?php echo base_url().'user/logs'; ?>" class="btn  btn-primary "><?php echo getlang('site_btn_login_activity', 'data'); ?></a>
                    </div>
                </div>
            </div>
            
            <hr>
            <?php $this->load->helper("form"); ?>
            <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url(); ?>user/account" method="post" role="form" enctype="multipart/form-data">
                <div class="box-body">
                	<ul class="nav nav-tabs">
                        <?php if($role != ROLE_SUPPER_ADMIN){ ?>
                        <li class="active"><a data-toggle="tab" href="#profile"> <?php echo getlang('site_tab_profile', 'data'); ?></a></li>
                        <?php } ?>
                        <li class=""><a data-toggle="tab" href="#account"> <?php echo getlang('site_tab_account', 'data'); ?></a></li>
                        <li><a data-toggle="tab" href="#changepass"> <?php echo getlang('site_tab_change_password', 'data'); ?></a></li>
                        <li><a data-toggle="tab" href="#photo"> <?php echo getlang('site_tab_change_photo', 'data'); ?></a></li>
                     </ul>


	                <div class="tab-content">
                        <?php if($role != ROLE_SUPPER_ADMIN){ 
                        $tab_active = '';
                            ?>
	                	<div id="profile" class="tab-pane fade in active">
	                    	<p></p>
		                    <div class="row">
		                        <div class="col-md-8">
		                       <?php
		                       	
                                    $sid = getFieldSectionID($section);
                                    $fields_list = getFieldList($sid);
                                    //var_dump($fields_list);

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
                    <?php }else{
                        $tab_active = 'active';
                    } ?>

	                    <div id="account" class="tab-pane fade in <?php echo $tab_active; ?>">
	                    	<p></p>
		                    <div class="row">
		                        <div class="col-md-8">
		                        	<?php echo fieldBuilder('input', 'name', $name, getlang('site_form_user_name', 'data'), 'required'); ?>
		                        </div>
		                    </div>
		                    <div class="row">
		                        <div class="col-md-8">
		                            <div class="form-group">
		                                <label class="col-sm-4 control-label"><?php echo getlang('site_form_email', 'data'); ?></label>
		                                <div class="col-sm-8">
		                                    <input type="text" disabled="disabled" value="<?php echo $email; ?> " name="">
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    
		                    <div class="row">
		                        <div class="col-md-8"> 
		                        	<?php echo fieldBuilder('input', 'mobile', $mobile,  getlang('site_form_phone', 'data'), 'required'); ?>
		                        </div>
		                    </div>

		                </div>
		                <p></p>
		                <div id="changepass" class="tab-pane fade">
		                	
		                	<div class="row">
		                        <div class="col-md-8">
		                            <?php 
		                            $oldpass_field = '<input type="password" class="form-control"  placeholder="'.getlang('site_form_old_password', 'data').'" name="oldPassword" maxlength="20">';
		                            echo fieldBuilder('select', 'password', $oldpass_field, $old_password, ''); ?>
		                        </div>
		                    </div>
		                    <hr>
		                    <div class="row">
		                        <div class="col-md-8">
		                            <?php 
		                            $pass1_field = '<input type="password" class="form-control"  placeholder="'.getlang('site_form_new_password', 'data').'" name="newPassword" maxlength="20">';
		                            echo fieldBuilder('select', 'password1', $pass1_field, $new_password, ''); ?>
		                            
		                        </div>
		                    </div>
		                    <div class="row">
		                        <div class="col-md-8">
		                            <?php 
		                            $pass2_field = '<input type="password" class="form-control"  placeholder="'.getlang('site_form_retype_password', 'data').'" name="cNewPassword" maxlength="20">';
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
                                        $img_path = site_url('/uploads/users/').'avator.png';
                                    }else{
                                        $img_path = site_url('/uploads/'.$folder_name).'/'.$avatar;
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
		                                    <input type="hidden"  value="<?php echo $avatar; ?>" name="old_avatar">
		                                </div>
		                            </div>
		                        </div> 
		                    </div>

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
                                    <input type="submit" class="btn btn-primary" value="<?php echo getlang('site_btn_submit', 'data'); ?>" />
                                     
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


<script src="<?php echo base_url(); ?>assets/backend/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.datepicker').datepicker({
          autoclose: true,
          format : "dd-mm-yyyy"
        });
    });
</script>