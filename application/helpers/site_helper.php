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
 ** Get usermenu item array
 **/
function getUserTopmenuArray($roleId) {
	$menu = array(
		'dashboard' => '<i class="fa fa-dashboard"></i> '.getlang('site_menu_dashboard', 'data')
	);

	if ($roleId != ROLE_SUPPER_ADMIN) {
		$menu['profile'] = '<i class="fa fa-user-circle"></i> '.getlang('site_menu_profile', 'data');
		$menu['account'] = '<i class="fa fa-cog"></i> '.getlang('site_menu_account', 'data');
	}

	return $menu;
}

/**
 ** Get Class Name By ID
 **/
function getClassname($id) {
	$CI = &get_instance();
	$CI->db->select('name');
	$CI->db->from('class');
	$CI->db->where('id', $id);
	$query   = $CI->db->get();
	$results = $query->row();
	if ($results) {
		$output = $results->name;
	} else {
		$output = '';
	}

	return $output;
}

/**
 ** Get Subject Name By ID
 **/
function getSubjectname($id) {
	$CI = &get_instance();
	$CI->db->select('name');
	$CI->db->from('subjects');
	$CI->db->where('id', $id);
	$query   = $CI->db->get();
	$results = $query->row();
	if ($results) {
		$output = $results->name;
	} else {
		$output = '';
	}

	return $output;
}

/**
 ** Get Department Name By ID
 **/
function getDepartmentname($id) {
	$CI = &get_instance();
	$CI->db->select('name');
	$CI->db->from('departments');
	$CI->db->where('id', $id);
	$query   = $CI->db->get();
	$results = $query->row();
	if ($results) {
		$output = $results->name;
	} else {
		$output = '';
	}

	return $output;
}

/**
 ** Get multi-value genarator
 **/
function getMultivalue($input, $function) {
	$output      = '';
	$values      = explode(",", $input);
	$total_value = count($values);
	foreach ($values as $v => $value) {
		$output .= $function($value);
		if ($v < ($total_value - 1)) {
			$output .= ', ';
		}
	}

	return $output;
}

/**
 ** Get Panel label
 **/
function getPanelLabel($group, $uid) {
	$label = '';

// Get group wise data
	if ($group == ROLE_TEACHER) {
		// Get designation

		$designation = getSingledata('teachers', 'designation', 'userid', $uid);

		// Get class
		$teacher_class_ids = getSingledata('teachers', 'class', 'userid', $uid);
		$teacher_class     = getMultivalue($teacher_class_ids, 'getClassname');

		// Get Subjects
		$teacher_subject_ids = getSingledata('teachers', 'subject', 'userid', $uid);
		$teacher_subject     = getMultivalue($teacher_subject_ids, 'getSubjectname');

		$label .= '<p><b>'.$designation.'</b></p>';
		$label .= '<p class="class_info" > Class: <b>'.$teacher_class.'</b></p>';
		$label .= '<p class="subject_info" > Subject: <b>'.$teacher_subject.'</b></p>';
	} elseif ($group == ROLE_PARENT) {
		$parentchilds = getParentChilds($uid);
		$label .= '<h5 class="text-left">'.getlang('childs_info', 'sys_data').'</h5>';

		foreach ($parentchilds as $key => $child) {
			$student_name   = getSingledata('users', 'name', 'userId', $child->userid);
			$student_avatar = getSingledata('users', 'avatar', 'userId', $child->userid);

			if (empty($student_name)) {
				$students_img_path = site_url('/uploads/students/').'/avator.png';
			} else {
				$students_img_path = site_url('/uploads/students/').'/'.$student_avatar;
			}

			$label .= '<div class="child">';
			$label .= '<a href="'.base_url().'user/studentprofile/'.$child->id.'">';
			$label .= '<img src="'.$students_img_path.'" alt="'.$student_name.'"><span>'.$student_name.'</span>';

			$label .= ' </a>';
			$label .= '</div>';
		}
	} elseif ($group == ROLE_STUDENT) {
		// Get roll
		$roll = getSingledata('students', 'roll', 'userid', $uid);

		// Get Class
		$student_class_id = getSingledata('students', 'class', 'userid', $uid);
		$student_class    = getClassname($student_class_id);

		// Get Department
		$student_department_id = getSingledata('students', 'department', 'userid', $uid);
		$student_department    = getDepartmentname($student_department_id);

		$label .= '<p class="class_info" > '.getlang('site_roll', 'data').' <b>'.$roll.'</b></p>';
		$label .= '<p class="class_info" > '.getlang('site_class', 'data').' <b>'.$student_class.'</b></p>';
		$label .= '<p class="class_info" > '.getlang('site_department', 'data').' <b>'.$student_department.'</b></p>';
	} else {
	}

	return $label;
}

