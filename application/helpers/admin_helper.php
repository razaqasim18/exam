<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 *  @author     : ZWebTheme
 *  date        : October, 2017
 *  Admin - User Management System
 *  http://codecanyon.net/user/zwebtheme
 *  http://support.zwebtheme.com
 */

/**
 * Set AdminCSS Files
 * @param string $template_name : This is admin template folder name
 * @return $output : This is output to set on header
 **/
function setAdminCSS($template_name)
{
    $admin_css_path = base_url() . 'assets/backend/' . $template_name . '/css/';
    $output         = '
            <link href="' . $admin_css_path . 'bootstrap.min.css" rel="stylesheet" type="text/css" />
            <link href="' . $admin_css_path . 'font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
            <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
            <link href="' . base_url() . 'assets/backend/' . $template_name . '/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet"/>
            <link href="' . base_url() . 'assets/backend/' . $template_name . '/plugins/iCheck/all.css" rel="stylesheet"/>
            <link href="' . $admin_css_path . 'AdminLTE.min.css" rel="stylesheet" type="text/css" />
            <link href="' . $admin_css_path . 'skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
            <link href="' . $admin_css_path . 'custom.css" rel="stylesheet" type="text/css" />
            <link href="' . $admin_css_path . 'sumoselect.min.css" rel="stylesheet" type="text/css" />
        ';

    return $output;
}

/**
 ** Set AdminJS Files
 * @param string $template_name : This is admin template folder name
 * @return $output : This is output to set on header
 **/
function setAdminJS($template_name)
{
    $admin_css_path = base_url() . 'assets/backend/' . $template_name . '/js/';
    $output         = '
            <script src="' . $admin_css_path . 'jQuery-2.1.4.min.js"></script>
            <script src="' . $admin_css_path . 'bootstrap.min.js" type="text/javascript"></script>
            <script src="' . base_url() . 'assets/backend/' . $template_name . '/plugins/colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script>
            <script src="' . base_url() . 'assets/backend/' . $template_name . '/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
            <script src="' . $admin_css_path . 'app.min.js" type="text/javascript"></script>
            <script src="' . base_url() . 'assets/backend/' . $template_name . '/plugins/chartjs/Chart.js"></script>
            <script src="' . $admin_css_path . 'dashboard.js" type="text/javascript"></script>
            <script type="text/javascript">var baseURL = "' . base_url() . '";</script>
            <script src="' . $admin_css_path . 'common.js"></script>
            <script src="' . $admin_css_path . 'jquery.sumoselect.min.js"></script>
        ';

    return $output;
}

/**
 ** Default function for upload image / files
 * @param string $new_file   : This is new file name
 * @param string $old_file   : This is old file name
 * @param string $field      : This is input name
 * @param string $path       : This is file destination path
 * @param string $type       : This is file extension type
 * @param string $max_size   : This is file maximum upload size
 * @param string $max_width  : This is file maximum width value
 * @param string $max_height : This is file maximum height value
 * @return $file             : This is uploaded file
 **/
function uploadImage($new_file, $old_file, $field, $path, $type, $max_size, $max_width, $max_height)
{
    $image_supported_type = getConfigItem('image_supported_type');
    $image_supported_size = getConfigItem('image_supported_size');

    $config['upload_path']   = $path;
    $config['allowed_types'] = $image_supported_type;
    if (!empty($image_supported_size)) {
        $config['max_size'] = $image_supported_size;
    }

    if (!empty($max_width)) {
        $config['max_width'] = $max_width;
    }

    if (!empty($max_height)) {
        $config['max_height'] = $max_height;
    }

    $CI = &get_instance();
    $CI->load->library('upload', $config);

    // check new file is exit
    if (!empty($new_file)) {
        // get delete old file if exit
        if (!empty($old_file)) {
            $delete_file = realpath(APPPATH . '.' . $path . $old_file);
            if (file_exists($delete_file)) {
                unlink($delete_file);
            }
        }

        // get upload
        if (!$CI->upload->do_upload($field)) {
            $CI->session->set_flashdata('error', $CI->upload->display_errors());
        } else {
            $file_data = $CI->upload->data();
            $file      = $file_data['file_name'];
        }
    } else {
        // Set old file is
        $file = $old_file;
    }

    return $file;
}

/**
 ** This function for field builder
 * @param string $type : This is field type (input, select, color, number)
 * @param string $field_name : This is field name
 * @param string $field_value : This is field default or exit value
 * @param string $field_label : This is field label
 * @param string $required : This is field required (required or null)
 * @param string $v : enable / desable bootstrap form
 * @param string $style : add custom style in filed
 * @return $output : This is output to set field
 **/
