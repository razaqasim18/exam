<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/FrontEndController.php';

class Results extends FrontEndController
{

    /**
    **  Constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('results_model');
        $this->load->database();
        $this->load->library('session');
        $this->isLoggedIn();   
    }

    /**
    ** User Profile
    **/
    public function resultlist()
    {	
    	$role = $this->session->userdata ( 'role' );
    	//echo $role; 
        $this->global['pageTitle'] = getlang('site_browser_result_title', 'data');
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';

        if ($role == ROLE_TEACHER) {
            $this->loadViews('rocky', "frontend/result/teacher_default", $this->global, NULL , NULL);
        }elseif ($role == ROLE_STUDENT) {
            $this->loadViews('rocky', "frontend/result/student_default", $this->global, NULL , NULL);
        }elseif ($role == ROLE_PARENT) {
            $this->loadViews('rocky', "frontend/result/parent_default", $this->global, NULL , NULL);
        }else{
            $this->loadViews('rocky', "frontend/result/default", $this->global, NULL , NULL);
        }

        
    }

    public function showresult(){
    	$reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );
        $role = $this->session->userdata ( 'role' );
        $uid = $this->uid;

        $html = '';

        if ($role == ROLE_TEACHER) {

            $exam_id  = $this->input->post('exam_id');
            $class_id = $this->input->post('class_id');
            $roll_id  = $this->input->post('roll_id');
            
            if (!empty($exam_id) && !empty($class_id) && !empty($roll_id)) {
                $return_value = ShowResults($exam_id,$class_id, $roll_id);
                $html .= $return_value['html'];
                $check = $return_value['check'];
                $comment = GetComment($exam_id,$class_id, $roll_id);
                // Result Comment
                $comment_form = '';
                $comment_form .='<div id="result_comment">';
                $comment_form .='<h4>'.getlang('site_teacher_comment', 'data'). ':'.'</h4>';
                $comment_form .='<div id="comment_saving"></div>';
                if (!empty($comment)) {
                    $comment_form .='<textarea cols="3" rows="3" id="comment" style="width: 100%;height: auto;">'.$comment.'</textarea>';
                }else{
                    $comment_form .='<textarea cols="" rows="" id="comment" style="width: 100%;height: auto;"></textarea>';
                }
                
                $comment_form .='<input type="hidden" name="class_id" id="class_id" value="'.$class_id.'" />';
                $comment_form .='<input type="hidden" name="roll_number" id="roll_id" value="'.$roll_id.'" />';
                $comment_form .='<input type="hidden" name="exam_id" id="eid" value="'.$exam_id.'" />';
                $comment_form .='<input type="hidden" name="teacher_id" id="tid" value="'.$uid.'" />';
                $comment_form .= '<input type="hidden" id="csrf" name="'.$reponse['csrfName'].'" value="'.$reponse['csrfHash'].'" />';
                $comment_form .='<button id="comment_save" class="btn btn-default" style="margin-top:10px;">'.getlang('site_save', 'data').'</button>';
                $comment_form .= '</div>';
                //$loader_html = '<div class=\"loader\"></div>';
                $comment_form .='<script type="text/javascript">';
                $comment_form .='jQuery(document).ready(function () { ';

                $comment_form .='function savecomment(){ ';
                $comment_form .='var hashValue = jQuery("#csrf").val();';
                $comment_form .='var class_id = jQuery("#class_id").val(); ';
                $comment_form .='var roll_id = jQuery("#roll_id").val(); ';
                $comment_form .='var exam_id = jQuery("#eid").val();';
                $comment_form .='var tid = jQuery("#tid").val();';
                $comment_form .='var comment = jQuery("#comment").val();';
                $comment_form .='jQuery("#comment_saving").html("'.getlang('site_comment_saving', 'data').'");';
                $url = base_url()."user/savecomment";
                $comment_form .= 'jQuery.post("'.$url.'",{
                                csrf_zadmin:hashValue,
                                class_id:class_id,
                                roll_id:roll_id,
                                exam_id:exam_id,
                                tid:tid,
                                comment:comment
                             }, function(data){';
                $comment_form .= 'if(data){ 
                        var obj = jQuery.parseJSON(data); 
                        var new_hash = obj.csrfHash; 
                        jQuery("#csrf").val(new_hash);
                        jQuery("#comment_saving").html(obj.html);
                }';
                $comment_form .=' });';

                

                $comment_form .='}';


                $comment_form .='jQuery( "#comment_save" ).click(function() { savecomment(); }); ';
                $comment_form .='});';
                $comment_form .='</script>';
                
                if(!empty($check)){
                    $html .= $comment_form;
                }
                

            }else{
                if (empty($exam_id)) {
                    $html .= '<p style="color:red;" >'.getlang('site_form_select_exam', 'data').'</p>';
                }elseif (empty($class_id)) {
                    $html .= '<p style="color:red;" >'.getlang('site_form_select_class', 'data').'</p>';
                }elseif (empty($roll_id)) {
                    $html .= '<p style="color:red;" >'.getlang('site_form_enter_roll', 'data').'</p>';
                }else{
                    $html .= '<p style="color:red;" >'.getlang('site_form_select_class', 'data').'</p>';
                    $html .= '<p style="color:red;" >'.getlang('site_form_select_exam', 'data').'</p>';
                    $html .= '<p style="color:red;" >'.getlang('site_form_enter_roll', 'data').'</p>';
                }
            }
            

        }elseif ($role == ROLE_STUDENT) {

            $sid= $this->input->post('sid');
            $exam= $this->input->post('exam_id');
            $return_value = DisplayResult($sid,$exam);
            $html .= $return_value;
            
            
        }elseif ($role == ROLE_PARENT) {

            $sid= $this->input->post('s_name');
            $exam= $this->input->post('exam_id');
            if (!empty($sid) && !empty($exam)) {
                $return_value = DisplayResult($sid,$exam);
                $html .= $return_value;

            }else{
                if (empty($sid)) {$html .= '<p style="color:red;" >'.getlang('site_form_select_student', 'data').'</p>';}
                if (empty($exam)) {$html .= '<p style="color:red;" >'.getlang('site_form_select_exam', 'data').'</p>';}
            }
            
        }else{
            $this->loadViews('rocky', "frontend/result/default", $this->global, NULL , NULL);
        }
       
        $reponse['html'] = $html;
    	echo json_encode($reponse);
    }

    public function savecomment(){
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );
        $html = '';
        $class_id = $this->input->post('class_id');
        $roll_id = $this->input->post('roll_id');
        $exam_id = $this->input->post('exam_id');
        $tid = $this->input->post('tid');
        $comment = $this->input->post('comment');

        // Check exit data
        $result = $this->results_model->checkExitComment($class_id, $roll_id, $exam_id, $tid);
        if (!empty($result)) {
           $id = getResultCommentId($class_id, $roll_id, $exam_id, $tid);
           $result_comment = array(
                'class' => $class_id, 
                'roll' => $roll_id, 
                'eid' => $exam_id, 
                'tid' => $tid, 
                'comments' => $comment
            );
           $result = $this->results_model->update($result_comment, $id);
           if (!empty($result)) {
               
           }
        }else{
            $result_comment = array(
                'class' => $class_id, 
                'roll' => $roll_id, 
                'eid' => $exam_id, 
                'tid' => $tid, 
                'comments' => $comment
            );
           $result = $this->results_model->addnew($result_comment);
        }

        $reponse['html'] = $html;
        echo json_encode($reponse);
    }
  
}

?>