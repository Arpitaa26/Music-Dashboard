<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
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
|		my-controller/my-method	-> my_controller/my_method
*/
global $route;
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['create'] = 'task/task/create';
$route['all_courses'] = 'course/course/all_courses';
$route['forgot_password'] = 'user/forgot_password';
/**
 * 
 * @param $group_ep group name (group endpoint)
 * @param $route_array route array in associative array
 * @return void
 * 
 * Example : 
 * group_route("api/user", [
 *   "get_all" => 'user/get_all',
 *    "get/(:num)" => 'user/get/$1'
 *  ]);
 * 
 */

function group_route($group_ep, $route_array)
{
    global $route;
    foreach ($route_array as $k => $v) {
        $p = !empty($k) ? "/{$k}" : "";
        $route["{$group_ep}{$p}"] = $v;
    }

    // echo "<pre>";
    // print_r($route);
    // exit;
}

// *************** API ROUTES ****************

// User
group_route("api/user", [
    "login" => 'User/api_login',
    "register" => 'User/api_register',
    "get" => 'User/get',
    "get/(:num)" => 'User/get/$1',
    "get_all" => 'User/get_all',
    "account_details/(:num)"=>'User/account_details/$1',
    "account_details"=>'User/account_details',
    "performance/(:num)"=>'User/performance/$1',
    "performance"=>'User/performance',
    "forgot_password"=>'User/forgot_password',
    "update_password"=>'User/update_password',
    // *********
    "user_type_get_all" => 'User/user_type_get_all',
    "user_pronoun_get_all" => 'User/user_pronoun_get_all',
]);

// Question
group_route("api/question", [
    "get_all" => 'question/question/get_all',
    "save" => 'question/question/save',
    "updateOrder" => 'question/question/updateOrder',

]);

//course_level
group_route("api/course_level", [
    "save" => 'course/course_level/save',
    "get/(:num)" => 'course/course_level/get/$1',
    "get_all" => 'course/course_level/get_all',
    "update/(:num)" => 'course/course_level/update/$1',
    "updateOrder" => 'course/course_level/updateOrder',
    "delete/(:num)" => 'course/course_level/delete/$1',
]);
// course_history
group_route("api/course_history", [
    ""=>'course_history/course_history/index',
    "get/(:num)" => 'course_history/course_history/get/$1',
    "get_all" => 'course_history/course_history/get_all',
    "save" => 'course_history/course_history/save',
    "module_complete/(:num)/(:any)" => 'course_history/course_history/module_complete/$1/$2',
    "complete_tutorial/(:num)" => 'course_history/course_history/complete_tutorial/$1',
]);
//User_attendance
group_route("api/user/attendance", [
    "save/(:num)" => 'user_attendance/user_attendance/save/$1',
    "get/(:num)" => 'user_attendance/user_attendance/get/$1',
    "get_all" => 'user_attendance/user_attendance/get_all',
    "left/(:num)" => 'user_attendance/user_attendance/left/$1',
    "feedback" => 'user_attendance/user_attendance/feedback',
    "start_end_class/(:num)" => 'user_attendance/user_attendance/start_end_class/$1',
    "barchart" => 'user_attendance/user_attendance/barchart',
    "get_attendance" => 'user_attendance/user_attendance/get_attendance',
    
]);

