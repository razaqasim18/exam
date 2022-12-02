<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

class Configuration_model extends CI_Model
{
   /**
     * This function used to get information by id
     * @param number $id : This is id
     * @return array $result : This is information
     */
    function getInfo($id)
    {
        $this->db->select('*');
        $this->db->from('config');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }
   
    
    /**
     * This function is used to update the information
     * @param array $info : This is updated information
     * @param number $Id : This is id
     */
    function edit($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('config', $Info);
        return TRUE;
    }



}

  