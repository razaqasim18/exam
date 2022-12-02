
<div class="content-wrapper">

    <?php 
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    
    ?>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-8 title-bar">
                <h1><i class="fa fa-book"></i> <?php echo getlang('title_academic_year', 'sys_data'); ?>
                <small><?php echo getlang('add_edit_delete', 'sys_data'); ?></small>
            </h1>
            </div>

            <div class="col-xs-12 col-md-4 text-right">
                <a class="btn btn-primary" href="<?php echo base_url().ADMIN_ALIAS; ?>/academicyear/addyear"><i class="fa fa-plus"></i> <?php echo getlang('btn_add', 'sys_data'); ?></a>
            </div>
        </div>

       
        <div class="row">
            <div class="col-xs-12 rms-data-table">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo getlang('academic_year_list', 'sys_data'); ?></h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url().ADMIN_ALIAS; ?>/academicyear" method="POST" id="searchList">
                                <div class="input-group">
                                  <input type="text" value="<?php echo $searchText; ?>" name="searchText" class="form-control input-sm pull-right" style="width: 150px;" placeholder="<?php echo getlang('search', 'sys_data'); ?>"/>
                                  <div class="input-group-btn">
                                    <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                  </div>
                                </div>
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                            </form>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th class="text-center" width="90px"><?php echo getlang('id', 'sys_data'); ?></th>
                                <th><?php echo getlang('year', 'sys_data'); ?></th>
                                <th class="text-center" width="100px"><?php echo getlang('action', 'sys_data'); ?></th>
                            </tr>
                            <?php
                            if(!empty($academicyearRecords))
                            {
                                foreach($academicyearRecords as $record)
                                {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $record->id; ?></td>
                                <td><?php echo $record->year; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url().ADMIN_ALIAS.'/academicyear/addyear/'.$record->id; ?>" title="<?php echo getlang('edit', 'sys_data'); ?>"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-sm btn-danger deleteYear"data-id="<?php echo $record->id; ?>" id="subjectId" href="#"  title="<?php echo getlang('delete', 'sys_data'); ?>"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                        </table>
                    </div>

                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>-->
<script type="text/javascript">
    jQuery(document).ready(function(){

        /**
        ** Call Pagination
        **/
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "academicyear/" + value);
            jQuery("#searchList").submit();
        });

        /**
        ** Call Delete subject
        **/
        jQuery(document).on("click", ".deleteYear", function(){
            var Id = $(this).data("id"),
                hitURL = baseURL + "<?php echo ADMIN_ALIAS; ?>/academicyear/delete",
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
                    if(data.status = true) { alert("<?php echo getlang('system_data_delete_successfully', 'sys_data'); ?>"); }
                    else if(data.status = false) { alert("<?php echo getlang('system_data_delete_failed', 'sys_data'); ?>"); }
                    else { alert("Access denied..!"); }
                    location.reload();
                });
            }
        });
    
    });

</script>





