

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
        				<h1 class="user-page-title"><i class="fa fa-envelope-open"></i> <?php echo getlang('site_mesage_title', 'data'); ?> </h1>
        			</div>
        			<div class="col-xs-12 col-sm-4 col-md-4 text-right pr-0">
        				<a href="<?php echo base_url().'user/messages/compose'; ?>" class="btn btn-primary "><?php echo getlang('site_btn_compose', 'data'); ?></a>
        			</div>
        		</div>
        	</div>
            
            <hr>

            <div class="box-body table-responsive no-padding">
                
                    <?php
                    if(!empty($data)){
                        ?>
                        <table class="table table-striped" id="user-table" style="margin-top: 0px;">
                           
                        
                        <?php
                        foreach($data as $item)
                        {
                            $link = base_url().'user/messages/details/'.$item->id;
                            
                            $message_id = unreadMessageByid($item->id);
                            if(!empty($message_id)){
                                if($item->sender_id != $uid ){
                                    $total_un_read_message = unreadMessageByid($item->id);
                                    $unread ='<b style="color: green;">('.$total_un_read_message.' '.getlang('site_unread', 'data').')</b> ';
                                }else{
                                    $total_un_read_message ="";
                                    $unread ='';
                                }
                            }else{
                                $total_un_read_message ="";
                                $unread ='';
                            }
                            
                            if($item->recever_id==$uid){
                                $from_name = '<b>'.getlang('site_from', 'data').'</b> '.getSingledata('users', 'name', 'userId', $item->sender_id);
                            }else{
                                $from_name = '<b>'.getlang('site_to', 'data').'</b> '.getSingledata('users', 'name', 'userId', $item->recever_id);
                            }
                            
                           ?>
                        <tr class="">
                            <td class="left" width="200px" style="font-style: italic;"><?php echo $from_name; ?></td>
                            <td class="left">
                                <a href="<?php echo $link; ?>">
                                    <b><?php echo $item->subject; ?></b> : 
                                    <?php echo substr($item->message,0,20) ;?> <?php echo $unread; ?>
                                </a> 
                            </td>
                            <td class="center" width="180px"><?php echo date( 'g:i A Y-m-d ', strtotime($item->date_time)); ?></td>
                        </tr>
                        <?php
                        
                        }

                        ?>
                    </table>

                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>

                    <?php
                    }else{
                        echo '<p style="color: red;">'.getlang('site_empty_list', 'data').'</p>';
                    }
                    ?>
            </div>
        </div>
    </div>
</div>





