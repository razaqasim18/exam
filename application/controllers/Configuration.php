<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/BaseController.php';

class Configuration extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('configuration_model');
        $this->load->database();
        $this->load->library('session');
        $this->isLoggedIn();   
    }
    
    
    /**
    ** Edit Function
    **/
    function edit()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{

            $Id = 1;
            $params = $this->input->post('param');
            
            // get config file array from helper function
            $config_file = getConfigData('file');
            foreach ($config_file as $key => $config_file_item) {
                $config_field     = $config_file_item[0];
                $config_old_field = $config_file_item[1];
                $config_label     = $config_file_item[2];
                $config_path      = $config_file_item[3];
                $config_default   = $config_file_item[4];

                // Get upload and set param
                $old_file = $this->input->post($config_old_field);
                $new_file = $_FILES[$config_field]['name'];
                $uploaded_file = uploadImage($new_file, $old_file, $config_field, './uploads/logo/', 'gif|jpg|png', '', '', '');
                $params[$config_field][] = $uploaded_file;
            }

            
            $params_data = json_encode($params);

            $data = array(
                'param_data'=> $params_data
            );
                
            if(!empty($Id)){
                $result = $this->configuration_model->edit($data, $Id);
                $message_success = getlang('system_data_update_successfully', 'sys_data');
                $message_error = getlang('system_data_update_failed', 'sys_data');
            }
            
            if($result > 0){
                $this->session->set_flashdata('success', $message_success);
            }else{
                $this->session->set_flashdata('error', $message_error);
            }

            redirect(ADMIN_ALIAS.'/configuration');

        }
    }


    /**
    ** This function is used to load the  list
    **/

    function index()
    {
    	$Id = 1;
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{    

        $configuratoin_title = getlang('browser_tab_configuration_page_title', 'sys_data');
            
            if(!empty($Id)){
                $data['con_data'] = $this->configuration_model->getInfo($Id);
            }else{
                $data['con_data'] = '';    
            }
            
            $this->global['pageTitle'] = $configuratoin_title;
            $this->loadViews("/backend/configuration/default",  $this->global, $data , NULL);
        }
    }


    

    /**
    ** Page not found : error 404
    **/
    function pageNotFound()
    {
        $this->global['pageTitle'] = getlang('404_page_not_found', 'sys_data');
        $this->loadViews("/backend/404", $this->global, NULL, NULL);
    }

    
}

?>