
<?php
    
    $schools_name    =  getConfigItem('site_name');
    $schools_address = getConfigItem('address');
    $schools_phone   = getConfigItem('phone');
    $schools_email   = getConfigItem('email');
    $schools_website = getConfigItem('website');


    $id                 = $invoice->id;
    $student_id         = $invoice->student_id;
    $student_class      = $invoice->student_class;
    $student_department = $invoice->student_department;
    $student_roll       = $invoice->student_roll;
    $payment_method     = $invoice->payment_method;
    $month              = $invoice->month;
    $year               = $invoice->year;
    $fees_id            = $invoice->fees_id;
    $total_bill         = $invoice->total_bill;
    $paid_ammount       = $invoice->paid_ammount;
    $due_ammount        = $invoice->due_ammount;
    $status             = $invoice->status;
    $create_date        = $invoice->create_date;
    $comment            = $invoice->comment;
    $uid                = $invoice->uid;
    $review_by          = $invoice->review_by;


 
    $invID = str_pad($id, 10, '0', STR_PAD_LEFT);
    $issue_date = date( 'Y-m-d', strtotime($create_date));
    $status_text = array('Pending','Paid','Un Paid','Cancel','Under Review');
    if(empty($status)){$status_value ='0';}else{$status_value =$status;}
    $paid_status = $status_text[$status_value];
    
    //due ammount
    $due = number_format(($total_bill)-($paid_ammount), 2);
                
    $link_back = '';
    $link_PDF   = '';
    
    $student_name = getSingledata('users', 'name', 'userId', $student_id);
    $class_name = getSingledata('class', 'name', 'id', $student_class);
    $paid_by = getSingledata('payment_method', 'name', 'id', $payment_method);
    $payment_alias = getSingledata('payment_method', 'alias', 'id', $payment_method);

?>

<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        document.getElementById("print").style.visibility = "hidden";
        window.print();
        document.body.innerHTML = originalContents;
        document.location.reload();
    }
</script>

