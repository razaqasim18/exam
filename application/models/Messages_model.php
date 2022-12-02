<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
 *  @author     : ZWebTheme
 *  date        : October, 2017
 *  Admin User Management System
 *  http://codecanyon.net/user/zwebtheme
 *  http://support.zwebtheme.com
 */

class Messages_model extends CI_Model
{
    /**
    ** List Count
    **/
    function ListingCount($uid)
    {
        $this->db->select('*');
        $this->db->from('messages');
        $this->db->where("(sender_id = ".$uid." OR  recever_id = ".$uid.")");
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
    ** Get List
    **/
    function Listing($uid, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('messages');
        $this->db->where("(sender_id = ".$uid." OR  recever_id = ".$uid.")");
        
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    
    /**
    ** Add New
    **/
    function addNew($data)
    {
        $this->db->trans_start();
        $this->db->insert('messages', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
    ** Get Reply
    **/
    function getReply($data)
    {
        $this->db->trans_start();
        $this->db->insert('message_reply', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    
    /**
    ** Get Message Item
    **/
    function getItem($id)
    {
        $this->db->select('*');
        $this->db->from('messages');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }



    /**
    ** Get Teacher List
    **/
    function getTeacherID($searchText)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('roleId', ROLE_TEACHER);
        
        if(!empty($searchText)) {
            $likeCriteria = "(name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
    ** Get Student List
    **/
    function getStudentID($searchText)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('roleId', ROLE_STUDENT);
        
        if(!empty($searchText)) {
            $likeCriteria = "(name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
    ** Get Parent List
    **/
    function getParentID($searchText)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('roleId', ROLE_PARENT);
        
        if(!empty($searchText)) {
            $likeCriteria = "(name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

}

  