<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Exams_model extends CI_Model {
	/**
	 * This function used to get information by id
	 * @param number $id : This is id
	 * @return array $result : This is information
	 */
	function getInfo($id) {
		$this->db->select('*');
		$this->db->from('exam');
		$this->db->where('id', $id);
		$query = $this->db->get();

		return $query->result();
	}

	/**
	 * This function is used to get the class listing count
	 * @param string $searchText : This is optional search text
	 * @return number $count : This is row count
	 */
	function ListingCount($searchText = '') {
		$this->db->select('BaseTbl.Id,  BaseTbl.name');
		$this->db->from('exam as BaseTbl');

		if (!empty($searchText)) {
			$likeCriteria = "(BaseTbl.name  LIKE '%".$searchText."%')";
			$this->db->where($likeCriteria);
		}

		$query = $this->db->get();

		return $query->num_rows();
	}

	function FormEntriesCount($filterText = array()) {
		$this->db->select('BaseTbl.id,  BaseTbl.exam');
		$this->db->from('form_entries as BaseTbl');

		if (!empty($filterText['department'])) {
			$likeCriteria = "(BaseTbl.department_id  LIKE '%".$filterText['department']."%')";
			$this->db->where($likeCriteria);
		}
		if (!empty($filterText['class_id'])) {
			$likeCriteria = "(BaseTbl.class_id  LIKE '%".$filterText['class_id']."%')";
			$this->db->where($likeCriteria);
		}
		if (!empty($filterText['exam_name'])) {
			$likeCriteria = "(BaseTbl.exam_id  LIKE '%".$filterText['exam_name']."%')";
			$this->db->where($likeCriteria);
		}
		if (!empty($filterText['semistar'])) {
			$likeCriteria = "(BaseTbl.semistar  LIKE '%".$filterText['semistar']."%')";
			$this->db->where($likeCriteria);
		}
		if (!empty($filterText['term'])) {
			$likeCriteria = "(BaseTbl.term  LIKE '%".$filterText['term']."%')";
			$this->db->where($likeCriteria);
		}

		$query = $this->db->get();

		return $query->num_rows();
	}

	/**
	 * This function is used to get the exam listing count
	 * @param string $searchText : This is optional search text
	 * @param number $page : This is pagination offset
	 * @param number $segment : This is pagination limit
	 * @return array $result : This is result
	 */
	function Listing($searchText = '', $page, $segment) {
		$this->db->select('*');
		$this->db->from('exam as BaseTbl');

		if (!empty($searchText)) {
			$likeCriteria = "(BaseTbl.name  LIKE '%".$searchText."%')";
			$this->db->where($likeCriteria);
		}

		$this->db->limit($page, $segment);
		$query = $this->db->get();

		$result = $query->result();

		return $result;
	}

	/**
	 * This function is used to add new exam to system
	 * @return number $insert_id : This is last inserted id
	 */
	function addNew($exam_info) {
		$this->db->trans_start();
		$this->db->insert('exam', $exam_info);

		$insert_id = $this->db->insert_id();

		$this->db->trans_complete();

		return $insert_id;
	}

	/**
	 * @param $form_info
	 * @return mixed
	 */
	function saveExamForm($form_info) {
		$this->db->trans_start();
		$this->db->insert('form_entries', $form_info);

		$insert_id = $this->db->insert_id();

		$this->db->trans_complete();

		return $insert_id;
	}

	/**
	 * @param $searchText
	 * @param $page
	 * @param $segment
	 * @return mixed
	 */
	function getFormEntries($filterText = [], $page, $segment) {
		$this->db->select('*');
		$this->db->from('form_entries as BaseTbl');

		if (!empty($filterText['department'])) {
			$likeCriteria = "(BaseTbl.department_id  LIKE '%".$filterText['department']."%')";
			$this->db->where($likeCriteria);
		}
		if (!empty($filterText['class_id'])) {
			$likeCriteria = "(BaseTbl.class_id  LIKE '%".$filterText['class_id']."%')";
			$this->db->where($likeCriteria);
		}
		if (!empty($filterText['exam_name'])) {
			$likeCriteria = "(BaseTbl.exam_id  LIKE '%".$filterText['exam_name']."%')";
			$this->db->where($likeCriteria);
		}
		if (!empty($filterText['semistar'])) {
			$likeCriteria = "(BaseTbl.semistar  LIKE '%".$filterText['semistar']."%')";
			$this->db->where($likeCriteria);
		}
		if (!empty($filterText['term'])) {
			$likeCriteria = "(BaseTbl.term  LIKE '%".$filterText['term']."%')";
			$this->db->where($likeCriteria);
		}

		$this->db->order_by("date", "desc");
		$this->db->limit($page, $segment);
		$query = $this->db->get();

		$result = $query->result();

		return $result;
	}

	/**
	 * This function is used to update the exam information
	 * @param array $userInfo : This is users updated information
	 * @param number $userId : This is class id
	 */
	function edit($exam_info, $id) {
		$this->db->where('id', $id);
		$this->db->update('exam', $exam_info);

		return TRUE;
	}

	/**
	 * This function is used to delete the user information
	 * @param number $userId : This is user id
	 * @return boolean $result : TRUE / FALSE
	 */
	function delete($Id) {
		$this->db->where('id', $Id);
		$this->db->delete('exam');

		return TRUE;
	}
}
