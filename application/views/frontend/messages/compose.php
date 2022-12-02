<?php
   
    $token_name = $this->security->get_csrf_token_name();
    $token_hash = $this->security->get_csrf_hash();

    $get_url_student_box = base_url()."user/messages/studentbox";
    $get_url_parent_box = base_url()."user/messages/parentbox";
    $get_url_teacher_box = base_url()."user/messages/teacherbox";
?>

<style type="text/css">
    #searchbox { position: relative;}
    #message_suggestions{ position: absolute; z-index: 999999999;margin:-10px 0 0 0px;padding: 0;  display:none;border: 1px solid #ccc;background: #f5f5f5; }
    .searchresult_ajax{min-width: 320px;}
    .searchresult_ajax:hover {background: #ccc;}
    
</style>


<script type="text/javascript">
    $(document).ready(function () {
        
        $("#to_selector").change(function(){
            var val = $("#to_selector").val();
            var hashValue = $('#csrf').val();
            if(val=="student"){
                $("#searchbox").html("<?php echo getlang('site_loading', 'data'); ?>");
                $.post( '<?php echo $get_url_student_box; ?>',
                    {
                        '<?php echo $this->security->get_csrf_token_name(); ?>':hashValue,
                        val:val
                    }, function(data)
                    {
                        var obj = $.parseJSON(data); 
                        var new_hash = obj.csrfHash; 
                        $("#csrf").val(new_hash);
                        $("#searchbox").html(obj.html); 
                    }
                ); 

            }else if(val=="parent"){
                $("#searchbox").html("<?php echo getlang('site_loading', 'data'); ?>");
                $.post( '<?php echo $get_url_parent_box; ?>',
                    {
                        '<?php echo $this->security->get_csrf_token_name(); ?>':hashValue,
                        val:val
                    }, function(data)
                    {
                        var obj = $.parseJSON(data); 
                        var new_hash = obj.csrfHash; 
                        $("#csrf").val(new_hash);
                        $("#searchbox").html(obj.html); 
                    }
                );          
            }else{
                $("#searchbox").html("<?php echo getlang('site_loading', 'data'); ?>");
                $.post( '<?php echo $get_url_teacher_box; ?>',
                    {
                        '<?php echo $this->security->get_csrf_token_name(); ?>':hashValue,
                        val:val
                    }, function(data)
                    {
                        var obj = $.parseJSON(data); 
                        var new_hash = obj.csrfHash; 
                        $("#csrf").val(new_hash);
                        $("#searchbox").html(obj.html); 
                    }
                );
            }
                                 
        });
                     
                     
    });//End doc
</script>

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
                        <h1 class="user-page-title"><i class="fa fa-envelope-open"></i> <?php echo getlang('site_form_new_message', 'data'); ?></h1>
                    </div>
                </div>
            </div>
            
            <hr>

            <div class="box-body table-responsive no-padding">
                <form action="<?php echo base_url(); ?>user/messages/send" class="" method="post">

                    <div class="container-fluid ">
                        <div class="row">
                            <div class="col-md-12 form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-1 control-label"><?php echo getlang('site_to', 'data'); ?></label>
                                    <div class="col-sm-11">
                                        <select name=""  class="form-control required" id="to_selector">
                                            <option value="teacher"><?php echo getlang('site_form_teacher', 'data'); ?></option>
                                            <option value="student"><?php echo getlang('site_form_student', 'data'); ?></option>
                                            <option value="parent"><?php echo getlang('site_form_parent', 'data'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid ">
                        <div class="row">
                            <div class="col-md-12 form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <span id="searchbox">
                                            <input type="text" id="teacher" class="form-control required" required="required" onkeyup="findteacher()" onblur="blure()" name="recever_name" placeholder="<?php echo getlang('site_form_enter_name', 'data'); ?>" />
                                        </span>
                                        <div id="message_suggestions" style=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid ">
                        <div class="row">
                            <div class="col-md-12 form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="text" id="subject" class="form-control required" required="required"  name="subject" placeholder="<?php echo getlang('site_form_subject', 'data'); ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid ">
                        <div class="row">
                            <div class="col-md-12 form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <textarea name="message" class="form-control required" required="required" id="messagearea" style="min-height: 150px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="<?php echo getlang('site_btn_send', 'data'); ?>" /> 
                                    <a class="btn  btn-default" href="<?php echo base_url().'user/messages'; ?>" title="<?php echo getlang('site_btn_cancel', 'data'); ?>"> <?php echo getlang('site_btn_cancel', 'data'); ?> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <input type="hidden" name="sender_id" value="<?php echo $uid; ?>"  />
                    <input type="hidden" name="recever_id" value="" id="recever_id" />
                    <input type="hidden" id="csrf" name="<?php echo $token_name; ?>" value="<?php echo $token_hash; ?>" />
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
    $get_url_find_student = base_url()."user/messages/findstudent";
    $get_url_find_parent  = base_url()."user/messages/findparent";
    $get_url_find_teacher = base_url()."user/messages/findteacher";
?>
<script type="text/javascript">

    // Get Teacher
    function lookteacher(oname, ovalue) {
        $("#recever_id").val(ovalue);
        $("#teacher").val(oname);
    } 

    // Get Student
    function lookstudent(oname, ovalue) {
        $("#recever_id").val(ovalue);
        $("#student").val(oname);
    }

    // Get Parent
    function lookparent(oname, ovalue) {
        $("#recever_id").val(ovalue);
        $("#parent").val(oname);
    } 
            
    // Find Teacher         
    function findteacher(){
        var val = $("#teacher").val();
        var hashValue = $('#csrf').val();
        if(val) {
            $("#message_suggestions").html("Loading ...");
            $.post( '<?php echo $get_url_find_teacher; ?>',
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
    
    // Find Student
    function findstudent(){
        var val = $("#student").val();
        var hashValue = $('#csrf').val();
        if(val) {
            $("#message_suggestions").html("Loading ...");
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

    // Find Parent
    function findparent(){
        var val = $("#parent").val();
        var hashValue = $('#csrf').val();
        if(val) {
            $("#message_suggestions").html("Loading ...");
            $.post( '<?php echo $get_url_find_parent; ?>',
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
</script>

    


