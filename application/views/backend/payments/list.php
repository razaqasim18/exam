
<div class="content-wrapper">
    
    <?php 
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
    $month_filter .='<option value="0" >'.getlang('select_month', 'sys_data').'</option>';
    for($m = 1; $m <= 12; $m++) {
        $monthName = date("F", mktime(null, null, null, $m));  
        if($month == $m){
            $month_filter .='<option value="'.$m.'" selected="selected" >'.$monthName.'</option>';
        }else{
            $month_filter .='<option value="'.$m.'" >'.$monthName.'</option>';
        }
          
    }
    $month_filter .='<option value="all" '.$all_slected.' >All</option>';
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
    $output .='<option value="0" > '.getlang('select_year', 'sys_data').' </option>';
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

    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-12">
            <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-12 title-bar">
            	<h1><i class="fa fa-money"></i> <?php echo getlang('title_payment', 'sys_data'); ?></h1>
            </div>

            
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    	
	                    <form action="<?php echo base_url().ADMIN_ALIAS; ?>/payments" method="POST" id="searchList">
                        <div class="container-fluid">
                        	
                            <div class="row">
                                
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="col-sm-12" style="padding-left: 0;">
                                            <?php echo $month_filter; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3"></div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="col-sm-12" style="padding-right: 0;">
                                            <?php echo $year_field; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3" style="padding-right: 0;">
                                    <div class="form-group">
                                        <label for="group" class=" col-sm-6 control-label"><?php echo getlang('status', 'sys_data'); ?></label>
                                        <div class="col-sm-6" style="padding-right: 0;">
                                            <?php echo $status_filter; ?>
                                        </div>
                                    </div>
                                </div>

                                
                                
                            </div>
                        </div>
	                            
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
	                    </form>
	                    
                    </div>

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover rms-table">
                            <tr class="odd">
                                <th>#</th>
                                <th><?php echo getlang('student_name', 'sys_data'); ?></th>
                                <th><?php echo getlang('roll', 'sys_data'); ?></th>
                                <th><?php echo getlang('year', 'sys_data'); ?></th>
                                <th><?php echo getlang('ammount', 'sys_data'); ?></th>
                                <th><?php echo getlang('method', 'sys_data'); ?></th>
                                <th><?php echo getlang('status', 'sys_data'); ?></th>
                                <th><?php echo getlang('date', 'sys_data'); ?></th>
                                <th></th>

                            </tr>
                            <?php
		                    if(!empty($data))
		                    {
                                $payment_data = '';
                                $i=0;
            foreach ($data as $item){
                $i++;
                $monthName    = date("F", mktime(null, null, null, $item->month));
                $year         = $item->year;
                $ammount      = $item->paid_ammount;
                $uid          = $item->uid;
                $student_id   = $item->student_id;
                $student_name = getSingledata('users', 'name', 'userId', $student_id);
                $paidby       = $item->payment_method;
                $status       = $item->status;
                $year_name    = getSingledata('academic_year', 'year', 'id', $year);
                $method_name  = getSingledata('payment_method', 'name', 'id', $paidby);
                $method_alias  = getSingledata('payment_method', 'alias', 'id', $paidby);

                $edit_payment = base_url().ADMIN_ALIAS.'/payments/details/'.$item->id;

                

                if($method_alias == 'offline'){
                    $paid_button = '';

                    if($role == ROLE_SUPPER_ADMIN || $role == ROLE_ADMIN ){
                        $edit_button = '<br><a href="'.$edit_payment.'" title="'.getlang('review', 'sys_data').'" class="btn btn-primary" ><i class="fa fa-pencil"></i></a>';
                    }else{
                        $edit_button = '';
                    }
                    
                }else{
                    $paid_button = '';
                    $edit_button = '';
                }

                if($status=="0"){
                    $st = '
                    <span style="color: orange;font-weight: bold;" >'.getlang('pending', 'sys_data').'</span> 
                    '.$edit_button.'
                    '.$paid_button.'
                    ';
                }

                if($status=="1"){
                    $st = '
                    <span style="color: green;font-weight: bold;" >'.getlang('paid', 'sys_data').'</span>
                    '.$edit_button.'
                    ';
                }

                if($status=="2"){
                    $st = '
                    <span style="color: red;font-weight: bold;" >'.getlang('unpaid', 'sys_data').'</span>
                    '.$edit_button.'
                    '.$paid_button.'
                    ';
                }
                        
                if($status=="3"){
                    $st = '
                    <span style="color: magenta;font-weight: bold;" >'.getlang('cancel', 'sys_data').'</span>
                    '.$edit_button.'
                    '.$paid_button.'
                    ';
                }
                        
                if($status=="4"){
                    $st = '
                    <span style="color: mediumblue;font-weight: bold;" >'.getlang('under_review', 'sys_data').'</span>
                    '.$edit_button.'
                    '.$paid_button.'
                    ';
                }
                        
                $submit_date   = date( 'Y-m-d', strtotime($item->create_date));
                $link_invoice  = base_url().ADMIN_ALIAS.'/payments/invoice/'. $item->id;

                $payment_data .='<tr>';
                $payment_data .='<td>'.$i.'</td>';
                $payment_data .='<td style="text-align: left;" >'.$student_name.'</td>';
                $payment_data .='<td  >'.$item->student_roll.'</td>';
                
                $payment_data .='<td style="text-align: left;" >'.$monthName.' - '.$year_name.'</td>';
                $payment_data .='<td>'.getCurrency($ammount).'</td>';
                $payment_data .='<td>'.$method_name.'</td>';
                $payment_data .='<td>'.$st.'</td>';
                $payment_data .='<td>'.$submit_date.'</td>';
                $payment_data .='<td>
                                <a href="'.$link_invoice.'" class="btn" title="'.getlang('invoice', 'sys_data').'">
                                <i class="fa fa-file-text-o"></i>
                                </a>
                                </td>';
               
                $payment_data .='</tr>';
            } // end loop

            echo $payment_data;
                            }
                            ?>
                        </table>

                        <?php if(empty($data)):?>
                            <p style="color: red; text-align: center;"><?php echo getlang('empty_list', 'sys_data'); ?></p>
                        <?php endif; ?>
                    </div>

	                <div class="box-footer clearfix">
	                    <?php echo $this->pagination->create_links(); ?>
	                </div>
                </div>
            </div>
        </div>

    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){

        /**
        ** Call Pagination
        **/
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "<?php echo ADMIN_ALIAS; ?>/payments/" + value);
            jQuery("#searchList").submit();
        });

 });
</script>


