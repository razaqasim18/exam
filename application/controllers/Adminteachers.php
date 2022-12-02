<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : zwebtheme
 * @version : 1.1
 * @since : May 2018
 */
class Adminteachers extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('teachers_model');
        $this->load->library('session');
        $this->isLoggedIn();   
    }
    


    /**
    ** Add or Edit your Teachers by this function
    **/
    function add($Id = NULL)
        {

            if($this->isAdmin() == TRUE){
                $this->loadThis();
            }else{
                $this->load->library('form_validation');
                if(empty($Id)){
                    $Id = $this->input->post('id');
                   
                }
                
                $this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]');
                $this->form_validation->set_rules('designation','Designation','trim|required|max_length[128]');
                if($this->form_validation->run() == FALSE)
                {

                    if(!empty($Id)){
                        $data['teachers_data'] = $this->teachers_model->getTeachersInfo($Id);
                        $data['accountInfo'] = $this->teachers_model->getAccountInfo($Id);
                        $this->global['pageTitle'] = getlang('browser_tab_teacher_edit', 'sys_data');
                        $this->loadViews("/backend/teachers/add", $this->global, $data, NULL);
                    }else{
                        $this->global['pageTitle'] = getlang('browser_tab_teacher_add', 'sys_data');
                        $this->loadViews("/backend/teachers/add", $this->global, NULL, NULL);
                    }
                }
                else
                {


                    $name = $this->security->xss_clean($this->input->post('name'));
                    $class = $this->input->post('class_name');
                    $department = $this->input->post('departments_name');
                    $designation = $this->input->post('designation');
                    $subject_name = $this->input->post('subject_name');

                    $email = $this->security->xss_clean($this->input->post('email'));
                    $password = $this->input->post('password');
                    $roleId = $this->input->post('role');
                    $mobile = $this->security->xss_clean($this->input->post('mobile'));
                    $verified = $this->input->post('verified');
                    $active = $this->input->post('active');

                    // Teacher avatar upload
                    $old_avatar = $this->input->post('old_avatar');
                    $new_avatar = $_FILES['avatar']['name'];
                    $avatar = uploadImage($new_avatar, $old_avatar, 'avatar', './uploads/teachers/', 'gif|jpg|png', '', '', '');
                    $department = implode(",",$department);
                    $subject_name = implode(",",$subject_name);
                    $class = implode(",",$class);


                    $teachersInfo = array(
                        'designation' => $designation,
                        'class'       => $class,
                        'department'  => $department, 
                        'subject'     => $subject_name 
                    );

                    if(empty($password)){
                        $account_info = array(
                            'email'       => $email,
                            'roleId'      => $roleId, 
                            'name'        => $name,
                            'avatar'      => $avatar,
                            'mobile'      => $mobile, 
                            'active'      => $active,
                            'is_verified' => $verified,  
                            'createdBy'   => $this->userid, 
                            'createdDtm'  => date('Y-m-d H:i:s')
                    );
                    }else{
                        $account_info = array(
                            'email'       => $email,
                            'password'    => getHashedPassword($password), 
                            'roleId'      => $roleId, 
                            'name'        => $name,
                            'avatar'      => $avatar,
                            'mobile'      => $mobile, 
                            'active'      => $active, 
                            'is_verified' => $verified,  
                            'createdBy'   => $this->userid, 
                            'createdDtm'  => date('Y-m-d H:i:s')
                        );
                    }
                    
                    if(!empty($Id)){
                        $result = $this->teachers_model->editTeacher($account_info, $teachersInfo, $Id);
                        $message_success = getlang('system_data_update_successfully', 'sys_data');
                        $message_error = getlang('system_data_update_failed', 'sys_data');
                    }else{
                        $result = $this->teachers_model->addNewTeacher($account_info, $teachersInfo);
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

                    redirect(ADMIN_ALIAS.'/teachers');

                }
            }
            
        }

    /**
     * This function is used to load the students list
     */

    function teacherslist()
    {
        
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {      

            $teachers_list_title = getlang('browser_tab_teachers_list_title', 'sys_data');

            $searchText     = $this->security->xss_clean($this->input->post('searchText'));
            $verified_value = $this->security->xss_clean($this->input->post('verified_value'));
            $status_value   = $this->security->xss_clean($this->input->post('status_value'));
            $data['searchText']     = $searchText;
            $data['verified_value'] = $verified_value;
            $data['status_value']   = $status_value;
            
            $this->load->library('pagination');
            
            $count = $this->teachers_model->teachersListingCount($searchText, $verified_value, $status_value);

            $per_item = getConfigItem('item_per_list');
            if(empty($per_item)){$per_item = 10;}
            
            $returns = $this->paginationCompress ( ADMIN_ALIAS."/teachers/", $count, $per_item, 3 );
            
            $data['teachersRecords'] = $this->teachers_model->teachersListing($searchText, $verified_value, $status_value, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = $teachers_list_title;
            $this->loadViews("backend/teachers/list",  $this->global, $data , NULL);
        }
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
        $no_permission = getlang('system_no_permission', 'sys_data');
        if (empty($Id)) {
            $Id = $this->input->post('Id');

        }

        if($this->isAdmin() == TRUE){
           $this->session->set_flashdata('error', $no_permission );
           redirect(ADMIN_ALIAS.'teachers');
        }else{

            // Delete Avatar
            $exit_avatar = getSingledata('users', 'avatar', 'userId', $Id);
            if(!empty($exit_avatar)){
                $old_file = './uploads/teachers/'.$exit_avatar;
                unlink($old_file);
            }

            // Get custom field delete
            $this->teachers_model->get_delete_custom_field_data($Id);
            
            // Get delete student
            $result = $this->teachers_model->deleteTeacher($Id);

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
    function view($id = NULL)
    {
        $no_permission = getlang('system_no_permission');
        $somthing_worng = getlang('somthing_worng');

       if($this->isAdmin() == TRUE){
           $this->session->set_flashdata('error', $no_permission );
           redirect(ADMIN_ALIAS.'/teachers');
        }else{
            
            if (!empty($id)) {
                $teacher_profile = getlang('browser_tab_teacher_profile', 'sys_data');
           
                $result['teacherInfo'] = $this->teachers_model->viewTeacher($id);
                $this->global['pageTitle'] = $teacher_profile;
                $this->loadViews("backend/teachers/view",  $this->global, $result , NULL);
                
           }else{
                $this->session->set_flashdata('error', $somthing_worng );
                redirect(ADMIN_ALIAS.'/teachers');
            }
        }
    }

    
}

?>