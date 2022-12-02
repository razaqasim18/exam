<?php

// get the data and pass it to your view
$token_name = $this->security->get_csrf_token_name();
$token_hash = $this->security->get_csrf_hash();

$id         = '';
$userid     = '';
$class      = '';
$department = '';
$year       = '';
$roll       = '';
$parent_id  = '';
$subjects   = '';

$compulsory_list = getFilteredSubjects('compulsory');
$optional_list   = getFilteredSubjects('optional');
$honors_list     = getFilteredSubjects('honors');

if (!empty($studentInfo)) {
    foreach ($studentInfo as $item) {
        $id         = $item->id;
        $userid     = $item->userid;
        $class      = $item->class;
        $department = $item->department;
        $roll       = $item->roll;
        $year       = $item->year;
        $parent_id  = $item->parent;

        if (null != $item->subjects) {
            $subjects          = $item->subjects;
            $selected_subjects = unserialize($subjects);
        }

        if (isset($selected_subjects['compulsory'])) {
            $compulsory_list = getFilteredSubjects('compulsory', $selected_subjects['compulsory']);
        }

        if (isset($selected_subjects['optional'])) {
            $optional_list = getFilteredSubjects('optional', $selected_subjects['optional']);
        }

        if (isset($selected_subjects['honors'])) {
            $honors_list = getFilteredSubjects('honors', $selected_subjects['honors']);
        }
    }
}

if (!empty($userid)) {
    $name          = getSingledata('users', 'name', 'userId', $userid);
    $avatar        = getSingledata('users', 'avatar', 'userId', $userid);
    $mobile        = getSingledata('users', 'mobile', 'userId', $userid);
    $parent_name   = getSingledata('users', 'name', 'userId', $parent_id);
    $parent_avatar = getSingledata('users', 'avatar', 'userId', $parent_id);
} else {
    $name          = '';
    $avatar        = '';
    $mobile        = '';
    $parent_name   = '';
    $parent_avatar = '';
}

if (!empty($parent_avatar)) {
    if (empty($parent_avatar)) {
        $img_path = site_url('/uploads/parents/') . '/avator.png';
    } else {
        $img_path = site_url('/uploads/parents/') . '/' . $parent_avatar;
    }

    $show_parent = 'display: block;';

    $html = '<div class="parent_list ">
                    <img src="' . $img_path . '" alt="' . $parent_name . '" class="avatar">
                    <span>' . $parent_name . '</span>
                </div>';
} else {
    $parent_name = '';
    $html        = '';
    $show_parent = '';
}

$class_list      = getClass($class);
$department_list = getDepartment('department', $department);
$year_field      = getAcademicYearList('year', $year);

$full_name   = getlang('full_name', 'sys_data');
$roll_no     = getlang('roll', 'sys_data');
$select_year = getlang('select_year', 'sys_data');
$class       = getlang('select_class', 'sys_data');
$department  = getlang('select_department', 'sys_data');
$avatar_name = getlang('photo', 'sys_data');
$submit      = getlang('btn_submit', 'sys_data');
$cancel      = getlang('btn_cancel', 'sys_data');

$base_controler = base_url() . ADMIN_ALIAS . "/students/parent";

$compulsory_subject = getlang('compulsory_subject', 'sys_data');
$honors_subject     = getlang('honors_subject', 'sys_data');
$optional_subject   = getlang('optional_subject', 'sys_data');

$compulsory = '';
$optional   = '';
$honors     = '';

$compulsory = fieldBuilder('select', 's_name', $compulsory_list, $compulsory_subject, '');

$optional = fieldBuilder('select', 's_name', $optional_list, $optional_subject, '');

$honors = fieldBuilder('select', 's_name', $honors_list, $honors_subject, '');

