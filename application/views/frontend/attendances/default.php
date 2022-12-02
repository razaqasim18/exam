

<div class="container">

    <div class="row">
        <div class="col-md-12">
            <?php echo getSystemMessage(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 left-sidebar"> <?php echo getUserPanel($role, $uid); ?></div>
        <div class="col-xs-12 col-sm-9 col-md-9 front-end-details">
        	<div class="container-fluid">
        		<div class="row">
        			<div class="col-xs-12 col-sm-8 col-md-8 pl-0">
        				<h1 class="user-page-title"><i class="fa fa-check-square"></i> <?php echo getlang('site_attendance_list_title', 'data'); ?> </h1>
        			</div>
        			<div class="col-xs-12 col-sm-4 col-md-4 text-right pr-0">
        				<a href="<?php echo base_url().'user/attendance/add'; ?>" class="btn btn-small btn-primary "><?php echo getlang('site_btn_new_attendance', 'data'); ?></a>
        			</div>
        		</div>
        	</div>
            
            <hr>

            <div class="box-body table-responsive no-padding">
                
                    <?php
                    if(!empty($data)){
                        ?>
                        <table class="table table-striped" id="user-table" style="margin-top: 0px;">
                            <tr>
                                <th  class="text-center"><?php echo getlang('site_date', 'data'); ?></th>
                                <th  class="text-center"><?php echo getlang('site_class', 'data'); ?></th>
                                <th  class="text-center"><?php echo getlang('site_department', 'data'); ?></th>
                                <th  class="text-center"><?php echo getlang('site_total_student', 'data'); ?></th>
                                <th  class="text-center"><?php echo getlang('site_total_parent', 'data'); ?></th>
                                <th  class="text-center"><?php echo getlang('site_absent', 'data'); ?></th>
                                <th  class="text-center"><?php echo getlang('site_edit', 'data'); ?></th>
                            </tr>
                        
                        <?php
                        foreach($data as $item)
                        {
                            $link = base_url().'user/attendance/add/'.$item->id;
                            $date = $item->attendance_date;
                            $class = getSingledata('class', 'name', 'id', $item->class);
                            $department = getSingledata('departments', 'name', 'id', $item->department);
                            $total_student = $item->total_student;
                            $total_present = totalPresent($item->id);
                            $total_absent = totalAbsent($item->id);
                            
                           ?>
                        <tr class="">
                            <td class="text-left"><a href="<?php echo $link; ?>"><?php echo $date; ?></a></td>
                            <td class="text-center"><?php echo $class; ?></td>
                            <td class="text-center"><?php echo $department; ?></td>
                            <td class="text-center"><?php echo $total_student; ?></td>
                            <td class="text-center"><?php echo $total_present; ?></td>
                            <td class="text-center"><?php echo $total_absent; ?></td>
                            <td class="text-center"> <a href="<?php echo $link; ?>" class="btn btn-small btn-default"><?php echo getlang('site_btn_edit', 'data'); ?></a></td>
                        </tr>
                        <?php
                        
                        }

                        ?>
                    </table>
                        <?php
                    }else{
                        echo '<p style="color: red;">'.getlang('site_empty_list', 'data').'</p>';
                    }
                    ?>
            </div>
        </div>
    </div>
</div>