function fieldBuilder($type, $field_name, $field_value, $field_label, $required, $v = 0, $style = NULL)
{
    $output = '';

    if (empty($required)) {
        $required = '';
    } else {
        $required = 'required';
    }

    if (!empty($v)) {
        $label_class = '';
        $hdiv        = '';
        $hdiv_close  = '';
    } else {
        $label_class = 'col-sm-4';
        $hdiv        = '<div class="col-sm-8">';
        $hdiv_close  = '</div>';
    }

    switch ($type) {
        case 'input':
            $output .= '<div class="form-group">';
            $output .= '<label for="field_id_' . $field_name . '" class=" ' . $label_class . ' control-label">' . $field_label . '</label>';
            $output .= $hdiv;
            $output .= '<input type="text" class="form-control ' . $required . '" value="' . $field_value . '" id="field_id_' . $field_name . '" name="' . $field_name . '" ' . $required . ' >';
            $output .= $hdiv_close;
            $output .= '</div>';
            break;

        case 'color':
            $output .= '<div class="form-group">';
            $output .= '<label for="field_id_' . $field_name . '" class=" ' . $label_class . ' control-label">' . $field_label . '</label>';
            $output .= $hdiv;
            $output .= '
                <div class="input-group colorpicker colorpicker-element">
                    <input type="text" class="form-control ' . $required . ' " value="' . $field_value . '" id="field_id_' . $field_name . '" name="' . $field_name . '" >
                    <div class="input-group-addon">
                        <i style="background-color: rgb(17, 217, 5);"></i>
                    </div>
                </div>';
            $output .= $hdiv_close;
            $output .= '</div>';
            break;

        case 'hr':
            $output .= '<hr>';
            break;

        case 'number':
            $output .= '<div class="form-group">';
            $output .= '<label for="field_id_' . $field_name . '" class=" ' . $label_class . ' control-label">' . $field_label . '</label>';
            $output .= $hdiv;
            $output .= '<input type="number" class="form-control ' . $required . '"  value="' . $field_value . '" id="field_id_' . $field_name . '" name="' . $field_name . '" >';
            $output .= $hdiv_close;
            $output .= '</div>';
            break;

        case 'textarea':
            $output .= '<div class="form-group">';
            $output .= '<label for="field_id_' . $field_name . '" class="col-sm-4 control-label">' . $field_label . '</label>';
            $output .= '<div class="col-sm-8">';
            $output .= '<textarea class="form-control ' . $required . '"  rows="3" id="field_id_' . $field_name . '" name="' . $field_name . '">' . $field_value . '</textarea>';
            //$output .='<input type="text" class="form-control '.$required.'" value="'.set_value($field_name, $field_value).'" id="field_id_'.$field_name.'" name="'.$field_name.'" >';
            $output .= '</div>';
            $output .= '</div>';
            break;

        case 'help':
            $output .= '<div class="form-group">';
            $output .= '<label for="field_id_' . $field_name . '" class="col-sm-4 control-label"></label>';
            $output .= '<div class="col-sm-8">';
            $output .= $field_label;
            $output .= '</div>';
            $output .= '</div>';
            break;

        case 'select':
            $output .= '<div class="form-group">';
            $output .= '<label for="field_id_' . $field_name . '" class="col-sm-4 control-label">' . $field_label . '</label>';
            $output .= '<div class="col-sm-8">';
            $output .= $field_value;
            $output .= '</div>';
            $output .= '</div>';
            break;

        case 'checkbox':
            $output .= '<div class="form-group">';
            $output .= '<label for="field_id_' . $field_name . '" class="col-sm-4 control-label">' . $field_label . '</label>';
            $output .= '<div class="col-sm-8">';

            if (!empty($field_value)) {
                $output .= '<label><input type="checkbox" name="' . $field_name . '" class="flat-red" checked /></label>';
            } else {
                $output .= '<label><input type="checkbox" name="' . $field_name . '" class="flat-red" /></label>';
            }

            $output .= '</div>';
            $output .= '</div>';
            break;

        case 'radio':
            $output .= '<div class="form-group">';
            $output .= '<label for="field_id_' . $field_name . '" class="col-sm-2 control-label">' . $field_label . '</label>';
            $output .= '<div class="col-sm-10">';
            $output .= '<input type="text" class="form-control ' . $required . '" value="' . set_value($field_name, $field_value) . '" id="field_id_' . $field_name . '" name="' . $field_name . '" >';
            $output .= '</div>';
            $output .= '</div>';
            break;
    }

    return $output;
}

/**
 ** Published/ Unpublished
 * @param string $name : field name
 * @param  $id : exit field id value
 * @return $output : This is output to set field
 **/
