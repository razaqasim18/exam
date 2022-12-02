<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/FrontEndController.php';

class Messages extends FrontEndController
{

    /**
    **  Constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('messages_model');
        $this->load->database();
        $this->load->library('session');
        $this->isLoggedIn();   
    }

    /**
    ** User Profile
    **/
    public function mlist()
    {
        $this->load->library('pagination');
        $count = $this->messages_model->ListingCount($this->uid);

        $per_item = getConfigItem('item_per_list');
        if(empty($per_item)){$per_item = 10;}
        
        $returns = $this->paginationCompress ( "user/messages", $count, $per_item, 3 );

        $data['data'] = $this->messages_model->Listing($this->uid, $returns["page"], $returns["segment"]);

        $this->global['pageTitle'] = getlang('site_browser_message_title', 'data');
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';
        $this->loadViews('rocky', "frontend/messages/list", $this->global, $data , NULL);
    }

    /**
    ** Message Details
    **/
    function details($id)
    {

        $data['data'] = $this->messages_model->getItem($id);
        $this->global['pageTitle'] = getlang('site_browser_message_details_title', 'data');
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';
        $this->loadViews('rocky', "frontend/messages/details", $this->global, $data , NULL);    
        
    }

    /**
    ** Add/ Edit Function
    **/
    function compose()
    {

        $this->global['pageTitle'] = getlang('site_browser_new_message_title', 'data');
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';
        $this->loadViews('rocky', "frontend/messages/compose", $this->global, NULL , NULL);    
        
    }

    /**
    ** Get Teacher Box
    **/
    function teacherbox(){
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );

        $html = '';
        $html .= '<input type="text" id="teacher" class="form-control required" onkeyup="findteacher()" onblur="blure()" name="recever_name" placeholder="'.getlang('site_form_enter_teacher_name', 'data').' " required="required" />';

