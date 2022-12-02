<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Acacemic (AcademicController)
 * Academic Class to control all academic related operations.
 * @author : zwebtheme
 * @version : 1.0
 * @since : January 2019
 */
class Academic extends BaseController
{
	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->isLoggedIn();   
    }
    
    /**
     * This is default constructor of the class
     */
    public function index()
    {
        $academic_list_title = getlang('browser_tab_academicyear_list_title', 'sys_data');
        $this->global['pageTitle'] = $academic_list_title;
        $this->loadViews("/backend/academic/default", $this->global, NULL , NULL);
    }
}

?>