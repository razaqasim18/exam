
<?php 
    $cy = intVal(date('Y'));
    $cm = intVal(date('m'));

    $token_name = $this->security->get_csrf_token_name();
    $token_hash = $this->security->get_csrf_hash();
        
    if(!empty($this->uid)){
        // Get Student ID
        $student_id = getSingledata('students', 'id', 'userid', $this->uid);
    }

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

    if(!empty($year_id) && !empty($cm) && !empty($student_id)){
        $attendance_report = DisplayAttendance($year_id, $cm, $student_id);
    }else{
        $attendance_report = '';
    }
    
?>

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
                        <h1 class="user-page-title"><i class="fa fa-check-square"></i> <?php echo getlang('site_attendance_title', 'data'); ?> </h1>
                    </div>
                </div>
            </div>
            
            <hr>

            <div class="box-body table-responsive no-padding">
                <div class="container-fluid">
                <form action="" class="form-horizontal ">
                    <div class="row">
                    <div class="col-xs-12 col-sm-9 col-md-9 pl-0">
                    <?php echo $month_list; ?>
                    <?php echo $year_list; ?>
                    </div>
                    </div>
                    <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id; ?>" />
                    <input type="hidden" id="csrf" name="<?php echo $token_name; ?>" value="<?php echo $token_hash; ?>" />
                </form>
                </div>
            </div>

            <div class="box-body table-responsive no-padding">
                <div id="result"><?php echo $attendance_report; ?></div>
            </div>
        </div>
    </div>
</div>

<?php $base_controler = base_url()."user/attendance/report"; ?>
<script type="text/javascript">
    $(document).ready(function () {

        function desplyresult(){
            var sid   = $("#student_id").val();
            var year  = $("#field_year").val();
            var month = $("#month").val();
            var hashValue = $('#csrf').val();

            $("#result").html("<?php echo getlang('site_loading', 'data'); ?>");
            $.post( '<?php echo $base_controler; ?>',{'<?php echo $this->security->get_csrf_token_name(); ?>':hashValue,sid:sid,year:year,month:month}, function(data){
                if(data)
                    { 
                        var obj = $.parseJSON(data); 
                        var new_hash = obj.csrfHash; 
                        $("#csrf").val(new_hash);
                        $("#result").html(obj.html); 
                    }
            });
        }

        $( "#field_student" ).change(function() { desplyresult() });
        $( "#field_year" ).change(function() { desplyresult() });
        $( "#month" ).change(function() { desplyresult() });
    });
</script>




