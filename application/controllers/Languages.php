<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/BaseController.php';

class Languages extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('languages_model');
        $this->load->database();
        $this->load->library('session');
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
            
            $this->form_validation->set_rules('title','Title','trim|required|max_length[128]');
            if($this->form_validation->run() == FALSE)
            {

                if(!empty($Id)){
                    $data['language_data'] = $this->languages_model->getInfo($Id);
                    $this->global['pageTitle'] = 'Edit Language';
                    $this->loadViews("/backend/languages/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = 'Add New Lanuage';
                    $this->loadViews("/backend/languages/add", $this->global, NULL, NULL);
                }
            }
            else
            {


                $title = $this->input->post('title');
                $title_native = $this->input->post('title_native');
                $lang_code = $this->input->post('lang_code');
                $image = $this->input->post('image');
                $published = $this->input->post('published');
                $direction = $this->input->post('direction');
                $lang_data = $this->input->post('lang_data');

                $params = $this->input->post('params');
                $params_data = json_encode($params);

                $sys_param = $this->input->post('sys_param');
                $sys_param_data = json_encode($sys_param);

                $data = array(
                    'title'=> $title,
                    'title_native'=> $title_native,
                    'lang_code'=> $lang_code,
                    'image'=> $image,
                    'published'=> $published,
                    'data'=> $params_data,
                    'sys_data'=> $sys_param_data,
                    'direction'=> $direction,
                    'lang_data'=> $lang_data
                    );
                
                if(!empty($Id)){
                    $result = $this->languages_model->edit($data, $Id);
                    $message_success = 'Language update successfully.';
                    $message_error = 'Language update failed ?';
                }else{
                	$result = $this->languages_model->addNew($data);
                	$message_success = 'Language create successfully.';
                	$message_error = 'Language create failed ?';
                }
                
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', $message_success);
                }
                else
                {
                    $this->session->set_flashdata('error', $message_error);
                }

                redirect(ADMIN_ALIAS.'/languages');

            }
        }
    }


    /**
    ** This function is used to load the  list
    **/

    function languagelist()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{      
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            $this->load->library('pagination');
            $count = $this->languages_model->ListingCount($searchText);

            $per_item = getConfigItem('item_per_list');
            if(empty($per_item)){$per_item = 10;}
            $returns = $this->paginationCompress ( ADMIN_ALIAS."/languages/", $count, $per_item, 3 );
            
            $data['languageRecords'] = $this->languages_model->Listing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Language List';
            $this->loadViews("/backend/languages/list",  $this->global, $data , NULL);
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
           $this->session->set_flashdata('error', 'You have no permission !');
           redirect(ADMIN_ALIAS.'/languages');
        }else{
            
            $result = $this->languages_model->delete($Id);
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