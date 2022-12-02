
<?php 

    $token_name = $this->security->get_csrf_token_name();
    $token_hash = $this->security->get_csrf_hash();

    $exam_id       = $this->input->get('exam');
    $class_id      = $this->input->get('class');
    $department_id = $this->input->get('department');
    $subject_id    = $this->input->get('subjects');

    // Exam Field
    $exam_list = getExamList('exam', $exam_id);
    $field_exam = fieldBuilder('select', 'exam', $exam_list, 'Exam', '');

    // Class Field
    $class_list = getClassList('class', $uid, $class_id);
    $field_class = fieldBuilder('select', 'class', $class_list, 'Class', '');

    // Department Field
    $department_list = getDepartmentList('department', $uid, $department_id);
    $field_department = fieldBuilder('select', 'department', $department_list, 'Department', '');

    // Subject Field
    $subject_list = getSubjectList('subject', $uid, $subject_id);
    $field_subject = fieldBuilder('select', 'subject', $subject_list, 'Subject', '');

    if(!empty($exam_id) && !empty($class_id)  && !empty($subject_id) && !empty($department_id)){ ?>
    <script type="text/javascript">
        $( document ).ready(function() {
           desplyresult();
        });
        
    </script>
    <?php } ?>

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
        			<div class="col-xs-12 col-sm-8 col-md-8 pl-0">
        				<h1 class="user-page-title"><i class="fa fa-star"></i> Manage Marks </h1>
        			</div>
        			
        		</div>
        	</div>
            
            <hr>

            <div class="box-body table-responsive no-padding well">
                <div class="container-fluid">
                    <form action="" class="form-horizontal ">
                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-9 col-md-9 pl-0">
                                
                                    <?php echo $field_exam; ?>
                                    <?php echo $field_class; ?>
                                    <?php echo $field_department; ?>
                                    <?php echo $field_subject; ?>
                                
                            </div>
                        </div>

                        <input type="hidden" id="csrf" name="<?php echo $token_name; ?>" value="<?php echo $token_hash; ?>" />

                    </form>
                </div>
            </div>

            <div class="box-body table-responsive no-padding">
                <div id="result"></div>
            </div>


        </div>
    </div>
</div>


<?php $base_controler = base_url()."user/marks/students"; ?>
<script type="text/javascript">
   
        function desplyresult(){
            var eid = $("#field_exam").val();
            var cid = $("#field_class").val();
            var did = $("#field_department").val();
            var sid = $("#field_subject").val();
            var uid = "<?php echo $uid; ?>";
            var hashValue = $('#csrf').val();

            $("#result").html("Loading ...");
            $.post('<?php echo $base_controler; ?>',
                {
                    '<?php echo $this->security->get_csrf_token_name(); ?>':hashValue,
                    eid:eid,
                    cid:cid,
                    did:did,
                    sid:sid,
                    uid:uid
                }, function(data){
                if(data)
                    { 
                        var obj = $.parseJSON(data); 
                        var new_hash = obj.csrfHash; 
                        $("#csrf").val(new_hash);
                        $("#result").html(obj.html); 
                    }
            });
        }

        $( "#field_exam" ).change(function() { desplyresult() });
        $( "#field_class" ).change(function() { desplyresult() });
        $( "#field_department" ).change(function() { desplyresult() });
        $( "#field_subject" ).change(function() { desplyresult() });
   
</script>