function getStatus($name, $id)
{
    $list = array(
        '1' => 'Published',
        '0' => 'Unpublished'
    );

    $output = '<select name="' . $name . '" id="s_' . $name . '" class="form-control" >';

    foreach ($list as $key => $item) {
        if ($key == $id) {
            $output .= '<option selected="selected" value="' . $key . '">' . $item . '</option>';
        } else {
            $output .= '<option value="' . $key . '">' . $item . '</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 ** Yes/ No
 * @param string $name : field name
 * @param  $id : exit field id value
 * @return $output : This is output to set field
 **/
function getYesNo($name, $id)
{
    $list = array(
        '0' => 'No',
        '1' => 'Yes'
    );

    $output = '<select name="' . $name . '" id="s_' . $name . '" class="form-control" >';

    foreach ($list as $key => $item) {
        if ($key == $id) {
            $output .= '<option selected="selected" value="' . $key . '">' . $item . '</option>';
        } else {
            $output .= '<option value="' . $key . '">' . $item . '</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 ** Function for section header
 * @param string $title : section main title
 * @param string $sub_title : section sub title
 * @param string $icon : fontawsome icon
 * @return $output : This is output to set field
 **/
function sectionHeader($title, $sub_title, $icon)
{
    $output = '<section class="content-header">';
    $output .= '<h1><i class="fa ' . $icon . '"></i> ' . $title . ' <small> ' . $sub_title . ' </small></h1>';
    $output .= '</section>';

    return $output;
}

/**
 ** Select single data
 * @param string $table : database table name
 * @param string $select_field : selected field name
 * @param string $where_field : where condition field name
 * @param string $where_data : where condition field value
 * @return $output : This is output to set field
 **/
function getSingledata($table, $select_field, $where_field, $where_data)
{
    $CI = &get_instance();
    $CI->db->select($select_field);
    $CI->db->from($table);
    $CI->db->where($where_field, $where_data);
    $query   = $CI->db->get();
    $results = $query->row();

    if ($results) {
        $output = $results->$select_field;
    } else {
        $output = '';
    }

    return $output;
}

/**
 ** Select single data
 * @param string $table : database table name
 * @param string $select_field : selected field name
 * @param string $where_field : where condition field name
 * @param string $where_data : where condition field value
 * @return $output : This is output to set field
 **/
function getCourses($select_field, $where_data)
{
    $ids[] = explode(',', $where_data);

    $CI = &get_instance();
    $CI->db->select($select_field);
    $CI->db->from('courses');
    $CI->db->where('id', $where_data);
    $query   = $CI->db->get();
    $results = $query->row();

    if ($results) {
        $output = $results->$select_field;
    } else {
        $output = '';
    }

    return $output;
}

/**
 ** Select Multiple data
 * @param string $table : database table name
 * @param string $select_field : selected field name
 * @return $result : output row data
 **/
function getMultipaledata($table, $select_field)
{
    $CI = &get_instance();
    $CI->db->select($select_field);
    $CI->db->from($table);
    $query = $CI->db->get();

    return $query->result();
}

/**
 * @param $class_name
 * @param $department
 * @return mixed
 */
function getStudentsList($class_name, $department)
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('students');
    $CI->db->where('class', $class_name);
    $CI->db->where('department', $department);
    $query = $CI->db->get();

    return $query->result();
}

/**
 ** Get Subject List
 **/
function getSubjects($ids)
{
    $subject_ids = explode(",", $ids);
    $CI          = &get_instance();
    $CI->db->select('*');
    $CI->db->from('subjects');
    $query   = $CI->db->get();
    $results = $query->result();

    $output = '<select name="subject_name[]" id="s_name" multiple="multiple" class="form-control required subjectfield" >';

    if ($ids != 0 || $ids == '') {
        foreach ($results as $key => $item) {
            $id = $item->id;

            if (in_array($id, $subject_ids)) {
                $output .= '<option selected="selected" value="' . $item->id . '">' . $item->name . '</option>';
            } else {
                $output .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            }
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 * @param $class_id
 * @param $subject_id
 * @return mixed
 */
function getSubjectsByClass($class_id, $subject_id)
{
    $CI = &get_instance();
    $CI->db->select('subjects');
    $CI->db->from('class');
    $CI->db->where('id', $class_id);
    $query   = $CI->db->get();
    $results = $query->row();

    $output = '<select name="subject_id" id="subject_id" class="form-control required subjectfield" >';

    if ($results) {
        $subjects = explode(",", $results->subjects);

        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->from('subjects');
        $CI->db->where("id IN ($results->subjects)");
        $query    = $CI->db->get();
        $subjects = $query->result();

        $output .= '<option value="" disabled selected>Please Select</option>';

        foreach ($subjects as $key => $item) {
            $id = $item->id;

            if ($id == $subject_id) {
                $output .= '<option selected="selected" value="' . $item->id . '">' . $item->name . '( ' . $item->code . ' )' . '</option>';
            } else {
                $output .= '<option value="' . $item->id . '">' . $item->name . '( ' . $item->code . ' )' . '</option>';
            }
        }
    }

    $output .= '</select>';

    return $output;
}

function getClassByDepartment($dept_id = '')
{

    $CI = &get_instance();
    $CI->db->select('id,name');
    $CI->db->from('class');
    if ($dept_id != '') {
        $CI->db->where('departments', $dept_id);
    }
    $query   = $CI->db->get();
    $results = $query->result();

    $output = '<select name="class_id" id="class" class="form-control required " >';
    $output .= '<option value="" selected> Select Class </option>';

    foreach ($results as $item) {
        $output .= '<option value="' . $item->id . '">' . $item->name . '</option>';
    }

    $output .= '</select>';

    return $output;
}

function getExamByClass($class_id = '')
{

    $CI = &get_instance();
    $CI->db->select('id,name');
    $CI->db->from('exam');
    if ($class_id != '') {
        $CI->db->where('class_id', $class_id);
    }
    $query   = $CI->db->get();
    $results = $query->result();

    $output = '<select name="exam_name" id="exam" class="form-control required " >';
    $output .= '<option value=""  selected> Select Exam </option>';

    foreach ($results as $item) {
        $output .= '<option value="' . $item->id . '">' . $item->name . '</option>';
    }

    $output .= '</select>';

    return $output;
}

/**
 * @param $id
 * @param $table
 * @return mixed
 */
function getNameById($id, $table)
{
    $CI = &get_instance();
    $CI->db->select('name');
    $CI->db->from($table);
    $CI->db->where('id', $id);
    $query  = $CI->db->get();
    $result = $query->row();

    if ($result) {
        return $result->name;
    } else {
        return null;
    }
}

/**
 * @param $id
 * @param $table
 * @return mixed
 */
function getSubjectNameCode($id, $table)
{
    $CI = &get_instance();
    $CI->db->select('name');
    $CI->db->select('code');
    $CI->db->from($table);
    $CI->db->where('id', $id);
    $query  = $CI->db->get();
    $result = $query->row();

    return $result->name . '( ' . $result->code . ' )';
}

/**
 ** Get Filtered Subject List
 **/
function getFilteredSubjects($type, $subjects = array())
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('subjects');
    $CI->db->where('type', $type);
    $query   = $CI->db->get();
    $results = $query->result();

    $output = '<select name="' . $type . '[]" id="s_name" multiple="multiple" class="form-control required subjectfield" >';

    foreach ($results as $key => $item) {
        $id = $item->id;

        if (in_array($id, $subjects)) {
            $output .= '<option selected="selected" value="' . $item->id . '">' . $item->name . '</option>';
        } else {
            $output .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 ** Get Subject List
 **/
function getParentsStudents($ids)
{
    $p_sutdents_ids = explode(",", $ids);
    $CI             = &get_instance();
    $CI->db->select('*');
    $CI->db->from('students');
    $query   = $CI->db->get();
    $results = $query->result();

    $output = '<select name="students_name[]" id="s_name" multiple="multiple" class="form-control required subjectfield" >';

    foreach ($results as $key => $item) {
        $id = $item->id;

        if (empty($item->avatar)) {
            $img_path = site_url('/uploads/students/') . '/avator.png';
        } else {
            $img_path = site_url('/uploads/students/') . '/' . $item->avatar;
        }

        if (in_array($id, $p_sutdents_ids)) {
            $output .= '<option selected="selected" value="' . $item->id . '">' . $item->name . '</option>';
        } else {
            $output .= '<option value="' . $item->id . '" style="background-image:url(' . $item->avatar . ');">' . $item->name . ' ' . $item->roll . ' ' . $item->department . ' </option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 ** Get Departments List
 **/
function getDepartments($ids)
{
    $department_ids = explode(",", $ids);
    $CI             = &get_instance();
    $CI->db->select('*');
    $CI->db->from('departments');
    $query   = $CI->db->get();
    $results = $query->result();

    $output = '<select name="departments_name[]" id="d_name" multiple="multiple" class="form-control required subjectfield" >';

    foreach ($results as $key => $item) {
        $id = $item->id;

        if (in_array($id, $department_ids)) {
            $output .= '<option selected="selected" value="' . $item->id . '">' . $item->name . '</option>';
        } else {
            $output .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 ** Get Departments List
 **/

function getCourseCode($ids)
{
    $course_ids = explode(",", $ids);
    $CI         = &get_instance();
    $CI->db->select('*');
    $CI->db->from('courses');
    $query   = $CI->db->get();
    $results = $query->result();

    $output = '<select name="course_code[]" id="c_code" multiple="multiple" class="form-control required coursefield" required >';

    foreach ($results as $key => $item) {
        $id = $item->id;

        if (in_array($id, $course_ids)) {
            $output .= '<option selected="selected" value="' . $item->id . '">' . $item->code . '</option>';
        } else {
            $output .= '<option value="' . $item->id . '">' . $item->code . '</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 ** Get Calsses list for multiple select
 **/
function getClassesList($ids, $multiselect = true)
{
    $class_ids = explode(",", $ids);
    $CI        = &get_instance();
    $CI->db->select('*');
    $CI->db->from('class');
    $query   = $CI->db->get();
    $results = $query->result();

    if ($multiselect) {
        $output = '<select name="class_name[]" id="c_name" multiple="multiple" class="form-control required subjectfield" >';
    } else {
        $output = '<select name="class_id" id="class_id" class="form-control required subjectfield" >';
    }

    $output .= '<option value="" disabled selected>Select Class</option>';

    foreach ($results as $key => $item) {
        $id = $item->id;

        if (in_array($id, $class_ids)) {
            $output .= '<option selected="selected" value="' . $item->id . '">' . $item->name . '</option>';
        } else {
            $output .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

function getClassForFilter($ids)
{
    $class_ids = explode(",", $ids);
    $CI        = &get_instance();
    $CI->db->select('*');
    $CI->db->from('class');
    $query   = $CI->db->get();
    $results = $query->result();

    $output = '<select name="class_id" id="class_id" class="form-control" >';

    $output .= '<option value=""  selected>Select Class</option>';

    foreach ($results as $key => $item) {
        $id = $item->id;

        if (in_array($id, $class_ids)) {
            $output .= '<option selected="selected" value="' . $item->id . '">' . $item->name . '</option>';
        } else {
            $output .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
function getHashedPassword($plainPassword)
{
    return password_hash($plainPassword, PASSWORD_DEFAULT);
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
function verifyHashedPassword($plainPassword, $hashedPassword)
{
    return password_verify($plainPassword, $hashedPassword) ? true : false;
}

/**
 ** This method used to get current browser agent
 **/

if (!function_exists('getBrowserAgent')) {
    function getBrowserAgent()
    {
        $CI = get_instance();
        $CI->load->library('user_agent');

        $agent = '';

        if ($CI->agent->is_browser()) {
            $agent = $CI->agent->browser() . ' ' . $CI->agent->version();
        } else

		if ($CI->agent->is_robot()) {
            $agent = $CI->agent->robot();
        } else

		if ($CI->agent->is_mobile()) {
            $agent = $CI->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }

        return $agent;
    }
}

/**
 ** Get System Message
 **/
function getSystemMessage()
{
    $CI = &get_instance();
    $CI->load->helper('form');

    $output = '';

    // validation error
    $output .= '<div class="row">';
    $output .= '<div class="col-md-12">';
    $output .= validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');
    $output .= '</div>';
    $output .= '</div>';

    // Error
    $error = $CI->session->flashdata('error');

    if ($error) {
        $output .= '<div class="alert alert-danger alert-dismissable">';
        $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
        $output .= $error;
        $output .= '</div>';
    }

    // Success
    $success = $CI->session->flashdata('success');

    if ($success) {
        $output .= '<div class="alert alert-success alert-dismissable">';
        $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
        $output .= $success;
        $output .= '</div>';
    }

    // Send
    $send = $CI->session->flashdata('send');

    if ($send) {
        $output .= '<div class="alert alert-success alert-dismissable">';
        $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
        $output .= $send;
        $output .= '</div>';
    }

    // not send
    $notsend = $CI->session->flashdata('notsend');

    if ($notsend) {
        $output .= '<div class="alert alert-danger alert-dismissable">';
        $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
        $output .= $notsend;
        $output .= '</div>';
    }

    // unable
    $unable = $CI->session->flashdata('unable');

    if ($unable) {
        $output .= '<div class="alert alert-danger alert-dismissable">';
        $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
        $output .= $unable;
        $output .= '</div>';
    }

    // invalid
    $invalid = $CI->session->flashdata('invalid');

    if ($invalid) {
        $output .= '<div class="alert alert-warning alert-dismissable">';
        $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
        $output .= $invalid;
        $output .= '</div>';
    }

    return $output;
}

/**
 ** Hexa to RGBA
 * @param string $color : Hexa color code
 * @param $opacity : opacity value
 **/
function hex2rgba($color, $opacity = false)
{
    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if (empty($color)) {
        return $default;
    }

    //Sanitize $color if "#" is provided
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb = array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if ($opacity) {
        if (abs($opacity) > 1) {
            $opacity = 1.0;
        }

        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    //Return rgb(a) color string

    return $output;
}

/**
 ** Get Total Active Student
 **/
function getTotalStudent()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('users');
    $CI->db->where('roleId !=', ROLE_SUPPER_ADMIN);
    $CI->db->where('roleId', ROLE_STUDENT);
    $CI->db->where('roleId !=', ROLE_PARENT);
    $CI->db->where('roleId !=', ROLE_TEACHER);
    $CI->db->where('active', 1);
    $CI->db->where('is_verified', 1);
    $query = $CI->db->get();

    return $query->num_rows();
}

/**
 ** Get Total Active Teacher
 **/
function getTotalTeacher()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('users');
    $CI->db->where('roleId !=', ROLE_SUPPER_ADMIN);
    $CI->db->where('roleId !=', ROLE_STUDENT);
    $CI->db->where('roleId !=', ROLE_PARENT);
    $CI->db->where('roleId', ROLE_TEACHER);
    $CI->db->where('active', 1);
    $CI->db->where('is_verified', 1);
    $query = $CI->db->get();

    return $query->num_rows();
}

/**
 ** Get Total Active Parent
 **/
function getTotalParent()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('users');
    $CI->db->where('roleId !=', ROLE_SUPPER_ADMIN);
    $CI->db->where('roleId !=', ROLE_STUDENT);
    $CI->db->where('roleId', ROLE_PARENT);
    $CI->db->where('roleId !=', ROLE_TEACHER);
    $CI->db->where('active', 1);
    $CI->db->where('is_verified', 1);
    $query = $CI->db->get();

    return $query->num_rows();
}

/**
 ** Get Total Active Admin user
 **/
function getTotalAdminUser()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('users');
    $CI->db->where('roleId !=', ROLE_SUPPER_ADMIN);
    $CI->db->where('roleId !=', ROLE_STUDENT);
    $CI->db->where('roleId !=', ROLE_PARENT);
    $CI->db->where('roleId !=', ROLE_TEACHER);
    //$CI->db->where('roleId', ROLE_USER);
    $CI->db->where('roleId', ROLE_ADMIN);
    $CI->db->where('active', 1);
    $CI->db->where('is_verified', 1);
    $query = $CI->db->get();

    return $query->num_rows();
}

/**
 ** Get Total user
 **/
function getTotalUser()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('users');
    $CI->db->where('roleId !=', 1);
    $query = $CI->db->get();

    return $query->num_rows();
}

/**
 ** Get Total Verified
 **/
function getTotalVerified()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('users');
    $CI->db->where('is_verified', 1);
    $CI->db->where('roleId !=', 1);
    $query = $CI->db->get();

    return $query->num_rows();
}

/**
 ** Get Total Inactive
 **/
function getTotalInactive()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('users');
    $CI->db->where('active', 0);
    $CI->db->where('roleId !=', 1);
    $query = $CI->db->get();

    return $query->num_rows();
}

/**
 ** Get Total Register
 **/
function getTotalRegister()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('users');
    $CI->db->where('roleId', 3);
    $CI->db->where('roleId !=', 1);
    $query = $CI->db->get();

    return $query->num_rows();
}

/**
 ** Get user chart by month
 * @param $month_value : Month Value (1, 2, 12)
 * @param $year_value : Year value (2018, 2019)
 **/
function getUserbymonth($month_value, $year_value)
{
    $CI = &get_instance();
    $CI->db->select('count(createdDtm) as totaluser');
    $CI->db->from('users');
    $CI->db->where('MONTH(createdDtm)', $month_value);
    $CI->db->where('YEAR(createdDtm)', $year_value);
    $CI->db->where('roleId !=', 1);
    $query = $CI->db->get();

    return $query->result();
}

/**
 ** Get Login History data
 * @param $user_id : user id
 **/
function getLoginData($user_id)
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('last_login');
    $CI->db->where('userId', $user_id);
    $CI->db->order_by("id", "desc");
    $query  = $CI->db->get();
    $result = $query->result();

    return $result;
}

/**
 ** Get Session data
 * @param $role : user group/ role id
 **/
function getSessionList($role)
{
    $CI = &get_instance();
    $CI->db->select("*");
    $CI->db->from('sessions');
    $CI->db->where('role', $role);
    $CI->db->where('data !=', '');
    $CI->db->order_by("timestamp ", "desc");
    $query  = $CI->db->get();
    $result = $query->result();

    return $result;
}

if (!function_exists('setFlashData')) {
    /**
     * @param $status
     * @param $flashMsg
     */
    function setFlashData($status, $flashMsg)
    {
        $CI = get_instance();
        $CI->session->set_flashdata($status, $flashMsg);
    }
}

/**
 ** Get Fields Type Data
 **/
function getFieldType($ids, $field_name)
{
    $field_type = explode(",", $ids);
    $CI         = &get_instance();
    $CI->db->select('*');
    $CI->db->from('fields_type');
    $query   = $CI->db->get();
    $results = $query->result();

    $output = '<select name="' . $field_name . '" id="' . $field_name . '" class="form-control required" >';

    foreach ($results as $key => $item) {
        $id = $item->id;

        if (in_array($id, $field_type)) {
            $output .= '<option selected="selected" value="' . $item->id . '">' . $item->type . '</option>';
        } else {
            $output .= '<option value="' . $item->id . '">' . $item->type . '</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 ** Select all data from fields
 ** $whereData use for show row.
 **/

function getfieldsdata($table, $select_field, $whereData, $section)
{
    $CI = &get_instance();
    $CI->db->select($select_field);
    $CI->db->from($table);
    $CI->db->where($whereData, 1);
    $CI->db->where('section', $section);
    $query = $CI->db->get();

    return $query->result();
}

/**
 ** Get  Class List
 **/
function getClass($ids)
{
    $class_ids = explode(",", $ids);
    $CI        = &get_instance();
    $CI->db->select('*');
    $CI->db->from('class');
    $query   = $CI->db->get();
    $results = $query->result();

    $output = '<select name="class_name" id="class" class="form-control required" >';
    $output .= '<option value="0" > ' . getlang('select_class', 'sys_data') . ' </option>';

    foreach ($results as $key => $item) {
        $id = $item->id;

        if (in_array($id, $class_ids)) {
            $output .= '<option selected="selected" value="' . $item->id . '">' . $item->name . '</option>';
        } else {
            $output .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 ** Get  Department List
 **/
function getDepartment($field_name, $ids)
{
    $department_ids = explode(",", $ids);
    $CI             = &get_instance();
    $CI->db->select('*');
    $CI->db->from('departments');
    $query   = $CI->db->get();
    $results = $query->result();

    $output = '<select name="' . $field_name . '" id="department" class="form-control required" >';
    $output .= '<option value="" > ' . getlang('select_department', 'sys_data') . ' </option>';

    foreach ($results as $key => $item) {
        $id = $item->id;

        if (in_array($id, $department_ids)) {
            $output .= '<option selected="selected" value="' . $item->id . '">' . $item->name . '</option>';
        } else {
            $output .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 * @param $name
 * @return mixed
 */
function getFieldSectionID($name)
{
    $CI = &get_instance();
    $CI->db->select('id');
    $CI->db->from('fields_section');
    $CI->db->where('name', $name);
    $query   = $CI->db->get();
    $results = $query->row();

    if ($results) {
        $output = $results->id;
    } else {
        $output = '';
    }

    return $output;
}

/**
 ** Get Fields list by section id
 **/

function getFieldList($sid)
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('fields');
    $CI->db->where('section', $sid);
    $CI->db->where('published', 1);
    $CI->db->order_by("field_order", "asc");
    $query = $CI->db->get();

    return $query->result();
}

/**
 ** Show field
 **/

function fieldshow($fid, $sid, $panel_id, $label, $type, $required)
{
    if (!empty($panel_id) && !empty($fid) && !empty($sid)) {
        $CI = &get_instance();
        $CI->db->select('data');
        $CI->db->from('fields_data');
        $CI->db->where('fid', $fid);
        $CI->db->where('sid', $sid);
        $CI->db->where('panel_id', $panel_id);
        $query       = $CI->db->get();
        $results     = $query->row();
        $field_value = $results->data;
    } else {
        $field_value = '';
    }

    if (empty($required)) {
        $required = '';
    } else {
        $required = 'required';
    }

    $field_name = 'field_' . $fid;

    $label_class = 'col-sm-4';
    $hdiv        = '<div class="col-sm-8">';
    $hdiv_close  = '</div>';

    if ($type == 1) {
        $output = '<div class="form-group">';
        $output .= '<label for="field_id_' . $field_name . '" class=" ' . $label_class . ' control-label">' . $label . '</label>';
        $output .= $hdiv;
        $output .= '<input type="text" class="form-control ' . $required . '" value="' . $field_value . '" id="' . $field_name . '" name="' . $field_name . '" >';
        $output .= $hdiv_close;
        $output .= '</div>';
    }

    if ($type == 2) {
        $output = '<div class="form-group">';
        $output .= '<label for="field_id_' . $field_name . '" class="' . $label_class . ' control-label">' . $label . '</label>';
        $output .= $hdiv;
        $output .= '<textarea class="form-control ' . $required . '" rows="3" id="' . $field_name . '" name="' . $field_name . '">' . $field_value . '</textarea>';
        $output .= $hdiv_close;
        $output .= '</div>';
    }

    //Check Box
    if ($type == 3) {
        //get option value

        $output = '<div class="form-group">';
        $output .= '<label for="' . $field_name . '" class=" ' . $label_class . ' control-label">' . $label . '</label>';
        $output .= $hdiv;

        $check_box_option        = getFieldOption($fid, $sid, $type);
        $check_box_option_values = explode(",", $check_box_option);

        $key = 0;

        foreach ($check_box_option_values as $option) {
            $key++;
            $options      = explode("=", $option);
            $option_value = $options[0];
            $option_name  = $options[1];

            if (in_array($option_value, explode(",", $value))) {
                $checked_code = 'checked="checked"';
            } else {
                $checked_code = '';
            }

            $output .= '<label class="custom_checkbox" ><input type="checkbox"  class=" "  ' . $checked_code . ' name="' . $field_name . '[]" id="' . $fid . '_' . $key . '"  value="' . $option_value . '"> ' . $option_name . ' </label>';
        }

        $output .= $hdiv_close;
        $output .= '</div>';
    }

    /**
     ** Radio Box
     **/

    if ($type == 4) {
        //get option value
        $value = '';

        $radio_box_option    = getFieldOption($fid, $sid, $type);
        $radio_option_values = explode(",", $radio_box_option);
        $output              = '<div class="form-group">';
        $output .= '<label for="' . $field_name . '" class=" ' . $label_class . ' control-label">' . $label . '</label>';
        $output .= $hdiv;

        foreach ($radio_option_values as $radio_option) {
            $radio_options = explode("=", $radio_option);
            $roption_value = $radio_options[0];
            $roption_name  = $radio_options[1];

            if (in_array($roption_value, explode(",", $value))) {
                $checked_code = 'checked="checked"';
            } else {
                $checked_code = '';
            }

            $output .= '<label class="custom_checkbox" > <input type="radio"   class=" "  ' . $checked_code . ' name="' . $field_name . '"  value="' . $field_value . '">   ' . $roption_name . ' </label>';
        }

        $output .= $hdiv_close;
        $output .= '</div>';
    }

    /**
     ** Select Box
     **/

    if ($type == 5) {
        $output = '<div class="form-group">';
        $output .= '<label for="' . $field_name . '" class=" ' . $label_class . ' control-label">' . $label . '</label>';
        $output .= $hdiv;

        $select_box_option = getFieldOption($fid, $sid, $type);

        $select_option_values = explode(",", $select_box_option);

        $output .= '<select  id="' . $field_name . '" class="form-control" name="' . $field_name . '" >';

        $output .= '<option value="0" >' . $label . '</option>';

        foreach ($select_option_values as $row) {
            $select_options = explode("=", $row);
            $soption_value  = $select_options[0];
            $soption_name   = $select_options[1];

            if ($soption_value == $id) {
                $output .= '<option selected="selected" value="' . $soption_value . '">' . $soption_name . '</option>';
            } else {
                $output .= '<option value="' . $soption_value . '">' . $soption_name . '</option>';
            }

            $output .= '<option value="' . $soption_value . '">' . $soption_name . '</option>';
        }

        $output .= '</select>';

        $output .= $hdiv_close;
        $output .= '</div>';
    }

    if ($type == 6) {
        $output = '<div class="form-group">';
        $output .= '<label for="' . $field_name . '" class=" ' . $label_class . ' control-label">' . $label . '</label>';
        $output .= $hdiv;
        $output .= '<input type="select" class=" form-control datepicker ' . $required . '" value="' . $field_value . '" id="' . $field_name . '" name="' . $field_name . '" >';
        $output .= $hdiv_close;
        $output .= '</div>';
    }

    return $output;
}

/**
 **
 **/

function getFieldOption($fid, $sid, $type)
{
    $CI = &get_instance();
    $CI->db->select('option_param');
    $CI->db->from('fields');
    $CI->db->where('id', $fid);
    $CI->db->where('section', $sid);
    $CI->db->where('type', $type);
    $query   = $CI->db->get();
    $results = $query->row();
    $output  = $results->option_param;

    return $output;
}

/**
 ** Save Custom fields data
 **/

function saveFields($fid, $type, $sid, $field_data, $student_id, $old_id)
{
    $customFieldInfo = array(
        'fid'      => $fid,
        'sid'      => $sid,
        'data'     => $field_data,
        'panel_id' => $student_id
    );
    $CI = &get_instance();
    // Query for new data
    if (empty($old_id)) {
        $CI->db->insert('fields_data', $customFieldInfo);
        $insert_id = $CI->db->insert_id();
    } else {
        // Query for update
        $CI->db->where('id', $old_id);
        $CI->db->update('fields_data', $customFieldInfo);
    }
}

/**
 ** Get Fields Section Data
 **/
function getFieldSection($ids, $field_name)
{
    $field_type = explode(",", $ids);
    $CI         = &get_instance();
    $CI->db->select('*');
    $CI->db->from('fields_section');
    $query   = $CI->db->get();
    $results = $query->result();

    $output = '<select name="' . $field_name . '" id="' . $field_name . '" class="form-control required" >';

    foreach ($results as $key => $item) {
        $id = $item->id;

        if (in_array($id, $field_type)) {
            $output .= '<option selected="selected" value="' . $item->id . '">' . $item->name . '</option>';
        } else {
            $output .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 * Get Exam
 **/
function getExam($ids, $multiple, $class)
{
    $exam_ids = explode(",", $ids);
    $CI       = &get_instance();
    $CI->db->select('*');
    $CI->db->from('exam');
    $query   = $CI->db->get();
    $results = $query->result();

    if (!empty($multiple)) {
        $multiple_att       = 'multiple="multiple"';
        $name               = 'name="exam_name[]"';
        $option_first_value = '';
    } else {
        $multiple_att       = '';
        $name               = 'name="exam_name"';
        $option_first_value = '<option value="0"> ' . getlang('select_exam', 'sys_data') . '</option>';
    }

    $output = '<select  id="exam" ' . $name . ' ' . $multiple_att . '  class="form-control required ' . $class . '" >';
    $output .= $option_first_value;

    foreach ($results as $key => $item) {
        $id = $item->id;

        if (in_array($id, $exam_ids)) {
            $output .= '<option selected="selected" value="' . $item->id . '">' . $item->name . '</option>';
        } else {
            $output .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 * Subject
 **/
function getSubjectsList($ids)
{
    $subject_ids = explode(",", $ids);
    $CI          = &get_instance();
    $CI->db->select('*');
    $CI->db->from('subjects');
    $query   = $CI->db->get();
    $results = $query->result();

    $output = '<select name="subject_name[]" id="subject"  class="form-control required" >';
    $output .= '<option value="0"> ' . getlang('select_subject', 'sys_data') . ' </option>';

    foreach ($results as $key => $item) {
        $id = $item->id;

        if (in_array($id, $subject_ids)) {
            $output .= '<option selected="selected" value="' . $item->id . '">' . $item->name . '</option>';
        } else {
            $output .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 ** Get Mark
 **/
function getMark($select_field, $exam_id, $class_id, $subject_id, $student_id, $roll, $year)
{
    $CI = &get_instance();
    $CI->db->select($select_field);
    $CI->db->from('exam_marks');
    $CI->db->where('exam_id', $exam_id);
    $CI->db->where('class_id', $class_id);
    $CI->db->where('subject_id', $subject_id);
    $CI->db->where('student_id', $student_id);
    $CI->db->where('roll', $roll);
    $CI->db->where('year', $year);
    $query   = $CI->db->get();
    $results = $query->row();

    if ($results) {
        $output = $results->$select_field;
    } else {
        $output = '';
    }

    return $output;
}

/**
 ** Get students id from parents
 **/
function getStudentId($select_field)
{
    $CI = &get_instance();
    $CI->db->select($select_field);
    $CI->db->from('parents');
    $query   = $CI->db->get();
    $results = $query->row();

    if ($results) {
        $output = $results->$select_field;
    } else {
        $output = '';
    }

    return $output;
}

/**
 **
 **/
function getSingleFieldsdata($select_field, $field_id, $panel_id)
{
    $CI = &get_instance();
    $CI->db->select($select_field);
    $CI->db->from('fields_data');
    $CI->db->where('fid', $field_id);
    $CI->db->where('panel_id', $panel_id);
    $query   = $CI->db->get();
    $results = $query->row();

    if ($results) {
        $output = $results->$select_field;
    } else {
        $output = '';
    }

    return $output;
}

/**
 ** Get Parent Childs
 **/

function getParentChilds($pid)
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('students');
    $CI->db->where('parent', $pid);
    $query = $CI->db->get();

    return $query->result();
}

/**
 ** Get currency format
 **/
function getCurrency($value)
{
    $currency_sign     = getConfigItem('currency_sign');
    $decimal_places    = getConfigItem('decimal_places');
    $currency_position = getConfigItem('currency_position');

    $currency         = $currency_sign;
    $currency_decimal = $decimal_places;

    if ($currency_position == 'after') {
        $currency_value = number_format($value, $currency_decimal) . '' . $currency;
    } else {
        $currency_value = $currency . '' . number_format($value, $currency_decimal);
    }

    return $currency_value;
}

/**
 ** Get New student
 **/
function getNewStudent()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('users as u');
    $CI->db->where('u.is_verified', 0);
    $CI->db->where('u.active', 0);
    $CI->db->where('u.roleId !=', ROLE_SUPPER_ADMIN);
    $CI->db->where('u.roleId', ROLE_STUDENT);
    $CI->db->where('u.roleId !=', ROLE_PARENT);
    $CI->db->where('u.roleId !=', ROLE_TEACHER);
    $query = $CI->db->get();

    return $query->num_rows();
}

/**
 ** Get New Parent
 **/
function getNewParent()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('users as u');
    $CI->db->where('u.is_verified', 0);
    $CI->db->where('u.active', 0);
    $CI->db->where('u.roleId !=', ROLE_SUPPER_ADMIN);
    $CI->db->where('u.roleId !=', ROLE_STUDENT);
    $CI->db->where('u.roleId', ROLE_PARENT);
    $CI->db->where('u.roleId !=', ROLE_TEACHER);
    $query = $CI->db->get();

    return $query->num_rows();
}

/**
 ** Get New Teacher
 **/
function getNewTeacher()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('users as u');
    $CI->db->where('u.is_verified', 0);
    $CI->db->where('u.active', 0);
    $CI->db->where('u.roleId !=', ROLE_SUPPER_ADMIN);
    $CI->db->where('u.roleId !=', ROLE_STUDENT);
    $CI->db->where('u.roleId !=', ROLE_PARENT);
    $CI->db->where('u.roleId', ROLE_TEACHER);
    $query = $CI->db->get();

    return $query->num_rows();
}

/**
 * @param $month
 * @param $year
 * @return mixed
 */
function getTotalIncomebyMonth($month, $year)
{
    $CI = &get_instance();
    $CI->db->select('sum(paid_ammount) as Total');
    $CI->db->from('payments');
    $CI->db->where('MONTH(create_date)', $month);
    $CI->db->where('YEAR(create_date)', $year);
    $CI->db->where('status', 1);
    $query  = $CI->db->get();
    $result = $query->row();

    $total_income = $result->Total;

    if (empty($total_income)) {
        $value = 0;
    } else {
        $value = $total_income;
    }

    return $value;
}

/**
 ** Get Income
 **/
function getIncome($year)
{
    $CI = &get_instance();
    $CI->db->select('sum(paid_ammount) as Total');
    $CI->db->from('payments');
    $CI->db->where('YEAR(create_date)', $year);
    $CI->db->where('status', 1);
    $query        = $CI->db->get();
    $result       = $query->row();
    $total_income = $result->Total;

    return $total_income;
}
