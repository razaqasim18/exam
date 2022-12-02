
<?php

	$token_name = $this->security->get_csrf_token_name();
    $token_hash = $this->security->get_csrf_hash();

 	$select_exam = getlang('site_form_select_exam', 'data');
 	$select_class = getlang('site_form_select_class', 'data');
	$examList = getExamList('exam', '');
    $exam_field = fieldBuilder('select', 'exam', $examList, $select_exam, '');
    $id = getSingledata('students', 'id', 'userid', $uid);
	$classlist = ClassList();
	$class_field = fieldBuilder('select', 'class', $classlist, $select_class, '');
	$roll_field = fieldBuilder('input', 'roll', '', getlang('roll', 'sys_data'), '');
   
?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 left-sidebar"> <?php echo getUserPanel($role, $uid); ?></div>
        <div class="col-xs-12 col-sm-9 col-md-9">
           <div class="box">
                <div class="box-body form-horizontal">
                    <fieldset class="well">
                    <div class="row"><div class="col-md-6"> <?php echo $exam_field; ?> </div></div>
                    <div class="row"><div class="col-md-6"> <?php echo $class_field; ?></div></div>
                    <div class="row"><div class="col-md-6"> <?php echo $roll_field; ?> </div></div>
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
<?php $base_controler = base_url()."results/showresult"; ?>

<script type="text/javascript">

    function desplyStudentList(){
        var exam_id = jQuery("#field_exam").val();
        var class_id = jQuery("#class").val();
        var roll_id = jQuery("#field_id_roll").val();
        var hashValue = jQuery('#csrf').val();
        jQuery('#result').html('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');

        jQuery.post( '<?php echo $base_controler; ?>',{
            '<?php echo $this->security->get_csrf_token_name(); ?>':hashValue,
            exam_id:exam_id,
            class_id:class_id,
            roll_id:roll_id
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
    jQuery( "#class" ).change(function() { desplyStudentList(); });
    jQuery( "#field_id_roll" ).keyup(function() { desplyStudentList(); });
             
</script>
