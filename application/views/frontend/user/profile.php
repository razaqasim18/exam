

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
   
    // get avatar
	if(empty($avatar)){
		$img_path = site_url('/uploads/users/').'/avator.png';
	}else{
		$img_path = site_url('/uploads/users/').'/'.$avatar;
	}

	if($role == ROLE_TEACHER){ 

		$folder_name = 'teachers';
		$getlang = getlang('teacher_name');
	}elseif ($role == ROLE_PARENT) {
		$getlang = getlang('parent_name');
		$folder_name = 'parents';
	}elseif ($role == ROLE_STUDENT) {
		$getlang = getlang('student_name');
		$folder_name = 'students';
	}else{
		$folder_name == 'users';
	}

?>


<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 left-sidebar"> <?php echo getUserPanel($role, $uid); ?></div>
        <div class="col-xs-12 col-sm-9 col-md-9">
            
            <div class="profile-page">
	            <div class="avatar">
				    <?php 
					    if(empty($avatar)){
				          $img_path = site_url('/uploads/users/').'/avator.png';
				        }else{
				          $img_path = site_url('/uploads/'.$folder_name.'/').'/'.$avatar;
				        }

					?>
				    <img src="<?php echo $img_path; ?>" alt="<?php echo $name; ?>">
			    </div>
			    <table>
					<tr>
						<td class="first"><?php echo $getlang;?></td>
						<td class="second"><?php echo $name; ?></td>
					</tr>
					<tr>
						<td class="first"><?php echo getlang('email');?></td>
						<td class="second"><?php echo $email; ?></td>
					</tr>

					<tr>
						<td class="first"><?php echo getlang('phone');?></td>
						<td class="second"><?php echo $mobile; ?></td>
					</tr>
					
	  			</table>
  			</div>
        </div>
    </div>
</div>
