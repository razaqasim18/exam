<?php

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Authentication extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
        $this->load->library('Authorization_Token');
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->database();
        $this->load->library('form_validation');
    }
    

    public function login_post() {
        $error = "";
        $email = $this->security->xss_clean($this->input->post('email'));
        $password = $this->input->post('password');
        
        if(empty($email)){
              $error .="Passsword is required"."\n";
        }
        
        if(empty($password)){
            $error .="Passsword is required"."\n";
        }
        
        if (!empty($error)) {
            $result = ['status' => "error", 'message' => $error];
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
        }
        
        $result = $this->login_model->getlogin($email, $password);
        if ($result) {
            $lastLogin = $this->login_model->lastLoginInfo($result->userId);
            $token_data['userId'] = $result->userId;
            $token_data['role'] = $result->roleId;
            $token_data['roleText'] = $result->role;
            $token_data['name'] = $result->name;
            $token_data['lastLogin'] = $lastLogin->createdDtm;
            $token_data['isLoggedIn'] = true;
            $result->token = $this->authorization_token->generateToken($token_data);
            $this->response($result, REST_Controller::HTTP_OK);
        } else {
            $result = ['status' => "error", 'message' => "Email or password mismatch"];
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
        }
          
    }
    
    public function register_post(){
        $error = "";
        $role     = $this->security->xss_clean($this->input->post('role'));
        $name     = ucwords(strtolower($this->security->xss_clean($this->input->post('name'))));
        $email    = $this->security->xss_clean($this->input->post('email'));
        $password = $this->input->post('password');
        $mobile   = $this->security->xss_clean($this->input->post('mobile'));
        
        if(empty($role)){
            $error .="Role is required"."\n";
        }
        
        if(empty($name)){
            $error .="Name is required"."\n";
        }
        
        if(empty($email)){
            $error .="Email is required"."\n";
        }
        
        if(empty($password)){
            $error .="Password is required"."\n";
        }
        
        if(empty($mobile)){
            $error .="Mobile is required"."\n";
        }
        
        if (!empty($error)) {
            $result = ['status' => "error", 'message' => $error];
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
        }
        
        
        if($role){
            if($role == ROLE_STUDENT){
                $studenterror = "";
                $class      = $this->security->xss_clean($this->input->post('class_name'));
                $department = $this->security->xss_clean($this->input->post('department'));
                $year       = $this->security->xss_clean($this->input->post('year'));
                $roll       = $this->security->xss_clean($this->input->post('roll'));
                
                if(empty($class)){
                      $studenterror .="Class is required"."\n";
                }
                
                if(empty($department)){
                    $studenterror .="Department is required"."\n";
                }
                
                if(empty($year)){
                    $studenterror .="Year is required"."\n";
                }
                
                if(empty($roll)){
                    $studenterror .="Roll is required"."\n";
                }
                
                if (!empty($studenterror)) {
                    $result = ['status' => "error", 'message' => $studenterror];
                    $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
                }
                
                $account_info = array(
                    'email'      =>$email,
                    'password'   =>getHashedPassword($password), 
                    'roleId'     =>$role, 
                    'name'       => $name,
                    'mobile'     =>$mobile, 
                    'createdDtm' =>date('Y-m-d H:i:s')
                );

                $students_info = array(
                    'roll'       => $roll, 
                    'year'       => $year, 
                    'class'      =>$class,
                    'department' =>$department
                );

                $result = $this->user_model->addNewStudents($account_info, $students_info);
                $message_success = getlangapi('student_registration_successfully');
                $message_error = getlangapi('student_registration_failed');

                if($result > 0){
                    $result = ['status' => 'success', 'message' =>$message_success];
                    $this->response($result, REST_Controller::HTTP_OK);
                } else {
                    $result = ['status' => 'error', 'message' =>$message_error];
                    $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
                }
            } else if($role == ROLE_PARENT){
                $parenterror = "";
                $role       = $this->security->xss_clean($this->input->post('role'));
                $name       = $this->security->xss_clean($this->input->post('name'));
                $email      = $this->security->xss_clean($this->input->post('email'));
                $password   = $this->input->post('password');
                $mobile     = $this->security->xss_clean($this->input->post('mobile'));
                
                if(empty($role)){
                    $parenterror .="Role is required"."\n";
                }
                
                if(empty($name)){
                    $parenterror .="Name is required"."\n";
                }
                
                if(empty($email)){
                    $parenterror .="Email is required"."\n";
                }
                
                if(empty($password)){
                    $parenterror .="Password is required"."\n";
                }
                
                if(empty($mobile)){
                    $parenterror .="Mobile is required"."\n";
                }
                
                if (!empty($error)) {
                    $result = ['status' => "error", 'message' => $parenterror];
                    $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
                }
                
                $account_info = array(
                    'email'      => $email,
                    'password'   => getHashedPassword($password), 
                    'roleId'     => $role, 
                    'name'       => $name,
                    'mobile'     => $mobile, 
                    'createdDtm' => date('Y-m-d H:i:s')
                );
                
                $result = $this->user_model->addNewParents($account_info);
                $message_success = getlangapi('parent_registration_successfully');
                $message_error   = getlangapi('parent_registration_failed');
                if($result > 0){
                    $result = ['status' => 'success', 'message' =>$message_success];
                    $this->response($result, REST_Controller::HTTP_OK);
                } else {
                    $result = ['status' => 'error', 'message' =>$message_error];
                    $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
                }

           
            } else if($role == ROLE_TEACHER){
                
                 
                $teachererror = "";
                
                $role       = $this->security->xss_clean($this->input->post('role'));
                $name       = $this->security->xss_clean($this->input->post('name'));
                $email      = $this->security->xss_clean($this->input->post('email'));
                $password   = $this->input->post('password');
                $mobile     = $this->security->xss_clean($this->input->post('mobile'));
    
                $class      = $this->security->xss_clean($this->input->post('class_name[]'));
                $department = $this->security->xss_clean($this->input->post('departments_name[]'));
                $subject       = $this->security->xss_clean($this->input->post('subject_name[]'));
                
                if(empty($role)){
                      $teachererror .="Role is required"."\n";
                }
                
                if(empty($name)){
                    $teachererror .="Name is required"."\n";
                }
                
                if(empty($email)){
                    $teachererror .="Email is required"."\n";
                }
                
                if(empty($password)){
                    $teachererror .="Password is required"."\n";
                }
                
                if(empty($mobile)){
                    $teachererror .="Mobile is required"."\n";
                }
                
                if(empty($class)){
                    $teachererror .="Class is required"."\n";
                }
                if(empty($department)){
                    $teachererror .="Department is required"."\n";
                }
                if(empty($subject)){
                    $teachererror .="Subject is required"."\n";
                }
                
                if (!empty($error)) {
                    $result = ['status' => "error", 'message' => $teachererror];
                    $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
                }
                
                $data['role_id']      = $role;
                $data['name']         = $name;
                $data['email']        = $email;
                $data['password']     = $password;
                $data['mobile']       = $mobile;
                
                if(!empty($class)){
                    $data['class']        = implode(',', $class);
                } else {
                    $data['class']        = '';
                }
                
                if(!empty($department)){
                    $data['department']   = implode(',', $department);
                } else {
                    $data['department']   = '';
                }
                
                if(!empty($subject)){
                    $data['subject']      = implode(',', $subject);
                } else {
                    $data['subject']      = '';
                }
                
                $department = implode(",",$department);
                $subject = implode(",",$subject);
                $class = implode(",",$class);
               
                $account_info = array(
                    'email'      => $email,
                    'password'   => getHashedPassword($password), 
                    'roleId'     => $role, 
                    'name'       => $name,
                    'mobile'     => $mobile, 
                    'createdDtm' => date('Y-m-d H:i:s')
                );

                $teacher_info = array(
                    'class'       => $class,
                    'department'  => $department, 
                    'subject'     => $subject 
                );
              
                $result = $this->user_model->addNewTeacher($account_info, $teacher_info);
                $message_success = getlangapi('teacher_registration_successfully');
                $message_error = getlangapi('teacher_registration_failed');

                if($result > 0){
                    $result = ['status' => 'success', 'message' =>$message_success];
                    $this->response($result, REST_Controller::HTTP_OK);
                } else {
                    $result = ['status' => 'error', 'message' =>$message_error];
                    $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
                }
            }
            
        } else {
                $result = ['status' => 'error', 'message' => "Something went wrong"];
                $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}