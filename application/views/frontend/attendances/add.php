<?php
    $id = '';
    $date = '';
    $class = '';
    $department = '';
    $token_name = $this->security->get_csrf_token_name();
    $token_hash = $this->security->get_csrf_hash();

    if (!empty($item_data)) {
        foreach ($item_data as $key => $item) {
            $id = $item->id;
            $date = $item->attendance_date;
            $class = $item->class;
            $department = $item->department;
        }
    }
 
    // $class_id      = $this->input->get('class');
    // $department_id = $this->input->get('department');

    // Get language
    $select_date = getlang('site_select_date', 'data');
    $select_class = getlang('site_select_class', 'data');
    $select_department = getlang('site_select_department', 'data');


    // Class list
    $classList = getClass($class);
    $class_field = fieldBuilder('select', 'class', $classList, $select_class, '');

    // Department List
    $department_list = getDepartment('department',$department);
    $department_field = fieldBuilder('select', 'department', $department_list, $select_department, '');

    $url = base_url()."attendances/saveattendance";
    //$userid = $userid;

    $date_field = '<input  type="text" name="attendances_date" value="'.$date.'" class="form-control datepicker" placeholder="'.$select_date.'"/>  '; 
    $attendances_date_field = fieldBuilder('select', 'date_field', $date_field, $select_date, '');
?>

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
                    <div class="col-xs-12 col-sm-12 col-md-12 pl-0">
                        <h1 class="user-page-title"><i class="fa fa-check-square"></i> <?php echo getlang('site_attendances_manage', 'data'); ?> </h1>
                    </div>
                </div>
            </div>
            
            <hr>

            <div class="box-body table-responsive no-padding">
   
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/adminlte/plugins/datepicker/datepicker3.css" />

                <!-- form start -->
                <?php $this->load->helper("form"); ?>
                <form  class="form-horizontal" action="<?php echo base_url(); ?>user/attendance/add" method="post" >
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9"><?php echo $attendances_date_field; ?> </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9"><?php echo $class_field; ?> </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9"><?php echo $department_field; ?> </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9 ">
                                <div class="form-group">
                                    <div class="col-sm-4 control-label"></div>
                                    <div class="col-sm-8">
                                      <input type="hidden" value="<?php echo $id; ?>" name="id">
                                        <input type="submit" class="btn btn-primary" value="<?php echo getlang('site_take_attendances', 'data'); ?>" /> 
                                        <a class="btn  btn-default" href="<?php echo base_url().'user/attendance'; ?>" title="<?php echo getlang('site_btn_cancel', 'data'); ?>"> <?php echo getlang('site_btn_cancel', 'data'); ?> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="teacher_name"  value="<?php echo $uid; ?>" />
                    <input type="hidden" id="csrf" name="<?php echo $token_name; ?>" value="<?php echo $token_hash; ?>" />
                </form>

                <div class="container-fluid">
                    <?php if(!empty($id) && !empty($date) && !empty($class) && !empty($department)):?>
                    <div class="row">
                        <div class="col-md-12">
                            <?php 
                            // Attendance form start
                            $student_list = getAttendanceStudents($class, $department);
                            $attentdance_display = '';

                            // Script for save student Attendance
                            $attentdance_display .= '<script type="text/javascript">';
                            $attentdance_display .= '$(document).ready(function () {';
                           
                            //function make
                            $attentdance_display .= 'function attentSaving(aid,sid,status,order){';
                            $url = base_url().'user/attendance/save';
                            $attentdance_display .= "var hashValue = $('#csrf').val();";
                            $attentdance_display .= '$("#saving_"+ order).html("Saving ...");';
                            $attentdance_display .= '$.post("'.$url.'",{'.$this->security->get_csrf_token_name().':hashValue, aid:aid, sid:sid, status:status}, function(data){';
                            $attentdance_display .= ' ';
                            $attentdance_display .= 'if(data){ var obj = $.parseJSON(data); var new_hash = obj.csrfHash; $("#csrf").val(new_hash);$("#saving_"+ order).html(obj.html); }';
                            $attentdance_display .= '});';
                            $attentdance_display .= '}';
                            
                            //function call
                            $s =0;
                            foreach ($student_list as $row_s) {
                                $s++;
                                $attentdance_display .= '$( "#button_'.$s.'" ).click(function() {';
                                $attentdance_display .= 'attentSaving($("#aid_'.$s.'").val(),$("#sid_'.$s.'").val(),$("#button_'.$s.'").is(":checked"),'.$s.')';
                                $attentdance_display .= '});';

                            }
                           
                            $attentdance_display .= '});';
                            $attentdance_display .= '</script>';
                            // End Script

                            $attentdance_display .='<table class="table table-striped" style="width: 100%;margin-top: 10px;" >';
                            $attentdance_display .='<tr>';
                            $attentdance_display .='<th>'.getlang('site_roll', 'data').'</th>';
                            $attentdance_display .='<th>'.getlang('site_student_name').'</th>';
                            $attentdance_display .='<th>'.getlang('site_present_status').'</th>';
                            $attentdance_display .='<th>'.getlang('site_entry_by').'</th>';
                            $attentdance_display .='</tr>';

                            $i = 0;
                            foreach ($student_list as $row) {
                                $s_name = getSingledata('users', 'name', 'userId', $row->userid);
                                $i++;
                                $attentdance_display .='<tr>';
                                $attentdance_display .='<td>'.$row->roll.'</td>';
                                $attentdance_display .='<td style="text-align: left;" >'.$s_name.'</td>';
                                $attentdance_display .='<td align="center">';
                                      
                                //Check old data

                                $check_value = getStatusByStudent($row->id, $id);
                                if(empty($check_value)){
                                    $checked ="";
                                }else{
                                    $checked ='checked="checked"';
                                }

                                $attentdance_display .='
    <div class="onoffswitch">
        <input id="button_'.$i.'" class="onoffswitch-checkbox" type="checkbox" name="status" value="0" '.$checked.'  />
    
        <label class="onoffswitch-label" for="button_'.$i.'">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
        </label>
    </div>';
                                $attentdance_display .='<div id="saving_'.$i.'"></div>';
                                $attentdance_display .='</td>';
                                $attentdance_display .='<input id="aid_'.$i.'" type="hidden" name="aid"  value="'.$id.'" />';
                                $attentdance_display .='<input id="sid_'.$i.'" type="hidden" name="sid" value="'.$row->id.'" />';
                                
                                $attentdance_display .='<td>'.getSingledata('users', 'name', 'userId', $uid).'</td>';
                                $attentdance_display .='</tr>';
                            }
                            $attentdance_display .='</table>';
                            echo $attentdance_display;
                        ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/backend/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>


<script type="text/javascript">
          
    $(document).ready(function(){
        $('.datepicker').datepicker({
            autoclose: true,
            format : "yyyy-mm-dd"
        });
    });
                
</script>
    