/**
 ** Get User Menu (Top Right dropdown Menu)
 * @param $userid : This is user id
 * @param $isLoggedIn : true/false
 * @return $output : This is output to set top right menu
 **/
function getTopNav($userid, $isLoggedIn) {
	// get user name
	$name = getSingledata('users', 'name', 'userId', $userid);

	// get role name
	$roleId = getSingledata('users', 'roleId', 'userId', $userid);

// Get Folder name
	if ($roleId == ROLE_TEACHER) {
		$folder_name = 'teachers';
	} elseif ($roleId == ROLE_PARENT) {
		$folder_name = 'parents';
	} elseif ($roleId == ROLE_STUDENT) {
		$folder_name = 'students';
	} else {
		$folder_name = 'users';
	}

	// Get avatar
	$avator = getSingledata('users', 'avatar', 'userId', $userid);

	if (empty($avator)) {
		$img_path = site_url('/uploads/users/').'/avator.png';
	} else {
		$img_path = site_url('/uploads/'.$folder_name.'/').'/'.$avator;
	}

	$output = '';

	if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
		$output .= '<ul class="nav navbar-nav top-nav-user">';
		$output .= '<li><a href="'.base_url().'login"><i class="fa fa-lock"></i> '.getlang('site_menu_site_login', 'data').'</a></li>';
		// Disable signup check
		$disable_signup = getConfigItem('disable_signup');

		if (empty($disable_signup)) {
			$output .= '<li><a href="'.base_url().'signup"><i class="fa fa-user"></i> '.getlang('site_menu_site_signup', 'data').'</a></li>';
		}

		$output .= '</ul>';
	} else {
		$CI      = &get_instance();
		$segment = $CI->uri->segment(2);
		$menu    = getUserTopmenuArray($roleId);
		$output .= '<ul class="nav navbar-nav top-nav-user">';
		$output .= '<li><a href="'.base_url().'user/dashboard" class="img"><img style="width: 40px; height: 40px;" src="'.$img_path.'" class="img-circle" alt="User Image" /></a></li>';
		$output .= '<li>
                        <a href="'.base_url().'user/dashboard">'.$name.' <i class="fa fa-angle-down pull-right"></i></a>

                        <ul class="dropdown">';

		foreach ($menu as $key => $item) {
			if ($segment == $key) {
				$class = 'active';
			} else {
				$class = '';
			}

			$output .= '<li class="'.$class.'"><a href="'.base_url().'user/'.$key.'">'.$item.'</a></li>';
		}

		$output .= '<li><a href="'.base_url().'logout"> <i class="fa fa-sign-out"></i> '.getlang('site_menu_site_logout', 'data').'</a></li>
                        </ul>
                        </li>';
		$output .= '</ul>';
	}

	return $output;
}

/**
 ** Get Language switcher
 **/
function getLangSwitch() {
	$CI   = &get_instance();
	$list = getLanguageObj();

	$output = '<ul class="nav navbar-nav top-nav-user">';
	$output .= '<li><a href="'.base_url().'" class="img"></a></li>';
	$output .= '<li>
                        <a href="'.base_url().'user/dashboard">'.getlang('site_menu_choose_lang', 'data').' <i class="fa fa-angle-down pull-right"></i></a>
                        <ul class="dropdown">';

	foreach ($list as $key => $item) {
		if ($CI->session->userdata('site_lang') == $item->id) {
			$output .= '<li class="active"><a href="'.base_url().'lang/'.$item->id.'">'.$item->title.'</a></li>';
		} else {
			$output .= '<li class=""><a href="'.base_url().'lang/'.$item->id.'">'.$item->title.'</a></li>';
		}
	}

	$output .= '
                        </ul>
                        </li>';
	$output .= '</ul>';

	return $output;
}

/**
 ** Get total unread notice number by user id
 * @param $group_value : user group/role id
 * @param $uid : This is user id
 **/
