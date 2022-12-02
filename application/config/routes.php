<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
| my-controller/my-method	-> my_controller/my_method
 */

$route['default_controller'] = "login";
$route['404_override']       = 'my404';

/*********** USER DEFINED ROUTES *******************/
/* api */
// login
$route['api/login'] = 'api/authentication/login';
$route['api/register'] = 'api/authentication/register';

// user
$route['api/user/result'] = 'api/result/showresult';
$route['api/user/account'] = 'api/user/account';

// course
// $route['api/course/inquiry/get'] = 'api/course_inquiry/index';
$route['api/course/inquiry/insert'] = 'api/course_inquiry/insert';


// exam
$route['api/exam/add'] = 'api/exam/add';
$route['api/exams/add/(:num)'] = "api/exam/add/$1";
$route['api/exam/get'] = 'api/exam/examList';

// all getter
$route['api/get/class'] = 'api/getter/class';
$route['api/get/department'] = 'api/getter/department';
$route['api/get/year'] = 'api/getter/year';
/* api */


/* Front-end */
$route['login']              = 'login';
$route['signup']             = 'signup';
$route['signup/add']         = 'signup/add';
$route['signup/savestudent'] = 'signup/saveStudent';
$route['signup/saveteacher'] = 'signup/saveTeacher';
$route['signup/saveparent']  = 'signup/saveParent';

$route['getlogin']                   = 'login/getlogin';
$route['user/dashboard']             = 'user';
$route['user/profile']               = 'user/profile';
$route['user/studentprofile']        = 'user/studentprofile';
$route['user/studentprofile/(:num)'] = 'user/studentprofile/$1';
$route['user/account']               = 'user/account';
$route['user/updateaccount']         = 'user/updateaccount';
$route['user/changepassword']        = 'user/changepassword';
$route['user/latestnotice']          = 'user/latestnotice';
$route['user/logs']                  = 'user/logs';
$route['user/logs/(:num)']           = 'user/logs/$1';

// Messages
$route['user/messages']                = 'messages/mlist';
$route['user/messages/(:num)']         = 'messages/mlist/$1';
$route['user/messages/details/(:num)'] = 'messages/details/$1';
$route['user/messages/compose']        = 'messages/compose';
$route['user/messages/send']           = 'messages/sendmessage';
$route['user/messages/reply']          = 'messages/reply';
$route['user/messages/studentbox']     = 'messages/studentbox';
$route['user/messages/parentbox']      = 'messages/parentbox';
$route['user/messages/teacherbox']     = 'messages/teacherbox';
$route['user/messages/findstudent']    = 'messages/findstudent';
$route['user/messages/findteacher']    = 'messages/findteacher';
$route['user/messages/findparent']     = 'messages/findparent';

// Attendances
$route['user/attendance']            = 'attendances/attendanceslist';
$route['user/attendance/(:num)']     = "attendances/attendanceslist/$1";
$route['user/attendance/add']        = "attendances/add";
$route['user/attendance/add/(:num)'] = "attendances/add/$1";
$route['user/attendance/userlist']   = 'attendances/userlist';
$route['user/attendance/save']       = 'attendances/saveStatus';
$route['user/attendance/report']     = 'attendances/report';

//student Subjects
$route['user/subjects'] = 'subjects/subjectslist';

//student exam card
$route['user/exam_card'] = 'examcard/examcard';

//student exam
$route['user/exam']             = 'exam/index';
$route['user/exam/submit_form'] = 'exam/submit_form';

// Marks
$route['user/marks']           = 'marks';
$route['user/marks/students']  = 'marks/students';
$route['user/marks/savemark']  = 'marks/savemark';
$route['user/marks/importcsv'] = 'marks/importcsv';

// Results
$route['user/results']     = 'results/resultlist';
$route['user/showresult']  = 'results/showresult';
$route['user/savecomment'] = 'results/savecomment';

// Payments
$route['user/payments']                = 'payments/paymentlist';
$route['user/payments/(:num)']         = 'payments/paymentlist/$1';
$route['user/payments/details/(:num)'] = 'payments/details/$1';
$route['user/payments/review/(:num)']  = 'payments/review/$1';
$route['user/payment/add']             = 'payments/add';
$route['user/payment/findstudent']     = 'payments/findstudent';
$route['user/payment/bill']            = 'payments/bill';
$route['user/payment/due']             = 'payments/due';
$route['user/payments/process/(:num)'] = 'payments/process/$1';
$route['user/payments/save']           = 'payments/save';
$route['user/payments/invoice/(:num)'] = 'payments/invoice/$1';

