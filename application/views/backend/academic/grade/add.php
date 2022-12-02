<?php 

$id         = '';
$name      = '';
$category        = '';
$gradepoint        = '';
$mark_from        = '';
$mark_upto       = '';
$comment       = '';
$status     = '';

if(!empty($data))
{
    foreach ($data as $item)
    {
        $id         = $item->id;
        $name      = $item->name;
        $category        = $item->category;
        $gradepoint        = $item->grade_point;
        $mark_from        = $item->mark_from;
        $mark_upto        = $item->mark_upto;
        $comment        = $item->comment;
        $status     = $item->status;
    }
}

$gradeCatlist = getGradeCategory('gcatname', $category);
$categoryField = fieldBuilder('select', 'gcatname', $gradeCatlist, getlang('gcat_name', 'sys_data'), 'required');
?>

<div class="content-wrapper">
    <?php 
    if(!empty($id)){
        $page_title = getlang('title_academic_grade_edit', 'sys_data');
    }else{
        $page_title = getlang('title_academic_grade_new', 'sys_data');
    }
    
    $page_sub_title = '';
    $page_icon = 'fa-bookmark';
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
                    <p></p>
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url().ADMIN_ALIAS; ?>/grade/add" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <?php echo fieldBuilder('input', 'gname', $name, getlang('grade_name', 'sys_data'), 'required'); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <?php echo $categoryField; ?>
                                </div>
                            </div>

                           <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <?php echo fieldBuilder('number', 'gradepoint', $gradepoint, getlang('grade_point', 'sys_data'), 'required'); ?>
                                </div>
                            </div>

                           <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <?php echo fieldBuilder('number', 'gradefrom', $mark_from, getlang('mark_from', 'sys_data'), 'required'); ?>
                                </div>
                            </div>

                           <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <?php echo fieldBuilder('number', 'gradeupto', $mark_upto, getlang('mark_upto', 'sys_data'), 'required'); ?>
                                </div>
                            </div>

                           <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <?php echo fieldBuilder('textarea', 'comment', $comment, getlang('comment', 'sys_data'), 'required'); ?>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <div class="form-group">
                                        <label for="status" class="col-sm-4 control-label"><?php echo getlang('status', 'sys_data'); ?></label>
                                        <div class="col-sm-8">
                                        <select class="form-control required" id="status" name="status">
                                            <option value="1" <?php if($status == '1'){echo 'selected="selected"';} ?> ><?php echo getlang('published', 'sys_data'); ?></option>
                                            <option value="0" <?php if($status == '0'){echo 'selected="selected"';} ?> ><?php echo getlang('unpublished', 'sys_data'); ?></option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
    
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <div class="form-group">
                                        <div class="col-sm-4 control-label"></div>
                                        <div class="col-sm-8">
                                            <input type="submit" class="btn btn-primary" value="<?php echo getlang('btn_submit', 'sys_data'); ?>" />
                                            <a href="<?php echo base_url().ADMIN_ALIAS; ?>/grade" class="btn btn-default"  ><?php echo getlang('btn_cancel', 'sys_data'); ?></a>
                                               
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" value="<?php echo $id; ?>" name="id">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
    
</div>

<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(function () {
        // instance, using default configuration.
        CKEDITOR.replace('editor');
    });
</script>