?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/adminlte/plugins/datepicker/datepicker3.css" />
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> <?php echo getlang('title_student', 'sys_data'); ?>
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

                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>

                    <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url() . ADMIN_ALIAS; ?>/students/add" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">

                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#general"> <?php echo getlang('tab_general', 'sys_data'); ?></a></li>
                                <li><a data-toggle="tab" href="#academic"> <?php echo getlang('tab_academic', 'sys_data'); ?></a></li>
                                <li><a data-toggle="tab" href="#account"> <?php echo getlang('tab_account', 'sys_data'); ?></a></li>
                                <li><a data-toggle="tab" href="#subject"> <?php echo getlang('tab_subject', 'sys_data'); ?></a></li>

                            </ul>

                            <div class="tab-content">

                                <div id="general" class="tab-pane fade in active">
                                    <p></p>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php echo fieldBuilder('input', 'name', $name, $full_name, 'required'); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php

                                            $sid         = getFieldSectionID('student');
                                            $fields_list = getFieldList($sid);

                                            foreach ($fields_list as $field) {
                                                $fid      = $field->id;
                                                $sid      = $sid;
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
                                            <?php echo fieldBuilder('input', 'roll', $roll, $roll_no, 'required'); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php echo fieldBuilder('select', 'class_name', $class_list, $class, ''); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php echo fieldBuilder('select', 'department_name', $department_list, $department, ''); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php echo fieldBuilder('select', 'year', $year_field, $select_year, ''); ?>
                                        </div>
                                    </div>
                                </div>

                                <div id="account" class="tab-pane fade">
                                    <p></p>

                                    <?php
                                    $email    = '';
                                    $active   = '';
                                    $verified = '';

                                    if (!empty($accountInfo)) {
                                        foreach ($accountInfo as $account) {
                                            $email    = $account->email;
                                            $active   = $account->active;
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
                                        <div class="col-md-6"> <?php echo fieldBuilder('input', 'mobile', $mobile, getlang('phone', 'sys_data'), 'required'); ?></div>
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
                                            echo fieldBuilder('select', 'cpassword', $pass_field, getlang('retype_password', 'sys_data'), 'required'); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="verified" class="col-sm-4 control-label"><?php echo getlang('verified', 'sys_data'); ?></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control required" id="verified" name="verified">
                                                        <option value="1" <?php
                                                                            if ($verified == '1') {
                                                                                echo 'selected="selected"';
                                                                            }
                                                                            ?>><?php echo getlang('verified', 'sys_data'); ?></option>
                                                        <option value="0" <?php
                                                                            if ($verified == '0') {
                                                                                echo 'selected="selected"';
                                                                            }
                                                                            ?>><?php echo getlang('unverified', 'sys_data'); ?></option>
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
                                                        <option value="1" <?php
                                                                            if ($active == '1') {
                                                                                echo 'selected="selected"';
                                                                            }
                                                                            ?>><?php echo getlang('active', 'sys_data'); ?></option>
                                                        <option value="0" <?php
                                                                            if ($active == '0') {
                                                                                echo 'selected="selected"';
                                                                            }
                                                                            ?>><?php echo getlang('inactive', 'sys_data'); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="role" value="<?php echo ROLE_STUDENT; ?>">

                                </div>

                                <div id="subject" class="tab-pane fade">
                                    <p></p>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php echo $compulsory ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php echo $optional ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php echo $honors ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>



                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <div class="col-sm-4 control-label"></div>
                                        <div class="col-sm-8">
                                            <input type="hidden" value="<?php echo $id; ?>" name="id">
                                            <input type="submit" class="btn btn-primary" value="<?php echo $submit; ?>" />
                                            <a class="btn  btn-default" href="<?php echo base_url() . ADMIN_ALIAS . '/students'; ?>" title="<?php echo getlang('cancel', 'sys_data'); ?>"><?php echo $cancel; ?> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="csrf" name="<?php echo $token_name; ?>" value="<?php echo $token_hash; ?>" />
                    </form>
                </div>
            </div>

        </div>
    </section>

</div>

<script src="<?php echo base_url(); ?>assets/backend/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    window.asd = jQuery('.subjectfield').SumoSelect({
        search: true,
        searchText: '<?php echo getlang('search_here', 'sys_data'); ?>'
    });
    jQuery(document).ready(function() {
        jQuery('.datepicker').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy"
        });
    });

    // Get Keyup event
    jQuery("#parent_name").keyup(function() {
        // Get Data
        var val = jQuery("#parent_name").val();
        var hashValue = jQuery('#csrf').val();

        // check value
        if (val) {

            // Get show loading
            jQuery('#parent_suggestions').show();
            jQuery("#parent_suggestions").html("<?php echo getlang('loadding', 'sys_data'); ?>");

            // Get jquery post for ajax task
            jQuery.post('<?php echo $base_controler; ?>', {
                val: val,
                '<?php echo $this->security->get_csrf_token_name(); ?>': hashValue
            }, function(data) {

                // Get return data to decode
                var obj = jQuery.parseJSON(data);
                // Get csrf new hash value
                var new_hash = obj.csrfHash;
                // Set csrf new hash value update
                jQuery('#csrf').val(new_hash);
                // Show suggestion box
                jQuery('#parent_suggestions').fadeIn();
                jQuery("#parent_suggestions").html(obj.html);
            });
        } else {
            // Set fadeout suggestion box
            jQuery('#parent_suggestions').fadeOut();
        }
    });

    // Get look parent
    function lookparent(oname, ovalue) {
        jQuery("#parent_name").val(oname);
        jQuery("#parent_id").val(ovalue);
        jQuery("#parent_suggestions").fadeOut();
    }
</script>