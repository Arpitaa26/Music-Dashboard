export interface StudentList {
  attendance: string;
  batch_code: string;
  batch_id: string;
  category: string;
  classes_purchased: string;
  classes_used: string;
  course_id: string;
  course_level_id: string;
  course_name: string;
  created_by: string;
  created_on: string;
  id: string;
  level: string;
  modules_completed: string;
  referral_code_used: string;
  status: string;
  teacher_id: string;
  updated_by: string;
  updated_on: string;
  user_fullname: string;
  user_id: string;
}

export interface IScheduleResponse {
  status: number;
  data: ISchedule[];
  message: string;
}
export interface ISchedule {
students: string;
  id: String;
  batch_id: String;
  session_id: String;
  module_id: String;
  user_id: String;
  status: String;
  start_time: any;
  end_time: String;
  description: String;
  link: String;
  recorded_link: String;
  level: String;
  created_by: String;
  updated_by: String;
  created_on: String;
  updated_on: String;
  session_type: String;
  batch_code: String;
  module_name: String;
  full_name: String;
  home_work: String;
  teacher_note: String;
  rescheduled_date: any;
  rescheduled_by: String;
  class_no: String;
  rescheduled_by_name: string;
}
