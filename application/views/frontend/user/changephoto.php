

    <?php
    $userId = '';
    $avatar = '';

    if(!empty($user_data))
    {
        foreach ($user_data as $item)
        {
            $userId = $item->userId;
            $avatar = $item->avatar;

        }

    }

    if(empty($avatar)){
        $img_path = site_url('/uploads/users').'/avator.png';
    }else{
        $img_path = site_url('/uploads/users').'/'.$avatar;
    }
	
	?>


<div class="container">

    <div class="row">
        <div class="col-md-12">
            <?php echo getSystemMessage(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 left-sidebar"> <?php echo getUserPanel($role, $uid); ?></div>

        <div class="col-xs-12 col-sm-9 col-md-9">
            <h1 class="user-page-title"><i class="fa fa-user"></i> Change Photo</h1>
            <hr>
            
            <?php $this->load->helper("form"); ?>
            <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url(); ?>user/changephoto" method="post" role="form" enctype="multipart/form-data" >
                <div class="box-body">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <?php 
                            $image_type = getConfigItem('image_supported_type');
                            $max_size = getConfigItem('image_supported_size');
                            $avatar_field = '<input type="file" id="avatar" name="avatar" onchange="readURL(this, 1, '.$max_size.', \''.$image_type.'\');" />';
                            echo fieldBuilder('select', 'avatar', $avatar_field, getlang('photo', 'sys_data'), '');

                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="col-sm-4 control-label"></div>
                                <div class="col-sm-8">
                                    <img height="180" width="180" id="preview_1" src="<?php echo $img_path; ?>" alt="avator" >
                                    <input type="hidden"  value="<?php echo $avatar; ?> " name="old_avatar">
                                </div>
                            </div>
                        </div> 
                    </div>

                    

                </div>
        
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-8 ">
                            <div class="form-group">
                                <div class="col-sm-4 control-label"></div>
                                <div class="col-sm-8">
                                    <input type="hidden" value="<?php echo $userId; ?>" name="id">
                                    <input type="submit" class="btn btn-primary" value="<?php echo getlang('submit', 'sys_data'); ?>" />
                                     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="uid" value="<?php echo $uid; ?>" />
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            </form>
        
        </div>
    </div>
</div>

