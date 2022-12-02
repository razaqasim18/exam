<?php
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Exam extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
        $this->load->library('Authorization_Token');
        $tokenresult = getheader($this->input->request_headers());
        if ($tokenresult['status'] == false) {
            $result = ['status' => 0, 'message' => $tokenresult['message']];
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
        }
        $this->load->model('exams_model');
        $this->load->database();
        $this->load->library('form_validation');
    }
    
    public function add_post($Id = NULL) {
        
        $tokendata = getheader($this->input->request_headers());
        $userdetail = getUserbyToken($tokendata);
        $role = $userdetail->role;
        $uid = $userdetail->userId;
        
        if ($role == ROLE_SUPPER_ADMIN || $role == ROLE_ADMIN ) {
            
			if (empty($Id)) {
				$Id = $this->input->post('id');
			}
            
            $name = $this->security->xss_clean($this->input->post('name'));
            if(empty($name)) {
                $result = ['status' => "error", 'message' => "Name is required"];
                $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
            } 
	
			// $name                   = $this->security->xss_clean($this->input->post('name'));
			$department_id          = $this->security->xss_clean($this->input->post('department'));
			$class_id               = $this->security->xss_clean($this->input->post('class_id'));
			$semistar               = $this->security->xss_clean($this->input->post('semistar'));
			$term                   = $this->security->xss_clean($this->input->post('term'));
			$type                   = $this->security->xss_clean($this->input->post('type'));
			$exam_date              = date('Y-m-d', strtotime($this->input->post('exam_date')));
			$form_fillup_start_date = date('Y-m-d', strtotime($this->input->post('form_fillup_start_date')));
			$form_fillup_last_date  = date('Y-m-d', strtotime($this->input->post('form_fillup_last_date')));
			$form_fee               = $this->security->xss_clean($this->input->post('form_fee'));
			$late_fee               = $this->security->xss_clean($this->input->post('late_fee'));

			$exam_info = [
				'name'                   => $name,
				'department_id'          => $department_id,
				'class_id'               => $class_id,
				'semistar'               => $semistar,
				'term'                   => $term,
				'type'                   => $type,
				'exam_date'              => $exam_date,
				'form_fillup_start_date' => $form_fillup_start_date,
				'form_fillup_last_date'  => $form_fillup_last_date,
				'form_fee'               => $form_fee,
				'late_fee'               => $late_fee
			];

			if (!empty($Id)) {
				$result          = $this->exams_model->edit($exam_info, $Id);
				$message_success = getlangapi('system_data_update_successfully', 'sys_data');
				$message_error   = getlangapi('system_data_update_failed', 'sys_data');
			} else {
				$result          = $this->exams_model->addNew($exam_info);
				$message_success = getlangapi('system_data_create_successfully', 'sys_data');
				$message_error   = getlangapi('system_data_create_failed', 'sys_data');
			}

			if ($result > 0) {
			    $result = ['statuss' => 'success', 'message' => $message_success];
                $this->response($result, REST_Controller::HTTP_OK);
			} else {
				$result = ['status' => 'false', 'message' => $message_error];
                $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
			}

		} else {
	    	$result = ['status' => 'false', 'message' => 'Access denied'];
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	
	public function examList_get(){
	    
// 	    if ($this->role == ROLE_STUDENT) {
// 			return true;
// 		}else{
// 			return false;
// 		}
	    
	    $tokendata = getheader($this->input->request_headers());
        $userdetail = getUserbyToken($tokendata);
        $role = $userdetail->role;
        $uid = $userdetail->userId;
        
	    $this->db->select('department');
		$this->db->select('class');
		$this->db->select('roll');
		$this->db->from('students');
		$this->db->where('userid', $uid);
		$query   = $this->db->get();
		$student = $query->row();

		$dept_id  = $student->department;
		$class_id = $student->class;
		$roll_no  = $student->roll;

		$this->db->select('*');
		$this->db->from('exam');
		$this->db->where('department_id', $dept_id);
		$this->db->where('class_id', $class_id);
		$this->db->where('form_fillup_start_date <=', date('Y-m-d'));
		$this->db->order_by('exam_date');
		$query = $this->db->get();
		$exams = $query->result_array();

		$data['exams']   = $exams;
		$data['dept']    = $dept_id;
		$data['rollno']  = $roll_no;
		$data['classid'] = $class_id;

        // $result = ['status' => 'true', 'result' => $data];
		$this->response($data, REST_Controller::HTTP_OK);
	}
    
}