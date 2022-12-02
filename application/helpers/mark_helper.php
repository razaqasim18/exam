<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    /**
    ** Get Exam List
    **/
    function getExamList($field_name, $id){
        $exam_ids = explode(",",$id);
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('exam');
        $query = $CI->db->get();
        $results = $query->result();

        $output = '<select name="'.$field_name.'" id="field_'.$field_name.'" class="form-control required" >';
        $output .='<option value="0" > '.getlang('site_form_select_exam', 'data').' </option>';
        foreach ($results as $key => $item) {
            $id = $item->id;
            if (in_array($id, $exam_ids)) {
                $output .= '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
            }else{
                $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
            }
           
        }
        $output .= '</select>';
        return $output;
    }

    /**
    ** Get Class List
    **/
    function getClassList($field_name, $uid, $ids){
        $class_select_id = explode(",",$ids);
        // Get class value
        $class_ids = getSingledata('teachers', 'class', 'userid', $uid);
        $values = explode(",", $class_ids);

        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('class');
        $query = $CI->db->get();
        $results = $query->result();

        $output = '<select name="'.$field_name.'" id="field_'.$field_name.'" class="form-control required" >';
        $output .='<option value="0" > '.getlang('select_class', 'sys_data').' </option>';
        foreach ($results as $key => $item) {
            if (in_array($item->id, $values)) {
                if (in_array($item->id, $class_select_id)) {
                    $output .= '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
                }else{
                    $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
                }
            }
        }
        $output .= '</select>';
        return $output;
    }

    /**
    ** Get Department List
    **/
    function getDepartmentList($field_name, $uid, $ids){
        $department_select_id = explode(",",$ids);
        // Get department value
        $department_ids = getSingledata('teachers', 'department', 'userid', $uid);
        $values = explode(",", $department_ids);

        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('departments');
        $query = $CI->db->get();
        $results = $query->result();

        $output = '<select name="'.$field_name.'" id="field_'.$field_name.'" class="form-control required" >';
        $output .='<option value="0" > '.getlang('select_department', 'sys_data').' </option>';
        foreach ($results as $key => $item) {
            if (in_array($item->id, $values)) {
                if (in_array($item->id, $department_select_id)) {
                    $output .= '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
                }else{
                    $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
                }
            }
        }
        $output .= '</select>';
        return $output;
    }

    /**
    ** Get Subject List
    **/
    function getSubjectList($field_name, $uid, $ids){
        $subject_selected_id = explode(",",$ids);
        // Get subject value
        $subject_ids = getSingledata('teachers', 'subject', 'userid', $uid);
        $values = explode(",", $subject_ids);

        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('subjects');
        $query = $CI->db->get();
        $results = $query->result();

        $output = '<select name="'.$field_name.'" id="field_'.$field_name.'" class="form-control required" >';
        $output .='<option value="0" > '.getlang('select_subject', 'sys_data').' </option>';
        foreach ($results as $key => $item) {
            if (in_array($item->id, $values)) {
                if (in_array($item->id, $subject_selected_id)) {
                    $output .= '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
                }else{
                    $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
                }
            }
        }
        $output .= '</select>';
        return $output;
    }


    /**
    ** Student List for entry mark
    **/
    function getstudentList($eid, $cid,$did, $subjid, $uid, $csrf_hash){
        
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('students');
        $CI->db->where('class', $cid);
        $CI->db->where('department', $did);
        $CI->db->order_by("roll", "asc");
        $query = $CI->db->get();
        $rows = $query->result();


        //upload xcxl file
        $mark_student = '<table class="admin-table well" id="admin-table" style="width: 100%;" align="center">';
        $mark_student .= '<tr>';
        $mark_student .= '<td>';

        $mark_student .= '<form action="'.base_url().'/user/marks/importcsv" method="post" name="user-form"   enctype="multipart/form-data" style="padding:10px;">';
        $mark_student .= '<input type="file" style="display: inline-block;" name="spreadsheet"/>';
        $mark_student .= '<input type="submit" value="'.getlang('upload', 'sys_data').'" id="upload" class="btn btn-default" style="display: inline-block;" />';
        $mark_student .= '<input type="hidden" name="task" value="importcsv"  />';
        $mark_student .= '<input type="hidden" name="controller" value="marks" />';
        $mark_student .= '<input type="hidden" name="exam_id" value="'.$eid.'" />';
        $mark_student .= '<input type="hidden" name="class_id" value="'.$cid.'" />';
        $mark_student .= '<input type="hidden" name="subject_id" value="'.$subjid.'" />';
        $mark_student .= '<input type="hidden" name="department_id" value="'.$did.'" />';
        $mark_student .= '<input type="hidden" id="csrf_mark" name="csrf_zadmin" value="'.$csrf_hash.'" />';
        $mark_student .= '</form>';
        $mark_student .= ' <p class="help-block" style="margin-top: 10px;padding:10px;">Only Excel File <b style="color: red;">{CSV} </b> format Import. Excel file Must have headers as follows:<b style="color: red;"> '.getlang('roll_studentname_mark_comment', 'sys_data').'</b> </p></td>';
        $mark_student .= '</tr>';
        $mark_student .= '</table>';
                
        $mark_student .= '<table class="admin-table" id="attendance-table" style="width: 100%;margin-top: 25px;" align="center">';
        $mark_student .= '<tr>';
        $mark_student .= '<th style="width: 7%;"></th>';
        $mark_student .= '<th style="width: 10%;">'.getlang('roll', 'sys_data').'</th>';
        $mark_student .= '<th style="" >'.getlang('student_name', 'sys_data').'</th>';
        $mark_student .= '<th style="width: 15%;">'.getlang('obtained', 'sys_data').'</th>';
        $mark_student .= '<th style="width: 15%;">'.getlang('comment', 'sys_data').'</th>';
        $mark_student .= '<th style="width: 15%;"></th>';
        $mark_student .= '</tr>';
        
        $mark_student .= '<input type="hidden" id="exam_id" name="exam_id" value="'.$eid.'" />';
        $mark_student .= '<input type="hidden" id="class_id" name="class_id" value="'.$cid.'" />';
        $mark_student .= '<input type="hidden" id="subject_id" name="subject_id" value="'.$subjid.'" />';
        $mark_student .= '<input type="hidden" id="uid"  value="'.$uid.'" />';
        
        // Script for save mark
        $mark_student .= '<script type="text/javascript">';
            $mark_student .= '$(document).ready(function () {';

            $mark_student .= 'var exam_id    = $("#exam_id").val();';
            $mark_student .= 'var class_id   = $("#class_id").val();';
            $mark_student .= 'var subject_id = $("#subject_id").val();';
            $mark_student .= 'var addby      = $("#uid").val();';
            
                 
            //function make
            $mark_student .= 'function markSaving(exam_id,class_id,subject_id,roll,sid,addby,year,mark,comment,order){';
            $url = base_url()."user/marks/savemark";
            $mark_student .= 'var getHass = $("#csrf").val();';
            $mark_student .= '$("#saving_"+ order).html("'.getlang('saving', 'sys_data').'");';
             
            $mark_student .= '$.post( "'.$url.'",{
                            csrf_zadmin:getHass,
                            exam_id:exam_id,
                            class_id:class_id,
                            subject_id:subject_id,
                            roll:roll,
                            sid:sid,
                            addby:addby,
                            year:year,
                            mark:mark,
                            comment:comment
                         }, function(data){';
            $mark_student .= 'if(data){ 
                        var obj = $.parseJSON(data); 
                        var new_hash = obj.csrfHash; 
                        $("#csrf").val(new_hash);
                        $("#csrf_mark").val(new_hash);
                        $("#saving_"+ order).html(obj.html);
            }';
            $mark_student .= '});';
            $mark_student .= '}';
        
            //function call
            foreach ($rows as $s => $items) {
                $mark_student .= '$( "#button_'.$s.'" ).click(function() {';
                $mark_student .= 'markSaving(
                                  exam_id,
                                  class_id,
                                  subject_id,
                                  $("#roll_'.$s.'").val(),
                                  $("#sid_'.$s.'").val(),
                                  addby,
                                  $("#year_'.$s.'").val(),
                                  $("#mark_'.$s.'").val(),
                                  $("#comment_'.$s.'").val(),
                                  '.$s.')';
                //$mark_student .= 'alert("test");';
                $mark_student .= '});';
            }
                 

            
        $mark_student .= '});';
        $mark_student .= '</script>';
            
            
        foreach ($rows as $i => $row) {
    
            $mark = getMark('mark', $eid, $cid, $subjid, $row->id, $row->roll, $row->year);
            $comment = getMark('comment', $eid, $cid, $subjid, $row->id, $row->roll, $row->year);

            $avatar = getSingledata('users', 'avatar', 'userId', $row->userid);
            $name = getSingledata('users', 'name', 'userId', $row->userid);

            if(empty($avatar)){
                $img_path = site_url('/uploads/students/').'/avator.png';
            }else{
                $img_path = site_url('/uploads/students/').'/'.$avatar;
            }
            
         
            //Hidden Value
            $mark_student .= '<input type="hidden" id="roll_'.$i.'" name="roll" value="'.$row->roll.'" />';
            $mark_student .= '<input type="hidden" id="sid_'.$i.'" name="student_id" value="'.$row->id.'" />';
            $mark_student .= '<input type="hidden" id="year_'.$i.'" name="year" value="'.$row->year.'" />';
            
            $mark_student .= '<tr>';
            $mark_student .= '<td style="width: 7%;text-align: center;"><img src="'.$img_path.'" alt="'.$name.'" class="avatar img-circle"></td>';
            $mark_student .= '<td style="width: 10%;">'.$row->roll.'</td>';
            $mark_student .= '<td style="text-align: left;" >'.$name.'</td>';
            $mark_student .= '<td style="width: 15%;text-align: center;" >';
            $mark_student .= '<input type="text" class="mark-input" id="mark_'.$i.'" name="marks" value="'.$mark.'"  />';
            $mark_student .= '</td>';
            $mark_student .= '<td class="text-left" >';
            $mark_student .= '<input type="text"  class="mark-inputd" id="comment_'.$i.'"  name="comment" value="'.$comment.'"  />';
            $mark_student .= '</td>';
            $mark_student .= '<td style="width: 15%;text-align: center;" >';
            $mark_student .= '<div id="saving_'.$i.'" class="mark-result" ></div>';
            $mark_student .= '<input type="button" name="" id="button_'.$i.'" class="btn btn-primary" style="line-height: 30px;height: 30px;" value="'.getlang('save', 'sys_data').'" />';
            $mark_student .= '</td>';
            $mark_student .= '</tr>';
                
        }//End foreach
                        
        $mark_student .= '</table>';
        return $mark_student;
    }


    


