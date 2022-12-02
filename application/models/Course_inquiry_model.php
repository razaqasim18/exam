<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Course_inquiry_model extends CI_Model
{
    function addNew($class_info)
    {
        $this->db->trans_start();
        $this->db->insert('course_inquiry', $class_info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    function courseListing($searchText = '', $status_value, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('course_inquiry');
        if(!empty($searchText)) {
            $likeCriteria = "(name LIKE '%".$searchText."%'
                            OR email LIKE '%".$searchText."%'
                            OR mobile LIKE '%".$searchText."%'
                            OR nationality LIKE '%".$searchText."%'
                            OR state LIKE '%".$searchText."%'
                            OR city LIKE '%".$searchText."%'
                            OR program LIKE '%".$searchText."%'
                            OR qualification LIKE '%".$searchText."%'
                            OR gender LIKE '%".$searchText."%'
                            OR caste LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        // Filter by ferify user
        // if(!empty($verified_value)){
        //     if($verified_value == 'verified'){
        //         $this->db->where('u.is_verified', 1);
        //     }

        //     if($verified_value == 'unverified'){
        //         $this->db->where('u.is_verified', 0);
        //     }
        // }

        // Filter by status 
        if(!empty($status_value)){
            $this->db->where('status', $status_value);
        }

        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();         
        return $result;
    }
   
    function courseListingcount($searchText = '', $status_value)
    {
        $this->db->select('*');
        $this->db->from('course_inquiry');
        if(!empty($searchText)) {
            $likeCriteria = "(name LIKE '%".$searchText."%'
                    OR email LIKE '%".$searchText."%'
                    OR mobile LIKE '%".$searchText."%'
                    OR nationality LIKE '%".$searchText."%'
                    OR state LIKE '%".$searchText."%'
                    OR city LIKE '%".$searchText."%'
                    OR program LIKE '%".$searchText."%'
                    OR qualification LIKE '%".$searchText."%'
                    OR gender LIKE '%".$searchText."%'
                    OR caste LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        // Filter by ferify user
        // if(!empty($verified_value)){
        //     if($verified_value == 'verified'){
        //         $this->db->where('u.is_verified', 1);
        //     }

        //     if($verified_value == 'unverified'){
        //         $this->db->where('u.is_verified', 0);
        //     }
        // }

        // Filter by status 
        if(!empty($status_value)){
            $this->db->where('status', $status_value);
        }

        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    public function deleteCourse($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('course_inquiry');
        return TRUE;
    }
    
    public function changeStatus($id,$data){
        $this->db->where('id', $id);
        $this->db->update('course_inquiry', $data);
        return TRUE;
    }
    
}    