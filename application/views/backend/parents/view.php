
<?php 
   $userid = $parentInfo->userid;
   if(!empty($userid)){
        $name = getSingledata('users', 'name', 'userId', $userid);
        $avatar = getSingledata('users', 'avatar', 'userId', $userid);
        $mobile = getSingledata('users', 'mobile', 'userId', $userid);
    }

    $parentchilds = getParentChilds($parentInfo->id);
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
                                $img_path = site_url('/uploads/parents/').'/avator.png';
                            }else{
                                $img_path = site_url('/uploads/parents/').'/'.$avatar;
                            }
          					?>
          					<img src="<?php echo $img_path; ?>" alt="<?php echo $name; ?>">
    				    </div>

    				    <table>
          					<tr>
          						<td class="first"><?php echo getlang('parent_name', 'sys_data');?></td>
          						<td class="second"><?php echo $name; ?></td>
          					</tr>

                            <?php if (!empty($parentchilds)) { ?>
                            <tr>
                                <td class="first"><?php echo getlang('childs_name', 'sys_data'); ?></td>
                                <td class="second">
                                    <?php 
                                        
                                          $total_ids = count($parentchilds);
                                          foreach ($parentchilds as $key => $child) {
                                            $child_name   = getSingledata('users', 'name', 'userId', $child->userid);
                                            $child_avatar = getSingledata('users', 'avatar', 'userId', $child->userid);

                                              if (($key + 1) == $total_ids) {
                                                  echo $child_name;
                                              }else{
                                                  echo $child_name.', ';
                                              }
                                          }
                                     
                                  ?>
                                </td>
                            </tr>
                            <?php  }   ?>
                    
          					<?php $fields = getfieldsdata('fields', '*', 'profile', 3);
          						foreach ($fields as $key => $item) { ?>
          							<tr>
          								<td class="first"><?php echo $item->field_name;?></td>
          								<td class="second"><?php echo getSingleFieldsdata('data', $item->id, $parentInfo->id); ?></td>
          							</tr>
          					<?php }?>
  				      </table> 
    			    </div>
    		    </div>
    		</div>
    	</div>
    </section>
</div>
 