// Course_performance
group_route("api/course_performance", [
    ""=>'course_performance/course_performance/index',
    "get/(:num)" => 'course_performance/course_performance/get/$1',
    "get_all" => 'course_performance/course_performance/get_all',
    "save" => 'course_performance/course_performance/save',
    "save/(:num)" => 'course_performance/course_performance/save/$1',
]);
//User_availability
group_route("api/user/availability", [
    "save" => 'user_availability/user_availability/save',
    "save/(:num)" => 'user_availability/user_availability/save/$1',
    "get/(:num)" => 'user_availability/user_availability/get/$1',
    "get_all" => 'user_availability/user_availability/get_all',
    "update/(:num)" => 'user_availability/user_availability/save/$1',
    "delete/(:num)" => 'user_availability/user_availability/delete/$1',
    "delete_availability" => 'user_availability/user_availability/delete_availability',
    "availability" => 'user_availability/user_availability/availability',
]);
// calendar
group_route("api/calendar", [
    "get_availability" => 'calendar/calendar/get_availability',
    "get_events" => 'calendar/calendar/get_events/',
    "get_class" => 'calendar/calendar/get_class',
    "edit_event" => 'calendar/calendar/edit_event',
    "add_event" => 'calendar/calendar/add_event',
    
]);
// payment
group_route("api/payment", [
    ""=>'payment/payment/index',
    "purchase" => 'payment/payment/purchase/',
    "get/(:num)" => 'payment/payment/get/$1',
    "get_all" => 'payment/payment/get_all',
    "save" => 'payment/payment/save',
    "save/(:num)" => 'payment/payment/save/$1',
]);
//Task
group_route("api/task", [
    "save" => 'task/task/save',
    "save/(:num)" => 'task/task/save/$1',
    "get/(:num)" => 'task/task/get/$1',
    "get_all" => 'task/task/get_all',
    "delete/(:num)" => 'task/task/delete/$1',
    "status" => 'task/task/status',
]);
//Task
group_route("api/task", [
    "task_comments" => 'task/task/task_comments',
    "get_all_comments" => 'task/task/get_all_comments',
    "get_all_comments/(:num)" => 'task/task/get_all_comments/$1',
]);
//Task Template
group_route("api/task_template", [
    "get_all" => 'task_template/task_template/get_all',
]);
//class_reschedule_request
group_route("api/class_reschedule_request", [
   
    "save" => 'class_reschedule_request/class_reschedule_request/save',
    "save/(:num)" => 'class_reschedule_request/class_reschedule_request/save/$1',
    "get/(:num)" => 'class_reschedule_request/class_reschedule_request/get/$1',
    "get_all" => 'class_reschedule_request/class_reschedule_request/get_all',
    "approved_status/(:num)" => 'class_reschedule_request/class_reschedule_request/approved_status/$1',
    "update/(:num)" => 'class_reschedule_request/class_reschedule_request/update/$1',
    "delete/(:num)" => 'class_reschedule_request/class_reschedule_request/delete/$1',
]);

// Module
group_route("api/module", [
    "get_all" => 'module/module/get_all',
    "get_all/(:any)" => 'module/module/get_all/$1',
    "get/(:num)" => 'module/module/get/$1',
    "updateOrder" => 'module/module/updateOrder',
]);

// Course
group_route("api/course", [
    "get_all" => 'course/course/get_all',
    "get_course_price" => 'course/course/get_course_price',
    "get/(:num)" => 'course/course/get/$1',
    "all_course" => 'course/course/all_course',
]);

// Question option
group_route("api/question_option", [
    "updateOption" => 'question_option/question_option/updateOption', //order
    "get_all" => 'question_option/question_option/get_all',
    "delete/(:num)" => 'question_option/question_option/delete/$1',

]);
// Question answer
group_route("api/question_answer", [
    "" => 'question_answer/question_answer/index',
    "get_all" => 'question_answer/question_answer/get_all',
    "save" => 'question_answer/question_answer/save',
    "save/(:num)" => 'question_answer/question_answer/save/$1',
    "delete/(:num)" => 'question_answer/question_answer/delete/$1',
]);
// Batch
group_route("api/batch", [
    "get_all" => 'batch/batch/get_all',
    "get/(:num)" => 'batch/batch/get/$1',
    "updateOrder" => 'batch/batch/updateOrder',
]);
// File

group_route("api/file", [
    "get_all" => 'file/file/get_all',
    "get/(:num)" => 'file/file/get/$1',
    "get_slug/(:any)" => 'file/file/get_slug/$1',
    "download/(:any)" => 'file/file/download/$1',
    "viewfile/(:any)" => 'file/file/viewfile/$1'
]);
// tutorial