function getTotalUnreadNotice($group_value, $uid) {
	$CI = &get_instance();
	$CI->db->select('*');
	$CI->db->from('notice as n');
	$likeCriteria = "(n.readNotice NOT LIKE '%".$uid."%')";
	$CI->db->where($likeCriteria);
	$CI->db->where('n.status', 1);
	$CI->db->where('n.is_delete', 0);
	$CI->db->where('n.groupId', $group_value);
	$query = $CI->db->get();

	return $query->num_rows();
}

/**
 ** User Panel Menu
 * @param $notice : unread notice number
 **/
function getUserMenusArray($notice, $group, $uid) {
	if (!empty($notice)) {
		$notice_counter = '<span class="label label-danger">'.$notice.'</span>';
	} else {
		$notice_counter = '';
	}

	$menu = array(
		'dashboard' => '<i class="fa fa-dashboard"></i> '.getlang('site_menu_dashboard', 'data')

// 'profile'              => '<i class="fa fa-user-circle"></i> '.getlang('site_menu_profile', 'data'),

// 'account'              => '<i class="fa fa-cog"></i> '.getlang('site_menu_account', 'data'),
		//'changepassword'       => '<i class="fa fa-key"></i> '.getlang('site_change_password', 'sys_data')
	);

	if ($group != ROLE_SUPPER_ADMIN) {
		$menu['profile'] = '<i class="fa fa-user-circle"></i> '.getlang('site_menu_profile', 'data');
		$menu['account'] = '<i class="fa fa-cog"></i> '.getlang('site_menu_account', 'data');
	}

	// Add Change Photo
	$disable_changephoto = getConfigItem('disable_changephoto');

	if (empty($disable_changephoto)) {
		//$menu['changephoto'] = '<i class="fa fa-user"></i> '.getlang('site_change_photo', 'sys_data');
	}

	if ($group == ROLE_TEACHER) {
		$menu['messages']   = '<i class="fa fa-envelope-open"></i> '.getlang('site_menu_message', 'data').'';
		$menu['attendance'] = '<i class="fa fa-check-square"></i> '.getlang('site_menu_attendances', 'data').'';
		$menu['marks']      = '<i class="fa fa-star"></i> '.getlang('site_menu_mark', 'data').'';
		$menu['results']    = '<i class="fa fa-file-text-o"></i> '.getlang('site_menu_result', 'data').'';
		$menu['payments']   = '<i class="fa fa-money"></i> '.getlang('site_menu_payments', 'data').'';
	} elseif ($group == ROLE_PARENT) {
		$menu['messages']   = '<i class="fa fa-envelope-open"></i> '.getlang('site_menu_message', 'data').'';
		$menu['attendance'] = '<i class="fa fa-check-square"></i> '.getlang('site_menu_attendances', 'data').'';
		$menu['results']    = '<i class="fa fa-file-text-o"></i> '.getlang('site_menu_result', 'data').'';
		$menu['payments']   = '<i class="fa fa-money"></i> '.getlang('site_menu_payments', 'data').'';
	} elseif ($group == ROLE_STUDENT) {
		$menu['messages']   = '<i class="fa fa-envelope-open"></i> '.getlang('site_menu_message');
		$menu['attendance'] = '<i class="fa fa-check-square"></i> '.getlang('site_menu_attendances', 'data').'';
		$menu['results']    = '<i class="fa fa-file-text-o"></i> '.getlang('site_menu_result', 'data').'';
		$menu['payments']   = '<i class="fa fa-money"></i> '.getlang('site_menu_payments', 'data').'';
		$menu['subjects']   = '<i class="fa fa-book"></i> '.getlang('site_menu_subjects', 'data').'';
		$menu['exam_card']  = '<i class="fa fa-book"></i> '.getlang('site_menu_exam_card', 'data').'';
		$menu['exam']       = '<i class="fa fa-graduation-cap"></i> '.getlang('site_exam', 'data').'';
	}

	// Add Login Activity
	$disable_logs = getConfigItem('disable_logs');

	if (empty($disable_logs)) {
		//$menu['logs'] = '<i class="fa fa-lock"></i> '.getlang('site_login_activity', 'sys_data');
	}

	// Add Notice
	$disable_notice = getConfigItem('disable_notice');

	if (empty($disable_notice)) {
		$menu['notice'] = '<i class="fa fa-bell"></i> '.getlang('site_menu_notice', 'data').' '.$notice_counter.'';
	}

	return $menu;
}

