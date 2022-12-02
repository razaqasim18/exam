<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

require APPPATH.'/libraries/FrontEndController.php';

class Exam extends FrontEndController {
	/**
	 * This is default constructor of the class
	 */
	public function __construct() {
		parent::__construct();
        $this->load->model('exams_model');
		$this->load->library('session');
		$this->isLoggedIn();
	}

	public function index() {
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
		$this->db->from('exam');
		$this->db->where('department_id', $dept_id);
		$this->db->where('class_id', $class_id);
		$this->db->where('form_fillup_start_date <=', date('Y-m-d'));
		$this->db->order_by('exam_date');
		$query = $this->db->get();
		$exams = $query->result_array();

		$this->global['pageTitle']        = 'Exam';
		$this->global['meta_description'] = '';
		$this->global['meta_tag']         = '';
		$this->global['author']           = '';

		$data['exams']   = $exams;
		$data['dept']    = $dept_id;
		$data['rollno']  = $roll_no;
		$data['classid'] = $class_id;

		if ($this->isStudent() == TRUE) {
			$this->loadViews('rocky', "frontend/exam/index", $this->global, $data, NULL);
		}
	}

	public function submit_form() {
		$form_fee  = $this->security->xss_clean($this->input->post('form_fee'));
		$late_fee  = $this->input->post('late_fee') ? $this->input->post('late_fee') : 0;
		$total_fee = $form_fee + $late_fee;

		$form_info = [
			'student_id'     => $this->security->xss_clean($this->input->post('student_id')),
			'student_name'   => $this->security->xss_clean($this->input->post('student_name')),
			'department_id'  => $this->security->xss_clean($this->input->post('department_id')),
			'department'     => $this->security->xss_clean($this->input->post('department')),
			'class_id'       => $this->security->xss_clean($this->input->post('class_id')),
			'class'          => $this->security->xss_clean($this->input->post('class')),
			'exam_id'        => $this->security->xss_clean($this->input->post('exam_id')),
			'exam'           => $this->security->xss_clean($this->input->post('exam')),
			'semistar'       => $this->security->xss_clean($this->input->post('semistar')),
			'term'           => $this->security->xss_clean($this->input->post('term')),
			'date'           => date('Y-m-d', strtotime($this->input->post('date'))),
			'form_fee'       => $form_fee,
			'late_fee'       => $late_fee,
			'total_fee'      => $total_fee,
			'payment_status' => 'Success'
		];

		$result          = $this->exams_model->saveExamForm($form_info);
		$message_success = 'Your form has been submitted successfully.';
		$message_error   = 'Something went wrong. The form has not been submitted.';

		if ($result > 0) {
			$this->session->set_flashdata('success', $message_success);
		} else {
			$this->session->set_flashdata('error', $message_error);
		}

		redirect($this->index());
	}
    
}
