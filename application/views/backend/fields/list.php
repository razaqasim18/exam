
<div class="content-wrapper">
    
    <?php 

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );


    $page_title = getlang('title_field_list', 'sys_data');
    $page_sub_title = getlang('field_list_sub_title', 'sys_data');
    
    ?>
    
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-12">
            <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-8 title-bar">
                <h1><i class="fa fa-cog"></i> <?php echo $page_title; ?> <small> <?php echo $page_sub_title; ?> </small></h1>
            </div>

            <div class="col-xs-12 col-md-4 text-right">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>fields/add">
                    <i class="fa fa-plus"></i> 
                    <?php echo getlang('btn_add', 'sys_data'); ?>
                </a>
            </div>
        </div>

        
        <div class="row">
            <div class="col-xs-12 rms-data-table">
              <div class="box">
                <div class="box-header">
                    <form action="<?php echo base_url().ADMIN_ALIAS; ?>/fields" method="POST" id="searchList">
                          <div class="container-fluid">
                            
                            <div class="row">
                                <div class="col-sm-3 " style="padding-left: 0;">
                                    <div class="input-group">
                                    <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" placeholder="<?php echo getlang('search', 'sys_data'); ?>"/>
                                    <div class="input-group-btn">
                                    <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                    </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="verified" class=" col-sm-6 control-label"><?php echo getlang('filter_by_status', 'sys_data'); ?></label>
                                        <div class="col-sm-6" style="padding-right: 0;">
                                            <select name="status_value"  onchange="this.form.submit()"  class="form-control">
                                                <option value="active" <?php if($status_value == 'active'){echo 'selected="selected"';} ?> ><?php echo getlang('published', 'sys_data'); ?></option>
                                                <option value="inactive" <?php if($status_value == 'inactive'){echo 'selected="selected"';} ?> ><?php echo getlang('unpublished', 'sys_data'); ?></option>
                                            </select> 
                                        </div>
                                    </div>
                                </div>

                               
                                <div class="col-sm-3" style="padding-right: 0;">
                                    <div class="form-group">
                                        <label for="group" class=" col-sm-6 control-label"><?php echo getlang('filter_by_section', 'sys_data'); ?></label>
                                        <div class="col-sm-6" style="padding-right: 0;">
                                            <select name="section_value" onchange="this.form.submit()" class="form-control input-sm">
                                                <option value="0" >Select</option>
                                                <option value="1" <?php if($section_value == 1){echo 'selected="selected"';} ?> ><?php echo getlang('students', 'sys_data'); ?></option>
                                                <option value="2" <?php if($section_value == 2){echo 'selected="selected"';} ?> ><?php echo getlang('teachers', 'sys_data'); ?></option>
                                                <option value="3" <?php if($section_value == 3){echo 'selected="selected"';} ?> ><?php echo getlang('parents', 'sys_data'); ?></option>
                                            </select> 
                                        </div>
                                    </div>
                                </div>

                                
                                
                            </div>
                        </div>
                                
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />  
                    </form>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover rms-table">
                    <tr>
                      <th><?php echo getlang('field_name', 'sys_data'); ?></th>
                      <th><?php echo getlang('field_type', 'sys_data'); ?></th>
                      <th><?php echo getlang('field_section', 'sys_data'); ?></th>
                      <th><?php echo getlang('field_order', 'sys_data'); ?></th>
                      <th><?php echo getlang('status', 'sys_data'); ?> </th>
                      <th class="text-center" width="100px" ><?php echo getlang('action', 'sys_data'); ?></th>
                      <th class="text-center" width="90px"><?php echo getlang('id', 'sys_data'); ?></th>
                    </tr>
                    
                    
                        <?php  foreach ($fieldsRecords as $key => $record) { ?>
                        <tr>  
                            <td><?php echo $record->field_name; ?></td>
                            <td><?php echo getSingledata('fields_type', 'type', 'id', $record->type); ?></td>
                            <td><?php echo getSingledata('fields_section', 'name', 'id', $record->section); ?></td>
                            <td><?php echo $record->field_order; ?></td>
                            <td>
                                <?php 
                                    if ($record->published  == 1) {
                                        echo '<span class="label label-success">'.getlang('published', 'sys_data').'</span>';
                                    }else{
                                        echo '<span class="label label-danger">'.getlang('unpublished', 'sys_data').'</span>';
                                    }
                                ?>
                            </td>
                              
                            <td class="text-center">
                                <a class="btn btn-sm btn-info"  href="<?php echo base_url().'fields/add/'.$record->id; ?>" title="<?php echo getlang('edit', 'sys_data'); ?>"><i class="fa fa-pencil"></i></a>
                                <a class="btn btn-sm btn-danger deleteFields"data-id="<?php echo $record->id; ?>" id="fieldId" href="#" name="Id" title="<?php echo getlang('delete', 'sys_data'); ?>"><i class="fa fa-trash"></i></a>
                            </td>
                            <td class="text-center"><?php echo $record->id; ?></td>
                        
                        </tr>
                        <?php } ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
            </div>
    </section>
</div>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){

        /**
        ** For pagination
        **/
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "fields/" + value);
            jQuery("#searchList").submit();
        });

        /**
        ** For Delete
        **/
         /**
        ** Call Delete subject
        **/
        jQuery(document).on("click", ".deleteFields", function(){
        var Id = $(this).data("id"),
            hitURL = baseURL + "fields/delete",
            currentRow = $(this);
        
        var confirmation = confirm("<?php echo getlang('system_confirm_delete_msg', 'sys_data'); ?>");
        
        if(confirmation)
        {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { Id : Id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>' } 
            }).done(function(data){
                console.log(data);
                currentRow.parents('tr').remove();
                if(data.status = true) { alert("<?php echo getlang('system_data_delete_success', 'sys_data'); ?>"); }
                else if(data.status = false) { alert("<?php echo getlang('system_data_delete_failed', 'sys_data'); ?>"); }
                else { alert("Access denied..!"); }
                location.reload();
            });
        }
    });



    });
</script>