/**
 ** Get user left panel
 * @param $group : user group/role id
 * @param $uid : This is user id
 **/
function getUserPanel($group, $uid) {
	$CI = &get_instance();

	// get user name
	$name = getSingledata('users', 'name', 'userId', $uid);

// Get group wise data
	if ($group == ROLE_TEACHER) {
		$folder_name = 'teachers';
	} elseif ($group == ROLE_PARENT) {
		$folder_name = 'parents';
	} elseif ($group == ROLE_STUDENT) {
		$folder_name = 'students';
	} else {
		$folder_name = 'users';
	}

	// get avatar
	$avatar = getSingledata('users', 'avatar', 'userId', $uid);

	if (empty($avatar)) {
		$img_path = site_url('/uploads/users').'/avator.png';
	} else {
		$img_path = site_url('/uploads/'.$folder_name).'/'.$avatar;
	}

	$segment = $CI->uri->segment(2);

	// get total unread notice
	$notice = getTotalUnreadNotice($group, $uid);

	$menu = getUserMenusArray($notice, $group, $uid);

	$output = '';

	$output .= '<div class="user-panel">';

// $output .= '<div class="logout-button">';

// $output .= '<a href="'.base_url().'logout" class="btn btn-primary "><i class="fa fa-sign-out"></i> Logout</a>';
	// $output .= '</div>';

	$output .= '<div class="user-avatar">';
	$output .= '<img style="width: 200px; height: 200px;" src="'.$img_path.'" class="img-circle" alt="'.$name.'" />';
	$output .= '</div>';

	$output .= '<div class="user-title">';
	$output .= '<h4>'.$name.'</h4> ';
	$output .= getPanelLabel($group, $uid);
	$output .= '<hr></div>';

	$output .= '<ul class="user-menu">';

	foreach ($menu as $key => $item) {
		if ($segment == $key) {
			$class = 'active';
		} else {
			$class = '';
		}

		$output .= '<li class="'.$class.'"><a href="'.base_url().'user/'.$key.'">'.$item.'</a></li>';
	}

	$output .= '</ul>';
	$output .= '</div>';

	return $output;
}

/**
 ** Get Student List By Parent
 **/
function getStudentListbyParent($field_name, $parent_id) {
	$CI = &get_instance();
	$CI->db->select('*');
	$CI->db->from('students');
	$CI->db->where('parent', $parent_id);
	$query   = $CI->db->get();
	$results = $query->result();

	$output = '<select name="'.$field_name.'" id="field_'.$field_name.'" class="form-control required" >';
	$output .= '<option value="" > '.getlang('select_students', 'sys_data').' </option>';

	foreach ($results as $key => $item) {
		$userid = $item->userid;
		$name   = getSingledata('users', 'name', 'userId', $userid);
		$output .= '<option value="'.$item->userid.'">'.$name.'</option>';
	}

	$output .= '</select>';

	return $output;
}

/**
 ** Get Student List By Parent
 **/
function getStudentListbyParentID($field_name, $parent_id) {
	$CI = &get_instance();
	$CI->db->select('*');
	$CI->db->from('students');
	$CI->db->where('parent', $parent_id);
	$query   = $CI->db->get();
	$results = $query->result();

	$output = '<select name="'.$field_name.'" id="field_'.$field_name.'" class="form-control required" >';
	$output .= '<option value="" > '.getlang('select_students', 'sys_data').' </option>';

	foreach ($results as $key => $item) {
		$userid = $item->userid;
		$name   = getSingledata('users', 'name', 'userId', $userid);
		$output .= '<option value="'.$item->id.'">'.$name.'</option>';
	}

	$output .= '</select>';

	return $output;
}

/**
 ** Get Academic Year List
 **/
function getAcademicYearList($field_name, $ids) {
	$year_ids = explode(",", $ids);
	$CI       = &get_instance();
	$CI->db->select('*');
	$CI->db->from('academic_year');
	$query   = $CI->db->get();
	$results = $query->result();

	$output = '<select name="'.$field_name.'" id="field_'.$field_name.'" class="form-control required" required >';
	$output .= '<option value="" > '.getlang('select_year', 'sys_data').' </option>';

	foreach ($results as $key => $item) {
		$id = $item->id;

		if (in_array($id, $year_ids)) {
			$output .= '<option selected="selected" value="'.$item->id.'">'.$item->year.'</option>';
		} else {
			$output .= '<option value="'.$item->id.'">'.$item->year.'</option>';
		}
	}

	$output .= '</select>';

	return $output;
}

