<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/BaseController.php';

class Adminfees extends BaseController
{


    /**
    ** This is default constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('fees_model');
        $this->load->database();
        $this->load->library('session');
        $this->isLoggedIn();   
    }
    
    
    /**
    ** Index
    **/
    function index()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{   
            $browser_title          = getlang('browser_tab_fees_manage', 'sys_data');
            $searchText             = $this->security->xss_clean($this->input->post('searchText'));
            $status_value           = $this->security->xss_clean($this->input->post('status_value'));
            $data['searchText']     = $searchText;
            $data['status_value']   = $status_value;
            
            $this->load->library('pagination');
            
            $count = $this->fees_model->ListingCount($searchText, $status_value);

            $per_item = getConfigItem('item_per_list');
            if(empty($per_item)){$per_item = 10;}
            
			$returns = $this->paginationCompress ( ADMIN_ALIAS."/fees/", $count, $per_item, 3 );

            $data['data'] = $this->fees_model->Listing($searchText, $status_value, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = $browser_title;
            $this->loadViews("/backend/fees/list", $this->global, $data, NULL);
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
                    $data['data'] = $this->fees_model->getInfo($id);
                    $this->global['pageTitle'] = getlang('browser_tab_fees_edit', 'sys_data');
                    $this->loadViews("/backend/fees/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = getlang('browser_tab_fees_add', 'sys_data');
                    $this->loadViews("/backend/fees/add", $this->global, NULL, NULL);
                }

            }else{

                $title  = $this->security->xss_clean($this->input->post('title'));
                $fee    = $this->security->xss_clean($this->input->post('fee'));
                $status = $this->input->post('status');
                
                $Info = array(
                    'title'      => $title,
                    'fee'        => $fee, 
                    'status'     => $status
                );
                
                if(!empty($id)){
                    $result          = $this->fees_model->edit($Info, $id);
                    $message_success = getlang('system_data_update_successfully', 'sys_data');
                    $message_error   = getlang('system_data_update_failed', 'sys_data');
                }else{
                    $result          = $this->fees_model->addNew($Info);
                    $message_success = getlang('system_data_create_successfully', 'sys_data');
                    $message_error   = getlang('system_data_create_failed', 'sys_data');
                }
                
                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }
                
                redirect(ADMIN_ALIAS.'/fees');
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
           redirect('fees');
        }else{

            $result = $this->fees_model->active($Id);
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
           redirect('fees');
        }else{

            $result = $this->fees_model->trash($Id);
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
           redirect('fees');
        }else{

            $result = $this->fees_model->delete($Id);
            if ($result > 0){ 
                $reponse['status'] = true;
            }else{
                $reponse['status'] = false;
            }
        }

        echo json_encode($reponse);
    }
    
    
    
}

