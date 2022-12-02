<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); 

class BaseController extends CI_Controller {

	protected $role = '';
	protected $userid = '';
	protected $name = '';
	protected $avatar = '';
	protected $roleText = '';
	protected $global = array ();
	protected $lastLogin = '';
	
	/**
	** Response
	**/
	public function response($data = NULL) {
		$this->output->set_status_header ( 200 )->set_content_type ( 'application/json', 'utf-8' )->set_output ( json_encode ( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) )->_display ();
		exit ();
	}
	
	/**
	** This function used to check the user is logged in or not
	**/
	function isLoggedIn() {
		$isLoggedIn = $this->session->userdata ( 'isLoggedIn' );
		
		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
			redirect ( 'admin' );
		} else {
			$this->role = $this->session->userdata ( 'role' );
			$this->userid = $this->session->userdata ( 'userId' );
			$this->name = $this->session->userdata ( 'name' );
			$this->avatar = $this->session->userdata ( 'avatar' );
			$this->roleText = $this->session->userdata ( 'roleText' );
			$this->lastLogin = $this->session->userdata ( 'lastLogin' );
			
			$this->global ['userid'] = $this->userid;
			$this->global ['name'] = $this->name;
			$this->global ['role'] = $this->role;
			$this->global ['role_text'] = $this->roleText;
			$this->global ['avatar'] = $this->avatar;
			$this->global ['last_login'] = $this->lastLogin;
		}
		
	}
	
	/**
	** This function is used to check the access
	**/
	function isAdmin() {
		if ($this->role == ROLE_SUPPER_ADMIN || $this->role == ROLE_ADMIN ) {
			return false;
		}else{
			return true;
		}
	}

	
	/**
	** This function is used to check the access
	**/
	function isTicketter() {
		if ($this->role != ROLE_ADMIN) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	** This function is used to load the set of views
	**/
	function loadThis() {
		$this->global ['pageTitle'] = 'Access Denied';
		$this->load->view ( 'backend/includes/header', $this->global );
		$this->load->view ( 'backend/access' );
		$this->load->view ( 'backend/includes/footer' );
	}
	
	/**
	** This function is used to logged out user from system
	**/
	function logout() {
		
		$this->session->sess_destroy ();
		redirect (ADMIN_ALIAS);
	}

	/**
    ** This function used to load views
    **/
    function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){
    	
        $this->load->view('backend/includes/header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('backend/includes/footer', $footerInfo);
    }
	
	/**
	** This function used provide the pagination resources
	**/
	function paginationCompress($link, $count, $perPage = 10, $segment = SEGMENT) {
		$this->load->library ( 'pagination' );

		$config ['base_url']        = base_url () . $link;
		$config ['total_rows']      = $count;
		$config ['uri_segment']     = $segment;
		$config ['per_page']        = $perPage;
		$config ['num_links']       = 5;
		$config ['full_tag_open']   = '<nav><ul class="pagination">';
		$config ['full_tag_close']  = '</ul></nav>';
		$config ['first_tag_open']  = '<li class="arrow">';
		$config ['first_link']      = 'First';
		$config ['first_tag_close'] = '</li>';
		$config ['prev_link']       = 'Previous';
		$config ['prev_tag_open']   = '<li class="arrow">';
		$config ['prev_tag_close']  = '</li>';
		$config ['next_link']       = 'Next';
		$config ['next_tag_open']   = '<li class="arrow">';
		$config ['next_tag_close']  = '</li>';
		$config ['cur_tag_open']    = '<li class="active"><a href="#">';
		$config ['cur_tag_close']   = '</a></li>';
		$config ['num_tag_open']    = '<li>';
		$config ['num_tag_close']   = '</li>';
		$config ['last_tag_open']   = '<li class="arrow">';
		$config ['last_link']       = 'Last';
		$config ['last_tag_close']  = '</li>';
	
		$this->pagination->initialize ( $config );
		$page    = $config ['per_page'];
		$segment = $this->uri->segment ( $segment );
	
		return array (
				"page" => $page,
				"segment" => $segment
		);
	}
}