<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    /**
    ** Get Total Present
    **/
    function totalPresent($aid){
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('attendance_info');
        $CI->db->where('attend', 1);
        $CI->db->where('attendance_id', $aid);
        $query = $CI->db->get();
        return $query->num_rows();
    }

    /**
    ** Get Total Absent
    **/
    function totalAbsent($aid){
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('attendance_info');
        $CI->db->where('attend', 0);
        $CI->db->where('attendance_id', $aid);
        $query = $CI->db->get();
        return $query->num_rows();
    }

    /**
    ** Get Attendance Student List
    **/
    function getAttendanceStudents($class, $department)
    {
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('students');
        $CI->db->where('class', $class);
        $CI->db->where('department', $department);
        $query = $CI->db->get();
        return $query->result();
    }

    /**
    ** Get Attendance Statu by Student ID
    **/
    function getStatusByStudent($sid, $aid)
    {
        $CI =& get_instance();
        $CI->db->select('attend');
        $CI->db->from('attendance_info');
        $CI->db->where('student_id', $sid);
        $CI->db->where('attendance_id', $aid);
        $query = $CI->db->get();
        $results = $query->row();
        if ($results) {
            $output = $results->attend;
        }else{
            $output = '';
        }
        
        return $output;
    }

    /**
    ** Attendance display
    **/
    function DisplayAttendance($year_id, $month, $student_id){

        $show         = '';
        $class        = getSingledata('students', 'class', 'id', $student_id);
        $department   = getSingledata('students', 'department', 'id', $student_id);
        $student_year = getSingledata('students', 'year', 'id', $student_id);
        if(empty($year_id)){
            $year = getSingledata('academic_year', 'year', 'id', $student_year);
        }else{
            $year = getSingledata('academic_year', 'year', 'id', $year_id);
        }

        $months = array( 
        	        'January', 
        	        'February', 
        	        'March', 
        	        'April',  
        	        'May', 
        	        'June', 
        	        'July', 
        	        'August', 
        	        'September',
        	        'October', 
        	        'November',
        	        'December'
        	    );
                           
        $d=cal_days_in_month(CAL_GREGORIAN,$month,$year);
        $month_val = $month-1;
        $month_title = $months[$month_val];
        $monthend = $d;
        $monthstart = 1;
                        
        // Get Total Class
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('attendance');
        $CI->db->where('class', $class);
        $CI->db->where('department', $department);
        $CI->db->where('YEAR(attendance_date)', $year);
        $CI->db->where('MONTH(attendance_date)', $month);
        
        $query = $CI->db->get();
        $total_class = $query->num_rows();

              
        $startdate = $year.'-'.$month.'-'.$monthstart;
        $enddate = $year.'-'.$month.'-'.$monthend;
                        
        // Get Present Query
        $CI->db->select('*');
        $CI->db->from('attendance_info');
        $CI->db->where("create_date BETWEEN '".$startdate." 00:00:01' AND '".$enddate." 23:59:59'");
        $CI->db->where('student_id', $student_id);
        $CI->db->where('attend', 1);
        $query_present = $CI->db->get();
        $total_present = $query_present->num_rows();

                      
        // Get Absent Query
        $CI->db->select('*');
        $CI->db->from('attendance_info');
        $CI->db->where("create_date BETWEEN '".$startdate." 00:00:01' AND '".$enddate." 23:59:59'");
        $CI->db->where('student_id', $student_id);
        $CI->db->where('attend', 0);
        $query_absent = $CI->db->get();
        $total_absent = $query_absent->num_rows();
                
        $show .='<table cellpadding="0" cellspacing="0" class="admin-table " id="attendance-table" style="width: 100%;border: 1px solid #eee;background: #f5f5f5;" align="center" >';
        $show .='<tr>';
            $show .= '<td style="text-align: left;border: none;"><b>'.$month_title.'</b></td>';
            $show .= '<td style="border: none;"><i> Total Class: '.$total_class.' days</i></td>';
            $show .= '<td style="border: none;"><i>Total Present: '.$total_present.' days</i></td>';
            $show .= '<td style="border: none;"><i>Total Absent: '.$total_absent.' days</i></td>';
        $show .='</tr>';
        $show .='</table>';



        $show .='<table cellpadding="0" cellspacing="0" class="admin-table attendance-report" id="attendance-table" style="width: 100%;margin-top: 0px;margin-bottom: 20px;" align="center" >';

        $show .='<tr>';
        $show .='<th>Day</th>';
        $show .='<th>Status</th>';
        $show .='<th>Entry By</th>';
        $show .='<th>Date & Time</th>';
        $show .='</tr>';
        
            for ($h = $monthstart; $h <= $monthend; $h++) {
                $show .='<tr>';
                $getattendanceD = getAttendanceDay('DAY(attendance_date)',$year, $month , $h ,$class, $department);
                $attendane_id   = getAttendanceDay('id',$year, $month , $h ,$class, $department);
                $student_attent = getAttentBy('attend', $student_id, $attendane_id);
                $create_date    = getAttentBy('create_date', $student_id, $attendane_id);
                $atten_date     = date( 'd-M-Y', strtotime($create_date));
                $atten_time     = date( '(g:i A)', strtotime($create_date));
                $tuid           = getAttentBy('entry_by', $student_id, $attendane_id);
                $teacher_name   = getSingledata('users', 'name', 'userid', $tuid);

                if($student_attent==1){
                    $pstatus = '<span style="color: green;font-weight: Bold;">Present</span>';
                    $pstatus_bg ='#ccffcc';
                }else{
                    $pstatus = '<span style="color: red;font-weight: Bold;">Absent</span>';
                    $pstatus_bg ='#ffcccc';
                }

                if($getattendanceD==$h){
                    $show .='<td style="background: '.$pstatus_bg.';" >'.$h.'</td>';
                    $show .='<td style="background: '.$pstatus_bg.';" >'.$pstatus.'</td>';
                    $show .='<td style="background: '.$pstatus_bg.';" >'.$teacher_name.'</td>';
                    $show .='<td style="background: '.$pstatus_bg.';" >'.$atten_date.' '.$atten_time.'</td>';
                }else{
                    $show .= '<td >'.$h.'</td>';
                    $show .= '<td ></td>';
                    $show .= '<td ></td>';
                    $show .= '<td ></td>';
                }
                $show .='</tr>';
            } 
        
        
        $show .='</table>';
        return $show;
    }


    function getAttendanceDay($select, $year, $month , $day ,$class, $department){
    	$CI =& get_instance();
        $CI->db->select($select);
        $CI->db->from('attendance');
        $CI->db->where('YEAR(attendance_date)', $year);
        $CI->db->where('MONTH(attendance_date)', $month);
        $CI->db->where('DAY(attendance_date)', $day);
        $CI->db->where('class', $class);
        $CI->db->where('department', $department);
        $query = $CI->db->get();
        $results = $query->row();
        if ($results) {
            $output = $results->$select;
        }else{
            $output = '';
        }
        return $output;
	}

	function getAttentBy($field, $student_id, $attendane_id){
		$CI =& get_instance();
        $CI->db->select($field);
        $CI->db->from('attendance_info');
        $CI->db->where('student_id', $student_id);
        $CI->db->where('attendance_id', $attendane_id);
        $query = $CI->db->get();
        $results = $query->row();
        if ($results) {
            $output = $results->$field;
        }else{
            $output = '';
        }
        return $output;
	}
   