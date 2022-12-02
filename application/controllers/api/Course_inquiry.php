<?php

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Course_inquiry extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
        $this->load->model('course_inquiry_model');
        $this->load->database();
    }
    
    // public function index_get(){
    //     echo "sss";
    // }
    
    public function insert_post(){
        
        $name = $this->security->xss_clean($this->input->post('name'));
        $email = $this->security->xss_clean($this->input->post('email'));
        $mobile = $this->security->xss_clean($this->input->post('mobile'));
        $nationality = $this->security->xss_clean($this->input->post('nationality'));
        $state = $this->security->xss_clean($this->input->post('state'));
        $city = $this->security->xss_clean($this->input->post('city'));
        $program = $this->security->xss_clean($this->input->post('program'));
        $qualification = $this->security->xss_clean($this->input->post('qualification'));
        $gender = $this->security->xss_clean($this->input->post('gender'));
        $caste = $this->security->xss_clean($this->input->post('caste'));
        
        $error = '';
        if(empty($name)){
             $error .="Name is required"."\n";
        }
        if(empty($email)){
             $error .="Email is required"."\n";
        }
        if(empty($mobile)){
             $error .="Mobile is required"."\n";
        }
        if(empty($nationality)){
             $error .="Nationality is required"."\n";
        }
        if(empty($state)){
             $error .="State is required"."\n";
        }
        if(empty($city)){
             $error .="City is required"."\n";
        }
        if(empty($program)){
             $error .="Program is required"."\n";
        }
        if(empty($qualification)){
             $error .="Qualification is required"."\n";
        }
        if(empty($gender)){
             $error .="Gender is required"."\n";
        }
        if(empty($caste)){
             $error .="Caste is required"."\n";
        }
          if (!empty($error)) {
            $result = ['status' => "error", 'message' => $error];
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
        }
        
        $course_info = [
            'name' => $name,
            'email'=> $email,
            'mobile' =>$mobile,
            'nationality' => $nationality,
            'state' => $state,
            'city' => $city,
            'program' => $program,
            'qualification' => $qualification,
            'gender' => $gender,
            'caste' => $caste
        ];
        $result = $this->course_inquiry_model->addNew($course_info);
        $message_success = getlangapi('course_inquiry_post_successfully');
        $message_error = getlangapi('course_inquiry_post_failed');

        if($result > 0){
            $result = ['status' => 'success', 'message' =>$message_success];
            $this->response($result, REST_Controller::HTTP_OK);
        } else {
            $result = ['status' => 'error', 'message' =>$message_error];
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
}
    