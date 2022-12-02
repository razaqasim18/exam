<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Adminpayment extends BaseController
{


    /**
    ** This is default constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payments_model');
        $this->load->database();
        $this->load->library('session');
        $this->isLoggedIn();   
    }
    
    
    /**
    ** Payment list
    **/
    function paymentlist()
    {
        $this->load->library('pagination');

        $month          = $this->security->xss_clean($this->input->post('month'));
        $year           = $this->security->xss_clean($this->input->post('year'));
        $status         = $this->security->xss_clean($this->input->post('status'));
        $data['month']  = $month;
        $data['year']   = $year;
        $data['status'] = $status;

       
        $count = $this->payments_model->ListingCount($this->role, $month, $year, $status);
        $per_item = getConfigItem('item_per_list');
        if(empty($per_item)){$per_item = 50;}
        
		$returns = $this->paginationCompress ( ADMIN_ALIAS."/payments/", $count, $per_item, 3 );
        $data['data'] = $this->payments_model->Listing($this->role, $month, $year, $status, $returns["page"], $returns["segment"]);

        $this->global['pageTitle'] = getlang('browser_tab_title_payment', 'sys_data');
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';
        $this->loadViews("backend/payments/list", $this->global, $data, NULL);
        
    }


    /**
    ** Payment Invoice
    **/
    function invoice($id = null)
    {
        $this->load->library('paypal');
        //$transaction = $this->paypal->onSMS_PaymentTransaction($id);
        $data['paypal'] = $this->paypal;

        $invoive_info = $this->payments_model->getInfo($id);
        $data['invoice'] = $invoive_info;
        $this->global['pageTitle'] = getlang('browser_tab_title_payment_invoice', 'sys_data');
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';
        $this->loadViews("backend/payments/invoice", $this->global, $data, NULL);
    }

    /**
    ** Payment details
    **/
    function details($id = null)
    {
        $this->load->library('paypal');
        //$transaction = $this->paypal->onSMS_PaymentTransaction($id);
        $data['paypal'] = $this->paypal;

        $invoive_info = $this->payments_model->getInfo($id);
        $data['invoice'] = $invoive_info;
        $this->global['pageTitle'] = getlang('browser_tab_title_payment_invoice', 'sys_data');
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';
        $this->loadViews("backend/payments/details", $this->global, $data, NULL);
    }

    /**
    ** Payment process
    **/
    function save()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('student_id','Select Student','required');
        $this->form_validation->set_rules('fees[]','Select Fees','required');
        $this->form_validation->set_rules('paid_ammount','Enter paid ammount','required');
        $this->form_validation->set_rules('payment_method','Select Payment Method','trim|required|numeric');

        if($this->form_validation->run() == FALSE)
            {
                $this->global['pageTitle'] = getlang('browser_tab_payment', 'sys_data');
                $this->global['meta_description'] = '';
                $this->global['meta_tag']         = '';
                $this->global['author']           = '';
                $this->loadViews('rocky', "frontend/payments/add", $this->global, NULL , NULL);
            }
        
        $student_uid    = $this->input->post('student_id');
        $month          = $this->input->post('month');
        $year           = $this->input->post('year');
        $fees           = $this->input->post('fees[]');
        if(!empty($fees)){
            $fees_id        = implode(",", $fees);
        }else{
            $fees_id        = '';
        }
        
        $total_bill     = $this->input->post('total_bill');
        $paid_ammount   = $this->input->post('paid_ammount');
        $due_ammount    = $this->input->post('due_ammount');
        $payment_method = $this->input->post('payment_method');

        $payment_method_alias = getSingledata('payment_method', 'alias', 'id', $payment_method);

        if (!empty($payment_method) && !empty($student_uid) && !empty($total_bill) && !empty($paid_ammount) ) {
            $student_class       = getSingledata('students', 'class', 'userid', $student_uid);
            $student_department  = getSingledata('students', 'department', 'userid', $student_uid);
            $student_roll        = getSingledata('students', 'roll', 'userid', $student_uid);
            $data = array(
                'student_id'           => $student_uid,
                'student_class'        => $student_class, 
                'student_department'   => $student_department,
                'student_roll'         => $student_roll,
                'payment_method'       => $payment_method,
                'month'                => $month,
                'year'                 => $year, 
                'fees_id'              => $fees_id,
                'total_bill'           => $total_bill,
                'paid_ammount'         => $paid_ammount, 
                'due_ammount'          => $due_ammount,
                'uid'                  => $this->uid
                
            );
                   
            $result          = $this->payments_model->addNew($data);
            $message_success = getlang('payment_successfully');
            $message_error   = getlang('payment_failed');
            if($result > 0){
                $this->session->set_flashdata('success', $message_success);
            }else{
                $this->session->set_flashdata('error', $message_error);
            }

            if($payment_method_alias == 'paypal'){
                redirect(base_url().'user/payments/process/'.$result);
            }else{
                redirect(base_url().'user/payments');
            }
            
                
        }
        
    }

    /**
    ** Payment review
    **/
    function review($id = null)
    {
       
        $review_by    = $this->input->post('review_by');
        $status       = $this->input->post('status');
        $comment      = $this->input->post('comment');
        
        if (!empty($id) && !empty($review_by) && !empty($status) && !empty($comment) ) {
            
            $data = array(
                'review_by' => $review_by,
                'comment'   => $comment, 
                'status'    => $status 
            );
                   
            $result          = $this->payments_model->review($data, $id);
            
            if($result > 0){
                $this->session->set_flashdata('success', getlang('system_review_add_success', 'sys_data'));
            }else{
                $this->session->set_flashdata('error', getlang('system_review_add_failed', 'sys_data'));
            }    
        }

        redirect(base_url().ADMIN_ALIAS.'/payments');
        
    }



    
}