// Front-end notice
$route['user/notice']                = 'notice/nlist';
$route['user/notice/(:num)']         = 'notice/nlist/$1';
$route['user/notice/details/(:num)'] = 'notice/details/$1';

$route['verify'] = 'login/verify';

$route['user/changephoto'] = 'user/changephoto';
$route['logout']           = 'user/logout';

$route['forgotpassword']                         = "login/forgotpassword";
$route['resetPasswordUser']                      = "login/resetPasswordUser";
$route['resetPasswordConfirmUser']               = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)']        = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser']                     = "login/createPasswordUser";

/** Language switcher **/
$route['lang/(:any)']                = 'LanguageSwitcher/switchLang/$1';
$route[ADMIN_ALIAS.'/lang/(:any)'] = 'LanguageSwitcher/switchLang/$1';

/* Back-end */
$route[ADMIN_ALIAS]                  = 'adminlogsudev';
$route[ADMIN_ALIAS.'/getlogin']    = 'adminlogsudev/getlogin';
$route[ADMIN_ALIAS.'/dashboard']   = 'adminuser';
$route[ADMIN_ALIAS.'/onlineadmin'] = 'adminuser/onlineadmin';
$route[ADMIN_ALIAS.'/onlineuser']  = 'adminuser/onlineuser';
$route[ADMIN_ALIAS.'/logout']      = 'adminuser/logout';

// Field Routing
$route[ADMIN_ALIAS.'/fields']            = "fields/fieldslist";
$route[ADMIN_ALIAS.'/fields/(:num)']     = "fields/fieldslist/$1";
$route[ADMIN_ALIAS.'/fields/add']        = "fields/add";
$route[ADMIN_ALIAS.'/fields/add/(:num)'] = "fields/add/$1";
$route[ADMIN_ALIAS.'/fields/delete']     = "fields/delete";

// Admin user
$route[ADMIN_ALIAS.'/user']                = 'adminuser/userlist';
$route[ADMIN_ALIAS.'/user/(:num)']         = "adminuser/userlist/$1";
$route[ADMIN_ALIAS.'/user/add']            = "adminuser/add";
$route[ADMIN_ALIAS.'/user/add/(:num)']     = "adminuser/add/$1";
$route[ADMIN_ALIAS.'/user/profile/(:num)'] = "adminuser/profile/$1";
$route[ADMIN_ALIAS.'/user/delete']         = "adminuser/delete";
$route[ADMIN_ALIAS.'/user/trash']          = "adminuser/trash";
$route[ADMIN_ALIAS.'/user/active']         = "adminuser/active";
$route[ADMIN_ALIAS.'/user/changeavatar']   = "adminuser/changeavatar";
$route[ADMIN_ALIAS.'/user/changepassword'] = "adminuser/changepassword";

// Forgot Password
$route[ADMIN_ALIAS.'/forgotpassword']                         = "adminlogsudev/forgotpassword";
$route[ADMIN_ALIAS.'/resetPasswordUser']                      = "adminlogsudev/resetPasswordUser";
$route[ADMIN_ALIAS.'/resetPasswordConfirmUser']               = "adminlogsudev/resetPasswordConfirmUser";
$route[ADMIN_ALIAS.'/resetPasswordConfirmUser/(:any)']        = "adminlogsudev/resetPasswordConfirmUser/$1";
$route[ADMIN_ALIAS.'/resetPasswordConfirmUser/(:any)/(:any)'] = "adminlogsudev/resetPasswordConfirmUser/$1/$2";
$route[ADMIN_ALIAS.'/createPasswordUser']                     = "adminlogsudev/createPasswordUser";

// Academic
$route[ADMIN_ALIAS.'/academic'] = 'academic';

