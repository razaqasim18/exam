

<div class="container">

    <div class="row">
        <div class="col-md-12">
            <?php echo getSystemMessage(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 left-sidebar"> <?php echo getUserPanel($role, $uid); ?></div>
        <div class="col-xs-12 col-sm-9 col-md-9">
            <h1 class="user-page-title"><i class="fa fa-bell"></i> <?php echo getlang('site_notice_list_tittle', 'data'); ?></h1>

            <hr>

            <div class="box-body table-responsive no-padding">
                <ul class="notice-list">
                    <?php
                    if(!empty($data)){
                        foreach($data as $item)
                        {
                            
                            if(!empty($item->readNotice)){
                                $user_id = $this->uid;
                                $user_ids = explode(",", $item->readNotice);
                                if (in_array($user_id, $user_ids))
                                {
                                    $unread = 0;
                                }else {
                                    $unread = 1;
                                }
                                
                            }else{

                                $unread = 1;
                            }

                            if(!empty($unread)){
                                $label = 'alert-success';
                            }else{
                                $label = 'alert-light';
                            }

                        echo '<li>
                        <div class="alert '.$label.'" style="margin-bottom: 5px;"> 
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-8">
                                <a href="'.base_url().'user/notice/details/'.$item->id.'"><b>'.$item->title.'</b></a>
                                <p>'.substr($item->noticeText,0,20).'</p> 
                                </div>
                                <div class="col-sm-4 text-right">
                                <p>'.date( 'g:i A Y-m-d ', strtotime($item->createDate)).'</p>
                                </div>
                            </div>
                        </div>
                        
                        
                        </div>
                        </li>';
                        }

                        ?>
                        <div class="box-footer clearfix">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                        <?php
                    }else{
                        echo '<p style="color: red;">'.getlang('site_empty_list', 'data').'</p>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>