<div class="content-wrapper">
    <section class="content">

    <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body ">
                <div id="printableArea">
                    <?php 
                    //Header Information
                    $onclick_link ="'printableArea'";
                    $header_con ='<p style="text-align: center;"><input type="button" id="print" onclick="printDiv('.$onclick_link.')" class="btn btn-small"  style="border: none;margin-left: 10px;width: 70px;" value="'.getlang('print', 'sys_data').'" /> </p>';
                    $header  = '<h4 class="" style="text-align: center;margin-bottom: 3px;" >'.$schools_name.'</h4>';
                    $header .='<p style="text-align: center;"><b>'.getlang('invoice', 'sys_data').'</b></p>';
                    $header .= $header_con;
                    $header .= '<table  width="100%" class="" id="data-table" style="border: 0px;margin: 0px 0;" >';
                    
                    $header .='<tr>';
                    $header .='<td style="border: 0px;text-align: left;" width="50%" class="payment-to" > ';
                    $header  .= '<h4 class="" >'.getlang('invoice', 'sys_data').': '.$invID.'</h4>';
                    $header .='</td>';
                    $header .='<td style="border: 0px; text-align: right;" width="50%"  class="bill-to" > ';
                    $header .='<span> Issue: '.$issue_date.'</span> <br />';
                    $header .='<span>Status: '.$paid_status.'</span> <br />';
                    $header .='<span>Paid By: '.$paid_by.'</span> <br />';
                    $header .='</td>';
                    $header .='</tr>';   
                    $header .='</table>';
                    
                    echo $header;
                    
                    //Student Information
                    $bill_info = '<table  width="100%" class="" id="data-table" style="border: 1px;margin: 0px 0;" >';
                    $bill_info .='<tr>';
                    $bill_info .='<td style="border: 0px;text-align: left;" width="50%" class="payment-to" > <b>Payment To</b> <br />';
                    $bill_info .='<span>'.$schools_name.'</span> <br />';
                    $bill_info .='<span>'.$schools_address.'</span> <br />';
                    $bill_info .='<span>'.$schools_phone.'</span> <br />';
                    $bill_info .='</td>';
                    $bill_info .='<td style="border: 0px;text-align: right;" width="50%" class="bill-to" > <b>Invoice To</b> <br />';
                    $bill_info .='<span>'.$student_name.'</span> <br />';
                    $bill_info .='<span> '.getlang('roll', 'sys_data').' - '.$student_roll.'</span> <br />';
                    $bill_info .='<span> '.getlang('class_name', 'sys_data').' - '.$class_name.'</span> <br />';
                    $bill_info .='</td>';
                    $bill_info .='</tr>';   
                    $bill_info .='</table>';
                    
                    echo $bill_info;
                    
                    $invoice_table = '<table  width="100%" class="mark-table" id="data-table" >';
                    $invoice_table .= '<tr>'; 
                    $invoice_table .= '<th style="text-align: center;" >#</th>';
                    $invoice_table .= '<th style="text-align: center;">'.getlang('fees', 'sys_data').'</th>';
                    $invoice_table .= '<th style="text-align: center;">'.getlang('total', 'sys_data').'</th>';
                    $invoice_table .= '</tr>'; 
                        
                    $i=0;
                    $pay_type = explode(",", $fees_id);
                    foreach($pay_type as $item){
                        $i++;
                        $payment_type_name = getSingledata('fees', 'title', 'id', $item);
                        $payment_type_fee = getSingledata('fees', 'fee', 'id', $item);
                        $invoice_table .= '<tr>'; 
                        $invoice_table .= '<td align="center"  style="width: 10%;padding: 30px; ">'.$i.'</td>';
                        $invoice_table .= '<td style="padding: 30px; " class="fee-td">'.$payment_type_name.'</td>';
                        $invoice_table .= '<td style="width: 25%;padding: 30px;text-align: right; ">'.getCurrency($payment_type_fee).'</td>';
                        $invoice_table .= '</tr>'; 
                    }
                    
                    $invoice_table .= '<tr>'; 
                    $invoice_table .= '<td align="center"  style="width: 10%;padding:10px 30px;border-right: 0 none; "></td>';
                    $invoice_table .= '<td style="padding:10px 30px; border-left: 0 none;text-align: right;" class="fee-td"> <span>'.getlang('sub_total', 'sys_data').' </span></td>';
                    $invoice_table .= '<td style="width: 25%;padding:10px 30px;text-align: right; ">'.getCurrency($total_bill).'</td>';
                    $invoice_table .= '</tr>'; 
                    $invoice_table .= '<tr>'; 
                    $invoice_table .= '<td align="center"  style="width: 10%;padding:10px 30px;border-right: 0 none; "></td>';
                    $invoice_table .= '<td style="padding:10px 30px;border-left: 0 none;text-align: right;" class="fee-td"> <span>'.getlang('paid', 'sys_data').' </span></td>';
                    $invoice_table .= '<td align="right" style="width: 25%;padding:10px 30px;text-align: right; ">'.getCurrency($paid_ammount).'</td>';
                    $invoice_table .= '</tr>'; 
                    $invoice_table .= '<tr>'; 
                    $invoice_table .= '<td align="center"  style="width: 10%;padding:10px 30px;border-right: 0 none; "></td>';
                    $invoice_table .= '<td style="padding:10px 30px;border-left: 0 none; text-align: right;" class="fee-td"> <span>'.getlang('due', 'sys_data').' </span></td>';
                    $invoice_table .= '<td align="right" style="width: 25%;padding:10px 30px; text-align: right;">'.getCurrency($due).'</td>';
                    $invoice_table .= '</tr>'; 
                    $invoice_table .='</table>';
                    
                    echo $invoice_table;

                    //Transaction Information
                    if($payment_alias != "offline"){
                        
                        echo $html = $paypal->onSMS_PaymentTransaction($id);
                        
                    }else{
                        if(!empty($review_by)){
                            $revier_name = getSingledata('users', 'name', 'userId', $review_by);
                        }else{
                            $revier_name = '-----';
                        }
                        
                        $review ='<br>
                        <p>'.getlang('review_by', 'sys_data').' '.$revier_name.'</p>
                        <p>'.getlang('review_comment', 'sys_data').' '.$comment.'</p>';
                        echo $review;
                    }
                    
                    ?>
                </div>
                </div> 
            </div>
        </div>
    </div>
</div>