// Academic year
$route[ADMIN_ALIAS.'/academicyear']                = 'adminacademicyear/yearlist';
$route[ADMIN_ALIAS.'/academicyear/(:num)']         = "adminacademicyear/yearlist/$1";
$route[ADMIN_ALIAS.'/academicyear/addyear']        = "adminacademicyear/addyear";
$route[ADMIN_ALIAS.'/academicyear/addyear/(:num)'] = "adminacademicyear/addyear/$1";
$route[ADMIN_ALIAS.'/academicyear/delete']         = "adminacademicyear/delete";

// Department
$route[ADMIN_ALIAS.'/departments']           = 'admindepartment/dlist';
$route[ADMIN_ALIAS.'/departments/(:num)']    = "admindepartment/dlist/$1";
$route[ADMIN_ALIAS.'/department/add']        = "admindepartment/add";
$route[ADMIN_ALIAS.'/department/add/(:num)'] = "admindepartment/add/$1";
$route[ADMIN_ALIAS.'/department/delete']     = "admindepartment/delete";

// Subjects
$route[ADMIN_ALIAS.'/subjects']            = 'adminsubjects/subjectslist';
$route[ADMIN_ALIAS.'/subjects/(:num)']     = "adminsubjects/subjectslist/$1";
$route[ADMIN_ALIAS.'/subjects/add']        = "adminsubjects/add";
$route[ADMIN_ALIAS.'/subjects/add/(:num)'] = "adminsubjects/add/$1";
$route[ADMIN_ALIAS.'/subjects/delete']     = "adminsubjects/delete";

// Class
$route[ADMIN_ALIAS.'/class']            = 'adminclasses/classlist';
$route[ADMIN_ALIAS.'/class/(:num)']     = "adminclasses/classlist/$1";
$route[ADMIN_ALIAS.'/class/add']        = "adminclasses/add";
$route[ADMIN_ALIAS.'/class/add/(:num)'] = "adminclasses/add/$1";
$route[ADMIN_ALIAS.'/class/delete']     = "adminclasses/delete";

// Courses
$route[ADMIN_ALIAS.'/courses']              = 'admincourses/courselist';
$route[ADMIN_ALIAS.'/courses/(:num)']       = "admincourses/courselist/$1";
$route[ADMIN_ALIAS.'/courses/add']          = "admincourses/add";
$route[ADMIN_ALIAS.'/courses/add/(:num)']   = "admincourses/add/$1";
$route[ADMIN_ALIAS.'/courses/delete']       = "admincourses/delete";
$route[ADMIN_ALIAS.'/courses/loadsubjects'] = "admincourses/loadsubjects";

// Examination Cards
$route[ADMIN_ALIAS.'/examcards']            = 'adminexamcards/examcardlist';
$route[ADMIN_ALIAS.'/examcards/(:num)']     = "adminexamcards/examcardlist/$1";
$route[ADMIN_ALIAS.'/examcards/add']        = "adminexamcards/add";
$route[ADMIN_ALIAS.'/examcards/add/(:num)'] = "adminexamcards/add/$1";
$route[ADMIN_ALIAS.'/examcards/delete']     = "adminexamcards/delete";

// Exam
$route[ADMIN_ALIAS.'/exams']                  = 'adminexams/examlist';
$route[ADMIN_ALIAS.'/exams/(:num)']           = "adminexams/examlist/$1";
$route[ADMIN_ALIAS.'/exams/add']              = "adminexams/add";
$route[ADMIN_ALIAS.'/exams/add/(:num)']       = "adminexams/add/$1";
$route[ADMIN_ALIAS.'/exams/delete']           = "adminexams/delete";
$route[ADMIN_ALIAS.'/exams/form_entries/(:any)']     = 'adminexams/form_entries/$1';
$route[ADMIN_ALIAS.'/exams/export_form_data'] = 'adminexams/export_form_data';
$route[ADMIN_ALIAS.'/exams/loadclasses']        = "adminexams/loadclasses";
$route[ADMIN_ALIAS.'/exams/loadexams']        = "adminexams/loadexams";


// Mark
$route[ADMIN_ALIAS.'/mark']            = "adminmark/add";
$route[ADMIN_ALIAS.'/mark/savemark']   = "adminmark/savemark";
$route[ADMIN_ALIAS.'/mark/getstudent'] = "adminmark/student_list";
$route[ADMIN_ALIAS.'/mark/importcsv']  = "adminmark/importcsv";

