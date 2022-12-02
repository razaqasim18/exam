<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Teachers_model extends CI_Model
{
   /**
     * This function used to get student information by id
     * @param number $id : This is student id
     * @return array $result : This is student information
     */
    function getTeachersInfo($id)
    {
        $this->db->select('*');
        $this->db->from('teachers');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    /**
    ** Get Account Info
    **/
    function getAccountInfo($id){
        // Get user id by student id
        $user_id = getSingledata('teachers', 'userid', 'id', $id);

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('userId', $user_id);
        $query = $this->db->get();
        return $query->result();
    }



    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function teachersListingCount($searchText = '', $verified_value, $status_value)
    {
        $this->db->select('*');
        $this->db->from('users as u');
        $this->db->join('teachers as t', 't.userid = u.userId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(u.email  LIKE '%".$searchText."%'
                            OR  u.name  LIKE '%".$searchText."%'
                            OR  u.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        // Filter by ferify user
        if(!empty($verified_value)){
            if($verified_value == 'verified'){
                $this->db->where('u.is_verified', 1);
            }

            if($verified_value == 'unverified'){
                $this->db->where('u.is_verified', 0);
            }
        }

        // Filter by status 
        if(!empty($status_value)){
            
            if($status_value == 'active'){
                $this->db->where('u.active', 1);
            }

            if($status_value == 'inactive'){
                $this->db->where('u.active', 0);
            }
        }

        if($status_value == 'trush'){
            $this->db->where('u.isDeleted', 1);
        }else{
            $this->db->where('u.isDeleted', 0);
        }

        $this->db->where('u.roleId !=', ROLE_SUPPER_ADMIN);
        $this->db->where('u.roleId !=', ROLE_STUDENT);
        $this->db->where('u.roleId !=', ROLE_PARENT);
        $this->db->where('u.roleId', ROLE_TEACHER);
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
    function teachersListing($searchText = '', $verified_value, $status_value, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('users as u');
        $this->db->join('teachers as t', 't.userid = u.userId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(u.email  LIKE '%".$searchText."%'
                            OR  u.name  LIKE '%".$searchText."%'
                            OR  u.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        // Filter by ferify user
        if(!empty($verified_value)){
            if($verified_value == 'verified'){
                $this->db->where('u.is_verified', 1);
            }

            if($verified_value == 'unverified'){
                $this->db->where('u.is_verified', 0);
            }
        }

        // Filter by status 
        if(!empty($status_value)){
            
            if($status_value == 'active'){
                $this->db->where('u.active', 1);
            }

            if($status_value == 'inactive'){
                $this->db->where('u.active', 0);
            }
        }

        if($status_value == 'trush'){
            $this->db->where('u.isDeleted', 1);
        }else{
            $this->db->where('u.isDeleted', 0);
        }

        $this->db->where('u.roleId !=', ROLE_SUPPER_ADMIN);
        $this->db->where('u.roleId !=', ROLE_STUDENT);
        $this->db->where('u.roleId !=', ROLE_PARENT);
        $this->db->where('u.roleId', ROLE_TEACHER);
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();         
        return $result;
    }
   
    
   
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewTeacher($account_info, $teachersInfo)
    {

        // Set Teachers Account
        $this->db->insert('users', $account_info);
        $user_id = $this->db->insert_id();
        $teachersInfo['userid'] = $user_id;

        // get Teachers query
        $this->db->insert('teachers', $teachersInfo);
        $teacher_id = $this->db->insert_id();

        //Setting Custom Field Data
        $sid = getFieldSectionID('teacher');
        
        $fields = getFieldList($sid);
        $total_field = count($fields);

        foreach($fields as $field){
            $fid = $field->id;
            $sid = $sid;
            $field_input_name ='field_'.$fid;
            $field_data = $this->input->post($field_input_name);
            $teacher_id = $teacher_id;
            $type = $field->type;
            saveFields($fid, $type, $sid, $field_data, $teacher_id,'');
        }

        return TRUE;
    }


    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editTeacher($account_info, $teachersInfo, $id)
    {

        // Get user id by teacher id
        $user_id = getSingledata('teachers', 'userid', 'id', $id);

        // Set teacher account data
        $this->db->where('userId', $user_id);
        $this->db->update('users', $account_info);

        $this->db->where('id', $id);
        $this->db->update('teachers', $teachersInfo);

        //Setting Custom Field Data
        $sid = getFieldSectionID('teacher');
        
        $fields = getFieldList($sid);
        $total_field = count($fields);

        foreach($fields as $field){
            $fid = $field->id;
            $sid = $sid;
            $field_input_name ='field_'.$fid;
            $field_data = $this->input->post($field_input_name);
            $teacher_id = $id;
            $type = $field->type;

            $this->db->FROM('fields_data');
            $this->db->SELECT('id');
            $this->db->where('fid',$fid);
            $this->db->where('sid',$sid);
            $this->db->where('panel_id',$teacher_id);
            $query_result=$this->db->get();
            $exit_ids = $query_result->row();
            $old_id = $exit_ids->id;

            saveFields($fid, $type, $sid, $field_data, $teacher_id,$old_id);
        }

        return TRUE;
    }



    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteTeacher($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('teachers');
        return TRUE;
    }

    /**
    ** Get Delete custom field data by student id
    **/
    function get_delete_custom_field_data($id){
        $this->db->where('panel_id', $id);
        $this->db->delete('fields_data');
        return TRUE;
    }




    public function viewTeacher($id){
        $this->db->SELECT('*');
        $this->db->FROM('teachers');
        $this->db->where('id',$id);
        $query_result=$this->db->get();
        $query=$query_result->row();
        return $query;
    }
    

}

  