group_route("api/tutorial", [
    "get_all" => 'tutorial/tutorial/get_all',
    "get_all/(:any)" => 'tutorial/tutorial/get_all/$1',
    "get/(:num)" => 'tutorial/tutorial/get/$1',
    "fetch_gallerys" => 'tutorial/tutorial/fetch_gallerys',
    "updateOrder" => 'tutorial/tutorial/updateOrder',
    "tutorialOrder" => 'tutorial/tutorial/tutorialOrder',
    "delete_file" => 'tutorial/tutorial/delete_file',
]);
// price
group_route("api/price", [
    "get/(:num)" => 'price/price/get/$1',
    "get_all" => 'price/price/get_all',
    "save" => 'price/price/save',
    "save/(:num)" => 'price/price/save/$1',
]);
// country_pricing
group_route("api/country", [
    "get/(:num)" => 'country/country/get/$1',
    "get_all" => 'country/country/get_all',
    "get_country" => 'country/country/get_country',
    "get_country_price" => 'country/country/get_country_price',
    "save" => 'country/country/save',
    "save/(:num)" => 'country/country/save/$1',
]);
// scheduled_class
group_route("api/scheduled_class", [
    "get_all" => 'scheduled_class/scheduled_class/get_all',
    "get/(:num)" => 'scheduled_class/scheduled_class/get/$1',
    "save" => 'scheduled_class/scheduled_class/save',
    "save/(:num)" => 'scheduled_class/scheduled_class/save/$1',
]);

// home_work
group_route("api/home_work", [
    "get_all" => 'home_work/home_work/get_all',
    "get/(:num)" => 'home_work/home_work/get/$1',
    "save/(:num)" => 'home_work/home_work/save/$1',
    "update_homework/(:num)" => 'home_work/home_work/update_homework/$1',
]);
// batch_teacher
group_route("api/batch_teacher", [
    "get_all" => 'batch_teacher/batch_teacher/get_all',
]);

// course_enrollment
group_route("api/course_enrollment", [
    "get_all" => 'course_enrollment/course_enrollment/get_all',
    "get_batch_students" => 'course_enrollment/course_enrollment/get_batch_students',
    

]);

// course_teacher
group_route("api/course_teacher", [
    "get/(:num)" => 'course_teacher/course_teacher/get_all/$1',
    "get_all" => 'course_teacher/course_teacher/get_all',

]);

group_route("api/file", [
    "upload" => 'file/file/single_save',
]);

// *************** WEB ROUTES ****************

group_route("login", [
    "" => 'user/session_login',
]);
group_route("logout", [
    "" => 'user/session_logout',
]);

group_route("course", [
    "" => 'course/course/index',
    "save" => 'course/course/save',
    "save/(:num)" => 'course/course/save/$1',
    "delete/(:num)" => 'course/course/delete/$1',
    "all_course" => 'course/course/all_course',
]);

group_route("module", [
    "" => 'module/module/index',
    "save" => 'module/module/save',
    "save/(:num)" => 'module/module/save/$1',
    "delete/(:num)" => 'module/module/delete/$1',
]);

group_route("question", [
    "" => 'question/question/index',
    "save" => 'question/question/save',
    "save/(:num)" => 'question/question/save/$1',
    "delete/(:num)" => 'question/question/delete/$1',
]);
group_route("question_answer", [
    "" => 'question_answer/question_answer/index',
    "save" => 'question_answer/question_answer/save',
    "save/(:num)" => 'question_answer/question_answer/save/$1',
    "delete/(:num)" => 'question_answer/question_answer/delete/$1',
]);
group_route("question_option", [
    "" => 'question_option/question_option/index',
    "save" => 'question_option/question_option/save',
    "save/(:num)" => 'question_option/question_option/save/$1',
    "delete/(:num)" => 'question_option/question_option/delete/$1',
]);

group_route("batch", [
    "" => 'batch/batch/index',
    "get_all" => 'batch/batch/get_all',
    "get/(:num)" => 'batch/batch/get/$1',
    "save" => 'batch/batch/save',
    "save/(:num)" => 'batch/batch/save/$1',
    "delete/(:num)" => 'batch/batch/delete/$1',
]);

//files
group_route("file", [
    "open/(:any)" => 'file/file/open/$1',
    "" => 'file/file/index',
    "get_all" => 'file/file/get_all',
    "file_save" => 'file/file/file_save',
    "file_save/(:num)" => 'file/file/file_save/$1',
    "delete/(:num)" => 'file/file/delete/$1',
    "download/(:any)" => 'file/file/download/$1',
    "viewfile/(:any)" => 'file/file/viewfile/$1'
]);
//tutorial
group_route("tutorial", [
    "open/(:any)" => 'tutorial/tutorial/open/$1',
    "" => 'tutorial/tutorial/index',
    "save" => 'tutorial/tutorial/save',
    "save/(:num)" => 'tutorial/tutorial/save/$1',
    "delete/(:num)" => 'tutorial/tutorial/delete/$1',
    "fetch_gallerys/(:num)" => 'tutorial/tutorial/fetch_gallerys/$1',
    "orderUpdate" => 'tutorial/tutorial/orderUpdate'
]);

