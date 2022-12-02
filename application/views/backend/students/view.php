

<div class="content-wrapper">
    <?php
    	$student_name = getSingledata('users', 'name', 'userId', $studentInfo->userid);
     	echo sectionHeader($student_name.' profile', '', 'fa-user'); 
     ?>
    <section class="content profile-page">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="box box-primary">
    				<div class="box-body">

    					

    				    <div class="avatar">
    					<?php 
    						$avatar = getSingledata('users', 'avatar', 'userId', $studentInfo->userid);
    						if(empty($avatar)){
                              $img_path = site_url('/uploads/students/').'/avator.png';
                          }else{
                              $img_path = site_url('/uploads/students/').'/'.$avatar;
                          }

    					?>
    					<img src="<?php echo $img_path; ?>" alt="<?php echo $student_name; ?>">
    				    </div>

    				    <table>
					<tr>
						<td class="first"><?php echo getlang('student_name');?></td>
						<td class="second"><?php echo $student_name; ?></td>
					</tr>
					
					<?php $fields = getfieldsdata('fields', '*', 'profile', 1);
						foreach ($fields as $key => $item) { ?>

							<tr>
								<td class="first"><?php echo $item->field_name;?></td>
								<td class="second"><?php echo getSingleFieldsdata('data', $item->id, $studentInfo->id); ?></td>
							</tr>
					<?php }?>

					
					<tr>
						<td class="first"><?php echo getlang('class_name', 'sys_data');?></td>
						<td class="second"><?php 
						if(!empty($studentInfo->class)){
							echo getSingledata('class', 'name', 'id', $studentInfo->class); 
						}
						?></td>
					</tr>
					<tr>
						<td class="first"><?php echo getlang('department_name', 'sys_data');?></td>
						<td class="second"><?php 
						if(!empty($studentInfo->department)){
							echo getSingledata('departments', 'name', 'id', $studentInfo->department); 
						}
						?></td>
					</tr>
					<tr>
						<td class="first"><?php echo getlang('roll', 'sys_data');?></td>
						<td class="second"><?php echo $studentInfo->roll; ?></td>
					</tr>
					<tr>
						<td class="first"><?php echo getlang('phone', 'sys_data');?></td>
						<td class="second">
							<?php 
								$mobile = getSingledata('users', 'mobile', 'userId', $studentInfo->userid);
								echo $mobile; 
							?>
						</td>
					</tr>
  				</table> 
   
    			    </div>
    		    </div>
    		</div>
    	</div>


    		
    </section>
    
</div>
 

