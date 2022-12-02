<?php 
/**
 * @package   : Bogra - School Management System for CodeIgniter
 * @author    : www.zwebtheme.com
 * @copyright : (C) 2018-2019 zwebtheme. All rights reserved.
 **/ 

if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/FrontEndController.php';

class User extends FrontEndController
{

    /**
    **  Constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->database();
        $this->load->library('session');
        $this->isLoggedIn();   
    }
    
    /**
    ** Index
    **/
    public function index()
    {
        $this->global['pageTitle'] = ''.getlang('site_dashboard_browser_title', 'data').'';
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';
        $this->loadViews('rocky', "frontend/user/dashboard", $this->global, NULL , NULL);
    }

    /**
    ** User Profile
    **/
    public function profile()
    {
        $role = $this->session->userdata ( 'role' );
        $user_id = $this->session->userdata ( 'userId' );
        $data['user_data'] = $this->user_model->getUser($user_id);
        $this->global['pageTitle'] = getlang('site_browser_my_profile_title','data');
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';
        //$role = '';
        if ($role == ROLE_TEACHER) {
            $this->loadViews('rocky', "frontend/user/profile_teacher", $this->global, $data , NULL);
        }elseif ($role == ROLE_STUDENT) {
            $this->loadViews('rocky', "frontend/user/profile_student", $this->global, $data , NULL);
        }elseif ($role == ROLE_PARENT) {
            $this->loadViews('rocky', "frontend/user/profile_parent", $this->global, $data , NULL);
        }else{
            $this->loadViews('rocky', "frontend/user/profile", $this->global, $data , NULL);
        }
        
    }

    public function studentprofile($Id = NULL){
        $user_id = getSingledata('students', 'userid', 'id', $Id);
        $data['user_data'] = $this->user_model->getUser($user_id);
        $this->global['pageTitle'] = getlang('site_browser_student_profile_title', 'data');
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';
        $this->loadViews('rocky', "frontend/user/profile_student", $this->global, $data , NULL);
    }

