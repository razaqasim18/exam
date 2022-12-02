<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/FrontEndController.php';

/**
 * Classes : Class (ClassesController)
 * Classes Class to control all class related operations.
 * @author : zwebtheme
 * @version : 1.1
 * @since : May 2018
 */

class Attendances extends FrontEndController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('attendances_model');
        $this->load->library('session');
        $this->isLoggedIn();   
    }
    
    /**
    ** Add/ Edit Function
    **/
    function add($Id = NULL)
    {

        if($this->isTeacher() == TRUE)
        {

            $this->load->library('form_validation');
            if(empty($Id)){
                $Id = $this->input->post('id');
            }
            
            $this->form_validation->set_rules('attendances_date','Attendances Date','required');

            if($this->form_validation->run() == FALSE)
            {
                if(!empty($Id)){
                    $data['item_data'] = $this->attendances_model->getItem($Id);
                    //$data['student_list'] = $this->attendances_model->getStudents($Id);
                    $this->global['pageTitle'] = getlang('site_browser_edit_attendances_title', 'data');
                    $this->loadViews('rocky', "frontend/attendances/add", $this->global, $data , NULL);
                }else{
                    $this->global['pageTitle'] = getlang('site_browser_addnew_attendances_title', 'data');
                    $this->loadViews('rocky', "frontend/attendances/add", $this->global, NULL , NULL);
                }
            }
            else
            {

                
                
                $attendances_date = $this->input->post('attendances_date');
                $class_name = $this->input->post('class_name');
                $department = $this->input->post('department');
                $teacher_name = $this->input->post('teacher_name');

                if (!empty($class_name) && !empty($department)) {
                        

                    $studentsList = getStudentsList($class_name, $department);
                    $totalstudents = count($studentsList);
                    if(empty($Id)){
                        $attendance = array(
                            'attendance_date'=> $attendances_date,
                            'class'=> $class_name, 
                            'department'=> $department,
                            'total_student'=> $totalstudents,
                            'teacher'=> $teacher_name
                        
                        );
                    }else{
                        $attendance = array(
                            'attendance_date'=> $attendances_date,
                            'class'=> $class_name, 
                            'department'=> $department,
                            'total_student'=> $totalstudents,
                            'teacher'=> $teacher_name,
                            'update_date'=> date('d-m-Y h:i:s')
                            
                        );
                    }
                    
                    if(!empty($Id)){
                        $result = $this->attendances_model->edit($attendance, $Id);
                        $message_success = getlang('site_data_update_successfully', 'data');
                        $message_error = getlang('site_data_update_failed', 'data');
                    }else{
                        $result = $this->attendances_model->addNew($attendance);
                        $Id = $result;
                        $message_success = getlang('site_data_create_successfully', 'data');
                        $message_error = getlang('site_data_create_failed', 'data');
                    }
                    
                    if($result > 0){
                        $this->session->set_flashdata('success', $message_success);
                    }else{
                        $this->session->set_flashdata('error', $message_error);
                    }

                    redirect(base_url().'user/attendance/add/'.$Id);
                }else{
                    if (empty($class_name)) { 
                        $message_error = getlang('site_select_class', 'data');
                    }
                    if (empty($department)) { 
                        $message_error .= getlang('site_select_department', 'data');
                    }
                    redirect(base_url().'user/attendance/add');
                }

            }
        }
    }

    /**
    ** Get Attendance List
    **/
    function attendanceslist()
    {
        
        $this->load->library('pagination');
        $count = $this->attendances_model->getAttendanceCount();
        $per_item = getConfigItem('item_per_list');
        if(empty($per_item)){$per_item = 10;}
        $returns = $this->paginationCompress ("/attendance/", $count, $per_item, 3 );

        $this->global['pageTitle'] = getlang('site_browser_attendance_title', 'data');
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';

    	if($this->isTeacher() == TRUE){
            $data['data'] = $this->attendances_model->getAttendance($returns["page"], $returns["segment"]);
	        $this->loadViews('rocky', "frontend/attendances/default", $this->global, $data , NULL);
        }elseif($this->isStudent() == TRUE){
            $data['data'] = $this->attendances_model->getAttendance($returns["page"], $returns["segment"]);
	        $this->loadViews('rocky', "frontend/attendances/default_student", $this->global, $data , NULL);
        }elseif ($this->isParent() == TRUE) {
        	$data['data'] = $this->attendances_model->getAttendance($returns["page"], $returns["segment"]);
	        $this->loadViews('rocky', "frontend/attendances/default_parent", $this->global, $data , NULL);
        }
    	
        
    }

    
    /**
    ** Get Save Attendance
    **/
    function saveStatus(){
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );

        $aid    = $this->input->post('aid');
        $sid    = $this->input->post('sid');
        $status = $this->input->post('status');

        if($status=="true"){
            $status_value ="1";
        }
     
        if($status=="false"){
            $status_value ="0";
        }

        $attendance_data = array(
                            'entry_by'      => $this->uid,
                            'student_id'    => $sid, 
                            'attend'        => $status_value,
                            'attendance_id' => $aid,
                            'update_date'   => date('Y-m-d H:i:s')
                        );

        $html = '';

        // Get Attendance info id
        $attendance_info_id = $this->attendances_model->getAttendanceInfoID($aid, $sid);
        if(!empty($attendance_info_id)){
            // Get Update
            $status_id = $this->attendances_model->getStatusUpdate($attendance_info_id, $attendance_data);
        }else{
            // Get new 
            $status_id = $this->attendances_model->getStatusNew($attendance_info_id, $attendance_data);
        }
        

        if (!empty($status_id)) {
            $html .= ' ';
        }else{
           $html .='<p style="color:red;padding:0; margin:0;">'.getlang('site_error', 'data').'</p>';
        }
       
        $reponse['html'] = $html;

        echo json_encode($reponse);
    }
    

    /**
    ** Get Attendance report
    **/
    function report(){
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );

        $sid    = $this->input->post('sid');
        $year    = $this->input->post('year');
        $month = $this->input->post('month');

        $html = '';
        if(!empty($sid) && !empty($year) && !empty($month)){
            $return_value = DisplayAttendance( $year, $month, $sid);
            $html .= $return_value;
        }else{
            if(empty($sid)){
                $html .=getlang('site_form_select_student', 'data');
            }elseif(empty($month)){
                $html .=getlang('site_form_select_month', 'data');
            }elseif (empty($year)) {
                $html .=getlang('site_form_select_year', 'data');
            }
         
        }

        $reponse['html'] = $html;

        echo json_encode($reponse);
    }
    
    
}

?>
