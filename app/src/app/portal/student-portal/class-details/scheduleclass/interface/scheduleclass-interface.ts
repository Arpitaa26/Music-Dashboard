export enum ScheduleStatusEnum {
  NOT_STARTED = 'NOT_STARTED',
  PENDING = 'PENDING',
  STARTED = 'STARTED',
  RESCHEDULED = 'RESCHEDULED',
  COMPLETED = 'COMPLETED',
}
export interface ScheduleClassInterface {
  students: String;
  id: String;
  batch_id: String;
  session_id: String;
  module_id: String;
  user_id: String;
  status: ScheduleStatusEnum;
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
  class_no: String;
  currency: string;
}

export interface AttendanceJoin {}
