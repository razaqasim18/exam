
<?php
    $cy = intVal(date('Y'));
    $cm = intVal(date('m'));

    $token_name = $this->security->get_csrf_token_name();
    $token_hash = $this->security->get_csrf_hash();

    // Get Parent ID
    //$parent_id = getSingledata('parents', 'id', 'userid', $this->uid);

    // Get Student List by Parent ID
    $students = getStudentListbyParent('student_id', $this->uid);
    $student_list = fieldBuilder('select', 'student', $students, getlang('site_form_select_student', 'data'), '');

    $year_id = getSingledata('academic_year', 'id', 'year', $cy);
    $year_field = getAcademicYearList('year', $year_id);
    $year_list = fieldBuilder('select', 'year', $year_field, getlang('site_form_year', 'data'), '');


    // Month Select Field
    $month_field ='<select id="month" name="month" class="form-control required" required="required">';
    for($i = 1; $i <= 12; $i++) {
    $isCurrentMonth = ($i == intVal(date("m"))) ? 'true': 'false';
    $monthName = date("F", mktime(null, null, null, $i));  
    if($isCurrentMonth=="true"){ $selected_month = 'selected="selected"'; }else{$selected_month = ''; } 
    $month_field .='<option value="'.$i.'" '.$selected_month.' >'.$monthName.'</option>';
    }
    $month_field .='</select>';
    $month_list = fieldBuilder('select', 'month', $month_field, getlang('site_form_month', 'data'), '');

    // Get Fees List
    $fees_list = getFeesList('fees', '');
    $field_fees = fieldBuilder('select', 'fee', $fees_list, getlang('site_form_fees', 'data'), '');

    $field_paid = fieldBuilder('input', 'paid_ammount', '', getlang('site_form_paid_amount', 'data'), '');

    $student_box= '<input type="text" id="student" class="form-control required" onkeyup="findstudent()" onblur="blure()"  name="student_name" placeholder="'.getlang('site_form_enter_student_roll_name', 'data').'  " required="required" />
        <div id="message_suggestions" style=""></div>
        <input type="hidden" name="student_id" value="" id="student_id" />
    ';
    $field_search_student = fieldBuilder('select', 'findstudent', $student_box, getlang('site_form_select_student', 'data'), '');

    // Get Payment Method
    $payment_method = getPaymentMethod('payment_method', '');
    $field_payment_method = fieldBuilder('select', 'payment_method', $payment_method, getlang('site_form_payment_method', 'data'), '');
    
?>

