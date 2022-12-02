<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    /*  
    *  @author     : ZWebTheme
    *  date        : October, 2017
    *  Admin - User Management System
    *  http://codecanyon.net/user/zwebtheme
    *  http://support.zwebtheme.com
    */

    /**
    ** Preloader
    * @param  $name : style name
    * @param  $id : exit id
    **/
    function getPreloaderStyle($name, $id){
        $list = array(
            '1' => 'Style 1', 
            '2' => 'Style 2',
            '3' => 'Style 3',
            '4' => 'Style 4'
        );

        $output = '<select name="'.$name.'" id="s_'.$name.'" class="form-control" >';
        foreach ($list as $key => $item) {
            if ($key == $id ) {
                $output .= '<option selected="selected" value="'.$key.'">'.$item.'</option>';
            }else{
                $output .= '<option value="'.$key.'">'.$item.'</option>';
            }
        }
        $output .= '</select>';
        return $output;
    }

    /**
    ** Select Configuration
    * @param  $select_field : param field name
    **/
    function getParam($select_field){
        $CI =& get_instance();
        $CI->db->select($select_field);
        $CI->db->from('config');
        $CI->db->where('id', 1);
        $query = $CI->db->get();
        $results = $query->row();
        $output = $results->$select_field;
        return $output;
    }

    /**
    ** Configuration
    * @param  $tab : Configuration tab name
    **/
    function getConfigData($tab){
        
        // Set General Configuration
        $config_general = array(
            array('site_name','Site Name','input'),
            array('address','Address','textarea'),
            array('email','Email','input'),
            array('phone','Phone','input'),
            array('website','Website','input'),
            array('default_language','Default Language','select'),
            array('default_theme','Default Admin Theme','select'),
            array('item_per_list','Item per list','input'),
            array('image_supported_type','Image Supported Type','input'),
            array('help_22','Example: <b>gif | jpg | png</b> <br> The mime types corresponding to the types of files you allow to be uploaded. Usually the file extension can be used as the mime type. Can be either an array or a pipe-separated string.','help'),

            array('image_supported_size','Image Max Size','input'),
            array('help_22','The maximum size (in kilobytes) that the file can be. Set to zero for no limit. Note: Most PHP installations have their own limit, as specified in the php.ini file. Usually 2 MB (or 2048 KB) by default.','help')
        );

        // Set Mail Configuration
        $config_mail = array(
            array('email_form','Email From','input'),
            array('from_name','From Name','input'),
            array('protocol','Protocol','input'),
            array('smtp_host','SMTP host','input'),
            array('smtp_port','SMTP port','input'),
            array('smtp_user','SMTP Username','input'),
            array('smtp_pass','SMTP Password','input'),
            array('mail_path','Mail Path','input')
        );

        // Set File Configuration
        $config_file = array(
            array('default_icon', 'default_icon_old', 'Default Icon', '/uploads/logo/', 'icon.png'),
            array('default_favicon', 'default_favicon_old', 'Default Favicon', '/uploads/logo/', 'favicon.png'),
            array('default_logo', 'default_logo_old', 'Default Logo', '/uploads/logo/', 'logo.png'),
            array('second_logo', 'second_logo_old', 'Second Logo', '/uploads/logo/', 'logo2.png'),
            array('404_background', '404_background_old', '404 Page', '/uploads/logo/', 'bsms.jpg'),
            array('login_background', 'login_background_old', 'Login Page', '/uploads/logo/', 'bsms.jpg')
        );

        // Set 404 Configuration
        $config_404 = array(
            array('404_title','Title','input'),
            array('404_browser_title','Browser Title','input'),
            array('404_description','Description','textarea')

        );

        // Set theme
        $config_theme = array(
            array('preloader','Preloader','select'),
            array('preloader_style','Preloader Style','select'),
            array('scroll_to_top','Scroll to Top','select'),
            array('header','Header','textarea'),
            array('help_header','[LOGO],  [USER_MENU],[OFFCANVAS], [LANG_SWITCH]','help'),
            array('header_bg','Header BG','color'),
            array('header_text','Header Text','color'),
            array('line1','line1','hr'),

            array('body_bg','Body BG','color'),
            array('body_text','Body Text','color'),
            array('line2','line2','hr'),

            array('footer','Footer','textarea'),
            array('footer_bg','Footer BG','color'),
            array('footer_text','Footer Text','color')
            
        );

        // Set Mail Template
        $config_mailtemplate = array(
            array('user_activation_mail_subject','User Activation Subject','input'),
            array('user_activation','User Activation','textarea'),
            array('help_1','[USER_NAME], [USER_EMAIL], [ACTIVATION_LINK], [SITE_NAME]','help'),
            array('user_activation_text','User Activation Button Text','input'),
            array('line1','line1','hr'),

            array('enable_user_udate','Enable Update Email','checkbox'),
            array('user_udate_subject','User Update Subject','input'),
            array('user_update','User Update','textarea'),
            array('line2','line1','hr'),

            array('enable_admin_notify','Enable Admin Notification','checkbox'),
            array('new_user_notify_admin_subject','New User Notify Admin Subject','input'),
            array('new_user_notify_admin','New User Notify Admin','textarea'),
            array('help_2','[USER_NAME], [USER_EMAIL]','help'),
            array('line3','line1','hr'),

            array('forgotpass_subject','Forgot Password Subject','input'),
            array('forgotpass','Forgot Password','textarea'),
            array('help_3','[USER_NAME], [RESET_LINK]','help'),
            array('forgotpass_text','Forgot Password Button Text','input'),
            array('line31','line1','hr'),

            array('enable_pass_update_confirm','Enable Password Update Conformation','checkbox'),
            array('pass_update_cinfirmation_subject','Password Update Confirmation Subject','input'),
            array('pass_update_cinfirmation','Password Update Confirmation','textarea'),
            array('help_4','[USER_NAME], [UPDATE_TIME]','help'),
            array('line4','line2','hr'),

            array('enable_notice_notify','Enable Notice Notification','checkbox'),
            array('notice_subject','Notice Notification Subject','input'),
            array('notice','Notice Notification','textarea'),
            array('help_4','[NOTICE_TITLE], [NOTICE_DETAILS]','help')
            
        );

        // Set Payment
        $config_payment = array(
            array('default_payment','Default payment method','select'),
            array('currency_code','Currency Code','input'),
            array('currency_sign','Currency Sign','input'),
            array('decimal_places','Decimal Places','input'),
            array('currency_position','Currency Position','select')
        );

        // Set Offline
        $config_offline = array(
            array('message','Message','textarea')
        );

        // Set Paypal
        $config_paypal = array(
            array('business','Paypal email Address','input'),
            array('help_1','Enter your paypal business email address.','help'),
            array('sandbox','Enable sandbox mode','checkbox'),
            array('secure_post','Secure post (use https) ?','checkbox')
        );

        // Set Account
        $config_account = array(
            array('disable_signup','Disable Signup','checkbox'),
            array('disable_logs','Disable Login Activity','checkbox'),
            array('disable_changephoto','Disable Change Photo','checkbox'),
            array('disable_notice','Disable Notice','checkbox')
        );

        if($tab == 'general'){
            return $config_general;
        }

        if($tab == 'mail'){
            return $config_mail;
        }

        if($tab == 'file'){
            return $config_file;
        }

        if($tab == '404'){
            return $config_404;
        }

        if($tab == 'theme'){
            return $config_theme;
        }

        if($tab == 'mailtemplate'){
            return $config_mailtemplate;
        }  

        if($tab == 'paypal'){
            return $config_paypal;
        } 

        if($tab == 'offline'){
            return $config_offline;
        }  

        if($tab == 'account'){
            return $config_account;
        }  

        if($tab == 'payment'){
            return $config_payment;
        }  
    }

    /**
    ** Get Configuration Item
    * @param  $field : field name
    **/
    function getConfigItem($field){
        
        // Get config param data
        $param_data = getParam('param_data');
        $params = json_decode($param_data,true);

        if(!empty($params[$field][0])){
            $output = $params[$field][0];
        }else{
            $output = '';
        }
        return $output;
    }

    /**
    ** Get Paypal Configuration
    **/
    function getPaymentConfig($method_id, $field){
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('payment_method');
        $CI->db->where('id', $method_id);
        $query = $CI->db->get();
        $results = $query->row();
        $param_data = $results->data;

        $params = json_decode($param_data,true);

        if(!empty($params[$field][0])){
            $output = $params[$field][0];
        }else{
            $output = '';
        }
        return $output;
    }

    /**
    ** Param data preview check-up for language field
    * @param  $param_data : param data object
    * @param  $field : field name
    **/
    function pdchecker($param_data, $field){
        if(!empty($param_data[$field][0])){
            $output = $param_data[$field][0];
        }else{
            $output = '';
        }
        return $output;
    }

    /**
    ** Use for label
    * @param  $label_name : label name
    **/
    function getlabel($label_name){
        $output = '<div class="col-md-12 label" style=" margin:20px 0;">';
        $output .= '<p style="padding:10px; background:#ccc; color:#000;margin:0; font-size:20px;">';
        $output .= $label_name;
        $output .='</p>';
        $output .='</div>';
        return $output;
    }

    /**
    ** Get Admin Theme list
    * @param  $name : theme name
    * @param  $id : exit id
    **/
    function gettheme($name, $id){
        $list = array(
            'skin-blue' => 'Skin Blue',
            'skin-blue-light' => 'Skin blue light',
            'skin-yellow' => 'Skin yellow',
            'skin-yellow-light' => 'Skin yellow light',
            'skin-green' => 'Skin green',
            'skin-green-light' => 'Skin green light',
            'skin-purple' => 'Skin purple',
            'skin-purple-light' => 'Skin purple light',
            'skin-red' => 'Skin red',
            'skin-red-light' => 'Skin red light',
            'skin-black' => 'Skin black',
            'skin-black-light' => 'Skin black light'
        );
        
        $output = '<select name="'.$name.'" id="s_'.$name.'" class="form-control" >';
        foreach ($list as $key => $item) {
            if ($key == $id ) {
                $output .= '<option selected="selected" value="'.$key.'">'.$item.'</option>';
            }else{
                $output .= '<option value="'.$key.'">'.$item.'</option>';
            }
        }
        $output .= '</select>';
        return $output;
    }

    /**
    ** Get Method list
    **/
    function getMethodList($field, $ids){
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('payment_method');
        $CI->db->where('published', 1);
        $query = $CI->db->get();
        $results = $query->result();

        $output = '<select name="'.$field.'" id="language_'.$field.'" class="form-control " >';
        $output .='<option value="0" > Select method </option>';
        foreach ($results as $key => $item) {
            $id = $item->id;
            if ($id == $ids) {
                $output .= '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
            }else{
                $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
            }
        }
        $output .= '</select>';
        return $output;
    }

    /**
    ** Get Currency Position List
    **/
    function getCurrencyPositionList($name, $id){
        $list = array(
            'after' => 'After',
            'before' => 'Before'
        );
        
        $output = '<select name="'.$name.'" id="s_'.$name.'" class="form-control" >';
        foreach ($list as $key => $item) {
            if ($key == $id ) {
                $output .= '<option selected="selected" value="'.$key.'">'.$item.'</option>';
            }else{
                $output .= '<option value="'.$key.'">'.$item.'</option>';
            }
        }
        $output .= '</select>';
        return $output;
    }

