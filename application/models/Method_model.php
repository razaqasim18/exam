<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : zwebtheme
*  School Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

class Method_model extends CI_Model
{
    /**
    ** Get List Count
    **/
    function ListingCount()
    {
        $this->db->select('id, name');
        $this->db->from('payment_method');
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
    ** Get List
    **/
    function Listing($page, $segment)
    {
        $this->db->select('*');
        $this->db->from('payment_method');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }



    /**
    ** Get Edit
    **/
    function edit($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('payment_method', $Info);
        return TRUE;
    }
    
    
    /**
    ** Get Info
    **/
    function getInfo($id)
    {
        $this->db->select('*');
        $this->db->from('payment_method');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    



}

  