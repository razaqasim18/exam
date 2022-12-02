<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Gcategory_model extends CI_Model
{

    /**
    ** Get List Count
    **/
    function ListingCount($searchText = '', $status_value)
    {
        $this->db->select('id, name');
        $this->db->from('grade_category');
        if(!empty($searchText)) {
            $likeCriteria = "(name  LIKE '%".$searchText."%')";
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

        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
    ** Get List
    **/
    function Listing($searchText = '', $status_value, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('grade_category');
        if(!empty($searchText)) {
            $likeCriteria = "(name  LIKE '%".$searchText."%')";
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


        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }


    /**
    ** Get Item by ID
    **/
    function getInfo($id)
    {
        $this->db->select('*');
        $this->db->from('grade_category');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }


    /**
    ** Get Add New
    **/
    function addNew($Info)
    {
        $this->db->trans_start();
        $this->db->insert('grade_category', $Info);
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
        $this->db->update('grade_category', $Info);
        return TRUE;
    }
  

    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('grade_category');
        return TRUE;
    }

}

  