// Attendances
$route[ADMIN_ALIAS.'/attendances']                       = 'attendances/attendanceslist';
$route[ADMIN_ALIAS.'/attendances/(:num)']                = "attendances/attendanceslist/$1";
$route[ADMIN_ALIAS.'/attendances/add']                   = "attendances/add";
$route[ADMIN_ALIAS.'/attendances/add/(:num)']            = "attendances/add/$1";
$route[ADMIN_ALIAS.'/attendances/delete']                = "attendances/delete";
$route[ADMIN_ALIAS.'/attendances/saveattendance']        = "attendances/saveAttendance";
$route[ADMIN_ALIAS.'/attendances/saveattendance/(:num)'] = "attendances/saveAttendance/$1";

// Students
$route[ADMIN_ALIAS.'/students']             = 'adminstudents/studentlist';
$route[ADMIN_ALIAS.'/students/(:num)']      = "adminstudents/studentlist/$1";
$route[ADMIN_ALIAS.'/students/add']         = "adminstudents/add";
$route[ADMIN_ALIAS.'/students/add/(:num)']  = "adminstudents/add/$1";
$route[ADMIN_ALIAS.'/students/delete']      = "adminstudents/delete";
$route[ADMIN_ALIAS.'/students/view']        = "adminstudents/view";
$route[ADMIN_ALIAS.'/students/view/(:num)'] = "adminstudents/view/$1";
$route[ADMIN_ALIAS.'/students/parent']      = "adminstudents/parentList";
$route[ADMIN_ALIAS.'/students/get_tokens']  = "adminstudents/get_tokens";

// Teacher
$route[ADMIN_ALIAS.'/teachers']             = 'adminteachers/teacherslist';
$route[ADMIN_ALIAS.'/teachers/(:num)']      = "adminteachers/teacherslist/$1";
$route[ADMIN_ALIAS.'/teachers/add']         = "adminteachers/add";
$route[ADMIN_ALIAS.'/teachers/add/(:num)']  = "adminteachers/add/$1";
$route[ADMIN_ALIAS.'/teachers/delete']      = "adminteachers/delete";
$route[ADMIN_ALIAS.'/teachers/view']        = "adminteachers/view";
$route[ADMIN_ALIAS.'/teachers/view/(:num)'] = "adminteachers/view/$1";

// Parent
$route[ADMIN_ALIAS.'/parents']             = 'adminparents/parentslist';
$route[ADMIN_ALIAS.'/parents/(:num)']      = "adminparents/parentslist/$1";
$route[ADMIN_ALIAS.'/parents/add']         = "adminparents/add";
$route[ADMIN_ALIAS.'/parents/add/(:num)']  = "adminparents/add/$1";
$route[ADMIN_ALIAS.'/parents/delete']      = "adminparents/delete";
$route[ADMIN_ALIAS.'/parents/view']        = "adminparents/view";
$route[ADMIN_ALIAS.'/parents/view/(:num)'] = "adminparents/view/$1";

// Notice
$route[ADMIN_ALIAS.'/notice']            = 'adminnotice/nlist';
$route[ADMIN_ALIAS.'/notice/(:num)']     = "adminnotice/nlist/$1";
$route[ADMIN_ALIAS.'/notice/add']        = "adminnotice/add";
$route[ADMIN_ALIAS.'/notice/add/(:num)'] = "adminnotice/add/$1";
$route[ADMIN_ALIAS.'/notice/delete']     = "adminnotice/delete";
$route[ADMIN_ALIAS.'/notice/trash']      = "adminnotice/trash";
$route[ADMIN_ALIAS.'/notice/active']     = "adminnotice/active";

// Payment
$route[ADMIN_ALIAS.'/payments']                = 'adminpayment/paymentlist';
$route[ADMIN_ALIAS.'/payments/(:num)']         = "adminpayment/paymentlist/$1";
$route[ADMIN_ALIAS.'/payments/details/(:num)'] = 'adminpayment/details/$1';
$route[ADMIN_ALIAS.'/payments/review/(:num)']  = 'adminpayment/review/$1';
$route[ADMIN_ALIAS.'/payments/invoice/(:num)'] = 'adminpayment/invoice/$1';

// Accounting
$route[ADMIN_ALIAS.'/accounting'] = 'accounting';
$route[ADMIN_ALIAS.'/incomes']    = 'accounting/incomes';

