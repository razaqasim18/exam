<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    /**
    ** Result display
    **/
    function DisplayResult($sid, $exam){

        $show = '';
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('exam_marks');
        $CI->db->where('student_id', $sid);
        $CI->db->where('exam_id', $exam);
        $query = $CI->db->get();
        $results = $query->result();

        // Check data
        if (!empty($results)) {
            // Get Class id
            $class_id = getSingledata('students', 'class', 'id', $sid);
            // Grade list
            $gradeList = getGradeList();
            //$totalmark = getTotalmark($sid, $exam);
            // Get comment
            $roll_id = getSingledata('students', 'roll', 'id', $sid);
            $comment = GetComment($exam, $class_id, $roll_id);

            // Get Subject list
            
            $subjects = getSingledata('class', 'subjects', 'id', $class_id);
            $subject_list = explode(",", $subjects);
            $total_subject = count($subject_list);


            $show .= '<h3>'.getlang('site_exam', 'data').':'.getSingledata('exam', 'name', 'id', $exam).' </h3>';
            $show .='<table cellpadding="0" cellspacing="0" class="admin-table attendance-report" id="attendance-table" style="width: 100%;margin-top: 0px;margin-bottom: 10px;" align="center" >';

            $show .='<tr>';
            $show .='<th>'.getlang('site_form_subject', 'data').'</th>';
            $show .='<th>'.getlang('site_obtain_mark', 'data').'</th>';
            $show .='<th>'.getlang('site_grade', 'data').'</th>';
            $show .='<th>'.getlang('site_comment', 'data').'</th>';
            $gp = 0;
            $gp_name = 0;
            $tearm_total_gp =0;
            $tearm_gp = 0;
            $totalmark = 0;


            // Start Foreach
            foreach ($results as $key => $value) {
                $subject_name = getSingledata('subjects', 'name', 'id', $value->subject_id);
                $show .='</tr>';
                $show .='<td style="text-align: left;padding-left:10px;">'.$subject_name.'</td>';
                $show .='<td>'.$value->mark.'</td>';

                // Get grade list
                $grade_comment = '';
                foreach ($gradeList as $key => $grade) {
                    $mark_from = $grade->mark_from;
                    $mark_upto = $grade->mark_upto;
                    
                    // Compaer marks
                    if ($value->mark >= $mark_from && $value->mark <= $mark_upto) {
                        $gp = $grade->grade_point;
                        $grade_comment = $grade->comment;
                        $show .='<td>'.$grade->name.'</td>';
                    }

                }

                // Get Total Mark
                $totalmark += $value->mark;

                // Get Total GPA
                $tearm_total_gp += $gp;
                $tearm_gp = round($tearm_total_gp / $total_subject, 2);
                // Comment
                if (!empty($value->comment)) {
                    $show .='<td>'.$value->comment.'</td>';
                }else{
                    $show .='<td>'.$grade_comment.'</td>';
                }
                
                $show .='</tr>';
            }
            // End Foreach

            $show .='</table>';

            // Use for Show total mark and GPA
            $show .= '<table style="width: 100%;margin-top: 0px;">';
            $show .= '<tr>';
            $show .= '<td class="text-left"><b>Total Mark :'.$totalmark.'</b></td>';
            $show .= '<td class="text-right" ><b>GPA :'.$tearm_gp.'</b></td>';
            $show .= '</tr>';
            $show .= '</table>';
            $show .= '<div class="teacher_comment">';
            $show .= '<h4 style="margin:0; padding-bottom:10px;">'.getlang('site_teacher_comment', 'data').':</h4>';
            $show .= '<p><i>'.$comment.'</i></p>';
            $show .='</div>';
        }else{
            $show .= '<p style="color:red;">'.getlang('site_search_mismatch', 'data').'</p>';
        }
        $data['subject'] = $show;
        return $show;
    }

    /**
    * Get Grade List
    **/
    function getGradeList(){
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('grade');
        $query = $CI->db->get();
        $results = $query->result();
        return $results;
    }

   
    

     /**
    ** Get Subject List
    **/
    function getStudents(){

        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('students');
        $query = $CI->db->get();
        $results = $query->result();

        

        $output = '<select name="student_name" id="s_name" class="form-control required " >';
        $output .= '<option value="0">'.getlang('select_student', 'sys_data').'</option>';
        foreach ($results as $key => $item) {
            $name = getSingledata('users', 'name', 'userId', $item->userid);
            $id = $item->id;
            $output .= '<option value="'.$item->id.'">'.$name.'</option>';
        }
        $output .= '</select>';
        return $output;
    }
    /**
    ** Get Class List
    **/
    function ClassList(){
        // Get class value

        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('class');
        $query = $CI->db->get();
        $results = $query->result();

        $output = '<select name="class" id="class" class="form-control required" >';
        $output .='<option value="0" >'.getlang('site_select_class', 'data').'</option>';
        foreach ($results as $key => $item) {
            $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
                
        }
        $output .= '</select>';
        return $output;
    }


    /**
    ** Result display
    **/
    function ShowResults($exam_id,$class_id, $roll_id){

        $show = '';
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('exam_marks');
        $CI->db->where('class_id', $class_id);
        $CI->db->where('exam_id', $exam_id);
        $CI->db->where('roll', $roll_id);
        $query = $CI->db->get();
        $results = $query->result();
        if (!empty($results)) {
            
              // Grade list
        $gradeList = getGradeList();
        $sid = getSingledata('students', 'id', 'roll', $roll_id);
        
        // Get Subject list
        //$calss_id = getSingledata('students', 'class', 'id', $sid);
        $subjects = getSingledata('class', 'subjects', 'id', $class_id);
        $subject_list = explode(",", $subjects);
        $total_subject = count($subject_list);


        $show .= '<h3>Exam:'.getSingledata('exam', 'name', 'id', $exam_id).' </h3>';
        $show .='<table cellpadding="0" cellspacing="0" class="admin-table attendance-report" id="attendance-table" style="width: 100%;margin-top: 0px;margin-bottom: 20px;" align="center" >';

        $show .='<tr>';
        $show .='<th>'.getlang('site_form_subject', 'data').'</th>';
        $show .='<th>'.getlang('site_obtain_mark', 'data').'</th>';
        $show .='<th>'.getlang('site_grade', 'data').'</th>';
        $show .='<th>'.getlang('site_comment', 'data').'</th>'; 
        $gp = 0;
        $gp_name = 0;
        $tearm_total_gp =0;
        $tearm_gp = 0;
        $totalmark = 0;

        // Start Foreach
        foreach ($results as $key => $value) {
            $subject_name = getSingledata('subjects', 'name', 'id', $value->subject_id);
            //$show .= var_dump($subject_name);
            $show .='</tr>';
            $show .='<td>'.$subject_name.'</td>';
            $show .='<td>'.$value->mark.'</td>';

            // Get grade list
            $grade_comment = '';
            foreach ($gradeList as $key => $grade) {
                $mark_from = $grade->mark_from;
                $mark_upto = $grade->mark_upto;
                
                // Compaer marks
                if ($value->mark >= $mark_from && $value->mark <= $mark_upto) {
                    $grade_comment = $grade->comment;
                    $gp = $grade->grade_point;
                    $show .='<td>'.$grade->name.'</td>';
                }

            }

            // Get Total Mark
            $totalmark += $value->mark;

            // Get Total GPA
            $tearm_total_gp += $gp;
            $tearm_gp = round($tearm_total_gp / $total_subject, 2);
            // Comment
            if (!empty($value->comment)) {
                $show .='<td>'.$value->comment.'</td>';
            }else{
                $show .= '<td>'.$grade_comment.'</td>';
            }
            
            $show .='</tr>';
        }
        // End Foreach

        $show .='</table>';

        // Use for Show total mark and GPA
        $show .= '<table style="width: 100%;margin-top: 0px;">';
        $show .= '<tr>';
        $show .= '<td class="text-left"><b>'.getlang('site_total_mark', 'data').':'.$totalmark.'</b></td>';
        $show .= '<td class="text-right" ><b>'.getlang('site_gpa', 'data').' :'.$tearm_gp.'</b></td>';
        $show .= '</tr>';
        $show .= '</table>';
        $check = 1;

        }else{
            $check = 0;
            $show .= '<p style="color:red;">'.getlang('site_search_mismatch', 'data').'</p>';
        }

        $output = array();
        $output['html'] = $show;
        $output['check'] = $check;

        return $output;
    }

    /**
    ** Get Result Comment id by Exam id, Class id, tid, roll id.
    **/
    function getResultCommentId($class_id, $roll_id, $exam_id, $tid){
        $CI =& get_instance();
        $CI->db->select('id');
        $CI->db->from('result_comments');
        $CI->db->where('class', $class_id);
        $CI->db->where('roll', $roll_id);
        $CI->db->where('eid', $exam_id);
        $CI->db->where('tid', $tid);
        $query = $CI->db->get();
        $results = $query->row();
        if($results){
            $output = $results->id;
        }else{
            $output = '';
        }
        return $output;
    }

    /**
    ** Get comment
    **/ 
    function GetComment($exam_id,$class_id, $roll_id){
        $CI =& get_instance();
        $CI->db->select('comments');
        $CI->db->from('result_comments');
        $CI->db->where('class', $class_id);
        $CI->db->where('roll', $roll_id);
        $CI->db->where('eid', $exam_id);
        $query = $CI->db->get();
        $results = $query->row();
        if($results){
            $output = $results->comments;
        }else{
            $output = '';
        }
        return $output;
    }

   