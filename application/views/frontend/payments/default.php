
<?php 
   //default param
    $cy = intVal(date('Y'));
    $cm = intVal(date('m'));

    //Pay Month
	if($month == 'all'){
        $all_slected = 'selected="selected"';
        $month = '';
	}else{
		$all_slected = '';
		if(empty($month)){
		$month = $cm;
		}
	}
    	
    
    $month_filter ='<select onchange="this.form.submit()"  name="month" class="form-control input-sm" >';
	$month_filter .='<option value="0" >'.getlang('site_form_select_month', 'data').'</option>';
    for($m = 1; $m <= 12; $m++) {
    	$monthName = date("F", mktime(null, null, null, $m));  
        if($month == $m){
            $month_filter .='<option value="'.$m.'" selected="selected" >'.$monthName.'</option>';
        }else{
        	$month_filter .='<option value="'.$m.'" >'.$monthName.'</option>';
        }
          
    }
    $month_filter .='<option value="all" '.$all_slected.' >'.getlang('site_form_all', 'data').'</option>';
    $month_filter .='</select>';

    /**
    ** Get Year Field
    **/
    if(empty($year)){
    	$year = getSingledata('academic_year', 'id', 'year', $cy);
    }
    
    $year_ids = explode(",",$year);
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('academic_year');
    $query = $CI->db->get();
    $results = $query->result();

    $output = '<select name="year" onchange="this.form.submit()" class="form-control input-sm required" >';
    $output .='<option value="0" > '.getlang('site_form_select_year', 'data').' </option>';
    foreach ($results as $key => $item) {
        $id = $item->id;
        if (in_array($id, $year_ids)) {
            $output .= '<option selected="selected" value="'.$item->id.'">'.$item->year.'</option>';
        }else{
            $output .= '<option value="'.$item->id.'">'.$item->year.'</option>';
        }
    }
    $output .= '</select>';
    $year_field = $output;


    // Filter Filter
    $status_filter = getPaymentStatus('status', $status, 'form-control input-sm pull-right', 'onchange="this.form.submit()"')
	