        $reponse['html'] = $html;
        echo json_encode($reponse);
    }
    
    /**
    ** Get Student Box
    **/
    function studentbox(){
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );

        $html = '';
        $html .= '<input type="text" id="student" class="form-control required" onkeyup="findstudent()" onblur="blure()"  name="recever_name" placeholder="'.getlang('site_form_enter_student_roll_name', 'data').'  " required="required" />';
        $reponse['html'] = $html;
        echo json_encode($reponse);
    }

    /**
    ** Get Parent Box
    **/
    function parentbox(){
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );

        $html = '';
        $html .= '<input type="text" id="parent" class="form-control required" onkeyup="findparent()" onblur="blure()"  name="recever_name"  placeholder="'.getlang('site_form_enter_parent_name', 'data').' " required="required" />';
        $reponse['html'] = $html;
        echo json_encode($reponse);
    }



    /**
    ** Find Teacher
    **/ 
    function findteacher(){
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );

        $html = '';

        $value = $this->input->post('val');
        $teacher_list   = $this->messages_model->getTeacherID($value);
        foreach($teacher_list as $item){
            if(!empty($item->avatar)){
                $img_path = site_url('/uploads/teachers/').$item->avatar;
            }else {
                $img_path = site_url('/uploads/users').'/avator.png';
            }
            
            $onclick = "onclick=\"lookteacher('".$item->name."','".$item->userId."');\"";
            $html .='<div class="row searchresult_ajax" '.$onclick.' style="margin: 5px 0;cursor: pointer;">';
            $html .='<div class="col-sm-2"><img src="'.$img_path.'" alt="" width="30px"height: 30px; style="margin: 3px;" /></div>';
            $html .='<div class="col-sm-10 pl-0" >'.$item->name.'</div>';
            $html .='</div>';
        }

        $reponse['html'] = $html;
        echo json_encode($reponse);
    }
    
    /**
    ** Find Student
    **/
    function findstudent(){
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );

        $html = '';

        $value = $this->input->post('val');
        $student_list = $this->messages_model->getStudentID($value);
        foreach($student_list as $item){
            if(!empty($item->avatar)){
                $img_path = site_url('/uploads/students/').$item->avatar;
            }else {
                $img_path = site_url('/uploads/users').'/avator.png';
            }
                     
            $onclick = "onclick=\"lookstudent('".$item->name."','".$item->userId."');\"";
            $html .='<div class="row searchresult_ajax" '.$onclick.' style="margin: 5px 0;cursor: pointer;">';
            $html .='<div class="col-sm-2"><img src="'.$img_path.'" alt="" width="30px"height: 30px; style="margin: 3px;" /></div>';
            $html .='<div class="col-sm-10 pl-0" >'.$item->name.'</div>';
            $html .='</div>';
        }

        $reponse['html'] = $html;
        echo json_encode($reponse);
    }

    /**
    ** Find Parent
    **/
    function findparent(){
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );

        $html = '';

        $value = $this->input->post('val');
        $parent_list = $this->messages_model->getParentID($value);
        foreach($parent_list as $item){
            if(!empty($item->avatar)){
                $img_path = site_url('/uploads/parents/').$item->avatar;
            }else {
                $img_path = site_url('/uploads/users').'/avator.png';
            }

            $onclick = "onclick=\"lookparent('".$item->name."','".$item->userId."');\"";
            $html .='<div class="row searchresult_ajax" '.$onclick.' style="margin: 5px 0;cursor: pointer;">';
            $html .='<div class="col-sm-2"><img src="'.$img_path.'" alt="" width="30px"height: 30px; style="margin: 3px;" /></div>';
            $html .='<div class="col-sm-10 pl-0" >'.$item->name.'</div>';
            $html .='</div>';
        }

        $reponse['html'] = $html;
        echo json_encode($reponse);
    }

    
    /**
    ** Get Message Send
    **/
    function sendmessage()
    {

        $this->load->library('form_validation');
        
        $recever_id   = $this->input->post('recever_id');
        $sender_id    = $this->input->post('sender_id');
        $message      = $this->input->post('message');
        $subject      = $this->input->post('subject');
        $recever_name = $this->input->post('recever_name');

        if (!empty($recever_id) && !empty($sender_id) && !empty($message) && !empty($subject) && !empty($recever_name)) {
            $data = array(
                'sender_id'    => $sender_id,
                'recever_name' => $recever_name, 
                'recever_id'   => $recever_id,
                'subject'      => $subject,
                'message'      => nl2br($message)
            );
                   
            $result          = $this->messages_model->addNew($data);
            $message_success = getlang('site_message_send_successfully', 'data');
            $message_error   = getlang('site_message_send_failed', 'data');
            if($result > 0){
                $this->session->set_flashdata('success', $message_success);
            }else{
                $this->session->set_flashdata('error', $message_error);
            }

            redirect(base_url().'user/messages');
                
        }
    }

    /**
    ** Get Message reply
    **/
    function reply()
    {

        $this->load->library('form_validation');
        
        $message    = $this->input->post('message');
        $message_id = $this->input->post('message_id');
        $sender_id  = $this->input->post('sender_id');
        $recever_id = $this->input->post('recever_id');

        if (!empty($message) && !empty($message_id) && !empty($sender_id) && !empty($recever_id)) {
            $data = array(
                'message_id'   => $message_id,
                'sender_id'    => $sender_id, 
                'recever_id'   => $recever_id,
                'message'      => nl2br($message)
            );
                   
            $result          = $this->messages_model->getReply($data);
            $message_success = getlang('site_message_send_successfully', 'data');
            $message_error   = getlang('site_message_send_failed', 'data');
            if($result > 0){
                $this->session->set_flashdata('success', $message_success);
            }else{
                $this->session->set_flashdata('error', $message_error);
            }

            redirect(base_url().'user/messages/details/'.$message_id);    
        }
    }
    
}

?>