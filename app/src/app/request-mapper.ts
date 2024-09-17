import { HttpHeaders } from '@angular/common/http';

export class RequestMapper {
  // Angular Routes

  public static readonly HOME: string = '';
  public static readonly LOGIN: string = 'login';
  public static readonly SIGNUP: string = 'signup';
  public static readonly LOGOUT: string = 'logout';
  public static readonly DASHBOARD: string = '';
  public static readonly DASHBOARD_: string = 'dashboard';
  public static readonly NOT_FOUND_URL: string = '404';
  public static readonly PORTAL: string = 'portal';
  public static readonly TEACHERS_PORTAL: string = 'teachers';
  public static readonly STUDENT_PORTAL: string = 'students';
  public static readonly BASE_RELATIVE_URL: string = '';
  public static readonly STUDENTS_DASHBOARD: string = 'dashboard';
  public static readonly TEACHERS_DASHBOARD: string = 'dashboard';
  public static readonly STUDENTS_CLASS_DETAILS: string = 'class_details';
  public static readonly TEACHERS_CLASS_DETAILS: string = 'class_details';
  public static readonly STUDENTS_ASSIGNMENTS: string = 'assignments';
  public static readonly TEACHERS_ASSIGNMENTS: string = 'assignments';
  public static readonly STUDENTS_PERFORMANCE_REPORT: string =
    'performance_report';

  public static readonly STUDENTS_HOMEWORK_TEACHERS_NOTE: string =
    'homework_and_teachers_note';
  public static readonly PROFILE: string = 'profile';
  public static readonly ST_PERFORMANCE_REPORT_BEGINNERS: string = 'beginners';
  public static readonly ST_PERFORMANCE_REPORT_INTERMEDIATE: string =
    'intermediate';
  public static readonly ST_PERFORMANCE_REPORT_ADVANCE: string = 'advance';
  public static readonly ST_PERFORMANCE_REPORT_EXPART: string = 'expart';
  public static readonly ST_PERFORMANCE_REPORT_COMMON: string = 'commmon';
  public static readonly PERFORMANCE_REPORT: string = 'performance_report';
  public static readonly COURSE_SHOW: string = 'course-show';
  public static readonly MODULE_LIST: string = 'module-list';
  public static readonly COURSE_INFO: string = 'course_info';
  public static readonly SUPPORT: string = 'support';
  public static readonly TEACHER_PROFILE: string = 'profile';
  public static readonly TEACHER_REFERRAL: string = 'referral';
  public static readonly TASK_CREATE: string = 'task-create';
  public static readonly TICKET_DETAILS: string = 'ticket-details';
  public static readonly ALL_COURSE: string = 'all_course';
  public static readonly RESCHDULE_APPROVE: string = 'reschdule_approve';
  public static readonly TEACHER_AVAILABILITY: string = 'teacher_availability';
  public static readonly ALL_COURSES: string = 'all_courses';
  public static readonly STUDENT_PROFILE: string = 'student-profile';
  static signup: any;
  public static readonly ABHYAS_AUDIO_ARCHIVE: string = 'abhyas_audio_archive';


  constructor() {}

  // API Urls

  public static readonly BASE_API_URL: string =
    'https://thesvpacademy.com/admin/api/';
  public static readonly API_USER_TYPE_GET_ALL: string =
    'user/user_type_get_all';
  public static readonly API_PRONOUN_TYPE: string = 'user/user_pronoun_get_all';
  public static readonly API_CLASS_RESCHEDULE: string =
    'class_reschedule_request/get_all';
  public static readonly API_CLASS_SCHEDULE_GET_ALL: string =
    'scheduled_class/get_all';
  public static readonly API_REGISTRATION: string = 'user/register';
  public static readonly API_COURSE: string = 'course/get_all';
  public static readonly COURSE_LEVEL: string = 'course_level/get_all';
  public static readonly API_MODULE_GET: string = 'module/get_all';
  public static readonly API_TUTORIAL_GET: string = 'tutorial/get_all';
  public static readonly API_TUTORIAL_GALLERY_GET: string =
    'tutorial/fetch_gallerys';
  public static readonly API_USER_LOGIN: string = 'user/login';
  public static readonly API_USER_TYPE: string = 'user/get';
  public static readonly API_COURSE_LEVEL: string = 'course_level/get_all';
  public static readonly API_CALENDAR: string = 'scheduled_class/get_all';
  public static readonly API_RESCHEDULE_REQUEST_SAVE: string =
    'class_reschedule_request/save';
  public static readonly API_RESCHEDULE_REQUEST_GET_ALL: string =
    'class_reschedule_request/get_all';
  public static readonly API_RESCHEDULE_REQUEST_GET: string =
    'class_reschedule_request/get/2';
  public static readonly API_USER_AVAILABILITY_GET_ALL: string =
    'user/availability/get_all';
  public static readonly API_TASK_SUPPORT: string = 'task/get_all';
  public static readonly API_CREATE_TASK: string = 'task/save';

