
<?php

    $avatar = '';
    if(!empty($userInfo))
    {
        foreach ($userInfo as $item)
        {
            $avatar = $item->avatar;
        }
    }

    


?>

<div class="content-wrapper">

    <?php 
    $page_title = getlang('change_avatar', 'sys_data');
    echo sectionHeader($page_title, '', ''); 
    ?>

    <section class="content">

        <div class="row">
            <div class="col-xs-12 col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    
                    <!-- form start -->
                    <form role="form" action="<?php echo base_url().ADMIN_ALIAS; ?>/user/changeavatar" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <?php 
                                    if(empty($avatar)){
                                        $img_path = site_url('/uploads/users/').'/avator.png';
                                    }else{
                                        $img_path = site_url('/uploads/users/').'/'.$avatar;
                                    }
                                    $image_type = getConfigItem('image_supported_type');
                                    $max_size = getConfigItem('image_supported_size');

                                    $avatar_field = '<input type="file" name="avatar" onchange="readURL(this, 1, '.$max_size.', \''.$image_type.'\');" />';
                                    echo fieldBuilder('select', 'avatar', $avatar_field, getlang('photo', 'sys_data'), '');

                                    ?>
                                    
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-4 control-label"></div>
                                        <div class="col-sm-8">
                                        	<p></p>
                                        	<img src="<?php echo $img_path; ?>" alt="avator" id="preview_1" >
                                            <input type="hidden" value="<?php echo $avatar; ?>" name="old_avatar">
                                        </div>
                                    </div>
                                </div> 
                            </div>

                        </div><!-- /.box-body -->

                        <div class="box-footer">
                        	<div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <div class="col-sm-4 control-label"></div>
                                        <div class="col-sm-8">
				                            <input type="submit" class="btn btn-primary" value="<?php echo getlang('btn_submit', 'sys_data'); ?>" />
				                            <a href="<?php echo base_url().ADMIN_ALIAS; ?>/user" class="btn btn-default"  ><?php echo getlang('btn_cancel', 'sys_data'); ?></a>
				                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="uid" value="<?php echo $userid; ?>" />
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    </form>
                </div>
            </div>
           
        </div>
    </section>
</div>