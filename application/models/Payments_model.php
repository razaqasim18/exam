<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Payments_model extends CI_Model
{
    /**
    ** Get Listing Count
    **/
    function ListingCount($group, $month, $year, $status)
    {
        $this->db->select('*');
        $this->db->from('payments');

        if($group == ROLE_PARENT){
            $this->db->where('uid', $this->uid);
        }elseif($group == ROLE_TEACHER){
            
        }elseif($group == ROLE_STUDENT){
            $this->db->where('uid', $this->uid);
        }else{

        }
        
        // Filter by month
        if(!empty($month)){
            $this->db->where('month', $month);
        }

        // Filter by year
        if(!empty($year)){
            $this->db->where('year', $year);
        }

        // Filter by status
        if(!empty($status)){
            $this->db->where('status', $status);
        }

        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
    ** Get listing
    **/
    function Listing($group, $month, $year, $status, $page, $segment)
    {

        $this->db->select('*');
        $this->db->from('payments');

        if($group == ROLE_PARENT){
            $this->db->where('uid', $this->uid);
        }elseif($group == ROLE_TEACHER){
            
        }elseif($group == ROLE_STUDENT){
            $this->db->where('uid', $this->uid);
        }else{

        }
        
        // Filter by month
        if(!empty($month)){
            if($month == 'all'){

            }else{
                $this->db->where('month', $month);
            }
            
        }

        // Filter by year
        if(!empty($year)){
            $this->db->where('year', $year);
        }

        // Filter by status

        if($status == 'all'){
            
        }elseif ($status == 'p') {
            $this->db->where('status', 0);
        }else{
            $this->db->where('status', $status);
        }

        $this->db->limit($page, $segment);
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
        
        if(!empty($searchText)) {
            $likeCriteria = "(name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('roleId', ROLE_STUDENT);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
    
    /**
    ** Get Store
    **/
    function addNew($Info)
    {
        $this->db->trans_start();
        $this->db->insert('payments', $Info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
    ** Get Update
    **/
    function edit($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('payments', $Info);
        return TRUE;
    }

    /**
    ** Get review
    **/
    function review($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('payments', $Info);
        return TRUE;
    }
    
    
    /**
    ** Get Info
    **/
    function getInfo($id)
    {
        $this->db->select('*');
        $this->db->from('payments');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    



    /**
    ** Get Bill 
    **/
    function getBill($bill_arry){
        
        $total_fee =0;
        if($bill_arry){
            foreach ($bill_arry as $bills){
                $bill_id = $bills;

                $this->db->select('fee');
                $this->db->from('fees');
                $this->db->where('id', $bill_id);
                $query = $this->db->get();
                $results = $query->row();
                if($results){
                    $fee = $results->fee;
                }else{
                    $fee = 0;
                }
                
                $total_fee += $fee;
            }
        }
                
        return $total_fee;
    }


}

  