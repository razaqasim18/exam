

    <?php
    $userId = '';
    $name = '';
    $avatar = '';
    $email = '';
    $mobile = '';
    $teacherdata = '';
    $teacherid = '';

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
    $teacherdata = profileData($uid, 'teachers');
    foreach ($teacherdata as $key => $teacherInfo) { }

    // get avatar
	if(empty($avatar)){
		$img_path = site_url('/uploads/users/').'/avator.png';
	}else{
		$img_path = site_url('/uploads/users/').'/'.$avatar;
	}

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
				          $img_path = site_url('/uploads/teachers/').'/'.$avatar;
				        }

					?>
				    <img src="<?php echo $img_path; ?>" alt="<?php echo $name; ?>">
			    </div>
			    <table>
					<tr>
						<td class="first"><?php echo getlang('site_teacher_name', 'data');?></td>
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

					<!-- Designation -->
	                <tr>
	                    <td class="first"><?php echo getlang('site_designation', 'data'); ?></td>
	                    <td class="second"><?php echo $teacherInfo->designation; ?></td>
	                </tr>

	                 <!-- Subjects -->
	                <tr>
	                    <td class="first"><?php echo getlang('site_subject', 'data'); ?></td>
	                    <td class="second"><?php 

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
	                      }?>
	                    </td>
	                </tr>

	                 <!-- Class -->
                <tr>
                    <td class="first"><?php echo getlang('site_class', 'data'); ?></td>
                    <td class="second"><?php 

                      if (!empty($teacherInfo->class)) {
                        $class_ids = explode(',', $teacherInfo->class);
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
                      }?>
                    </td>
                </tr>

                <?php $fields = getfieldsdata('fields', '*', 'profile', 2);
                  foreach ($fields as $key => $item) {?>
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
