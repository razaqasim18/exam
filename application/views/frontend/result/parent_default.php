
<?php

	$token_name = $this->security->get_csrf_token_name();
    $token_hash = $this->security->get_csrf_hash();

 	$select_exam = getlang('site_form_select_exam', 'data');
 	$select_student = getlang('site_form_select_student', 'data');
	$examList = getExamList('exam', '');
    $exam_field = fieldBuilder('select', 'exam', $examList, $select_exam, '');
    $id = getSingledata('students', 'id', 'userid', $uid);

    $studentList = getStudents();
    $student_field = fieldBuilder('select', 'student_name', $studentList, $select_student, '');
?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 left-sidebar"> <?php echo getUserPanel($role, $uid); ?></div>
        <div class="col-xs-12 col-sm-9 col-md-9">
           <div class="box">
                <div class="box-body form-horizontal">
                    <fieldset class="well">
                    <div class="row"><div class="col-md-6"> <?php echo $exam_field; ?> </div></div>
                    <div class="row"><div class="col-md-6"> <?php echo $student_field; ?> </div></div>
                    </fieldset>
                    <input type="hidden" id="csrf" name="<?php echo $token_name; ?>" value="<?php echo $token_hash; ?>" />
                    <!-- Result -->
                    <div class="row">
                        <div class="col-md-12">
                            <div id="result"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $base_controler = base_url()."results/showresult"; //echo $base_controler; ?>

<script type="text/javascript">

    function desplyStudentList(){
        var exam_id = jQuery("#field_exam").val();
        var s_name = jQuery("#s_name").val();
        var hashValue = jQuery('#csrf').val();
        jQuery('#result').html('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');

        jQuery.post( '<?php echo $base_controler; ?>',{
            '<?php echo $this->security->get_csrf_token_name(); ?>':hashValue,
            exam_id:exam_id,
            s_name:s_name
        }, function(data){
                if(data)
                    { 
                        var obj = jQuery.parseJSON(data); 
                        var new_hash = obj.csrfHash; 
                        jQuery("#csrf").val(new_hash);
                        jQuery("#result").html(obj.html); 
                    }
            });
    }

    
    
    jQuery( "#field_exam" ).change(function() {  desplyStudentList(); });
    jQuery( "#s_name" ).change(function() { desplyStudentList(); });
                
                
                
</script>