group_route("scheduled_class", [
    "" => 'scheduled_class/scheduled_class/index',
    "save" => 'scheduled_class/scheduled_class/save',
    "save/(:num)" => 'scheduled_class/scheduled_class/save/$1',
    "delete/(:num)" => 'scheduled_class/scheduled_class/delete/$1',
]);

group_route("batch_teacher", [
    "" => 'batch_teacher/batch_teacher/index',
    "save" => 'batch_teacher/batch_teacher/save',
    "save/(:num)" => 'batch_teacher/batch_teacher/save/$1',
    "delete/(:num)" => 'batch_teacher/batch_teacher/delete/$1',
]);

group_route("course_enrollment", [
    "" => 'course_enrollment/course_enrollment/index',
    "save" => 'course_enrollment/course_enrollment/save',
    "save/(:num)" => 'course_enrollment/course_enrollment/save/$1',
    "delete/(:num)" => 'course_enrollment/course_enrollment/delete/$1',
]);

group_route("user", [
    "" => 'user/index',
    "save" => 'user/web_register',
    "save/(:num)" => 'user/web_register/$1',
    "delete/(:num)" => 'user/delete/$1',
    "account_details/(:num)"=>'user/account_details/$1',
    "account_details"=>'user/account_details',
    "performance/(:num)"=>'user/performance/$1',
    "performance"=>'user/performance',
    "forgot_password"=>'user/forgot_password',
    "update_password"=>'user/update_password',
    
]);

group_route("course_teacher", [
    "" => 'course_teacher/course_teacher/index',
    "save" => 'course_teacher/course_teacher/save',
    "save/(:num)" => 'course_teacher/course_teacher/save/$1',
    "delete/(:num)" => 'course_teacher/course_teacher/delete/$1',
]);

group_route("class_reschedule_request", [
    "" => 'class_reschedule_request/class_reschedule_request/index',
    "approved_status/(:num)" => 'class_reschedule_request/class_reschedule_request/approved_status/$1',
    "delete/(:num)" => 'class_reschedule_request/class_reschedule_request/delete/$1',
]);
//User_availability

