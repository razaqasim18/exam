<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

class Notice_model extends CI_Model
{
    /**
     * This function is used to get the notice listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function noticeListingCount($searchText = '', $status_value, $group_value)
    {
        $this->db->select('n.id, n.title');
        $this->db->from('notice as n');
        if(!empty($searchText)) {
            $likeCriteria = "(n.title  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        // Filter by status 
        if(!empty($status_value)){
            
            if($status_value == 'active'){
                $this->db->where('n.status', 1);
            }

            if($status_value == 'inactive'){
                $this->db->where('n.status', 0);
            }
        }

        if($status_value == 'trush'){
            $this->db->where('n.is_delete', 1);
        }else{
            $this->db->where('n.is_delete', 0);
        }

        // Filter by group 
        if(!empty($group_value)){
            $this->db->where('n.groupId', $group_value);
        }

        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the notice listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function noticeListing($searchText = '', $status_value, $group_value, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('notice as n');
        if(!empty($searchText)) {
            $likeCriteria = "(n.title  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }


        // Filter by status 
        if(!empty($status_value)){
            
            if($status_value == 'active'){
                $this->db->where('n.status', 1);
            }

            if($status_value == 'inactive'){
                $this->db->where('n.status', 0);
            }
        }

        if($status_value == 'trush'){
            $this->db->where('n.is_delete', 1);
        }else{
            $this->db->where('n.is_delete', 0);
        }

        // Filter by group 
        if(!empty($group_value)){
            $this->db->where('n.groupId', $group_value);
        }
        

        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }


    /**
     * This function is used to get the notice listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function getNoticeCount($group)
    {
        $this->db->select('n.id, n.title');
        $this->db->from('notice as n');

        // Filter by group 
        if(!empty($group)){
            $this->db->where('n.groupId', $group);
        }
        
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the notice listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function getNotice($group, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('notice as n');
        
        // Filter by group 
        if(!empty($group)){
            $this->db->where('n.groupId = '.$group.' OR n.groupId = 0');
        }
        
        $this->db->where('n.status', 1);

        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    /**
     * This function is used to get the user group information
     * @return array $result : This is result of the query
     */
    function getGroup()
    {
        $this->db->select('roleId, role');
        $this->db->from('roles');
        $this->db->where('roleId !=', 1);
        $query = $this->db->get();
        return $query->result();
    }

   
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNew($Info)
    {
        $this->db->trans_start();
        $this->db->insert('notice', $Info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
     * This function is used to update the notice information
     * @param array $Info : This is notice updated information
     * @param number $id : This is notice id
     */
    function edit($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('notice', $Info);
        return TRUE;
    }
    
    
    /**
     * This function used to get notice information by id
     * @param number $id : This is notice id
     */
    function getNoticeInfo($id)
    {
        $this->db->select('*');
        $this->db->from('notice');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    
    
    /**
     * This function is used to delete the notice information
     * @param number $id : This is notice id
     * @return boolean $result : TRUE / FALSE
     */
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('notice');
        return TRUE;
    }

    /**
     * This function is used to trash the notice information
     * @param number $id : This is notice id
     * @return boolean $result : TRUE / FALSE
     */
    function trash($id) {
        $data = array('is_delete' => 1);
        $this->db->where('id', $id);
        $this->db->update('notice', $data);
        return TRUE;
    }

    /**
     * This function is used to active the notice information
     * @param number $id : This is notice id
     * @return boolean $result : TRUE / FALSE
     */
    function active($id) {
        $data = array('is_delete' => 0);
        $this->db->where('id', $id);
        $this->db->update('notice', $data);
        return TRUE;
    }


    /**
     * This function is used to read the notice information
     * @param number $id : This is notice id
     * @param number $value : This is notice read value
     * @return boolean $result : TRUE / FALSE
     */
    function read($id, $value) {
        $data = array('readNotice' => $value);
        $this->db->where('id', $id);
        $this->db->update('notice', $data);
        return TRUE;
    }

    /**
     * This function is used to read the notice information
     * @param number $id : This is notice id
     * @param number $value : This is notice read value
     * @return boolean $result : TRUE / FALSE
     */
    function hit($id, $value) {
        $data = array('hit' => $value);
        $this->db->where('id', $id);
        $this->db->update('notice', $data);
        return TRUE;
    }

    function userListing($group_value)
    {
        $this->db->select('*');
        $this->db->from('users as BaseTbl');
        

        $this->db->where('BaseTbl.is_verified', 1);

        // Filter by status 
        $this->db->where('BaseTbl.active', 1);

        $this->db->where('BaseTbl.isDeleted', 0);

        // Filter by group 
        if(!empty($group_value)){
            $this->db->where('BaseTbl.roleId', $group_value);
        }
        
        
        $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }



}

  