<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Classes : Class (ClassesController)
 * Classes Class to control all class related operations.
 * @author : zwebtheme
 * @version : 1.1
 * @since : May 2018
 */
class Admincourseinquiry extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('course_inquiry_model');
        $this->isLoggedIn();  
    }
    
    public function courseInquirylist($page = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {      
            $course_inquiry_title = getlang('browser_course_inquiry_list_title', 'sys_data');
            $searchText     = $this->security->xss_clean($this->input->post('searchText'));
            // $verified_value = $this->security->xss_clean($this->input->post('verified_value'));
            $status_value   = $this->security->xss_clean($this->input->post('status_value'));
            $data['searchText']     = $searchText;
            // $data['verified_value'] = $verified_value;
            $data['status_value']   = $status_value;
            
            $this->load->library('pagination');
            $count = $this->course_inquiry_model->courseListingcount($searchText, $status_value);
            $per_item = getConfigItem('item_per_list');
            if(empty($per_item)){$per_item = 10;}
            
            $returns = $this->paginationCompress ( ADMIN_ALIAS."/course/inquiry/",$count, $per_item, 4 );
            $data['courseRecords'] = $this->course_inquiry_model->courseListing($searchText, $status_value, $returns["page"], $returns["segment"]);
            
            
            $this->global['pageTitle'] = $course_inquiry_title;
            $this->loadViews("backend/course_inquiry/list",  $this->global, $data , NULL);
        }
    }
    
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
           redirect(ADMIN_ALIAS.'/course/inquiry');
        }else{

            // Get delete student
            $result = $this->course_inquiry_model->deleteCourse($Id);

            if ($result > 0){ 
                $reponse['status'] = true;
            }else{ 
                $reponse['status'] = false;
            }
        }

        echo json_encode($reponse);
    }
    
    public function status()
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
           redirect(ADMIN_ALIAS.'/course/inquiry');
        }else{
            $Id = $this->input->post('Id');
            $statusvar = $this->input->post('status');
            
            // Get delete student
            $result = $this->course_inquiry_model->changeStatus($Id,["status" => $statusvar]);

            if ($result > 0){ 
                $reponse['status'] = true;
            } else { 
                $reponse['status'] = false;
            }
        }

        echo json_encode($reponse);
    }

    
}