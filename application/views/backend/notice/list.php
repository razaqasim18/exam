
<div class="content-wrapper">
    
    <?php 
    $page_title = getlang('title_notice', 'sys_data');
    $page_sub_title = getlang('notice_sub_title', 'sys_data');
    
    ?>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-12">
            <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-6 title-bar">
            	<h1><i class="fa fa-bell"></i> <?php echo $page_title; ?> <small> <?php echo $page_sub_title; ?> </small></h1>
            </div>

            <div class="col-xs-12 col-md-6 text-right">
            	<a class="btn btn-primary" href="<?php echo base_url().ADMIN_ALIAS; ?>/notice/add"><i class="fa fa-plus"></i> <?php echo getlang('btn_add', 'sys_data'); ?></a>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    	
	                    <form action="<?php echo base_url().ADMIN_ALIAS; ?>/notice" method="POST" id="searchList">
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

                                <div class="col-sm-3"></div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="status" class=" col-sm-6 control-label"><?php echo getlang('show_status', 'sys_data'); ?></label>
                                        <div class="col-sm-6" style="padding-right: 0;">
                                            <select name="status_value" onchange="this.form.submit()"  class="form-control input-sm">
                                                <option value="0" ><?php echo getlang('select', 'sys_data'); ?></option>
                                                <option value="active" <?php if($status_value == 'active'){echo 'selected="selected"';} ?> ><?php echo getlang('active', 'sys_data'); ?></option>
                                                <option value="inactive" <?php if($status_value == 'inactive'){echo 'selected="selected"';} ?> ><?php echo getlang('inactive', 'sys_data'); ?></option>
                                                <option value="trush" <?php if($status_value == 'trush'){echo 'selected="selected"';} ?> ><?php echo getlang('trush', 'sys_data'); ?></option>
                                            </select> 
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3" style="padding-right: 0;">
                                    <div class="form-group">
                                        <label for="group" class=" col-sm-6 control-label"><?php echo getlang('show_group', 'sys_data'); ?></label>
                                        <div class="col-sm-6" style="padding-right: 0;">
                                            <select name="group_value" onchange="this.form.submit()" class="form-control input-sm">
                                                <option value="0" >Select</option>
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
                                <th><?php echo getlang('notice_title', 'sys_data'); ?></th>
                                <th><?php echo getlang('user_group', 'sys_data'); ?></th>
                                <th><?php echo getlang('hit', 'sys_data'); ?></th>
                                <th><?php echo getlang('date', 'sys_data'); ?></th>
                                <th><?php echo getlang('created_by', 'sys_data'); ?></th>
                                <th><?php echo getlang('status', 'sys_data'); ?></th>
                                <th class="text-center" width="120px" ><?php echo getlang('action', 'sys_data'); ?></th>
                                <th class="text-center" width="90px"><?php echo getlang('id', 'sys_data'); ?></th>
                            </tr>
                            <?php
		                    if(!empty($data))
		                    {
                                $i = 0;
		                        foreach($data as $item)
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

		                            
		                            ?>
                            <tr class="<?php echo $tr_class; ?>">
                                <td><b><?php echo $item->title; ?></b></td>
                                <td>
                                    <?php  
                                    if($item->groupId == 0){
                                        echo 'All';
                                    }elseif ($item->groupId == 2) {
                                        echo 'Admin';
                                    }elseif ($item->groupId == 3) {
                                        echo 'User';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $item->hit; ?></td>
                                <td><?php echo date( 'd M Y g:i A', strtotime($item->createDate)); ?></td>
                                <td>
                                    <?php 
                                    echo $createby = getSingledata('users', 'name', 'userId', $item->createdBy);
                                    ?>
                                </td>

                                <td>
                                    <?php 
                                    if(!empty($item->is_delete)){
                                        echo '<span class="label label-danger">Trush</span> ';
                                        echo ' <a class="btn btn-sm btn-success activeNotice" href="#" data-id="'.$item->id.'" title="Active"><i class="fa fa-check"></i></a>';
                                       
                                    }else{
                                        if(!empty($item->status)){
                                            echo '<span class="label label-success">'.getlang('active', 'sys_data').'</span>';
                                        }else{
                                            echo '<span class="label label-danger">'.getlang('inactive', 'sys_data').'</span>';
                                        }
                                    }
                                    
                                    ?>
                                    
                                        
                                </td>
                                <td class="text-center">
                                   <a class="btn btn-sm btn-info" href="<?php echo base_url().ADMIN_ALIAS.'/notice/add/'.$item->id; ?>" title="<?php echo getlang('edit', 'sys_data'); ?>"><i class="fa fa-pencil"></i></a>
                                   <?php 
                                    if(!empty($item->is_delete)){
                                       echo '<a class="btn btn-sm btn-danger deleteNotice" href="#" data-id="'.$item->id.'" title="'.getlang('empty_trush', 'sys_data').'"><i class="fa fa-trash"></i></a>';
                                    }else{
                                       echo '<a class="btn btn-sm btn-danger trashNotice" href="#" data-id="'.$item->id.'" title="'.getlang('trush', 'sys_data').'"><i class="fa fa-trash"></i></a>'; 
                                    }
                                   ?>
                                   
                                </td>
                                <td class="text-center"><?php echo $item->id; ?></td>
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
            jQuery("#searchList").attr("action", baseURL + "<?php echo ADMIN_ALIAS; ?>/notice/" + value);
            jQuery("#searchList").submit();
        });
    });

     /**
        ** Call Active
        **/
        jQuery(document).on("click", ".activeNotice", function(){
            var Id = $(this).data("id"),
            hitURL = baseURL + "<?php echo ADMIN_ALIAS; ?>/notice/active",
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
        jQuery(document).on("click", ".trashNotice", function(){
            var Id = $(this).data("id"),
            hitURL = baseURL + "<?php echo ADMIN_ALIAS; ?>/notice/trash",
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
        jQuery(document).on("click", ".deleteNotice", function(){
            var Id = $(this).data("id"),
            hitURL = baseURL + "<?php echo ADMIN_ALIAS; ?>/notice/delete",
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
</script>
