<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/FrontEndController.php';

class Signup extends FrontEndController
{


    /**
    ** constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->database();
        $this->load->library('session');
    }
    
    /**
    ** Index
    **/
    public function index()
    {
        $disable_signup = getConfigItem('disable_signup');
        if (empty($disable_signup)) {
            $data['role_id']  = '';
            $data['name']     = '';
            $data['email']    = '';
            $data['mobile']   = '';
            $data['roles'] = $this->user_model->getUserRolesforSignup();
            $this->global['pageTitle'] = getlang('signup_page_title', 'sys_data'); 
            $this->global['meta_description'] = '';
            $this->global['meta_tag']         = '';
            $this->global['author']           = '';
            $this->loadViews('rocky', "frontend/signup/signup", $this->global, $data , NULL);
        }else{
            redirect('login');
        }
    }
    
   
    /**
    ** Save Signup data
    **/
    function add()
    {

        $disable_signup = getConfigItem('disable_signup');
        if (empty($disable_signup)) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password','Password','required|max_length[8]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[8]');
            $this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('mobile','Mobile Number','required');
            $this->form_validation->set_rules('role','Select group','required');

            $role     = $this->security->xss_clean($this->input->post('role'));
            $name     = ucwords(strtolower($this->security->xss_clean($this->input->post('name'))));
            $email    = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('password');
            $mobile   = $this->security->xss_clean($this->input->post('mobile'));

            if($this->form_validation->run() == FALSE){
                $data['role_id']  = $role;
                $data['name']     = $name;
                $data['email']    = $email;
                $data['password'] = $password;
                $data['mobile']   = $mobile;
                $data['roles'] = $this->user_model->getUserRolesforSignup();
                $this->global['pageTitle'] = getlang('signup_page_title', 'sys_data'); 
                $this->global['meta_description'] = '';
                $this->global['meta_tag']         = '';
                $this->global['author']           = '';
                $this->loadViews('rocky', "frontend/signup/signup", $this->global, $data , NULL);
            }

            

            if($role == ROLE_STUDENT){
                $data['role_id']      = $role;
                $data['name']         = $name;
                $data['email']        = $email;
                $data['password']     = $password;
                $data['mobile']       = $mobile;
                $data['class']        = '';
                $data['department']   = '';
                $data['year']         = '';

                $this->global['pageTitle']        = 'Signup Step 2'; 
                $this->global['meta_description'] = '';
                $this->global['meta_tag']         = '';
                $this->global['author']           = '';
                $this->loadViews('rocky', "frontend/signup/student", $this->global, $data , NULL);

            }elseif ($role == ROLE_PARENT) {
                $data['role_id']  = $role;
                $data['name']     = $name;
                $data['email']    = $email;
                $data['password'] = $password;
                $data['mobile']   = $mobile;

                $this->global['pageTitle']        = 'Signup Step 2'; 
                $this->global['meta_description'] = '';
                $this->global['meta_tag']         = '';
                $this->global['author']           = '';
                $this->loadViews('rocky', "frontend/signup/parent", $this->global, $data , NULL);
            }elseif ($role == ROLE_TEACHER) {
                $data['role_id']  = $role;
                $data['name']     = $name;
                $data['email']    = $email;
                $data['password'] = $password;
                $data['mobile']   = $mobile;

                $data['class']        = '';
                $data['department']   = '';
                $data['subject']      = '';

                $this->global['pageTitle']        = 'Signup Step 2'; 
                $this->global['meta_description'] = '';
                $this->global['meta_tag']         = '';
                $this->global['author']           = '';
                $this->loadViews('rocky', "frontend/signup/teacher", $this->global, $data , NULL);
            }
                
           
        }else{
            redirect('login');
        }
        
    }

    /**
    ** Save Student
    **/
    function saveStudent()
    {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('class_name','Class','trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('department','Department','trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('year','Year','trim|required|is_natural_no_zero');

            $role       = $this->security->xss_clean($this->input->post('role'));
            $name       = $this->security->xss_clean($this->input->post('name'));
            $email      = $this->security->xss_clean($this->input->post('email'));
            $password   = $this->input->post('password');
            $mobile     = $this->security->xss_clean($this->input->post('mobile'));
            $class      = $this->security->xss_clean($this->input->post('class_name'));
            $department = $this->security->xss_clean($this->input->post('department'));
            $year       = $this->security->xss_clean($this->input->post('year'));
            $roll       = $this->security->xss_clean($this->input->post('roll'));

            if($this->form_validation->run() == FALSE){
                $data['role_id']      = $role;
                $data['name']         = $name;
                $data['email']        = $email;
                $data['password']     = $password;
                $data['mobile']       = $mobile;
                $data['class']        = $class;
                $data['department']   = $department;
                $data['year']         = $year;

                $this->global['pageTitle']        = 'Signup Step 2'; 
                $this->global['meta_description'] = '';
                $this->global['meta_tag']         = '';
                $this->global['author']           = '';
                $this->loadViews('rocky', "frontend/signup/student", $this->global, $data , NULL);
            }else{
               
                $account_info = array(
                    'email'      =>$email,
                    'password'   =>getHashedPassword($password), 
                    'roleId'     =>$role, 
                    'name'       => $name,
                    'mobile'     =>$mobile, 
                    'createdDtm' =>date('Y-m-d H:i:s')
                );

                $students_info = array(
                    'roll'       => $roll, 
                    'year'       => $year, 
                    'class'      =>$class,
                    'department' =>$department
                );

                $result = $this->user_model->addNewStudents($account_info, $students_info);
                $message_success = getlang('student_registration_successfully');
                $message_error = getlang('student_registration_failed');

                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }

                redirect('signup');

            }

    }


    /**
    ** Save Teacher
    **/
    function saveTeacher()
    {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('class_name[]','Class','trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('departments_name[]','Department','trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('subject_name[]','Subject','trim|required|is_natural_no_zero');

            $role       = $this->security->xss_clean($this->input->post('role'));
            $name       = $this->security->xss_clean($this->input->post('name'));
            $email      = $this->security->xss_clean($this->input->post('email'));
            $password   = $this->input->post('password');
            $mobile     = $this->security->xss_clean($this->input->post('mobile'));

            $class      = $this->security->xss_clean($this->input->post('class_name[]'));
            $department = $this->security->xss_clean($this->input->post('departments_name[]'));
            $subject       = $this->security->xss_clean($this->input->post('subject_name[]'));

            if($this->form_validation->run() == FALSE){
                $data['role_id']      = $role;
                $data['name']         = $name;
                $data['email']        = $email;
                $data['password']     = $password;
                $data['mobile']       = $mobile;
                
                if(!empty($class)){
                    $data['class']        = implode(',', $class);
                }else{
                    $data['class']        = '';
                }
                
                if(!empty($department)){
                    $data['department']   = implode(',', $department);
                }else{
                    $data['department']   = '';
                }
                
                if(!empty($subject)){
                    $data['subject']      = implode(',', $subject);
                }else{
                    $data['subject']      = '';
                }
                

                $this->global['pageTitle']        = 'Signup Step 2'; 
                $this->global['meta_description'] = '';
                $this->global['meta_tag']         = '';
                $this->global['author']           = '';
                $this->loadViews('rocky', "frontend/signup/teacher", $this->global, $data , NULL);
            }else{

                $department = implode(",",$department);
                $subject = implode(",",$subject);
                $class = implode(",",$class);
               
                $account_info = array(
                    'email'      => $email,
                    'password'   => getHashedPassword($password), 
                    'roleId'     => $role, 
                    'name'       => $name,
                    'mobile'     => $mobile, 
                    'createdDtm' => date('Y-m-d H:i:s')
                );

                $teacher_info = array(
                    'class'       => $class,
                    'department'  => $department, 
                    'subject'     => $subject 
                );

                $result = $this->user_model->addNewTeacher($account_info, $teacher_info);
                $message_success = getlang('teacher_registration_successfully');
                $message_error = getlang('teacher_registration_failed');

                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }

                redirect('signup');

            }

    }

    /**
    ** Save Parent
    **/
    function saveParent()
    {
            $this->load->library('form_validation');
            $role       = $this->security->xss_clean($this->input->post('role'));
            $name       = $this->security->xss_clean($this->input->post('name'));
            $email      = $this->security->xss_clean($this->input->post('email'));
            $password   = $this->input->post('password');
            $mobile     = $this->security->xss_clean($this->input->post('mobile'));

            // if($this->form_validation->run() == FALSE){
            //     $data['role_id']      = $role;
            //     $data['name']         = $name;
            //     $data['email']        = $email;
            //     $data['password']     = $password;
            //     $data['mobile']       = $mobile;
                
            //     $this->global['pageTitle']        = 'Signup Step 2'; 
            //     $this->global['meta_description'] = '';
            //     $this->global['meta_tag']         = '';
            //     $this->global['author']           = '';
            //     $this->loadViews('rocky', "frontend/signup/parent", $this->global, $data , NULL);
            // }else{

                $account_info = array(
                    'email'      => $email,
                    'password'   => getHashedPassword($password), 
                    'roleId'     => $role, 
                    'name'       => $name,
                    'mobile'     => $mobile, 
                    'createdDtm' => date('Y-m-d H:i:s')
                );

                $result = $this->user_model->addNewParents($account_info);
                $message_success = getlang('parent_registration_successfully');
                $message_error   = getlang('parent_registration_failed');

                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }

                redirect('signup');

            //}

    }
    
}





?>