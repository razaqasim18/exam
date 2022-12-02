<?php
	$csrf = array(
		'name' => $this->security->get_csrf_token_name(),
		'hash' => $this->security->get_csrf_hash()
	);

	$id                     = '';
	$name                   = '';
	$department_id          = 0;
	$class_id               = 0;
	$semester               = 0;
	$term                   = '';
	$type                   = '';
	$exam_date              = '';
	$form_fillup_start_date = '';
	$form_fillup_last_date  = '';
	$form_fee               = '';
	$late_fee               = '';

	if (!empty($exam_data)) {
		foreach ($exam_data as $item) {
			$id                     = $item->id;
			$name                   = $item->name;
			$department_id          = $item->department_id;
			$class_id               = $item->class_id;
			$semester               = $item->semistar;
			$term                   = $item->term;
			$type                   = $item->type;
			$exam_date              = date('d-m-Y', strtotime($item->exam_date));
			$form_fillup_start_date = date('d-m-Y', strtotime($item->form_fillup_start_date));
			$form_fillup_last_date  = date('d-m-Y', strtotime($item->form_fillup_last_date));
			$form_fee               = $item->form_fee;
			$late_fee               = $item->late_fee;
		}
	}

	$exam_date_field              = '<input  type="text" name="exam_date" value="'.$exam_date.'" class="form-control datepicker" placeholder="'.getlang('exam_date', 'sys_data').'"/>  ';
	$form_fillup_start_date_field = '<input  type="text" name="form_fillup_start_date" value="'.$form_fillup_start_date.'" class="form-control datepicker" placeholder="Form Fillup Start Date"/>  ';
	$form_fillup_last_date_field  = '<input  type="text" name="form_fillup_last_date" value="'.$form_fillup_last_date.'" class="form-control datepicker" placeholder="Form Fillup Last Date"/>  ';

	$exam_name   = getlang('exam_name', 'sys_data');
	$date        = getlang('exam_date', 'sys_data');
	$exam_status = getlang('status', 'sys_data');

	$department      = getlang('department', 'sys_data');
	$department_list = getDepartment('department', $department_id);

	$class_name  = getlang('class_name', 'sys_data');
	$class_list  = getClassesList($class_id, false);
	$class_field = fieldBuilder('select', 'class_id', $class_list, $class_name, 'required');

?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css" />
<div class="content-wrapper">
    <?php
    	$page_title = 'Add new exam';
    	$page_icon  = 'fa-pencil';
    	echo sectionHeader($page_title, '', $page_icon);
    ?>

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
                    <?php $this->load->helper("form");?>
                    <form role="form" class="form-horizontal" id="addUser" action="<?php echo base_url().ADMIN_ALIAS; ?>/exams/add/" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6"><?php echo fieldBuilder('input', 'name', $name, $exam_name, 'required'); ?> </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo fieldBuilder('select', 'department_name', $department_list, $department, 'required'); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">                                                       <?php echo $class_field; ?></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field_id_class_id" class="col-sm-4 control-label">Semester</label>
                                        <div class="col-sm-8"><select name="semistar" id="class_id" class="form-control required" required="">
                                                <option value="" disabled="" selected="">Please Select</option>
                                                <?php

                                                	for ($i = 1; $i <= 8; $i++) {
                                                	if ($semester == $i) {?>
                                                        <option value=<?=$i?> selected="selected"> <?=$i?></option>
                                                    <?php } else {?>
                                                        <option value=<?=$i?>> <?=$i?></option>
                                                <?php }
                                                	}

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col-md-6">
                                    <label for="term" class="col-sm-4 control-label">Term</label>
                                    <div class="col-sm-8">
                                        <label class="radio-inline">
                                            <input type="radio" name="term" id="ms" value="MS" <?= ($term == 'MS') ? 'checked' : '' ?>> MS
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="term" id="es" value="ES" <?= ($term == 'ES') ? 'checked' : '' ?>> ES
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 20px;">
                                <div class="col-md-6">
                                    <label for="type" class="col-sm-4 control-label">Exam Type</label>
                                    <div class="col-sm-8">
                                        <label class="radio-inline">
                                            <input type="radio" name="type" id="Theory" value="Theory" <?= ($type == 'Theory') ? 'checked' : '' ?>> Theory
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="type" id="Practical" value="Practical" <?= ($type == 'Practical') ? 'checked' : '' ?>> Practical
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"><?php echo fieldBuilder('select', 'date_field', $exam_date_field, $date, ''); ?> </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"><?php echo fieldBuilder('select', 'date_field', $form_fillup_start_date_field, 'Form Fillup Start Date', ''); ?> </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"><?php echo fieldBuilder('select', 'date_field', $form_fillup_last_date_field, 'Form Fillup Last Date', ''); ?> </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type" class="col-sm-4 control-label">Form Fee</label>
                                        <div class="col-sm-8">
                                            <input type="number"  step="0.25" name="form_fee" id="form_fee" class="form-control" placeholder="Form Fee" value="<?= $form_fee ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type" class="col-sm-4 control-label">Late Fee</label>
                                        <div class="col-sm-8">
                                            <input type="number" step="0.25" name="late_fee" id="late_fee" class="form-control" placeholder="Late Fee" value="<?= $late_fee ?>">
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
                                            <input type="submit" class="btn btn-primary" value="<?php echo getlang('btn_submit', 'sys_data'); ?>" />
                                            <a class="btn  btn-default" href="<?php echo base_url().ADMIN_ALIAS.'/exams'; ?>" title="<?php echo getlang('btn_cancel', 'sys_data'); ?>"><?php echo getlang('btn_cancel', 'sys_data'); ?> </a>
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
    jQuery(document).ready(function() {
        jQuery('.datepicker').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy"
        });
    });
</script>