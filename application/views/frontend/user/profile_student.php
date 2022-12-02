

<?php
    $userId = '';
    $name = '';
    $avatar = '';
    $email = '';
    $mobile = '';
    $teacherdata = '';

    if(!empty($user_data))
    {
        foreach ($user_data as $item)
        {
            $userId = $item->userId;
            $name = $item->name;
            $avatar = $item->avatar;
            $email = $item->email;
            $mobile = $item->mobile;

        }

    }
  
	$studentdata = profileData($userId, 'students');
    foreach ($studentdata as $key => $studentInfo) { }
?>


<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 left-sidebar"> <?php echo getUserPanel($role, $uid); ?></div>
        <div class="col-xs-12 col-sm-9 col-md-9">
            <!-- <h1 class="user-page-title"><i class="fa fa-user-circle"></i> My Profile</h1>
            <hr> -->
            <div class="profile-page">
	            <div class="avatar">
				    <?php 
					    if(empty($avatar)){
				          $img_path = site_url('/uploads/users/').'/avator.png';
				        }else{
				          $img_path = site_url('/uploads/students/').'/'.$avatar;
				        }

					?>
				    <img src="<?php echo $img_path; ?>" alt="<?php echo $name; ?>">
			    </div>
			    <table>
					<tr>
						<td class="first"><?php echo getlang('site_student_name', 'data');?></td>
						<td class="second"><?php echo $name; ?></td>
					</tr>

					<tr>
						<td class="first"><?php echo getlang('site_email', 'data');?></td>
						<td class="second"><?php echo $email; ?></td>
					</tr>

					<tr>
						<td class="first"><?php echo getlang('site_phone', 'data');?></td>
						<td class="second"><?php echo $mobile; ?></td>
					</tr>

	                 <!-- Class -->
	                <tr>
	                    <td class="first"><?php echo getlang('site_class', 'data'); ?></td>
	                    <td class="second"><?php 

	                      if (!empty($studentInfo->class)) {
	                        $class_ids = explode(',', $studentInfo->class);
	                        $total_ids = count($class_ids);
	                        foreach ($class_ids as $key => $item) {
	                          if (($key + 1) == $total_ids) {
	                            echo getSingledata('class', 'name', 'id', $item);
	                          }else{
	                            echo getSingledata('class', 'name', 'id', $item).', ';
	                          }
	                        }
	                      }?>
	                    </td>
	                </tr>
	                <!-- Department -->
	                <tr>
	                    <td class="first"><?php echo getlang('site_department', 'data'); ?></td>
	                    <td class="second"><?php 

	                      if (!empty($studentInfo->department)) {
	                        $department_ids = explode(',', $studentInfo->department);
	                        $total_ids = count($department_ids);
	                        foreach ($department_ids as $key => $item) {
	                          if (($key + 1) == $total_ids) {
	                            echo getSingledata('departments', 'name', 'id', $item);
	                          }else{
	                            echo getSingledata('departments', 'name', 'id', $item).', ';
	                          }
	                        }
	                      }?>
	                    </td>
	                </tr>

	                <?php $fields = getfieldsdata('fields', '*', 'profile', 1);
	                  foreach ($fields as $key => $item) {?>
	                    <tr>
	                        <td class="first"><?php echo $item->field_name;?></td>
	                        <td class="second"><?php echo getSingleFieldsdata('data', $item->id, $studentInfo->id); ?></td>
	                    </tr>
	                <?php }?>
					
	  			</table>
  			</div>
        </div>
    </div>
</div>
