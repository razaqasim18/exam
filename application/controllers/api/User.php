<?php
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class User extends REST_Controller
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
        $this->load->model('user_model');
        $this->load->database();
        $this->load->library('form_validation');
    }
    
    public function account_post()
    {
        //$role = $this->session->userdata ( 'role' );
        // get id from post
        //$id = $this->input->post('id');
        
        $tokendata = getheader($this->input->request_headers());
        $userdetail = getUserbyToken($tokendata);
        $role = $userdetail->role;
        $id = $userdetail->userId;

        if ($role == ROLE_TEACHER) {
            $section = 'teacher';
            $uid = getSingledata('teachers', 'id', 'userid', $id);
            $folder_name = 'teachers';
        } elseif ($role == ROLE_STUDENT) {
            $section = 'student';
            $uid = getSingledata('students', 'id', 'userid', $id);
            $folder_name = 'students';
        } elseif ($role == ROLE_PARENT) {
            $section = 'parent';
            $uid = getSingledata('parents', 'id', 'userid', $id);
            $folder_name = 'parents';
        } else {
            $folder_name = 'users';
            $uid = '';
        }
       

        if(!empty($id)){
            // Get update account info
            $error = "";
            // Get data for account
            $name = ucwords(strtolower($this->security->xss_clean($this->input->post('name'))));
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
             // Get data for password
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');

            // Get data for avatar
            $old_avatar = $this->input->post('old_avatar');
            $new_avatar = $_FILES['avatar']['name'];

            // Get upload avatar
            $avatar = uploadImage($new_avatar, $old_avatar, 'avatar', './uploads/'.$folder_name.'/', 'gif|jpg|png', '', '', '');
            if(empty($name)) {
                $error .= "name is required \n";
            }
            
            if(empty($mobile)) {
                $error .= "mobile is required \n";
            }
            
            // if(empty($oldPassword)) {
            //     $error .= "oldPassword is required \n";
            // }
            
            if(!empty($newPassword)) {
                $resultPas = $this->user_model->matchOldPassword($id, $oldPassword);
                if(empty($resultPas)){
                    $error .= getlangapi('system_old_pass_error', 'sys_data'). "\n";
                }
            }
            
            if(!empty($error)){
                $result = ['status' => 'error', 'message' =>$error];
                $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
            } 
            
            if(!empty($newPassword)){
                $userInfo = array(
                    'name'=>$name,
                    'mobile'=>$mobile,
                    'avatar'=>$avatar,
                    'password'=>getHashedPassword($newPassword),
                    'createdBy'=>$id, 
                    'createdDtm'=>date('Y-m-d H:i:s')
                );

                $panelInfo = array(
                    'name'=>$name,
                    'phone'=>$mobile,
                    'avatar'=>$avatar
                );
            } else {
                $userInfo = array(
                    'name'=>$name,
                    'mobile'=>$mobile,
                    'avatar'=>$avatar,
                    'createdBy'=>$id, 
                    'createdDtm'=>date('Y-m-d H:i:s')
                );

                $panelInfo = array(
                    'name'=>$name,
                    'phone'=>$mobile,
                    'avatar'=>$avatar
                );
            }
                
            $result = $this->user_model->edit($role, $userInfo, $panelInfo, $id, $uid, $section);

            $message_success = getlangapi('site_data_update_successfully', 'data');
            $message_error = getlangapi('site_data_update_failed', 'data');
                
            if($result > 0){
                $enable_user_udate = getConfigItem('enable_user_udate');
                if(!empty($enable_user_udate)){
                    $email = getSingledata('users', 'email', 'userId', $id);
                    send_update_confirmation($email, $name);
                }
            $result = ['status' => 'success', 'message' =>$message_success];
            $this->response($result, REST_Controller::HTTP_OK);
            } else {
                $result = ['status' => 'error', 'message' =>$message_error];
                $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
            }
                
        } else {
            $result = ['status' => 'error', 'message' =>"Something went wrong"];
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
        }
        
    }
}    