

    <?php

    $disable_notice = getConfigItem('disable_notice');
	
	$avator = getSingledata('users', 'avatar', 'userId', $uid);
	if(empty($avator)){
		$img_path = site_url('/uploads/users/').'/avator.png';
	}else{
		$img_path = site_url('/uploads/users/').'/'.$avator;
	}
	
	?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 left-sidebar"> <?php echo getUserPanel($role, $uid); ?></div>

        <div class="col-xs-12 col-sm-9 col-md-9">
        <h1><?php echo getlang('site_welcome_title', 'data'); ?> <span class="green"><?php echo $this->name; ?></span></h1>
        <p><?php echo getlang('site_last_login', 'data'); ?> <b><?php echo $this->lastLogin; ?></b></p>


        <!-- Latest Message -->
        <div class=" message message_box">
            <h3 style="margin-top: 56px;"><i class="fa fa-envelope-open"></i> <?php echo getlang('site_latest_msg_title', 'data'); ?></h3>  
            <ul class="notice-list">
                <?php 
                $message_list = getLatestMessage($this->uid);
                foreach ($message_list as $i => $item) :
                    $link = base_url().'user/messages/details/'. $item->id;
                    $message_id = unreadMessageByid($item->id);
                    if(!empty($message_id)){
                        if($item->sender_id != $this->uid ){
                            $total_un_read_message = unreadMessageByid($item->id);
                            $unread ='<b style="color: green;">('.$total_un_read_message.' '.getlang('site_unread', 'data').')</b> ';
                            $label = 'alert-success';
                        }else{
                            $total_un_read_message ="";
                            $unread ='';
                             $label = 'alert-light';
                        }
                    }else{
                        $total_un_read_message ="";
                        $unread ='';
                        $label = 'alert-light';
                    }
                                    
                    if($item->recever_id==$this->uid){
                        $from_name = '<b>'.getlang('site_from', 'data').'</b> '.getSingledata('users', 'name', 'userId', $item->sender_id);
                    }else{
                        $from_name = '<b>'.getlang('site_to', 'data').'</b> '.getSingledata('users', 'name', 'userId', $item->recever_id);
                    }

                    $main_message = substr($item->message,0,20);
                    $text = str_replace('<br />', PHP_EOL, $main_message);
                    ?>


                    <li>
                        <div class="alert <?php echo $label; ?>" style="margin-bottom: 5px;" > 
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-3">
                                <?php echo $from_name; ?>
                                </div>

                                <div class="col-sm-5">
                                    <a href="<?php echo $link; ?>">
                                    <b><?php echo $item->subject; ?></b>  
                                    <p><?php echo  $text; ?> <?php echo $unread; ?></p>
                                    </a> 
                                </div>
                                <div class="col-sm-4 text-right">
                                <?php echo date( 'g:i A Y-m-d ', strtotime($item->date_time)); ?>
                                </div>
                            </div>
                        </div>
                        </div>
                    </li>

                    
                <?php endforeach;  ?>
            </ul>
        </div>

     
        <!-- Show notice module -->
        <?php if (empty($disable_notice)) {?>
        <h3 style="margin-top: 56px;"><i class="fa fa-bell"></i> <?php echo getlang('site_latest_notice_title', 'data'); ?></h3>
        <div id="notice" ></div>
        <?php } ?>
        
        </div>
    </div>
</div>

<?php if (empty($disable_notice)) { ?>
<script type="text/javascript">
	/**
	** Latest Notice Module js script
	**/
    function loadNotice(){    
    	var hitURL = '<?php echo base_url(); ?>' + "user/latestnotice";
        $.ajax({
            url: hitURL,
            cache: false,
            success: function(html){       
                $("#notice").html(html); 
            },
        });
    }
    setInterval (loadNotice, 500);
</script>
<?php } ?>