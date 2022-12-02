<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    /*  
    *  @author     : ZWebTheme
    *  date        : October, 2017
    *  Admin - User Management System
    *  http://codecanyon.net/user/zwebtheme
    *  http://support.zwebtheme.com
    */

    /**
    ** Set Protocol function
    **/
    if(!function_exists('setProtocol')){
        function setProtocol()
        {
            $CI = &get_instance();
                        
            $CI->load->library('email');
            
            $config['protocol']  = getConfigItem('protocol');
            $config['mailpath']  = getConfigItem('mail_path');
            $config['smtp_host'] = getConfigItem('smtp_host');
            $config['smtp_port'] = getConfigItem('smtp_port');
            $config['smtp_user'] = getConfigItem('smtp_user');
            $config['smtp_pass'] = getConfigItem('smtp_pass');
            $config['charset'] = "utf-8";
            $config['mailtype'] = "html";
            $config['crlf'] = "\r\n"; 
            $config['newline'] = "\r\n";
            $config['wordwrap'] = TRUE;
            
            $CI->email->initialize($config);
            
            return $CI;
        }
    }


    /**
    ** Send Password Reset link to user
    * @param  $detail : data
    **/
    function send_resetpass_link($detail)
    {
        $mail_from = getConfigItem('email_form');
        $from_name = getConfigItem('from_name');
        $site_name = getConfigItem('site_name');
        $icon = getConfigItem('default_icon');
        if(empty($icon)){
            $icon_path = site_url('/uploads/logo/').'/icon.png';
        }else{
            $icon_path = site_url('/uploads/logo/').'/'.$icon;
        }

        $subject = getConfigItem('forgotpass_subject');
        $content = getConfigItem('forgotpass');
        $forgotpass_text = getConfigItem('forgotpass_text');
        

        $activation_link = $detail['reset_link'];

        $placeHolders = [
            '[USER_NAME]',
            '[RESET_LINK]',
        ];

        $values = [
            '<b>'.$detail["name"].'</b><br>',
            '<br><a style="display:inline-block;font-size:15px;padding:10px 18px;margin: 20px auto;vertical-align:middle;color:#ffffff;background:#34a8c4;border-top:solid 1px #2c8ea6;border-right:solid 1px #2c8ea6;border-bottom:solid 1px #2c8ea6;border-left:solid 1px #2c8ea6;border-radius:3px;text-decoration:none;white-space:normal;font-weight:bold;line-height:18px" href="'.$activation_link.'" target="_blank"> <span class="il"> '.$forgotpass_text.' </span></a><br>',
        ];
        $rendered = str_replace($placeHolders, $values, $content);
        $rendered = nl2br($rendered);

        $data['content'] = $rendered;
        $data['site_name'] = $site_name;
        $data['icon_path'] = 'http://zwebtheme.com/images/web_logo.png';
        
        $CI = setProtocol();    
        $CI->email->from($mail_from, $from_name);
        $CI->email->subject($subject);
        $CI->email->message($CI->load->view('email/resetpassword', $data, TRUE));
        $CI->email->to($detail["email"]);
        $status = $CI->email->send();
        //echo $CI->email->print_debugger();
        return $status;
    }


    /**
    ** Send Password Change Confirmation
    * @param  $email : user email
    * @param  $name : user full name
    **/
    function send_passchange_confirmation($email, $name) {
        $mail_from = getConfigItem('email_form');
        $from_name = getConfigItem('from_name');
        $site_name = getConfigItem('site_name');
        $icon = getConfigItem('default_icon');
        if(empty($icon)){
            $icon_path = site_url('/uploads/logo/').'/icon.png';
        }else{
            $icon_path = site_url('/uploads/logo/').'/'.$icon;
        }

        $subject = getConfigItem('pass_update_cinfirmation_subject');
        $content = getConfigItem('pass_update_cinfirmation');
        $time = date('Y-m-d H:i:s');

        $placeHolders = [
            '[USER_NAME]',
            '[UPDATE_TIME]',
        ];

        $values = [
            '<b>'.$name.'</b><br>',
            '<b>'.$time.'</b>',
        ];
        $rendered = str_replace($placeHolders, $values, $content);
        $rendered = nl2br($rendered);

        $data['content'] = $rendered;
        $data['site_name'] = $site_name;
        $data['icon_path'] = 'http://zwebtheme.com/images/web_logo.png';

        $CI = setProtocol();    
        $CI->email->from($mail_from, $from_name);  
        $CI->email->subject($subject);  
        $CI->email->message($CI->load->view('email/pass_update_confirmation', $data, TRUE));
        $CI->email->to($email);
        $status = $CI->email->send();
        return $status;
    }


    /**
    ** Send user data update Confirmation
    * @param  $email : user email
    * @param  $name : user full name
    **/
    function send_update_confirmation($email, $name) {
        $mail_from = getConfigItem('email_form');
        $from_name = getConfigItem('from_name');
        $site_name = getConfigItem('site_name');
        $icon = getConfigItem('default_icon');
        if(empty($icon)){
            $icon_path = site_url('/uploads/logo/').'/icon.png';
        }else{
            $icon_path = site_url('/uploads/logo/').'/'.$icon;
        }

        $subject = getConfigItem('user_udate_subject');
        $content = getConfigItem('user_update');
        $time = date('Y-m-d H:i:s');

        $placeHolders = [
            '[USER_NAME]',
            '[UPDATE_TIME]',
        ];

        $values = [
            '<b>'.$name.'</b><br>',
            '<b>'.$time.'</b>',
        ];
        $rendered = str_replace($placeHolders, $values, $content);
        $rendered = nl2br($rendered);

        $data['content'] = $rendered;
        $data['site_name'] = $site_name;
        $data['icon_path'] = 'http://zwebtheme.com/images/web_logo.png';

        $CI = setProtocol();    
        $CI->email->from($mail_from, $from_name);  
        $CI->email->subject($subject);  
        $CI->email->message($CI->load->view('email/user_update_confirmation', $data, TRUE));
        $CI->email->to($email);
        $status = $CI->email->send();
        return $status;
    }


    /**
    ** Send User activation link
    * @param  $email : user email
    * @param  $name : user full name
    * @param  $hash : hash vale that auto generated
    **/
    function send_activation_link($name, $email, $hash) {
        $mail_from = getConfigItem('email_form');
        $from_name = getConfigItem('from_name');
        $site_name = getConfigItem('site_name');
        $icon = getConfigItem('default_icon');
        if(empty($icon)){
            $icon_path = site_url('/uploads/logo/').'/icon.png';
        }else{
            $icon_path = site_url('/uploads/logo/').'/'.$icon;
        }

        $subject = getConfigItem('user_activation_mail_subject');
        $content = getConfigItem('user_activation');
        $user_activation_text = getConfigItem('user_activation_text');

        $activation_link = base_url() . 'verify?' . 'email=' . $email . '&hash=' . $hash;

        $placeHolders = [
            '[USER_NAME]',
            '[USER_EMAIL]',
            '[ACTIVATION_LINK]',
            '[SITE_NAME]',
        ];

        $values = [
            '<b>'.$name.'</b><br>',
            '<b>'.$email.'</b>',
            '<br><a style="display:inline-block;font-size:15px;padding:10px 18px;margin: 20px auto;vertical-align:middle;color:#ffffff;background:#34a8c4;border-top:solid 1px #2c8ea6;border-right:solid 1px #2c8ea6;border-bottom:solid 1px #2c8ea6;border-left:solid 1px #2c8ea6;border-radius:3px;text-decoration:none;white-space:normal;font-weight:bold;line-height:18px" href="'.$activation_link.'" target="_blank"> <span class="il"> '.$user_activation_text.' </span></a><br>',
            '<b>'.$site_name.'</b>',
        ];
        $rendered = str_replace($placeHolders, $values, $content);
        $rendered = nl2br($rendered);

        $data['content'] = $rendered;
        $data['site_name'] = $site_name;
        $data['icon_path'] = 'http://zwebtheme.com/images/web_logo.png';

        $CI = setProtocol();    
        $CI->email->from($mail_from, $from_name);  
        $CI->email->subject($subject);  
        $CI->email->message($CI->load->view('email/account_new', $data, TRUE));
        $CI->email->to($email);
        $status = $CI->email->send();
        return $status;
    }

    /**
    ** Send notification to admin for new user
    * @param  $email : user email
    * @param  $name : user full name
    **/
    function send_notification_admin($name, $email) {
        $mail_from = getConfigItem('email_form');
        $from_name = getConfigItem('from_name');
        $site_name = getConfigItem('site_name');
        $icon = getConfigItem('default_icon');
        if(empty($icon)){
            $icon_path = site_url('/uploads/logo/').'/icon.png';
        }else{
            $icon_path = site_url('/uploads/logo/').'/'.$icon;
        }

        
        $subject = getConfigItem('new_user_notify_admin_subject');
        $content = getConfigItem('new_user_notify_admin');

        $placeHolders = [
            '[USER_NAME]',
            '[USER_EMAIL]',
        ];

        $values = [
            '<b>'.$name.'</b><br>',
            '<b>'.$email.'</b>',
        ];
        $rendered = str_replace($placeHolders, $values, $content);
        $rendered = nl2br($rendered);

        $data['content'] = $rendered;
        $data['site_name'] = $site_name;
        $data['icon_path'] = 'http://zwebtheme.com/images/web_logo.png';

        $CI = setProtocol();    
        $CI->email->from($mail_from, $from_name);  
        $CI->email->subject($subject);  
        $CI->email->message($CI->load->view('email/new_user', $data, TRUE));
        $CI->email->to($mail_from);
        $status = $CI->email->send();
        return $status;
    }

    /**
    ** Send Notice Confirmation
    * @param  $email : user email
    * @param  $notice_title : notice title
    * @param  $notice : notice details
    **/
    function send_notice_confirmation($email, $notice_title, $notice) {
        $mail_from = getConfigItem('email_form');
        $from_name = getConfigItem('from_name');
        $site_name = getConfigItem('site_name');
        $icon = getConfigItem('default_icon');
        if(empty($icon)){
            $icon_path = site_url('/uploads/logo/').'/icon.png';
        }else{
            $icon_path = site_url('/uploads/logo/').'/'.$icon;
        }

        $subject = getConfigItem('notice_subject');
        $content = getConfigItem('notice');

        $placeHolders = [
            '[NOTICE_TITLE]',
            '[NOTICE_DETAILS]',
        ];

        $values = [
            '<b>'.$notice_title.'</b><br>',
            '<b>'.$notice.'</b><br>',
        ];
        $rendered = str_replace($placeHolders, $values, $content);
        $rendered = nl2br($rendered);

        $data['content'] = $rendered;
        $data['site_name'] = $site_name;
        $data['icon_path'] = 'http://zwebtheme.com/images/web_logo.png';

        $CI = setProtocol();    
        $CI->email->from($mail_from, $from_name);  
        $CI->email->subject($subject);  
        $CI->email->message($CI->load->view('email/notice_confirmation', $data, TRUE));
        $CI->email->to($email);
        $status = $CI->email->send();
        return $status;
    }

