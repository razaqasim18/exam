<?php

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Getter extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
        $this->load->database();
    }
    

    public function class_get() {
        $result = $this->db->from('class')->get()->result_array();
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    public function department_get() {
        $result = $this->db->from('departments')->get()->result_array();
        $this->response($result, REST_Controller::HTTP_OK);
    }  
    
    public function year_get() {
        $result = $this->db->from('academic_year')->get()->result_array();
        $this->response($result, REST_Controller::HTTP_OK);
    } 
   
}