/**
 ** Get user profile data
 **/
function profileData($uid, $table) {
	$CI = &get_instance();
	$CI->db->select('*');
	$CI->db->from($table);
	$CI->db->where('userid', $uid);
	$query = $CI->db->get();

	return $query->result();
}

/**
 ** Get Academic Year List
 **/
function getGradeCategory($field_name, $ids) {
	$gcat_ids = explode(",", $ids);
	$CI       = &get_instance();
	$CI->db->select('*');
	$CI->db->from('grade_category');
	$query   = $CI->db->get();
	$results = $query->result();

	$output = '<select name="'.$field_name.'" id="field_'.$field_name.'" class="form-control required" >';
	$output .= '<option value="0" > '.getlang('select_grade_category', 'sys_data').' </option>';

	foreach ($results as $key => $item) {
		$id = $item->id;

		if (in_array($id, $gcat_ids)) {
			$output .= '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
		} else {
			$output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
		}
	}

	$output .= '</select>';

	return $output;
}

/**
 ** Get Latest Message
 **/
function getLatestMessage($uid) {
	$CI = &get_instance();
	$CI->db->select('*');
	$CI->db->from('messages');
	$CI->db->where('recever_id = '.$uid.' OR sender_id = '.$uid.'');
	$CI->db->order_by('id', 'DESC');
	$CI->db->limit('5');
	$query = $CI->db->get();

	return $query->result();
}

/**
 ** Get Unread Message
 **/
function unreadMessageByid($id) {
	$CI = &get_instance();
	$CI->db->select('*');
	$CI->db->from('messages');
	$CI->db->where('status', 0);
	$CI->db->where('id', $id);
	$query_m = $CI->db->get();
	$total_m = $query_m->num_rows();

	$CI->db->select('*');
	$CI->db->from('message_reply');
	$CI->db->where('status', 0);
	$CI->db->where('message_id', $id);
	$query_r = $CI->db->get();
	$total_r = $query_r->num_rows();

	$total = round($total_m + $total_r);

	return $total;
}

/**
 ** Reply Message List
 **/
function getReplyMessages($message_id) {
	$CI = &get_instance();
	$CI->db->select('*');
	$CI->db->from('message_reply');
	$CI->db->where('message_id', $message_id);
	$query = $CI->db->get();

	return $query->result();
}

/**
 ** Get Message avatar
 **/
function getMessagesAvatar($uid) {
	// get user group
	$group = getSingledata('users', 'roleId', 'userId', $uid);

// Get group wise data
	if ($group == ROLE_TEACHER) {
		$folder_name = 'teachers';
	} elseif ($group == ROLE_PARENT) {
		$folder_name = 'parents';
	} elseif ($group == ROLE_STUDENT) {
		$folder_name = 'students';
	} else {
		$folder_name = 'users';
	}

	$avatar = getSingledata('users', 'avatar', 'userId', $uid);
	if (empty($avatar)) {
		$img_path = site_url('/uploads/users').'/avator.png';
	} else {
		$img_path = site_url('/uploads/'.$folder_name).'/'.$avatar;
	}

	return $img_path;
}

/**
 ** Get Message status updater
 **/
function getMessagesstatusUpdate($id, $rid) {
	$CI   = &get_instance();
	$data = array('status' => 1);
	$CI->db->where('id', $id);
	$CI->db->where('recever_id', $rid);
	$CI->db->update('messages', $data);

	$data_r = array('status' => 1);
	$CI->db->where('message_id', $id);
	$CI->db->where('recever_id', $rid);
	$CI->db->update('message_reply', $data_r);

	return TRUE;
}

/**
 * @param $exam_id
 */
function formFilledUpForExam($exam_id) {
	$CI = &get_instance();
	$CI->db->select('exam_id');
	$CI->db->where('exam_id', $exam_id);
	$query  = $CI->db->get('form_entries');
	$result = $query->row();
	if ($result) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * @param $array
 * @param $die
 */
function pr($array, $die = 0) {
	echo "<pre>";
	print_r($array);
	echo "</pre>";

	if ($die) {
		die;
	}
}