?>
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <?php echo getSystemMessage(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 left-sidebar"> <?php echo getUserPanel($role, $uid); ?></div>
        <div class="col-xs-12 col-sm-9 col-md-9">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8 pl-0">
                        <h1 class="user-page-title"><i class="fa fa-money"></i> <?php echo getlang('site_payment_list_title', 'data');?> </h1>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 text-right pr-0">
                        <a href="<?php echo base_url().'user/payment/add'; ?>" class="btn  btn-primary ">New Payment</a>
                    </div>
                </div>
            </div>
            
            <hr>

            <div class="box-body table-responsive no-padding">

            	<form action="<?php echo base_url(); ?>user/payments" method="POST" id="searchList">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-3" style="padding-left: 0;">
                                	<?php echo $month_filter; ?>
                                </div>
                                <div class="col-sm-1" ></div>

                                <div class="col-sm-3">
                                    <?php echo $year_field; ?>
                                </div>

                                <div class="col-sm-2" style="padding-right: 0;"></div>

                                <div class="col-sm-3" style="padding-right: 0;">
                                   <?php echo $status_filter; ?>
                                </div>
                            </div>
                        </div>
	                            
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
	                    </form>
                
                <ul class="notice-list">
                    <?php
                    if(!empty($data)){

                        $payment_data ='<table class="table table-striped" id="data-table" style="width: 100%;margin-top: 20px;" align="center">';
            $payment_data .='<tr>';
            $payment_data .='<th>#</th>';
            if($this->role == ROLE_TEACHER){
                $payment_data .='<th>Student Name</th>';
                $payment_data .='<th>Roll</th>';
            }
            $payment_data .='<th>'.getlang('site_form_year', 'data').'</th>';
            $payment_data .='<th>'.getlang('site_amount', 'data').'</th>';
            $payment_data .='<th>'.getlang('site_payment_method', 'data').'</th>';
            $payment_data .='<th>'.getlang('site_status', 'data').'</th>';
            $payment_data .='<th>'.getlang('site_date', 'data').'</th>';
            $payment_data .='<th></th>';
            // $payment_data .='<th></th>';
            $payment_data .='</tr>';
                     
            $i=0;
            foreach ($data as $item){
                $i++;
                $monthName = date("F", mktime(null, null, null, $item->month));
                $year_name = getSingledata('academic_year', 'year', 'id', $item->year);;
                $ammount = $item->paid_ammount;
                $uid = $item->uid;
                //$student_id       = $item->student_id;
                //$student_name = getSingledata('students', 'userid', 'id', $student_id);
                $student_uid = $item->student_id;
                $student_name = getSingledata('users', 'name', 'userId', $student_uid);
                $paidby = $item->payment_method;
                $status = $item->status;

                $link_payment = base_url().'user/payments/process/'. $item->id;
                $edit_payment = base_url().'user/payments/details/'. $item->id;

                if($paidby == 1){
                    $paid_button = '';

                    if($this->role == ROLE_TEACHER){
                        $edit_button = '<br><a href="'.$edit_payment.'" title="'.getlang('site_review', 'data').'" class="btn btn-small btn-primary" ><i class="fa fa-pencil"></i></a>';
                    }else{
                        $edit_button = '';
                    }
                    
                }else{
                    $paid_button = '<br><a href="'.$link_payment.'" class="btn btn-small btn-primary" >'.getlang('site_pay_now', 'data').'</a>';
                    $edit_button = '';
                }

                if($status=="0"){
                    $st = '
                    <span style="color: orange;font-weight: bold;" >'.getlang('site_form_pending', 'data').'</span> 
                    '.$edit_button.'
                    '.$paid_button.'
                    ';
                }

                if($status=="1"){
                    $st = '
                    <span style="color: green;font-weight: bold;" >'.getlang('site_form_paid', 'data').'</span>
                    '.$edit_button.'
                    ';
                }

                if($status=="2"){
                    $st = '
                    <span style="color: red;font-weight: bold;" >'.getlang('site_form_unpaid', 'data').'</span>
                    '.$edit_button.'
                    '.$paid_button.'
                    ';
                }
                        
                if($status=="3"){
                    $st = '
                    <span style="color: magenta;font-weight: bold;" >'.getlang('site_form_cancel', 'data').'</span>
                    '.$edit_button.'
                    '.$paid_button.'
                    ';
                }
                        
                if($status=="4"){
                    $st = '
                    <span style="color: mediumblue;font-weight: bold;" >'.getlang('site_form_under_review', 'data').'</span>
                    '.$edit_button.'
                    '.$paid_button.'
                    ';
                }
                        
                $submit_date   = date( 'Y-m-d', strtotime($item->create_date));
                $link_invoice  = base_url().'user/payments/invoice/'. $item->id;
                $link_PDF      = base_url().'user/payments/pdf/'. $item->id;

                $payment_method =  getSingledata('payment_method', 'name', 'id', $paidby);

                $payment_data .='<tr>';
                $payment_data .='<td>'.$i.'</td>';
                if($this->role == ROLE_TEACHER){
                    $payment_data .='<td style="text-align: left;" >'.$student_name.'</td>';
                    $payment_data .='<td  >'.$item->student_roll.'</td>';
                }
                $payment_data .='<td style="text-align: left;" >'.$monthName.' - '.$year_name.'</td>';
                $payment_data .='<td>'.getCurrency($ammount).'</td>';
                $payment_data .='<td>'.$payment_method.'</td>';
                $payment_data .='<td>'.$st.'</td>';
                $payment_data .='<td>'.$submit_date.'</td>';
                $payment_data .='<td>
                                <a href="'.$link_invoice.'" class="btn" title="'.getlang('site_invoice', 'data').'">
                                <i class="fa fa-file-text-o"></i>
                                </a>
                                </td>';
                // $payment_data .='<td>
                //                 <a href="'.$link_PDF.'" title="PDF" class="btn"><i class="fa fa-file-pdf-o"></i></a>
                //                 </td>';
                $payment_data .='</tr>';
            } // end loop
        $payment_data .='</table>';
        echo $payment_data;

                    
                        
                    }else{
                        echo '<p style="color: red;">'.getlang('site_empty_list', 'data').'</p>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>





