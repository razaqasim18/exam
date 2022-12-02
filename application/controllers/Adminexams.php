<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/*
 *  @author     : ZWebTheme
 *  date        : October, 2017
 *  Admin - User Management System
 *  http://codecanyon.net/user/zwebtheme
 *  http://support.zwebtheme.com
 */

require APPPATH.'/libraries/BaseController.php';

class Adminexams extends BaseController {
	/**
	 **  Constructor of the class
	 **/
	public function __construct() {
		parent::__construct();
		$this->load->model('exams_model');
		$this->load->database();
		$this->load->library('session');
		$this->isLoggedIn();
	}

	/**
	 ** This function is used to load the  list
	 **/

	function examlist() {
		$exam_list_title = getlang('browser_tab_exam_list_title', 'sys_data');

		if ($this->isAdmin() == TRUE) {
			$this->loadThis();
		} else {
			$searchText         = $this->security->xss_clean($this->input->post('searchText'));
			$data['searchText'] = $searchText;
			$this->load->library('pagination');
			$count   = $this->exams_model->ListingCount($searchText);
			$returns = $this->paginationCompress("exams/", $count, 20);

			$data['examRecords'] = $this->exams_model->Listing($searchText, $returns["page"], $returns["segment"]);

			$this->global['pageTitle'] = $exam_list_title;
			$this->loadViews("/backend/academic/exam/list", $this->global, $data, NULL);
		}
	}

	/**
	 ** Add new exam
	 **/
	public function add($Id = NULL) {
		if ($this->isAdmin() == TRUE) {
			$this->loadThis();
		} else {
			$this->load->library('form_validation');

			if (empty($Id)) {
				$Id = $this->input->post('id');
			}

			$this->form_validation->set_rules('name', 'Exam Name', 'trim|required|max_length[128]');

			if ($this->form_validation->run() == FALSE) {
				if (!empty($Id)) {
					$data['exam_data']         = $this->exams_model->getInfo($Id);
					$this->global['pageTitle'] = getlang('browser_tab_edit_exam', 'sys_data');
					$this->loadViews("/backend/academic/exam/add", $this->global, $data, NULL);
				} else {
					$this->global['pageTitle'] = getlang('browser_tab_add_new_exam', 'sys_data');
					$this->loadViews("/backend/academic/exam/add", $this->global, NULL, NULL);
				}
			} else {
				$name                   = $this->security->xss_clean($this->input->post('name'));
				$department_id          = $this->security->xss_clean($this->input->post('department'));
				$class_id               = $this->security->xss_clean($this->input->post('class_id'));
				$semistar               = $this->security->xss_clean($this->input->post('semistar'));
				$term                   = $this->security->xss_clean($this->input->post('term'));
				$type                   = $this->security->xss_clean($this->input->post('type'));
				$exam_date              = date('Y-m-d', strtotime($this->input->post('exam_date')));
				$form_fillup_start_date = date('Y-m-d', strtotime($this->input->post('form_fillup_start_date')));
				$form_fillup_last_date  = date('Y-m-d', strtotime($this->input->post('form_fillup_last_date')));
				$form_fee               = $this->security->xss_clean($this->input->post('form_fee'));
				$late_fee               = $this->security->xss_clean($this->input->post('late_fee'));

				$exam_info = [
					'name'                   => $name,
					'department_id'          => $department_id,
					'class_id'               => $class_id,
					'semistar'               => $semistar,
					'term'                   => $term,
					'type'                   => $type,
					'exam_date'              => $exam_date,
					'form_fillup_start_date' => $form_fillup_start_date,
					'form_fillup_last_date'  => $form_fillup_last_date,
					'form_fee'               => $form_fee,
					'late_fee'               => $late_fee
				];

				if (!empty($Id)) {
					$result          = $this->exams_model->edit($exam_info, $Id);
					$message_success = getlang('system_data_update_successfully', 'sys_data');
					$message_error   = getlang('system_data_update_failed', 'sys_data');
				} else {
					$result          = $this->exams_model->addNew($exam_info);
					$message_success = getlang('system_data_create_successfully', 'sys_data');
					$message_error   = getlang('system_data_create_failed', 'sys_data');
				}

				if ($result > 0) {
					$this->session->set_flashdata('success', $message_success);
				} else {
					$this->session->set_flashdata('error', $message_error);
				}

				redirect(ADMIN_ALIAS.'/exams');
			}
		}
	}

