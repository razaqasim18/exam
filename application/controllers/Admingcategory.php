<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/BaseController.php';

class Admingcategory extends BaseController
{


    /**
    ** This is default constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('gcategory_model');
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
            $browser_title          = getlang('browser_tab_gcategory_manage', 'sys_data');
            $searchText             = $this->security->xss_clean($this->input->post('searchText'));
            $status_value           = $this->security->xss_clean($this->input->post('status_value'));
            $data['searchText']     = $searchText;
            $data['status_value']   = $status_value;
            
            $this->load->library('pagination');
            
            $count = $this->gcategory_model->ListingCount($searchText, $status_value);

            $per_item = getConfigItem('item_per_list');
            if(empty($per_item)){$per_item = 10;}
            
			$returns = $this->paginationCompress ( ADMIN_ALIAS."/gcategory/", $count, $per_item, 3 );

            $data['data'] = $this->gcategory_model->Listing($searchText, $status_value, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = $browser_title;
            $this->loadViews("/backend/academic/gcategory/list", $this->global, $data, NULL);
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
            $this->form_validation->set_rules('gcategory','Grade Category Name','trim|required');
            $this->form_validation->set_rules('gcatmark','Grade Category Mark','trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                
                if(!empty($id)){
                    $data['data'] = $this->gcategory_model->getInfo($id);
                    $this->global['pageTitle'] = getlang('browser_tab_gcategory_edit', 'sys_data');
                    $this->loadViews("/backend/academic/gcategory/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = getlang('browser_tab_gcategory_new', 'sys_data');
                    $this->loadViews("/backend/academic/gcategory/add", $this->global, NULL, NULL);
                }

            }else{

                $gcategory_name  = $this->security->xss_clean($this->input->post('gcategory'));
                $gcatmark    = $this->security->xss_clean($this->input->post('gcatmark'));
                $status = $this->input->post('status');
                
                $Info = array(
                    'name'      => $gcategory_name,
                    'mark'        => $gcatmark, 
                    'status'     => $status
                );
                
                if(!empty($id)){
                    $result          = $this->gcategory_model->edit($Info, $id);
                    $message_success = getlang('system_data_update_successfully', 'sys_data');
                    $message_error   = getlang('system_data_update_failed', 'sys_data');
                }else{
                    $result          = $this->gcategory_model->addNew($Info);
                    $message_success = getlang('system_data_create_successfully', 'sys_data');
                    $message_error   = getlang('system_data_create_failed', 'sys_data');
                }
                
                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }
                
                redirect(ADMIN_ALIAS.'/gcategory');
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

            $result = $this->gcategory_model->delete($Id);
            if ($result > 0){ 
                $reponse['status'] = true;
            }else{
                $reponse['status'] = false;
            }
        }

        echo json_encode($reponse);
    }
    
    
    
}

