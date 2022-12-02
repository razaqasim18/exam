<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
 *  @author     : ZWebTheme
 *  date        : October, 2017
 *  Admin User Management System
 *  http://codecanyon.net/user/zwebtheme
 *  http://support.zwebtheme.com
 */

class Results_model extends CI_Model
{
    
   
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addnew($result_comment)
    {
        $this->db->trans_start();
        $this->db->insert('result_comments', $result_comment);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
    ** Check Exit Comment $class_id, $roll_id, $exam_id, $tid
    **/
    function checkExitComment($class_id, $roll_id, $exam_id, $tid){
        $this->db->select("*");
        $this->db->from("result_comments");
        $this->db->where("class", $class_id);   
        $this->db->where("eid", $exam_id);   
        $this->db->where("tid", $tid);   
        $this->db->where("roll", $roll_id);   
        $query = $this->db->get();
        return $query->result();
    }

    /**
    ** Update Result Comment
    **/
    function update($result_comment, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('result_comments', $result_comment);
        return TRUE;
    }
}

  