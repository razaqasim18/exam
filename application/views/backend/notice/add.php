<?php 

$id         = '';
$title      = '';
$noticeText = '';
$groupId    = '';
$users      = '';
$status     = '';

if(!empty($data))
{
    foreach ($data as $item)
    {
        $id         = $item->id;
        $title      = $item->title;
        $noticeText = $item->noticeText;
        $groupId    = $item->groupId;
        $users      = $item->users;
        $status     = $item->status;
    }
}


?>

<div class="content-wrapper">
    <?php 
    if(!empty($id)){
        $page_title = getlang('title_edit_notice', 'sys_data');
    }else{
        $page_title = getlang('title_add_notice', 'sys_data');
    }
    
    $page_sub_title = '';
    $page_icon = 'fa-bell';
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
                    <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url().ADMIN_ALIAS; ?>/notice/add" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <?php echo fieldBuilder('input', 'title', $title, getlang('notice_title', 'sys_data'), 'required'); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <div class="form-group">
                                        <label for="status" class="col-sm-4 control-label"><?php echo getlang('notice_content', 'sys_data'); ?></label>
                                        <div class="col-sm-8">
                                        <textarea id="editor" name="noticeText" rows="10" cols="80"><?php echo $noticeText; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8">
                                    <div class="form-group">
                                        <label for="groupId" class="col-sm-4 control-label"><?php echo getlang('user_group', 'sys_data'); ?></label>
                                        <div class="col-sm-8">
                                        <select class="form-control required" id="groupId" name="groupId">
                                            <option value="0">All Group</option>
                                            <?php
                                            if(!empty($roles))
                                            {
                                                foreach ($roles as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->roleId; ?>" <?php if($rl->roleId == $groupId) {echo "selected=selected";} ?>><?php echo $rl->role ?></option>
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
                                            <a href="<?php echo base_url().ADMIN_ALIAS; ?>/notice" class="btn btn-default"  ><?php echo getlang('btn_cancel', 'sys_data'); ?></a>
                                               
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


