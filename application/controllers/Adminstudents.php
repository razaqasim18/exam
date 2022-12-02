<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH.'/libraries/BaseController.php';

class Adminstudents extends BaseController
{
    /**
     ** This is default constructor of the class
     **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('students_model');
        $this->load->library('session');
        $this->isLoggedIn();
    }

    /**
     ** Add Function
     **/
    public function add($Id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if (empty($Id)) {
                $Id = $this->input->post('id');
            }

            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Full Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required');
            $this->form_validation->set_rules('class_name', 'Class');
            $this->form_validation->set_rules('roll', 'Roll No', 'required');

            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');

            if ($this->form_validation->run() == false) {
                if (!empty($Id)) {
                    $data['studentInfo']       = $this->students_model->getStudentInfo($Id);
                    $data['accountInfo']       = $this->students_model->getAccountInfo($Id);
                    $this->global['pageTitle'] = getlang('edit_students_title');
                    $this->loadViews("backend/students/add", $this->global, $data, null);
                } else {
                    $this->global['pageTitle'] = getlang('browser_tab_add_new_students_title', 'sys_data');
                    $this->loadViews("backend/students/add", $this->global, null, null);
                }
            } else {
                $name       = ucwords(strtolower($this->security->xss_clean($this->input->post('name'))));
                $class      = $this->input->post('class_name');
                $department = $this->input->post('department');
                $roll       = $this->input->post('roll');
                $year       = $this->input->post('year');
                $mobile     = $this->security->xss_clean($this->input->post('mobile'));

                $email       = $this->security->xss_clean($this->input->post('email'));
                $password    = $this->input->post('password');
                $roleId      = $this->input->post('role');
                $verified    = $this->input->post('verified');
                $active      = $this->input->post('active');
                $subjectData = ["compulsory" => $this->input->post('compulsory'), "optional" => $this->input->post('optional'), "honors" => $this->input->post('honors')];
                $subjects    = serialize($subjectData);

                $students_info = array(
                    'roll'       => $roll,
                    'year'       => $year,
                    'class'      => $class,
                    'department' => $department,
                    'subjects'   => $subjects
                );

                if (empty($password)) {
                    $account_info = array(
                        'email'       => $email,
                        'roleId'      => $roleId,
                        'name'        => $name,
                        'mobile'      => $mobile,
                        'active'      => $active,
                        'is_verified' => $verified,
                        'createdBy'   => $this->userid,
                        'createdDtm'  => date('Y-m-d H:i:s')
                    );
                } else {
                    $account_info = array(
                        'email'       => $email,
                        'password'    => getHashedPassword($password),
                        'roleId'      => $roleId,
                        'name'        => $name,
                        'mobile'      => $mobile,
                        'active'      => $active,
                        'is_verified' => $verified,
                        'createdBy'   => $this->userid,
                        'createdDtm'  => date('Y-m-d H:i:s')
                    );
                }

                $this->load->model('students_model');

                if (!empty($Id)) {
                    $result          = $this->students_model->editStudent($account_info, $students_info, $Id);
                    $message_success = getlang('system_data_update_successfully', 'sys_data');
                    $message_error   = getlang('system_data_update_failed', 'sys_data');
                } else {
                    $result          = $this->students_model->addNewStudents($account_info, $students_info);
                    $message_success = getlang('system_data_create_successfully', 'sys_data');
                    $message_error   = getlang('system_data_create_failed', 'sys_data');
                }

                if ($result > 0) {
                    $this->session->set_flashdata('success', $message_success);
                } else {
                    $this->session->set_flashdata('error', $message_error);
                }

                redirect(ADMIN_ALIAS.'/students');
            }
        }
    }

    /**
     * This function is used to load the students list
     */
    public function studentlist()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $students_list_title = getlang('browser_tab_students_list_title', 'sys_data');

            $searchText             = $this->security->xss_clean($this->input->post('searchText'));
            $verified_value         = $this->security->xss_clean($this->input->post('verified_value'));
            $status_value           = $this->security->xss_clean($this->input->post('status_value'));
            $data['searchText']     = $searchText;
            $data['verified_value'] = $verified_value;
            $data['status_value']   = $status_value;

            $this->load->library('pagination');

            $count = $this->students_model->studentsListingCount($searchText, $verified_value, $status_value);

            $per_item = getConfigItem('item_per_list');

            if (empty($per_item)) {$per_item = 10;}

            $returns = $this->paginationCompress(ADMIN_ALIAS."/students/", $count, $per_item, 3);

            $data['studentsRecords'] = $this->students_model->studentsListing($searchText, $verified_value, $status_value, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = $students_list_title;
            $this->loadViews("backend/students/list", $this->global, $data, null);
        }
    }

    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    public function delete($Id = null)
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

        if ($this->isAdmin() == true) {
            $this->session->set_flashdata('error', $no_permission);
            redirect(ADMIN_ALIAS.'students');
        } else {
            // Get custom field delete
            $this->students_model->get_delete_custom_field_data($Id);

            // Get delete from user
            $this->students_model->get_delete_student_user($Id);

            // Get delete student
            $result = $this->students_model->deleteStudent($Id);

            if ($result > 0) {
                $reponse['status'] = true;
            } else {
                $reponse['status'] = false;
            }
        }

        echo json_encode($reponse);
    }

    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    public function view($id = null)
    {
        $no_permission  = getlang('system_no_permission', 'sys_data');
        $somthing_worng = getlang('system_somthing_worng', 'sys_data');

        if ($this->isAdmin() == true) {
            $this->session->set_flashdata('error', $no_permission);
            redirect('students');
        } else {
            if (!empty($id)) {
                $student_profile = getlang('browser_tab_student_profile', 'sys_data');

                $result['studentInfo']     = $this->students_model->viewStudent($id);
                $this->global['pageTitle'] = $student_profile;
                $this->loadViews("backend/students/view", $this->global, $result, null);
            } else {
                $this->session->set_flashdata('error', $somthing_worng);
                redirect(ADMIN_ALIAS.'/students');
            }
        }
    }

    /**
     ** Get Parent List
     **/
    public function parentList()
    {
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );

        $val           = $this->input->post('val');
        $html          = '';
        $parent_object = $this->students_model->parentList($val);

        if (!empty($parent_object)) {
            foreach ($parent_object as $key => $item) {
                if (empty($item->avatar)) {
                    $img_path = site_url('/uploads/parents/').'/avator.png';
                } else {
                    $img_path = site_url('/uploads/parents/').'/'.$item->avatar;
                }

                $onclick = "onclick=\"lookparent('".$item->name."','".$item->userId."');\"";
                $html .= '<div class="parent_list  " '.$onclick.'>
                    <img src="'.$img_path.'" alt="'.$item->name.'" class="avatar">
                    <span>'.$item->name.'</span>
                </div>';
            }
        } else {
            $html .= '<p style="color:red;padding:0; margin:0;">'.getlang('system_search_mitchmatch', 'sys_data').'</p>';
        }

        $reponse['html'] = $html;

        echo json_encode($reponse);
    }
}
