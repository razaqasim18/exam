<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/paypal/helper.php');

class Paypal {
	
    

	/*
	* method buildLayout
	* @vars = object with product, order, user info
	* @layout = tmpl name
	* Builds the layout to be shown, along with hidden fields.
	* @return html
	*/
	function buildLayout($vars, $layout = 'default' )
	{
		// Load the layout & push variables
		ob_start();
		$layout = dirname(__FILE__) . '/paypal/default.php';
		include($layout);
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}




	/*
	* method onSMS_PaymentGetHTML
	* on transection process this function is being used to get html from component
	* @dependent : self::buildLayout()
	* @return html for view
	* @vars : passed from component, all info regarding payment n order
	*/
	function PaymentGetHTML($vars, $payment_method_id)
	{
		
		$business_email = getPaymentConfig($payment_method_id, 'business');
		$sandbox        = getPaymentConfig($payment_method_id, 'sandbox');
		$secure_post    = getPaymentConfig($payment_method_id, 'secure_post');

		if(!empty($sandbox)){
			$sandbox = 1;
		}

		if(!empty($secure_post)){
			$secure_post = 1;
		}

		$vars->sandbox 			= $sandbox;
		$vars->action_url 		= PaypalHelper::buildPaymentSubmitUrl($secure_post , $sandbox);
		$vars->business         = $business_email;

		// If component does not provide cmd
		if (empty($vars->cmd)){
			$vars->cmd = '_xclick';
		}

		//Take this receiver email address from plugin if component not provided it
		//if(empty($vars->business)) $vars->business = $this->params->get('business');
        $html = $this->buildLayout($vars);
		return $html;
	}
	

	/*
	* method onSMS_PaymentProcesspayment
	* used when we recieve payment from site or thurd party
	* @data : the necessary info recieved from form about payment
	* @return payment process final status
	*/
	function onSMS_PaymentProcesspayment($data)
	{
        $CI =& get_instance();

		$payer_email    = $data['payer_email'];
		$payer_id       = $data['payer_id'];
		$payer_status   = $data['payer_status'];
		$transaction_id = $data['txn_id'];
		$total_paid_amt = $data['mc_gross'];
		$payment_status = $data['payment_status'];
		$payment_type   = $data['payment_type'];
		$txn_type       = $data['txn_type'];
		$payment_date   = $data['payment_date'];
		$order_id       = $data['custom'];

		$paypal_data = array(
            'payer_email'     => $payer_email,
            'payer_id'        => $payer_id, 
            'payer_status'    => $payer_status,
            'transaction_id'  => $transaction_id,
            'total_paid_amt'  => $total_paid_amt,
            'payment_status'  => $payment_status,
            'payment_type'    => $payment_type, 
            'txn_type'        => $txn_type,
            'payment_date'    => $payment_date,
            'order_id'        => $order_id
        );

		$CI->db->trans_start();
        $CI->db->insert('paypal', $paypal_data);
        $insert_id = $CI->db->insert_id();
        $CI->db->trans_complete();
        
        if($payment_status == 'Completed'){
            $Info = array('status' => 1, 'txn_id' => $transaction_id);
        	$CI->db->where('id', $order_id);
            $CI->db->update('payments', $Info);
        }

        $message_success = 'Your payment by paypal are successfully done. Transaction id: '.$transaction_id.' ';
        $CI->session->set_flashdata('success', $message_success);
        redirect(base_url().'user/payments');
		return true;
	}

    /**
    ** Get 
    **/
	function onSMS_PaymentTransaction($order_id)
	{
        
		$CI =& get_instance();
		$CI->db->select('*');
        $CI->db->from('paypal');
        $CI->db->where('order_id', $order_id);
        $query = $CI->db->get();
        $paypal = $query->row();

		$transaction = '<table  width="100%" class="" id="admin-table" style="border: 1px;margin: 10px 0;" >';
		$transaction .='<tr>';
	    $transaction .='<td style="border: 0px;" width="50%" class="payment-to" > <b>Transaction Details</b> <br />';
		$transaction .='<span>Payer Email: '.$paypal->payer_email.'</span> <br />';
		$transaction .='<span>Payer Status: '.$paypal->payer_status.'</span> <br />';
		$transaction .='<span>Transaction ID: '.$paypal->transaction_id.'</span> <br />';
		$transaction .='<span>Payment Status: '.$paypal->payment_status.'</span> <br />';
		$transaction .='<span>Payment Date: '.$paypal->payment_date.'</span> <br />';
		$transaction .='</td>';
		$transaction .='</table>';
        return $transaction;
	}
}