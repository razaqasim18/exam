
<div class="content-wrapper">
    
    <?php 

    $token_name = $this->security->get_csrf_token_name();
    $token_hash = $this->security->get_csrf_hash();
    
    ?>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-12">
            <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-6 title-bar">
            	<h1><i class="fa fa-paypal"></i> <?php echo getlang('title_payment_method', 'sys_data'); ?> </h1>
            </div>

            <div class="col-xs-12 col-md-6 text-right">
            	
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover rms-table">
                            <tr class="odd">
                                <th>Title</th>
                                <th>Status</th>
                                <th class="text-center" width="120px" ><?php echo getlang('action', 'sys_data'); ?></th>
                                <th class="text-center" width="90px"><?php echo getlang('id', 'sys_data'); ?></th>
                            </tr>
                            <?php
		                    if(!empty($data))
		                    {
                                $i = 0;
		                        foreach($data as $item)
		                        {

                                    if (0 == $i % 2) {
                                        // even
                                        $tr_class = 'even';
                                    }
                                    else {
                                        // odd
                                        $tr_class = 'odd';
                                    }
                                    $i++;

		                            
		                            ?>
                            <tr class="<?php echo $tr_class; ?>">
                                <td><b><?php echo $item->name; ?></b></td>
                                <td>
                                    <?php 
                                    if(!empty($item->published)){
                                        echo '<span class="label label-success">Active</span>';
                                    }else{
                                        echo '<span class="label label-danger">Inactive</span>';
                                    }
                                    ?>   
                                </td>
                                <td class="text-center">
                                   <a class="btn btn-sm btn-info" href="<?php echo base_url().ADMIN_ALIAS.'/methods/details/'.$item->id; ?>" title="<?php echo getlang('edit', 'sys_data'); ?>"><i class="fa fa-pencil"></i></a>
                                </td>
                                <td class="text-center"><?php echo $item->id; ?></td>
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

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "<?php echo ADMIN_ALIAS; ?>/fees/" + value);
            jQuery("#searchList").submit();
        });
    });

        /**
        ** Call Active
        **/
        jQuery(document).on("click", ".activeFees", function(){
            var Id = $(this).data("id"),
            hitURL = baseURL + "<?php echo ADMIN_ALIAS; ?>/fees/active",
            currentRow = $(this);
            var confirmation = confirm("Are you sure want to re active ?");
            var hashValue = $('#csrf').val();
        
            if(confirmation){
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { Id : Id , '<?php echo $this->security->get_csrf_token_name(); ?>':hashValue} 
                }).done(function(data){
                    currentRow.parents('tr').remove();
                    $("#csrf").val(data.csrfHash);
                    if(data.status = true) { alert("Re active successfully"); }
                    else if(data.status = false) { alert("Reactive failed"); }
                    else { alert("<?php echo getlang('access_denied', 'sys_data'); ?>"); }
                    //location.reload();
                });
            }
        });

        /**
        ** Call Trash
        **/
        jQuery(document).on("click", ".trashFees", function(){
            var Id = $(this).data("id"),
            hitURL = baseURL + "<?php echo ADMIN_ALIAS; ?>/fees/trash",
            currentRow = $(this);
            var confirmation = confirm("Are you sure want to trash ?");
            var hashValue = $('#csrf').val();
        
            if(confirmation){
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { Id : Id , '<?php echo $this->security->get_csrf_token_name(); ?>': hashValue} 
                }).done(function(data){
                    currentRow.parents('tr').remove();
                    $("#csrf").val(data.csrfHash);
                    if(data.status = true) { alert("Trash successfully"); }
                    else if(data.status = false) { alert("Trash failed"); }
                    else { alert("<?php echo getlang('access_denied', 'sys_data'); ?>"); }
                    //location.reload();
                });
            }
        });

        /**
        ** Empty Trash
        **/
        jQuery(document).on("click", ".deleteFees", function(){
            var Id = $(this).data("id"),
            hitURL = baseURL + "<?php echo ADMIN_ALIAS; ?>/fees/delete",
            currentRow = $(this);
            var confirmation = confirm("<?php echo getlang('are_you_sure_want_to_delete', 'sys_data'); ?>");
            var hashValue = $('#csrf').val();
        
            if(confirmation){
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { Id : Id , '<?php echo $this->security->get_csrf_token_name(); ?>':hashValue} 
                }).done(function(data){
                    currentRow.parents('tr').remove();
                    $("#csrf").val(data.csrfHash);
                    if(data.status = true) { alert("<?php echo getlang('data_delete_successfully', 'sys_data'); ?>"); }
                    else if(data.status = false) { alert("<?php echo getlang('data_delete_failed', 'sys_data'); ?>"); }
                    else { alert("<?php echo getlang('access_denied', 'sys_data'); ?>"); }
                    //location.reload();
                });
            }
        });
</script>
