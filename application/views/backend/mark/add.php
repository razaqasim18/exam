<?php

  $token_name = $this->security->get_csrf_token_name();
  $token_hash = $this->security->get_csrf_hash();

  $exam_id       = $this->input->get('exam');
	$class_id      = $this->input->get('class');
	$department_id = $this->input->get('department');
	$subject_id    = $this->input->get('subjects');

   // Get language
   $select_exam = getlang('select_exam', 'sys_data');
   $select_class = getlang('select_class', 'sys_data');
   $select_department = getlang('select_department', 'sys_data');
   $select_subject = getlang('select_subject', 'sys_data');
   // Exam list
   $examList = getExam($exam_id, 0, '');
   $exam_field = fieldBuilder('select', 'exam', $examList, $select_exam, '');

   // Class list
   $classList = getClass($class_id);
   $class_field = fieldBuilder('select', 'class', $classList, $select_class, '');

   // Department List
   $department_list = getDepartment('department',$department_id);
   $department_field = fieldBuilder('select', 'department', $department_list, $select_department, '');

   // Subject list
   $subjectList = getSubjectsList($subject_id);
   $subject_field = fieldBuilder('select', 'subject', $subjectList, $select_subject, '');

   

   //$userid = $userid;

   if(!empty($exam_id) && !empty($class_id)  && !empty($subject_id) && !empty($department_id)){ ?>
    <script type="text/javascript">
    	jQuery( document ).ready(function() {
           desplyStudentList();
        });
    	
    </script>
    <?php } ?>
   

<div class="content-wrapper mark-page">
    <?php 
    $page_title = getlang('title_academic_mark', 'sys_data');
    $page_icon = 'fa fa-star';
    echo sectionHeader($page_title, '', $page_icon); 
    ?>
    <section class="content">

        <div class="row">
             <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body form-horizontal">
                        <div class="row"><div class="col-md-6"> <?php echo $exam_field; ?> </div></div>
                        <div class="row"><div class="col-md-6"> <?php echo $class_field; ?> </div></div>
                        <div class="row"><div class="col-md-6"> <?php echo $department_field; ?> </div></div>
                        <div class="row"><div class="col-md-6"> <?php echo $subject_field; ?> </div></div>

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
    </section>
</div>


<?php $base_controler = base_url().ADMIN_ALIAS."/mark/getstudent"; ?>
<script type="text/javascript">

    function desplyStudentList(){
        var exam_id = jQuery("#exam").val();
        var class_id = jQuery("#class").val();
        var department_id = jQuery("#department").val();
        var subject_id = jQuery("#subject").val();
        var uid = <?php echo $userid; ?>;
        var hashValue = jQuery('#csrf').val();

        jQuery('#result').html('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');

        jQuery.post( '<?php echo $base_controler; ?>',{
            '<?php echo $this->security->get_csrf_token_name(); ?>':hashValue,
            exam_id:exam_id,
            class_id:class_id, 
            department_id:department_id, 
            subject_id:subject_id, 
            uid:uid
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

    
    
    jQuery( "#exam" ).change(function() {  desplyStudentList(); });
    jQuery( "#class" ).change(function() { desplyStudentList(); });
    jQuery( "#department" ).change(function() { desplyStudentList(); });
    jQuery( "#subject" ).change(function() { desplyStudentList(); });
                
                
                
</script>
    


