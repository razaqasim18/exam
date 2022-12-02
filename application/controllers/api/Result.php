<?php
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Result extends REST_Controller
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
        $this->load->model('login_model');
        $this->load->database();
        $this->load->library('form_validation');
    }
    
    public function showresult_post(){
        $tokendata = getheader($this->input->request_headers());
        $userdetail = getUserbyToken($tokendata);
        
    	$reponse = array('status' => true);
        $role = $userdetail->role;
        $uid = $userdetail->userId;
        $html = '';
           
        if ($role == ROLE_TEACHER) {

            $exam_id  = $this->input->post('exam_id');
            $class_id = $this->input->post('class_id');
            $roll_id  = $this->input->post('roll_id');
            
            if(empty($exam_id)) {
                $result = ['status' => "error", 'message' => getlangapi('site_form_select_exam', 'data')];
                $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
            } 
            
            if(empty($class_id)) {
                $result = ['status' => "error", 'message' => getlangapi('site_form_select_class', 'data')];
                $this->response($result, REST_Controller::HTTP_BAD_REQUEST);    
            }
            
            if (empty($roll_id)) {
                $result = ['status' => "error", 'message' => getlangapi('site_form_enter_roll', 'data')];
                $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
            }
            
            // if (!empty($exam_id) && !empty($class_id) && !empty($roll_id)) {
            $return_value = ShowResultsApi($exam_id,$class_id, $roll_id);
            $html = $return_value;
            // }
            
        } elseif ($role == ROLE_STUDENT) {
            $sid= $this->input->post('sid');
            $exam= $this->input->post('exam_id');
            $return_value = DisplayResultApi($sid,$exam);
            $html = $return_value;
        } elseif ($role == ROLE_PARENT) {

            $sid= $this->input->post('s_name');
            $exam= $this->input->post('exam_id');
           
            if (empty($sid)) {
                $result = ['status' => "error", 'message' => getlangapi('site_form_select_student', 'data')];
                $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
            }
            
            if (empty($exam)) {
                $result = ['status' => "error", 'message' =>getlangapi('site_form_select_exam', 'data')];
                $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
            }
            // if (!empty($sid) && !empty($exam)) {
                $return_value = DisplayResultApi($sid,$exam);
                $html = $return_value;
            // }
        } else {
            $result = ['status' => "error", 'message' => 'Something went wrong'];
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
        }
       
        $reponse = $html;
        $this->response($reponse, REST_Controller::HTTP_OK);
        
    }
}    
