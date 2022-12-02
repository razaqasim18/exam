
<?php
    $id = '';
    $title = '';
    $noticeText = '';

    if(!empty($data))
    {
        foreach ($data as $item)
        {
            $id = $item->id;
            $title = $item->title;
            $noticeText = $item->noticeText;
        }

    }


?>


<div class="container">

    <div class="row">
        <div class="col-md-12">
            <?php echo getSystemMessage(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 left-sidebar"> <?php echo getUserPanel($role, $uid); ?></div>
        <div class="col-xs-12 col-sm-9 col-md-9">
            <h1 class="user-page-title"><?php echo $title; ?></h1>
            <hr>
            <div class="notice-details">
                <?php echo $noticeText; ?>
            </div>
        </div>
    </div>
</div>





