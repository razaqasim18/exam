<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

require APPPATH.'/libraries/FrontEndController.php';

class ExamCard extends FrontEndController {
	/**
	 * This is default constructor of the class
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('attendances_model');
		$this->load->library('session');
		$this->isLoggedIn();
	}

	function ExamCard() {
		$this->db->select('department');
		$this->db->select('class');
		$this->db->select('roll');
		$this->db->from('students');
		$this->db->where('userid', $this->uid);
		$query   = $this->db->get();
		$student = $query->row();

		$dept_id  = $student->department;
		$class_id = $student->class;
		$roll_no  = $student->roll;

		$this->db->select('*');
		$this->db->from('exam_card');
		$this->db->where('department_id', $dept_id);
		$this->db->where('class_id', $class_id);
		$this->db->order_by('semistar');
		$query   = $this->db->get();
		$results = $query->result_array();

		$this->global['pageTitle']        = getlang('site_browser_exam_card_title', 'data');
		$this->global['meta_description'] = '';
		$this->global['meta_tag']         = '';
		$this->global['author']           = '';

		$data['results'] = $results;
		$data['dept']    = $dept_id;
		$data['rollno']  = $roll_no;
		$data['classid'] = $class_id;

		if ($this->isStudent() == TRUE) {
			$this->loadViews('rocky', "frontend/examcard/exam_card", $this->global, $data, NULL);
		}
	}
}
