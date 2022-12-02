
<?php
    
    

    $token_name = $this->security->get_csrf_token_name();
    $token_hash = $this->security->get_csrf_hash();

    $message_id = '';
    $message_recever_id = '';
    $message_sender_id = '';
    $message_recever_name = '';
    $message_subject = '';
    $message_message = '';
    $message_date_time = '';

    if(!empty($data))
    {
        foreach ($data as $item)
        {
            $message_id           = $item->id;
			$message_recever_id   = $item->recever_id;
			$message_sender_id    = $item->sender_id;
			$message_recever_name = $item->recever_name;
			$message_subject      = $item->subject;
			$message_message      = $item->message;
			$message_date_time    = $item->date_time;
        }

    }

    // set receiver id
    if($message_sender_id == $uid){
    	$reply_form_recever_id = $message_recever_id;
    }else{
    	$reply_form_recever_id = $message_sender_id;
    }

     
    // Ger read status update by reciver id
    if(!empty($message_id)){
    	getMessagesstatusUpdate($message_id, $uid);
    }
    

	//Message list
	$messages       = getReplyMessages($message_id);
	$avator_message = getMessagesAvatar($message_sender_id);

?>

<style type="text/css">     
	.message_head {background: #f5f5f5;padding: 10px;display: inline-block;width: 96%;margin: 8px 0;}
	.message_head p {}
	.message {padding: 20px 10px;}
	.info-bar {display: inline-block;width: 100%;font-size: 12px;color: #666;}			
	.avator_meg, .message-body {display: inline-block;}
	.avator_meg {width: 10%;}
	.sender .avator_meg,.commone-avator {float: left;}
	.sender .info {float: left;}
	.sender .date-time, .sender .message-body {float: right;}
	.recever .avator_meg {float: right;text-align: right;}
	.recever .info {float: right;}
	.recever .date-time {float: left;}
	.message-body {width: 88%;background: #fff;padding: 1%;min-height: 50px;}
	.avator_m {margin: 0;}
	.megg{display: inline-block; width: 80%;}
	.date{display: inline-block; width: 20%;float: right; text-align: right;font-size: 11px;}
</style>


<div class="container">

    <div class="row">
        <div class="col-md-12">
            <?php echo getSystemMessage(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 left-sidebar"> <?php echo getUserPanel($role, $uid); ?></div>
        <div class="col-xs-12 col-sm-9 col-md-9 front-end-details">
        	
            <div class="box-body table-responsive no-padding">
            	<p class=""><b><?php echo getlang('site_msg_details_title', 'data')?>: <?php echo $message_subject; ?></b></p>
				<div class="message_head">
					<div class="avator avator_m commone-avator">
						<img src="<?php echo $avator_message; ?>" class="img-circle" alt="" style="width: 50px;height: 50px;" /> <br />
					</div>
					<div class="message-body" style="float: right;">
						<span class="date"><?php echo date( 'g:i A', strtotime($message_date_time)); ?> <br />
							<?php echo date( 'd M y', strtotime($message_date_time)); ?>
						</span>
						<span class="megg"><?php echo $message_message; ?></span>
					</div>
				</div>
			    <?php 
				$count = count($messages);
				if(!empty($count)){
					foreach($messages as $message){
						$reply_id         = $message->id;
						$reply_sender_id  = $message->sender_id;
						$reply_recever_id = $message->recever_id;
						$reply_message    = $message->message;
						$reply_date_time  = $message->date_time;
						$avator           = getMessagesAvatar($reply_sender_id);
										 
						if($message_sender_id ==$reply_sender_id){$add_class ='sender';}else{$add_class ='recever';}
						echo'<div class="message_head '.$add_class.'">';
						echo '<div class="avator avator_m avator_meg "><img src="'.$avator.'" class="img-circle" alt="" style="width: 50px;height: 50px;" /></div>';
						echo'<div class="message-body"><span class="date">'. date( 'g:i A', strtotime($reply_date_time)).'<br />'. date( 'd M y', strtotime($reply_date_time)).'</span><span class="megg">'. $reply_message.'</span></div>';
						echo'</div>';
					}
				}
				?>
				<form action="<?php echo base_url(); ?>user/messages/reply" method="post">
				    <textarea name="message" cols="" rows="" style="min-height: 100px;width: 96%;margin-bottom: 15px;" placeholder="<?php echo getlang('site_form_enter_message', 'data'); ?>"></textarea>
					<input type="submit" value="<?php echo getlang('site_btn_send', 'data'); ?>" class="btn btn-small" />
			        <input type="hidden" name="message_id" value="<?php echo $message_id; ?>"  />
					<input type="hidden" name="sender_id" value="<?php echo $uid; ?>"  />
					<input type="hidden" name="recever_id" value="<?php echo $reply_form_recever_id; ?>" id="recever_id" />
					<input type="hidden" id="csrf" name="<?php echo $token_name; ?>" value="<?php echo $token_hash; ?>" />
				</form>
            </div>
        </div>
    </div>
</div>