group_route("user_availability", [
    "" => 'user_availability/user_availability/index',
    "save" => 'user_availability/user_availability/save',
    "save/(:num)" => 'user_availability/user_availability/save/$1',
    "edit/(:num)" => 'user_availability/user_availability/edit/$1',
    "availability/(:num)" => 'user_availability/user_availability/create/$1',
    "get/(:num)" => 'user_availability/user_availability/get/$1',
    "get_all" => 'user_availability/user_availability/get_all',
    "update/(:num)" => 'user_availability/user_availability/save/$1',
    "delete/(:num)" => 'user_availability/user_availability/delete/$1',
    "delete_availability/(:num)" => 'user_availability/user_availability/delete_availability/$1',
]);
//course_level
group_route("course_level", [
    "" => 'course/course_level/index',
    "save" => 'course/course_level/save',
    "get/(:num)" => 'course/course_level/get/$1',
    "get_all" => 'course/course_level/get_all',
    "save/(:num)" => 'course/course_level/save/$1',
    "update/(:num)" => 'course/course_level/update/$1',
    "delete/(:num)" => 'course/course_level/delete/$1',
]);
//Task
group_route("task", [
    "" => 'task/task/index',
    "save" => 'task/task/save',
    "save/(:num)" => 'task/task/save/$1',
    "get/(:num)" => 'task/task/get/$1',
    "get_all" => 'task/task/get_all',
    "delete/(:num)" => 'task/task/delete/$1',
    "status" => 'task/task/status',
]);
//Task comments
group_route("task", [
    "task_comments" => 'task/task/task_comments',
    "get_all_comments" => 'task/task/get_all_comments',
]);
//Task Template
group_route("task_template", [
    "" => 'task_template/task_template/index',
    "save" => 'task_template/task_template/save',
    "save/(:num)" => 'task_template/task_template/save/$1',
    "get/(:num)" => 'task_template/task_template/get/$1',
    "get_all" => 'task_template/task_template/get_all',
    "delete/(:num)" => 'task_template/task_template/delete/$1',
]);
// price
group_route("price", [
    ""=>'price/price/index',
    "get/(:num)" => 'price/price/get/$1',
    "get_all" => 'price/price/get_all',
    "save" => 'price/price/save',
    "save/(:num)" => 'price/price/save/$1',
]);
//User_attendance
group_route("user_attendance", [
    "" => 'user_attendance/user_attendance/index',
    "save/(:num)" => 'user_attendance/user_attendance/save/$1',
    "create/(:num)" => 'user_attendance/user_attendance/create/$1',
    "get/(:num)" => 'user_attendance/user_attendance/get/$1',
    "get_all" => 'user_attendance/user_attendance/get_all',
    "left/(:num)" => 'user_attendance/user_attendance/left/$1',
    "feedback" => 'user_attendance/user_attendance/feedback',
    "start_end_class/(:num)" => 'user_attendance/user_attendance/start_end_class/$1',
    "barchart" => 'user_attendance/user_attendance/barchart',
    "get_attendance" => 'user_attendance/user_attendance/get_attendance',
    
]);
// home_work
group_route("home_work", [
    "get_all" => 'home_work/home_work/get_all',
    "get/(:num)" => 'home_work/home_work/get/$1',
    "save/(:num)" => 'home_work/home_work/save/$1',
    "update_homework/(:num)" => 'home_work/home_work/update_homework/$1',
]);
// Question answer
group_route("question_answer", [
    "" => 'question_answer/question_answer/index',
    "save" => 'question_answer/question_answer/save',
    "save/(:num)" => 'question_answer/question_answer/save/$1',
    "delete/(:num)" => 'question_answer/question_answer/delete/$1',
]);
// email and task settings
group_route("general_settings", [
    ""=>'general_settings/general_settings/index',
    "save" => 'general_settings/general_settings/save',
    "save/(:num)" => 'general_settings/general_settings/save/$1',
    "add"=>'general_settings/general_settings/add',
    "email_templates" => 'general_settings/general_settings/email_templates',
    "email_preview" => 'general_settings/general_settings/email_preview',
    "get_email_template_content_by_id" => 'general_settings/general_settings/get_email_template_content_by_id',
    "task_templates" => 'general_settings/general_settings/task_templates',
    "task_preview" => 'general_settings/general_settings/task_preview',
    "get_task_template_content_by_id" => 'general_settings/general_settings/get_task_template_content_by_id',
    "task_save" => 'general_settings/general_settings/task_save',
    "task_save/(:num)" => 'general_settings/general_settings/task_save/$1',
]);
// course_history
group_route("course_history", [
    ""=>'course_history/course_history/index',
    "get/(:num)" => 'course_history/course_history/get/$1',
    "get_all" => 'course_history/course_history/get_all',
    "module_complete/(:num)/(:any)" => 'course_history/course_history/module_complete/$1/$2',
    "complete_tutorial/(:num)" => 'course_history/course_history/complete_tutorial/$1',
    
    

]);
// country_pricing
group_route("country", [
    ""=>'country/country/index',
    "get/(:num)" => 'country/country/get/$1',
    "get_country" => 'country/country/get_country',
    "get_all" => 'country/country/get_all',
    "get_country_price" => 'country/country/get_country_price',
    "save" => 'country/country/save',
    "save/(:num)" => 'country/country/save/$1',
]);
// calendar
group_route("calendar", [
    
    "get_events" => 'calendar/calendar/get_events/',
    "get_class" => 'calendar/calendar/get_class',
    "get_availability" => 'calendar/calendar/get_availability',
    "edit_event" => 'calendar/calendar/edit_event',
    "add_event" => 'calendar/calendar/add_event',
    
]);
// Course_performance
group_route("course_performance", [
    ""=>'course_performance/course_performance/index',
    "get/(:num)" => 'course_performance/course_performance/get/$1',
    "get_all" => 'course_performance/course_performance/get_all',
    "save" => 'course_performance/course_performance/save',
    "save/(:num)" => 'course_performance/course_performance/save/$1',
]);