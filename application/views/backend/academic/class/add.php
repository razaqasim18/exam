<?php

$csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash()
);

$id = '';
$name = '';
$s_name = '';
$d_name = '';
$class_field = '';
$subject_field = '';
$department_field = '';

if (!empty($class_data)) {
    foreach ($class_data as $item) {
        $id = $item->id;
        $name = $item->name;
        $s_name = $item->subjects;
        $d_name = $item->departments;
    }
}
$class_name = getlang('class_name', 'sys_data');
$subject_name = getlang('subject_name', 'sys_data');
$department_name = getlang('department_name', 'sys_data');




$class_field = fieldBuilder('input', 'name', $name, $class_name, 'required');

$subject_list = getSubjects($s_name);
$subject_field = fieldBuilder('select', 's_name', $subject_list, $subject_name, '');

$department_list = getDepartments($d_name);
$department_field = fieldBuilder('select', 'd_name', $department_list, $department_name, '');

?>


<div class="content-wrapper class-page">

    <?php
    $page_title = getlang('title_academic_class', 'sys_data');
    $page_icon = 'fa-sitemap';
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
                    <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url() . ADMIN_ALIAS ?>/class/add/" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6"> <?php echo $class_field; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><?php echo $subject_field; ?> </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><?php echo $department_field; ?> </div>
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
                                            <a class="btn  btn-default" href="<?php echo base_url() . ADMIN_ALIAS . '/class'; ?>" title="<?php echo getlang('btn_cancel', 'sys_data'); ?> "> <?php echo getlang('btn_cancel', 'sys_data'); ?> </a>
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
    window.asd = jQuery('.subjectfield').SumoSelect({
        search: true,
        searchText: '<?php echo getlang('search_here', 'sys_data'); ?>'
    });
</script>