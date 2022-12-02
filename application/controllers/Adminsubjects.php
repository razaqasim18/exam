<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/BaseController.php';

class Adminsubjects extends BaseController
{

    /**
    **  Constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('subjects_model');
        $this->load->database();
        $this->load->library('session');
        $this->isLoggedIn();   
    }

    /**
    ** This function is used to load the  list
    **/

    function subjectslist()
    {

        $subjects_list_title = getlang('browser_tab_subjects_list_title', 'sys_data');

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{      
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            $this->load->library('pagination');
            $count = $this->subjects_model->ListingCount($searchText);
            $returns = $this->paginationCompress ( "subjects/", $count, 20 );
            
            $data['subjectsRecords'] = $this->subjects_model->Listing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = $subjects_list_title;
            $this->loadViews("/backend/academic/subject/list",  $this->global, $data , NULL);
        }
    }
    
    /**
    ** Add new academic year
    **/
    public function add($Id = NULL)
    {

        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $this->load->library('form_validation');
            if(empty($Id)){
                $Id = $this->input->post('id');
               
            }
            
            $this->form_validation->set_rules('name','Subject name','trim|required|max_length[128]');
            if($this->form_validation->run() == FALSE)
            {

                if(!empty($Id)){
                    $data['subject_data'] = $this->subjects_model->getInfo($Id);
                    $this->global['pageTitle'] = getlang('browser_tab_edit_subject', 'sys_data');
                    $this->loadViews("/backend/academic/subject/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = getlang('browser_tab_add_new_subject', 'sys_data');
                    $this->loadViews("/backend/academic/subject/add", $this->global, NULL, NULL);
                }
            }
            else
            {


                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('name'))));
                $code = ucwords(strtolower($this->security->xss_clean($this->input->post('code'))));
                $type = ucwords(strtolower($this->security->xss_clean($this->input->post('type'))));

                $subject_info = ['name'=> $name, 'code'=> $code, 'type'=> $type];
            
                
                if(!empty($Id)){
                    $result = $this->subjects_model->edit($subject_info, $Id);
                    $message_success = getlang('system_data_update_successfully', 'sys_data');
                    $message_error = getlang('system_data_update_failed', 'sys_data');
                }else{
                    $result = $this->subjects_model->addNew($subject_info);
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

                redirect(ADMIN_ALIAS.'/subjects');

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
           redirect(ADMIN_ALIAS.'/subjects');
        }else{
            $result = $this->subjects_model->delete($Id);
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