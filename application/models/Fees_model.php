<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : zwebtheme
*  School Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

class Fees_model extends CI_Model
{
    /**
    ** Get List Count
    **/
    function ListingCount($searchText = '', $status_value)
    {
        $this->db->select('id, title');
        $this->db->from('fees');
        if(!empty($searchText)) {
            $likeCriteria = "(title  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        // Filter by status 
        if(!empty($status_value)){
            
            if($status_value == 'active'){
                $this->db->where('status', 1);
            }

            if($status_value == 'inactive'){
                $this->db->where('status', 0);
            }
        }

        if($status_value == 'trush'){
            $this->db->where('is_delete', 1);
        }else{
            $this->db->where('is_delete', 0);
        }

        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
    ** Get List
    **/
    function Listing($searchText = '', $status_value, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('fees');
        if(!empty($searchText)) {
            $likeCriteria = "(title  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        // Filter by status 
        if(!empty($status_value)){
            
            if($status_value == 'active'){
                $this->db->where('status', 1);
            }

            if($status_value == 'inactive'){
                $this->db->where('status', 0);
            }
        }

        if($status_value == 'trush'){
            $this->db->where('is_delete', 1);
        }else{
            $this->db->where('is_delete', 0);
        }

        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }


    
    /**
    ** Get Item
    **/
    function getItem($group, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('fees');
        $this->db->where('status', 1);
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
    
   
    /**
    ** Get New
    **/
    function addNew($Info)
    {
        $this->db->trans_start();
        $this->db->insert('fees', $Info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
    ** Get Edit
    **/
    function edit($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('fees', $Info);
        return TRUE;
    }
    
    
    /**
    ** Get Info
    **/
    function getInfo($id)
    {
        $this->db->select('*');
        $this->db->from('fees');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
    ** Get Delete
    **/
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('fees');
        return TRUE;
    }

    /**
    ** Get Trash
    **/
    function trash($id) {
        $data = array('is_delete' => 1);
        $this->db->where('id', $id);
        $this->db->update('fees', $data);
        return TRUE;
    }

    /**
    ** Get Active
    **/
    function active($id) {
        $data = array('is_delete' => 0);
        $this->db->where('id', $id);
        $this->db->update('fees', $data);
        return TRUE;
    }



}

  