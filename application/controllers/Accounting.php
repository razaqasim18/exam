<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


require APPPATH . '/libraries/BaseController.php';

class Accounting extends BaseController
{


    /**
    ** This is default constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('accounting_model');
        $this->load->database();
        $this->load->library('session');
        $this->isLoggedIn();   
    }
    
    
    /**
    ** Set Index
    **/
    function index()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{   
            // Get Current Year
            $current_year =date("Y");
            $data['total_income']  = $this->accounting_model->getIncome($current_year);
            $this->global['pageTitle'] = getlang('browser_tab_accounting_dashboard', 'sys_data');
            $this->loadViews("/backend/accounting/default", $this->global, $data, NULL);
        }
    }

    
    /**
    ** Set Income
    **/
    function incomes()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{   

            $month          = $this->security->xss_clean($this->input->post('month'));
            $year           = $this->security->xss_clean($this->input->post('year'));
            $data['month']  = $month;
            $data['year']   = $year;

            // Get Current Year
            $cy = intVal(date('Y'));
            if(empty($year)){
                $year = getSingledata('academic_year', 'id', 'year', $cy);
            }
            
            if(empty($month)){
                $month = intVal(date('m'));
            }elseif ($month == 'all') {
                $month = 0;
            }

            $data['data']  = $this->accounting_model->Listing($month, $year);
            $this->global['pageTitle'] = getlang('browser_tab_incomes', 'sys_data');
            $this->loadViews("/backend/accounting/income", $this->global, $data, NULL);
        }
    }
    
}

