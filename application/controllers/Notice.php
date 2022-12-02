<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/*  
*  @author     : ZWebTheme
*  date        : October, 2017
*  Admin - User Management System
*  http://codecanyon.net/user/zwebtheme
*  http://support.zwebtheme.com
*/

require APPPATH . '/libraries/FrontEndController.php';

class Notice extends FrontEndController
{


    /**
    ** This is default constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('notice_model');
        $this->load->database();
        $this->load->library('session');
        $this->isLoggedIn();   
    }
    
    
    /**
    ** Notice list
    **/
    function nlist()
    {
        $disable_notice = getConfigItem('disable_notice');
        if (empty($disable_notice)) {
          
            $browser_title = getlang('site_browser_notice_page_title', 'data');
            
            $this->load->library('pagination');
            
            $count = $this->notice_model->getNoticeCount($this->role);

            $per_item = getConfigItem('item_per_list');
            if(empty($per_item)){$per_item = 10;}
    		$returns = $this->paginationCompress ( "user/notice", $count, $per_item, 3 );

            $data['data'] = $this->notice_model->getNotice($this->role, $returns["page"], $returns["segment"]);

            
            $this->global['pageTitle'] = $browser_title;
            $this->global['meta_description'] = '';
            $this->global['meta_tag']         = '';
            $this->global['author']           = '';
            $this->loadViews('rocky', "frontend/notice/default", $this->global, $data , NULL);
        }else{
            redirect('user/dashboard');
        }
        
    }

    /**
    ** Notice Details
    **/
    function details($id = null)
    {
        if(!empty($id)){

            $browser_title = getlang('site_browser_notice_details_page_title', 'data');
            $this->global['pageTitle'] = $browser_title;

            $notice_data = $this->notice_model->getNoticeInfo($id);

            if(!empty($notice_data)){
                $notice_id = '';
                $exit_data = '';
                $exit_hit = '';
                foreach ($notice_data as $item)
                {
                    $notice_id = $item->id;
                    $exit_data = $item->readNotice;
                    $exit_hit = $item->hit;
                }

                $user_id = $this->uid;

                // Setting read/unread section
                if(!empty($exit_data)){
                    // exit reded id to make arry
                    $user_ids = explode(",", $exit_data);

                    // check if exit
                    if (in_array($user_id, $user_ids))
                    {

                    }else {
                        // get seeting if unread - get push id 
                        array_push($user_ids, $user_id);
                        // make this ids as string
                        $read_ids = implode(",",$user_ids);
                        // get exit data update
                        $this->notice_model->read($notice_id, $read_ids);
                    }
                }else{
                    $read_ids = $user_id;
                    $this->notice_model->read($notice_id, $read_ids);
                }

                // manage hit
                $final_hit = ($exit_hit + 1);
                $this->notice_model->hit($notice_id, $final_hit);
                
            }


            $data['data'] = $notice_data;
            $this->global['meta_description'] = '';
            $this->global['meta_tag']         = '';
            $this->global['author']           = '';
            $this->loadViews('rocky', "frontend/notice/details", $this->global, $data , NULL);
        }else{

        } 
    }

    
}

