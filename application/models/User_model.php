<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
 *  @author     : ZWebTheme
 *  date        : October, 2017
 *  Admin User Management System
 *  http://codecanyon.net/user/zwebtheme
 *  http://support.zwebtheme.com
 */

class User_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param string $verified_value : This is verify value come from dropsown
     * @param string $status_value : This is status value come from dropsown
     * @param string $group_value : This is group/role value come from dropsown
     * @return number $count : This is row count
     */
    function userListingCount($searchText = '', $verified_value, $status_value, $group_value)
    {
        $this->db->select('u.userId, u.email, u.name, u.mobile, Role.role');
        $this->db->from('users as u');
        $this->db->join('roles as Role', 'Role.roleId = u.roleId','left');
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

        // Filter by group 
        if(!empty($group_value)){
            $this->db->where('u.roleId', $group_value);
        }
        
        $this->db->where('u.isDeleted', 0);
        $this->db->where('u.is_verified', 1);
        $this->db->where('u.roleId !=', ROLE_STUDENT);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the user listing 
     * @param string $searchText : This is optional search text
     * @param string $verified_value : This is verify value come from dropsown
     * @param string $status_value : This is status value come from dropsown
     * @param string $group_value : This is group/role value come from dropsown
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function userListing($searchText = '', $verified_value, $status_value, $group_value, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('users as u');
        $this->db->join('roles as Role', 'Role.roleId = u.roleId','left');
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

        // Filter by group 
        if(!empty($group_value)){
            $this->db->where('u.roleId', $group_value);
        }
        
        
        $this->db->where('u.roleId !=', ROLE_SUPPER_ADMIN);
        $this->db->where('u.roleId !=', ROLE_STUDENT);
        $this->db->where('u.roleId !=', ROLE_PARENT);
        $this->db->where('u.roleId !=', ROLE_TEACHER);
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }



    /**
    ** Get Log Listing count
    **/
    function logListingCount($uid)
    {
        $this->db->select('*');
        $this->db->from('last_login');
        $this->db->where('userId', $uid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
    ** Get Log Listing
    **/
    function getLogs($uid, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('last_login');
        $this->db->where('userId', $uid);
        $this->db->order_by("id", "desc");
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    
    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('roles');
        $this->db->where('roleId !=', 1);
        $query = $this->db->get();
        return $query->result();
    }

    /**
    ** Get user role for signup
    **/
    function getUserRolesforSignup()
    {
        $this->db->select('roleId, role');
        $this->db->from('roles');
        $this->db->where('roleId !=', 1);
        $this->db->where('roleId !=', 2);
        $this->db->where('roleId !=', 3);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("users");
        $this->db->where("email", $email);   
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function used to get student information by id
     * @param number $id : This is student id
     * @return array $result : This is student information
     */
    function getStudentInfo($id)
    {
        $this->db->select('*');
        $this->db->from('students');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNew($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('users', $userInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    /**
     * This function used to get user information by id without super admin
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('isDeleted', 0);
		$this->db->where('roleId !=', 1);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        return $query->result();
    }

    /**
    * This function used to get all user information by id
    * @param {string} $userId : This is user id
    * @return array $result : This is user information
    */
    function getUser($userId)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
    * This function used to get admin information only by admin id
    * @param {string} $userId : This is user id
    * @return array $result   : This is admin information
    */
    function getadmininfo($userId)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId  : This is user id
     */
    function edit($role, $userInfo, $panelInfo, $userId, $uid, $section)
    {
        
        //Setting Custom Field Data
        $sid         = getFieldSectionID($section);
        $fields      = getFieldList($sid);
        $total_field = count($fields);

        foreach($fields as $field){
            $fid = $field->id;
            $sid = $sid;
            $field_input_name ='field_'.$fid;
            $field_data = $this->input->post($field_input_name);
            $student_id = $uid;
            $type = $field->type;

            $this->db->FROM('fields_data');
            $this->db->SELECT('id');
            $this->db->where('fid',$fid);
            $this->db->where('sid',$sid);
            $this->db->where('panel_id',$student_id);
            $query_result=$this->db->get();
            $exit_ids = $query_result->row();
            $old_id = $exit_ids->id;

            saveFields($fid, $type, $sid, $field_data, $student_id,$old_id);
        }

        $this->db->where('userId', $userId);
        $this->db->update('users', $userInfo);

        return TRUE;
    }

    /**
    ** Get user edit
    **/
    function userEdit($userInfo, $userId){
        $this->db->where('userId', $userId);
        $this->db->update('users', $userInfo);
        return TRUE;
    }


    function userphotoedit($userInfo, $userId){
        $this->db->where('userId', $userId);
        $this->db->update('users', $userInfo);
        return TRUE;
    }
    
    
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function delete($id)
    {
        $this->db->where('userId', $id);
        $this->db->delete('users');
        return TRUE;
    }

    /**
     * This function is used to trash the user 
     * @param number $id : This is user id
    **/
    function trash($id) {
        $data = array('isDeleted' => 1);
        $this->db->where('userId', $id);
        $this->db->update('users', $data);
    }

    /**
     * This function is used to active/deactive the user 
     * @param number $id : This is user id
    **/
    function active($id) {
        $data = array('isDeleted' => 0);
        $this->db->where('userId', $id);
        $this->db->update('users', $data);
    }


    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);        
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('users');
        $user = $query->result();
        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change users password
     * @param number $userId  : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('users', $userInfo);
        return $this->db->affected_rows();
    }

    
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfoById($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * This function is used to get the notice listing count
     * @param number $group : This is user group id
     * @param number $page : This is pagination limit
     * @return array $result : This is result
     */
    function getNotice($group, $page)
    {
        $this->db->select('*');
        $this->db->from('notice as n');
        
        // Filter by group 
        if(!empty($group)){
            $this->db->where('n.groupId = '.$group.' OR n.groupId = 0');
        }
        
        $this->db->where('n.status', 1);

        $this->db->limit($page);
        $this->db->order_by("n.id", "desc");
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }


    /**
    ** Sign-up for student
    **/
    function addNewStudents($account_info, $students_info)
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
        foreach($fields as $field){
            $fid = $field->id;
            $sid = $sid;
            $field_input_name ='field_'.$fid;
            $field_data = $this->input->post($field_input_name);
            $student_id = $student_id;
            $type = $field->type;
            saveFields($fid, $type, $sid, $field_data, $student_id,'');
        }

        return TRUE;
    }

    /**
    ** Sign-up for teacher
    **/
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
    ** Sign-up for parent
    **/
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

   

}

  