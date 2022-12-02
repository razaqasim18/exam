<?php 

$id         = '';
$name      = '';
$cat_mark        = '';
$status     = '';

if(!empty($data))
{
    foreach ($data as $item)
    {
        $id              = $item->id;
        $name            = $item->name;
        $cat_mark        = $item->mark;
        $status          = $item->status;
    }
}


?>

<div class="content-wrapper">
    <?php 
    if(!empty($id)){
        $page_title = getlang('title_academic_grade_category_edit', 'sys_data');
    }else{
        $page_title = getlang('title_academic_grade_category_add', 'sys_data');
    }
    
    $page_sub_title = '';
    $page_icon = 'fa-list-alt';
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
                    <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url().ADMIN_ALIAS; ?>/gcategory/add" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <?php echo fieldBuilder('input', 'gcategory', $name, getlang('gcat_name', 'sys_data'), 'required'); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <?php echo fieldBuilder('number', 'gcatmark', $cat_mark, getlang('mark', 'sys_data'), 'required'); ?>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <div class="form-group">
                                        <label for="status" class="col-sm-4 control-label">Status</label>
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
                                            <a href="<?php echo base_url().ADMIN_ALIAS; ?>/gcategory" class="btn btn-default"  ><?php echo getlang('btn_cancel', 'sys_data'); ?></a>
                                               
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