    /**
    ** User Logs
    **/
    public function logs()
    {
        $this->load->library('pagination');

        $disable_logs = getConfigItem('disable_logs');
        if (empty($disable_logs)) {

            
            $count = $this->user_model->logListingCount($this->uid);

            $per_item = getConfigItem('item_per_list');
            if(empty($per_item)){$per_item = 10;}

            
            $returns = $this->paginationCompress ( "user/logs", $count, $per_item, 3 );
            $data['user_data'] = $this->user_model->getLogs($this->uid, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = getlang('site_browser_log_title', 'data');
            $this->global['meta_description'] = '';
            $this->global['meta_tag']         = '';
            $this->global['author']           = '';
            $this->loadViews('rocky', "frontend/user/logs", $this->global, $data , NULL);
        }else{
            redirect('user/dashboard');
        }
    }

    /**
    ** User Account
    **/
    public function account()
    {
        
        $role = $this->session->userdata ( 'role' );

        // get id from post
        $id = $this->input->post('id');

        if ($role == ROLE_TEACHER) {
            $section = 'teacher';
            $uid = getSingledata('teachers', 'id', 'userid', $id);
            $folder_name = 'teachers';
        }elseif ($role == ROLE_STUDENT) {
            $section = 'student';
            $uid = getSingledata('students', 'id', 'userid', $id);
            $folder_name = 'students';
        }elseif ($role == ROLE_PARENT) {
            $section = 'parent';
            $uid = getSingledata('parents', 'id', 'userid', $id);
            $folder_name = 'parents';
        }else{
            $folder_name = 'users';
            $uid = '';
        }

        if(!empty($id)){
            // Get update account info
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[11]');
            $this->form_validation->set_rules('oldPassword','Old Password');
            $this->form_validation->set_rules('newPassword','New Password');
            $this->form_validation->set_rules('cNewPassword','Confirm Password');

            if($this->form_validation->run() == FALSE){
                $data['user_data'] = $this->user_model->getUser($this->uid);
                $this->global['pageTitle'] = getlang('site_browser_my_account_title', 'data');
                $this->global['meta_description'] = '';
                $this->global['meta_tag']         = '';
                $this->global['author']           = '';
                $this->loadViews('rocky', "frontend/user/account", $this->global, $data , NULL);
            }else{

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
                
                if(!empty($newPassword)){
                    $resultPas = $this->user_model->matchOldPassword($this->uid, $oldPassword);
                    if(empty($resultPas)){
                        $this->session->set_flashdata('error', getlang('system_old_pass_error', 'sys_data'));
                        redirect('user/account');
                    }else{
                        $userInfo = array(
                            'name'=>$name,
                            'mobile'=>$mobile,
                            'avatar'=>$avatar,
                            'password'=>getHashedPassword($newPassword),
                            'createdBy'=>$this->uid, 
                            'createdDtm'=>date('Y-m-d H:i:s')
                        );

                        $panelInfo = array(
                            'name'=>$name,
                            'phone'=>$mobile,
                            'avatar'=>$avatar
                        );
                    }
                }else{
                    $userInfo = array(
                        'name'=>$name,
                        'mobile'=>$mobile,
                        'avatar'=>$avatar,
                        'createdBy'=>$this->uid, 
                        'createdDtm'=>date('Y-m-d H:i:s')
                    );

                    $panelInfo = array(
                        'name'=>$name,
                        'phone'=>$mobile,
                        'avatar'=>$avatar
                    );
                }
                
                $result = $this->user_model->edit($role, $userInfo, $panelInfo, $this->uid, $uid, $section);

                $message_success = getlang('site_data_update_successfully', 'data');
                $message_error = getlang('site_data_update_failed', 'data');
                    
                if($result > 0){
                    $enable_user_udate = getConfigItem('enable_user_udate');
                    if(!empty($enable_user_udate)){
                        $email = getSingledata('users', 'email', 'userId', $id);
                        send_update_confirmation($email, $name);
                    }
                    
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }
                    
            redirect('user/account');
            }

        }else{
            $data['user_data'] = $this->user_model->getUser($this->uid);
            $this->global['pageTitle'] = getlang('site_browser_my_account_title', 'data');
            $this->global['meta_description'] = '';
            $this->global['meta_tag']         = '';
            $this->global['author']           = '';
            $this->loadViews('rocky', "frontend/user/account", $this->global, $data , NULL);
        }
        
    }



    /**
    ** Latest Notice Module
    **/
    function latestnotice(){
        $base_controler = base_url()."user/notice/";
        $data = $this->user_model->getNotice($this->role, '10');

        $output ='';
        
        if(!empty($data)){
            $output .= '<ul class="notice-list">';
            foreach($data as $item)
            {
                if(!empty($item->readNotice)){
                    $user_id = $this->uid;
                    $user_ids = explode(",", $item->readNotice);
                    if (in_array($user_id, $user_ids))
                    {
                        $unread = 0;
                    }else {
                        $unread = 1;
                    }
                }else{
                    $unread = 1;
                }
                
                if(!empty($unread)){
                    $label = 'alert-success';
                }else{
                    $label = 'alert-light';
                }

                $output .= '<li><div class="alert '.$label.'" style="margin-bottom: 5px;" > 
                <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-8">
                                <a href="'.base_url().'user/notice/details/'.$item->id.'"><b>'.$item->title.'</b></a>
                                <p>'.substr($item->noticeText,0,20).'</p> 
                                </div>
                                <div class="col-sm-4 text-right">
                                <p>'.date( 'g:i A Y-m-d ', strtotime($item->createDate)).'</p>
                                </div>
                            </div>
                        </div>

                
                </div></li>';
            }
            $output .= '</ul>';

        }else{
            $output .= '<p style="color: red;">'.getlang('site_empty_list', 'data').'</p>';
        }
        

        echo $output;
    }


    
    
}

?>