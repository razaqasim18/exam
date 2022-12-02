<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/BaseController.php';

class Adminnotice extends BaseController
{


    /**
    ** This is default constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('notice_model');
        $this->load->database();
        $this->load->library('session');
        $this->isLoggedIn();   
    }
    
    
    /**
    ** Notice list
    **/
    function nlist()
    {


        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{   
            $browser_title = getlang('browser_tab_notice_page_title', 'sys_data');
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $status_value = $this->security->xss_clean($this->input->post('status_value'));
            $group_value = $this->security->xss_clean($this->input->post('group_value'));
            $data['searchText']     = $searchText;
            $data['status_value']   = $status_value;
            $data['group_value']    = $group_value;
            
            $this->load->library('pagination');
            
            $count = $this->notice_model->noticeListingCount($searchText, $status_value, $group_value);

            $per_item = getConfigItem('item_per_list');
            if(empty($per_item)){$per_item = 10;}
            
			$returns = $this->paginationCompress ( ADMIN_ALIAS."/notice/", $count, $per_item, 3 );

            $data['data'] = $this->notice_model->noticeListing($searchText, $status_value, $group_value, $returns["page"], $returns["segment"]);


            $this->global['pageTitle'] = $browser_title;
            
            $this->loadViews("/backend/notice/list", $this->global, $data, NULL);
        }
    }

    
    /**
    ** Create Notice
    **/
    function add($id = null)
    {

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if(empty($id)){
                $id = $this->input->post('id');
            }
            

            $this->load->library('form_validation');
            $this->form_validation->set_rules('title','Notice Title','trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                
                if(!empty($id)){
                    $data['roles'] = $this->notice_model->getGroup();
                    $data['data'] = $this->notice_model->getNoticeInfo($id);
                    $this->global['pageTitle'] = getlang('browser_tab_notice_edit', 'sys_data');
                    $this->loadViews("/backend/notice/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = getlang('browser_tab_notice_new', 'sys_data');
                    $data['roles'] = $this->notice_model->getGroup();
                    $this->loadViews("/backend/notice/add", $this->global, $data, NULL);
                }

            }else{

                $title = $this->security->xss_clean($this->input->post('title'));
                $noticeText = $this->security->xss_clean($this->input->post('noticeText'));
                $groupId = $this->input->post('groupId');
                $status = $this->input->post('status');
                
                $Info = array(
                    'title'      => $title,
                    'noticeText' => $noticeText, 
                    'groupId'    => $groupId, 
                    'status'     => $status,
                    'createdBy'  => $this->userid, 
                    'updateDate' => date('Y-m-d H:i:s')
                );
                
                if(!empty($id)){
                    $result = $this->notice_model->edit($Info, $id);
                    $message_success = getlang('system_data_update_successfully', 'sys_data');
                    $message_error = getlang('system_data_update_failed', 'sys_data');
                }else{
                    $result = $this->notice_model->addNew($Info);
                    $message_success = getlang('system_data_create_successfully', 'sys_data');
                    $message_error = getlang('system_data_create_failed', 'sys_data');
                }
                
                if($result > 0){

                    // get user list by group
                    $user_list = $this->notice_model->userListing($groupId);
                    $email_list = array();
                    foreach ($user_list as $key => $item) {
                       $email_list[] = $item->email;
                    }
                    $emails = implode(',', $email_list);
                    
                    $enable_notice_notify = getConfigItem('enable_notice_notify');
                    if(!empty($enable_notice_notify)){
                        $notice = send_notice_confirmation($emails, $title, $noticeText);
                        if($notice){
                            $this->session->set_flashdata('success', $message_success);
                        }else{
                            $this->session->set_flashdata('notsend', 'Email has been failed');
                        }
                    }else{
                        $this->session->set_flashdata('success', $message_success);
                    }

                    
                    
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }
                
                redirect(ADMIN_ALIAS.'/notice');
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
           redirect('notice');
        }else{

            $result = $this->notice_model->active($Id);
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
           redirect('notice');
        }else{

            $result = $this->notice_model->trash($Id);
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
           redirect('notice');
        }else{

            $result = $this->notice_model->delete($Id);
            if ($result > 0){ 
                $reponse['status'] = true;
            }else{
                $reponse['status'] = false;
            }
        }

        echo json_encode($reponse);
    }
    
    
    
}

