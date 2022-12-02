<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/BaseController.php';

class Adminuser extends BaseController
{


    /**
    ** This is default constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        // $this->load->helper('language');
        // $this->lang->load('system');
        $this->load->model('user_model');
        $this->load->database();
        $this->load->library('session');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $dashboard_title = getlang('browser_tab_dashboard_page_title', 'sys_data');
        $this->global['pageTitle'] = $dashboard_title;
        $this->loadViews("/backend/dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the user list
     */
    function userlist()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{   
            $browser_title = getlang('browser_tab_user_page_title', 'sys_data');
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $verified_value = $this->security->xss_clean($this->input->post('verified_value'));
            $status_value = $this->security->xss_clean($this->input->post('status_value'));
            $group_value = $this->security->xss_clean($this->input->post('group_value'));
            $data['searchText']     = $searchText;
            $data['verified_value'] = $verified_value;
            $data['status_value']   = $status_value;
            $data['group_value']    = $group_value;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userListingCount($searchText, $verified_value, $status_value, $group_value);

            $per_item = getConfigItem('item_per_list');
            if(empty($per_item)){$per_item = 10;}
            
			$returns = $this->paginationCompress ( ADMIN_ALIAS."/user/", $count, $per_item, 3 );

            $data['userRecords'] = $this->user_model->userListing($searchText, $verified_value, $status_value, $group_value, $returns["page"], $returns["segment"]);

            
            $this->global['pageTitle'] = $browser_title;
            
            $this->loadViews("/backend/user/list", $this->global, $data, NULL);
        }
    }

    

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function add($Id = NULL)
    {


        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            if(empty($Id)){
                $Id = $this->input->post('id');
            }

            if(empty($Id)){
                $this->form_validation->set_rules('password','Password','required|max_length[8]');
                $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[8]');
            }


            $this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[11]');
            
            if($this->form_validation->run() == FALSE)
            {
                $addnew_teacher_title = getlang('browser_tab_teacher_add', 'sys_data');
                $edit_teacher_title = getlang('browser_tab_teacher_edit', 'sys_data');
                
                if(!empty($Id)){
                    $data['roles'] = $this->user_model->getUserRoles();
                    $data['user_data'] = $this->user_model->getUserInfo($Id);
                    $this->global['pageTitle'] = $edit_teacher_title;
                    $this->loadViews("/backend/user/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = $addnew_teacher_title;
                    $data['roles'] = $this->user_model->getUserRoles();
                    $this->loadViews("/backend/user/add", $this->global, $data, NULL);
                }

            }else{

                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('name'))));
                $email = $this->security->xss_clean($this->input->post('email'));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $verified = $this->input->post('verified');
                $active = $this->input->post('active');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));

                // User avatar upload
                $old_avatar = $this->input->post('old_avatar');
                $new_avatar = $_FILES['avatar']['name'];
                $avatar = uploadImage($new_avatar, $old_avatar, 'avatar', './uploads/users/', 'gif|jpg|png', '', '', '');

                
                if(empty($password)){
                    $userInfo = array(
                    'email'       => $email,
                    'roleId'      => $roleId, 
                    'name'        => $name,
                    'avatar'      => $avatar,
                    'mobile'      => $mobile, 
                    'is_verified' => $verified, 
                    'active'      => $active, 
                    'createdBy'   => $this->userid, 
                    'createdDtm'  => date('Y-m-d H:i:s')
                    );
                }else{
                    $userInfo = array(
                    'email'       => $email,
                    'password'    => getHashedPassword($password), 
                    'roleId'      => $roleId, 
                    'name'        => $name,
                    'avatar'      => $avatar,
                    'mobile'      => $mobile, 
                    'is_verified' => $verified, 
                    'active'      => $active, 
                    'createdBy'   => $this->userid, 
                    'createdDtm'  => date('Y-m-d H:i:s')
                    );
                }

                
                if(!empty($Id)){
                    $result = $this->user_model->userEdit($userInfo, $Id);
                    $message_success = getlang('system_data_update_successfully', 'sys_data');
                    $message_error = getlang('system_data_update_failed', 'sys_data');
                }else{
                    $result = $this->user_model->addNew($userInfo);
                    $message_success = getlang('system_data_create_successfully', 'sys_data');
                    $message_error = getlang('system_data_create_failed', 'sys_data');
                }
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', $message_success);
                }
                else
                {
                    $this->session->set_flashdata('error', $message_error);
                }
                
                redirect(ADMIN_ALIAS.'/user');
            }
        }
    }

    /**
     * This function is used to user profile
     */
    function profile($Id = NULL)
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if(!empty($Id)){
                $data['user_data'] = $this->user_model->getUser($Id);
                $this->global['pageTitle'] = getlang('profile', 'sys_data');
                $this->loadViews("/backend/user/profile", $this->global, $data, NULL);
            }
        }
    }

    /**
    ** Active
    **/
    function active($Id = NULL)
    {
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );
        if (empty($Id)) {
            $Id = $this->input->post('Id');

        }

        if($this->isAdmin() == TRUE){
            $no_permission = getlang('system_no_permission', 'sys_data');
           $this->session->set_flashdata('error'.$no_permission);
           redirect('user');
        }else{

            $result = $this->user_model->active($Id);
            if ($result > 0){ 
                $reponse['status'] = true;
            }else{
                $reponse['status'] = false;
            }
        }

        echo json_encode($reponse);
    }

    /**
    ** Trush
    **/
    function trash($Id = NULL)
    {
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );
        if (empty($Id)) {
            $Id = $this->input->post('Id');

        }

        if($this->isAdmin() == TRUE){
            $no_permission = getlang('system_no_permission', 'sys_data');
           $this->session->set_flashdata('error'.$no_permission);
           redirect('user');
        }else{

            $result = $this->user_model->trash($Id);
            if ($result > 0){ 
                $reponse['status'] = true;
            }else{
                $reponse['status'] = false;
            }
        }

        echo json_encode($reponse);
    }

    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function delete($Id = NULL)
    {
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );
        if (empty($Id)) {
            $Id = $this->input->post('Id');

        }

        if($this->isAdmin() == TRUE){
            $no_permission = getlang('system_no_permission', 'sys_data');
           $this->session->set_flashdata('error'.$no_permission);
           redirect('user');
        }else{

            // Delete Avatar
            $exit_avatar = getSingledata('users', 'avatar', 'userId', $Id);
            if(!empty($exit_avatar)){
                $delete_file = realpath(APPPATH .'../uploads/users/'.$exit_avatar);
                unlink($delete_file);
            }

            $result = $this->user_model->delete($Id);
            if ($result > 0){ 
                $reponse['status'] = true;
            }else{
                $reponse['status'] = false;
            }
        }

        echo json_encode($reponse);
    }
    
    /**
     * This function is used to load the change password screen
     */
    function changepassword()
    {
        // get id from post
        $id = $this->input->post('uid');

        if(!empty($id)){
            // Get password update
            $this->load->library('form_validation');
            $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
            $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
            $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
            
            if($this->form_validation->run() == FALSE){
                // Display change password form
                $change_password = getlang('browser_tab_change_password', 'sys_data');
                $this->global['pageTitle'] = $change_password;
                $this->loadViews("/backend/user/changepassword", $this->global, NULL, NULL);
            }else{
                $oldPassword = $this->input->post('oldPassword');
                $newPassword = $this->input->post('newPassword');
                
                $resultPas = $this->user_model->matchOldPassword($this->userid, $oldPassword);
                
                if(empty($resultPas))
                {
                    $this->session->set_flashdata('error', getlang('system_old_pass_error', 'sys_data'));
                    redirect(ADMIN_ALIAS.'/user/changepassword');
                }
                else
                {
                    $usersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>$this->userid,
                                    'updatedDtm'=>date('Y-m-d H:i:s'));
                    
                    $result = $this->user_model->changePassword($this->userid, $usersData);
                    
                    if($result > 0) { $this->session->set_flashdata('success', getlang('system_pass_update_success', 'sys_data')); }
                    else { $this->session->set_flashdata('error', getlang('system_pass_update_failed', 'sys_data')); }
                    
                    redirect(ADMIN_ALIAS.'/user/changepassword');
                }
            }

        }else{
            // Display change password form
            $change_password = getlang('browser_tab_change_password', 'sys_data');
            $this->global['pageTitle'] = $change_password;
            $this->loadViews("/backend/user/changepassword", $this->global, NULL, NULL);
        }
        
    }
     

    /**
    ** Change Avatar (Display form)
    **/
    function changeavatar()
    {
        // get id from post
        $id = $this->input->post('uid');

        if(!empty($id)){
            // get update avatar
            $old_avatar = $this->input->post('old_avatar');
            $new_avatar = $_FILES['avatar']['name'];
            $avatar = uploadImage($new_avatar, $old_avatar, 'avatar', './uploads/users/', 'gif|jpg|png', '', '', '');
            
            // Set user info 
            $userInfo = array('avatar'=>$avatar);
            $result = $this->user_model->userEdit($userInfo, $this->userid);
            if($result == true) {
                $this->session->set_flashdata('success', getlang('system_data_update_successfully', 'sys_data'));
            }else{
                $this->session->set_flashdata('error', getlang('system_data_update_failed', 'sys_data'));
            }     
            redirect(ADMIN_ALIAS.'/user/changeavatar');
           
        }else{
            // display avatar form
            $browser_title = getlang('browser_tab_user_page_title', 'sys_data');
            $data['userInfo'] = $this->user_model->getadmininfo($this->userid);
            $this->global['pageTitle'] = $browser_title;
            $this->loadViews("/backend/user/changeavatar", $this->global, $data, NULL);
        }

        
    }



    /**
    ** Online Admin user list
    **/
    function onlineadmin(){

        $session_list = getSessionList('2'); 
        $total_user = count($session_list);

         $output ='<p>'.getlang('recently', 'sys_data').' <b>'.$total_user.'</b> '.getlang('user_loged_in', 'sys_data').'</p>';

        $output .='<div class="box-body">';
        $output .='<ul class="products-list product-list-in-box">';

            if(!empty($total_user)){
                foreach ($session_list as $key => $online_user) {
                    $uid     = $online_user->user;

                    $name = getSingledata('users', 'name', 'userId', $uid);
                    $email = getSingledata('users', 'email', 'userId', $uid);
                    $avatar = getSingledata('users', 'avatar', 'userId', $uid);

                    if(empty($avatar)){
                        $online_avatar_img = site_url('/uploads/users/').'/avator.png';
                    }else{
                        $online_avatar_img = site_url('/uploads/users/').'/'.$avatar;
                    }

                $output .='<li class="item">
                        <div class="product-img">
                        <img src="'.$online_avatar_img.'" alt="'.$name.'" class="avatar img-circle" />
                        </div>
                        <div class="product-info">
                        <span class="product-title"> '.$name.' <span class="label label-success pull-right">Online</span><span>
                        <span class="product-description">'.$email.'</span>
                        </div>
                        </li>
                    ';

                }
            }

        $output .='</ul>';
        $output .='</div>';

        echo $output;
    }

    /**
    ** Online user list
    **/
    function onlineuser(){

        $session_list = getSessionList('3'); 
        $total_user = count($session_list);

        $output ='<p>'.getlang('recently', 'sys_data').' <b>'.$total_user.'</b> '.getlang('user_loged_in', 'sys_data').'</p>';

        $output .='<div class="box-body">';
        $output .='<ul class="products-list product-list-in-box">';

            if(!empty($total_user)){
                foreach ($session_list as $key => $online_user) {
                    $uid     = $online_user->user;

                    $name = getSingledata('users', 'name', 'userId', $uid);
                    $email = getSingledata('users', 'email', 'userId', $uid);
                    $avatar = getSingledata('users', 'avatar', 'userId', $uid);

                    if(empty($avatar)){
                        $online_avatar_img = site_url('/uploads/users/').'/avator.png';
                    }else{
                        $online_avatar_img = site_url('/uploads/users/').'/'.$avatar;
                    }

                $output .='<li class="item">
                        <div class="product-img">
                        <img src="'.$online_avatar_img.'" alt="'.$name.'" class="avatar img-circle" />
                        </div>
                        <div class="product-info">
                        <span class="product-title"> '.$name.' <span class="label label-success pull-right">'.getlang('online', 'sys_data').'</span><span>
                        <span class="product-description">'.$email.'</span>
                        </div>
                        </li>
                    ';

                }
            }

        $output .='</ul>';
        $output .='</div>';

        echo $output;
    }

    
    

    
}

?>