<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/BaseController.php';

class Adminmethod extends BaseController
{


    /**
    ** This is default constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('method_model');
        $this->load->database();
        $this->load->library('session');
        $this->isLoggedIn();   
    }
    
    
    /**
    ** Index
    **/
    function methodlist()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{   
            $this->load->library('pagination');
            $count = $this->method_model->ListingCount();
            $per_item = getConfigItem('item_per_list');
            if(empty($per_item)){$per_item = 10;}
			$returns = $this->paginationCompress ( ADMIN_ALIAS."/methods/", $count, $per_item, 3 );
            $data['data'] = $this->method_model->Listing($returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = 'Payment Methods';
            $this->loadViews("/backend/method/list", $this->global, $data, NULL);
        }
    }

    
    /**
    ** Method Details
    **/
    function details($id = null)
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{

            if(!empty($id)){
                $data['data'] = $this->method_model->getInfo($id);
                $this->global['pageTitle'] = getlang('browser_tab_payment_configuration_method', 'sys_data');
                $this->loadViews("/backend/method/add", $this->global, $data, NULL);
            }else{
                redirect(ADMIN_ALIAS.'/methods');
            }

        }   
        
    }

    /**
    ** Method Details
    **/
    function save()
    {

        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{

            $id = $this->input->post('id');
            $params = $this->input->post('param');
            $params_data = json_encode($params);
            $status = $this->input->post('status');
            
            $Info = array(
                'data'        => $params_data, 
                'published'   => $status
            );
            
            if(!empty($id)){
                $result          = $this->method_model->edit($Info, $id);
                $message_success = getlang('system_data_update_successfully', 'sys_data');
                $message_error   = getlang('system_data_update_failed', 'sys_data');
            }
            
            if($result > 0){
                $this->session->set_flashdata('success', $message_success);
            }else{
                $this->session->set_flashdata('error', $message_error);
            }
            
            redirect(ADMIN_ALIAS.'/methods');
        }
        
    }

    
    
    
    
}

