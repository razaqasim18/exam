

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
    $parentdata = profileData($uid, 'parents');
    foreach ($parentdata as $key => $parentInfo) { }

    // get avatar
	$parentchilds = getParentChilds($parentInfo->userid);

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
							$img_path = site_url('/uploads/parents/').'/'.$avatar;
						}

					?>
				    <img src="<?php echo $img_path; ?>" alt="<?php echo $name; ?>">
			    </div>
			    <table>
					<tr>
						<td class="first"><?php echo getlang('site_parent_name', 'data');?></td>
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

					<?php $fields = getfieldsdata('fields', '*', 'profile', 3);

	                  foreach ($fields as $key => $item) {?>
	                    <tr>
	                        <td class="first"><?php echo $item->field_name;?></td>
	                        <td class="second"><?php echo getSingleFieldsdata('data', $item->id, $parentInfo->id); ?></td>
	                    </tr>
	                <?php }?>
					
	  			</table>
	  			<ul>
	  				<h5><?php echo getlang('site_child_info', 'data'); ?></h5>
	  				<?php 
	  					foreach ($parentchilds as $key => $child) { 
	  						$child_name   = getSingledata('users', 'name', 'userId', $child->userid);
	  						$child_avatar = getSingledata('users', 'avatar', 'userId', $child->userid);
			              if(empty($child_avatar)){
			                $img_path = site_url('/uploads/students/').'/avator.png';
			              }else{
			                $img_path = site_url('/uploads/students/').'/'.$child_avatar;
			              }
			          	

	  				?>
	  				<li>
	  					<a href="<?php echo base_url().'user/studentprofile/'.$child->id; ?>">
	  						<img src="<?php echo $img_path; ?>" alt="<?php echo $child_name; ?>">
	  						<span><?php echo $child_name; ?></span>
	  					</a>
	  				</li>
	  				<?php }?>
	  			</ul>
  			</div>
        </div>
    </div>
</div>
