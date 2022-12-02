<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Accounting_model extends CI_Model
{
    /**
    ** Get Income
    **/
    function getIncome($year)
    {
        $this->db->select('sum(paid_ammount) as Total');
        $this->db->from('payments');
        $this->db->where('YEAR(create_date)', $year);
        $this->db->where('status', 1);
        $query = $this->db->get();
        $result = $query->row();  
        return $result;
    }

    /**
    ** Get Income List
    **/
    function Listing($month, $year)
    {
        $this->db->select('*');
        $this->db->from('payments');
       
        // Filter by month
        if(!empty($month)){
            $this->db->where('month', $month);
        }

        // Filter by year
        if(!empty($year)){
            $this->db->where('year', $year);
        }
        $this->db->where('status', 1);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }


}

  