// Payment Method
$route[ADMIN_ALIAS.'/methods']                = 'adminmethod/methodlist';
$route[ADMIN_ALIAS.'/methods/details/(:num)'] = "adminmethod/details/$1";
$route[ADMIN_ALIAS.'/methods/save']           = "adminmethod/save";
//$route[ADMIN_ALIAS.'/payments/invoice'] = "adminpayment/invoice";

// Payment Fees
$route[ADMIN_ALIAS.'/fees']            = 'adminfees';
$route[ADMIN_ALIAS.'/fees/(:num)']     = "adminfees/index/$1";
$route[ADMIN_ALIAS.'/fees/add']        = "adminfees/add";
$route[ADMIN_ALIAS.'/fees/add/(:num)'] = "adminfees/add/$1";
$route[ADMIN_ALIAS.'/fees/delete']     = "adminfees/delete";
$route[ADMIN_ALIAS.'/fees/trash']      = "adminfees/trash";
$route[ADMIN_ALIAS.'/fees/active']     = "adminfees/active";

// Grade Category
$route[ADMIN_ALIAS.'/gcategory']            = 'admingcategory';
$route[ADMIN_ALIAS.'/gcategory/(:num)']     = "admingcategory/index/$1";
$route[ADMIN_ALIAS.'/gcategory/add']        = "admingcategory/add";
$route[ADMIN_ALIAS.'/gcategory/add/(:num)'] = "admingcategory/add/$1";
$route[ADMIN_ALIAS.'/gcategory/delete']     = "admingcategory/delete";
$route[ADMIN_ALIAS.'/gcategory/active']     = "admingcategory/active";

// Grade
$route[ADMIN_ALIAS.'/grade']            = 'admingrade';
$route[ADMIN_ALIAS.'/grade/(:num)']     = "admingrade/index/$1";
$route[ADMIN_ALIAS.'/grade/add']        = "admingrade/add";
$route[ADMIN_ALIAS.'/grade/add/(:num)'] = "admingrade/add/$1";
$route[ADMIN_ALIAS.'/grade/delete']     = "admingrade/delete";
$route[ADMIN_ALIAS.'/grade/trash']      = "admingrade/trash";
$route[ADMIN_ALIAS.'/grade/active']     = "admingrade/active";

// configuration Routing
$route[ADMIN_ALIAS.'/configuration']      = "configuration";
$route[ADMIN_ALIAS.'/configuration/edit'] = "configuration/edit";

// languages Routing
$route[ADMIN_ALIAS.'/languages']            = "languages/languagelist";
$route[ADMIN_ALIAS.'/languages/(:num)']     = "languages/languagelist/$1";
$route[ADMIN_ALIAS.'/languages/add']        = "languages/add";
$route[ADMIN_ALIAS.'/languages/add/(:num)'] = "languages/add/$1";
$route[ADMIN_ALIAS.'/languages/delete']     = "languages/delete";

// Update
$route[ADMIN_ALIAS.'/update']            = 'update';
$route[ADMIN_ALIAS.'/update/getInstall'] = 'update/getInstall';

// course inquiry
$route[ADMIN_ALIAS.'/course/inquiry']             = 'admincourseinquiry/courseInquirylist';
$route[ADMIN_ALIAS.'/course/inquiry/(:num)']      = "admincourseinquiry/courseInquirylist/$1";
$route[ADMIN_ALIAS.'/course/inquiry/delete']      = "admincourseinquiry/delete";
$route[ADMIN_ALIAS.'/course/inquiry/status']      = "admincourseinquiry/status";

// $route[ADMIN_ALIAS.'/students/(:num)']      = "admincourseinquiry/studentlist/$1";
// $route[ADMIN_ALIAS.'/students/add']         = "admincourseinquiry/add";
// $route[ADMIN_ALIAS.'/students/add/(:num)']  = "admincourseinquiry/add/$1";
// $route[ADMIN_ALIAS.'/students/delete']      = "admincourseinquiry/delete";
// $route[ADMIN_ALIAS.'/students/view']        = "admincourseinquiry/view";

// $route[ADMIN_ALIAS.'/students/parent']      = "admincourseinquiry/parentList";
// $route[ADMIN_ALIAS.'/students/get_tokens']  = "admincourseinquiry/get_tokens";