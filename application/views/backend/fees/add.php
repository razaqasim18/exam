<?php 

$id         = '';
$title      = '';
$fee        = '';
$status     = '';

if(!empty($data))
{
    foreach ($data as $item)
    {
        $id         = $item->id;
        $title      = $item->title;
        $fee        = $item->fee;
        $status     = $item->status;
    }
}


?>

<div class="content-wrapper">
    <?php 
    if(!empty($id)){
        $page_title = getlang('title_edit_fees', 'sys_data');
    }else{
        $page_title = getlang('title_add_fees', 'sys_data');
    }
    
    $page_sub_title = '';
    $page_icon = 'fa-usd';
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
                    <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url().ADMIN_ALIAS; ?>/fees/add" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <?php echo fieldBuilder('input', 'title', $title, getlang('fees_title', 'sys_data'), 'required'); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <?php echo fieldBuilder('number', 'fee', $fee, 'Fee', 'required'); ?>
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
                                            <a href="<?php echo base_url().ADMIN_ALIAS; ?>/fees" class="btn btn-default"  ><?php echo getlang('btn_cancel', 'sys_data'); ?></a>
                                               
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


