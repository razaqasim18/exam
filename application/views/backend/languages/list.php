
<div class="content-wrapper">
    <?php echo sectionHeader('Language Management', 'Add/ Edit/ Delete', 'fa-language'); ?>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>

        
            <div class="row">
                <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>languages/add"><i class="fa fa-plus"></i> Add New Language</a>
                    <div class="box-tools">
                        <form action="<?php echo base_url().ADMIN_ALIAS; ?>/languages" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" value="<?php echo $searchText; ?>" name="searchText" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>

                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>Name</th>
                        <th>Native name</th>
                        <th>Lang Code</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($languageRecords))
                    {
                        foreach($languageRecords as $record)
                        {

                            if(empty($record->image)){
                                $flug_path = site_url('/uploads/lang/').'/flag.gif';
                            }else{
                                $flug_path = site_url('/uploads/lang/').'/'.$record->image.'.gif';
                            }
                            ?>
                            <tr>
                                <td>
                                     
                                    <img src="<?php echo $flug_path; ?>" alt="<?php echo $record->title; ?>" >

                                    <?php echo $record->title ?>
                                </td>
                                <td><?php echo $record->title_native ?></td>
                                <td><?php echo $record->lang_code ?></td>
                                <td class="text-center">
                                  <a class="btn btn-sm btn-info" href="<?php echo base_url().ADMIN_ALIAS.'/languages/add/'.$record->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                  <a class="btn btn-sm btn-danger deletelang"data-id="<?php echo $record->id; ?>" id="lang" href="#"  title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
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
        ** Call Pagination
        **/
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "<?php echo ADMIN_ALIAS; ?>/languages/" + value);
            jQuery("#searchList").submit();
        });

        /**
        ** Call Delete subject
        **/
        jQuery(document).on("click", ".deletelang", function(){
        var Id = $(this).data("id"),
            hitURL = baseURL + "<?php echo ADMIN_ALIAS; ?>/languages/delete",
            currentRow = $(this);
        
        var confirmation = confirm("Are you sure want to delete ?");
        
        if(confirmation)
        {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : {Id:Id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'} 
            }).done(function(data){
                currentRow.parents('tr').remove();
                if(data.status = true) { alert("Language successfully deleted"); }
                else if(data.status = false) { alert("Language deletion failed"); }
                else { alert("Access denied..!"); }
                location.reload();
            });
        }
    });
    





    });

</script>





