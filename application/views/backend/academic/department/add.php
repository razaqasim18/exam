
<?php
$csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
);

$id = '';
$name = '';
if(!empty($department_data))
{
    foreach ($department_data as $item)
    {
        $id = $item->id;
        $name = $item->name;
    }
}


?>


<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <?php 
    $page_title =  getlang('title_academic_department', 'sys_data');
    $page_icon = 'fa-sitemap';
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
                    <form role="form" id="addSubject" class="form-horizontal" action="<?php echo base_url().ADMIN_ALIAS; ?>/department/add" method="post" role="form" enctype="multipart/form-data" >
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <?php echo fieldBuilder('input', 'name', $name, getlang('department_name', 'sys_data'), 'required'); ?>
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
                                            <a class="btn  btn-default" href="<?php echo base_url().ADMIN_ALIAS.'/departments'; ?>" title="<?php echo getlang('btn_cancel', 'sys_data') ?>"> <?php echo getlang('btn_cancel', 'sys_data'); ?> </a>
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
