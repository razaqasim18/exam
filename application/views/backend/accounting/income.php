
<?php 

    $schools_name    =  getConfigItem('site_name');
    $schools_address = getConfigItem('address');
    $schools_phone   = getConfigItem('phone');
    $schools_email   = getConfigItem('email');
    $schools_website = getConfigItem('website');
    
    $link_income        = '';

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
            <div class="col-xs-12 col-md-6 title-bar">
            	<h1><i class="fa fa-pie-chart"></i> <?php echo getlang('title_income', 'sys_data'); ?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="box-header">
                        
                        <form action="<?php echo base_url().ADMIN_ALIAS; ?>/incomes" method="POST" id="searchList">
                        <div class="container-fluid">
                            
                            <div class="row">
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4"><?php echo getlang('filter_by_month', 'sys_data'); ?> </label>
                                        <div class="col-sm-6">
                                            <?php echo $month_filter; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4"><?php echo getlang('filter_by_year', 'sys_data'); ?> </label>
                                        <div class="col-sm-6" style="padding-right: 0;">
                                            <?php echo $year_field; ?>
                                        </div>
                                    </div>
                                </div>

                               

                            </div>
                        </div>
                                
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        </form>
                        
                    </div>
                    
                    <div class="box-body">
                        <div id="printableArea">
                        <?php 
                        if(!empty($data)){
                            ?>

                            <style type="text/css">
                .information-div h3,
                .information-div p {text-align: center;}
            </style>
     
            <?php 
            //Header Information
            $year_value = getSingledata('academic_year', 'year', 'id', $year);
            $onclick_link ="'printableArea'";
            $header_con ='<p style="text-align: center;"><input type="button" id="print" onclick="printDiv('.$onclick_link.')" class="btn btn-small"  style="border: none;margin-left: 10px;" value="Print" /> </p>';
            $header  = '<div class="information-div">';
            $header .= '<h3> '.$schools_name.'</h3>';
            $header .= '<p> '.getlang('income_list', 'sys_data').' - '.$year_value.'</p>';
            $header .= $header_con;
            $header .= '</div>';
            echo $header;
            ?>


        <table class="table table-striped" id="admin-tabled" align="center" style="width: 100%;">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-left"><?php echo getlang('title', 'sys_data'); ?></th>
                    <th class="text-center"><?php echo getlang('date', 'sys_data'); ?></th>
                    <th class="text-center"><?php echo getlang('method', 'sys_data'); ?></th>
                    <th class="text-right"><?php echo getlang('amount', 'sys_data'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                $i = 0;
                foreach ($data as $item) :
                    $i++;
                $total += $item->paid_ammount;
                $link       = ''. $item->id;
                $item_ids = $item->fees_id;
                $payment_method_id = $item->payment_method;
                $payment_method  = getSingledata('payment_method', 'name', 'id', $payment_method_id);
                ?>
                <tr>
                    <td class="text-center"><?php echo $i; ?></td>
                    <td class="text-left" style="color: green;">
                        <?php 
                        $items = explode(',', $item_ids);
                        foreach ($items as $key => $value){
                            echo $item_name = getSingledata('fees', 'title', 'id', $value);
                        }
                        ?>  
                    </td>
                    <td class="text-center"><?php echo date( 'd-M-Y', strtotime($item->create_date)); ?></td>
                    <td class="text-center"><?php echo $payment_method;?></td>
                    <td class="text-right"><?php echo getCurrency($item->paid_ammount); ?></td>
                    
                </tr>
                <?php endforeach; ?>
                
                <tr class="row0">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right" style="color: green;">Total: <?php echo getCurrency($total); ?></td>
                    
                </tr>
                
            </tbody>
        </table>
                            <?php
                        }else{

                        }
                        ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
</div>