	/**
	 * This function is used to delete the exams using yearId
	 * @return boolean $result : TRUE / FALSE
	 */
	function delete($Id = NULL) {
		$reponse = array('status' => true);
		$reponse = array(
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash()
		);

		if (empty($Id)) {
			$Id = $this->input->post('Id');
		}

		if ($this->isAdmin() == TRUE) {
			$no_permission = getlang('system_no_permission', 'sys_data');
			$this->session->set_flashdata('error'.$no_permission);
			redirect(ADMIN_ALIAS.'/exams');
		} else {
			$result = $this->exams_model->delete($Id);

			if ($result > 0) {
				$reponse['status'] = true;
			} else {
				$reponse['status'] = false;
			}
		}

		echo json_encode($reponse);
	}

	/**
	 * @param $mode
	 */
	public function form_entries($mode) {
		if ($this->isAdmin() == TRUE) {
			$this->loadThis();
		} else {
			$searchText         = $this->security->xss_clean($this->input->post('searchText'));
			$filterText = [];
			if (isset($_GET['submit'])) {
				$filterText         = $this->security->xss_clean($this->input->get());
				$data['filter']= $filterText;
			}
			
			$data['searchText'] = $searchText;
			$this->load->library('pagination');
			$count   = $this->exams_model->FormEntriesCount($filterText);
			$returns = $this->paginationCompress("exams/form_entries/".$mode, $count, 20);

			$data['form_entries'] = $this->exams_model->getFormEntries($filterText, $returns["page"], $returns["segment"]);

			$this->global['pageTitle'] = 'Exam Form Entries';
            
			if ($mode == 'list') {                
				$this->loadViews("/backend/academic/exam/form_entries", $this->global, $data, NULL);
			} else {               
                $this->export_form_data($data['form_entries']);
            }
		}
	}
	public function loadclasses(){
		$dept_id = $this->input->get('department_id');

		echo $class_list  = getClassByDepartment($dept_id);
	}

	public function loadexams(){
		$class_id = $this->input->get('class_id');

		echo $class_list  = getExamByClass($class_id);

	}

	public function export_form_data($form_entries) {
		
		$fileName    = 'exam_form_data.xlsx';
		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Student Name');
		$sheet->setCellValue('B1', 'Department');
		$sheet->setCellValue('C1', 'Class');
		$sheet->setCellValue('D1', 'Exam');
		$sheet->setCellValue('E1', 'Semester');
		$sheet->setCellValue('F1', 'Term');		
		$sheet->setCellValue('G1', 'Date');
		$sheet->setCellValue('H1', 'Fee');
		$sheet->setCellValue('I1', 'Payment Status');
		$row = 2;

		foreach ($form_entries as $record) {
			$sheet->setCellValue('A'.$row, $record->student_name);
			$sheet->setCellValue('B'.$row, $record->department);
			$sheet->setCellValue('C'.$row, $record->class);
			$sheet->setCellValue('D'.$row, $record->exam);
			$sheet->setCellValue('E'.$row, $record->semistar);
			$sheet->setCellValue('F'.$row, $record->term);
			$sheet->setCellValue('G'.$row, date('d-m-Y', strtotime($record->date)));

            if ($record->late_fee > 0) {
                $total = $record->form_fee + $record->late_fee;
                $total = number_format((float)$total, 2, '.', '');
                $total_fee = $total . " [ Form Fee(" . $record->form_fee . ") + Late Fee(" . $record->late_fee . ") ]";
            } else {
                $total_fee = $record->form_fee;
            }

			$sheet->setCellValue('H'.$row, $total_fee);
			$sheet->setCellValue('I'.$row, $record->payment_status);
			$row++;
		}

		$writer = new Xlsx($spreadsheet);
		$writer->save("uploads/form_entries/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
		redirect(base_url()."/uploads/form_entries/".$fileName);
	}
}

?>