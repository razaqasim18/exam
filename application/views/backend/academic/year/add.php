
<?php
$csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
);

$id = '';
$year = '';
if(!empty($year_data))
{
    foreach ($year_data as $item)
    {
        $id = $item->id;
        $year = $item->year;
    }
}


?>


<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <?php 
    $page_title =  getlang('title_academic_year', 'sys_data');
    $page_icon = 'fa-book';
    echo sectionHeader($page_title, '', $page_icon); 
    ?>
    
    <section class="content">

        <div class="row">
             <div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
    


        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addSubject" class="form-horizontal" action="<?php echo base_url().ADMIN_ALIAS; ?>/academicyear/addyear" method="post" role="form" enctype="multipart/form-data" >
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <?php echo fieldBuilder('input', 'year', $year, getlang('year', 'sys_data'), 'required'); ?>
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
                                            <input type="submit" class="btn btn-primary" value="<?php echo getlang('btn_submit', 'sys_data'); ?>" /> 
                                            <a class="btn  btn-default" href="<?php echo base_url().ADMIN_ALIAS.'/academicyear'; ?>" title="<?php echo getlang('btn_cancel', 'sys_data'); ?>"> <?php echo getlang('btn_cancel', 'sys_data'); ?> </a>
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
