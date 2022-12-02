<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 *  @author     : zwebtheme
 *  date        : Aprill, 2019
 *  Bogra - School Management System
 *  http://codecanyon.net/user/zwebtheme
 *  http://support.zwebtheme.com
 */

/**
 ** Published/ Unpublished
 * @param string $name : field name
 * @param  $id : exit field id value
 * @return $output : This is output to set field
 **/
function getDirection($name, $id)
{
    $list = array(
        'ltl' => 'ltl',
        'rtl' => 'rtl'
    );

    $output = '<select name="'.$name.'" id="s_'.$name.'" class="form-control" >';
    foreach ($list as $key => $item) {
        if ($key == $id) {
            $output .= '<option selected="selected" value="'.$key.'">'.$item.'</option>';
        } else {
            $output .= '<option value="'.$key.'">'.$item.'</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 ** Get  Language List
 * @param string $field : lang field name
 * @param  $ids : exit field id values
 **/
function getLanguageList($field, $ids)
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('languages');
    $CI->db->where('published', 0);
    $query   = $CI->db->get();
    $results = $query->result();

    $output = '<select name="'.$field.'" id="language_'.$field.'" class="form-control " >';
    $output .= '<option value="0" > Select Language </option>';
    foreach ($results as $key => $item) {
        $id = $item->id;
        if ($id == $ids) {
            $output .= '<option selected="selected" value="'.$item->id.'">'.$item->title.'</option>';
        } else {
            $output .= '<option value="'.$item->id.'">'.$item->title.'</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 ** Get  Language List
 **/
function getLanguageObj()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('languages');
    $CI->db->where('published', 1);
    $query   = $CI->db->get();
    $results = $query->result();

    return $results;
}

/**
 ** Get System language data
 **/
function getSystemLang()
{
    $system_lang_data = array(

        // Sitebar Menu Section
        'menu_title'                               => 'Menu',
        'menu_academics'                           => 'Academics',
        'menu_accounting'                          => 'Accounting',
        'menu_class'                               => 'Class',
        'menu_courses'                             => 'Courses',
        'menu_examcard'                            => 'Examination Card',
        'menu_configuration'                       => 'Configuration',
        'menu_department'                          => 'Department',
        'menu_dashboard'                           => 'Dashboard',
        'menu_exams'                               => 'Exams',
        'menu_fees'                                => 'Fees',
        'menu_field_builder'                       => 'Field Builder',
        'menu_grade'                               => 'Grade',
        'menu_grade_category'                      => 'Grade Category',
        'menu_incomes'                             => 'Incomes',
        'menu_languages'                           => 'Languages',
        'menu_marks'                               => 'Marks',
        'menu_notices'                             => 'Notices',
        'menu_parents'                             => 'Parents',
        'menu_payments'                            => 'Payments',
        'menu_payment_method'                      => 'Payment Method',
        'menu_setting'                             => 'Setting',
        'menu_subjects'                            => 'Subjects',
        'menu_students'                            => 'Students',
        'menu_teachers'                            => 'Teachers',
        'menu_users'                               => 'Users',
        'menu_year'                                => 'Year',

        // Title Section
        'title_section'                            => 'Title',

        'title_academic_grade_new'                 => 'Add New Grade',
        'title_academic_grade_category_add'        => 'Add New Grade Category',
        'title_add_fees'                           => 'Add Fees',
        'title_accountig'                          => 'Accounting',
        'title_add_notice'                         => 'Add Notice',
        'title_academic'                           => 'Academic Quick icon',
        'title_academic_year'                      => 'Academic Year Management',
        'title_add_user'                           => 'Add User Form',
        'title_field_add'                          => 'Add New Field',
        'sub_title_dashboard'                      => 'Control Panel',
        'title_academic_class'                     => 'Class Management',
        'title_academic_courses'                   => 'Courses Management',
        'title_academic_examcards'                 => 'ExamCards Management',
        'title_payment_configuration_method'       => 'Configuration Methods',
        'field_list_sub_title'                     => 'create/update notice',
        'title_configuration'                      => 'Configuration',
        'title_dashboard'                          => 'Dashboard',
        'title_academic_department'                => 'Department Management',
        'title_academic_grade_edit'                => 'Edit Grade',
        'title_academic_exam'                      => 'Exam Management',
        'title_academic_grade_category_edit'       => 'Edit Grade Category',
        'title_edit_fees'                          => 'Edit Fees',
        'title_edit_notice'                        => 'Edit Notice',
        'title_field_edit'                         => 'Edit Field',
        'title_edit_user'                          => 'Edit User Form',
        'title_fees'                               => 'Fees Management',
        'title_field_list'                         => 'Field list',
        'title_fees_manage'                        => 'Fees Management',
        'title_academic_grade'                     => 'Grade Management',
        'title_academic_grade_category'            => 'Grade Category Management',
        'title_income'                             => 'Income List',
        'title_academic_mark'                      => 'Mark Management',
        'title_notice'                             => 'Notice List',
        'title_parent'                             => 'Parents Management',
        'title_payment'                            => 'Payment List',
        'title_payment_method'                     => 'Payment Methods',
        'title_academic_subject'                   => 'Subject Management',
        'title_student'                            => 'Student Management',
        'title_teacher'                            => 'Teacher Management',
        'title_user'                               => 'User List',

        // Button Section
        'btn_add'                                  => 'Add',
        'button_section'                           => 'Button',
        'btn_cancel'                               => 'Cancel',
        'btn_change_password'                      => 'Change password',
        'btn_check_login_activity'                 => 'Check Login Activity',
        'btn_change_avatar'                        => 'Change avatar',
        'btn_login'                                => 'Login',
        'btn_logout'                               => 'Logout',
        'btn_submit'                               => 'Submit',

        // Tab Section
        'tab_section'                              => 'Tab',

        'tab_academic'                             => 'Academic',
        'tab_account'                              => 'Account',
        'tab_subject'                              => 'Subject',
        'tab_email_template'                       => 'Email Template',
        'tab_general'                              => 'General',
        'tab_media'                                => 'Media',
        'tab_mail_configuration'                   => 'Mail Configuration',
        'tab_404_page'                             => '404 Page',
        'prent_student_info'                       => 'Parent Student Information',
        'tab_payment'                              => 'Payment',
        'tab_theme'                                => 'Theme',

        // System Message Section
        'system_message_section'                   => 'System Messages',

        'system_confirm_delete_msg'                => 'Are you sure you want to delete ?',
        'system_confirm_trush_msg'                 => 'Are you sure you want to trush ?',
        'system_confirm_reactive_msg'              => 'Are you sure you want to reactive ?',
        'system_access_denied'                     => 'Access denied..!',
        'system_data_delete_failed'                => 'Data delete failed.',
        'system_data_update_successfully'          => 'Data update successfully but not stored for demo account',
        'system_data_delete_successfully'          => 'Data delete successfully but not stored for demo account',
        'system_data_create_failed'                => 'Data create failed',
        'system_data_update_failed'                => 'Data update failed',
        'exam_card_exists_error'                   => 'Exam card for this department for this year is already Exists',

        'system_data_create_successfully'          => 'Data create successfully but not stored for demo account',
        'data_create_successfully_activate'        => 'Data create successfully & Activation link sent to your email !',
        'system_email_pass_mismatch'               => 'Email pass mismatch',
        'system_excel_file_successfully_upload'    => 'Excel File successfully upload & mark stored  ! but not stored for demo account',
        'system_email_registered'                  => 'Invalid Email',
        'system_no_permission'                     => 'No Permission',
        'system_reset_pass'                        => 'Reset Password',
        'system_pass_link_sent'                    => 'Reset password link sent to your email.',
        'system_email_failed'                      => 'Reset password link send failed',
        'system_review_add_success'                => 'Review add successfully',
        'system_review_add_failed'                 => 'Review add failed',
        'system_please_select_csv_file'            => 'Please select CSV file !',
        'system_pass_update_success'               => 'Password update successful but not stored for demo account',
        'system_pass_update_failed'                => 'Password update failed',
        'system_sent_details_error'                => 'Sending unable !',
        'system_somthing_worng'                    => 'Somthing worng !',
        'system_search_mitchmatch'                 => 'Serarch result mitchmatch try again !',
        'system_old_pass_error'                    => 'Your old password not correct !',
        'system_data_delete_success'               => 'Successfully deleted.',
        'system_data_trush_success'                => 'Successfully trushed.',
        'system_save_success'                      => 'Save Success',
        'system_save_error'                        => 'Save Error',
        'system_data_trush_failed'                 => 'Trushed failed.',
        'system_pass_success'                      => 'Your password successfully reset but not stored for demo account',
        'system_pass_error'                        => 'Your password reset failed ',

        // Set default word Or sentense
        'default_word'                             => 'Default Word',
        'add_edit_delete'                          => 'Add/ Edit/ Delete',
        'action'                                   => 'Action',
        'admin'                                    => 'Admin',
        'active'                                   => 'Active',
        'comment'                                  => 'Comment',
        'delete'                                   => 'Delete',
        'date'                                     => 'Date',
        'edit'                                     => 'Edit',
        'email'                                    => 'Email',
        'id'                                       => 'ID',
        'inactive'                                 => 'Inactive',
        'photo'                                    => 'Photo',
        'published'                                => 'Published',
        'profile_view'                             => 'Profile View',
        'profile'                                  => 'Profile',
        'phone'                                    => 'Phone',
        'print'                                    => 'Print',
        'search'                                   => 'Search',
        'search_here'                              => 'Search Here',
        'status'                                   => 'Status',
        'show_status'                              => 'Show Status',
        'save'                                     => 'Save',
        'saving'                                   => 'Saving',
        'select'                                   => 'Select',
        'show_verified'                            => 'Show Verified',
        'show_group'                               => 'Show Group',
        'trush'                                    => 'Trush',

        'unverified'                               => 'Unverified',
        'unpublished'                              => 'Unpublished',
        'verified'                                 => 'Verified',

        // Month
        'month_section'                            => 'Month',

        'month_jan'                                => 'Jan',
        'month_feb'                                => 'Feb',
        'month_mar'                                => 'Mar',
        'month_apr'                                => 'Apr',
        'month_may'                                => 'May',
        'month_jun'                                => 'Jun',
        'month_jul'                                => 'Jul',
        'month_aug'                                => 'Aug',
        'month_sep'                                => 'Sep',
        'month_oct'                                => 'Oct',
        'month_nov'                                => 'Nov',
        'month_dec'                                => 'Dec',

        // Browser Tab
        'browser_tab_title'                        => 'Brower Tab Title',

        'browser_tab_academicyear_list_title'      => 'Academic Year List',
        'browser_tab_academic_list_title'          => 'Academic Management',
        'browser_tab_accounting_dashboard'         => 'Accounting Dashboard',
        'browser_tab_add_new_year'                 => 'Add New Year',
        'browser_tab_addnew_class_title'           => 'Add New Class',
        'browser_tab_addnew_course_title'          => 'Add New Course',
        'browser_tab_addnew_examcard_title'        => 'Add New ExamCard',
        'browser_tab_add_new_subject'              => 'Add New Subject',
        'browser_tab_add_new_department'           => 'Add New Department',
        'browser_tab_add_new_exam'                 => 'Add New Exam',
        'browser_tab_fees_add'                     => 'Add New Fees',
        'browser_tab_gcategory_new'                => 'Add New Grade Category',
        'browser_tab_grade_new'                    => 'Add New Grade',
        'browser_tab_add_parent'                   => 'Add New Parent',
        'browser_tab_add_new_students_title'       => 'Add New Sutdent',
        'browser_tab_teacher_add'                  => 'Add New Teacher',
        'browser_tab_attendances_list_title'       => 'Attendances List',
        'browser_tab_add_field'                    => 'Add New Field',
        'browser_tab_class_list_title'             => 'Class List',
        'browser_tab_courses_list_title'           => 'Courses List',
        'browser_tab_examcard_list_title'          => 'ExamCard List',
        'browser_tab_change_password'              => 'Change Password',
        'browser_tab_signup_page_title'            => 'Signup',
        'browser_tab_configuration_page_title'     => 'Configuration',
        'browser_tab_department_list_title'        => 'Departments List',
        'browser_tab_dashboard_page_title'         => 'Dashboard',
        'browser_tab_edit_class_title'             => 'Edit Class',
        'browser_tab_edit_course_title'            => 'Edit Course',
        'browser_tab_edit_examcard_title'          => 'Edit ExamCard',
        'browser_tab_edit_year'                    => 'Edit year',
        'browser_tab_edit_subject'                 => 'Edit Subject',
        'browser_tab_edit_department'              => 'Edit Department',
        'browser_tab_exam_list_title'              => 'Exams List',
        'browser_tab_edit_exam'                    => 'Edit Exam',
        'browser_tab_gcategory_edit'               => 'Edit Grade Category',
        'browser_tab_grade_edit'                   => 'Edit Grade',
        'browser_tab_notice_edit'                  => 'Edit Notice',
        'browser_tab_parent_edit'                  => 'Edit Parent',
        'browser_tab_teacher_edit'                 => 'Edit Teacher',
        'browser_tab_fees_manage'                  => 'Fees Management',
        'browser_tab_fees_edit'                    => 'Fees Edit',
        'browser_tab_edit_field'                   => 'Field Edit',
        'browser_tab_field_list'                   => 'Field list',
        'browser_tab_gcategory_manage'             => 'Grade Category Management',
        'browser_tab_grade_manage'                 => 'Grade Management',
        'browser_tab_incomes'                      => 'Incomes',
        'browser_tab_mark_title'                   => 'Manage Mark',
        'browser_tab_notice_page_title'            => 'Notice',
        'browser_tab_notice_new'                   => 'New Notice',
        'browser_tab_parent_profile'               => 'Parent Profile',
        'browser_tab_parent_list_title'            => 'Parents List',
        'browser_tab_title_payment'                => 'Payment List',
        'browser_tab_title_payment_invoice'        => 'Payment Invoice',
        'browser_tab_payment_configuration_method' => 'Payment Configuration Method',
        'browser_tab_payment'                      => 'Payment',
        'browser_tab_student_profile'              => 'Student Profile',
        'browser_tab_students_list_title'          => 'Students List',
        'browser_tab_subjects_list_title'          => 'Subjects Management',
        'browser_tab_teacher_profile'              => 'Teacher Profile',
        'browser_tab_teachers_list_title'          => 'Teachers List',
        'browser_tab_user_page_title'              => 'User List',

        // Other Section
        'other_section'                            => 'Other',

        'academic_year_list'                       => 'Academic Year List',
        'add_new_students_title'                   => 'Add New Sutdent',
        'assign_parent'                            => 'Assign Parent',
        'add_new_parent_title'                     => 'Add New Parent',
        'add_new_parent'                           => 'Add New Parent',
        'ammount'                                  => 'Ammount',
        'all'                                      => 'All',
        '404_page_not_found'                       => '404 page not found',
        'class_name'                               => 'Class Name',
        'class_list'                               => 'Class List',
        'courses_list'                             => 'Courses List',
        'exam_cards_list'                          => 'ExamCards List',
        'create_parent_account'                    => 'Create an account',
        'childs_name'                              => 'Child Name',
        'childs_info'                              => 'Child Information :',
        'change_avatar'                            => 'Change Photo',
        'change_password'                          => 'Change Password',
        'created_by'                               => 'Created By',
        'cancel'                                   => 'Cancel',
        'gcat_name'                                => 'Category Name',
        'retype_password'                          => 'Confirm Password',
        'department_list'                          => 'Departments List',
        'department_name'                          => 'Department',
        'course_name'                              => 'Course Name',
        'course_code'                              => 'Course Code',
        'paper'                                    => 'Paper',
        'paper_code'                               => 'Paper Code',
        'designation'                              => 'Designation',
        'due'                                      => 'Due',
        'exam_list'                                => 'Exam List',
        'exam_name'                                => 'Exam Name',
        'exam_date'                                => 'Exam Date',
        'excel_file_successfully_upload'           => 'Excel File successfully upload & mark stored  ! ',
        'edit_students_title'                      => 'Edit Sutdent',
        'edit_parent_title'                        => 'Edit Parent',
        'edit_parent'                              => 'Edit Parent',
        'empty_list'                               => 'Empty List',
        'empty_trush'                              => 'Empty Trush',
        'enter_user_details'                       => 'Enter User Details',
        'full_name'                                => 'Full Name',
        'fees'                                     => 'Fees',
        'fees_title'                               => 'Fees title',
        'forget_password'                          => 'Forget password',
        'filter_by_month'                          => 'Filter By Month',
        'filter_by_year'                           => 'Filter By Year',
        'filter_by_status'                         => 'Filter By Status',
        'filter_by_section'                        => 'Filter By Section',
        'field_name'                               => 'Field Title',
        'field_type'                               => 'Field Type',
        'field_section'                            => 'Field Section',
        'field_order'                              => 'Field Order',
        'grade_name'                               => 'Grade Name',
        'grade_point'                              => 'Grade point',
        'user_group'                               => 'Group',
        'hit'                                      => 'Hit',
        'invoice'                                  => 'Invoice',
        'issue'                                    => 'Issue',
        'income_list'                              => 'Income List',
        'invoice_to'                               => 'Invoice To',
        'loading'                                  => 'Loading....',
        'admin_login_activity'                     => 'Login Activity',
        'login_page_title'                         => 'Login',
        'mark_from'                                => 'Mark From',
        'mark_upto'                                => 'Mark Upto',
        'mark'                                     => 'Mark',
        'method'                                   => 'Method',
        'name'                                     => 'Name',
        'new_password'                             => 'New Password',
        'notice_title'                             => 'Notice Title',
        'notice_content'                           => 'Notice Content',
        'no_student_found'                         => 'No student found',
        'obtained'                                 => 'Obtained',
        'or'                                       => 'Or',
        'online'                                   => 'Online',
        'old_password'                             => 'Old Password',
        'parents'                                  => 'Parents',
        'paid_by'                                  => 'Paid by',
        'paid'                                     => 'Paid:',
        'payment_to'                               => 'Payment To',
        'parent_assign'                            => 'Parent Assign',
        'enter_roll'                               => 'Please Enter Students Roll',
        'parent_name'                              => 'Parent Name',
        'parent_list'                              => 'Parents List',
        'pending'                                  => 'Pending',
        'payment_successfully'                     => 'Payment add successfully !',
        'payment_failed'                           => 'Payment add failed !',
        'passowrd'                                 => 'Password',
        'roll_studentname_mark_comment'            => 'Roll, Student Name, Mark, Comment',
        'review_by'                                => 'Review By',
        'review_comment'                           => 'Review Comment:',
        'reactive_successfully'                    => 'Reactive successfully',
        'reactive_failed'                          => 'Reactive failed',
        'remembar_me'                              => 'Remembar Me',
        'recently'                                 => 'Recently',
        'review'                                   => 'Review',
        'students'                                 => 'Students',
        'select_students'                          => 'Select Student',
        'select_exam'                              => 'Select Exam',
        'select_class'                             => 'Select Class',
        'select_subject'                           => 'Select Subject',
        'select_department'                        => 'Select Department',
        'roll'                                     => 'Students Roll',
        'select_role'                              => 'Select Role',
        'student_list'                             => 'Students List',
        'select_year'                              => 'Select Year',
        'select_grade_category'                    => 'Select Grade Category',
        'student_name'                             => 'Student Name',
        'sub_total'                                => 'Sub Total:',
        'subject_name'                             => 'Subject Name',
        'subject_code'                             => 'Subject Code',
        'subject_type'                             => 'Subject Type',
        'subject_list'                             => 'Subjects List',
        'compulsory_subject'                       => 'Compulsory Subject',
        'honors_subject'                           => 'Honors Subject',
        'optional_subject'                         => 'Optional Subject',
        'select_month'                             => 'Select Month',
        'total'                                    => 'Total',
        'title'                                    => 'Title',
        'total_income'                             => 'Total Income',
        'teachers'                                 => 'Teachers',
        'teacher_name'                             => 'Teacher name',
        'type_parent_name'                         => 'Type Parent Namet',
        'user_list'                                => 'User List',
        'users'                                    => 'Users',
        'upload'                                   => 'Upload',
        'unpaid'                                   => 'Unpaid',
        'under_review'                             => 'Under Review',
        'user_name'                                => 'User Name',
        'user_loged_in'                            => 'user loged in.',
        'view_details'                             => 'View Details',
        'year'                                     => 'Year',
        'department'                               => 'Department',
        'class'                                    => 'Class',
        'semester'                                 => 'Semester'

    );

    return $system_lang_data;
}

/**
 ** Get Site language data
 **/
function getSiteLang()
{
    $site_lang_data = array(

        // Set Menu
        'menu_title'                             => 'User Menu',
        'site_menu_attendances'                  => 'Attendance',
        'site_menu_dashboard'                    => 'Dashboard',
        'site_menu_login_activity'               => 'Login Activity',
        'site_menu_site_logout'                  => 'Logout',
        'site_menu_site_login'                   => 'Login',
        'site_menu_mark'                         => 'Manage mark',
        'site_menu_profile'                      => 'My Profile',
        'site_menu_account'                      => 'My Account',
        'site_menu_message'                      => 'Message',
        'site_menu_notice'                       => 'Notice',
        'site_menu_payments'                     => 'Payment',
        'site_menu_subjects'                     => 'Subjects',
        'site_menu_exam_card'                    => 'Exam Card',
        'site_menu_result'                       => 'Result',
        'site_menu_site_signup'                  => 'Signup',

        // Browser title
        'site_browser_title'                     => 'Browser Title',

        'site_dashboard_browser_title'           => 'Dashboard',
        'site_browser_my_profile_title'          => 'My Profile',
        'site_browser_student_profile_title'     => 'Student Profile',
        'site_browser_log_title'                 => 'My Logs',
        'site_browser_my_account_title'          => 'My Account',
        'site_browser_attendance_title'          => 'Attendance',
        'site_browser_subjects_title'          => 'Subjects',
        'site_browser_exam_card_title'          => 'ExamCard',
        'site_browser_result_title'              => 'Result',
        'site_msg_details_title'                 => 'Subject',
        'site_browser_message_title'             => 'My Messages',
        'site_browser_message_details_title'     => 'Messages details',
        'site_browser_new_message_title'         => 'New Messages',
        'site_browser_edit_attendances_title'    => 'Edit Attendance',
        'site_browser_addnew_attendances_title'  => 'Add new attendance',
        'site_browser_payment_list_title'        => 'Payment List',
        'site_browser_payment_title'             => 'Payment',
        'site_browser_payment_process_title'     => 'Payment proccess',
        'site_borwser_payment_invoice_title'     => 'Payment Invoice',
        'site_borwser_payment_title'             => 'Payment',
        'site_browser_addnew_payment_title'      => 'Add new payment',
        'site_browser_notice_page_title'         => 'Notice list',
        'site_browser_notice_details_page_title' => 'Notice details',

        // Message

        'site_message_title'                     => 'Front-end System Message',
        'site_data_update_successfully'          => 'Data update successfully but not efect for demo account',
        'site_data_update_failed'                => 'Data update failed',
        'site_data_create_successfully'          => 'Data create successfully but not efect for demo account',
        'site_data_create_failed'                => 'Data create failed',
        'site_search_mismatch'                   => 'Search mismatch',
        'site_payment_successfully'              => 'Payment successful',
        'site_review_add_success'                => 'Review add successfully but not efect for demo account',
        'site_review_add_failed'                 => 'Review add failed',
        'site_payment_failed'                    => 'Payment failed',
        'site_empty_list'                        => 'Empty List',
        'site_message_send_successfully'         => 'Message send successfully',
        'site_message_send_failed'               => 'Message send failed',
        'site_select_payment_fees'               => 'You did not select payment fees ! please try again',
        'site_select_payment_type'               => 'You did not select payment type ! please try again',

        // Site button

        'site_button'                            => 'Button',

        'site_btn_change_password'               => 'Change Password',
        'site_btn_change_photo'                  => 'Change Photo',
        'site_btn_notice'                        => 'Notice',
        'site_btn_login_activity'                => 'Login activity',
        'site_btn_submit'                        => 'Submit',
        'site_btn_send'                          => 'Send',
        'site_btn_compose'                       => 'Compose',
        'site_btn_new_attendance'                => 'New attendance',
        'site_btn_edit'                          => 'Edit',
        'site_btn_cancel'                        => 'Cancel',
        'site_take_attendances'                  => 'Take Attendance',

        // Title
        'site_title'                             => 'Title',

        'site_latest_msg_title'                  => 'Latest Message',
        'site_latest_notice_title'               => 'Latest Notice',
        'site_welcome_title'                     => 'Welcome Back',
        'site_my_login_activity_title'           => 'My Login Activity',
        'site_my_account_title'                  => 'My Account',
        'site_sign_up_title'                     => 'Signup Form',
        'site_sign_up_title_2'                   => 'Signup Step 2',
        'site_mesage_title'                      => 'Message',
        'site_attendance_title'                  => 'Student Attendance Report',
        'site_subject_title'                  => ' Subjects',
        'site_exam_card_title'                  => ' ExamCard',
        'site_attendance_list_title'             => 'Attendance List',
        'site_attendances_manage'                => 'Attencances Management',
        'site_payment_list_title'                => 'Payment list',
        'site_notice_list_tittle'                => 'Notice list',
        'site_entry_by'                          => 'Entry By',
        'site_present_status'                    => 'Present',

        // Tab
        'site_tab'                               => 'Tab',

        'site_tab_profile'                       => 'Profile',
        'site_tab_account'                       => 'Account',
        'site_tab_change_password'               => 'Change password',
        'site_tab_change_photo'                  => 'Photo',

        // Form element

        'site_form_field'                        => 'Form Element',

        'site_form_passowrd'                     => 'Password',
        'site_form_new_password'                 => 'New password',
        'site_form_old_password'                 => 'Old password',
        'site_form_retype_password'              => 'Retype password',
        'site_form_email'                        => 'Email',
        'site_form_enter_roll'                   => 'Enter roll',
        'site_form_user_name'                    => 'User name',
        'site_form_phone'                        => 'Phone',
        'site_form_select_group'                 => 'Select group',
        'site_form_class'                        => 'Class',
        'site_form_department'                   => 'Department',
        'site_form_subject'                      => 'Subject',
        'site_form_year'                         => 'Year',
        'site_form_month'                        => 'Month',
        'site_form_roll'                         => 'Roll',
        'site_form_enter_message'                => 'Enter message',
        'site_form_select_student'               => 'Select student',
        'site_form_new_message'                  => 'New Message',
        'site_form_student'                      => 'Student',
        'site_form_parent'                       => 'Parent',
        'site_form_enter_parent_name'            => 'Enter parent name',
        'site_form_teacher'                      => 'Teacher',
        'site_form_enter_name'                   => 'Enter name',
        'site_form_enter_teacher_name'           => 'Enter teacher name',
        'site_form_select_exam'                  => 'Select Exam',
        'site_form_fees'                         => 'Fees',
        'site_form_paid_amount'                  => 'Paid Ammount',
        'site_form_payment_method'               => 'Payment method',
        'site_form_payment_form'                 => 'Payment Form',
        'site_form_total_bill'                   => 'Total Bill',
        'site_form_due'                          => 'Due',
        'site_form_all'                          => 'All',
        'site_form_paid'                         => 'Paid',
        'site_form_unpaid'                       => 'Unpaid',
        'site_form_cancel'                       => 'Cancel',
        'site_form_under_review'                 => 'Under Review',
        'site_form_pending'                      => 'Pending',
        'site_form_select_year'                  => 'Select Year',
        'site_form_select_month'                 => 'Select month',
        'site_form_enter_student_roll_name'      => 'Enter student name or roll',

        // Others
        'site_others'                            => 'Others',

        'site_from'                              => 'From',
        'site_last_login'                        => 'Last Login',
        'site_to'                                => 'To',
        'site_unread'                            => 'Unread',
        'site_unread'                            => 'Unread',
        'site_menu_choose_lang'                  => 'Choose language',
        'site_roll'                              => 'Roll',
        'site_email'                             => 'Email',
        'site_error'                             => 'Error',
        'site_teacher_name'                      => 'Teacher name',
        'site_parent_name'                       => 'Parent name',
        'site_class'                             => 'Class',
        'site_child_info'                        => 'Child Information',
        'site_phone'                             => 'Phone',
        'site_designation'                       => 'Designation',
        'site_subject'                           => 'Subject',
        'site_student_name'                      => 'Student name',
        'site_department'                        => 'Department',
        'site_profile_info'                      => 'Profile Information',
        'site_academic_info'                     => 'Academic Information',
        'site_signup_request'                    => 'Signup request for',
        'site_select_here'                       => 'Select here',
        'site_payment_not_fount'                 => 'Payment not found',
        'site_select_date'                       => 'Please select Date.',
        'site_select_class'                      => 'Please select class.',
        'site_select_department'                 => 'Please select department.',
        'site_loading'                           => 'Loading ...',
        'site_date'                              => 'Date',
        'site_total_student'                     => 'Total students',
        'site_total_parent'                      => 'Total parents',
        'site_teacher_comment'                   => 'Teacher comment',
        'site_sub_total'                         => 'Sub total',
        'site_total'                             => 'Total',
        'site_absent'                            => 'Total absent',
        'site_edit'                              => 'Edit',
        'site_exam'                              => 'Exam',
        'site_due'                               => 'Due',
        'site_fees'                              => 'Fees',
        'site_paid'                              => 'Paid',
        'site_commnet'                           => 'Comment',
        'site_grade'                             => 'Grade',
        'site_obtain_mark'                       => 'Obtaine mark',
        'site_print'                             => 'Print',
        'site_invoice'                           => 'Invoice',
        'site_issue'                             => 'Issue:',
        'site_status'                            => 'Status:',
        'site_save'                              => 'Save',
        'site_comment_saving'                    => 'Comment saving',
        'site_paid_by'                           => 'Paid by:',
        'site_payment_to'                        => 'Payment To',
        'site_total_mark'                        => 'Total mark',
        'site_gpa'                               => 'GPA',
        'site_invoice_to'                        => 'Invoice To',
        'site_student_roll'                      => 'Student Roll',
        'site_student_class'                     => 'Student Class',
        'site_amount'                            => 'Amount',
        'site_review'                            => 'Review',
        'site_pay_now'                           => 'Pay Now',
        'site_payment_method'                    => 'Method'
    );

    return $site_lang_data;
}

/**
 ** Get flug list
 * @param string $name : lang flag name
 * @param  $id : exit flag alias
 **/
function getFlags($name, $id)
{
    $list = array(
        'af' => 'af', 'af_za' => 'af_za', 'al' => 'al', 'ar' => 'ar', 'ar_aa' => 'ar', 'at' => 'at', 'az' => 'az', 'az_az' => 'az_az', 'be' => 'be', 'be_by' => 'be_by', 'belg' => 'belg', 'bg' => 'bg', 'bg_bg' => 'bg_bg', 'bn' => 'bn', 'bn_bd' => 'bn_bd', 'br' => 'br', 'br_fr' => 'br_fr', 'bs' => 'bs', 'bs_ba' => 'bs_ba', 'ca' => 'ca', 'ca_es' => 'ca_es', 'cbk_iq' => 'cbk_iq', 'ch' => 'ch', 'cs' => 'cs', 'cs_cz' => 'cs_cz', 'cy' => 'cy', 'cy_gb' => 'cy_gb', 'cz' => 'cz', 'da' => 'da', 'da_dk' => 'da_dk', 'de' => 'de', 'de_ch' => 'de_ch', 'de_de' => 'de_de', 'de_li' => 'de_li', 'de_lu' => 'de_lu', 'dk' => 'dk', 'dz_bt' => 'dz_bt', 'el' => 'el', 'el_gr' => 'el_gr', 'en' => 'en', 'en_au' => 'en_au', 'en_ca' => 'en_ca', 'en_gb' => 'en_gb', 'en_nz' => 'en_nz', 'en_us' => 'en_us', 'eo' => 'eo', 'eo_xx' => 'eo_xx', 'es' => 'es', 'es_co' => 'es_co', 'es_es' => 'es_es', 'et' => 'et', 'et_ee' => 'et_ee', 'eu_es' => 'eu_es', 'fa' => 'fa', 'fi' => 'fi', 'fi_fi' => 'fi_fi', 'fr' => 'fr', 'fr_ca' => 'fr_ca', 'fr_fr' => 'fr_fr', 'ga_ie' => 'ga_ie', 'gd' => 'gd', 'gd_gb' => 'gd_gb', 'gl' => 'gl', 'he' => 'he', 'he_il' => 'he_il', 'hi' => 'hi', 'hk' => 'hk', 'hi_in' => 'hi_in', 'hk' => 'hk', 'hk_hk' => 'hk_hk', 'hr' => 'hr', 'hr_hr' => 'hr_hr', 'hu' => 'hu', 'hu_hu' => 'hu_hu', 'hy' => 'hy', 'hy_am' => 'hy_am', 'id' => 'id', 'id_id' => 'id_id', 'is' => 'is', 'is_is' => 'is_is', 'it' => 'it', 'it_it' => 'it_it', 'ja' => 'ja', 'ja_jp' => 'ja_jp', 'ka' => 'ka', 'ka_ge' => 'ka_ge', 'km' => 'km', 'km_kh' => 'km_kh', 'ko' => 'ko', 'ko_kr' => 'ko_kr', 'ku' => 'ku', 'lo' => 'lo', 'lo_la' => 'lo_la', 'lt' => 'lt', 'lt_lt' => 'lt_lt', 'lv' => 'lv', 'lv_lv' => 'lv_lv', 'mk' => 'mk', 'mk_mk' => 'mk_mk', 'mn' => 'mn', 'mn_mn' => 'mn_mn', 'ms_my' => 'ms_my', 'nb_no' => 'nb_no', 'nl' => 'nl', 'nl_be' => 'nl_be', 'nl_nl' => 'nl_nl', 'nn_no' => 'nn_no', 'no' => 'no', 'pl' => 'pl', 'pl_pl' => 'pl_pl', 'prs_af' => 'prs_af', 'ps' => 'ps', 'ps_af' => 'ps_af', 'pt' => 'pt', 'pt_br' => 'pt_br', 'pt_pt' => 'pt_pt', 'ro' => 'ro', 'ro_ro' => 'ro_ro', 'ru' => 'ru', 'ru_ru' => 'ru_ru', 'si' => 'si', 'sk' => 'sk', 'sk_sk' => 'sk_sk', 'sl' => 'sl', 'sl_si' => 'sl_si', 'sq_al' => 'sq_al', 'sr' => 'sr', 'sr_rs' => 'sr_rs', 'sr_yu' => 'sr_yu', 'srp_me' => 'srp_me', 'sv' => 'sv', 'sv_se' => 'sv_se', 'sw' => 'sw', 'sw_ke' => 'sw_ke', 'sy' => 'sy', 'sy_iq' => 'sy_iq', 'ta' => 'ta', 'ta_in' => 'ta_in', 'th' => 'th', 'th_th' => 'th_th', 'tk_tm' => 'tk_tm', 'tr' => 'tr', 'tr_tr' => 'tr_tr', 'tw' => 'tw', 'ug_cn' => 'ug_cn', 'uk' => 'uk', 'uk_ua' => 'uk_ua', 'ur' => 'ur', 'ur_pk' => 'ur_pk', 'us' => 'us', 'uz' => 'uz', 'uz_uz' => 'uz_uz', 'vi' => 'vi', 'vi_vn' => 'vi_vn', 'zh' => 'zh', 'zh_cn' => 'zh_cn', 'zh_tw' => 'zh_tw'
    );

    $output = '<select name="'.$name.'" id="s_'.$name.'" class="form-control" >';

    foreach ($list as $key => $item) {
        if ($key == $id) {
            $output .= '<option selected="selected" value="'.$key.'">'.$item.'</option>';
        } else {
            $output .= '<option value="'.$key.'">'.$item.'</option>';
        }
    }

    $output .= '</select>';

    return $output;
}

/**
 ** Get Lang
 * @param string $name : lang flag name
 * @param  $field_name : data
 **/
function getlang($name, $field_name = 'data')
{
    $CI = &get_instance();

    if ($field_name == 'data') {
        $sys_data = getSiteLang();
    } else {
        $sys_data = getSystemLang();
    }

    // Get default language
    $lang_id = getConfigItem('default_language');
    $sw      = $CI->session->userdata('site_lang');

    if (empty($sw)) {
        $lang_id = $lang_id;
    } else {
        $lang_id = $sw;
    }

    $lang_param = getSingledata('languages', $field_name, 'id', $lang_id);
    $param_data = json_decode($lang_param, true);

    if (!empty($param_data[$name][0])) {
        $output = $param_data[$name][0];
    } else {
        if (!empty($sys_data[$name])) {
            $output = $sys_data[$name];
        } else {
            $output = '';
        }
    }

    return $output;
}

/**
 ** Get Language fields
 * @param $param : lang param data
 * @param  $field : field name
 * @param  $label : field label name
 **/
function langField($param, $field, $label, $field_name = 'params')
{
    $output = '<div class="col-md-3">'.fieldBuilder('input', $field_name.'['.$field.'][]', pdchecker($param, $field), $label, '', 1).'</div>';

    return $output;
}
