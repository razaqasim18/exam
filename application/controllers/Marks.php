<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/FrontEndController.php';

class Marks extends FrontEndController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mark_model');
        $this->load->library('session');
        $this->isLoggedIn();   
    }
    
    
    /**
    ** Index Page for this controller.
    **/
    function index()
    {
        
        $this->global['pageTitle'] = 'Manage Marks';
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';

    	if($this->isTeacher() == TRUE){
            //$data['data'] = $this->attendances_model->getAttendance($returns["page"], $returns["segment"]);
	        $this->loadViews('rocky', "frontend/marks/default", $this->global, NULL , NULL);
        }elseif($this->isStudent() == TRUE){
            $this->session->set_flashdata('error', 'Cant Access !');
            redirect('user/dashboard');
        }elseif ($this->isParent() == TRUE) {
            $this->session->set_flashdata('error', 'Cant Access !');
        	redirect('user/dashboard');
        }
    	
        
    }

    
   

    /**
    ** Get Student List
    **/
    function students(){
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );

        $eid = $this->input->post('eid');
        $cid = $this->input->post('cid');
        $did = $this->input->post('did');
        $sid = $this->input->post('sid');
        $uid = $this->input->post('uid');

        $html = '';
        if(!empty($eid) && !empty($cid) && !empty($did) && !empty($sid)){
            //$return_value = DisplayAttendance( $year, $month, $sid);
            $html .= getstudentList($eid, $cid,$did, $sid, $uid, $reponse['csrfHash']);
        }else{
            if(empty($eid)){
                $html .='<p style="text-align: center;color: red;">'.getlang('select_exam', 'sys_data').'</p>';
            }elseif(empty($cid)){
                $html .='<p style="text-align: center;color: red;">'.getlang('select_class', 'sys_data').'</p>';
            }elseif (empty($did)) {
                $html .='<p style="text-align: center;color: red;">'.getlang('select_department', 'sys_data').'</p>';
            }elseif (empty($sid)) {
                $html .='<p style="text-align: center;color: red;">'.getlang('select_subject', 'sys_data').'</p>';
            }
         
        }

        $reponse['html'] = $html;

        echo json_encode($reponse);
    }


    /**
    ** Get Save mark 
    **/
    function savemark(){

        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );
        
        $html = '';
        
        $save_success = getlang('save_success');
        $save_error = getlang('save_error');

        $exam_id = $this->input->post('exam_id');
        $class_id = $this->input->post('class_id');
        $subject_id = $this->input->post('subject_id');
        $roll = $this->input->post('roll');
        $student_id = $this->input->post('sid');
        $year = $this->input->post('year');
        $mark = $this->input->post('mark');
        $comment = $this->input->post('comment');
        $uid = $this->input->post('addby');

        // Get check exit data
        $mark_id = getMark('id', $exam_id, $class_id, $subject_id, $student_id, $roll, $year);


        // Preparetion for stire
        $data = array(
            'student_id'=> $student_id, 
            'exam_id'=>$exam_id, 
            'class_id'=> $class_id, 
            'subject_id'=>$subject_id, 
            'mark'=>$mark,
            'comment'=>$comment, 
            'roll'=>$roll, 
            'year'=>$year,
            'add_by'=>$uid
        );



        // get save 
        if(!empty($mark_id)){
            $id = $this->mark_model->edit($data, $mark_id);
        }else{
            $id = $this->mark_model->addNew($data);
        }
        
        if ($id) {
            $html .='<b style="color:green;">'.$save_success.'</b>';
        }else{
            $html .= '<b style="color:red;">'.$save_error.'</b>';
        }


        $reponse['html'] = $html;

        echo json_encode($reponse);
    }


    /**
    ** Import Excel File
    **/
    function importcsv(){
        $exam_id       = $this->input->post('exam_id');
        $class_id      = $this->input->post('class_id');
        $department_id = $this->input->post('department_id');
        $subject_id    = $this->input->post('subject_id');


        $message_type = '';
        $msg = '';
        //jimport('phpexcel.library.PHPExcel');
        //Check valid spreadsheet has been uploaded
        if(isset($_FILES['spreadsheet'])){


            if($_FILES['spreadsheet']['tmp_name']){
                if(!$_FILES['spreadsheet']['error'])
                {

                    $filename=$_FILES["spreadsheet"]["tmp_name"];   
                    if($_FILES["spreadsheet"]["size"] > 0){

                        $file = fopen($filename, "r");

                        // read the first line and ignore it
                        fgets($file); 
                        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){

                            $roll          = $getData['0'];
                            $student_name  = $getData['1'];
                            $mark          = $getData['2'];
                            $comment       = $getData['3'];


                            //get student id
                            $student_id = getSingledata('students', 'id', 'roll', $roll);
                            //get student year
                            $student_year = getSingledata('students', 'year', 'roll', $roll);
                            
                                
                            //if(!empty($student_id) && !empty($student_year)){
                                                          
                                // Get check exit data
                            $mark_id = getMark('id', $exam_id, $class_id, $subject_id, $student_id, $roll, $student_year);


                                // Preparetion for stire
                                $data = array(
                                    'student_id'=> $student_id, 
                                    'exam_id'=>$exam_id, 
                                    'class_id'=> $class_id, 
                                    'subject_id'=>$subject_id, 
                                    'mark'=>$mark,
                                    'comment'=>$comment, 
                                    'roll'=>$roll, 
                                    'year'=>$student_year,
                                    'add_by'=>$this->uid
                                );

                               
                                // get save 
                                if(!empty($mark_id)){
                                    $id = $this->mark_model->edit($data, $mark_id);
                                }else{

                                    $id = $this->mark_model->addNew($data);
                                }                                                                  
                            //}

                            
                        }

                        fclose($file);
                        $message_type .= 'success';
                        $msg .=''.getlang('excel_file_successfully_upload', 'sys_data').'';
                            
                        
                    }


                }else{
                    $message_type .= 'error';
                    $msg .= $_FILES['spreadsheet']['error'];
                }
            }// End spreadsheet file tmp_name

        }else{
            $message_type .= 'error';
            $msg .= 'Please select CSV file !';
        }

        $this->session->set_flashdata($message_type, $msg);
        redirect('/user/marks?exam='.$exam_id.'&class='.$class_id.'&department='.$department_id.'&subjects='. $subject_id);
        //$link = 'index.php?option=com_sms&view=marks&exam='.$exam_id.'&class='.$class_id.'&division='.$department_id.'&subjects='. $subject_id;
        

    }
    
    
}

?>
