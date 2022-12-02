<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Parents_model extends CI_Model
{
   /**
     * This function used to get student information by id
     * @param number $id : This is student id
     * @return array $result : This is student information
     */
    function getParentInfo($id)
    {
        $this->db->select('*');
        $this->db->from('parents');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    /**
    ** Get Account Info
    **/
    function getAccountInfo($id){
        // Get user id by student id
        $user_id = getSingledata('parents', 'userid', 'id', $id);

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
    function parentsListingCount($searchText = '', $verified_value, $status_value)
    {
        $this->db->select('*');
        $this->db->from('users as u');
        $this->db->join('parents as p', 'p.userid = u.userId','left');
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
        $this->db->where('u.roleId', ROLE_PARENT);
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
    function parentsListing($searchText = '', $verified_value, $status_value, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('users as u');
        $this->db->join('parents as p', 'p.userid = u.userId','left');
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
        $this->db->where('u.roleId', ROLE_PARENT);
        $this->db->where('u.roleId !=', ROLE_TEACHER);
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();         
        return $result;
    }

    /**
    ** Get Students List by Name
    **/
    function studentList($val)
    {
        $this->db->select('*');
        $this->db->from('students as BaseTbl');
        if(!empty($val)) {
            $likeCriteria = "(BaseTbl.name  LIKE '%".$val."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
   
    
   
    
    /**
     * This function is used to add new parents to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewParents($account_info)
    {

        // Set parents Account
        $this->db->insert('users', $account_info);
        $user_id = $this->db->insert_id();
        $parentsInfo['userid'] = $user_id;

        // get parents query
        $this->db->insert('parents', $parentsInfo);
        $teacher_id = $this->db->insert_id();

        //Setting Custom Field Data
        $sid = getFieldSectionID('parent');
        
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
    function editParents($account_info, $id)
    {

        // Get user id by teacher id
        $user_id = getSingledata('parents', 'userid', 'id', $id);

        // Set teacher account data
        $this->db->where('userId', $user_id);
        $this->db->update('users', $account_info);

    
        //Setting Custom Field Data
        $sid = getFieldSectionID('parent');
        
        $fields = getFieldList($sid);
        $total_field = count($fields);

        foreach($fields as $field){
            $fid = $field->id;
            $sid = $sid;
            $field_input_name ='field_'.$fid;
            $field_data = $this->input->post($field_input_name);
            $parent_id = $id;
            $type = $field->type;

            $this->db->FROM('fields_data');
            $this->db->SELECT('id');
            $this->db->where('fid',$fid);
            $this->db->where('sid',$sid);
            $this->db->where('panel_id',$parent_id);
            $query_result=$this->db->get();
            $exit_ids = $query_result->row();
            $old_id = $exit_ids->id;

            saveFields($fid, $type, $sid, $field_data, $parent_id,$old_id);
        }

        return TRUE;
    }


    function get_delete_parent_user($user_id)
    {

        $this->db->where('userId', $user_id);
        $this->db->delete('usres');
        return TRUE;
    }
   

    /**
    ** Get Delete custom field data by parent id
    **/
    function get_delete_custom_field_data($id){
        $this->db->where('panel_id', $id);
        $this->db->delete('fields_data');
        return TRUE;
    }

     /**
     * This function is used to delete the parents information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteParent($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('parents');
        return TRUE;
    }





    public function viewParent($id){
        $this->db->SELECT('*');
        $this->db->FROM('parents');
        $this->db->where('id',$id);
        $query_result=$this->db->get();
        $query=$query_result->row();
        return $query;
    }
    

}

  