
<?php


$id = '';
$title = '';
$title_native = '';
$lang_code = '';
$image = '';
$published = '';
$direction = '';
$lang_data = '';
$data = '';
$param = '';
$sys_param = '';
if(!empty($language_data))
{
    foreach ($language_data as $item)
    {
        $id = $item->id;
        $title = $item->title;
        $title_native = $item->title_native;
        $lang_code = $item->lang_code;
        $image = $item->image;
        $published = $item->published;
        $direction = $item->direction;
        $lang_data = $item->lang_data;
        $data = $item->data;
        $param = json_decode($data,true);

        $sys_data = $item->sys_data;
        $sys_param = json_decode($sys_data,true);
        
    }
}

$direction_list = getDirection('direction', $direction);
$status_list =  getStatus('published', $published);
$flag_list = getFlags('image', $image);


if(empty($image)){
    $flug_path = site_url('/uploads/lang/').'/flag.gif';
}else{
    $flug_path = site_url('/uploads/lang/').'/'.$image.'.gif';
}



?>


<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <?php echo sectionHeader('Language Form', 'Add / Edit language', 'fa-language'); ?>
    
    <section class="content">

        <div class="row">
             <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>
    


        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header">
                        <!-- <h3 class="box-title">Enter Subject Details</h3> -->
                    </div>

                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addlanguage" class="" action="<?php echo base_url().ADMIN_ALIAS; ?>/languages/add" method="post" role="form">
                        <div class="box-body">

                            

                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#general">General</a></li>
                                <li><a data-toggle="tab" href="#data">Front-end Language Data</a></li>
                                <li><a data-toggle="tab" href="#system_masg">Back-end Language Data</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="general" class="tab-pane fade in active">
                                    <p></p>

                                    <fieldset class="form-horizontal">
                                    <div class="row">
                                        <div class="col-md-6"><?php echo fieldBuilder('input', 'title', $title, 'Title', 'required'); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6"><?php echo fieldBuilder('input', 'title_native', $title_native, 'Native Title', 'required'); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6"><?php echo fieldBuilder('input', 'lang_code', $lang_code, 'Lang Code', 'required'); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="s_image" class="col-sm-4 control-label">Flag image</label>
                                                <div class="col-sm-7"><?php echo $flag_list; ?></div>
                                                <div class="col-sm-1"><img src="<?php echo $flug_path; ?>" id="flag_icon" alt="<?php echo $image; ?>" ></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6"><?php echo fieldBuilder('select', 'direction', $direction_list, 'Direction', 'required'); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6"><?php echo fieldBuilder('select', 'published', $status_list, 'Published', 'required'); ?></div>
                                    </div>

                                   <!--  <div class="row">
                                    <div class="col-md-6"><?php  //echo fieldBuilder('textarea', 'lang_data', $lang_data, 'Custom Language Data', ''); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="col-sm-4 control-label"></label>
                                                <div class="col-sm-8"><p>Please put each data with comma.</p></div>
                                            </div>
                                        </div>
                                    </div>
 -->
                                    </fieldset>
                                </div>

                                <div id="data" class="tab-pane fade ">
                                    <p></p>
                                    <fieldset class="form-vertical language-fielset"> 
                                    <div class="row">

                                        <?php 
                                        $site_lang_data = getSiteLang();
                                        foreach ($site_lang_data as $key => $lang_item) {
                                        	$lang_item_as_title = $lang_item;
                                            $site_lang_item_as_alias = $key;
                                        	$lang_item_as_alias = str_replace(' ', '', strtolower($lang_item));
                                            if ($site_lang_item_as_alias == 'menu_title') {
                                                echo '<div class="col-md-12"><h3>'.$lang_item_as_title.'</h3></div>';
                                            }elseif($site_lang_item_as_alias == 'site_browser_title'){
                                                echo '<div class="col-md-12"><h3>'.$lang_item_as_title.'</h3></div>';
                                            }elseif ($site_lang_item_as_alias == 'site_message_title') {
                                                echo '<div class="col-md-12"><h3>'.$lang_item_as_title.'</h3></div>';
                                            }elseif ($site_lang_item_as_alias == 'site_button') {
                                                echo '<div class="col-md-12"><h3>'.$lang_item_as_title.'</h3></div>';

                                            }elseif ($site_lang_item_as_alias == 'site_title') {
                                                echo '<div class="col-md-12"><h3>'.$lang_item_as_title.'</h3></div>';
                                            }elseif ($site_lang_item_as_alias == 'site_tab') {
                                                echo '<div class="col-md-12"><h3>'.$lang_item_as_title.'</h3></div>';
                                            }elseif ($site_lang_item_as_alias == 'site_form_field') {
                                                echo '<div class="col-md-12"><h3>'.$lang_item_as_title.'</h3></div>';
                                            }elseif ($site_lang_item_as_alias == 'site_others') {
                                                echo '<div class="col-md-12"><h3>'.$lang_item_as_title.'</h3></div>';
                                            }else{
                                                echo langField($param, $site_lang_item_as_alias, $lang_item_as_title);
                                            }

                                        	
                                        }
                                        
                                        ?>
                                    </div>
                                    </fieldset>

                                </div>

                                <div id="system_masg" class="tab-pane fade ">
                                    <p></p>
                                    <fieldset class="form-vertical language-fielset"> 
                                    <div class="row">
                                    <?php 
                                    $system_lang_data = getSystemLang();
                                    //var_dump($system_lang_data);
                                        foreach ($system_lang_data as $key => $system_lang_item) {
                                        	$system_lang_item_as_title = $system_lang_item;
                                        	$system_lang_item_as_alias = $key;

                                            if($system_lang_item_as_alias == 'menu_title'){
                                                echo '<div class="col-md-12"><h3>'.$system_lang_item_as_title.'</h3></div>';
                                            }elseif($system_lang_item_as_alias == 'title_section'){
                                                echo '<div class="col-md-12"><h3>'.$system_lang_item_as_title.'</h3></div>';
                                            }


                                            elseif($system_lang_item_as_alias == 'default_word'){
                                                echo '<div class="col-md-12"><h3>'.$system_lang_item_as_title.'</h3></div>';
                                            }elseif($system_lang_item_as_alias == 'browser_tab_title'){
                                                echo '<div class="col-md-12"><h3>'.$system_lang_item_as_title.'</h3></div>';
                                            }elseif($system_lang_item_as_alias == 'button_section'){
                                                echo '<div class="col-md-12"><h3>'.$system_lang_item_as_title.'</h3></div>';
                                            }elseif($system_lang_item_as_alias == 'tab_section'){
                                                echo '<div class="col-md-12"><h3>'.$system_lang_item_as_title.'</h3></div>';
                                            }elseif ($system_lang_item_as_alias == 'month_section') {
                                                echo '<div class="col-md-12"><h3>'.$system_lang_item_as_title.'</h3></div>';
                                                
                                            }elseif($system_lang_item_as_alias == 'system_message_section'){
                                                echo '<div class="col-md-12"><h3>'.$system_lang_item_as_title.'</h3></div>';
                                            }elseif($system_lang_item_as_alias == 'other_section'){
                                                echo '<div class="col-md-12"><h3>'.$system_lang_item_as_title.'</h3></div>';
                                            }else{
                                                echo langField($sys_param, $system_lang_item_as_alias, $system_lang_item_as_title, 'sys_param');
                                            }
                                        	
                                        }
                                    ?>
                                    </div>
                                    </fieldset>
                                    
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
                                            <a class="btn  btn-default" href="<?php echo base_url().ADMIN_ALIAS.'/languages'; ?>" title="<?php echo getlang('cancel', 'sys_data'); ?>"> <?php echo getlang('btn_cancel', 'sys_data'); ?> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    </form>
                    <!-- form end -->

                </div>
            </div>
        </div> 
           
    </section>
    
</div>

<script type="text/javascript">
    jQuery( "#s_image" ).change(function() { 
        var image = jQuery("#s_image").val();
        jQuery('#flag_icon').attr('src', '<?php echo site_url('/uploads/lang/'); ?>'+image+'.gif');
    });
</script>
