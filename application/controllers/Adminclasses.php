<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Classes : Class (ClassesController)
 * Classes Class to control all class related operations.
 * @author : zwebtheme
 * @version : 1.1
 * @since : May 2018
 */
class Adminclasses extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('class_model');
        $this->isLoggedIn();  
    }
    
    
    /**
    ** Add/ Edit Function
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
            

           
            $this->form_validation->set_rules('name','Class Name','trim|required|max_length[128]');

            //$this->form_validation->set_rules('subject_name','Subject Name','');

            if($this->form_validation->run() == FALSE)
            {
                if(!empty($Id)){
                    $data['class_data'] = $this->class_model->getInfo($Id);
                    $this->global['pageTitle'] = getlang('browser_tab_edit_class_title', 'sys_data');
                    $this->loadViews("backend/academic/class/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = getlang('browser_tab_addnew_class_title', 'sys_data');
                    $this->loadViews("backend/academic/class/add", $this->global, NULL, NULL);
                }
            }
            else
            {

                
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('name'))));
                $subject_name = $this->input->post('subject_name');
                $subject_name = implode(",",$subject_name);

                $department_name = $this->input->post('departments_name');
                $department_name = implode(",",$department_name);

                $class_info = array('name'=> $name,'subjects'=> $subject_name, 'departments'=> $department_name);

                
                if(!empty($Id)){
                    $result = $this->class_model->edit($class_info, $Id);
                    $message_success = getlang('system_data_update_successfully', 'sys_data');
                    $message_error = getlang('system_data_update_failed', 'sys_data');
                }else{

                	$result = $this->class_model->addNew($class_info);
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

                redirect(ADMIN_ALIAS.'/class');

            }
        }
    }


    /**
    ** This function is used to load the  list
    **/

    function classlist()
    {

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{  
    
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            $this->load->library('pagination');
            $count = $this->class_model->ListingCount($searchText);
            $returns = $this->paginationCompress ( "classes/", $count, 20 );
            
            $data['classRecords'] = $this->class_model->Listing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = getlang('browser_tab_class_list_title', 'sys_data');
            $this->loadViews("/backend/academic/class/list",  $this->global, $data , NULL);
        }
    }


    

    /**
    * This function is used to delete the using id
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
           $this->session->set_flashdata('error', $no_permission );
           redirect(ADMIN_ALIAS.'/class');
        }else{
            
            $result = $this->class_model->delete($Id);
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