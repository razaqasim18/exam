<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

class My404 extends CI_Controller {

	/**
    ** This is default constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	public function index()
	{
        $this->load->view('404');
	}
}
