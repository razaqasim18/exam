<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/BaseController.php';

class Adminacademicyear extends BaseController
{

    /**
    **  Constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academicyear_model');
        $this->load->database();
        $this->load->library('session');
        $this->isLoggedIn();   
    }

    /**
    ** This function is used to load the  list
    **/

    function yearlist()
    {

        $academicyear_list_title = getlang('browser_tab_academicyear_list_title', 'sys_data');

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{      
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            $this->load->library('pagination');
            $count = $this->academicyear_model->ListingCount($searchText);
            $returns = $this->paginationCompress ( "academicyear/", $count, 20 );
            
            $data['academicyearRecords'] = $this->academicyear_model->Listing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = $academicyear_list_title;
            $this->loadViews("/backend/academic/year/list",  $this->global, $data , NULL);
        }
    }
    
    /**
    ** Add new academic year
    **/
    public function addyear($Id = NULL)
    {

        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $this->load->library('form_validation');
            if(empty($Id)){
                $Id = $this->input->post('id');
               
            }
            
            $this->form_validation->set_rules('year','Year','trim|required|max_length[128]');
            if($this->form_validation->run() == FALSE)
            {

                if(!empty($Id)){
                    $data['year_data'] = $this->academicyear_model->getInfo($Id);
                    $this->global['pageTitle'] = getlang('browser_tab_edit_year', 'sys_data');
                    $this->loadViews("/backend/academic/year/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = getlang('browser_tab_add_new_year', 'sys_data');
                    $this->loadViews("/backend/academic/year/add", $this->global, NULL, NULL);
                }
            }
            else
            {


                $year = ucwords(strtolower($this->security->xss_clean($this->input->post('year'))));

                $year_info = array('year'=> $year);
                
                if(!empty($Id)){
                    $result = $this->academicyear_model->edit($year_info, $Id);
                    $message_success = getlang('system_data_update_successfully', 'sys_data');
                    $message_error = getlang('system_data_update_failed', 'sys_data');
                }else{
                    $result = $this->academicyear_model->addNew($year_info);
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

                redirect(ADMIN_ALIAS.'/academicyear');

            }
        }
        
    }


    /**
     * This function is used to delete the academic year using yearId
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
           redirect(ADMIN_ALIAS.'/academicyear');
        }else{
            $result = $this->academicyear_model->delete($Id);
            if ($result > 0){ 
                $reponse['status'] = true;
            }else{
                $reponse['status'] = false;
            }
        }

        echo json_encode($reponse);
    }
    



   }
?>