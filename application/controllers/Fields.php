<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Classes : Fields (FieldsController)
 * Classes Fields to control all filed related operations.
 * @author : zwebtheme
 * @version : 1.3
 * @since : May 2019
 */
class Fields extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('fields_model');
        $this->load->database();
        $this->load->library('session');
        $this->isLoggedIn();   
    }
    
    
    /**
    ** Add/ Edit Function
    **/
    function add($Id = NULL)
    {
        $update_success = getlang('system_data_update_successfully', 'sys_data');
        $update_failed = getlang('system_data_update_failed','sys_data');
        $create_success = getlang('system_data_create_successfully', 'sys_data');
        $create_failed = getlang('system_data_create_failed', 'sys_data');


        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $this->load->library('form_validation');
            if(empty($Id)){
                $Id = $this->input->post('id');
            }
            
            $this->form_validation->set_rules('field_name','Field Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('field_order','Field Order','trim|required|max_length[128]');
            $this->form_validation->set_rules('option_value','Option Value','trim|max_length[128]');

            //$this->form_validation->set_rules('subject_name','Subject Name','');

            if($this->form_validation->run() == FALSE)
            {
                if(!empty($Id)){
                    $data['field_data'] = $this->fields_model->getInfo($Id);
                    $this->global['pageTitle'] = getlang('browser_tab_edit_field', 'sys_data');
                    $this->loadViews("/backend/fields/add", $this->global, $data, NULL);
                }else{

                    $this->global['pageTitle'] = getlang('browser_tab_add_field', 'sys_data');
                    $this->loadViews("/backend/fields/add", $this->global, NULL, NULL);
                }
            }
            else
            {

                
                $field_name = ucwords(strtolower($this->security->xss_clean($this->input->post('field_name'))));
                $field_type = $this->security->xss_clean($this->input->post('fields_type'));
                $field_section = $this->security->xss_clean($this->input->post('fields_section'));
                $status = $this->security->xss_clean($this->input->post('published'));
                $required_field = ucwords(strtolower($this->security->xss_clean($this->input->post('required_field'))));
                $field_order = $this->security->xss_clean($this->input->post('field_order'));
                $option_value = $this->security->xss_clean($this->input->post('option_value'));
                $display_on_profile = $this->security->xss_clean($this->input->post('display_on_profile'));
                $display_on_list = $this->security->xss_clean($this->input->post('display_on_list'));
                $display_on_biodata = $this->security->xss_clean($this->input->post('display_on_biodata'));
                
                $field_info = 
                array(
                    'field_name'=> $field_name,
                    'type'=> $field_type,
                    'section'=> $field_section,
                    'published'=> $status,
                    'required'=> $required_field,
                    'field_order'=> $field_order,
                    'option_param'=> $option_value,
                    'profile'=> $display_on_profile,
                    'list'=> $display_on_list,
                    'biodata'=> $display_on_biodata
                );

                
                if(!empty($Id)){
                    $result = $this->fields_model->edit($field_info, $Id);
                    $message_success = getlang('system_data_update_successfully', 'sys_data');
                    $message_error = getlang('system_data_update_failed', 'sys_data');
                }else{

                	$result = $this->fields_model->addNew($field_info);
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

                redirect(ADMIN_ALIAS.'/fields');

            }
        }
    }


    /**
    ** This function is used to load the  list
    **/

    function fieldslist()
    {

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{  
                

            $field_list_title = getlang('browser_tab_field_list', 'sys_data');

            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $status_value = $this->security->xss_clean($this->input->post('status_value'));
            $section_value = $this->security->xss_clean($this->input->post('section_value'));
            $data['searchText']     = $searchText;
            $data['status_value'] = $status_value;
            $data['section_value']   = $section_value;

            
            $this->load->library('pagination');


            $count = $this->fields_model->ListingCount($searchText, $status_value, $section_value);

            $returns = $this->paginationCompress ( ADMIN_ALIAS."fields/", $count, 20 );
            
            $data['fieldsRecords'] = $this->fields_model->Listing($searchText, $status_value, $section_value, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = $field_list_title;
            $this->loadViews("/backend/fields/list",  $this->global, $data , NULL);
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
           redirect(ADMIN_ALIAS.'fields');
        }else{
            
            $result = $this->fields_model->delete($Id);
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