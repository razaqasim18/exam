
<?php

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );


    $id = '';
    $userid = '';
    $class = '';
    $department = '';
    $year = '';
    $roll = '';
    $subject = '';
    $designation = '';

    if(!empty($teachers_data))
    {
        foreach ($teachers_data as $item)
        {
            $id = $item->id;
            $userid = $item->userid;
            $class = $item->class;
            $designation = $item->designation;
            $department = $item->department;
            $subject = $item->subject;
            
        }
    }

    if(!empty($userid)){
        $name = getSingledata('users', 'name', 'userId', $userid);
        $avatar = getSingledata('users', 'avatar', 'userId', $userid);
        $mobile = getSingledata('users', 'mobile', 'userId', $userid);
    }else{
        $name = '';
        $avatar = '';
        $mobile = '';
    }
    

    $class_list      = getClassesList($class);
    $department_list = getDepartments($department);
    $subject_filed   = getSubjects($subject);
    

    $full_name        = getlang('full_name', 'sys_data');
    $designation_lang = getlang('designation', 'sys_data');
    $select_subject   = getlang('subject_name', 'sys_data');
    $class            = getlang('class_name', 'sys_data');
    $department       = getlang('department_name','sys_data');
    $avatar_name      = getlang('photo', 'sys_data');
    $submit           = getlang('btn_submit', 'sys_data');
    $cancel           = getlang('btn_cancel', 'sys_data');

?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/adminlte/plugins/datepicker/datepicker3.css" />
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> <?php echo getlang('title_teacher', 'sys_data'); ?>
      </h1>
    </section>
    
    <section class="content">

        <div class="row">
             <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <!-- <h3 class="box-title">Enter Student Details</h3> -->
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addUser" class="form-horizontal"  action="<?php echo base_url().ADMIN_ALIAS; ?>/teachers/add" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">

                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#general"> <?php echo getlang('tab_general', 'sys_data'); ?></a></li>
                                <li><a data-toggle="tab" href="#academic"> <?php echo getlang('tab_academic', 'sys_data'); ?></a></li>
                                <li><a data-toggle="tab" href="#account"> <?php echo getlang('tab_account', 'sys_data'); ?></a></li>
                                <li><a data-toggle="tab" href="#photo"> <?php echo $avatar_name; ?></a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="general" class="tab-pane fade in active">
                                    <p></p>

                                    <div class="row">
                                        <div class="col-md-6"> 
                                            <?php  echo fieldBuilder('input', 'name', $name, $full_name, 'required'); ?>
                                        </div>
                                    </div>

                                    <!-- <div class="row">
                                        <div class="col-md-6"> 
                                            <?php  //echo fieldBuilder('number', 'mobile', $mobile, $mobile_number, 'required'); ?>
                                        </div>
                                    </div>
 -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php

                                                $sid = getFieldSectionID('teacher');
                                                 
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
                                <div id="academic" class="tab-pane fade">
                                    <p></p>

                                    <div class="row">
                                        <div class="col-md-6"> 
                                            <?php  echo fieldBuilder('input', 'designation', $designation, $designation_lang, 'required'); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php  echo fieldBuilder('select', 'class_name', $class_list, $class, ''); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php  echo fieldBuilder('select', 'department_name', $department_list, $department, ''); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6"> 
                                            <?php  echo fieldBuilder('select', 'subject', $subject_filed, $select_subject, ''); ?>
                                        </div>
                                    </div>

                                </div>

                                <div id="account" class="tab-pane fade">
                                    <p></p>

                                    <?php 
                                    $email = '';
                                    $active = '';
                                    $verified = '';
                                    if(!empty($accountInfo))
                                    {
                                        foreach ($accountInfo as $account)
                                        {
                                            $email = $account->email;
                                            $active = $account->active;
                                            $verified = $account->is_verified;
                                        }
                                    }
                                    ?>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php echo fieldBuilder('input', 'email', $email, getlang('email', 'sys_data'), 'required'); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6"> <?php echo fieldBuilder('input', 'mobile', $mobile,  getlang('phone', 'sys_data'), 'required'); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php 
                                            $pass_field = '<input type="password" class="form-control required" id="password" name="password" maxlength="20">';
                                            echo fieldBuilder('select', 'password', $pass_field, getlang('passowrd', 'sys_data'), 'required'); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php 
                                            $pass_field = '<input type="password" class="form-control required equalTo" id="cpassword" name="cpassword" maxlength="20">';
                                            echo fieldBuilder('select', 'cpassword',$pass_field,  getlang('retype_password', 'sys_data'), 'required'); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
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

                                    <input type="hidden" name="role" value="<?php echo ROLE_TEACHER; ?>">
                                       
                                </div>


                                <div id="photo" class="tab-pane fade">
                                    <p></p>
                                       <div class="row">
                                            <div class="col-md-8">
                                                <?php 
                                                $image_type = getConfigItem('image_supported_type');
                                                $max_size = getConfigItem('image_supported_size');
                                                if(empty($avatar)){
                                                    $img_path = site_url('/uploads/teachers/').'/avator.png';
                                                }else{
                                                    $img_path = site_url('/uploads/teachers/').'/'.$avatar;
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

                        <!-- /.box-body -->

                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <div class="col-sm-4 control-label"></div>
                                        <div class="col-sm-8">
                                            <input type="hidden" value="<?php echo $id; ?>" name="id">
                                            <input type="submit" class="btn btn-primary" value="<?php echo $submit; ?>" /> 
                                            <a class="btn  btn-default" href="<?php echo base_url().ADMIN_ALIAS.'/teachers'; ?>" title="<?php echo getlang('cancel', 'sys_data'); ?>"> <?php echo $cancel; ?> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    </form>
                </div>
            </div>
           
        </div>    
    </section>
    
</div>

<script src="<?php echo base_url(); ?>assets/backend/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.datepicker').datepicker({
          autoclose: true,
          format : "dd-mm-yyyy"
        });
    });

    window.asd = jQuery('.subjectfield').SumoSelect({search: true, searchText: '<?php echo getlang('search_here', 'sys_data'); ?>'});
</script>