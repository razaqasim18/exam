
<div class="content-wrapper">
    
    

    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-12">
            <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-6 title-bar">
            	<h1><i class="fa fa-users"></i> <?php echo getlang('title_user', 'sys_data'); ?> </h1>
            </div>

            <div class="col-xs-12 col-md-6 text-right">
            	<a class="btn btn-primary" href="<?php echo base_url().ADMIN_ALIAS; ?>/user/add"><i class="fa fa-plus"></i> <?php echo getlang('btn_add', 'sys_data'); ?></a>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    	
	                    <form action="<?php echo base_url().ADMIN_ALIAS; ?>/user" method="POST" id="searchList">
                        <div class="container-fluid">
                        	
                            <div class="row">
                                <div class="col-sm-3 " style="padding-left: 0;">
                                    <div class="input-group">
                                    <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" placeholder="<?php echo getlang('search', 'sys_data'); ?>"/>
                                    <div class="input-group-btn">
                                    <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                    </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="verified" class=" col-sm-6 control-label"><?php echo getlang('show_verified', 'sys_data'); ?></label>
                                        <div class="col-sm-6" style="padding-right: 0;">
                                            <select name="verified_value"  onchange="this.form.submit()"  class="form-control">
                                                <option value="0" ><?php echo getlang('select', 'sys_data'); ?></option>
                                                <option value="verified" <?php if($verified_value == 'verified'){echo 'selected="selected"';} ?> ><?php echo getlang('verified', 'sys_data'); ?></option>
                                                <option value="unverified" <?php if($verified_value == 'unverified'){echo 'selected="selected"';} ?> ><?php echo getlang('unverified', 'sys_data'); ?></option>
                                            </select> 
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="status" class=" col-sm-6 control-label"><?php echo getlang('show_status', 'sys_data'); ?></label>
                                        <div class="col-sm-6" style="padding-right: 0;">
                                            <select name="status_value" onchange="this.form.submit()"  class="form-control input-sm">
                                                <option value="0" >Select</option>
                                                <option value="active" <?php if($status_value == 'active'){echo 'selected="selected"';} ?> >Active</option>
                                                <option value="inactive" <?php if($status_value == 'inactive'){echo 'selected="selected"';} ?> >Inactive</option>
                                                <option value="trush" <?php if($status_value == 'trush'){echo 'selected="selected"';} ?> >Trush</option>
                                            </select> 
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3" style="padding-right: 0;">
                                    <div class="form-group">
                                        <label for="group" class=" col-sm-6 control-label"><?php echo getlang('show_group', 'sys_data'); ?></label>
                                        <div class="col-sm-6" style="padding-right: 0;">
                                            <select name="group_value" onchange="this.form.submit()" class="form-control input-sm">
                                                <option value="0" ><?php echo getlang('select', 'sys_data'); ?></option>
                                                <option value="3" <?php if($group_value == 3){echo 'selected="selected"';} ?> ><?php echo getlang('users', 'sys_data'); ?></option>
                                                <option value="2" <?php if($group_value == 2){echo 'selected="selected"';} ?> ><?php echo getlang('admin', 'sys_data'); ?></option>
                                            </select> 
                                        </div>
                                    </div>
                                </div>

                                
                                
                            </div>
                        </div>
	                            
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
	                    </form>
	                    
                    </div>

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover rms-table">
                            <tr class="odd">
                                <th></th>
                                <th><?php echo getlang('user_name', 'sys_data'); ?></th>
                                <th><?php echo getlang('email', 'sys_data'); ?></th>
                                <th>Verified</th>
                                <th><?php echo getlang('user_group', 'sys_data'); ?></th>

                                <th>Status</th>
                                <th class="text-center" width="120px" ><?php echo getlang('action', 'sys_data'); ?></th>
                                <th class="text-center" width="90px"><?php echo getlang('id', 'sys_data'); ?></th>
                            </tr>
                            <?php
		                    if(!empty($userRecords))
		                    {
                                $i = 0;
		                        foreach($userRecords as $record)
		                        {

                                    if (0 == $i % 2) {
                                        // even
                                        $tr_class = 'even';
                                    }
                                    else {
                                        // odd
                                        $tr_class = 'odd';
                                    }
                                    $i++;

		                            if(empty($record->avatar)){
		                              $img_path = site_url('/uploads/users/').'/avator.png';
		                            }else{
		                              $img_path = site_url('/uploads/users/').'/'.$record->avatar;
		                            }
		                            ?>
                            <tr class="<?php echo $tr_class; ?>">
                                <td width="60px"><img src="<?php echo $img_path; ?>" alt="<?php echo $record->name; ?>" class="avatar img-circle" ></td>
                                <td><a href="<?php echo base_url().ADMIN_ALIAS.'/user/profile/'.$record->userId; ?>"><?php echo $record->name; ?></a></td>
                                <td><?php echo $record->email; ?></td>
                                <td>
                                    <?php 
                                    if(!empty($record->is_verified)){
                                        echo '<span class="label label-success">'.getlang('verified', 'sys_data').'</span>';
                                    }else{
                                        echo '<span class="label label-danger">'.getlang('unverified', 'sys_data').'</span>';
                                    }
                                    ?>
                                    
                                        
                                </td>
                                <td><?php echo $record->role; ?></td>
                                <td>
                                    <?php 
                                    if(!empty($record->isDeleted)){
                                        echo '<span class="label label-danger">'.getlang('trush', 'sys_data').'</span> ';
                                        echo ' <a class="btn btn-sm btn-success activeUser" href="#" data-id="'.$record->userId.'" title="'.getlang('active', 'sys_data').'"><i class="fa fa-check"></i></a>';
                                       
                                    }else{
                                        if(!empty($record->active)){
                                            echo '<span class="label label-success">'.getlang('active', 'sys_data').'</span>';
                                        }else{
                                            echo '<span class="label label-danger">'.getlang('inactive', 'sys_data').'</span>';
                                        }
                                    }
                                    
                                    ?>
                                    
                                        
                                </td>
                                <td class="text-center">
                                   <a class="btn btn-sm btn-info" href="<?php echo base_url().ADMIN_ALIAS.'/user/add/'.$record->userId; ?>" title="<?php echo getlang('edit', 'sys_data'); ?>"><i class="fa fa-pencil"></i></a>
                                   <?php 
                                    if(!empty($record->isDeleted)){
                                       echo '<a class="btn btn-sm btn-danger deleteUser" href="#" data-id="'.$record->userId.'" title="'.getlang('empty_trush', 'sys_data').'"><i class="fa fa-trash"></i></a>';
                                    }else{
                                       echo '<a class="btn btn-sm btn-danger trashUser" href="#" data-id="'.$record->userId.'" title="'.getlang('empty_trush', 'sys_data').'"><i class="fa fa-trash"></i></a>'; 
                                    }
                                   ?>
                                   <a class="btn btn-sm btn-success" href="<?php echo base_url().ADMIN_ALIAS.'/user/profile/'.$record->userId; ?>" title="<?php echo getlang('view_profile', 'sys_data'); ?>"><i class="fa fa-user"></i></a>
                                   
                                </td>
                                <td class="text-center"><?php echo $record->userId; ?></td>
                            </tr>
                            <?php
                            }
                        }
                        ?>
                        </table>
                    </div>

	                <div class="box-footer clearfix">
	                    <?php echo $this->pagination->create_links(); ?>
	                </div>
                </div>
            </div>
        </div>

    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "<?php echo ADMIN_ALIAS; ?>/user/" + value);
            jQuery("#searchList").submit();
        });

        /**
        ** Call Active
        **/
        jQuery(document).on("click", ".activeUser", function(){
            var Id = $(this).data("id"),
            hitURL = baseURL + "<?php echo ADMIN_ALIAS; ?>/user/active",
            currentRow = $(this);
            var confirmation = confirm("<?php echo getlang('system_confirm_reactive_msg', 'sys_data'); ?>");
        
            if(confirmation){
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { Id : Id , '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'} 
                }).done(function(data){
                    currentRow.parents('tr').remove();
                    if(data.status = true) { alert("<?php echo getlang('reactive_successfully', 'sys_data'); ?>"); }
                    else if(data.status = false) { alert("<?php echo getlang('reactive_failed', 'sys_data'); ?>"); }
                    else { alert("<?php echo getlang('access_denied', 'sys_data'); ?>"); }
                    location.reload();
                });
            }
        });

        /**
        ** Call Trash
        **/
        jQuery(document).on("click", ".trashUser", function(){
            var Id = $(this).data("id"),
            hitURL = baseURL + "<?php echo ADMIN_ALIAS; ?>/user/trash",
            currentRow = $(this);
            var confirmation = confirm("<?php echo getlang('system_confirm_trush_msg', 'sys_data'); ?>");
        
            if(confirmation){
	            jQuery.ajax({
	            type : "POST",
	            dataType : "json",
	            url : hitURL,
	            data : { Id : Id , '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'} 
	            }).done(function(data){
	                currentRow.parents('tr').remove();
	                if(data.status = true) { alert("<?php echo getlang('system_data_trush_success', 'sys_data'); ?>"); }
	                else if(data.status = false) { alert("<?php echo getlang('system_data_trush_failed', 'sys_data'); ?>"); }
	                else { alert("<?php echo getlang('access_denied', 'sys_data'); ?>"); }
                    location.reload();
	            });
            }
        });

        /**
        ** Empty Trash
        **/
        jQuery(document).on("click", ".deleteUser", function(){
            var Id = $(this).data("id"),
            hitURL = baseURL + "<?php echo ADMIN_ALIAS; ?>/user/delete",
            currentRow = $(this);
            var confirmation = confirm("<?php echo getlang('system_confirm_delete_msg', 'sys_data'); ?>");
        
            if(confirmation){
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { Id : Id , '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'} 
                }).done(function(data){
                    currentRow.parents('tr').remove();
                    if(data.status = true) { alert("<?php echo getlang('system_data_delete_success', 'sys_data'); ?>"); }
                    else if(data.status = false) { alert("<?php echo getlang('system_data_delete_failed', 'sys_data'); ?>"); }
                    else { alert("<?php echo getlang('access_denied', 'sys_data'); ?>"); }
                    location.reload();
                });
            }
        });
    });
</script>
