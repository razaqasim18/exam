<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Students_model extends CI_Model
{
    /**
     * This function used to get student information by id
     * @param number $id : This is student id
     * @return array $result : This is student information
     */
    public function getStudentInfo($id)
    {
        $this->db->select('*');
        $this->db->from('students');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     ** Get Account Info
     **/
    public function getAccountInfo($id)
    {
        // Get user id by student id
        $user_id = getSingledata('students', 'userid', 'id', $id);

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('userId', $user_id);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     ** Get Parent by name
     **/
    public function parentList($name)
    {
        $this->db->select('*');
        $this->db->from('users');

        if (!empty($name)) {
            $likeCriteria = "(name  LIKE '%" . $name . "%')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('roleId', ROLE_PARENT);
        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    public function studentsListingCount($searchText = '', $verified_value, $status_value)
    {
        $this->db->select('*');
        $this->db->from('users as u');
        $this->db->join('students as s', 's.userid = u.userId', 'left');

        if (!empty($searchText)) {
            $likeCriteria = "(u.email  LIKE '%" . $searchText . "%'
                            OR  u.name  LIKE '%" . $searchText . "%'
                            OR  u.mobile  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        // Filter by ferify user
        if (!empty($verified_value)) {
            if ($verified_value == 'verified') {
                $this->db->where('u.is_verified', 1);
            }

            if ($verified_value == 'unverified') {
                $this->db->where('u.is_verified', 0);
            }
        }

        // Filter by status
        if (!empty($status_value)) {
            if ($status_value == 'active') {
                $this->db->where('u.active', 1);
            }

            if ($status_value == 'inactive') {
                $this->db->where('u.active', 0);
            }
        }

        if ($status_value == 'trush') {
            $this->db->where('u.isDeleted', 1);
        } else {
            $this->db->where('u.isDeleted', 0);
        }

        $this->db->where('u.roleId !=', ROLE_SUPPER_ADMIN);
        $this->db->where('u.roleId', ROLE_STUDENT);
        $this->db->where('u.roleId !=', ROLE_PARENT);
        $this->db->where('u.roleId !=', ROLE_TEACHER);
        $query = $this->db->get();

        return $query->num_rows();
    }

    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    public function studentsListing($searchText = '', $verified_value, $status_value, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('users as u');
        $this->db->join('students as s', 's.userid = u.userId', 'left');
        if (!empty($searchText)) {
            $likeCriteria = "(u.email  LIKE '%" . $searchText . "%'
                            OR  u.name  LIKE '%" . $searchText . "%'
                            OR  u.mobile  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        // Filter by ferify user
        if (!empty($verified_value)) {
            if ($verified_value == 'verified') {
                $this->db->where('u.is_verified', 1);
            }

            if ($verified_value == 'unverified') {
                $this->db->where('u.is_verified', 0);
            }
        }

        // Filter by status
        if (!empty($status_value)) {
            if ($status_value == 'active') {
                $this->db->where('u.active', 1);
            }

            if ($status_value == 'inactive') {
                $this->db->where('u.active', 0);
            }
        }

        if ($status_value == 'trush') {
            $this->db->where('u.isDeleted', 1);
        } else {
            $this->db->where('u.isDeleted', 0);
        }

        $this->db->where('u.roleId !=', ROLE_SUPPER_ADMIN);
        $this->db->where('u.roleId', ROLE_STUDENT);
        $this->db->where('u.roleId !=', ROLE_PARENT);
        $this->db->where('u.roleId !=', ROLE_TEACHER);
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }

    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    public function addNewStudents($account_info, $students_info)
    {
        // Set Student Account
        $this->db->insert('users', $account_info);
        $user_id = $this->db->insert_id();

        // Set Student Data
        $students_info['userid'] = $user_id;
        $this->db->insert('students', $students_info);
        $student_id = $this->db->insert_id();

        //Setting Custom Field Data
        $sid         = getFieldSectionID('student');
        $fields      = getFieldList($sid);
        $total_field = count($fields);

        foreach ($fields as $field) {
            $fid              = $field->id;
            $sid              = $sid;
            $field_input_name = 'field_' . $fid;
            $field_data       = $this->input->post($field_input_name);
            $student_id       = $student_id;
            $type             = $field->type;
            saveFields($fid, $type, $sid, $field_data, $student_id, '');
        }

        return true;
    }

    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    public function editStudent($account_info, $students_info, $id)
    {
        // Get user id by student id
        $user_id = getSingledata('students', 'userid', 'id', $id);

        // Set Student Account
        $this->db->where('userId', $user_id);
        $this->db->update('users', $account_info);

        // Set Student Data
        $this->db->where('id', $id);
        $this->db->update('students', $students_info);

        //Setting Custom Field Data
        $sid         = getFieldSectionID('student');
        $fields      = getFieldList($sid);
        $total_field = count($fields);

        foreach ($fields as $field) {
            $fid              = $field->id;
            $sid              = $sid;
            $field_input_name = 'field_' . $fid;
            $field_data       = $this->input->post($field_input_name);
            $student_id       = $id;
            $type             = $field->type;

            $this->db->FROM('fields_data');
            $this->db->SELECT('id');
            $this->db->where('fid', $fid);
            $this->db->where('sid', $sid);
            $this->db->where('panel_id', $student_id);
            $query_result = $this->db->get();
            $exit_ids     = $query_result->row();
            $old_id       = $exit_ids->id;

            saveFields($fid, $type, $sid, $field_data, $student_id, $old_id);
        }

        return true;
    }

    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    public function deleteStudent($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('students');

        return true;
    }

    /**
     * @param $id
     */
    public function get_delete_student_user($id)
    {
        // Get user id by student id
        $user_id = getSingledata('students', 'userid', 'id', $id);
        $this->db->where('userId', $user_id);
        $this->db->delete('users');

        return true;
    }

    /**
     ** Get Delete custom field data by student id
     **/
    public function get_delete_custom_field_data($id)
    {
        $this->db->where('panel_id', $id);
        $this->db->delete('fields_data');

        return true;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function viewStudent($id)
    {
        $this->db->SELECT('*');
        $this->db->FROM('students');
        $this->db->where('id', $id);
        $query_result = $this->db->get();
        $query        = $query_result->row();

        return $query;
    }
}
