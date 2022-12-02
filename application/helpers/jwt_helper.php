<?php

//function get Authorization header
if (!function_exists('getheader')) {
    function getheader($headers)
    {
        $ci = &get_instance();
        if (isset($headers['authorization']) || isset($headers['Authorization'])) {
            if (isset($headers['authorization'])) {
                $token = $headers['authorization'];
            } else {
                $token = $headers['Authorization'];
            }
            $tokenresult = $ci->authorization_token->validateToken($token);
        } else {
            $tokenresult = ['status' => false, 'message' => 'token is required'];
        }
        return $tokenresult;
    }
}

//function get userid from token
if (!function_exists('getUseridbyToken')) {
    function getUseridbyToken($token)
    {
        $userdata = $token['data'];
        $id = $userdata->user_id;
        return $id;
    }
}

// userdetyail
if (!function_exists('getUserbyToken')) {
    function getUserbyToken($token)
    {
        $userdata = $token['data'];
        return $userdata;
    }
}


if (!function_exists('DisplayResultApi')) {
    function DisplayResultApi($sid, $exam){
      
        // $show = array();
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('exam_marks');
        $CI->db->where('student_id', $sid);
        $CI->db->where('exam_id', $exam);
        $query = $CI->db->get();
        $results = $query->result();
        //  var_dump($results);
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
            
            $data[getlangapi('site_exam', 'data')] = getSingledata('exam', 'name', 'id', $exam);
            
            $gp = 0;
            $gp_name = 0;
            $tearm_total_gp =0;
            $tearm_gp = 0;
            $totalmark = 0;

            $show = [];
        
            // Start Foreach
            foreach ($results as $key => $value) {
                $subject_name = getSingledata('subjects', 'name', 'id', $value->subject_id);
                
                
                
                
                // // Get grade list
                $grade_comment = '';
                foreach ($gradeList as $key1 => $grade) {
                    $mark_from = $grade->mark_from;
                    $mark_upto = $grade->mark_upto;
                    
                    // Compaer marks
                    if ($value->mark >= $mark_from && $value->mark <= $mark_upto) {
                        $gp = $grade->grade_point;
                        $grade_comment = $grade->comment;
                        $grade_name = $grade->name;
                    }

                }
                // Get Total Mark
                $totalmark += $value->mark;

                // Get Total GPA
                $tearm_total_gp += $gp;
                $tearm_gp = round($tearm_total_gp / $total_subject, 2);
                // Comment
                $commentCond = (!empty($value->comment)) ? $grade->comment : $grade_comment;
                $show[] = [
                   getlangapi('site_form_subject', 'data') => $subject_name,
                   getlangapi('site_obtain_mark', 'data') =>  $value->mark,
                   getlangapi('site_grade', 'data') => $grade_name,
                   getlangapi('site_comment', 'data') => $commentCond
                ];
            }
            $data['totalmark'] = $totalmark;
            $data['gpa'] = $tearm_gp;
            $data[getlangapi('site_teacher_comment', 'data')] = $comment;
        } else {
            $show = getlangapi('site_search_mismatch', 'data');
        }
        $data["result"] = $show;
        return $data;
    }
}

if (!function_exists('ShowResultsApi')) {
    function ShowResultsApi($exam_id,$class_id, $roll_id){

        $show = array();
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('exam_marks');
        $CI->db->where('class_id', $class_id);
        $CI->db->where('exam_id', $exam_id);
        $CI->db->where('roll', $roll_id);
        $query = $CI->db->get();
        $results = $query->result();
                // Check data
        if (!empty($results)) {
            // Grade list
            $gradeList = getGradeList();
            $sid = getSingledata('students', 'id', 'roll', $roll_id);
            
            // Get Subject list
            //$calss_id = getSingledata('students', 'class', 'id', $sid);
            $subjects = getSingledata('class', 'subjects', 'id', $class_id);
            $subject_list = explode(",", $subjects);
            $total_subject = count($subject_list);
            
            $show[getlangapi('site_exam', 'data')] = getSingledata('exam', 'name', 'id', $exam_id);
            
            $gp = 0;
            $gp_name = 0;
            $tearm_total_gp =0;
            $tearm_gp = 0;
            $totalmark = 0;


            // Start Foreach
            foreach ($results as $key => $value) {
                $subject_name = getSingledata('subjects', 'name', 'id', $value->subject_id);
                
                // Get grade list
                $grade_comment = '';
                foreach ($gradeList as $key1 => $grade) {
                    $mark_from = $grade->mark_from;
                    $mark_upto = $grade->mark_upto;
                    
                    // Compaer marks
                    if ($value->mark >= $mark_from && $value->mark <= $mark_upto) {
                        $gp = $grade->grade_point;
                        $grade_comment = $grade->comment;
                        $grade_name = $grade->name;
                    }

                }
                // Get Total Mark
                $totalmark += $value->mark;

                // Get Total GPA
                $tearm_total_gp += $gp;
                $tearm_gp = round($tearm_total_gp / $total_subject, 2);
                // Comment
                $commentCond = (!empty($value->comment)) ? $grade->comment : $grade_comment;
                $show[] = [
                   getlangapi('site_form_subject', 'data') => $subject_name,
                   getlangapi('site_obtain_mark', 'data') =>  $value->mark,
                   getlangapi('site_grade', 'data') => $grade_name,
                   getlangapi('site_comment', 'data') => $commentCond
                ];
            }
            $data['totalmark'] = $totalmark;
            $data['gpa'] = $tearm_gp;
        } else {
            $show = getlangapi('site_search_mismatch', 'data');
        }
        $data["result"] = $show;
        return $data;
    }
}
function getlangapi($name, $field_name = 'data')
{
    $CI = &get_instance();

    if ($field_name == 'data') {
        $sys_data = getSiteLang();
    } else {
        $sys_data = getSystemLang();
    }

    // Get default language
    $lang_id = getConfigItem('default_language');
    // $sw      = $CI->session->userdata('site_lang');

    if (empty($sw)) {
        $lang_id = $lang_id;
    } else {
        $lang_id = $sw;
    }

    $lang_param = getSingledata('languages', $field_name, 'id', $lang_id);
    $param_data = json_decode($lang_param, true);

    if (!empty($param_data[$name][0])) {
        $output = $param_data[$name][0];
    } else {
        if (!empty($sys_data[$name])) {
            $output = $sys_data[$name];
        } else {
            $output = '';
        }
    }

    return $output;
}