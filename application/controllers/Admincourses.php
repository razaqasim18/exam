<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

require APPPATH.'/libraries/BaseController.php';

class Admincourses extends BaseController {
	/**
	 * This is default constructor of the class
	 */
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('courses_model');
		$this->isLoggedIn();
	}

	/**
	 ** Add/ Edit Function
	 **/
	function add($Id = NULL) {
		if ($this->isAdmin() == TRUE) {
			$this->loadThis();
		} else {
			$this->load->library('form_validation');

			if (empty($Id)) {
				$Id = $this->input->post('id');
			}

			$this->form_validation->set_rules('name', 'Course Name', 'trim|required|max_length[128]');

			//$this->form_validation->set_rules('subject_name','Subject Name','');

			if ($this->form_validation->run() == FALSE) {
				if (!empty($Id)) {
					$data['course_data']       = $this->courses_model->getInfo($Id);
					$this->global['pageTitle'] = getlang('browser_tab_edit_course_title', 'sys_data');
					$this->loadViews("backend/academic/courses/add", $this->global, $data, NULL);
				} else {
					$this->global['pageTitle'] = getlang('browser_tab_addnew_course_title', 'sys_data');
					$this->loadViews("backend/academic/courses/add", $this->global, NULL, NULL);
				}
			} else {
				$class_id   = $this->input->post('class_id');
				$subject_id = $this->input->post('subject_id');
				$name       = $this->input->post('name');
				$code       = $this->input->post('code');

				$course_info = array('class_id' => $class_id, 'subject_id' => $subject_id, 'name' => $name, 'code' => $code);

				if (!empty($Id)) {
					$result          = $this->courses_model->edit($course_info, $Id);
					$message_success = getlang('system_data_update_successfully', 'sys_data');
					$message_error   = getlang('system_data_update_failed', 'sys_data');
				} else {
					$result          = $this->courses_model->addNew($course_info);
					$message_success = getlang('system_data_create_successfully', 'sys_data');
					$message_error   = getlang('system_data_create_failed', 'sys_data');
				}

				if ($result > 0) {
					$this->session->set_flashdata('success', $message_success);
				} else {
					$this->session->set_flashdata('error', $message_error);
				}

				redirect(ADMIN_ALIAS.'/courses');
			}
		}
	}

	/**
	 ** This function is used to load the  list
	 **/

	function courselist() {
		if ($this->isAdmin() == TRUE) {
			$this->loadThis();
		} else {
			$searchText         = $this->security->xss_clean($this->input->post('searchText'));
			$data['searchText'] = $searchText;
			$this->load->library('pagination');
			$count   = $this->courses_model->ListingCount($searchText);
			$returns = $this->paginationCompress("courses/", $count, 20);

			$data['coursesRecords'] = $this->courses_model->Listing($searchText, $returns["page"], $returns["segment"]);

			$this->global['pageTitle'] = getlang('browser_tab_courses_list_title', 'sys_data');
			$this->loadViews("/backend/academic/courses/list", $this->global, $data, NULL);
		}
	}

	/**
	 * This function is used to delete the using id
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
			$this->session->set_flashdata('error', $no_permission);
			redirect(ADMIN_ALIAS.'/courses');
		} else {
			$result = $this->courses_model->delete($Id);
			if ($result > 0) {
				$reponse['status'] = true;
			} else {
				$reponse['status'] = false;
			}
		}

		echo json_encode($reponse);
	}

	function loadsubjects() {
		$class_id = $this->input->get('class_id');
		echo $subject_list  = getSubjectsByClass($class_id, 0);
		
	}
}

?>