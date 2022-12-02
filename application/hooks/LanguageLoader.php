<?php
class LanguageLoader
{
    function initialize() {
        $ci =& get_instance();
        $ci->load->helper('language');
        $ci->lang->load('system','english');
    }

    // function initialize() {
    //     $ci =& get_instance();
    //     $ci->load->helper('language');
    //     $siteLang = $ci->session->userdata('site_lang');

    //     if ($siteLang) {
    //         $ci->lang->load('system',$siteLang);
    //     } else {
    //         $ci->lang->load('system','english');
    //     }
    // }
}