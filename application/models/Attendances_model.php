<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Attendances_model extends CI_Model
{

    /**
    ** Get Item by ID
    **/
    function getItem($id)
    {
        $this->db->select('*');
        $this->db->from('attendance');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    /**
    ** Get Attendance Count
    **/
    function getAttendanceCount()
    {
        $this->db->select('*');
        $this->db->from('attendance');
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
    ** Get Attendance Data
    **/
    function getAttendance($page, $segment)
    {
        $this->db->select('*');
        $this->db->from('attendance');
        
        //$this->db->where('n.status', 1);

        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
    ** Get Add New
    **/
    function addNew($Info)
    {
        $this->db->trans_start();
        $this->db->insert('attendance', $Info);
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
        $this->db->update('attendance', $Info);
        return TRUE;
    }

    /**
    ** Save Attendance info ID
    **/
    function getAttendanceInfoID($aid, $sid){
        $this->db->select('id');
        $this->db->from('attendance_info');
        $this->db->where('attendance_id', $aid);
        $this->db->where('student_id', $sid);
        $query = $this->db->get();
        $results = $query->row();
        if($results){
            $id = $results->id;
        }else{
            $id = '';
        }
        return $id;
    }

    /**
    ** Save Attendance Status New
    **/
    function getStatusNew($id, $data){
        $this->db->trans_start();
        $this->db->insert('attendance_info', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
    ** Save Attendance Status Update
    **/
    function getStatusUpdate($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('attendance_info', $data);
        return TRUE;
    }

}

  