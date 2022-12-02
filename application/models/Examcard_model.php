<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
 *  @author     : ZWebTheme
 *  date        : January, 2019
 *  http://codecanyon.net/user/zwebtheme
 *  http://support.zwebtheme.com
 */

class Examcard_model extends CI_Model
{
 
     /**
     * This function used to get information by id
     * @param number $id : This is id
     * @return array $result : This is information
     */
    function getInfo($id)
    {
        $this->db->select('*');
        $this->db->from('exam_card');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }


    /**
     * This function is used to get the class listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function ListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.Id');
        $this->db->from('exam_card as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the class listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function Listing($searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('exam_card as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
   
    
   
    
    /**
     * This function is used to add new class to system
     * @return number $insert_id : This is last inserted id
     */
    function addNew($class_info)
    {
        $this->db->trans_start();
        $this->db->insert('exam_card', $class_info);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }


    /**
     * This function is used to update the class information
     * @param array $userInfo : This is class updated information
     * @param number $userId : This is class id
     */
    function edit($class_info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('exam_card', $class_info);
        return TRUE;
    }



    /**
     * This function is used to delete the class information
     * @param number $userId : This is class id
     * @return boolean $result : TRUE / FALSE
     */
    function delete($Id)
    {
        $this->db->where('id', $Id);
        $this->db->delete('exam_card');
        return TRUE;
    }

}

  