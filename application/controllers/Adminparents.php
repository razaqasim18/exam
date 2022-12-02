<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Adminparents extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('parents_model');
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
                if($this->form_validation->run() == FALSE)
                {

                    if(!empty($Id)){
                        $data['parents_data'] = $this->parents_model->getParentInfo($Id);
                        $data['accountInfo'] = $this->parents_model->getAccountInfo($Id);
                        $this->global['pageTitle'] = getlang('browser_tab_parent_edit', 'sys_data');
                        $this->loadViews("/backend/parents/add", $this->global, $data, NULL);
                    }else{
                        $this->global['pageTitle'] = getlang('browser_tab_add_parent', 'sys_data');
                        $this->loadViews("/backend/parents/add", $this->global, NULL, NULL);
                    }
                }
                else
                {
                    
                    $name = $this->security->xss_clean($this->input->post('name'));
                    $email = $this->security->xss_clean($this->input->post('email'));
                    $password = $this->input->post('password');
                    $roleId = $this->input->post('role');
                    $mobile = $this->security->xss_clean($this->input->post('mobile'));
                    $verified = $this->input->post('verified');
                    $active = $this->input->post('active');

                    // Teacher avatar upload
                    $old_avatar = $this->input->post('old_avatar');
                    $new_avatar = $_FILES['avatar']['name'];
                    $avatar = uploadImage($new_avatar, $old_avatar, 'avatar', './uploads/parents/', 'gif|jpg|png', '', '', '');

                    
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
                        $result = $this->parents_model->editParents($account_info, $Id);
                        $message_success = getlang('system_data_update_successfully', 'sys_data');
                        $message_error = getlang('system_data_update_failed', 'sys_data');
                    }else{
                        $result = $this->parents_model->addNewParents($account_info);
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

                    redirect(ADMIN_ALIAS.'/parents');

                }
            }
            
        }

    /**
     * This function is used to load the students list
     */

     function parentslist()
    {
        
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {      

            $parent_list_title = getlang('browser_tab_parent_list_title', 'sys_data');

            $searchText     = $this->security->xss_clean($this->input->post('searchText'));
            $verified_value = $this->security->xss_clean($this->input->post('verified_value'));
            $status_value   = $this->security->xss_clean($this->input->post('status_value'));
            $data['searchText']     = $searchText;
            $data['verified_value'] = $verified_value;
            $data['status_value']   = $status_value;
            
            $this->load->library('pagination');
            $count = $this->parents_model->parentsListingCount($searchText, $verified_value, $status_value);
            
            $per_item = getConfigItem('item_per_list');
            if(empty($per_item)){$per_item = 10;}
            
            $returns = $this->paginationCompress ( ADMIN_ALIAS."/parents/", $count, $per_item, 3 );
            
            $data['parentsRecords'] = $this->parents_model->parentsListing($searchText, $verified_value, $status_value, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = $parent_list_title;
            $this->loadViews("backend/parents/list",  $this->global, $data , NULL);
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
        $no_permission = getlang('no_permission');
        if (empty($Id)) {
            $Id = $this->input->post('Id');

        }

        if($this->isAdmin() == TRUE){
           $this->session->set_flashdata('error', $no_permission );
           redirect(ADMIN_ALIAS.'/parents');
        }else{

            // Delete Avatar
            $exit_avatar = getSingledata('parents', 'photo', 'id', $Id);
            if(!empty($exit_avatar)){
                $old_file = './uploads/parents/'.$exit_avatar;
                unlink($old_file);
            }
            // Delete data from user
            echo $user_id = getSingledata('parents', 'userid', 'id', $id);
            return false;
            $this->parents_model->get_delete_parent_user($user_id);

            // Get custom field delete
            $this->parents_model->get_delete_custom_field_data($Id);
            
            // Get delete student
            $result = $this->parents_model->deleteParent($Id);

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
        $no_permission = getlang('system_no_permission', 'sys_data');
        $somthing_worng = getlang('system_somthing_worng', 'sys_data');

       if($this->isAdmin() == TRUE){
           $this->session->set_flashdata('error', $no_permission );
           redirect(ADMIN_ALIAS.'/parents');
        }else{
            
            if (!empty($id)) {
                $parent_profile = getlang('browser_tab_parent_profile', 'sys_data');
           
                $result['parentInfo'] = $this->parents_model->viewParent($id);
                $this->global['pageTitle'] = $parent_profile;
                $this->loadViews("backend/parents/view",  $this->global, $result , NULL);
                
           }else{
                $this->session->set_flashdata('error', $somthing_worng );
                redirect(ADMIN_ALIAS.'/parents');
            }
        }
    }

    
}

?>