  public static readonly API_AUDIO_ARCHIVE_GET_ALL: string =
    'file/get_all?category=AUDIO_ARCHIVE';
  public static readonly API_AUDIO_ARCHIVE_UPLOAD: string = 'file/upload';

  public static readonly API_TASK_COMMENT: string = 'task/get_all_comments';
  public static readonly API_POST_COMMENT: string = 'task/ticket_discation';

  public static readonly API_COURSE_ENROLLMENT: string =
    'course_enrollment/get_all';
  public static readonly API_ATTENDANCE_JOIN: string = 'user/attendance/save/';

  public static readonly API_TEACHER_COURSE_ENROLLMENT: string =
    'course_enrollment/get_all';

  public static readonly API_COMPLETE_CLASS: string =
    'user/attendance/start_end_class/';
  public static readonly API_FORGOT_PASSWORD: string = 'user/forgot_password';
  public static readonly API_UPDATE_PASSWORD: string = 'user/update_password';

  public static readonly API_QUIZ_GET_ALL: string = 'question/get_all';

  public static readonly API_RESCHEDULE_CLASS_APPROVED: string =
    'class_reschedule_request/approved_status/';

  public static readonly API_TEACHER_ADDITIONAL_DETAILS: string =
    'user/account_details/';

  public static readonly API_TEACHER_ASSIGNEMENT_NOTES_SUBMIT: string =
    'home_work/update_homework/';
  public static readonly API_TEACHER_AVAILABILITY: string =
    'user/availability/availability';

  public static readonly API_QUIZ_SAVE: string = 'question_answer/save/';
  public static readonly API_TEACHER_COOKIE_CUTNIP: string = 'user/get';

  public static readonly API_COURSE_HISTORY_GET_ALL: string =
    'course_history/get_all';

  public static readonly API_COA_CWA_GET_ALL: string =
    'course_performance/get_all';
  public static readonly API_FILE_DOWNLOAD: string = 'file/viewfile';

  public static readonly API_BULLETIN_EVENT: string = 'event/get_all';
  public static readonly API_GET_MONTH_CLASS_ALL: string =
    'course_history/get_month_class_all';
  public static readonly API_GET_DAY_CLASS_ALL: string =
    'course_history/get_day_class_all';

  public static readonly API_COURSE_START_COMPLETE: string =
    'course_history/complete_tutorial_batch';

  public static readonly API_COURSE_ALL: string = 'course/all_courses';

  public static readonly API_COURSE_ENROLL: string = 'course_enrollment/enroll';
  public static readonly API_REFERRAL_GET_ALL: string = 'referral/get_all';

  public static readonly API_CLASS_RENEWAL: string =
    'course_enrollment/class_renewal';
  public static readonly API_COUPON_APPLY_COUPON: string =
    'coupon/apply_coupon';

  public static readonly API_COURSE_BUY: string = 'course_enrollment/class_buy';

  public static readonly API_COURSE_ALL_NEW: string = 'course/all_courses';
  public static readonly API_COURSE_ENROLMENT_GET_ALL: string =
    'course_enrollment/get_all';

  public static readonly API_ARCHIVE_FEEDBACK: string = 'file/feedback_archive';

  public static readonly API_RESCHEDULE_MESSAGE: string =
    'class_reschedule_request/reschedule_info';
  public static readonly API_PAYMENT_STATUS: string =
    'course_enrollment/payment_status';

}
