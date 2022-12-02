<?php 

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );
?>
<div class="content-wrapper">
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-8 title-bar">
                <h1>
                    <i class="fa fa-users"></i> 
                    <?php echo getlang('title_student', 'sys_data'); ?> 
                </h1>
            </div>

            <div class="col-xs-12 col-md-4 text-right">
                <a class="btn btn-primary" href="<?php echo base_url().ADMIN_ALIAS; ?>/students/add"><i class="fa fa-plus"></i> <?php echo getlang('btn_add', 'sys_data'); ?></a>
            </div>
        </div>
       

        <div class="row">
            <div class="col-xs-12 rms-data-table">
                <div class="box">
                <div class="box-header">
                        <form action="<?php echo base_url().ADMIN_ALIAS; ?>/students" method="POST" id="searchList">
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
                                                <option value="0" ><?php echo getlang('select', 'sys_data'); ?></option>
                                                <option value="active" <?php if($status_value == 'active'){echo 'selected="selected"';} ?> ><?php echo getlang('active', 'sys_data'); ?></option>
                                                <option value="inactive" <?php if($status_value == 'inactive'){echo 'selected="selected"';} ?> ><?php echo getlang('inactive', 'sys_data'); ?></option>
                                                <option value="trush" <?php if($status_value == 'trush'){echo 'selected="selected"';} ?> ><?php echo getlang('trush', 'sys_data'); ?></option>
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
                    <tr>
                      	<th><?php echo getlang('student_name', 'sys_data'); ?></th>
                      	<th><?php echo getlang('class_name', 'sys_data'); ?></th>
                      	<th><?php echo getlang('department_name', 'sys_data'); ?></th>
                      	<th><?php echo getlang('roll', 'sys_data'); ?></th>
                        <th>Verified</th>
                        <th>Status</th>

                      	<?php 

                      	$showFieldData = getfieldsdata('fields', '*', 'list', 1);
                      	foreach ($showFieldData as $key => $item) { ?>
                      		<th><?php echo $item->field_name; ?></th>
                      	<?php } ?>
                      

                      	<th><?php echo getlang('phone', 'sys_data'); ?></th>
                      	<th><?php echo getlang('year', 'sys_data'); ?></th>
                      	<th class="text-center" width="120px"><?php echo getlang('action', 'sys_data'); ?></th>
                    </tr>
                    <?php
                    if(!empty($studentsRecords))
                    {
                        foreach($studentsRecords as $record)
                        {
                          $avatar    = getSingledata('users', 'avatar', 'userId', $record->userid);
                          $s_name    = getSingledata('users', 'name', 'userId', $record->userid);
                          $phone     = getSingledata('users', 'mobile', 'userId', $record->userid);
                          $year_name = getSingledata('academic_year', 'year', 'id', $record->year);
                          $active    = getSingledata('users', 'active', 'userId', $record->userid);
                          $isDeleted = getSingledata('users', 'isDeleted', 'userId', $record->userid);
                          $is_verified = getSingledata('users', 'is_verified', 'userId', $record->userid);
                          

                          	if(empty($avatar)){
                              $img_path = site_url('/uploads/students/').'/avator.png';
                          	}else{
                              $img_path = site_url('/uploads/students/').'/'.$avatar;
                          	}
                    ?>
                    <tr>
                      <td>
                    		<a href="<?php echo base_url().ADMIN_ALIAS.'/students/add/'.$record->id; ?>" style="color: #000;">
                      		<img src="<?php echo $img_path; ?>" alt="<?php echo $s_name; ?>" class="avatar" >
                      		<?php echo $s_name; ?>
                      	</a>
                      </td>
                    	<td>
                        <?php
                       
                       	if (!empty($record->class)) {
                        	echo getSingledata('class', 'name', 'id', $record->class);
                        }else{				

                        } 
                       	?>
                     	</td>

                    	<td>
                        <?php 
                      		if (!empty($record->department)) {
	                         	echo getSingledata('departments', 'name', 'id', $record->department);
	                        }else{        

	                        } 
	                      ?>
                      </td>
                      <td><?php echo $record->roll; ?></td>

                        <td>
                            <?php 
                            if(!empty($is_verified)){
                                echo '<span class="label label-success">'.getlang('verified', 'sys_data').'</span>';
                            }else{
                                echo '<span class="label label-danger">'.getlang('unverified', 'sys_data').'</span>';
                            }
                            ?>   
                        </td>

                        <td>
                            <?php 
                            if(!empty($isDeleted)){
                                echo '<span class="label label-danger">'.getlang('trush', 'sys_data').'</span> ';
                                echo ' <a class="btn btn-sm btn-success activeUser" href="#" data-id="'.$record->userId.'" title="'.getlang('active', 'sys_data').'"><i class="fa fa-check"></i></a>';
                            }else{
                                if(!empty($active)){
                                    echo '<span class="label label-success">'.getlang('active', 'sys_data').'</span>';
                                }else{
                                    echo '<span class="label label-danger">'.getlang('inactive', 'sys_data').'</span>';
                                }
                            }
                            ?>   
                        </td>

	                    <?php 
	                  		$showFieldData = getfieldsdata('fields', '*', 'list', 1);
	                  		foreach ($showFieldData as $key => $item) {?>
	                  			<td><?php echo getSingleFieldsdata('data', $item->id, $record->id); ?></td>
	                  	<?php } ?>
                      

                      	<td><?php echo $phone; ?></td>
                      	<td><?php echo $year_name; ?></td>
                      	<td class="text-center">
                          	<a class="btn btn-sm btn-primary" href="<?= base_url().ADMIN_ALIAS.'/students/view/'.$record->id; ?>" title="<?php echo getlang('profile_view', 'sys_data'); ?>"><i class="fa fa-eye"></i></a> 
                          	<a class="btn btn-sm btn-info" href="<?php echo base_url().ADMIN_ALIAS.'/students/add/'.$record->id; ?>" title="<?php echo getlang('edit', 'sys_data'); ?>"><i class="fa fa-pencil"></i></a>
                          	<a class="btn btn-sm btn-danger deleteStudent" data-id="<?php echo $record->id; ?>" id="studentId" href="#"  title="<?php echo getlang('delete', 'sys_data'); ?>"><i class="fa fa-trash"></i></a>
                      	</td>
                        
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
            </div>
    </section>
</div>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){

        /**
        ** Call Pagination
        **/
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "<?php echo ADMIN_ALIAS; ?>/students/" + value);
            jQuery("#searchList").submit();
        });


        /**
        ** Call Delete
        **/

        jQuery(document).on("click", ".deleteStudent", function(){
        var Id = $(this).data("id"),
            hitURL = baseURL + "<?php echo ADMIN_ALIAS; ?>/students/delete",
            currentRow = $(this);
        
        var confirmation = confirm("<?php echo getlang('system_confirm_delete_msg', 'sys_data'); ?>");
        
        if(confirmation)
        {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { Id : Id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>' } 
            }).done(function(data){
                
                currentRow.parents('tr').remove();
                if(data.status = true) { alert("<?php echo getlang('system_data_delete_success', 'sys_data'); ?>"); }
                else if(data.status = false) { alert("<?php echo getlang('system_data_delete_failed', 'sys_data'); ?>"); }
                else { alert("<?php echo getlang('system_access_denied', 'sys_data'); ?>"); }
                location.reload();
            });
        }

    });

 });
</script>





