<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Classes : Class (ClassesController)
 * Classes Class to control all class related operations.
 * @author : zwebtheme
 * @version : 1.1
 * @since : May 2018
 */

class Adminmark extends BaseController
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
    ** This function is used to load the  list
    **/

    function add()
    {
        
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{      

            $mark_title = getlang('browser_tab_mark_title', 'sys_data');
            
            $this->global['pageTitle'] = $mark_title;
            $this->loadViews("backend/mark/add",  $this->global,'' , NULL);
        }

        
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
                                    'add_by'=>$this->userid
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
                        $msg .= getlang('system_excel_file_successfully_upload', 'sys_data');
                            
                        
                    }


                }else{
                    $message_type .= 'error';
                    $msg .= $_FILES['spreadsheet']['error'];
                }
            }// End spreadsheet file tmp_name

        }else{
            $message_type .= 'error';
            $msg .= getlang('system_please_select_csv_file', 'sys_data');
        }

        $this->session->set_flashdata($message_type, $msg);
        redirect(ADMIN_ALIAS.'/mark?exam='.$exam_id.'&class='.$class_id.'&department='.$department_id.'&subjects='. $subject_id);
        //$link = 'index.php?option=com_sms&view=marks&exam='.$exam_id.'&class='.$class_id.'&division='.$department_id.'&subjects='. $subject_id;
        

    }


    /**
    ** Get Student List by exam_id, class_id & Subject_id
    **/

    function student_list()
    {
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );

        $html = '';

        $action = getlang('action', 'sys_data');
        $roll = getlang('roll', 'sys_data');
        $name = getlang('student_name', 'sys_data');
        $mark = getlang('mark', 'sys_data');
        $comment = getlang('comment', 'sys_data');
        $saving = getlang('saving', 'sys_data');
        $save = getlang('save', 'sys_data');

        // Reacive data from add form

        $exam_id = $this->input->post('exam_id');
        $class_id = $this->input->post('class_id');
        $department = $this->input->post('department_id');
        $subject_id = $this->input->post('subject_id');
        $uid = $this->input->post('uid');
        

        if(!empty($exam_id) && !empty($class_id)  && !empty($department) && !empty($subject_id)){

            $students = $this->mark_model->getStudents($class_id, $department);

            if (!empty($students)) {
               
            
           
            //upload xcxl file
            $mark_student = '<table class="admin-table" id="admin-table" style="width: 100%;margin-top: 50px;background: #f5f5f5;" align="center">';
            $mark_student .= '<tr>';
            $mark_student .= '<td>';

            $mark_student .= '<form action="'.base_url().ADMIN_ALIAS.'/mark/importcsv" method="post" name="user-form"   enctype="multipart/form-data" style="padding:10px;">';
            $mark_student .= '<input type="file" style="display: inline-block;" name="spreadsheet"/>';
            $mark_student .= '<input type="submit" value="'.getlang('upload', 'sys_data').'" id="upload" class="btn btn-default" style="display: inline-block;" />';
            $mark_student .= '<input type="hidden" name="task" value="importcsv"  />';
            $mark_student .= '<input type="hidden" name="controller" value="marks" />';
            $mark_student .= '<input type="hidden" name="exam_id" value="'.$exam_id.'" />';
            $mark_student .= '<input type="hidden" name="class_id" value="'.$class_id.'" />';
            $mark_student .= '<input type="hidden" name="subject_id" value="'.$subject_id.'" />';
            $mark_student .= '<input type="hidden" name="department_id" value="'.$department.'" />';
            $mark_student .= '<input type="hidden" id="csrf_mark" name="'.$reponse['csrfName'].'" value="'.$reponse['csrfHash'].'" />';
            $mark_student .= '</form>';
            $mark_student .= ' <p class="help-block" style="margin-top: 10px;padding:10px;">Only Excel File <b style="color: red;">{CSV} </b> format Import. Excel file Must have headers as follows:<b style="color: red;"> '.getlang('roll_studentname_mark_comment', 'sys_data').'</b> </p></td>';
            $mark_student .= '</tr>';
            $mark_student .= '</table>';

          

            $mark_student .= '<table class="table-bordered result-table" id="admin-table" style="margin-top: 50px;" align="center">';
            $mark_student .= '<tr>';
            $mark_student .= '<th style="width: 3%;"></th>';
            $mark_student .= '<th style="width: 15%;">'.$roll.'</th>';
            $mark_student .= '<th>'.$name.'</th>';
            $mark_student .= '<th>'.$mark.'</th>';
            $mark_student .= '<th>'.$comment.'</th>';
            $mark_student .= '<th style="text-align: left;">'.$action.'</th>';
            $mark_student .= '</tr>';

            $mark_student .= '<input type="hidden" id="exam_id"  value="'.$exam_id.'" />';
            $mark_student .= '<input type="hidden" id="class_id"  value="'.$class_id.'" />';
            $mark_student .= '<input type="hidden" id="subject_id"  value="'.$subject_id.'" />';
            $mark_student .= '<input type="hidden" id="uid"  value="'.$uid.'" />';


            // Script for save mark
            $mark_student .= '<script type="text/javascript">';
                $mark_student .= 'jQuery(document).ready(function () {';

                $mark_student .= 'var exam_id = jQuery("#exam_id").val();';
                $mark_student .= 'var class_id = jQuery("#class_id").val();';
                $mark_student .= 'var subject_id = jQuery("#subject_id").val();';
                $mark_student .= 'var addby = jQuery("#uid").val();';
                     
                //function make
                $mark_student .= 'function markSaving(exam_id,class_id,subject_id,roll,sid,addby,year,mark,comment,order){';
                $url = base_url().ADMIN_ALIAS."/mark/savemark";
                $mark_student .= 'var getHass = jQuery("#csrf").val();';
                $mark_student .= 'jQuery("#saving_"+ order).html("'.$saving.'");';
                 
                $mark_student .= 'jQuery.post( "'.$url.'",{
                                csrf_zadmin:getHass,
                                exam_id:exam_id,
                                class_id:class_id,
                                subject_id:subject_id,
                                roll:roll,
                                sid:sid,
                                addby:addby,
                                year:year,
                                mark:mark,
                                comment:comment
                             }, function(data){';
                $mark_student .= 'if(data){ 
                        var obj = jQuery.parseJSON(data); 
                        var new_hash = obj.csrfHash; 
                        jQuery("#csrf").val(new_hash);
                        jQuery("#csrf_mark").val(new_hash);
                        jQuery("#saving_"+ order).html(obj.html);
                }';
                $mark_student .= '});';
                $mark_student .= '}';
            
                //function call
                foreach ($students as $s => $items) {
                    $mark_student .= 'jQuery( "#button_'.$s.'" ).click(function() {';
                    $mark_student .= 'markSaving(
                                      exam_id,
                                      class_id,
                                      subject_id,
                                      jQuery("#roll_'.$s.'").val(),
                                      jQuery("#sid_'.$s.'").val(),
                                      addby,
                                      jQuery("#year_'.$s.'").val(),
                                      jQuery("#mark_'.$s.'").val(),
                                      jQuery("#comment_'.$s.'").val(),
                                      '.$s.')';
                    //$mark_student .= 'alert("test");';
                    $mark_student .= '});';
                }
                     

                
            $mark_student .= '});';
            $mark_student .= '</script>';

            foreach ($students as $key => $student) {

                
                $mark = getMark('mark', $exam_id, $class_id, $subject_id, $student->id, $student->roll, $student->year);
                $comment = getMark('comment', $exam_id, $class_id, $subject_id, $student->id, $student->roll, $student->year);

                $student_name = getSingledata('users', 'name', 'userId', $student->userid);
                $student_avatar = getSingledata('users', 'avatar', 'userId', $student->userid);

                //Hidden Value
                $mark_student .= '<input type="hidden" id="roll_'.$key.'"  value="'.$student->roll.'" />';
                $mark_student .= '<input type="hidden" id="sid_'.$key.'"  value="'.$student->id.'" />';
                $mark_student .= '<input type="hidden" id="year_'.$key.'"  value="'.$student->year.'" />';

                $mark_student .= '<tr>';
               
                if(empty($student_avatar)){
                  $img_path = site_url('/uploads/students/').'/avator.png';
                }else{
                  $img_path = site_url('/uploads/students/').'/'.$student_avatar;
                }

                $mark_student .= '<td style="width: 3%;text-align: left;"><img src="'.$img_path.'" alt="'.$student_name.'" class="avatar"></td>';
                $mark_student .= '<td style="width: 3%;text-align: center;">'.$student->roll.'</td>';
                $mark_student .= '<td style="width: 15%;text-align: left;">'.$student_name.'</td>';

                // Mark Field
                $mark_student .= '<td style="width: 15%;text-align: center;">';
                $mark_student .= '<input type="text" class="mark-input" id="mark_'.$key.'"  value="'.$mark.'"  />';
                $mark_student .= '</td>';

                //Comment Field
                $mark_student .= '<td style="width: 15%;text-align: center;">';
                $mark_student .= '<input type="text" class="mark-input" id="comment_'.$key.'"  value="'.$comment.'"  />';
                $mark_student .= '</td>';

                $mark_student .= '<td style="text-align: left;">';
                $mark_student .= '<div id="saving_'.$key.'"></div>';
                $mark_student .= '<input type="button" class="btn btn-primary"  name="save" id="button_'.$key.'" value="'.$save.'" />';
                $mark_student .= '</td>';
                $mark_student .= '</tr>';
            }
            $mark_student .= '</table>';

            $html .= $mark_student;
        }else{
            $html .= '<p style="color:red;">'.getlang('no_student_found', 'sys_data').'</p>';
        }

        }else{

            $select_exam        = getlang('select_exam', 'sys_data');
            $select_subject     = getlang('select_subject', 'sys_data');
            $select_department  = getlang('select_department', 'sys_data');
            $select_class       = getlang('select_class', 'sys_data');
            $class_exam_subject = getlang('class_exam_subject', 'sys_data');
            if (empty($exam_id)) { 
                $html .= '<p style="color:red;">'.$select_exam.'</p>';
            }elseif (empty($class_id)) { 
                $html .= '<p style="color:red;">'.$select_class.'</p>';
            }elseif (empty($department)) { 
                $html .= '<p style="color:red;">'.$select_department.'</p>';
            }elseif (empty($subject_id)) { 
                $html .= '<p style="color:red;">'.$select_subject.'</p>';
            }else{ 
                $html .= '<p style="color:red;">'.$class_exam_subject.'</p>';
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

        
        $save_success = getlang('system_save_success', 'sys_data');
        $save_error = getlang('system_save_error', 'sys_data');

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
            $html .= '<b style="color:green;">'.$save_success.'</b>';
        }else{
            $html .= '<b style="color:red;">'.$save_error.'</b>';
        }

        $reponse['html'] = $html;

        echo json_encode($reponse);
    }

    
    
}

?>
