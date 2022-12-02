
<?php
$csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
);

$id = '';
$name = '';
$code = '';
$type_data = '<select name="type" id="field_id_type" class="form-control required" >
<option value="compulsory">Compulsory</option>
<option value="optional">Optional</option>
<option value="honors">Honors</option>
</select>';

if(!empty($subject_data))
{
    
    foreach ($subject_data as $item)
    {
        $id = $item->id;
        $name = $item->name;
        $code = $item->code;
        $type = $item->type;

        $c_selected = ($type=='compulsory') ? 'selected' : '' ;
        $o_selected = ($type=='optional') ? 'selected' : '' ;
        $h_selected = ($type=='honors') ? 'selected' : '' ;
        
        $type_data = '<select name="type" id="field_id_type" class="form-control required" >
<option value="compulsory" '.$c_selected.'>Compulsory</option>
<option value="optional" '.$o_selected.'>Optional</option>
<option value="honors" '.$h_selected.'>Honors</option>
</select>';
    }
}


?>


<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <?php 
    $page_title =  getlang('title_academic_subject', 'sys_data');
    $page_icon = 'fa-book';
    echo sectionHeader($page_title, '', $page_icon); 
    ?>
    
    <section class="content">

        <div class="row">
             <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>
    


        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addSubject" class="form-horizontal" action="<?php echo base_url().ADMIN_ALIAS; ?>/subjects/add" method="post" role="form" enctype="multipart/form-data" >
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">                                
                                    <?php echo fieldBuilder('input', 'name', $name, getlang('subject_name', 'sys_data'), 'required'); ?>
                                </div>
                                <div class="col-md-3">                                
                                    <?php echo fieldBuilder('input', 'code', $code, getlang('subject_code', 'sys_data'), 'required'); ?>
                                </div>
                                <div class="col-md-3">                                
                                    <?php echo fieldBuilder('select', 'suresh', $type_data, getlang('subject_type', 'sys_data'), 'required'); ?>
                                </div>
                            </div>
                        </div>

    
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <div class="col-sm-4 control-label"></div>
                                        <div class="col-sm-8">
                                            <input type="hidden" value="<?php echo $id; ?>" name="id">
                                            <input type="submit" class="btn btn-primary" value="<?php echo getlang('btn_submit','sys_data'); ?>" /> 
                                            <a class="btn  btn-default" href="<?php echo base_url().ADMIN_ALIAS.'/subjects'; ?>" title="<?php echo getlang('btn_cancel', 'sys_data'); ?>"> <?php echo getlang('btn_cancel', 'sys_data'); ?> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                        
                    </form>
                    <!-- form end -->

                </div>
            </div>
        </div> 
           
    </section>
    
</div>
