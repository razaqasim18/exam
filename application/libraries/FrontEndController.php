<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); 

class FrontEndController extends CI_Controller {
	
	/**
	** This function is used to load the set of views
	**/
    function loadViews($template = "", $viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){
        $this->load->view('frontend/includes/templates/'.$template.'/header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('frontend/includes/templates/'.$template.'/footer', $footerInfo);
    }


    /**
	** This function used to check the user is logged in or not
	**/
	function isLoggedIn() {
		$isLoggedIn = $this->session->userdata ( 'isLoggedIn' );
		
		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
			redirect ( 'login' );
		} else {
			$this->role = $this->session->userdata ( 'role' );
			$this->uid = $this->session->userdata ( 'userId' );
			$this->name = $this->session->userdata ( 'name' );
			$this->email = $this->session->userdata ( 'email' );
			$this->roleText = $this->session->userdata ( 'roleText' );
			$this->lastLogin = $this->session->userdata ( 'lastLogin' );

			$this->global ['name'] = $this->name;
			$this->global ['role'] = $this->role;
			$this->global ['role_text'] = $this->roleText;
			$this->global ['last_login'] = $this->lastLogin;
			$this->global ['uid'] = $this->uid;
		}
	}

	/**
	** This function is used to check the access teacher
	**/
	function isTeacher() {
		if ($this->role == ROLE_TEACHER) {
			return true;
		}else{
			return false;
		}
	}

	/**
	** This function is used to check the access student
	**/
	function isStudent() {
		if ($this->role == ROLE_STUDENT) {
			return true;
		}else{
			return false;
		}
	}

	/**
	** This function is used to check the access parent
	**/
	function isParent() {
		if ($this->role == ROLE_PARENT) {
			return true;
		}else{
			return false;
		}
	}

	/**
	** This function is used to logged out user from system
	**/
	function logout() {
		
		$this->session->sess_destroy ();
		redirect ( 'login' );
	}

	/**
	** This function used provide the pagination resources
	**/
	function paginationCompress($link, $count, $perPage = 10, $segment = SEGMENT) {
		$this->load->library ( 'pagination' );

		$config ['base_url'] = base_url () . $link;
		$config ['total_rows'] = $count;
		$config ['uri_segment'] = $segment;
		$config ['per_page'] = $perPage;
		$config ['num_links'] = 5;
		$config ['full_tag_open'] = '<nav><ul class="pagination">';
		$config ['full_tag_close'] = '</ul></nav>';
		$config ['first_tag_open'] = '<li class="arrow">';
		$config ['first_link'] = 'First';
		$config ['first_tag_close'] = '</li>';
		$config ['prev_link'] = 'Previous';
		$config ['prev_tag_open'] = '<li class="arrow">';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_link'] = 'Next';
		$config ['next_tag_open'] = '<li class="arrow">';
		$config ['next_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li class="active"><a href="#">';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li class="arrow">';
		$config ['last_link'] = 'Last';
		$config ['last_tag_close'] = '</li>';
	
		$this->pagination->initialize ( $config );
		$page = $config ['per_page'];
		$segment = $this->uri->segment ( $segment );
	
		return array (
				"page" => $page,
				"segment" => $segment
		);
	}

	
	
}