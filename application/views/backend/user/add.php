<?php 

$userId = '';
$name = '';
$avatar = '';
$email = '';
$mobile = '';
$roleId = '';
$required = 'required';
$active = '';
$verified = '';

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
        $verified = $item->is_verified;
    }

    $required = '';
}


  
?>

<div class="content-wrapper">
    <?php 
  
    if(!empty($userId)){
        $page_title = getlang('title_edit_user', 'sys_data');
    }else{
        $page_title = getlang('title_add_user', 'sys_data');
    }
    
    $page_sub_title = '';
    $page_icon = 'fa-users';
    echo sectionHeader($page_title, $page_sub_title, $page_icon); 
    ?>
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo getlang('enter_user_details', 'sys_data'); ?></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url().ADMIN_ALIAS; ?>/user/add" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8"><?php echo fieldBuilder('input', 'name', $name, getlang('full_name', 'sys_data'), 'required'); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-8"><?php echo fieldBuilder('input', 'email', $email, getlang('email', 'sys_data'), 'required'); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <?php 
                                    $pass_field = '<input type="password" class="form-control '.$required.'" id="password" name="password" maxlength="20">';
                                    echo fieldBuilder('select', 'password', $pass_field, getlang('passowrd', 'sys_data'), $required); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <?php 
                                    $pass_field = '<input type="password" class="form-control '.$required.' equalTo" id="cpassword" name="cpassword" maxlength="20">';
                                    echo fieldBuilder('select', 'cpassword',$pass_field,  getlang('retype_password', 'sys_data'), $required); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8"> <?php echo fieldBuilder('input', 'mobile', $mobile,  getlang('phone', 'sys_data'), 'required'); ?></div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="role" class="col-sm-4 control-label"><?php echo getlang('user_group', 'sys_data'); ?></label>
                                        <div class="col-sm-8">
                                        <select class="form-control required" id="role" name="role">
                                            <option value="0"><?php echo getlang('select_role', 'sys_data'); ?></option>
                                            <?php
                                            if(!empty($roles))
                                            {
                                                foreach ($roles as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->roleId; ?>" <?php if($rl->roleId == $roleId) {echo "selected=selected";} ?>><?php echo $rl->role ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="verified" class="col-sm-4 control-label"><?php echo getlang('verified', 'sys_data'); ?></label>
                                        <div class="col-sm-8">
                                        <select class="form-control required" id="verified" name="verified">
                                            <option value="1" <?php if($verified == '1'){echo 'selected="selected"';} ?> ><?php echo getlang('verified', 'sys_data'); ?></option>
                                            <option value="0" <?php if($verified == '0'){echo 'selected="selected"';} ?> ><?php echo getlang('unverified', 'sys_data'); ?></option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="active" class="col-sm-4 control-label"><?php echo getlang('status', 'sys_data'); ?></label>
                                        <div class="col-sm-8">
                                        <select class="form-control required" id="active" name="active">
                                            <option value="1" <?php if($active == '1'){echo 'selected="selected"';} ?> ><?php echo getlang('active', 'sys_data'); ?></option>
                                            <option value="0" <?php if($active == '0'){echo 'selected="selected"';} ?> ><?php echo getlang('inactive', 'sys_data'); ?></option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <?php 
                                    $image_type = getConfigItem('image_supported_type');
                                    $max_size = getConfigItem('image_supported_size');
                                    if(empty($avatar)){
                                        $img_path = site_url('/uploads/users/').'/avator.png';
                                    }else{
                                        $img_path = site_url('/uploads/users/').'/'.$avatar;
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
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-8 ">
                                    <div class="form-group">
                                        <div class="col-sm-4 control-label"></div>
                                        <div class="col-sm-8">
                                            <input type="hidden" value="<?php echo $userId; ?>" name="id">
                                            <input type="submit" class="btn btn-primary" value="<?php echo getlang('btn_submit', 'sys_data'); ?>" />
                                            <a href="<?php echo base_url().ADMIN_ALIAS; ?>/user" class="btn btn-default"  ><?php echo getlang('btn_cancel', 'sys_data'); ?></a>
                                               
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
    </section>
    
</div>

