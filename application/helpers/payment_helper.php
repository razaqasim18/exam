<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


    /**
    ** Get Payment Status
    **/
    function getPaymentStatus($name, $id, $class, $event){
        $list = array(
            'p'   => ''.getlang('pending', 'sys_data').'', 
            '1'   => ''.getlang('paid', 'sys_data').'',
            '2'   => ''.getlang('unpaid', 'sys_data').'',
            '3'   => ''.getlang('cancel', 'sys_data').'',
            '4'   => ''.getlang('under_review', 'sys_data').'',
            'all' => ''.getlang('all', 'sys_data').''
        );

        $output = '<select name="'.$name.'" id="s_'.$name.'" '.$event.' class="'.$class.'" >';
        foreach ($list as $key => $item) {
            if ($key == $id ) {
                $output .= '<option selected="selected" value="'.$key.'">'.$item.'</option>';
            }else{
                $output .= '<option value="'.$key.'">'.$item.'</option>';
            }
        }
        $output .= '</select>';
        return $output;
    }

    /**
    ** Get Fees List
    **/
    function getFeesList($field_name, $id){
        $exam_ids = explode(",",$id);
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('fees');
        $query = $CI->db->get();
        $results = $query->result();

        $output = '<select name="'.$field_name.'[]" id="field_'.$field_name.'" multiple="multiple" class="fees_field form-control required" >';
        //$output .='<option value="0" > Select Fees </option>';
        foreach ($results as $key => $item) {
            $id = $item->id;
            if (in_array($id, $exam_ids)) {
                $output .= '<option selected="selected" value="'.$item->id.'">'.$item->title.'('.getCurrency($item->fee).')</option>';
            }else{
                $output .= '<option value="'.$item->id.'">'.$item->title.'('.getCurrency($item->fee).')</option>';
            }
           
        }
        $output .= '</select>';
        return $output;
    }

    /**
    ** Get Payment Method
    **/
    function getPaymentMethod($field_name, $id){
        $method_ids = explode(",",$id);
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('payment_method');
        $query = $CI->db->get();
        $results = $query->result();

        $output = '<select name="'.$field_name.'" id="field_'.$field_name.'" class="form-control required" >';
        $output .='<option value="" > Select Method </option>';
        foreach ($results as $key => $item) {
            $id = $item->id;
            if (in_array($id, $method_ids)) {
                $output .= '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
            }else{
                $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
            }
           
        }
        $output .= '</select>';
        return $output;
    }


    /**
    ** Display Payment List 
    **/
    function paymentList($group, $item_id,$status_filter,$month_filter,$year_filter,$section_filter,$roll_filder){
                
        // Condition of teacher , student & Parent
        if($group == ROLE_TEACHER){
            $items = getPaymentDetailsByClass($item_id,$status_filter,$month_filter,$year_filter,$section_filter,$roll_filder);
        }elseif ($group == ROLE_PARENT) {
            $items = getPaymentDetails($group, $item_id,$status_filter,$month_filter,$year_filter);  
        }elseif($group == ROLE_STUDENT){
            $items = getPaymentDetails($group, $item_id,$status_filter,$month_filter,$year_filter);
        }

        // Empty message show
        if(empty($items)){
            $payment_data ='<div class="alert alert-no-items">';
            $payment_data .= 'Empty';
            $payment_data .='</div>';
        }else{ 
            $payment_data ='<table class="admin-table" id="admin-table" style="width: 100%;margin-top: 20px;" align="center">';
            $payment_data .='<tr>';
            $payment_data .='<th>#</th>';
            if($group_title=="Teachers"){
                $payment_data .='<th>Student Name</th>';
                $payment_data .='<th>Roll</th>';
            }
            $payment_data .='<th>Year</th>';
            $payment_data .='<th>Ammount</th>';
            $payment_data .='<th>Method</th>';
            $payment_data .='<th>Status</th>';
            $payment_data .='<th>Date</th>';
            $payment_data .='<th></th>';
            $payment_data .='<th></th>';
            $payment_data .='</tr>';
                     
            $i=0;
            foreach ($items as $item){
                $i++;
                $monthName = date("F", mktime(null, null, null, $item->month));
                $year = $item->year;
                $ammount = $item->paid_ammount;
                $uid = $item->uid;
                $student_id       = $item->student_id;
                $student_name = getSingledata('students', 'name', 'id', $student_id);
                $paidby = $item->payment_method;
                $status = $item->status;

                $link_payment = base_url().'user/payments/process';
                $edit_payment = base_url().'user/payments/process';

                if($paidby == 'offline'){
                    $paid_button = '';

                    if($group == ROLE_TEACHER){
                        $edit_button = '<br><a href="'.$edit_payment.'" title="Review" class="btn btn-primary" ><i class="fa fa-pencil"></i></a>';
                    }else{
                        $edit_button = '';
                    }
                    
                }else{
                    $paid_button = '<br><a href="'.$link_payment.'" class="btn btn-primary" >Pay Now</a>';
                    $edit_button = '';
                }

                if($status=="0"){
                    $st = '
                    <span style="color: orange;font-weight: bold;" >Pending</span> 
                    '.$edit_button.'
                    '.$paid_button.'
                    ';
                }

                if($status=="1"){
                    $st = '
                    <span style="color: green;font-weight: bold;" >Paid</span>
                    '.$edit_button.'
                    ';
                }

                if($status=="2"){
                    $st = '
                    <span style="color: red;font-weight: bold;" >Unpaid</span>
                    '.$edit_button.'
                    '.$paid_button.'
                    ';
                }
                        
                if($status=="3"){
                    $st = '
                    <span style="color: magenta;font-weight: bold;" >Cancel</span>
                    '.$edit_button.'
                    '.$paid_button.'
                    ';
                }
                        
                if($status=="4"){
                    $st = '
                    <span style="color: mediumblue;font-weight: bold;" >Under Review</span>
                    '.$edit_button.'
                    '.$paid_button.'
                    ';
                }
                        
                $submit_date   = date( 'Y-m-d', strtotime($item->create_date));
                $link_invoice  = base_url().'user/payments/invoice/'. $item->id;
                $link_PDF      = base_url().'user/payments/pdf/'. $item->id;

                $payment_data .='<tr>';
                $payment_data .='<td>'.$i.'</td>';
                if($group_title=="Teachers"){
                    $payment_data .='<td style="text-align: left;" >'.$student_name.'</td>';
                    $payment_data .='<td  >'.$item->student_roll.'</td>';
                }
                $payment_data .='<td style="text-align: left;" >'.$monthName.' - '.$year.'</td>';
                $payment_data .='<td>'.getCurrency($ammount).'</td>';
                $payment_data .='<td>'.$paidby.'</td>';
                $payment_data .='<td>'.$st.'</td>';
                $payment_data .='<td>'.$submit_date.'</td>';
                $payment_data .='<td>
                                <a href="'.$link_invoice.'" class="btn" title="Invoice">
                                <i class="fa fa-file-text-o"></i>
                                </a>
                                </td>';
                $payment_data .='<td>
                                <a href="'.$link_PDF.'" title="PDF" class="btn"><i class="fa fa-file-pdf-o"></i></a>
                                </td>';
                $payment_data .='</tr>';
            } // end loop
        $payment_data .='</table>';
        }
                     
        return $payment_data;
    }

    /**
    **  Students & Parent payment list (Query By Student ID)
    ***/
    function getPaymentDetails($group, $id,$status_filter,$month_filter,$year_filter){

        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('payments');
        
        if ($group=="ROLE_PARENT") {
            //$student_ids = getSingledata('parents', 'student_id', 'id', $id);
            //$CI->db->where('student_id IN(' . $student_ids.')');
            
        }else{
            //$query->where($db->quoteName('student_id') . ' = '. $db->quote($id));
        }       
        
        // Filter by Status.
        if($status_filter){
            if($status_filter=='12'){$status_filter=0;}
            if (is_numeric($status_filter)){
                //$query->where('status = ' . $db->quote($status_filter));
            }
        }
                
        // Filter by Month.
        if(!empty($month_filter)){
            $CI->db->where('month', $month_filter);
        }
                
        // Filter by Year.
        if(!empty($year_filter)){
            $CI->db->where('year', $year_filter);
        }
            
        $CI->db->order_by("month", "ASC");
        $query = $CI->db->get();
        $results = $query->result();
        return  $results;
    }

    /**
    ** Teachers Payment list (Query by teacher class ID)
    **/
    function getPaymentDetailsByClass($id,$status_filter,$month_filter,$year_filter,$section_filter,$roll_filder)
    {
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('payments');
        //$CI->db->where('student_class', $id);


        
        // Filter by Status.
        if($status_filter){
            if($status_filter=='12'){$status_filter=0;}
            if (is_numeric($status_filter)){
                //$query->where('status = ' . $db->quote($status_filter));
            }
        }
                
        // Filter by Month.
        if(!empty($month_filter)){
            $CI->db->where('month', $month_filter);
        }
                
        // Filter by Year.
        if(!empty($year_filter)){
            $CI->db->where('year', $year_filter);
        }
                
        
                
        $CI->db->order_by("month", "ASC");
        $query = $CI->db->get();
        $results = $query->result();
        return  $results;
    }

    


