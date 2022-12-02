<?php 
    $userid = $teacherInfo->userid;
    if(!empty($userid)){
        $name   = getSingledata('users', 'name', 'userId', $userid);
        $avatar = getSingledata('users', 'avatar', 'userId', $userid);
        $mobile = getSingledata('users', 'mobile', 'userId', $userid);
    }
?>

<div class="content-wrapper">
    <?php echo sectionHeader($name.' profile', '', 'fa-user'); ?>
    <section class="content profile-page">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="box box-primary">
    				<div class="box-body">
    				    <div class="avatar">
    					    <?php 
						    if(empty($avatar)){
                                $img_path = site_url('/uploads/teachers/').'/avator.png';
                            }else{
                                $img_path = site_url('/uploads/teachers/').'/'.$avatar;
                            }
    					    ?>
    					    <img src="<?php echo $img_path; ?>" alt="<?php echo $name; ?>">
    				    </div>

    				    <table>
        					<tr>
        						<td class="first"><?php echo getlang('teacher_name', 'sys_data');?></td>
        						<td class="second"><?php echo $name; ?></td>
        					</tr>

        					<tr>
        						<td class="first"><?php echo getlang('subject_name', 'sys_data'); ?></td>
        						<td class="second">
                                    <?php 
                                    if (!empty($teacherInfo->subject)) {
                                        $subject_ids = explode(',', $teacherInfo->subject);
                                        $total_ids = count($subject_ids);
                                        foreach ($subject_ids as $key => $item) {
                                          if (($key + 1) == $total_ids) {
                                            echo getSingledata('subjects', 'name', 'id', $item);
                                          }else{
                                            echo getSingledata('subjects', 'name', 'id', $item).', ';
                                          }
                                        }
                                    }
                                    ?>
        						</td>
        					</tr>

					        <tr>
						        <td class="first"><?php echo getlang('class_name', 'sys_data');?></td>
						        <td class="second">
                                    <?php 
                                    if (!empty($teacherInfo->class)) {
                                        $class_ids = explode(",",$teacherInfo->class);
                                        $total_ids = count($class_ids);
                                        foreach ($class_ids as $key => $item) {
                                          if (($key + 1) == $total_ids) {
                                            echo getSingledata('class', 'name', 'id', $item);
                                          }else{
                                            echo getSingledata('class', 'name', 'id', $item).', ';
                                          }
                                        }
                                    }
                                    ?>
                                </td>
					        </tr>
        					<tr>
        						<td class="first"><?php echo getlang('department_name', 'sys_data');?></td>
        						<td class="second">
                                    <?php 
                                    if (!empty($teacherInfo->department)) {
                                        $department_ids = explode(',', $teacherInfo->department);
                                        $total_ids = count($department_ids);
                                        foreach ($department_ids as $key => $item) {
                                            if (($key + 1) == $total_ids) {
                                              echo getSingledata('departments', 'name', 'id', $item);
                                            }else{
                                              echo getSingledata('departments', 'name', 'id', $item).', ';
                                            }
                                        }
                                    }
                                    ?>
        						</td>
        					</tr>
					
					        <?php $fields = getfieldsdata('fields', '*', 'profile', 2);
						      foreach ($fields as $key => $item) { ?>
      							<tr>
      								<td class="first"><?php echo $item->field_name;?></td>
      								<td class="second"><?php echo getSingleFieldsdata('data', $item->id, $teacherInfo->id); ?></td>
      							</tr>
					        <?php }?>
  				      </table> 
    			  </div>
    		  </div>
    		</div>
    	</div>
    </section>
</div>
 

