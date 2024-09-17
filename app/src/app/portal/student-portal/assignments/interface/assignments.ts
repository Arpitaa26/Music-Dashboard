export interface Assignments {
  link:string,
  text:string,
  id:string
}




export interface ICourseType {
  
  id: string;
  user_id: string;
  course_id: string;
  course_level_id: string;
  batch_id: string;
  category: string;
  referral_code_used: string;
  modules_completed: string;
  attendance: string;
  classes_purchased: string;
  classes_used: string;
  status: string;
  created_by: string;
  updated_by: string;
  created_on: string;
  updated_on: string;
  user_fullname: string;
  course_name: string;
  batch_code: string;
  level: string;
}

export interface ICourseTypeResponse {
status: number;
data: ICourseType[];
message: string;
}


export interface IScheduleItemsResponse {
status: number;
data: IScheduleItems[];
message: string;
}

export interface IScheduleItems 
{
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
  students:any;
  class_no: string;
}
