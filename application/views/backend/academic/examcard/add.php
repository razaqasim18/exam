<?php

$csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash()
);

$id         = '';
$year = '';
$class_id   = 0;
$department_id = 0;
$semester = '';
$paper       = '';


if (!empty($examcard_data)) {
    foreach ($examcard_data as $item) {
        $id         = $item->id;
        $year        = $item->year;
        $department_id = $item->department_id;
        $class_id   = $item->class_id;
        $semester       = $item->semistar;
        $paper = explode(",", $item->paper);
    }
}


$select_year = getlang('select_year', 'sys_data');
$department  = getlang('select_department', 'sys_data');
$class_name   = getlang('class_name', 'sys_data');
$semesterlbl  = getlang('semester', 'sys_data');


$year_field      = getAcademicYearList('year', $year);
$department_list = getDepartment('department', $department_id);

$class_list  = getClassesList($class_id, false);
$class_field = fieldBuilder('select', 'class_id', $class_list, $class_name, 'required');

?>


<div class="content-wrapper class-page">

    <?php
    $page_title = getlang('title_academic_examcards', 'sys_data');
    $page_icon  = 'fa-sitemap';
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
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addExamCard" class="form-horizontal" action="<?php echo base_url() . ADMIN_ALIAS ?>/examcards/add" method="POST" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo fieldBuilder('select', 'year', $year_field, $select_year, 'required'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo fieldBuilder('select', 'department_name', $department_list, $department, 'required'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"> <?php echo $class_field; ?></div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field_id_class_id" class="col-sm-4 control-label">Semester</label>
                                        <div class="col-sm-8"><select name="semester" id="class_id" class="form-control required" required="">
                                                <option value="" disabled="" selected="">Please Select</option>
                                                <?php
                                                for ($i = 1; $i <= 8; $i++) {
                                                    if ($semester == $i) { ?>
                                                        <option value=<?= $i ?> selected="selected"> <?= $i ?></option>
                                                    <?php } else { ?>
                                                        <option value=<?= $i ?>> <?= $i ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field_id_class_id" class="col-sm-4 control-label">Paper</label>
                                        <div class="col-sm-8">
                                            <select name="paper[]" id="class_id" class="form-control required paperfield" required multiple="multiple">
                                                <option value="" disabled="" selected="">Please Select</option>
                                                <?php
                                                for ($i = 1; $i <= 10; $i++) {
                                                    if (in_array($i, $paper)) { ?>
                                                        <option value=<?= $i ?> selected="selected"> <?= $i ?></option>
                                                    <?php } else { ?>
                                                        <option value=<?= $i ?>> <?= $i ?></option>
                                                <?php }
                                                } ?>
                                            </select>
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
                                            <a class="btn  btn-default" href="<?php echo base_url() . ADMIN_ALIAS . '/examcards'; ?>" title="<?php echo getlang('btn_cancel', 'sys_data'); ?> "><?php echo getlang('btn_cancel', 'sys_data'); ?> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                    </form>
                </div>
            </div>

        </div>
    </section>

</div>

<script type="text/javascript">
    window.asd = jQuery('.paperfield').SumoSelect({
        search: true,
        searchText: '<?php echo getlang('search_here', 'sys_data'); ?>'
    });
</script>