<style type="text/css">
    .SumoSelect,
    .SlectBox{width: 100%;}

    #searchbox { position: relative;}
    #message_suggestions{ position: absolute; z-index: 999999999;margin:-10px 0 0 0px;padding: 0;  display:none;border: 1px solid #ccc;background: #f5f5f5; }
    .searchresult_ajax{min-width: 320px;}
    .searchresult_ajax:hover {background: #ccc;}
</style>


<div class="container">

    <div class="row">
        <div class="col-md-12">
            <?php echo getSystemMessage(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 left-sidebar"> <?php echo getUserPanel($role, $uid); ?></div>
        <div class="col-xs-12 col-sm-9 col-md-9 front-end-details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 pl-0">
                        <h1 class="user-page-title"><i class="fa fa-money"></i> <?php echo getlang('site_form_payment_form', 'data'); ?> </h1>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="box-body  no-padding">
                <div class="container-fluid">
                <form method="post" action="<?php echo base_url(); ?>user/payments/save" class="form-horizontal ">
                    <div class="row">
                        <div class="col-xs-12 col-sm-9 col-md-9 pl-0">
                        <?php
                        if($this->role == ROLE_PARENT){
                            echo $student_list;
                        }elseif($this->role == ROLE_TEACHER){
                            echo $field_search_student; 
                        }elseif($this->role == ROLE_STUDENT){
                            echo '<input type="hidden" name="student_id" value="'.$this->uid.'" id="student_id" />';
                        }
                        ?>
                        <?php echo $month_list; ?>
                        <?php echo $year_list; ?>
                        <?php echo $field_fees; ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo getlang('site_form_total_bill', 'data'); ?></label>
                            
                            <div class="col-sm-8">
                                <div id="bill" style="margin-top: 10px;">
                                    <p style="color: green;font-size: 150%;" id="total_bill"></p>
                                        <input type="hidden" id="total_bill_value" name="total_bill" value="" />
                                </div>
                            </div>
                        </div>

                        <?php echo $field_paid; ?>

                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo getlang('site_form_due', 'data'); ?></label>
                            <div class="col-sm-8">
                                <div id="due" style="margin-top: 10px;">
                                    <p style="color: red;font-size: 150%;" id="due_bill"></p>
                                    <input type="hidden" name="due_ammount" value="" />
                                </div>
                            </div>
                        </div>

                        <?php echo $field_payment_method; ?>

                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-8">
                                <input type="submit" class="btn btn-primary" value="<?php echo getlang('site_btn_submit', 'data'); ?>" />
                            </div>
                        </div>

                        </div>
                    </div>

                    
                    <input type="hidden" id="csrf" name="<?php echo $token_name; ?>" value="<?php echo $token_hash; ?>" />
                </form>
                </div>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    window.asd = $('.fees_field').SumoSelect({csvDispCount: 3});
</script>

<?php 
$get_url_bill = base_url()."user/payment/bill";
$get_url_due = base_url()."user/payment/due";
$get_url_find_student = base_url()."user/payment/findstudent";
?>

<script type="text/javascript">
    
                
        $( "#field_fees" ).change(function() {
            var val = $("#field_fees").val();
            var hashValue = $('#csrf').val();

            // Get bill calculation
            $("#bill").html("<?php echo getlang('site_loading', 'data'); ?>");
            $.post( '<?php echo $get_url_bill; ?>',{
                    '<?php echo $this->security->get_csrf_token_name(); ?>':hashValue,
                    val:val
                }, function(data)
                {
                    var obj = $.parseJSON(data); 
                    var new_hash = obj.csrfHash; 
                    $("#csrf").val(new_hash);
                    $("#bill").html(obj.html); 
                }
            );

            // Get Due calculation
            $.post( '<?php echo $get_url_due; ?>',{
                    '<?php echo $this->security->get_csrf_token_name(); ?>':hashValue,
                    val:val
                }, function(data)
                {
                    var obj = $.parseJSON(data); 
                    var new_hash = obj.csrfHash; 
                    $("#csrf").val(new_hash);
                    $("#due").html(obj.html); 
                }
            );
               
        });
        
        $( "#field_id_paid_ammount" ).keyup(function() {
            var totalbill = $("#total_bill_value").val();
            var paid      = $("#field_id_paid_ammount").val();
            var due       = Number( Number(totalbill) - Number(paid)).toFixed(2); 
            var due_html ='<p style="color: red;font-size: 150%;" id="total_due"> ' + due + '</p><input type="hidden" name="due_ammount" value="' + due + '" />'
            $("#due").html("<?php echo getlang('site_loading', 'data'); ?>");
            $("#due").html(due_html); 
        });
        
        
                    


        // Find Student
        function findstudent(){
            var val = $("#student").val();
            var hashValue = $('#csrf').val();
            if(val) {
                $("#message_suggestions").html("<?php echo getlang('site_loading', 'data'); ?>");
                $.post( '<?php echo $get_url_find_student; ?>',
                    {
                        '<?php echo $this->security->get_csrf_token_name(); ?>':hashValue,
                        val:val
                    }, function(data)
                    {
                        var obj = $.parseJSON(data); 
                        var new_hash = obj.csrfHash; 
                        $("#csrf").val(new_hash);
                        $('#message_suggestions').fadeIn();
                        $("#message_suggestions").html(obj.html); 
                    }
                );        
            }else{
                $('#message_suggestions').fadeOut();
            } 
        }

        function blure(){
            $('#message_suggestions').fadeOut();
        }

        // Get Student
        function lookstudent(oname, ovalue) {
            $("#student_id").val(ovalue);
            $("#student").val(oname);
        }
</script>


