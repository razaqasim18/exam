<?php

$csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash()
);

$id         = '';
$class_id   = 0;
$subject_id = 0;
$name       = '';
$code       = '';

if (!empty($course_data)) {
    foreach ($course_data as $item) {
        $id         = $item->id;
        $class_id   = $item->class_id;
        $subject_id = $item->subject_id;
        $name       = $item->name;
        $code       = $item->code;
    }
}

$class_name   = getlang('class_name', 'sys_data');
$subject_name = getlang('subject_name', 'sys_data');
$course_name  = getlang('course_name', 'sys_data');
$course_code  = getlang('course_code', 'sys_data');
$paper_code  = getlang('paper_code', 'sys_data');

$class_list  = getClassesList($class_id, false);
$class_field = fieldBuilder('select', 'class_id', $class_list, $class_name, 'required');

$subject_list  = getSubjectsByClass($class_id, $subject_id);
$subject_field = fieldBuilder('select', 'class_id', $subject_list, $subject_name, 'required');

$course_name_field = fieldBuilder('input', 'name', $name, $course_name, 'required');
$course_code_field = fieldBuilder('input', 'code', $code, $course_code, 'required');

?>


<div class="content-wrapper class-page">

    <?php
    $page_title = getlang('title_academic_courses', 'sys_data');
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
                    <form role="form" id="addCourse" class="form-horizontal" action="<?php echo base_url() . ADMIN_ALIAS ?>/courses/add/" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6"> <?php echo $class_field; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><?php echo $subject_field; ?> </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><?php echo $course_name_field; ?> </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><?php echo $course_code_field; ?> </div>
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
                                            <a class="btn  btn-default" href="<?php echo base_url() . ADMIN_ALIAS . '/courses'; ?>" title="<?php echo getlang('btn_cancel', 'sys_data'); ?> "><?php echo getlang('btn_cancel', 'sys_data'); ?> </a>
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
$("#class_id").on("change", function(){
    $.ajax({
            url: '<?php echo base_url() . ADMIN_ALIAS . '/courses/loadsubjects'; ?>',
            data: {
                class_id: $("#class_id").val()
            },
            success: function(html){       
               $("#subject_id").html(html);
            },
        });
});

</script>