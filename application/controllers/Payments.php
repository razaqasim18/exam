<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/FrontEndController.php';

class Payments extends FrontEndController
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
        
        
		$returns = $this->paginationCompress ("user/payments/", $count, $per_item, 3 );
        $data['data'] = $this->payments_model->Listing($this->role, $month, $year, $status, $returns["page"], $returns["segment"]);

        $this->global['pageTitle'] = getlang('site_browser_payment_list_title', 'data');
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';
        $this->loadViews('rocky', "frontend/payments/default", $this->global, $data , NULL);
    }

    /**
    ** New Payment form
    **/
    function add()
    {
        $this->global['pageTitle'] = getlang('site_browser_addnew_payment_title', 'data');
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';
        $this->loadViews('rocky', "frontend/payments/add", $this->global, NULL , NULL);
    }

    

    /**
    ** Check Bill
    **/
    function bill(){
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );

        $html = '';

        $value = $this->input->post('val');
        $bill= $this->payments_model->getBill($value);

        if(!empty($bill)){
            $bill_value = '<p style="color: green;font-size: 150%;" id="total_bill"> '.number_format($bill,2).'</p>';
            $bill_value .= '<input type="hidden" id="total_bill_value" name="total_bill" value="'.$bill.'" />';
            $html .= $bill_value;
        }else{
            $html .= "<p style='color: red;'>'".getlang('site_select_payment_fees', 'data')."' </p>";
        }

        

        $reponse['html'] = $html;
        echo json_encode($reponse);
    }

    /**
    ** Duse Ammount
    **/
    function due(){
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );

        $html = '';

        $bill_arry = $this->input->post('val');
        $bill= $this->payments_model->getBill($bill_arry);
        if(!empty($bill)){
            $bill_value = '<p style="color: red;font-size: 150%;" id="due_bill"> '.number_format($bill,2).'</p>';
            $bill_value .= '<input type="hidden" name="due_ammount" value="'.$bill.'" />';
            $html .= $bill_value;
        }else{
            $html .= "<p style='color: red;'>'".getlang('site_select_payment_type', 'data')."' </p>";
        }
        
        $reponse['html'] = $html;
        echo json_encode($reponse);
    }

    /**
    ** Payment process
    **/
    function process($id = null)
    {

        
        if(!empty($id)){
            $this->load->library('paypal');

            $method     = $this->input->get('method');

            if($method == 'processPayment'){
                $post       = $this->input->post();
                // // add post field exception
                if( !count($post) ) $post = @file_get_contents('php://input');  
                $html = $this->paypal->onSMS_PaymentProcesspayment($post);
                echo $html[0];
            }else{


                $token_name = $this->security->get_csrf_token_name();
                $token_hash = $this->security->get_csrf_hash();

                $payment_data = $this->payments_model->getInfo($id);
                if (isset($payment_data))
                {
                   $fees_id = $payment_data->fees_id;
                   $paid_ammount = $payment_data->paid_ammount;
                   $payment_method = $payment_data->payment_method;
                }

                $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                $cancel_link = $actual_link;
                $url = $actual_link.'?method=processPayment&processor=paypal';

                $vars    = new stdClass();
                $vars->token_name      = $token_name;
                $vars->token_hash      = $token_hash;
                $vars->order_id      = $id;
                $vars->user_id       = $this->uid;
                $vars->item_name     = '';
                $items = explode(',', $fees_id);
                foreach ($items as $key => $value){
                    $vars->item_name .= getSingledata('fees', 'title', 'id', $value);
                }

                $vars->item_name = substr($vars->item_name, 0, strlen($vars->item_name)-2);

                $vars->cancel_return = $cancel_link;

                //processPayment
                $vars->return = $vars->notify_url = $vars->url = $url;
                $vars->currency_code = getConfigItem('currency_code');
                $vars->amount = $paid_ammount;
                    

                $paypal_html = $this->paypal->PaymentGetHTML($vars, $payment_method);
                $data['paypal'] = $paypal_html;

                $this->global['pageTitle'] = getlang('site_browser_payment_process_title', 'data');
                $this->global['meta_description'] = '';
                $this->global['meta_tag']         = '';
                $this->global['author']           = '';
                $this->loadViews('rocky', "frontend/payments/process", $this->global, $data , NULL);
            }
        }else{
            $this->session->set_flashdata('error', getlang('site_payment_not_fount', 'data'));
            redirect(base_url().'user/payments');
        }

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
        $this->global['pageTitle'] = getlang('site_borwser_payment_invoice_title', 'data');
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';
        $this->loadViews('rocky', "frontend/payments/invoice", $this->global, $data , NULL);
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
        $this->global['pageTitle'] = getlang('site_borwser_payment_invoice_title', 'data');
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';
        $this->loadViews('rocky', "frontend/payments/details", $this->global, $data , NULL);
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
                $this->global['pageTitle'] = getlang('site_borwser_payment_title', 'data');
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
            $message_success = getlang('site_payment_successfully', 'data');
            $message_error   = getlang('site_payment_failed', 'data');
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
                $this->session->set_flashdata('success', getlang('site_review_add_success', 'data'));
            }else{
                $this->session->set_flashdata('error', getlang('site_review_add_failed', 'data'));
            }    
        }

        redirect(base_url().'user/payments');
        
    }


    /**
    ** Find Student
    **/
    function findstudent(){
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
            );

        $html = '';

        $value = $this->input->post('val');
        $student_list = $this->payments_model->getStudentID($value);
        foreach($student_list as $item){
            if(!empty($item->avatar)){
                $img_path = site_url('/uploads/students/').$item->avatar;
            }else {
                $img_path = site_url('/uploads/users').'/avator.png';
            }
                     
            $onclick = "onclick=\"lookstudent('".$item->name."','".$item->userId."');\"";
            $html .='<div class="row searchresult_ajax" '.$onclick.' style="margin: 5px 0;cursor: pointer;">';
            $html .='<div class="col-sm-2"><img src="'.$img_path.'" alt="" width="30px"height: 30px; style="margin: 3px;" /></div>';
            $html .='<div class="col-sm-10 pl-0" >'.$item->name.'</div>';
            $html .='</div>';
        }

        $reponse['html'] = $html;
        echo json_encode($reponse);
    }
    

    
}

