<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/FrontEndController.php';


class Subjects extends FrontEndController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->isLoggedIn();
    }

    /**
     ** Get Subjects List
     **/
    function Subjectslist()
    {
        $CI          = &get_instance();
        $CI->db->select('subjects');
        $CI->db->from('students');
        $CI->db->where('userid', $this->uid);
        $query   = $CI->db->get();
        $results = $query->row();

        $subjects = unserialize($results->subjects);


        $this->global['pageTitle'] = getlang('site_browser_subjects_title', 'data');
        $this->global['meta_description'] = '';
        $this->global['meta_tag']         = '';
        $this->global['author']           = '';

        $data['subjects'] = $subjects;
        if ($this->isStudent() == TRUE) {

            $this->loadViews('rocky', "frontend/subjects/student_subjects", $this->global, $data, NULL);
        }
    }
}
