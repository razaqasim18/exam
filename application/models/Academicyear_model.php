<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
 *  @author     : ZWebTheme
 *  date        : January, 2019
 *  http://codecanyon.net/user/zwebtheme
 *  http://support.zwebtheme.com
 */

class Academicyear_model extends CI_Model
{
 
     /**
     * This function used to get information by id
     * @param number $id : This is id
     * @return array $result : This is information
     */
    function getInfo($id)
    {
        $this->db->select('*');
        $this->db->from('academic_year');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }


    /**
     * This function is used to get the academic year listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function ListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.Id,  BaseTbl.year');
        $this->db->from('academic_year as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.year  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the academic year listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function Listing($searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('academic_year as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.year  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
   
    
   
    
    /**
     * This function is used to add new academic year to system
     * @return number $insert_id : This is last inserted id
     */
    function addNew($year_info)
    {
        $this->db->trans_start();
        $this->db->insert('academic_year', $year_info);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }


    /**
     * This function is used to update the academic year information
     * @param array $userInfo : This is academic year updated information
     * @param number $userId : This is academic year id
     */
    function edit($year_info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('academic_year', $year_info);
        return TRUE;
    }



    /**
     * This function is used to delete the academic year information
     * @param number $userId : This is academic year id
     * @return boolean $result : TRUE / FALSE
     */
    function delete($Id)
    {
        $this->db->where('id', $Id);
        $this->db->delete('academic_year');
        return TRUE;
    }

}

  