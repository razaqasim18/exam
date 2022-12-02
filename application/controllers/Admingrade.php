<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/BaseController.php';

class Admingrade extends BaseController
{


    /**
    ** This is default constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('grade_model');
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
            $browser_title          = getlang('browser_tab_grade_manage', 'sys_data');
            $searchText             = $this->security->xss_clean($this->input->post('searchText'));
            $status_value           = $this->security->xss_clean($this->input->post('status_value'));
            $data['searchText']     = $searchText;
            $data['status_value']   = $status_value;
            
            $this->load->library('pagination');
            
            $count = $this->grade_model->ListingCount($searchText, $status_value);

            $per_item = getConfigItem('item_per_list');
            if(empty($per_item)){$per_item = 10;}
            
			$returns = $this->paginationCompress ( ADMIN_ALIAS."/grade/", $count, $per_item, 3 );

            $data['data'] = $this->grade_model->Listing($searchText, $status_value, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = $browser_title;
            $this->loadViews("/backend/academic/grade/list", $this->global, $data, NULL);
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
            $this->form_validation->set_rules('gname','Grade Name','trim|required');
            $this->form_validation->set_rules('gradepoint','Grade Point','trim|required');
            $this->form_validation->set_rules('gradefrom','Grade From','trim|required');
            $this->form_validation->set_rules('gradeupto','Grade Upto','trim|required');
            $this->form_validation->set_rules('comment','Comment','trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                
                if(!empty($id)){
                    $data['data'] = $this->grade_model->getInfo($id);
                    $this->global['pageTitle'] = getlang('browser_tab_grade_edit', 'sys_data');
                    $this->loadViews("/backend/academic/grade/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = getlang('browser_tab_grade_new', 'sys_data');
                    $this->loadViews("/backend/academic/grade/add", $this->global, NULL, NULL);
                }

            }else{

                $gcatname    = $this->input->post('gcatname');
                $gname    = $this->security->xss_clean($this->input->post('gname'));
                $gradepoint    = $this->security->xss_clean($this->input->post('gradepoint'));
                $mark_from    = $this->security->xss_clean($this->input->post('gradefrom'));
                $mark_upto    = $this->security->xss_clean($this->input->post('gradeupto'));
                $comment    = $this->security->xss_clean($this->input->post('comment'));
                $status = $this->input->post('status');
                
                $Info = array(
                    'name'          => $gname,
                    'category'      => $gcatname,
                    'grade_point'   => $gradepoint, 
                    'mark_from'     => $mark_from, 
                    'mark_upto'     => $mark_upto,
                    'comment'       => $comment,
                    'status'        => $status
                );
                
                if(!empty($id)){
                    $result          = $this->grade_model->edit($Info, $id);
                    $message_success = getlang('system_data_update_successfully', 'sys_data');
                    $message_error   = getlang('system_data_update_failed', 'sys_data');
                }else{
                    $result          = $this->grade_model->addNew($Info);
                    $message_success = getlang('system_data_create_successfully', 'sys_data');
                    $message_error   = getlang('system_data_create_failed', 'sys_data');
                }
                
                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }
                
                redirect(ADMIN_ALIAS.'/grade');
            }
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
        if (empty($Id)) {
            $Id = $this->input->post('Id');

        }

        if($this->isAdmin() == TRUE){
            $no_permission = getlang('system_no_permission', 'sys_data');
           $this->session->set_flashdata('error'.$no_permission);
           redirect('fees');
        }else{

            $result = $this->grade_model->delete($Id);
            if ($result > 0){ 
                $reponse['status'] = true;
            }else{
                $reponse['status'] = false;
            }
        }

        echo json_encode($reponse);
    }
    
    
    
}

