<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class Adminexamcards extends BaseController
{
	/**
	 * This is default constructor of the class
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('examcard_model');
		$this->isLoggedIn();
	}

	/**
	 ** Add/ Edit Function
	 **/
	function add($Id = NULL)
	{
		if ($this->isAdmin() == TRUE) {
			$this->loadThis();
		} else {
			$this->load->library('form_validation');

			if (empty($Id)) {
				$Id = $this->input->post('id');
			}
			$this->form_validation->set_rules('year', 'Year', 'required');
			$this->form_validation->set_rules('department', 'Department', 'required');
			$this->form_validation->set_rules('semester', 'semester', 'required');
			$this->form_validation->set_rules('class_id', 'Class', 'required');
			$this->form_validation->set_rules('paper[]', 'Paper', 'required');


			if ($this->form_validation->run() == FALSE) {

				if (!empty($Id)) {
					$data['examcard_data']       = $this->examcard_model->getInfo($Id);

					$this->global['pageTitle'] = getlang('browser_tab_edit_examcard_title', 'sys_data');
					$this->loadViews("backend/academic/examcard/add", $this->global, $data, NULL);
				} else {


					$this->global['pageTitle'] = getlang('browser_tab_addnew_examcard_title', 'sys_data');
					$this->loadViews("backend/academic/examcard/add", $this->global, NULL, NULL);
				}
			} else {

				$year   = $this->input->post('year');
				$department_id   = $this->input->post('department');
				$class_id   = $this->input->post('class_id');
				$semester       = $this->input->post('semester');
				$paper      = implode(',', $this->input->post('paper[]'));

				$examcard_info = array('year' => $year, 'department_id' => $department_id, 'class_id' => $class_id, 'semistar' => $semester, 'paper' => $paper);

				//  print_r($examcard_info);die;
				if (!empty($Id)) {
					
					$result          = $this->examcard_model->edit($examcard_info, $Id);
					$message_success = getlang('system_data_update_successfully', 'sys_data');
					$message_error   = getlang('system_data_update_failed', 'sys_data');
				} else {
				
					$result          = $this->examcard_model->addNew($examcard_info);
					$message_success = getlang('system_data_create_successfully', 'sys_data');
					$message_error   = getlang('system_data_create_failed', 'sys_data');
				}

				if ($result > 0) {
					$this->session->set_flashdata('success', $message_success);
				} else {
					$this->session->set_flashdata('error', $message_error);
				}

				redirect(ADMIN_ALIAS . '/examcards');
			}
		}
	}

	/**
	 ** This function is used to load the  list
	 **/

	function examcardlist()
	{
		if ($this->isAdmin() == TRUE) {
			$this->loadThis();
		} else {
			$searchText         = $this->security->xss_clean($this->input->post('searchText'));
			$data['searchText'] = $searchText;
			$this->load->library('pagination');
			$count   = $this->examcard_model->ListingCount($searchText);
			$returns = $this->paginationCompress("examcards/", $count, 20);

			$data['examcardRecords'] = $this->examcard_model->Listing($searchText, $returns["page"], $returns["segment"]);

			$this->global['pageTitle'] = getlang('browser_tab_examcard_list_title', 'sys_data');
			$this->loadViews("/backend/academic/examcard/list", $this->global, $data, NULL);
		}
	}

	/**
	 * This function is used to delete the using id
	 * @return boolean $result : TRUE / FALSE
	 */
	function delete($Id = NULL)
	{
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
			redirect(ADMIN_ALIAS . '/examcards');
		} else {
			$result = $this->examcard_model->delete($Id);
			if ($result > 0) {
				$reponse['status'] = true;
			} else {
				$reponse['status'] = false;
			}
		}

		echo json_encode($reponse);
	}
}
